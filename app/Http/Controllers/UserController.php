<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        //$users = User::all(); // Retrieve all users
        $users = User::paginate(10); // 10 users per page
        //return view('users.index', compact('users'));
        return view('users.index', ['users' => $users]);
    }
    
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'prefixname' => 'required|string|in:Mr.,Mrs.,Ms.',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'suffixname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public'); // Store the file in the 'photos' directory under 'public'
        }

        $user = User::create([
            'prefixname' => $validatedData['prefixname'],
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'middlename' => $validatedData['middlename'],
            'suffixname' => $validatedData['suffixname'],
            'username' => $validatedData['username'],
            'photo' => $photoPath,
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Summary of update
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return mixed
     * Note:
     * Ensures that the email is unique in the users table, 
     * but excludes the current user's email (whose ID is $user->id) from this uniqueness check.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'prefixname' => 'required|string|in:Mr.,Mrs.,Ms.',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'middlename' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'suffixname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                \Storage::delete('public/' . $user->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    } 
    
    public function trashed()
    {
        // Retrieve only soft-deleted users
        $users = User::onlyTrashed()->get(); 
        return view('users.trashed', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.trashed')->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
    }
}
