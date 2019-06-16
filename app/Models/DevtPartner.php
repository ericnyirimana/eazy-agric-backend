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
        'email',
        'status',
        'category',
        'password',
        'dp_district',
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
        'status' => 'closed',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
