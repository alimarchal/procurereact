<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\V1\BusinessResource;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->where('user_id', auth()->id())
            ->with('customer')
            ->latest()
            ->paginate(config('pagination.per_page', 15));

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = Project::create([
            ...$request->validated(),
            'user_id' => auth()->id()
        ]);

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Project $project): JsonResponse
    {
        return (new ProjectResource($project))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function update(UpdateProjectRequest $request, Project $project): JsonResponse
    {
        $project->update($request->validated());

        return (new ProjectResource($project->fresh()))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
