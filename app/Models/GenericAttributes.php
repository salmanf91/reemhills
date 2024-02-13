<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenericAttributes extends Model
{
    use HasFactory;

    protected $table = 'generic_attributes';

    protected $fillable = [
        'generic_key',
        'generic_value',
    ];

    public $timestamps = true;
}
