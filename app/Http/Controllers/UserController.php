<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\CreateUserRequest;
use App\Http\Requests\Form\UpdateUserProfileRequest;
use App\Http\Requests\Form\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Services\ImageService;
use App\Services\UserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserService $userService,
        private readonly ImageService $imageService,
    ){}

    public function user(): JsonResponse
    {
        return self::sendResponse(new UserResource(request()->user()));
    }

    public function updateUserProfile(UpdateUserProfileRequest $request): JsonResponse
    {
        $user = auth()->user();

        if ($request->email !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $request->only('email', 'firstname', 'lastname'));
        } else {
            $input = $request->only('email', 'firstname', 'lastname');

            $user->update([
                'email' => $input['email'],
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
            ]);
        }

        $this->imageService->uploadImage($request, $user, 'avatar', 'profile-avatars', 'profile-avatar');

        return self::sendResponse(new UserResource($user), "Profile information was updated.");
    }

    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

    public function index(): JsonResponse
    {
        return self::sendResponse(UserResource::collection($this->userRepository->getAll()));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        return self::sendResponse(new UserResource($this->userRepository->getById($id)));
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $data = $request->only("firstname", "lastname", "email", "is_admin", "password");

        $user = $this->userService->store($data);
        $resource = new UserResource($user);

        return self::sendResponse($resource, "User '{$user->full_name}' was created.");
    }

    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $data = $request->only("firstname", "lastname", "email", "is_admin", "password");

        $user = $this->userService->update($id, $data);
        $resource = (new UserResource($user));

        return self::sendResponse($resource, "User '{$user->full_name}' was updated.");
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $userFullName = $this->userService->delete($id);

        return self::sendResponse([], "User '{$userFullName}' was removed.");
    }
}
