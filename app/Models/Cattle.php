<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 
use App\Models\Status;
use App\Models\Category;
use App\Models\Herd;
use App\Models\CauseEntry;
use App\Models\StatusReproductive;
use App\Models\StatusProductive;
use App\Models\Owner;
use App\Models\Color;
use App\Models\Classification;
use App\Models\Guide;

class Cattle extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'cattles';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_id',
        'code',
        'category_id',
        'herd_id',
        'date_start',
        'cause_entry_id',
        'status_reproductive_id',
        'status_productive_id',
        'date_revision',
        'owner_id',
        'father_id',
        'mother_id',
        'date_birth',
        'color_id',
        'classification_id',
        'guide_id',
        'sexo',
        'income_weight',
        'output_weight',
        'price_purchase',
        'status_id'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function herd(): BelongsTo
    {
        return $this->belongsTo(Herd::class, 'herd_id', 'id');
    }

    public function causeEntry(): BelongsTo
    {
        return $this->belongsTo(CauseEntry::class, 'cause_entry_id', 'id');
    }

    public function statusReproductive(): BelongsTo
    {
        return $this->belongsTo(StatusReproductive::class, 'status_reproductive_id', 'id');
    }

    public function statusProductive(): BelongsTo
    {
        return $this->belongsTo(StatusProductive::class, 'status_productive_id', 'id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }

    public function classification(): BelongsTo
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'id');
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class, 'guide_id', 'id');
    }

    public function veterinarians()
    {
        return $this->hasMany(Veterinarian::class, 'cattle_id');
    }

    //CONSULTAS
    public function getCattles($request)
    {
        $userId = Auth::id();
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Siempre filtrar por empresa activa del usuario
        $query = Cattle::with('status', 'veterinarians', 'herd', 'category', 'classification', 'causeEntry')
            ->where('company_id', $activeCompanyId);

        $cattles = $query->get();

        if ($cattles->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($cattles)
            ->addIndexColumn() // para el índice
            ->addColumn('code', function ($cattle) {
                return $cattle->code;
            })
            ->addColumn('herd', function ($cattle) {
                return $cattle->herd->name;
            })
            ->addColumn('category', function ($cattle) {
                return $cattle->category->name;
            })
            ->addColumn('classification', function ($cattle) {
                return $cattle->classification->name;
            })
            ->addColumn('date_start', function ($cattle) {
                return $cattle->date_start;
            })
            ->addColumn('causeEntry', function ($cattle) {
                return $cattle->causeEntry->name;
            })
            ->addColumn('status', function ($cattle) {
                $statusName = $cattle->status ? $cattle->status->name : 'Sin estado';

                // Personalizar colores
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0',
                    'muerto' => '#000000',
                    'vendido' => '#FF9800',
                    default => '#6c757d'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($cattle) {
                $id = $cattle->id;
                $btnView = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="viewCattle(`' . $id . '`)"><i class="fa-solid fa-eye"></i></button>';
                
                // Si el animal está vendido (status_id = 4), no mostrar botón de editar
                $btnEdit = '';
                if ($cattle->status_id != 4) {
                    $btnEdit = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="editCattle(`' . $id . '`)"><i class="fa-solid fa-pen-to-square"></i></button>';
                }
                
                $btnService = '';
                if ($cattle->veterinarians->count() > 0) {
                    $btnService = '<a href="' . route('cattle.servicesVeterinarian', $id) . '" class="btn btn-danger btn-link btn-sm btn-icon p-1"><i class="fa-solid fa-house-medical"></i></a>';
                }
                return '<div class="text-center">'. $btnView .' '. $btnEdit .' '. $btnService .'</div>';
            })
            ->rawColumns(['code', 'name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function newCattles()
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        // Filtrar por empresa activa del usuario
        $categorys = Category::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $status = Status::all(); // Los status son globales
        
        $herds = Herd::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $causeEntrys = CauseEntry::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $statusReproductives = StatusReproductive::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $statusProductives = StatusProductive::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $owners = Owner::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $fathers = Cattle::where('company_id', $activeCompanyId)
            ->where('sexo', 'Macho')
            ->whereNotNull('code')
            ->whereIn('status_id', [1, 3]) // Solo activos y referencia
            ->get();
        
        $mothers = Cattle::where('company_id', $activeCompanyId)
            ->where('sexo', 'Hembra')
            ->whereNotNull('code')
            ->whereIn('status_id', [1, 3]) // Solo activos y referencia
            ->get();
        
        $colors = Color::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $classifications = Classification::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        $guides = Guide::where('company_id', $activeCompanyId)
            ->whereNotIn('status_id', [2, 3])
            ->get();
        
        return [
            'categorys' => $categorys,
            'status' => $status,
            'herds' => $herds,
            'causeEntrys' => $causeEntrys,
            'statusReproductives' => $statusReproductives,
            'statusProductives' => $statusProductives,
            'owners' => $owners,
            'fathers' => $fathers,
            'mothers' => $mothers,
            'colors' => $colors,
            'classifications' => $classifications,
            'guides' => $guides
        ];
    }

    public function createCattle($request)
    {
        $userId = auth()->id();
        $user = auth()->user();
        $activeCompanyId = $user->active_company_id;

        // Evitar duplicados por empresa
        if (Cattle::where('company_id', $activeCompanyId)->where('code', $request->code)->exists()) {
            return response()->json(['status' => false, 'msg' => 'Ya existe un animal con este código en la empresa.']);
        }

        Cattle::create([
            'code' => $request->code,
            'category_id' => $request->category,
            'herd_id' => $request->herd,
            'date_start' => $request->dateStart,
            'cause_entry_id' => $request->causeEntry,
            'status_reproductive_id' => $request->statusReproductive ?: null,
            'status_productive_id' => $request->statusProductive ?: null,
            'date_revision' => $request->dateRevision ?: null,
            'owner_id' => $request->owner ?: null,
            'father_id' => $request->father ?: null,
            'mother_id' => $request->mother ?: null,
            'date_birth' => $request->dateBirth ?: null,
            'color_id' => $request->color,
            'classification_id' => $request->classification,
            'guide_id' => $request->guide ?: null,
            'sexo' => $request->sexo,
            'user_id' => $userId,
            'company_id' => $activeCompanyId,
            'income_weight' => $request->incomeWeight,
            'output_weight' => $request->outputWeight ?: null,
            'price_purchase' => $request->pricePurchase

        ]);

        return response()->json(['status' => true, 'msg' => 'Animal creado correctamente.']);
    }

    public function getCattle($id)
    {
        $userId = Auth::id();

        // Obtener empresa activa del usuario
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $cattle = Cattle::where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$cattle) {
            return response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }

        // Obtener todos los status
        $statuses = Status::orderBy('name')->get(['id', 'name']);
        $categories = Category::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $causeEntrys = CauseEntry::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $classifications = Classification::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $colors = Color::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $herds = Herd::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'code', 'name']);
        $owners = Owner::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $statusProductives = StatusProductive::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $statusReproductives = StatusReproductive::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);
        $fathers = Cattle::where('company_id', $activeCompanyId)->where('sexo', 'Macho')->whereIn('status_id', [1, 3])->orderBy('code')->get(['id', 'code']);
        $mothers = Cattle::where('company_id', $activeCompanyId)->where('sexo', 'Hembra')->whereIn('status_id', [1, 3])->orderBy('code')->get(['id', 'code']);
        $guides = Guide::where('company_id', $activeCompanyId)->whereNotIn('status_id', [2, 3])->orderBy('name')->get(['id', 'name']);

        $data =  response()->json([
            'status' => true,
            'data' => [
                'id' => $cattle->id,
                'code' => $cattle->code,
                'category' => optional($cattle->category)->id,
                'herd' => optional($cattle->herd)->id,
                'dateStart' => $cattle->date_start,
                'dateEnd' => $cattle->date_end,
                'causeEntry' => optional($cattle->causeEntry)->id,
                'statusReproductive' => optional($cattle->statusReproductive)->id,
                'statusProductive' => optional($cattle->statusProductive)->id,
                'dateRevision' => $cattle->date_revision,
                'owner' => optional($cattle->owner)->id,
                'father' => $cattle->father,
                'mother' => $cattle->mother,
                'dateBirth' => $cattle->date_birth,
                'color' => optional($cattle->color)->id,
                'classification' => optional($cattle->classification)->id,
                'guide' => optional($cattle->guide)->id,
                'sexo' => $cattle->sexo,
                'name' => $cattle->name,
                'status_id' => $cattle->status_id,
                'incomeWeight' => $cattle->income_weight,
                'outputWeight' => $cattle->output_weight,
                'pricePurchase' => $cattle->price_purchase,
            ],
            'statuses' => $statuses,
            'categories' => $categories,
            'causeEntrys' => $causeEntrys,
            'classifications' => $classifications,
            'colors' => $colors,
            'herds' => $herds,
            'owners' => $owners,
            'statusReproductives' => $statusReproductives,
            'statusProductives' => $statusProductives,
            'fathers' => $fathers,
            'mothers' => $mothers,
            'guides' => $guides
        ]);

        return $data;
    }

    public function getCattleView($id)
    {
        $user = Auth::user();
        $activeCompanyId = $user->active_company_id;

        $cattle = Cattle::with(['category',
                                'herd', 
                                'causeEntry',
                                'color', 
                                'owner', 
                                'statusReproductive', 
                                'statusProductive',
                                'owner',
                                'color',
                                'classification',
                                'guide',
                                'status'])
                ->where('id', $id)
                ->where('company_id', $activeCompanyId)
                ->first();

        if (!$cattle) {
            $data = response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }else{
            // Obtener hijos donde este animal es padre o madre
            $children = Cattle::where('company_id', $activeCompanyId)
                ->where(function($query) use ($id) {
                    $query->where('father_id', $id)
                          ->orWhere('mother_id', $id);
                })
                ->select('id', 'code', 'sexo', 'date_birth', 'father_id', 'mother_id')
                ->get();

            $data = response()->json([
                'status' => true,
                'cattle' => $cattle,
                'children' => $children
            ]);
        }

        return $data;
    }

    public function updateCattle($request)
    {   
        $cattle = $this->find($request->idEdit);
        if (!$cattle) {
            return response()->json(['status' => false, 'msg' => 'Animal no encontrado.']);
        }

        // Validar duplicados por empresa (excluyendo el animal actual)
        $user = auth()->user();
        $activeCompanyId = $user->active_company_id;
        
        if (Cattle::where('company_id', $activeCompanyId)
                ->where('code', $request->codeEdit)
                ->where('id', '!=', $request->idEdit)
                ->exists()) {
            return response()->json(['status' => false, 'msg' => 'Ya existe un animal con este código en la empresa.']);
        }

        //dd($request->incomeWeightEdit);
        
        $cattle->code = $request->codeEdit;
        $cattle->category_id = $request->categoryEdit;
        $cattle->status_id = $request->statusEdit;
        $cattle->herd_id = $request->herdEdit;
        $cattle->date_start = $request->dateStartEdit;
        $cattle->date_end = $request->dateEndEdit;
        $cattle->cause_entry_id = $request->causeEntryEdit;
        $cattle->status_reproductive_id = $request->statusReproductiveEdit;
        $cattle->status_productive_id = $request->statusProductiveEdit;
        $cattle->date_revision = $request->dateRevisionEdit;
        $cattle->owner_id = $request->ownerEdit ?: null;
        $cattle->father_id = $request->fatherEdit ?: null;
        $cattle->mother_id = $request->motherEdit ?: null;
        $cattle->date_birth = $request->dateBirthEdit;
        $cattle->color_id = $request->colorEdit;
        $cattle->classification_id = $request->classificationEdit;
        $cattle->guide_id = $request->guideEdit ?: null;
        $cattle->sexo = $request->sexoEdit;
        $cattle->income_weight = $request->incomeWeightEdit;
        $cattle->output_weight = $request->outputWeightEdit;
        $cattle->price_purchase = $request->pricePurchaseEdit;


        if ($cattle->save()) {
            return response()->json(['status' => true, 'msg' => 'Datos actualizados correctamente.']);
        }

        return response()->json(['status' => false, 'msg' => 'No se pudieron actualizar los datos.']);
    }

    public function servicesVeterinarian($id)
    {
        // Obtener la información del ganado (opcional si la quieres mostrar en la vista)
        $cattle = Cattle::findOrFail($id);

        // Retornar vista con datos
        return $cattle;
    }

    public function getServicesVeterinarian($id)
    {
        $userId = Auth::id();

        $veterinarians = Veterinarian::with('status')->where('cattle_id', $id)->where('user_id', $userId)->get();

        if ($veterinarians->count() === 0) {
            return DataTables::of(collect())->make(true);
        }

        $data = DataTables::of($veterinarians)
            ->addIndexColumn() // para el índice
            ->addColumn('product', function ($veterinarian) {
                return $veterinarian->product->name;
            })
            ->addColumn('symptoms', function ($veterinarian) {
                return $veterinarian->symptoms;
            })
            ->addColumn('dateStart', function ($veterinarian) {
                return $veterinarian->date_start;
            })
            ->addColumn('dateEnd', function ($veterinarian) {
                return $veterinarian->date_end;
            })
            ->addColumn('status', function ($veterinarian) {
                $statusName = $veterinarian->status ? $veterinarian->status->name : 'Sin estado';

                // Personalizar
                $badgeClass = match (strtolower($statusName)) {
                    'activo' => '#44C47D',
                    'inactivo' => '#DC3545',
                    'referencia' => '#9c27b0'
                };

                return '<span class="badge badge-default text-white p-2" style="background-color:' . $badgeClass . '; border-color:' . $badgeClass . '">' . $statusName . '</span>';
            })
            ->addColumn('options', function ($veterinarian) {
                $id = $veterinarian->id; 
                $btnView = '<button class="btn btn-info btn-link btn-sm btn-icon" onClick="viewCattleServices(`' . $id . '`)"><i class="fa-solid fa-eye"></i></button>';
                return '<div class="text-center">'. $btnView .'</div>';
            })
            ->rawColumns(['code', 'name', 'status', 'options'])
            ->make(true);
        
        return $data;
    }

    public function getCattleServicesView($id)
    {
        $userId = Auth::id();

        $veterinarian = Veterinarian::with(['product',
                                'status'])
                ->where('id', $id)
                ->where('user_id', $userId)
                ->first();

        if (!$veterinarian) {
            $data = response()->json([
                'status' => false,
                'msg' => 'Datos no encontrados.'
            ]);
        }else{
            $data = response()->json([
                'status' => true,
                'veterinarian' => $veterinarian
            ]);
        }

        return $data;
    }
}
