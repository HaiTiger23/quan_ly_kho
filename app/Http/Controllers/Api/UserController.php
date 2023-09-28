<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function view() {
        $user = auth('sanctum')->user();
        $user->avatar = asset('storage/images/user/'.$user->avatar);
        return $this->successResponse('Successfully', $user);
    }
    function update(Request $request ) {
        try {
            $request->validate([
                'name' => 'required',
                'date' =>'string|required',
                'address' =>'required',
                'gender' =>'required|string'
            ]);
            $user = auth("sanctum")->user();
            $result = User::where('id', $user->id)->update([
                "name" => $request->name,
                "dia_chi" =>  $request->address,
                "gioi_tinh" => $request->gender,
                "date" => $request->date,
            ]);
            if ($result) {
                return $this->successResponse("Successfully", $result);
            }else {
                return $this->errorResponse("Failed",$result);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse("Error",$th->getMessage());
        }
    }
    function changePassword(Request $request) {
        try {
            $request->validate([
                'old_password' => 'required',
                'password' =>'string|required|confirmed|min:8|max:16',
            ]);

            $user = auth("sanctum")->user();
            if(!Hash::check($request->old_password, $user->password)) {
                return $this->errorResponse("incorrect password");
            }
            $hashPassword = Hash::make($request->password);
            $result = User::where('id', $user->id)->update([
                "password" => $hashPassword,
            ]);
            if ($result) {
                return $this->successResponse("Successfully", $result);
            }else {
                return $this->errorResponse("Failed",$result);
            }
            } catch (\Throwable $th) {
                return $this->errorResponse("Error",$th->getMessage());
        }
    }
}
