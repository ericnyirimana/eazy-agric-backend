<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class MasterAgent extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'ma';
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
        'ma_address',
        'ma_phonenumber',
        'ma_name',
        'ma_account_type',
        '_id',
        'ma_id',
        'ma_manager_name',
        'type' => 'ma',
        'ma_email',
        'ma_value_chain',
        'manager_location',
        'manager_email',
        'ma_district',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'ma_password', 'id', 'password',
    ];
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'ma',
        'status' => 'inactive',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
