<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MerchantXeroCredential extends Model
{
    protected $fillable = [
        'merchant_id',
        'contact_id',
        'contact_number',
    ];

    /**
     * Get the merchant that owns the MerchantXeroCredential
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }
}
