<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    /**
     * Show invitation acceptance form.
     */
    public function accept($token)
    {
        $user = User::where('invitation_token', $token)->first();

        if (!$user) {
            return view('auth.invitation_invalid'); // create a simple "Invalid or expired link" view
        }

        return view('auth.invitation_accept', compact('user', 'token'));
    }

    /**
     * Handle form submission for accepting invitation.
     */
    public function acceptSubmit(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('invitation_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid or expired invitation token.');
        }

        // Activate account and set password
        $user->update([
            'password' => Hash::make($request->password),
            'invitation_token' => null, // clear the token
            'is_active' => true,
        ]);

        return redirect()->route('login')->with('success', 'Your account has been activated. You can now log in.');
    }
}
