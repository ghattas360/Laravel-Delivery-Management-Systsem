<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AdminProfileController extends Controller
{
    public function edit()
    {
        $admin = auth()->user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $validated['name'];

        if ($request->filled('password')) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }



/*    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = Auth::user(); // Make sure user is admin

        if ($admin->photo && Storage::disk('public')->exists($admin->photo)) {
            Storage::disk('public')->delete($admin->photo);
        }

        $path = $request->file('photo')->store('admin_photos', 'public');
        $admin->photo = $path;
        $admin->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile photo updated!');
    }*/

/*    public function uploadPhoto(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $admin = User::findOrFail($id);

        // Delete old image if exists
        if ($admin->photo && Storage::exists($admin->photo)) {
            Storage::delete($admin->photo);
        }

        $path = $request->file('photo')->store('photo', 'public');
        $admin->photo = $path;
        $admin->save();

        return redirect()->route('admin.profile.show', ['id' => $id])->with('success', 'Profile image updated!');
    }*/

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the logged-in admin
        $admin = Auth::user();

        // Delete old image if it exists
        if ($admin->photo && Storage::exists($admin->photo)) {
            Storage::delete($admin->photo);
        }

        // Store the new image in `public/photo`
        $path = $request->file('photo')->store('photo', 'public');

        // Save the new path
        $admin->photo = $path;
        $admin->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profile image updated successfully!');
    }

}
