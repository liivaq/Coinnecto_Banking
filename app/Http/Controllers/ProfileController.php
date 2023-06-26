<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function dashboard()
    {
        $account = auth()->user()->accounts()->first();
        $transactions = $account->transactions()->latest()->take(3)->get();

        return view('dashboard', [
            'account' => $account,
            'transactions' => $transactions
        ]);
    }

    public function edit(Request $request): View
    {
        $google2fa = app('pragmarx.google2fa');

        $QR_Image = $google2fa->getQRCodeInline(
            $request->user()->name,
            $request->user()->email,
            $request->user()->google2fa_secret
        );

        return view('profile.edit', [
            'name' => 'QR',
            'image' => $QR_Image,
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
