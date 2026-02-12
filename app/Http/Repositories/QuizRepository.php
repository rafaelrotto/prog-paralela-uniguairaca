<?php

namespace App\Http\Repositories;

use App\Models\Quiz;

class QuizRepository extends BaseRepository
{
    public function __construct(Quiz $model)
    {
        parent::__construct($model);
    }

    public function index(array $data)
    {
        $query = $this->model->where(function ($query) use ($data) {
            if (isset($data['discipline_id'])) {
                $query->where('discipline_id', $data['discipline_id']);
            }
        });

        return isset($data['per_page']) ? $query->paginate($data['per_page']) : $query->get();
    }
}
