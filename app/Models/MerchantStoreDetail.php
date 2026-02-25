<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantStoreDetail extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'email',
        'dialcode',
        'phone',
        'address',
        'building_floor_room',
        'latitude',
        'longitude',
        'notes',
        'iso2'
    ];

    /**
     * Get the merchant that owns the MerchantBillingDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
}
