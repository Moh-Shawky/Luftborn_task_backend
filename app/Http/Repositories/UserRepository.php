<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


// this class created to deal with database insted of controller to make controller more readable 



class UserRepository
{

    // this function isn't completed yet as it should generate a token to make user authorized

    public function login($request){
        $validated_data = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);
        if ($validated_data->fails()) {
            return response()->json(['errors' => $validated_data->errors()], 422);
        }
        $validated_data = $validated_data->validated();
        $user = User::where('email',$request->email)->first();
        if(! $user || ! Hash::check($validated_data['password'],$user->password)){
            return response()->json(['errors' => 'Invalid credentials']);
        }
        else {
            $token = $user->createToken('usertoken')->plainTextToken;
            return response()->json(['token' => $token]);


        }


    }

    public function get_all_users()
    {
        $users = User::all();
        return $users;
    }

    public function get_user_by_id($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user;
        }
        return response()->json(['errors' => 'User isn\'t exist'], 422);
    }

    // this is register function

    public function create_user($request)
    {

        // validate the data 
        $validated_data = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:users',
            'password' => 'confirmed|required',
            'role' => 'sometimes'
        ]);
        if ($validated_data->fails()) {
            return response()->json(['errors' => $validated_data->errors()], 422);
        }
        $validated_data = $validated_data->validated();

        // Hash the password
        $validated_data['password'] = Hash::make($validated_data['password']);
    
        // Create the user
        $created_user = User::create($validated_data);

        
        if ($created_user) {
            return $created_user;
        }
        return response()->json(['errors' => 'please try again with valid data']);
    }


    public function update_user($id, $request)
    {

        //get the user which will be updated
        $update_user = User::find($id);


        // if condition for user who enter his email again 
        // and else for user who will change his email 
        // so we want to be sure that new email isn't taken by any existent user

        if ($update_user) {
            if($update_user->email == $request->email){
            $validated_data = validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'role' => 'required'
            ]);
            if ($validated_data->fails()) {
                return response()->json(['errors' => $validated_data->errors()], 422);
            }
            
            $validated_data = $validated_data->validated();

            // update only fields which have a values 
            foreach ($validated_data as $key => $value) {
                $update_user->{$key} = $value;
            }

            $update_user->save();

            return $update_user;
        }
        else{
            $validated_data = validator::make($request->all(), [
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|unique:users',
                'role' => 'required'
            ]);
            if ($validated_data->fails()) {
                return response()->json(['errors' => $validated_data->errors()], 422);
            }
            
            $validated_data = $validated_data->validated();

            foreach ($validated_data as $key => $value) {
                $update_user->{$key} = $value;
            }

            $update_user->save();

            return $update_user;
        }
        }
        return response()->json(['errors' => 'User isn\'t exist'], 422);
    }

    
    public function delete_user($id)
    {

        $user = User::find($id);
        if ($user) {
            $deleted_user = $user->delete();
            if ($deleted_user) {
                return response()->json(['message' => 'user has been deleted successfuly']);
            }
            return response()->json(['errors' => 'please try again']);
        }
        return response()->json(['message' => 'User isn\'t exist']);
    }
}
