<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'buyer_id',
        'payment_status',
        'payment_json_response',
    ];

    const PAYMENT_STATUS_SUCCESS = "0";
    const PAYMENT_STATUS_ERROR = "5000";
}
