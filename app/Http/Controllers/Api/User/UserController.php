<?php

namespace App\Http\Controllers\Api\User;

use App\Dtos\User\CreateUserDto;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\UpdateUserService;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * The create user service.
     *
     * @var CreateUserService
     */
    protected $createUserService;

    /**
     * The update user service.
     *
     * @var UpdateUserService
     */
    protected $updateUserService;

    public function __construct(CreateUserService $createUserService, UpdateUserService $updateUserService)
    {
        $this->createUserService = $createUserService;
        $this->updateUserService = $updateUserService;
    }

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dto = new CreateUserDto($request->all());
        $user = $this->createUserService->execute($dto);

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
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = $this->updateUserService->execute($request, $id);
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
