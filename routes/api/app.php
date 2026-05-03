<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\App\AppHealthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', AppHealthController::class)->name('health');
