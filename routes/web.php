<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScndCtgController;
use App\Http\Controllers\ThrdCtgController;
use App\Http\Controllers\FourCtgController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SearchItemController;

use App\models\Documents;
    
Route::get('search', [SearchItemController::class, 'searchOutput'])->name('search');

Route::POST('/search-items', [SearchItemController::class, 'search'])->name('search-items');


Route::get('/', [HomeController::class, 'ListOutput'])->name('home');

Route::get('/Mcatedory-add', [HomeController::class, 'categoryAddView'])->name('HomeAddView');

Route::post('/Mcatedory-add', [HomeController::class, 'categoryAdd'])->name('HomeAdd');

Route::get('/{id}/HomeUpdate', [HomeController::class, 'categoryUpdateView'])->name('HomeUpdateView');

Route::post('/{id}/HomeUpdate', [HomeController::class, 'categoryUpdate'])->name('HomeUpdate');

Route::get('/{id}/homeDeleting', [HomeController::class, 'categoryDelete'])->name('HomeDelete');

Route::post('/{id}/HomeIMGUpdate', [HomeController::class, 'contentIMGUpdate'])->name('HomeIMGUpdate');

Route::post('/{id}/HomeDescUpdate', [HomeController::class, 'contentDescUpdate'])->name('HomeDescUpdate');


Route::get('/2с/{id_MPC}', [ScndCtgController::class, 'ListOutput'])->name('2c');

Route::get('/Scatedory-add/{id}', [ScndCtgController::class, 'categoryAddView'])->name('ScategoryAddView');

Route::post('/Scatedory-add', [ScndCtgController::class, 'categoryAdd'])->name('ScategoryAdd');

Route::get('/2c/{id}/TCtgUpdate', [ScndCtgController::class, 'categoryUpdateView'])->name('ScategoryUpdateView');

Route::post('/2c/{id}/TCtgUpdate', [ScndCtgController::class, 'categoryUpdate'])->name('ScategoryUpdate');

Route::get('/2c/{id}/itemDeleting', [ScndCtgController::class, 'categoryDelete'])->name('ScategoryDelete');


Route::get('/3с/{id_SC}', [ThrdCtgController::class, 'ListOutput'])->name('3c');

Route::get('/catedory-add/{id}', [ThrdCtgController::class, 'categoryAddView'])->name('categoryAddView');

Route::post('/catedory-add', [ThrdCtgController::class, 'categoryAdd'])->name('categoryAdd');

Route::get('/3c/{id}/TCtgUpdate', [ThrdCtgController::class, 'categoryUpdateView'])->name('categoryUpdateView');

Route::post('/3c/{id}/TCtgUpdate', [ThrdCtgController::class, 'categoryUpdate'])->name('categoryUpdate');

Route::get('/3c/{id}/itemDeleting', [ThrdCtgController::class, 'categoryDelete'])->name('categoryDelete');


Route::get('/catedory4-add/{id}', [FourCtgController::class, 'categoryAddView'])->name('category4AddView');

Route::post('/catedory4-add', [FourCtgController::class, 'categoryAdd'])->name('category4Add');

Route::get('/4c/{id}/FCtgUpdate', [FourCtgController::class, 'categoryUpdateView'])->name('category4UpdateView');

Route::post('/4c/{id}/FCtgUpdate', [FourCtgController::class, 'categoryUpdate'])->name('category4Update');

Route::get('/4c/{id}/itemDeleting', [FourCtgController::class, 'categoryDelete'])->name('category4Delete');

Route::get('/list4/{id_Category}', [ItemController::class, 'List4Output'])->name('list4');


Route::get('/list/{id_Category}', [ItemController::class, 'ListOutput'])->name('list');

Route::get('/item/{id_item}', [ItemController::class, 'itemOutput'])->name('item');

Route::get('/item/{id_item}/update', [ItemController::class, 'itemUpdate'])->name('update');

Route::get('/list/{id_Category}/ItmDel', [ItemController::class, 'itemDelete'])->name('delete');

Route::get('/item/{id_item}/imgDeleting', [ItemController::class, 'imgDelete'])->name('imgDel');

Route::get('/item/{id}/imgUpdatingView', [ItemController::class, 'imgUpdateView'])->name('imgUpdateView');

Route::post('/item/{id}/imgUpdate', [ItemController::class, 'imgUpdate'])->name('imgUpdate');

Route::get('/item/{id_item}/docsDeleting', [ItemController::class, 'docsDelete'])->name('docsDel');

Route::post('/item/{id_item}/update', [ItemController::class, 'itemUpload'])->name('itemUpload');

Route::get('/add/{id}', [ItemController::class, 'itemAddView'])->name('add');

Route::post('/add', [ItemController::class, 'itemAdd'])->name('itemAdd');


Route::get('/post', [\App\Http\Controllers\ListController::class, 'ListOutput']);


Route::get('/get-pdf/{id}', [\App\Http\Controllers\FileController::class, 'fileConvert'])->name('get-pdf');



Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/');
    }
    return view('auth/login');
})->name('login');
 
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/logout', function () {
     Auth::logout();
    return redirect('/');
});

Route::get('/register', function () {
    if (Auth::check()) {
        return view('auth/register');
    }
    return redirect('/');
})->name('register');

Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
