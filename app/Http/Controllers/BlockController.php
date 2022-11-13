<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlockRequest;
use App\Models\Block;
use App\Models\Menu;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BlockController extends Controller
{
    public function create(BlockRequest $request, string $permalink): JsonResponse
    {
        $user = auth("sanctum")->user();

        try {
            $menu = Menu::findByPermalinkAndUser($permalink, $user->id);

            $block = new Block([
                "user" => $user->id,
                "menu" => $menu->id,
                "text" => $request->input("text")
            ]);

            $block->save();

            return response()->json($block, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->json(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
