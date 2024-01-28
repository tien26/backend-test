<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarListRequest;
use App\Http\Resources\CarListResource;
use App\Models\CarList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarListController extends Controller
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

        $car_list = CarList::Search(request('search'))->Filter(request(['status']))->orderBy($sorted_by, $sort)->paginate($limit);

        return $this->paginateResponse(CarListResource::collection($car_list));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarListRequest $request)
    {
        $name_file = null;
        if ($request->file('photo')) {
            $name_file = 'car-' . strtotime(now()) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('car-img', $name_file);
        }

        $input = $request->only(['merk', 'model', 'no_car', 'price', 'photo', 'status']);

        $input['photo'] = $name_file;
        $input['status'] = false;
        $car_list = CarList::create($input);

        return $this->successResponse($car_list, 'created car list success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarList  $carList
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car_list = CarList::find($id);
        if (!$car_list) {
            return $this->errorResponse();
        }
        return $this->successResponse(new CarListResource($car_list));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarList  $carList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car_list = CarList::find($id);
        if (!$car_list) {
            return $this->errorResponse();
        }

        if ($car_list->no_car != $request->input('no_car')) {
            $request->validate([
                'merk' => 'required|string',
                'model' => 'required|string',
                'no_car' => 'required|string|unique:car_lists,no_car',
                'price' => 'required|integer',
                // 'photo' => 'required',
                'status' => 'boolean',
            ]);
        } else {
            $request->validate([
                'merk' => 'required|string',
                'model' => 'required|string',
                'no_car' => 'required',
                'price' => 'required|integer',
                // 'photo' => 'required',
                'status' => 'boolean',
            ]);
        }

        $name_file = $car_list->photo;
        if ($request->file('photo')) {

            $name_file = 'car-' . strtotime(now()) . '.' . $request->file('photo')->getClientOriginalExtension();
            if ($car_list->photo) {
                Storage::delete('car-img/' . $car_list->photo);
            }
            $request->file('photo')->storeAs('car-img', $name_file);
        }

        $input = $request->only(['merk', 'model', 'no_car', 'price', 'photo', 'status']);
        $input['photo'] = $name_file;
        $car_list->update($input);

        return $this->successResponse($car_list, 'updated car list success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarList  $carList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_list = CarList::find($id);
        if (!$car_list) {
            return $this->errorResponse();
        }

        $car_list->destroy($car_list->id);

        return $this->successResponse(new CarListResource($car_list), 'deleted car list success');
    }
}
