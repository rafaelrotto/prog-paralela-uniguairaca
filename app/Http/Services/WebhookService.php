<?php

namespace App\Http\Services;

use App\Jobs\SaveLeadDataJob;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\Lead;
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

        SaveLeadDataJob::dispatch($data['data']['lead']);
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

    public function findOrCreateLead(array $lead)
    {
        $createdLead = Lead::query()->orWhere(function ($query) use ($lead) {
            $query->where('phone', $lead['phone'])
                ->orWhere('email', $lead['email']);
        })->first();

        Log::info('Usuário encontrado no banco de dados: ' . is_null($createdLead) ? '' : json_encode($createdLead->toArray()));

        if (!$createdLead) {
            $company = $this->findOrCreateCompany($lead['company']);

            Log::info('Empresa encontrada no banco de dados: ' . json_encode($company->toArray()));

            $customField = $this->findOrCreateCustomFields($lead['custom_fields']);

            Log::info('Campo personalizado criado: ' . is_null($customField) ? '' :  json_encode($customField->toArray()));

            $createdLead = Lead::create([
                'first_name' =>  $lead['first_name'],
                'last_name' =>  $lead['last_name'],
                'email' =>  $lead['email'],
                'phone' =>  $lead['phone'],
                'company_id' =>  $company->id,
                'job_title' =>  $lead['job_title'],
                'source' =>  $lead['source'],
                'status' =>  $lead['status']
            ]);

            $createdLead->customFields()->attach($customField->id);
        }

        Log::info('Lead criado com sucesso! ' . json_encode($createdLead->toArray()));

        return $lead;
    }

    private function findOrCreateCompany(string $companyName)
    {
        return Company::firstOrCreate(
            ['name' =>  $companyName],
            [
                'name' => $companyName
            ]
        );
    }

    private function findOrCreateCustomFields(?array $customField = null)
    {
        if (!$customField) return null;

        return CustomField::firstOrCreate(
            ['segment' => $customField['segment']],
            [
                'segment' => $customField['segment'],
                'interest' => $customField['interesse']
            ]
        );
    }
}
