<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
    /**
     * Sends a success JSON response to the consumer.
     *
     * @param  string   $message
     * @param  int      $status_code
     * @param  mixed    $data
     * @return JsonResponse
     */
    protected function successResponse($message, $status_code = 200, $data = null)
    {
        return response()
            ->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $status_code);
    }

    /**
     * Sends a error JSON response to the consumer.
     *
     * @param  string   $error_message
     * @param  int      $status_code
     * @param  mixed    $error_details
     * @return JsonResponse
     */
    protected function errorResponse($error_message, $status_code = 400, $error_details = null)
    {
        return response()
            ->json([
                'success' => false,
                'message' => 'Ops! We have an error :(',
                'error_message' => $error_message,
                'error_status_code' => $status_code,
                'error_details' => $error_details
            ], $status_code);
    }

    /**
     * Sends a JSON resources collection response to the consumer.
     *
     * @param  string       $message
     * @param  array        $collection
     * @param  int          $status_code
     * @return JsonResponse
     */
    protected function collectionResponse($message, $collection, $status_code = 200)
    {
        return $this->successResponse($message, $status_code, $collection);
    }

    /**
     * Sends a JSON resource response to the consumer.
     *
     * @param  string   $message
     * @param  Model    $instance
     * @param  int      $status_code
     * @return JsonResponse
     */
    protected function resourceResponse($message, $instance, $status_code = 200)
    {
        return $this->successResponse($message, $status_code, $instance);
    }

    /**
     * Sends a paginated JSON response to the consumer.
     *
     * @param  string   $message
     * @param  int      $status_code
     * @param  mixed    $data
     * @return JsonResponse
     */
    protected function paginatedResponse($message, LengthAwarePaginator $data, $status_code = 200)
    {
        return response()
            ->json(
                array_merge(
                    ['success' => true, 'message' => $message], 
                    $data->toArray()
                ),
                $status_code
            );
    }
}
