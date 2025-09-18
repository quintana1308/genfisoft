<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'rebaño',   
        'email',
        'password',
        'company_id',
        'active_company_id',
        'role',
        'is_active',
        'last_login_at',
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
            'password' => 'hashed',
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relaciones
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function activeCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'active_company_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'user_companies')->withPivot('is_primary')->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Métodos de utilidad
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    public function canManage(): bool
    {
        return in_array($this->role, ['admin', 'manager']);
    }

    public function hasValidLicense(): bool
    {
        return $this->company && $this->company->hasValidLicense();
    }

    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    // Métodos para gestión multi-empresa
    public function getActiveCompany()
    {
        return $this->activeCompany ?: $this->company;
    }

    public function switchToCompany($companyId): bool
    {
        // Verificar que el usuario tiene acceso a esta empresa
        if ($this->isAdmin() || $this->companies()->where('company_id', $companyId)->exists()) {
            $this->update(['active_company_id' => $companyId]);
            return true;
        }
        return false;
    }

    public function getAccessibleCompanies()
    {
        if ($this->isAdmin()) {
            return Company::all();
        }
        return $this->companies;
    }

    public function hasAccessToCompany($companyId): bool
    {
        if ($this->isAdmin()) {
            return true;
        }
        return $this->companies()->where('company_id', $companyId)->exists();
    }
}
