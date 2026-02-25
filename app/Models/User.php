<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class User extends Authenticatable
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
        'firstname',
        'lastname',
        'email',
        'dialcode',
        'phone',
        'vehicle_type',
        'vehicle_name',
        'avatar',
        'gender',
        'address',
        'city',
        'state',
        'zipcode',
        'iso2',
        'status',
        'vehicle_type',
        'vehicle_description',
        'vehicle_registration_no',
        'app_push_token',
        'password',
        'is_online',
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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['firstname', 'lastname'])
            ->saveSlugsTo('slug');
    }
    public function activeJobs(){
        return $this->hasMany(Task::class,'driver_id','id')->whereIn('status',['active','in-transist','arrived']);
    }

    function distance($latitude, $longitude)
    {

        $unit = "K";
        $lat1 = $this->latitude;
        $lon1 = $this->longitude;
        $sd = $this->merchant?->storeDetail;
        $lat2 = $latitude;
        $lon2 = $longitude;

        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            return round(($miles * 1.609344), 1);

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
