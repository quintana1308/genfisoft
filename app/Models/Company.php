<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business_name',
        'tax_id',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'logo',
        'settings',
        'status_id'
    ];

    protected $casts = [
        'settings' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'user_companies')->withPivot('is_primary')->withTimestamps();
    }

    public function license(): HasOne
    {
        return $this->hasOne(License::class)->where('status', 'active');
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function cattles(): HasMany
    {
        return $this->hasMany(Cattle::class);
    }

    public function herds(): HasMany
    {
        return $this->hasMany(Herd::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    // Métodos de utilidad
    public function isActive(): bool
    {
        return $this->status_id == 1;
    }

    public function hasValidLicense(): bool
    {
        $license = $this->license;
        return $license && 
               $license->status === 'active' && 
               $license->end_date >= now()->toDateString();
    }

    public function getLicenseStatus(): string
    {
        $license = $this->license;
        
        if (!$license) {
            return 'no_license';
        }

        if ($license->end_date < now()->toDateString()) {
            return 'expired';
        }

        if ($license->status !== 'active') {
            return $license->status;
        }

        return 'active';
    }

    public function getDaysUntilExpiration(): int
    {
        $license = $this->license;
        
        if (!$license) {
            return 0;
        }

        return now()->diffInDays($license->end_date, false);
    }
}
