<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurCrop extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'our_crops';

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
