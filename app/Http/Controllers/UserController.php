<?php

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Jobs\SendUserEmail;
use Illuminate\Http\Request;



class UserController extends Controller
{

    // using construct to create object from User Repository class

    protected $UserRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->UserRepository = $userRepository;
    }
    
    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->UserRepository = $userRepository;
    // }
    public function login(Request $request)
    {
        $login_user = $this->UserRepository->login($request);
        return $login_user;
    }
    public function index()
    {
        $users = $this->UserRepository->get_all_users();
        return $users;
    }
    public function show($id)
    {
        $user = $this->UserRepository->get_user_by_ID($id);
        return $user;
    }
    public function store(Request $request)
    {
        $created_user = $this->UserRepository->create_user($request);
        return $created_user;
    }
    public function update($id, Request $request)
    {
        $updated_user = $this->UserRepository->update_user($id, $request);
        return $updated_user;
    }
    public function destroy($id)
    {
        $deleted_user = $this->UserRepository->delete_user($id);
        return $deleted_user;
    }



    
    public function send_email()
    {
        $users = $this->UserRepository->get_all_users();
        foreach ($users as $user) {
            dispatch(new SendUserEmail ($user));
        }
        return response()->json(['message' => 'Emails sent successfully']);
    }
}
