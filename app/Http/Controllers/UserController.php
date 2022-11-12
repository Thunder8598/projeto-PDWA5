<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function create(UserRequest $request): JsonResponse
    {
        try {
            if (!empty(User::findByName($request->input("name"))) || !empty(User::findByEmail($request->input("email"))))
                return response()->json(null, Response::HTTP_CONFLICT);

            $user = new User([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "password" => $request->input("pwd")
            ]);

            $user->save();

            return response()->json($user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function edit(UserRequest $request, int $id): JsonResponse
    {
        try {
            $user = User::findById($id);

            if (empty($user))
                return response()->json(null, Response::HTTP_NOT_FOUND);

            $user->fill([
                "name" => $request->input("name"),
                "email" => $request->input("email"),
                "password" => $request->input("pwd")
            ]);

            $user->save();

            return response()->json($user);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request, int $id): Response
    {
        try {
            $user = User::findById($id);

            if (empty($user))
                return response(null, Response::HTTP_NOT_FOUND);

            $user->delete();

            return response(null);
        } catch (Exception $e) {
            report($e);

            return response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
