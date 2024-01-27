<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowingHistoryRequest;
use App\Http\Resources\BorrowingHistoryResource;
use App\Models\BorrowingHistory;
use Illuminate\Http\Request;

class BorrowingHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ? $request->input('limit') : 10;
        $sorted_by = $request->input('sorted_by') ? $request->input('sorted_by') : 'created_at';
        $sort = $request->input('sort') ? $request->input('sort') : 'desc';
        $borrowing_history = BorrowingHistory::History()->paginate($limit);
        // ->orderBy($sorted_by, $sort)

        return $this->paginateResponse(BorrowingHistoryResource::collection($borrowing_history));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BorrowingHistoryRequest $request)
    {
        $input = $request->only(['loan_id', 'total', 'status']);

        $borrowing_history = BorrowingHistory::create($input);

        return $this->successResponse($borrowing_history, 'created borrowing history success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BorrowingHistory  $borrowingHistory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $borrowing_history = BorrowingHistory::find($id);
        if (!$borrowing_history) {
            return $this->errorResponse();
        }
        return $this->successResponse(new BorrowingHistoryResource($borrowing_history));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BorrowingHistory  $borrowingHistory
     * @return \Illuminate\Http\Response
     */
    public function update(BorrowingHistoryRequest $request, $id)
    {
        $borrowing_history = BorrowingHistory::find($id);
        if (!$borrowing_history) {
            return $this->errorResponse();
        }

        $input = $request->only(['loan_id', 'total']);

        $borrowing_history->update($input);

        return $this->successResponse($borrowing_history, 'updated borrowing history success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BorrowingHistory  $borrowingHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrowing_history = BorrowingHistory::find($id);
        if (!$borrowing_history) {
            return $this->errorResponse();
        }
        $borrowing_history->destroy($borrowing_history->id);

        return $this->successResponse(new BorrowingHistoryResource($borrowing_history), 'deleted borrowing history success');
    }
}
