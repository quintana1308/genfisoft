<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CauseEntryController;
use App\Http\Controllers\StatusProductiveController;
use App\Http\Controllers\StatusReproductiveController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\HerdController;
use App\Http\Controllers\CattleController;
use App\Http\Controllers\VeterinarianController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\WorkmanController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\DeathController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanySwitchController;

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    //DASHBOARD
    Route::get('/chart/reproductive-stats', [DashboardController::class, 'getReproductiveStats']);
    Route::get('/chart/productive-stats', [DashboardController::class, 'getProductiveStats']);
    Route::get('/chart/category-stats', [DashboardController::class, 'getCategoryStats']);
    Route::get('/dashboard/data', [DashboardController::class, 'getInputsByOwner']);

    //CATEGORY
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/data', [CategoryController::class, 'getCategorys']);
    Route::post('/category/create', [CategoryController::class, 'createCategory'])->name('createCategory');
    Route::get('/category/getCategory/{id}', [CategoryController::class, 'getCategory'])->name('getCategory');
    Route::post('/category/update', [CategoryController::class, 'updateCategory'])->name('updateCategory');


    //PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //CAUSE ENTRY
    Route::get('/causeEntry', [CauseEntryController::class, 'index'])->name('causeEntry.index');
    Route::get('/causeEntry/data', [CauseEntryController::class, 'getCauseEntrys']);
    Route::post('/causeEntry/create', [CauseEntryController::class, 'createCauseEntry'])->name('createCauseEntry');
    Route::get('/causeEntry/getCauseEntry/{id}', [CauseEntryController::class, 'getCauseEntry'])->name('getCauseEntry');
    Route::post('/causeEntry/update', [CauseEntryController::class, 'updateCauseEntry'])->name('updateCauseEntry');

    //STATUS PRODUCTIVE
    Route::get('/statusProductive', [StatusProductiveController::class, 'index'])->name('statusProductive.index');
    Route::get('/statusProductive/data', [StatusProductiveController::class, 'getStatusProductives']);
    Route::post('/statusProductive/create', [StatusProductiveController::class, 'createStatusProductive'])->name('createStatusProductive');
    Route::get('/statusProductive/getStatusProductive/{id}', [StatusProductiveController::class, 'getStatusProductive'])->name('getStatusProductive');
    Route::post('/statusProductive/update', [StatusProductiveController::class, 'updateStatusProductive'])->name('updateStatusProductive');

    //STATUS REPRODUCTIVE
    Route::get('/statusReproductive', [StatusReproductiveController::class, 'index'])->name('statusReproductive.index');
    Route::get('/statusReproductive/data', [StatusReproductiveController::class, 'getStatusReproductives']);
    Route::post('/statusReproductive/create', [StatusReproductiveController::class, 'createStatusReproductive'])->name('createStatusReproductive');
    Route::get('/statusReproductive/getStatusReproductive/{id}', [StatusReproductiveController::class, 'getStatusReproductive'])->name('getStatusReproductive');
    Route::post('/statusReproductive/update', [StatusReproductiveController::class, 'updateStatusReproductive'])->name('updateStatusReproductive');

    //COLOR
    Route::get('/color', [ColorController::class, 'index'])->name('color.index');
    Route::get('/color/data', [ColorController::class, 'getColors']);
    Route::post('/color/create', [ColorController::class, 'createColor'])->name('createColor');
    Route::get('/color/getColor/{id}', [ColorController::class, 'getColor'])->name('getColor');
    Route::post('/color/update', [ColorController::class, 'updateColor'])->name('updateColor');

    //CLASSIFICATION
    Route::get('/classification', [ClassificationController::class, 'index'])->name('classification.index');
    Route::get('/classification/data', [ClassificationController::class, 'getClassifications']);
    Route::post('/classification/create', [ClassificationController::class, 'createClassification'])->name('createClassification');
    Route::get('/classification/getClassification/{id}', [ClassificationController::class, 'getClassification'])->name('getClassification');
    Route::post('/classification/update', [ClassificationController::class, 'updateClassification'])->name('updateClassification');

    //OWNER
    Route::get('/owner', [OwnerController::class, 'index'])->name('owner.index');
    Route::get('/owner/data', [OwnerController::class, 'getOwners']);
    Route::post('/owner/create', [OwnerController::class, 'createOwner'])->name('createOwner');
    Route::get('/owner/getOwner/{id}', [OwnerController::class, 'getOwner'])->name('getOwner');
    Route::post('/owner/update', [OwnerController::class, 'updateOwner'])->name('updateOwner');

    //HERD
    Route::get('/herd', [HerdController::class, 'index'])->name('herd.index');
    Route::get('/herd/data', [HerdController::class, 'getHerds']);
    Route::post('/herd/create', [HerdController::class, 'createHerd'])->name('createHerd');
    Route::get('/herd/getHerd/{id}', [HerdController::class, 'getHerd'])->name('getHerd');
    Route::post('/herd/update', [HerdController::class, 'updateHerd'])->name('updateHerd');

    //CATTLE
    Route::get('/cattle', [CattleController::class, 'index'])->name('cattle.index');
    Route::get('/cattleCreate', [CattleController::class, 'create'])->name('cattle.create');
    Route::get('/cattleEdit', [CattleController::class, 'edit'])->name('cattle.edit');
    Route::get('/cattle/data', [CattleController::class, 'getCattles']);
    Route::post('/cattle/create', [CattleController::class, 'createCattle'])->name('createCattle');
    Route::get('/cattle/getCattle/{id}', [CattleController::class, 'getCattle'])->name('getCattle');
    Route::get('/cattle/getCattleView/{id}', [CattleController::class, 'getCattleView'])->name('getCattleView');
    Route::post('/cattle/update', [CattleController::class, 'updateCattle'])->name('updateCattle');
    Route::get('/cattle/{id}/servicesVeterinarian', [CattleController::class, 'servicesVeterinarian'])->name('cattle.servicesVeterinarian');
    Route::get('/cattle/dataVeterinarian', [CattleController::class, 'getServicesVeterinarian']);
    Route::get('/cattle/getCattleServicesView/{id}', [CattleController::class, 'getCattleServicesView'])->name('getCattleServicesView');

    //VETERINARIAN
    Route::get('/veterinarian', [VeterinarianController::class, 'index'])->name('veterinarian.index');
    Route::get('/veterinarianCreate', [VeterinarianController::class, 'create'])->name('veterinarian.create');
    Route::get('/veterinarianEdit', [VeterinarianController::class, 'edit'])->name('veterinarian.edit');
    Route::get('/veterinarian/data', [VeterinarianController::class, 'getVeterinarians']);
    Route::post('/veterinarian/create', [VeterinarianController::class, 'createVeterinarian'])->name('createVeterinarian');
    Route::get('/veterinarian/getVeterinarian/{id}', [VeterinarianController::class, 'getVeterinarian'])->name('getVeterinarian');
    Route::get('/veterinarian/getVeterinarianView/{id}', [VeterinarianController::class, 'getVeterinarianView'])->name('getVeterinarianView');
    Route::post('/veterinarian/update', [VeterinarianController::class, 'updateVeterinarian'])->name('updateVeterinarian');


    //PRODUCT
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/data', [ProductController::class, 'getProducts']);
    Route::post('/product/create', [ProductController::class, 'createProduct'])->name('createProduct');
    Route::get('/product/getProduct/{id}', [ProductController::class, 'getProduct'])->name('getProduct');
    Route::post('/product/update', [ProductController::class, 'updateProduct'])->name('updateProduct');

    //ESTATE
    Route::get('/estate', [EstateController::class, 'index'])->name('estate.index');
    Route::get('/estate/data', [EstateController::class, 'getEstates']);
    Route::post('/estate/create', [EstateController::class, 'createEstate'])->name('createEstate');
    Route::get('/estate/getEstate/{id}', [EstateController::class, 'getEstate'])->name('getEstate');
    Route::post('/estate/update', [EstateController::class, 'updateEstate'])->name('updateEstate');

    //WORKMAN
    Route::get('/workman', [WorkmanController::class, 'index'])->name('workman.index');
    Route::get('/workman/data', [WorkmanController::class, 'getWorkmans']);
    Route::post('/workman/create', [WorkmanController::class, 'createWorkman'])->name('createWorkman');
    Route::get('/workman/getWorkman/{id}', [WorkmanController::class, 'getWorkman'])->name('getWorkman');
    Route::post('/workman/update', [WorkmanController::class, 'updateWorkman'])->name('updateWorkman');

    //INPUT
    Route::get('/input', [InputController::class, 'index'])->name('input.index');
    Route::get('/input/data', [InputController::class, 'getInputs']);
    Route::post('/input/create', [InputController::class, 'createInput'])->name('createInput');
    Route::get('/input/getInput/{id}', [InputController::class, 'getInput'])->name('getInput');
    Route::post('/input/update', [InputController::class, 'updateInput'])->name('updateInput');

    //DEATH
    Route::get('/death', [DeathController::class, 'index'])->name('death.index');
    Route::get('/death/data', [DeathController::class, 'getDeaths']);
    Route::post('/death/create', [DeathController::class, 'createDeath'])->name('createDeath');
    Route::get('/death/deleteDeath/{id}', [DeathController::class, 'deleteDeath'])->name('deleteDeath');

    //ADMIN - Solo para administradores
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Gestión de empresas
        Route::get('/companies', [AdminController::class, 'companies'])->name('companies');
        Route::get('/companies/data', [AdminController::class, 'getCompaniesData'])->name('companies.data');
        Route::get('/companies/create', [AdminController::class, 'createCompany'])->name('companies.create');
        Route::post('/companies', [AdminController::class, 'storeCompany'])->name('companies.store');
        Route::get('/companies/{id}/edit', [AdminController::class, 'editCompany'])->name('companies.edit');
        Route::put('/companies/{id}', [AdminController::class, 'updateCompany'])->name('companies.update');
        Route::get('/companies/{id}', [AdminController::class, 'getCompany'])->name('companies.show');
        
        // Gestión de licencias
        Route::get('/companies/{companyId}/licenses', [AdminController::class, 'companyLicenses'])->name('companies.licenses');
        Route::get('/companies/{companyId}/licenses/create', [AdminController::class, 'createLicense'])->name('licenses.create');
        Route::post('/companies/{companyId}/licenses', [AdminController::class, 'storeLicense'])->name('licenses.store');
        Route::post('/licenses/{id}/renew', [AdminController::class, 'renewLicense'])->name('licenses.renew');
        Route::put('/licenses/{id}/toggle-status', [AdminController::class, 'toggleLicenseStatus'])->name('licenses.toggle-status');
        
        // Gestión de usuarios
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/data', [AdminController::class, 'getUsersData'])->name('users.data');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::get('/users/{id}', [AdminController::class, 'getUser'])->name('users.show');
        Route::put('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });

    // Cambio de empresa
    Route::post('/switch-company', [CompanySwitchController::class, 'switchCompany'])->name('switch.company');
    Route::get('/accessible-companies', [CompanySwitchController::class, 'getAccessibleCompanies'])->name('accessible.companies');

});

require __DIR__.'/auth.php';
