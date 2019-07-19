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
        'address',
        'value_chain',
        'account_type',
        'email',
        'district',
        'contact_person',
        'ma_password',
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
        'password',
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
        'status' => 'demo',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Get the farmers under a master agent
     */
    public function farmers()
    {

        return $this->hasMany('App\Models\Farmer', 'ma_id');
    }

    /**
     * Get the orders under a master agent
     */
    public function orders()
    {
        return $this->hasMany('App\Models\InputOrder', 'ma_id');
    }

    /**
     * Get the mapping orders under a master agent
     */
    public function mappingOrders()
    {
        return $this->hasMany('App\Models\MapCoordinate', 'ma_id');
    }

    /**
     * Get the planting orders under a master agent
     */
    public function plantingOrders()
    {
        return $this->hasMany('App\Models\Planting', 'ma_id');
    }

    /**
     * Get soil test orders under a master agent
     */
    public function soilTestOrders()
    {
        return $this->hasMany('App\Models\SoilTest', 'ma_id');
    }

    /**
     * Get spraying orders under a master agent
     */
    public function sprayingOrders()
    {
        return $this->hasMany('App\Models\Spraying', 'ma_id');
    }
}
