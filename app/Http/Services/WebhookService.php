<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    private array $requiredFields = [
        'first_name',
        'last_name',
        'email',
        'source',
        'status'
    ];

    public function handle(array $data)
    {
        Log::info('Dados do usuário: ' . json_encode($data['data']['user']));

        if (!isset($data['data']['user']['email']) || !isset($data['data']['user']['name'])) {
            Log::info('Email ou nome do usuário não informado, retornando sem processar!');

            return;
        }

        if (!isset($data['data']['lead'])) {
            Log::info('Informações do Lead não fornecidas, retornando sem processar!');

            return;
        }

        if (!$this->validateLead($data['data']['lead'])) {
            Log::info('Informações do Lead incompletas, retornando sem processar!');

            return;
        }

        $user = $this->findOrCreateUser($data['data']['user']);

        Log::info('Usuário criado no banco de dados: ' . json_encode($user->toArray()));

        //$lead = $this->findOrCreateLead($data['data']['lead']);
    }

    private function findOrCreateUser(array $user)
    {
        $existingUser = User::query()->where('email', $user['email'])->first();

        if (!$existingUser) {
            $existingUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password')
            ]);
        }

        return $existingUser;
    }

    private function validateLead(array $lead)
    {
        foreach ($this->requiredFields as $field) {
            if (!array_key_exists($field, $lead)) return false;
        }

        return true;
    }

    private function createOrUpdateLead(array $lead)
    {

    }
}