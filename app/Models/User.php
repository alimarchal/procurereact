<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ibr_no',
        'referred_by',
        'gender',
        'country_of_business',
        'city_of_business',
        'country_of_bank',
        'bank',
        'iban',
        'currency',
        'mobile_number',
        'dob',
        'mac_address',
        'device_name',
        'is_active',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function company()
    {
        return $this->hasOne(Company::class);
    }


    /* Relation for IBRs having child IBRs start */
    public function ibr(): HasMany
    {
        return $this->hasMany(User::class,'referred_by','ibr_no');
    }


    public function ibrReferred(): HasMany
    {
        // This is method where we implement recursive relationship
        return $this->hasMany(User::class,'referred_by', 'ibr_no')->with('ibr');
    }
    /* Relation for IBRs having child IBRs end */


    /* Relation for IBRs having parent IBRs start */
    public function parentIbr(): HasMany
    {
        // This relationship will only return one level of parent ibr
        return $this->hasMany(User::class,'ibr_no','referred_by')->select('id','ibr_no','referred_by');
    }

    public function parentIbrReference(): HasMany
    {
        // This is method where we implement recursive relationship
        return $this->hasMany(User::class,'ibr_no', 'referred_by')->with('parentIbr');
    }
    /* Relation for IBRs having parent IBRs end */

    public function directCommissions(): HasMany
    {
        return $this->hasMany(IbrDirectCommission::class);
    }

    public function indirectCommissions(): HasMany
    {
        return $this->hasMany(IbrIndirectCommission::class);
    }

}
