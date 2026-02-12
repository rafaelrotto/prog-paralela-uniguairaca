<?php

namespace App\Http\Repositories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;

class DisciplineRepository extends BaseRepository
{

    public function __construct(Discipline $model)
    {
        parent::__construct($model);
    }

    public function index(array $data)
    {
        $userCompanyId = auth()->user()->company_id; // Pega o company_id do usuário autenticado

        $query = $this->model->where('company_id', $userCompanyId); // Filtra sempre pela empresa do usuário

        if (isset($data['search'])) {
            $query->where('name', 'like', '%' . $data['search'] . '%');
        }

        return isset($data['per_page'])
            ? $query->paginate($data['per_page'])
            : $query->get();
    }
}
