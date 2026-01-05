<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();

        // Create default profile if not exists
        if (!$profile) {
            $profile = Profile::create([
                'business_name' => 'ROROO Wedding Make Up',
                'owner_name' => 'Admin',
                'email' => 'admin@roroowedding.com',
                'phone' => '08123456789',
                'address' => 'Alamat Lengkap',
                'banks' => [],
                'social_media' => [
                    'instagram' => '',
                    'facebook' => '',
                    'tiktok' => '',
                    'whatsapp' => '',
                    'website' => '',
                ],
                'description' => 'Deskripsi bisnis',
            ]);
        }

        return view('profile.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'banks' => 'nullable|array',
            'banks.*.bank_name' => 'required|string',
            'banks.*.account_number' => 'required|string',
            'banks.*.account_holder' => 'required|string',
            'social_media' => 'nullable|array',
        ]);

        $profile = Profile::first();

        if ($profile) {
            $profile->update($validated);
        } else {
            Profile::create($validated);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diperbarui');
    }
}
