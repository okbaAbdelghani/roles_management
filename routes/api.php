<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//get default manuscripts
Route::get('/manuscripts',[\App\Http\Controllers\ManuscriptController::class, 'index']);
//get default manuscripts
Route::get('/manuscripts/perPage/{perPage}',[\App\Http\Controllers\ManuscriptController::class, 'nbrManuscriptsPerPage']);
//get default manuscripts
//Route::get('/manuscripts/search/{title}',[\App\Http\Controllers\ManuscriptController::class, 'searchByTitle']);
//get default manuscripts
Route::get('/manuscripts/detail/{uuid}',[\App\Http\Controllers\ManuscriptController::class, 'manuscriptByUuid']);
//get default manuscripts
Route::get('/manuscripts/subject/{class}',[\App\Http\Controllers\ManuscriptController::class, 'manuscriptsByClass']);
//get default manuscripts
Route::get('/manuscripts/subject/number/{lot}',[\App\Http\Controllers\ManuscriptController::class, 'classListByRow']);
//get libraries List
//Route::get('/manuscripts/libraries',[\App\Http\Controllers\ManuscriptController::class, 'librariesList']);
//get libraries by LOT
Route::get('/manuscripts/lib',[\App\Http\Controllers\ManuscriptController::class, 'librariesList']);
//Search In libraries List
Route::get('/manuscripts/lib/search/{lib}',[\App\Http\Controllers\ManuscriptController::class, 'searchInLibrariesList']);
//get All Class List
Route::get('/manuscripts/class',[\App\Http\Controllers\ManuscriptController::class, 'subjectList']);
// Search In Class List
Route::get('/manuscripts/class/search/{subject}',[\App\Http\Controllers\ManuscriptController::class, 'searchInSubjectList']);
//get PaperNum
Route::get('/manuscripts/paperNum',[\App\Http\Controllers\ManuscriptController::class, 'paperNumList']);
// Search In PaperNum
Route::get('/manuscripts/paperNum/search/{paper}',[\App\Http\Controllers\ManuscriptController::class, 'searchInPaperNumList']);

//get manuscripts list of languages
Route::get('/manuscripts/count',[\App\Http\Controllers\ManuscriptController::class, 'countManuscripts']);
// Search By Elements
Route::post('/manuscripts/search',[\App\Http\Controllers\ManuscriptController::class, 'searchByElements']);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function (){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
