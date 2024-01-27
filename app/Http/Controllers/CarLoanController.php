<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarLoanRequest;
use App\Http\Resources\CarLoanResource;
use App\Models\CarLoan;
use Illuminate\Http\Request;

class CarLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ? $request->input('limit') : 10;
        // $sorted_by = $request->input('sorted_by') ? $request->input('sorted_by') : 'created_at';
        $sort = $request->input('sort') ? $request->input('sort') : 'desc';

        $car_loan = CarLoan::RelationLoan(request('search'))->paginate($limit);
        // ->orderBy($sorted_by, $sort)

        return $this->paginateResponse(CarLoanResource::collection($car_loan));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarLoanRequest $request)
    {
        $input = $request->only(['car_id', 'user_id', 'no_loan', 'start_date', 'end_date', 'status']);

        $input['no_loan'] = 'CAR-' . strtotime(now());
        $car_loan = CarLoan::create($input);

        return $this->successResponse($car_loan, 'created car loan success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarLoan  $carLoan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car_loan = CarLoan::find($id);
        if (!$car_loan) {
            return $this->errorResponse();
        }
        return $this->successResponse(new CarLoanResource($car_loan));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarLoan  $carLoan
     * @return \Illuminate\Http\Response
     */
    public function update(CarLoanRequest $request, $id)
    {
        $car_loan = CarLoan::find($id);
        if (!$car_loan) {
            return $this->errorResponse();
        }
        $input = $request->only(['car_id', 'user_id', 'no_loan', 'start_date', 'end_date', 'status']);

        $input['no_loan'] = $car_loan->no_loan;
        $car_loan->update($input);

        return $this->successResponse($car_loan, 'updated car loan success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarLoan  $carLoan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_loan = CarLoan::find($id);
        if (!$car_loan) {
            return $this->errorResponse();
        }
        $car_loan->destroy($car_loan->id);

        return $this->successResponse(new CarLoanResource($car_loan), 'deleted car loan success');
    }
}
