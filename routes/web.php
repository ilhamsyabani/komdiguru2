<?php

use App\Http\Livewire\Pages\Admin\AddUser;
use App\Http\Livewire\Pages\Admin\ViewUser;
use App\Http\Livewire\Pages\Category\AddCategory;
use App\Http\Livewire\Pages\Category\EditCategory;
use App\Http\Livewire\Pages\Category\ViewCategory;
use App\Http\Livewire\Pages\Dashboard;
use App\Http\Livewire\Pages\Instansion\AddInstansion;
use App\Http\Livewire\Pages\Instansion\ViewInstansion;
use App\Http\Livewire\Pages\Option\AddOption;
use App\Http\Livewire\Pages\Option\EditOption;
use App\Http\Livewire\Pages\Option\ViewOption;
use App\Http\Livewire\Pages\Question\AddQuestion;
use App\Http\Livewire\Pages\Question\EditQuestion;
use App\Http\Livewire\Pages\Question\ViewQuestion;
use App\Http\Livewire\Pages\Result\DetailResult;
use App\Http\Livewire\Pages\Result\ViewResult;
use App\Http\Livewire\Pages\Rule\EditRule;
use App\Http\Livewire\Pages\Rule\ViewRule;
use App\Http\Livewire\Pages\Servey\AddSurvey;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('auth.login');
})->name('welcome');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
 
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/dashboard', Dashboard::class)->middleware(['auth','verified'])->name('dashboard');
Route::get('/admin/view-user', ViewUser::class)->middleware(['auth', 'verified'])->name('view-user');
Route::get('/admin/add-user', AddUser::class)->middleware(['auth', 'verified'])->name('add-user');
Route::get('/admin/view-instansion', ViewInstansion::class)->middleware(['auth', 'verified'])->name('view-instansion');
Route::get('/admin/add-instansion', AddInstansion::class)->middleware(['auth', 'verified'])->name('add-instansion');
Route::get('/admin/view-category', ViewCategory::class)->middleware(['auth', 'verified'])->name('view-category');
Route::get('/admin/add-category', AddCategory::class)->middleware(['auth', 'verified'])->name('add-category');
Route::get('/admin/edit-category/{categoryId}', EditCategory::class)->middleware(['auth', 'verified'])->name('edit-category');
Route::get('/admin/view-rule', ViewRule::class)->middleware(['auth', 'verified'])->name('view-rule');
Route::get('/admin/edit-rule/{ruleId}', EditRule::class)->middleware(['auth', 'verified'])->name('edit-rule');
Route::get('/admin/view-question', ViewQuestion::class)->middleware(['auth', 'verified'])->name('view-question');
Route::get('/admin/add-question', AddQuestion::class)->middleware(['auth', 'verified'])->name('add-question');
Route::get('/admin/edit-question/{questionId}', EditQuestion::class)->middleware(['auth', 'verified'])->name('edit-question');
Route::get('/user/test', AddSurvey::class)->middleware(['auth', 'verified'])->name('survey');
Route::post('/survey/test', [\App\Http\Controllers\TestController::class, 'store'])->name('client.test.store');
Route::put('/survey/test/{result}', [\App\Http\Controllers\TestController::class, 'update'])->name('client.test.update');
Route::get('/survey/test', [\App\Http\Controllers\TestController::class, 'index'])->name('test');
Route::get('/survey/test/{result_id}', [\App\Http\Controllers\TestController::class, 'edit'])->name('survey.edit');
Route::get('/survey/results/{result_id}', [\App\Http\Controllers\ResultController::class, 'show'])->name('survey.results');
Route::get('/result/{result}', DetailResult::class)->middleware(['auth', 'verified'])->name('detail.result');
Route::get('/admin/result', ViewResult::class)->middleware(['auth', 'verified'])->name('result');


require __DIR__ . '/auth.php';