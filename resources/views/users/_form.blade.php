{{-- resources/views/users/_form.blade.php --}}
{{-- This partial contains the common form fields for create and edit --}}
{{-- It expects a $user variable (can be null or an empty User object for create) --}}
{{-- It expects a $countries variable (array of country codes => names) passed from the controller --}}
{{-- It expects a $submitButtonText variable passed from the parent view --}}

@csrf {{-- CSRF Protection --}}

<div>
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    @error('name')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="surname">Surname:</label><br>
    <input type="text" id="surname" name="surname" value="{{ old('surname', $user->surname ?? '') }}" required>
    @error('surname')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    @error('email')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="phone">Phone:</label><br>
    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" required>
    @error('phone')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

{{-- ****** Start of Updated Country Block ****** --}}
<div>
    <label for="country">Country:</label><br>
    {{-- Use a select dropdown --}}
    <select id="country" name="country" required>
        <option value="">-- Select Country --</option>
        {{-- Check if $countries variable exists and is not empty before looping --}}
        @if(isset($countries) && !empty($countries))
            {{-- Loop through countries passed from controller --}}
            @foreach($countries as $code => $name)
                {{-- Pre-select the correct option based on old input or existing user data --}}
                {{-- Use ?? '' to handle case where $user might be a new empty model instance --}}
                <option value="{{ $code }}" {{ old('country', $user->country ?? '') == $code ? 'selected' : '' }}>
                    {{ $name }} ({{ $code }}) {{-- Display name and code --}}
                </option>
            @endforeach
        @else
             {{-- Display a disabled option if no countries were passed (config file issue?) --}}
             <option value="" disabled>No countries configured.</option>
        @endif
    </select>
    {{-- Display validation errors --}}
    @error('country')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>
{{-- ****** End of Updated Country Block ****** --}}


<div>
    <label for="gender">Gender:</label><br>
    {{-- TODO: Replace with radio buttons or select later for better UX/validation --}}
    <input type="text" id="gender" name="gender" value="{{ old('gender', $user->gender ?? '') }}" required>
    @error('gender')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

<hr>

{{-- Profile Picture Upload --}}
<div>
    <label for="profile_picture">Profile Picture:</label><br>
    <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpeg, image/gif">
    @error('profile_picture')
        <div style="color: red;">{{ $message }}</div>
    @enderror

    {{-- Optionally display current image on edit form --}}
    @if (isset($user) && $user->profile_picture)
        <p>Current Picture:</p>
        <img src="{{ Storage::url($user->profile_picture) }}" alt="Current Profile Picture" height="100">
    @endif
</div>

<hr>

{{-- Password fields --}}
<p><i>Leave password fields blank to keep the current password (on edit).</i></p>

<div>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" autocomplete="new-password">
    @error('password')
        <div style="color: red;">{{ $message }}</div>
    @enderror
</div>

<div>
    <label for="password_confirmation">Repeat Password:</label><br>
    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
</div>

{{-- TODO: Add Introduction field later --}}

<hr>

<div>
    {{-- The submit button text will be passed from the parent view --}}
    <button type="submit">{{ $submitButtonText ?? 'Submit' }}</button>
</div>
