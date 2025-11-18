<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function __construct(private readonly ProjectService $projectService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->projectService->index($request->all());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->user_id;
        $data['company_id'] = auth()->user()->company_ud;

        return response()->json([
            'message' => 'Projeto criado com sucesso.',
            'data' => $this->projectService->store($data)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
            return response()->json(['data' => $this->projectService->find($id)]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, string $id)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->user_id;
        $data['company_id'] = auth()->user()->company_ud;

        return response()->json(['data' => $this->projectService->update($data, $id)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->projectService->destroy($id);
        return response()->noContent();
    }
}
