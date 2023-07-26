<?php

namespace App\Jobs;

use App\Models\Clientes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessLancJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clientId;
    protected $lancamentos;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clientId, array $lancamentos)
    {
        $this->clientId = $clientId;
        $this->lancamentos = $lancamentos;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = Clientes::find($this->clientId);
        $client->lancamentos()->create($this->lancamentos);
    }
}
