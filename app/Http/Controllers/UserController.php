<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use stdClass;

class UserController extends Controller
{
    public function getAll() {
        return response()->json(User::all(), 200);
    }

    public function getById($id) {
        $selectedUser = User::find($id);
        if ($selectedUser) {
            return response()->json($selectedUser, 200);
        } else {
            $response = new stdClass();
            $response->message = 'Data not found';

            return response()->json($response, 400);
        }
    }

    public function create(Request $request) {
        $createdUser = User::create($request->all());
        return response()->json($createdUser, 201);
    }

    public function update(Request $request, $id) {
        $selectedUser = User::find($id);
        $selectedUser->update($request->all());

        return response()->json($selectedUser, 200);
    }

    public function delete($id) {
        $selectedUser = User::find($id);
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
