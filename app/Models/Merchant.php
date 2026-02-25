<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Merchant extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'email',
        'avatar',
        'password',
        'status',
        'invoice_frequency'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the Billing Detail associated with the Merchant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function billingDetail(): HasOne
    {
        return $this->hasOne(MerchantBillingDetail::class, 'merchant_id', 'id');
    }

    /**
     * Get the Store Detail associated with the Merchant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function storeDetail(): HasOne
    {
        return $this->hasOne(MerchantStoreDetail::class, 'merchant_id', 'id');
    }

    /**
     * Get the xeroCredentials associated with the Merchant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function xeroCredentials(): HasOne
    {
        return $this->hasOne(MerchantXeroCredential::class, 'merchant_id', 'id');
    }
}
