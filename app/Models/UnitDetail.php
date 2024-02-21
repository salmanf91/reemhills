<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitDetail extends Model
{

    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'unit_details';

    protected $columns = [
        'id','unit_name','project_id','phase_id','type_id','building_id'
    ];

    public function getTextAttribute()
    {
        return implode(' | ', [
            $this->attributes('unit_name'),
            $this->attributes('project_id'),
            $this->attributes('phase_id'),
            $this->attributes('type_id'),
            $this->attributes('building_id'),
        ]);
    }

    public function getConcatenatedAttributesAttribute()
    {
        return implode(' | ', [
            $this->getAttribute('unit_name'),
            $this->getAttribute('project_id'),
            $this->getAttribute('phase_id'),
            $this->getAttribute('type_id'),
            $this->getAttribute('building_id'),
        ]);
    }
}