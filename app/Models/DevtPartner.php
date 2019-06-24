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
        'firstname',
        'lastname',
        'organization',
        'phonenumber',
        'district',
        'email',
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
}
