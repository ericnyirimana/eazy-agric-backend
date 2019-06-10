<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'username', 'ma_password',

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
