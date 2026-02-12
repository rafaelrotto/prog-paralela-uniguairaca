<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\DisciplineRepository;

class DisciplineService extends BaseService
{

    public function __construct(private readonly DisciplineRepository $disciplineRepository)
    {
        parent::__construct($disciplineRepository);
    }

    public function index(array $data)
    {
        return $this->disciplineRepository->index($data);
    }

    public function show(string $id)
    {

        $discilpine = $this->disciplineRepository->show($id);
        $userCompanyId = auth()->user()->company_id;

        if ($discilpine->company_id !== $userCompanyId) {
            abort(403, "Você não tem permissão para acessar essa disciplina.");
        }

        return $discilpine;
    }

    public function update(array $data, string $id)
    {

        $loggedUserId = auth()->user()->id;
        $discipline = $this->disciplineRepository->show($id);

        if ($loggedUserId != $discipline->user_id) {
            abort(403, "Você não tem permissão para editar essa disciplina.");
        }

        return $this->disciplineRepository->update($data, $id);
    }
}
