<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller {
    // Ensure only authenticated users can access this route
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the user's profile page.
     *
     * @return \Illuminate\View\View
     */
    public function showProfilePage() {
        $user = Auth::user();

        return view('profile', ['user' => $user, 'title' => 'Profile']);
    }

    /**
     * Update the user's profile.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'gender' => 'required|string|in:Laki-Laki,Perempuan',
            'phone' => ['nullable', 'string', 'regex:/^08[0-9]{10}$/'],
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'minat' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'phone.regex' => 'Nomor telepon harus diawali dengan "08" dan memiliki panjang maksimal 12 karakter.',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->phone = $request->input('phone');
        $user->birth_date = $request->input('birth_date');
        $user->address = $request->input('address');
        $user->minat = $request->input('minat');
        $user->bio = $request->input('bio');
        if ($request->hasFile('photo')) {
            $extension = $request->photo->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $request->photo->move(public_path('images'), $fileName);
            $user->photo = $fileName;
        }

        $user->save();

        return response()->json(['success' => true, 'message' => 'Profil berhasil diperbarui', 'photo' => $user->photo]);
    }
}
