<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'license_key',
        'plan_type',
        'start_date',
        'end_date',
        'max_users',
        'max_cattle',
        'features',
        'status',
        'price',
        'payment_reference',
        'last_validated_at',
        'notes'
    ];

    protected $casts = [
        'features' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'last_validated_at' => 'datetime',
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relaciones
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeValid($query)
    {
        return $query->where('status', 'active')
                    ->where('end_date', '>=', now()->toDateString());
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('status', 'active')
                    ->whereBetween('end_date', [
                        now()->toDateString(),
                        now()->addDays($days)->toDateString()
                    ]);
    }

    // Métodos de utilidad
    public function isValid(): bool
    {
        return $this->status === 'active' && 
               $this->end_date >= now()->toDateString();
    }

    public function isExpired(): bool
    {
        return $this->end_date < now()->toDateString();
    }

    public function isExpiringSoon($days = 30): bool
    {
        return $this->isValid() && 
               $this->end_date <= now()->addDays($days)->toDateString();
    }

    public function getDaysRemaining(): int
    {
        return now()->diffInDays($this->end_date, false);
    }

    public function updateLastValidation(): void
    {
        $this->update(['last_validated_at' => now()]);
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? []);
    }

    public function canAddUsers(int $currentUserCount): bool
    {
        return $currentUserCount < $this->max_users;
    }

    public function canAddCattle(int $currentCattleCount): bool
    {
        return $currentCattleCount < $this->max_cattle;
    }

    // Generar clave de licencia única
    public static function generateLicenseKey(): string
    {
        do {
            $key = strtoupper(substr(md5(uniqid(rand(), true)), 0, 16));
            $formatted = chunk_split($key, 4, '-');
            $licenseKey = rtrim($formatted, '-');
        } while (self::where('license_key', $licenseKey)->exists());

        return $licenseKey;
    }

    // Planes predefinidos
    public static function getPlanLimits(string $planType): array
    {
        return match($planType) {
            'basic' => [
                'max_users' => 3,
                'max_cattle' => 200,
                'features' => ['basic_reports', 'cattle_management']
            ],
            'premium' => [
                'max_users' => 10,
                'max_cattle' => 1000,
                'features' => ['basic_reports', 'cattle_management', 'veterinary', 'financial']
            ],
            'enterprise' => [
                'max_users' => 50,
                'max_cattle' => 5000,
                'features' => ['basic_reports', 'cattle_management', 'veterinary', 'financial', 'advanced_reports', 'api_access']
            ],
            default => [
                'max_users' => 1,
                'max_cattle' => 50,
                'features' => ['basic_reports']
            ]
        };
    }
}
