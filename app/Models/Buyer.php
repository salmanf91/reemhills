<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'buyer';
    protected $primaryKey = 'buyer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'buyer_type',
        'buyers_name',
        'mobile_no',
        'email_id',
        'address',
        'project',
        'phase',
        'unit_no',
        'passport_path',
        'emirates_id_path',
        'mou_doc_path',
        'company_name',
        'tl_no',
        'trade_license_path',
        'building',
        'type',
        'order_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_primary_buyer' => 'boolean',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the secondary buyers associated with this buyer.
     */
    public function secondaryBuyers()
    {
        return $this->hasMany(Buyer::class, 'buyer_id', 'buyer_id');
    }

    /**
     * Get the primary buyer associated with this buyer (if it's a secondary buyer).
     */
    public function primaryBuyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id', 'buyer_id');
    }
}
