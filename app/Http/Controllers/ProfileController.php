<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | Doctor Profile
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('doctor')) {

            $doctor = $user->doctor;

            if (!$doctor) {
                abort(404, 'Doctor profile not found.');
            }

            // Load only the relationships needed by the profile page.
            $doctor->load([
                'patients.user',
                'patients.devices',
                'devices',
            ]);

            $doctor->loadCount([
                'patients',
                'devices',
            ]);

            return view('profile.doctor', [
                'user' => $user,
                'doctor' => $doctor,
                'patients' => $doctor->patients,
                'devices' => $doctor->devices,

                'pageTitle' => 'My Profile',

                'breadcrumbs' => [
                    [
                        'title' => 'My Profile',
                        'url' => route('profile.index'),
                    ],
                ],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Patient Profile
        |--------------------------------------------------------------------------
        */

 
            $patient = $user->patient;

            if (!$patient) {
                abort(404, 'Patient profile not found.');
            }

            $patient->load('devices');

            return view('profile.patient', [
                'user' => $user,
                'patient' => $patient,

                'pageTitle' => 'My Profile',

                'breadcrumbs' => [
                    [
                        'title' => 'My Profile',
                        'url' => route('profile.index'),
                    ],
                ],
            ]);
       

        /*
        |--------------------------------------------------------------------------
        | Admin / Other User
        |--------------------------------------------------------------------------
        */

        // return view('profile.user', [
        //     'user' => $user,
        //     'pageTitle' => 'My Profile',

        //     'breadcrumbs' => [
        //         [
        //             'title' => 'My Profile',
        //             'url' => route('profile.index'),
        //         ],
        //     ],
        // ]);
    }

    /**
     * Display the user's profile edit page.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $doctor = null;
        $patient = null;

        if ($user->hasRole('doctor')) {
            $doctor = $user->doctor;
        } elseif ($user->hasRole('patient')) {
            $patient = $user->patient;
        }

        return view('profile.edit', [
            'user' => $user,
            'doctor' => $doctor,
            'patient' => $patient,
            'pageTitle' => 'Edit Profile',
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.index')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Password changed successfully.');
    }
}
