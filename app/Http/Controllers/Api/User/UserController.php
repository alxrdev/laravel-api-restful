<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\CreateUserService;
use App\Services\User\ResendUserVerificationEmailService;
use App\Services\User\UpdateUserService;
use App\Services\User\VerifyUserService;
use App\Traits\CollectionListHelpers;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    use CollectionListHelpers;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->sortedFilteredAndPaginatedCollection(User::all(), $request, ['name','created_at'], ['admin'], UserResource::class);
        return $this->paginatedResponse('All users', $users);
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
        return $this->resourceResponse('User created', new UserResource($user), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->resourceResponse('Showing user', new UserResource($user), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User               $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $userResponse = (new UpdateUserService($request, $user))->execute();
        return $this->resourceResponse('User updated.', new UserResource($userResponse), 200);
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
    
    /**
     * Method that verify the user
     * 
     * @param  string  $token
     * @return  \Illuminate\Http\Response
     */
    public function verify(string $token)
    {
        (new VerifyUserService())->execute($token);
        return $this->successResponse('User verified', 201);
    }

    /**
     * Method that resend the user verification email
     * 
     * @param  User  $user
     * @return  \Illuminate\Http\Response
     */
    public function resend(User $user)
    {
        (new ResendUserVerificationEmailService($user))->execute();
        return $this->successResponse('Verification email sended', 201);
    }
}
