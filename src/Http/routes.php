<?php


use Illuminate\Support\Facades\Route;
use itinysun\ddns\Http\Controllers\DdnsController;
use itinysun\ddns\Http\Controllers\DomainController;


Route::resource('ddns', DomainController::class);

Route::any('/ddns/run/{token}',[DdnsController::class,'run'])->withoutMiddleware(['admin'])->name('ddns.run');
