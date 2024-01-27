<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailRequest;
use App\Http\Resources\UserDetailResource;
use App\Models\CarLoan;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDetailController extends Controller
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
        $user_detail = UserDetail::Filter(['user'])->orderBy($sorted_by, $sort)->paginate($limit);

        return $this->paginateResponse(UserDetailResource::collection($user_detail));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserDetailRequest $request)
    {
        $name_file = null;
        if ($request->file('photo')) {
            $name_file = 'user-' . strtotime(now()) . '.' . $request->file('photo')->getClientOriginalExtension();
            $request->file('photo')->storeAs('user-img', $name_file);
        }

        $input = $request->only(['user_id', 'name', 'phone', 'sim', 'photo']);
        $input['photo'] = $name_file;
        $user_detail = UserDetail::create($input);

        return $this->successResponse($user_detail, 'created user detail success', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_detail = UserDetail::find($id);
        if (!$user_detail) {
            return $this->errorResponse();
        }
        return $this->successResponse(new UserDetailResource($user_detail));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UserDetailRequest $request, $id)
    {
        $user_detail = UserDetail::find($id);
        if (!$user_detail) {
            return $this->errorResponse();
        }

        $name_file = $user_detail->photo;
        if ($request->file('photo')) {

            $name_file = 'user-' . strtotime(now()) . '.' . $request->file('photo')->getClientOriginalExtension();
            if ($user_detail->photo) {
                Storage::delete('user-img/' . $user_detail->photo);
            }
            $request->file('photo')->storeAs('user-img', $name_file);
        }

        $input = $request->only(['user_id', 'name', 'phone', 'sim', 'photo']);
        $input['photo'] = $name_file;
        $user_detail->update($input);

        return $this->successResponse($user_detail, 'updated user detail success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserDetail  $userDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_detail = UserDetail::find($id);
        if (!$user_detail) {
            return $this->errorResponse();
        }

        $user_detail->destroy($user_detail->id);

        return $this->successResponse(new UserDetailResource($user_detail), 'deleted user detail success');
    }
}
