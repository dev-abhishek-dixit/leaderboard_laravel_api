<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Jobs\GenerateQrCodeJob;

/**
 * UserController
 * 
 * @package    App\Http\Controllers
 * @subpackage Controllers
 * @author     Abhishek Dixit<abhishekdixit342@gmail.com>
 * 
 */

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = app(UserService::class)->getAllUsers();
        return UserResource::collection($users)
               ->additional(['msg' => 'Users list retrieved successfully']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = app(UserService::class)->getUserById($id);
        if ($user) {
            return new UserResource($user, 'User retrieved successfully');
        }
        return  new UserResource(null, 'User not found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->validated();
        $user = app(UserService::class)->createUser($data);
        if ($user) {
             GenerateQrCodeJob::dispatch($user)->delay(now()->addSeconds(10));
        }
        return new UserResource($user, 'User created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $user = app(UserService::class)->updateUser($id, $data);
        if ($user) {
            if (request()->has('points')) {
                $usersList = app(UserService::class)->getAllUsers($filter = False);
                return UserResource::collection($usersList)
                       ->additional(['msg' => 'User updated successfully']);
            }else{
                return new UserResource($user, 'User updated successfully');
            }
        }
        return  new UserResource(null, 'User not found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = app(UserService::class)->deleteUser($id);
        if ($user) {
            return new UserResource(null, 'User deleted successfully');
        }
        return  new UserResource(null, 'User not found');
    }
    /**
     * Get the points of user grouping them by points.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupPoints()
    {
       $points = app(UserService::class)->groupPoints();
       if ($points) {
            return response()->json([
                'data' => $points,
                'message' => 'Points grouped successfully'
            ]);
        }
        return  response()->json([
            'data' => [],
            'message' => 'No points found'
        ]);
    }
}
