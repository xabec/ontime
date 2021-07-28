<?php

use App\Http\Controllers\CheckVisitController;
use App\Http\Controllers\DoorController;
use App\Http\Controllers\DoorDisplayController;
use App\Http\Controllers\FinishRegistrationController;
use App\Http\Controllers\GetDoorStatusController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewDoorsController;
use App\Http\Controllers\RegisterVisitController;
use App\Http\Controllers\ScreenViewController;
use App\Http\Controllers\UnlockDoorController;
use App\Http\Controllers\VisitController;
use App\Http\Livewire\DoorDisplay;
use App\Http\Livewire\DoorTableController;
use App\Http\Livewire\NewDoors;
use App\Http\Livewire\ScreenView;
use App\Http\Livewire\UnlockDoor;
use App\Http\Livewire\VisitController as LivewireVisit;
use App\Http\Livewire\VisitTableController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('home');});

Route::post('/senddoorstatus', [ScreenView::class, 'changestatus'])->name('doors.status');
Route::get('/token', function () {return csrf_token();});

Route::get('/registervisit', [RegisterVisitController::class, 'index'])->name('registervisit.index');
Route::post('/registervisit/insert', [LivewireVisit::class, 'insert'])->name('registervisit.insert');

Route::get('/doors/view', [ScreenViewController::class, 'index'])->name('doors.view');
Route::get('/doors/unlock', [UnlockDoorController::class, 'index'])->name('doors.unlock');
Route::post('/doors/open_public', [UnlockDoor::class, 'open_public'])->name('doors.open_public');
Route::get('/doors/open_public/link', [UnlockDoor::class, 'open_public_link'])->name('doors.open_public_link');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/unlock', [UnlockDoorController::class, 'index'])->name('unlock');

Route::get('/user/finishregistration', [FinishRegistrationController::class, 'index'])->name('user.finishregistration');
Route::post('/user/confirmfinish', [FinishRegistrationController::class, 'confirmFinish'])->name('user.confirmfinish');
Route::get('/user/edit/{id}', [FinishRegistrationController::class, 'edit'])->name('user.edit');
Route::post('/user/confirmedit', [FinishRegistrationController::class, 'confirmEdit'])->name('user.confirmedit');
Route::get('/user/doctor/{id}', [FinishRegistrationController::class, 'doctorEdit'])->name('doctor.edit');
Route::post('/user/doctor/confirmedit', [FinishRegistrationController::class, 'doctorConfirm'])->name('doctor.confirm');

Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
Route::get('/visits/deletevisit/{id}', [VisitTableController::class, 'delete'])->name('visit.delete');
Route::get('/visits/editvisit/{id}', [VisitTableController::class, 'edit'])->name('visit.edit');
Route::post('/visits/confirmedit/{id}', [VisitTableController::class, 'confirmEdit'])->name('visit.confirmedit');
Route::get('/visits/completevisit/{id}', [VisitTableController::class, 'complete'])->name('visit.complete');
Route::post('/visits/confirmcomplete/{id}', [VisitTableController::class, 'confirmComplete'])->name('visit.confirmcomplete');
Route::get('/visits/check/{id}', [CheckVisitController::class, 'index'])->name('visit.check');

Route::get('/doors', [DoorController::class, 'index'])->name('doors.index');
Route::get('/doors/deletedoors/{id}', [DoorTableController::class, 'delete'])->name('doors.delete');
Route::get('/doors/editdoors/{id}', [DoorTableController::class, 'edit'])->name('doors.edit');
Route::post('/doors/confirmedit/{id}', [DoorTableController::class, 'confirmEdit'])->name('doors.confirmedit');
Route::get('/doors/new', [NewDoorsController::class, 'index'])->name('doors.new');
Route::post('/doors/check', [NewDoors::class, 'check'])->name('doors.check_status');
Route::post('/doors/insert', [DoorTableController::class, 'insert'])->name('doors.insert');
Route::get('/doors/doordisplay/{id}', [DoorDisplayController::class, 'index'])->name('doors.doordisplay');
Route::post('/doors/doordisplay/insert/{id}', [DoorDisplayController::class, 'insert'])->name('doors.doordisplay.insert');
Route::get('/doors/rights/{id}', [DoorTableController::class, 'rights'])->name('doors.rights');
Route::post('/doors/rights/insert/{id}', [DoorTableController::class, 'insertRights'])->name('doors.rights.insert');

Route::post('/doors/open', [DoorController::class, 'open'])->name('doors.open');
