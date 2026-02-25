<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    protected $fillable = [
        'parent_task_id',
        'merchant_id',
        'driver_id',
        'service_id',
        'type',
        'name',
        'email',
        'iso2',
        'dialcode',
        'phone',
        'address',
        'latitude',
        'longitude',
        'location',
        'due_time',
        'vehicle_type',
        'registration_number',
        'destination_contact_name',
        'destination_contact_email',
        'destination_dialcode',
        'destination_phone',
        'destination_address',
        'destination_building_floor_room',
        'destination_latitude',
        'destination_longitude',
        'destination_notes',
        'destination_iso2',
        'priority',
        'due_amount',
        'towing_fee',
        'status',
        'requirements',
        'notes',
        'arrival_time',
        'completion_time',
        'signature',
        'driver_notes',
        'service_time',
        'added_by_id',
        'dispatched_by_id',
        'invoice_generated',
        'invoice_no',
        'battery_tyre_size',
        'ticket_no',
        'remarks',
        'do_sent'
    ];

    protected $hidden = [
        'signature',
    ];

    protected function casts(): array
    {
        return [
            'requirements' => 'array'
        ];
    }

    /**
     * Get all of the photos for the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(TaskPhoto::class, 'task_id', 'id');
    }

    public function parentTask(): BelongsTo
    {
        return $this->BelongsTo(Task::class, 'parent_task_id', 'id');
    }



    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class, 'merchant_id', 'id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id', 'id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'added_by_id', 'id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    function distance()
    {

        $unit = "K";
        $lat1 = $this->latitude;
        $lon1 = $this->longitude;
        $sd = $this->merchant?->storeDetail;
        $lat2 = $sd?->latitude;
        $lon2 = $sd?->longitude;

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            return round(($miles * 1.609344), 1) . ' KM';

            //   if ($unit == "K") {
            //     return ($miles * 1.609344);
            //   } else if ($unit == "N") {
            //     return ($miles * 0.8684);
            //   } else {
            //     return $miles;
            //   }
        }
    }


}
