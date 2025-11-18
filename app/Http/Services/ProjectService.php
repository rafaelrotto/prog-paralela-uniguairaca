<?php

namespace App\Http\Services;

use App\Http\Repositories\ProjectRepository;

class ProjectService extends BaseService
{
    public function __construct(private readonly ProjectRepository $projectRepository)
    {
        parent::__construct($projectRepository);
    }

    public function index(array $data)
    {
        return $this->projectRepository->index($data);
    }

    public function find(string $id)
    {
        return $this->projectRepository->find($id);
    }

    public function destroy(string $id)
    {
        return $this->projectRepository->destroy($id);
    }

    public function update(array $data, string $id)
    {
        return $this->projectRepository->update($data, $id);
    }
}
