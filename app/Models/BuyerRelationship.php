<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerRelationship extends Model
{
    use HasFactory;

    protected $table = 'buyer_relationship';

    protected $fillable = [
        'primary_buyer_id',
        'secondary_buyer_id',
    ];

    public $timestamps = true;

    protected $casts = [
        'primary_buyer_id' => 'int',
        'secondary_buyer_id' => 'int',
    ];

    public function primaryBuyer()
    {
        return $this->belongsTo(Buyer::class, 'primary_buyer_id', 'buyer_id');
    }

    public function secondaryBuyer()
    {
        return $this->belongsTo(Buyer::class, 'secondary_buyer_id', 'buyer_id');
    }
}
