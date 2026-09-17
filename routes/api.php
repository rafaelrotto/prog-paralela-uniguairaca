<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/webhook', function(Request $request) {
    Log::info(
        'Webhook recebido. Informações a serem processadas: ' . json_encode($request->all())
    );

    return response()->json(['message' => 'Webhook recebido']);
});
