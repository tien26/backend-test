<?php

namespace App\Http\Traits;

trait ApiResponse
{
    protected function paginateResponse($data, $message = 'get data success', $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
            'paginate' => [
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
                'current_page' => $data->currentpage(),
                'per_page' => $data->perPage(),
                'last_page' => $data->lastPage(),
                'count' => $data->count(),
                'total' => $data->total(),
            ],
        ], $code);
    }

    protected function successResponse($data, $message = 'get data success', $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function errorResponse($message = 'data not found', $code = 404)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
        ], $code);
    }
}
