<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin\AdminHealthController;
use Illuminate\Support\Facades\Route;

Route::get('/health', AdminHealthController::class)->name('health');
