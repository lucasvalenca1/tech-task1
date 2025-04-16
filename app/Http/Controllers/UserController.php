<?php

namespace App\Http\Controllers;

// Import Form Requests
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
// use Illuminate\Http\Request; // No longer needed for store/update
use Illuminate\Support\Facades\Hash; // Still needed if manually hashing (though cast handles it)
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
// use Illuminate\Validation\Rule; // No longer needed here

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::latest()->get();
        $countries = config('countries', []);
        return view('users.index', compact('users', 'countries'));
    }

    public function create(): View
    {
        $countries = config('countries', []);
        return view('users.create', compact('countries'));
    }

    // Type-hint StoreUserRequest - Validation happens automatically
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // Get validated data (already validated by StoreUserRequest)
        $validatedData = $request->validated();

        // Handle file upload if present
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $path;
        }

        // REMOVED: $request->validate() call
        // REMOVED: Manual password hashing (handled by model cast)

        $user = User::create($validatedData);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        $countries = config('countries', []);
        return view('users.edit', compact('user', 'countries'));
    }

    // Type-hint UpdateUserRequest - Validation happens automatically
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // Get validated data (already validated by UpdateUserRequest)
        $validated = $request->validated();

        // Handle password update (only if provided)
        if (!empty($validated['password'])) {
            // REMOVED: Manual password hashing (handled by model cast)
        } else {
            // Important: Ensure password field is NOT included in the update if empty
            unset($validated['password']);
        }

        // Handle file upload update
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validated['profile_picture'] = $path;
        } else {
            // If no new picture uploaded, don't try to update the field
            // (unless you specifically want to allow removing it)
            // We can just let $validated array exclude it if not present in request.
            // If 'profile_picture' key exists in $validated due to form submission
            // but no file was uploaded (e.g., checkbox to remove?), handle here.
            // For now, if no file, $validated won't have the key typically.
        }

        // REMOVED: $request->validate() call

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully!');
    }
}
