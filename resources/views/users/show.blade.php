<!DOCTYPE html>
<html>
<head>
    <title>View User: {{ $user->name }} {{ $user->surname }}</title>
    {{-- Basic styling could be added here or via CSS file --}}
    <style>
        body { font-family: sans-serif; }
        table { border-collapse: collapse; margin-bottom: 1em; }
        th, td { border: 1px solid #ccc; padding: 0.5em; text-align: left; }
        th { background-color: #f0f0f0; }
        .actions a, .actions button { margin-right: 5px; }
        .actions form { display: inline; }
    </style>
</head>
<body>
    <h1>User Details</h1>

    <p>
        <a href="{{ route('users.index') }}">« Back to User List</a>
    </p>

    <table>
        <tr>
            <th>ID</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $user->name }}</td> {{-- Test checks for this --}}
        </tr>
        <tr>
            <th>Surname</th>
            <td>{{ $user->surname }}</td> {{-- Test checks for this --}}
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $user->email }}</td> {{-- Test checks for this --}}
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $user->phone }}</td> {{-- Test checks for this --}}
        </tr>
        <tr>
            <th>Country</th>
            <td>{{ $user->country }}</td> {{-- Test checks for this --}}
        </tr>
        <tr>
            <th>Gender</th>
            <td>{{ $user->gender }}</td> {{-- Test checks for this --}}
        </tr>
        <tr>
            <th>Joined</th>
            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>
        {{-- Add selfie/introduction fields here later if needed --}}
        {{-- <tr><th>Selfie</th><td>...</td></tr> --}}
        {{-- <tr><th>Introduction</th><td>...</td></tr> --}}
    </table>

    <div class="actions">
        {{-- Link to the edit form (uses the user's ID) --}}
        <a href="{{ route('users.edit', $user->id) }}">Edit User</a>

        {{-- Form for deleting the user --}}
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf {{-- CSRF protection --}}
            @method('DELETE') {{-- Specify DELETE HTTP method --}}
            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')">Delete User</button>
        </form>
    </div>

</body>
</html>
