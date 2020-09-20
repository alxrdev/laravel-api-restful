<?php

namespace App\Http\Controllers\Api\User;

use App\Dtos\User\CreateUserDto;
use App\Dtos\User\UpdateUserDto;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateUserRequest;
use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return $this->collectionResponse('All users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $user = (new CreateUserService())->execute($request);

        return $this->resourceResponse('User created', $user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->resourceResponse('Showing user', $user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $dto = new UpdateUserDto(array_merge($request->all(), ['id' => $id]));
        $user = (new UpdateUserService())->updateUserService->execute($dto);

        return $this->resourceResponse('User updated.', $user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()
            ->noContent();
    }
}
