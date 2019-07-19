<?php
namespace App\Utils;

use Laravel\Lumen\Routing\Controller as BaseController;
use \Mailjet\Resources;

class Email extends BaseController
{
    /**
     * setup email client.
     */
    private function initMail()
    {
        $mailjetApiKey = getenv('MJ_APIKEY_PUBLIC');
        $mailjetSecret = getenv('MJ_API_SECRET_KEY');
        $this->admin_email = getenv('MJ_API_EMAIL');

        return new \Mailjet\Client($mailjetApiKey, $mailjetSecret, true, ['version' => 'v3.1']);
    }

    /**
     * generate a formatted message body for mailjet
     * all params are required
     */
    private function formatMessage($to, $subject, $body)
    {
        $to_email = explode(',', $to);
        foreach ($to_email as $email) {
            $emails[] = ['Email' => $email, 'Name' => $email];
        }
        return $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => $this->admin_email,
                        'Name' => "ezyagric",
                    ],
                    'To' => $emails,
                    'Subject' => "Ezyagric: $subject",
                    'TextPart' => $body['text'],
                    'HTMLPart' => $body['html'],
                ],
            ],
        ];
    }

    /**
     * generates an HTML template for messages
     * all params are required
     */
    private function templates($btn_text, $btn_url, $header, $content)
    {
        if ($content === strip_tags($content)) {
            $content = '<h4 style="margin: 0 auto; margin-bottom: 50px;">' . $content . '</h4>';
        }
        return $htmlTemplate = '<div style="font-family:arial; margin: 20px;">
        <div style="display: inline-block; text-align: center; margin: 0 auto; width: 600px; margin: 0 auto; display: block;">
          <img src="' . env("EMAIL_BANNER", "http://www.mtic.go.ug/nids/slide/fruits.png") . '" style="width: 100%;">

          <div style="width: 560px; margin: 0 auto; padding: 30px;">
            <h1 style="text-transform: uppercase;">' . $header . '</h1>
            ' . $content . '
            <a href="' . $btn_url . '" style=" padding: 18px 25px; background-color: #27A9E0; border-radius: 40px; text-decoration: none; color: white; text-transform: uppercase;">' . $btn_text . '</a> </div> </div> </div>';
    }

    private function getTemplate($template, $url = '', $password = '')
    {
        $body = [
            'RESET_PASSWORD' => [
                'subject' => 'Reset your Password',
                'body' => $this->templates(
                    'reset password',
                    $url,
                    'Reset your password !',
                    'You told us you forgot your password. If you really did, click on the button below to choose a new one, If you didn’t mean to reset your password, then you can just ignore this email; your password will not change.'
                ),
            ],
            'LOGIN' => [
                'subject' => 'User account login',
                'body' => $this->templates(
                    'Account Login',
                    $url,
                    'You can now login !!!',
                    'Thank you for creating an account with us <br> You can now login with this password' . ' ' . $password . ' ' . '<br/>'
                ),
            ]];
        return $body[$template];
    }

    /**
     * send actual email to recipients
     * @param $to {string} seperate multiple emails with commar
     * @param $subject {string} subject of the email
     * @param body {string/html} contains the actual message to be displayed to the user.
     * @param $type {string} [optional] when omitted, will treat $body as string and not HTML
     */
    public function sendMail($to, $subject, $body, $type = 'TEXT')
    {
        $mail = $this->initMail();
        $body = $this->formatMessage($to, $subject, [
            'text' => $type == 'TEXT' ? $body : '',
            'html' => $body,
        ]);
        $response = $mail->post(Resources::$Email, ['body' => $body]);

        return $response->success() && ['status' => 'success'];
    }

    /**
     * Sends a predefined email containing information about password reset
     * @param $to [string] email to send reset link to
     * @param  $path [string] url to redirect user to
     */
    public function mailWithTemplate($template = 'RESET_PASSWORD', $to, $path, $password = '')
    {
        $template = $this->getTemplate($template, $path, $password);

        return $this->sendMail(
            $to,
            $template['subject'],
            $template['body'],
            'text'
        );
    }
}
