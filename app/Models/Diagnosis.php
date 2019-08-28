<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    /**
     * The document type
     * @var string
     */
    protected $table = 'diagnosis';

    protected $fillable = [];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
