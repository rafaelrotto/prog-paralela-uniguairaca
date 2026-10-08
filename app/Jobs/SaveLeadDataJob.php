<?php

namespace App\Jobs;

use App\Http\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class SaveLeadDataJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(private array $lead)
    {
        $this->onQueue('save-lead');
    }

    /**
     * Execute the job.
     */
    public function handle(WebhookService $service): void
    {
        $service->findOrCreateLead($this->lead);
    }
}
