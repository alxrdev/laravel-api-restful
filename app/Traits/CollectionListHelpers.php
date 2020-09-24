<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

trait CollectionListHelpers
{
    /**
     * Method that returns a sorted and filtered and paginated collection
     * 
     * @param  Collection $collection
     * @param  Request $request
     * @param  array $sortFields
     * @param  array $filterFields
     * @param  string $responseClass
     * @return  LengthAwarePaginator
     */
    protected function sortedFilteredAndPaginatedCollection(Collection $collection, Request $request, array $sortFields, array $filterFields, string $responseClass = null) : LengthAwarePaginator
    {
        return $this->paginateCollection(
            $this->sortedAndFilteredCollection($collection, $request, $sortFields, $filterFields),
            $request,
            $responseClass
        );
    }

    /**
     * Method that returns a sorted and filtered 
     * 
     * @param  Collection $collection
     * @param  Request $request
     * @param  array $sortFields
     * @param  array $filterFields
     * @return  Collection
     */
    protected function sortedAndFilteredCollection(Collection $collection, Request $request, array $sortFields, array $filterFields) : Collection
    {
        return $this->sortCollection(
            $this->filterCollection(
                $collection,
                $request,
                $filterFields
            ),
            $request,
            $sortFields
        );
    }

    /**
     * Method that returns sorted collection
     * 
     * @param  Collection $collection
     * @param  Request $request
     * @param  array $allowedFields
     */
    protected function sortCollection(Collection $collection, Request $request, array $allowedFields) : Collection
    {
        if (!$request->sort_by || array_search($request->sort_by, $allowedFields) === false) {
            return $collection;
        }

        return $collection->sortBy->{$request->sort_by};
    }

    /**
     * Method that returns a filtered collection
     * 
     * @param  Collection $collection
     * @param  Request $request
     * @param  array $allowedFields
     */
    protected function filterCollection(Collection $collection, Request $request, array $allowedFields) : Collection
    {
        foreach ($request->query() as $field => $value) {
            if (array_search($field, $allowedFields) !== false) {
                $collection = $collection->where($field, $value);
            }
        }

        return $collection;
    }

    /**
     * Method that returns a paginated collection
     * 
     * @param  Collection $collection
     * @param  Request $request
     * @param  string $responseClass
     * @return  LengthAwarePaginator
     */
    protected function paginateCollection(Collection $collection, Request $request, string $responseClass = null) : LengthAwarePaginator
    {
        $page = $request->page ?? 1;
        $perPage = $request->per_page ?? 15;
        
        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $results = ($responseClass)
            ? call_user_func_array(
                array($responseClass, 'collection'),
                [$results]
                )
            : $results;

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        $paginated->appends($request->all());

        return $paginated;
    }
}
