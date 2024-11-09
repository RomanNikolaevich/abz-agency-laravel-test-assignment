<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function index(): JsonResponse
    {
        $positions = Position::all();

        return $positions->isEmpty()
            ? response()->json(['success' => false, 'message' => 'Positions not found'], 404)
            : response()->json(['success' => true, 'positions' => PositionResource::collection($positions)], 200);
    }
}
