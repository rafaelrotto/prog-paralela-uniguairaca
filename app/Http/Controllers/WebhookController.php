<?php

namespace App\Http\Controllers;

use App\Http\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function __construct(private WebhookService $service)
    {}

    public function handle(Request $request)
    {
        Log::info('Informações do webhook recebidas no controller' . json_encode($request->all()));

        $this->service->handle($request->all());

        return response()->json(['message' => 'Tudo certo por aqui!'], 202);
    }
}
