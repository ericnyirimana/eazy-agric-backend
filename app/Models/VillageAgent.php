<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageAgent extends Model {
    
    protected $table = 'va';

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

    /**
     * Get the farmers under a village agent
     */
    public function farmers()
    {
        return $this->hasMany('App\Models\Farmer', 'vaId');
    }

    /**
     * Get the orders under a village agent
     */
    public function orders()
    {
        return $this->hasMany('App\Models\InputOrder', 'vaId');
    }

    /**
     * Get the mapping orders under a village agent
     */
    public function mappingOrders()
    {
        return $this->hasMany('App\Models\MapCoordinate', 'vaId');
    }

    /**
     * Get the planting orders under a village agent
     */
    public function plantingOrders()
    {
        return $this->hasMany('App\Models\Planting', 'vaId');
    }

    /**
     * Get soil test orders under a village agent
     */
    public function soilTestOrders()
    {
        return $this->hasMany('App\Models\SoilTest', 'vaId');
    }

    /**
     * Get spraying orders under a village agent
     */
    public function sprayingOrders()
    {
        return $this->hasMany('App\Models\Spraying', 'vaId');
    }

}
