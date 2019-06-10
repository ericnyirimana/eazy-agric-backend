<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageAgent extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'va';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
