<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\AdminUpdateRequest;
use App\Http\Requests\Web\PasswordUpdateRequest;
use App\Models\User;
use App\Services\AdminProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Appus\Admin\Messages\Facades\Message;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.index', compact('user'));
    }

    public function store(AdminUpdateRequest $request)
    {
        $user = Auth::user();

        $user->fill($request->only('first_name', 'last_name', 'email', 'phone'));

        $avatar = $request->get('avatar');

        if ($avatar) {
            if ($user->avatar) {
                Storage::delete($user->avatar);
            }
            $image = AdminProfileService::getPuthAvatar($avatar);

            $imageName = Str::random(15) . '.png';
            Storage::put('uploads/' . $imageName, base64_decode($image));

            $user->avatar = 'uploads/' . $imageName;
        }
        $user->save();
        Message::success('User profile was successfully updated!');

        return redirect()->back();
    }

    public function edit()
    {
        $user = Auth::user();

        return view('user.edit', compact('user'));
    }

    public function changePassword(PasswordUpdateRequest $request)
    {
        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update(['password'=> Hash::make($request->password)]);
            Message::success('User profile was successfully updated!');

            return redirect()->back();
        }

        Message::warning('Current password is incorrect');

        return redirect()->back();
    }
}
