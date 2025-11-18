<?php

namespace App\Http\Repositories;

use App\Models\Project;

class ProjectRepository extends BaseRepository
{
    public function __construct(private readonly Project $project)
    {
        parent::__construct($project);
    }

    public function builder()
    {
        return auth()->user()->type === 'admin'
            ? $this->model->newQuery()
            : $this->model->where('created_by', auth()->user()->user_id)
            ->andWhere('company_id', auth()->user()->company_id);
    }

    public function index(array $data)
    {

        $query = $this->builder()->where(function ($query) use ($data) {
            if (isset($data['search'])) {
                $query->where('name', 'like', '%' . $data['search'] . '%')
                    ->orWhere('description', 'like', '%' . $data['search'] . '%');
            }

            if (isset($data['project_id'])) {
                $query->where('id', $data['project_id']);
            }
        });

        return isset($data['per_page']) ? $query->paginate($data['per_page']) : $query->get();
    }


    public function find(string $id)
    {
        return $this->builder()->findOrFail($id);
    }

    public function destroy(string $id)
    {
        return $this->builder()->findOrFail($id)->delete();
    }

    public function update(array $data, string $id)
    {
       return $this->builder()->findOrFail($id)->update($data);
    }
}
