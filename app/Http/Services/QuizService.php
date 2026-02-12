<?php

namespace App\Http\Services;

use App\Http\Repositories\CompanyRepository;
use App\Http\Repositories\QuizRepository;

class QuizService extends BaseService
{
    public function __construct(private readonly QuizRepository $quizRepository)
    {
        parent::__construct($quizRepository);
    }

    public function index(array $data)
    {
        return $this->quizRepository->index($data);
    }
}
