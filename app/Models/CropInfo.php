<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropInfo extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'cropinf';

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships
}
