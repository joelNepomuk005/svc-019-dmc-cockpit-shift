<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\UserCategoriesResponse;
use App\UserCategories;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserCategoriesController extends ApiController
{
    /**x
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserCategoriesResponse::collection(QueryBuilder::for(UserCategories::class)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|max:255',
            'deleted_at' => 'nullable',
            'created_at' => 'required',
            'updated_at' => 'required',
        ]);
        $userCategories = UserCategories::create($data);

        return UserCategoriesResponse::make($userCategories);

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $UserCategories = UserCategories::find($id);
        if ($UserCategories == null) {
            return $this->notFoundResponse($id);
        }

        return UserCategoriesResponse::make($UserCategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        //
    }
}
