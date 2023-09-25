<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//VERIFICA SI ESTAS LOGEADO
Route::get('/verificacion',function(){
    return 'verificado';
})->middleware(Authenticate::class);


//GRUPO DE RUTAS
Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        return 'pagina usuarios';
    });
    Route::Get('/clientes',function(){
        return 'pagina clientes';
    });
});
#==============================================================
//TEST DE APP

#-Pagina principal
Route::view('/inicio','main')->name('mainPage');

Route::get('/menu',function(){
    return view('menu');
})->middleware(Authenticate::class)->name('menuUser');


#==============================================================
//RETORNA UNA VISTA 
Route::view('/vista','welcome');

// INGRESO DE DATOS 
Route::get('/nombre/{name}',function(string $name){
    return 'Tu nombre es '.$name;
})->name('Mi nombre');

Route::get('/apodo/{apodo?}',function(?string $apodo = ' usted no tiene apodo'){
    return " tu apodo es: ".$apodo;
});

Route::get('/nombre/{name}/apellido/{lastName}',function(string $name,string $lastName){
    return 'Tu nombre es '.$name ." " .$lastName;
});

Route::get('/semana/{dia}',function(string $dia){
    return 'El dia de la semana es '.$dia;
})->whereIn('dia',['Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo']);




//=====================================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
