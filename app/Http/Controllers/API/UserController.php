<?php

namespace App\Http\Controllers\API;

use App\Models\User;

use App\Services\UserService;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    
    public function index()
    {        
        $Users = $this->userService->allUser();
        return response()->json([
            'status' => 200,
            'Users' => $Users
        ]);
    }

    public function store(UserRequest $request)
    {
        $UserData = $request->validated();
        $Users = $this->userService->createUser($UserData);
        
        return response()->json([
            'status' => 201,
            'Users' => $Users,
            'message'=> 'Created Successfully'
        ]);
    }


    public function update(UserRequest $request, $UserId)
    {          
        $UserData = $request->validated();
        $Users = $this->userService->updateUser($UserId, $UserData);

        return response()->json([
            'status' => 200,
            'Users' => $Users,
            'message'=> 'Updated successfully'
        ]);
    }


    public function destroy($UserId)
    {
        $Users = $this->userService->deleteUser($UserId);
       
        return response()->json([
            'status' => 200,
            'Users' => $Users,
            'message'=> 'Deleted Successfully'
        ]);
    }
}


