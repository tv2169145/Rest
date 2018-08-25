<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Users = $this->userService->getAllUsers();

        return response()->json(['data' => $Users], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $user = $this->userService->createUser($data);

        return response()->json(['data' => $user], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->getOneUser($id);

        return response()->json(['data' => $user], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->userService->getOneUserORM($id);

        $rules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        ];

        $this->validate($request, $rules);

        $data = $request;

        $user = $this->userService->updateUser($data, $id);

        if($user != null){
            if($user->admin == null){
                return response()->json(['error' => 'only verified users can modify the admin field',
                    'code' => 409],
                    409);
            }
            $user->save();
        }else{
            return response()->json(['error' => 'you need to specify a different value to update',
                'code' => 422],
                422);
        }

        return response()->json(['date' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = $this->userService->getOneUserORM($id);

        $user->delete();

        return response()->json(['date' => $user], 200);

    }
}
