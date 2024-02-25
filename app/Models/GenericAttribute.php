<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenericAttribute extends Model
{
    use HasFactory;

    protected $table = 'generic_attribute';

    protected $fillable = [
        'generic_key',
        'generic_value',
    ];

    public $timestamps = true;
}
