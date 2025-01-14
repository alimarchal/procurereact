<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'ibr_no',
        'referred_by',
        'name',
        'email',
        'password',
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

    /**
     * Get IBRs (Independent Business Representatives) referred by this user
     * Establishes a one-to-many relationship where:
     * - referred_by links to parent IBR's ibr_no
     * - Returns collection of child IBRs referred by current user
     *
     * @return HasMany
     */
    public function ibr(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by', 'id')->with('ibr');
    }

    /**
     * Get all IBRs in the downline network recursively
     * Establishes a recursive relationship that:
     * - Returns direct referrals (level 1)
     * - Eager loads nested referrals (level 2+) via 'ibr' relation
     * - Enables multi-level marketing structure tracking
     * - Useful for calculating indirect commissions & network size
     *
     * @return HasMany
     */
    public function ibrReferred(): HasMany
    {
        return $this->hasMany(User::class, 'referred_by', 'id');
    }


    /**
     * Get immediate parent IBR (upline)
     * Retrieves single-level parent relationship:
     * - Returns IBR who directly referred current user
     * - Selects only essential fields (id, ibr_no, referred_by)
     * - Used for direct upline commission calculations
     *
     * @return HasMany
     */
    public function parentIbr(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'referred_by')->select('id','ibr_no','referred_by');
    }

    /**
     * Get entire upline network recursively
     * Establishes recursive relationship that:
     * - Returns immediate parent IBR
     * - Eager loads all ancestor IBRs via 'parentIbr' relation
     * - Enables upward network traversal
     * - Used for multi-level commission structures
     *
     * @return HasMany
     */
    public function parentIbrReference(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'referred_by')->with('parentIbr');
    }


    public function referralNetwork()
    {
        return $this->ibrReferred()->with('referralNetwork');
    }

    /**
     * Get user's business profile
     * One-to-one relationship with Business model
     *
     * @return HasOne
     */
    public function business()
    {
        return $this->hasOne(Business::class);
    }

    /**
     * Get direct commissions earned from level 1 referrals
     * Tracks commissions from immediately referred IBRs
     *
     * @return HasMany
     */
    public function directCommissions(): HasMany
    {
        return $this->hasMany(IbrDirectCommission::class);
    }

    /**
     * Get indirect commissions earned from downline network
     * Tracks commissions from level 2+ referrals in network
     *
     * @return HasMany
     */
    public function indirectCommissions(): HasMany
    {
        return $this->hasMany(IbrIndirectCommission::class);
    }
}
