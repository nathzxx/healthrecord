<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PublicVisitationForm;

Route::get('/', function () {
    return to_route('filament.admin.auth.login');
})->middleware('guest');


Route::get('/visitation', function () {
    return view('public-visitation');
})->name('public.visitation');