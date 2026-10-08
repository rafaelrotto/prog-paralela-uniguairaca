<?php

namespace App\Jobs;

use App\Http\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessLeadData implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $data)
    {}

    /**
     * Execute the job.
     */
    public function handle(WebhookService $service): void
    {
        Log::info('Job será executado! Dados a serem processados: ' . json_encode($this->data));

        $service->handle($this->data);
    }
}
