<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class OffTaker extends Model
{
    use Authenticatable, Authorizable;
    /**
     * The document type
     * @var string
     */
    protected $table = 'offtaker';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'organization',
        'phonenumber',
        'password',
        'ot_username',
        'ot_name',
        'account_type',
        'contact_person',
        'district',
        'ot_address',
        'value_chain',
        'type' => 'offtaker',
        '_id',
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
        'type' => 'offtaker',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }
}
