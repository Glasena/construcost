<?php

require base_path('app/Modules/Auth/routes/api.php');

use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return ['message' => 'pong'];
});