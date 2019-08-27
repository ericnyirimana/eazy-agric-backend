<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Government extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'government';
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
        'account_type',
        'email',
        'district',
        'contact_person',
        '_id',
        'type' => 'government',
        'password',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'password',
    ];
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'government',
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
