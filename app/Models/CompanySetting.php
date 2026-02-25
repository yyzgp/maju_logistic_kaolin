<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CompanySetting extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'company',
        'email',
        'dialcode',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'zipcode',
        'state',
        'iso2',
        'logo',
        'website',
        'uen_no',
        'gst_no',
        'bank_name',
        'bank_account_no',
        'cheque_payable_to',
        'invoice_frequency'
    ];

}
