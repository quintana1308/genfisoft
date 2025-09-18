<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB; 

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
