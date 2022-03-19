<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserController extends Controller
{
    public function getAll() {
        return response()->json(User::all(), 200);
    }

    public function getByEmail($email) {
        $selectedUser = User::where('email', $email)->first();
        if ($selectedUser) {
            return response()->json($selectedUser, 200);
        } else {
            $response = new stdClass();
            $response->message = 'Data not found';

            return response()->json($response, 400);
        }
    }

    public function create(Request $request) {
        $requestData = $request->all();
        $requestData['password'] = Hash::make($requestData['password']);
        $createdUser = User::create($requestData);
        return response()->json($createdUser, 201);
    }

    public function update(Request $request, $email) {
        $selectedUser = User::where('email', $email)->first();

        $requestData = $request->all();
        $requestData['password'] = Hash::make($requestData['password']);

        $selectedUser->update($requestData);

        return response()->json($selectedUser, 200);
    }

    public function delete($email) {
        $selectedUser = User::where('email', $email)->first();
        if ($selectedUser) {
            $selectedUser->delete();

            return response()->json(null, 200);
        } else {
            $response = new stdClass();
            $response->message = 'Data not found';

            return response()->json($response, 400);
        }
    }
}
