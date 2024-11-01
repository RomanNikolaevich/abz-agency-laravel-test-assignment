<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\ImageProcessingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\ImageProcessing\ImageProcessorService;
use App\Services\ImageProcessing\Strategies\UploadedImageSourceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::paginate(6);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $userStoreData = $request->validated();

        $imageProcessor = new ImageProcessorService(new UploadedImageSourceService($request->file('photo')));

        try {
            $userStoreData['photo'] = $imageProcessor->processAndStoreImage();
        } catch (ImageProcessingException $e) {
            Log::error('Image processing error: ' . $e->getMessage());

            return response()->json(['error' => 'Error processing image'], 500);
        }

        $user = User::create($userStoreData);


        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $userUpdateData = $request->validated();

        if ($request->hasFile('photo')) {
            $imageProcessor = new ImageProcessorService(
                new UploadedImageSourceService($request->file('photo'))
            );

            try {
                $userUpdateData['photo'] = $imageProcessor->processAndStoreImage();
            } catch (ImageProcessingException $e) {
                Log::error('Image processing error: ' . $e->getMessage());

                return response()->json(['error' => 'Error processing image'], 500);
            }
        }

        $user->update($userUpdateData);


        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
