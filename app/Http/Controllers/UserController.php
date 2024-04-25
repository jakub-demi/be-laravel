<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\UpdateUserProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
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

        return self::sendResponse([], "Profile information was updated.");
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
}
