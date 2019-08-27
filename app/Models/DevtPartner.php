<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class DevtPartner extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'partner';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_name',
        'username',
        'phone_number',
        'address',
        'value_chain',
        'email',
        'district',
        'contact_person',
        'address',
        'partner_id',
        'dp_email',
        'account_type',
        'dp_phonenumber',
        'dp_location',
        'value_chain',
        'dp_address',
        'dp_name',
        'dp_password',
        'dp_username',
        'dp_manager_name',
        '_id',
        'dp_id',
        'type',
        'status',
        'contact_person',
        'value_chain',
        'account_type',
        'status',
        'category',

    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'id',
    ];
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'partner',
        'category' => 'development-partner',
        'status' => 'demo',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
    public function setUsernameAttribute($username)
    {
        $this->attributes['username'] = strtolower($username);
    }
}
