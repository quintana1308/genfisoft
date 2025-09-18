<?php

namespace App\Traits;

use App\Models\Company;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToCompany
{
    /**
     * Boot the trait
     */
    protected static function bootBelongsToCompany()
    {
        // Automáticamente asignar company_id al crear
        static::creating(function ($model) {
            if (!$model->company_id && Auth::check()) {
                $model->company_id = Auth::user()->company_id;
            }
        });

        // Automáticamente filtrar por company_id en consultas
        static::addGlobalScope('company', function (Builder $builder) {
            if (Auth::check() && Auth::user()->company_id) {
                $builder->where('company_id', Auth::user()->company_id);
            }
        });
    }

    /**
     * Relación con Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope para filtrar por empresa específica
     */
    public function scopeForCompany(Builder $query, $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Verificar si el registro pertenece a la empresa del usuario actual
     */
    public function belongsToCurrentUserCompany(): bool
    {
        return Auth::check() && $this->company_id === Auth::user()->company_id;
    }
}
