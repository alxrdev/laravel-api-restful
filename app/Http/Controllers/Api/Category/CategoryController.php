<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\UpdateCategoryService;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->sortedFilteredAndPaginatedCollection(Category::all(), $request, ['name', 'created_at'], [], CategoryResource::class);
        return $this->paginatedResponse('All categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest        $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = (new CreateCategoryService())->execute($request);
        return $this->resourceResponse('Category created.', new CategoryResource($category), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->resourceResponse('Showing category', new CategoryResource($category));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest        $request
     * @param  \App\Models\Category         $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $result = (new UpdateCategoryService())->execute($request, $category);
        return $this->resourceResponse('Category updated.', new CategoryResource($result));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->successResponse('Category deleted.', 204);
    }
}
