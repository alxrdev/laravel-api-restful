<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        
        return response()
            ->json([
                'success' => true,
                'message' => 'All users',
                'data' => $users
            ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = bcrypt($request->password);
        $fields['verified'] = User::UNVERIFIED_USER;
        $fields['verification_token'] = User::verificationTokenGenerator();
        $fields['admin'] = User::REGULAR_USER;

        $user = User::create($fields);

        return response()
            ->json([
                'success' => true,
                'message' => 'User created',
                'data' => $user
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()
            ->json([
                'success' => true,
                'message' => 'Showing user',
                'data' => $user
            ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER
        ];

        $this->validate($request, $rules);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::verificationTokenGenerator();
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return response()
                    ->json([
                        'success' => false,
                        'message' => 'Ops! We have an error :(',
                        'error_message' => 'User must be verified to change admin value.',
                        'error_status_code' => 409
                    ], 409);
            }

            $user->admin = $request->admin;
        }

        if (!$user->isDirty()) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Ops! We have an error :(',
                    'error_message' => 'At least one value must be modified to update the user.',
                    'error_status_code' => 409
                ], 409);
        }

        $user->save();

        return response()
            ->json([
                'success' => true,
                'message' => 'User updated.',
                'data' => $user
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()
            ->noContent();
    }
}
