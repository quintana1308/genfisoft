<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;
use App\Models\Cattle;

class Death extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'deaths';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'cattle_id',
        'reason',
        'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function cattle(): BelongsTo
    {
        return $this->belongsTo(Cattle::class, 'cattle_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    //CONSULTAS
    public function getDeaths($request)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $query = Death::with('status')->where('company_id', $activeCompanyId);

        // Si se envían las dos fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('date', [$request->fecha_inicio, $request->fecha_fin]);
        }
        // Si solo se envía fecha_inicio
        elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('date', '>=', $request->fecha_inicio);
        }
        // Si solo se envía fecha_fin
        elseif ($request->filled('fecha_fin')) {
            $query->whereDate('date', '<=', $request->fecha_fin);
        }

        $deaths = $query->get();
        
        if ($deaths->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($deaths)
            ->addIndexColumn() // para el índice
            ->addColumn('cattle', function ($death) {
                return $death->cattle->code;
            })
            ->addColumn('reason', function ($death) {
                return $death->reason;
            })
            ->addColumn('date', function ($death) {
                return $death->date;
            })
            ->addColumn('options', function ($death) {
                $id = $death->id;
                
                $btnEdit = '<button class="btn btn-danger btn-link btn-sm btn-icon" onClick="deleteDeath(`' . $id . '`)"><i class="fa-solid fa-trash"></i></button>';
                return '<div class="text-center">' . $btnEdit . '</div>';
            })
            ->rawColumns(['cattle', 'reason', 'date', 'options'])
            ->make(true);
        
        return $data;
    }

    public function createDeath($request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados
        if (Death::where('company_id', $activeCompanyId)->where('cattle_id', $request->cattleId)->exists()) {
            return response()->json(['status' => false, 'msg' => 'El animal ya se encuentra muerto.']);
        }

        $death = Death::create([
            'cattle_id' => $request->cattleId,
            'reason' => $request->reason,
            'date' => $request->date,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
        ]);

        // Actualizar el status del animal
        if ($death) {
            $cattle = Cattle::find($request->cattleId);
            if ($cattle) {
                $cattle->status_id = 2; // 👈 muerto
                $cattle->save();
            }
        }

        return response()->json(['status' => true, 'msg' => 'Muerte creada correctamente.']);
    }

    public function deleteDeath($id)
    {   
        $death = $this->find($id);

        if (!$death) {
            return response()->json([
                'status' => false,
                'msg'    => 'Muerte no encontrada.'
            ]);
        }

        if ($death->delete()) {

            $cattle = Cattle::find($death->cattle_id);
            if ($cattle) {
                $cattle->status_id = 1; // 👈 muerto
                $cattle->save();
            }

            return response()->json([
                'status' => true,
                'msg'    => 'Muerte eliminada correctamente.'
            ]);
        }

        return response()->json([
            'status' => false,
            'msg'    => 'No se pudo eliminar el registro.'
        ]);
    }
}