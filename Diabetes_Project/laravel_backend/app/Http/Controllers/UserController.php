<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    /**
     * Display user list + form
     */
    public function index()
    {
        $users = User::paginate(15);
        return view('users.index', compact('users'));
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,doctor,patient',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'New user added successfully.');
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,doctor,patient',
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->route('users.index')->with('success', 'User role updated.');
    }

    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        // Optional: Prevent admin from deleting himself
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', "You can't delete your own account.");
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
