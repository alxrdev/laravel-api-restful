<?php

namespace App\Http\Controllers\Api\Category;

use App\Dtos\Category\UpdateCategoryDto;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Models\Category;
use App\Services\Category\CreateCategoryService;
use App\Services\Category\UpdateCategoryService;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return $this->collectionResponse('All categories', $categories);
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
        return $this->resourceResponse('Category created.', $category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->resourceResponse('Showing category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $dto = new UpdateCategoryDto(array_merge($request->all(), ['category' => $category]));
        $result = (new UpdateCategoryService())->updateCategoryService->execute($dto);

        return $this->resourceResponse('Category updated.', $result);
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
