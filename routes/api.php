<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\MessageRequestController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;
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


Route::get('/check-update', function (Request $request) {
    $versionFile = base_path('version.json');

    if (!file_exists($versionFile)) {
        return response()->json([
            'error' => 'Version file not found',
            'update' => false
        ], 500);
    }

    $fileContents = file_get_contents($versionFile);
    if ($fileContents === false) {
        return response()->json([
            'error' => 'Unable to read version file',
            'update' => false
        ], 500);
    }

    $versionData = json_decode($fileContents, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($versionData)) {
        return response()->json([
            'error' => 'Invalid JSON format in version file',
            'update' => false
        ], 500);
    }

    if (!isset($versionData['version']) || !isset($versionData['url'])) {
        return response()->json([
            'error' => 'Missing required version data',
            'update' => false
        ], 500);
    }

    $currentVersion = $request->query('version', '');

    if (version_compare($versionData['version'], $currentVersion, '>')) {
        return response()->json([
            'update' => true,
            'version' => $versionData['version'],
            'url' => $versionData['url']
        ]);
    } else {
        return response()->json([
            'update' => false
        ]);
    }
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/step1', [AuthController::class, 'step1']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/register/step2', [AuthController::class, 'step2']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
    Route::get('/messages/{userId}', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);

    // Message Request Routes
    Route::post('/message-requests', [MessageRequestController::class, 'sendRequest']);
    Route::put('/message-requests/{id}/accept', [MessageRequestController::class, 'acceptRequest']);
    Route::put('/message-requests/{id}/reject', [MessageRequestController::class, 'rejectRequest']);
    Route::get('/message-requests/received', [MessageRequestController::class, 'getReceivedRequests']);
    Route::get('/message-requests/sent', [MessageRequestController::class, 'getSentRequests']);
    Route::get('/message-requests/can-message/{userId}', [MessageRequestController::class, 'canMessage']);
    Route::get('/message-requests/accepted', [MessageRequestController::class, 'getAcceptedUsers']);

    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
    Route::get('/active-users', [ProfileController::class, 'getUnblockedUsers']);
    Route::get('/users/{id}', [ProfileController::class, 'getUserById']);
    Route::get('/best-matches', [ProfileController::class, 'getOppositeGenderUsers']);

    // Like Routes
    Route::post('/users/{userId}/like', [LikeController::class, 'likeUser']);
    Route::get('/users/{userId}/liked-by', [LikeController::class, 'getLikedBy']);
    Route::get('/users/{userId}/likes', [LikeController::class, 'getLikes']);
    Route::delete('/users/{userId}/unlike', [LikeController::class, 'unlikeUser']);
});
