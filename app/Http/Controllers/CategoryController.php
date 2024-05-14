<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\CreateCategoryRequest;
use App\Http\Requests\Form\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly CategoryService $categoryService,
    ){}

    public function index(): JsonResponse
    {
        return self::sendResponse(CategoryResource::collection($this->categoryRepository->getAll()));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return self::sendResponse(new CategoryResource($this->categoryRepository->getById($id)));
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $data = $request->only("name");

        $category = $this->categoryService->store($data);
        $resource = new CategoryResource($category);

        return self::sendResponse($resource, "Order Category '{$category->name}' was created.");
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        $data = $request->only("name");

        $category = $this->categoryService->update($id, $data);
        $resource = new CategoryResource($category);

        return self::sendResponse($resource, "Order Category '{$category->name}' was updated.");
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $categoryName = $this->categoryService->delete($id);

        return self::sendResponse([], "Order Category '{$categoryName}' was removed.");
    }
}
