<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantBillingDetail extends Model
{
    protected $fillable = [
        'merchant_id',
        'name',
        'email',
        'dialcode',
        'phone',
        'address',
        'latitude',
        'longitude',
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
