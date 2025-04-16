<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    {{-- Add basic styling later if needed --}}
</head>
<body>
    <h1>User List</h1>

    {{-- Display success message if flashed from controller --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add a link to create a new user --}}
    <p>
        <a href="{{ route('users.create') }}">Create New User</a>
    </p>

    {{-- Check if there are any users --}}
    @if ($users->count() > 0)
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Country</th>
                    <th>Gender</th>
                    <th>Actions</th> {{-- For View/Edit/Delete links later --}}
                </tr>
            </thead>
            <tbody>
                {{-- Loop through the $users collection passed from the controller --}}
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td> {{-- Displaying name --}}
                        <td>{{ $user->surname }}</td>
                        <td>{{ $user->email }}</td> {{-- Displaying email --}}
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->country }}</td>
                        <td>{{ $user->gender }}</td>
                        <td>
                            {{-- Add links for Show, Edit, Delete later --}}
                             <a href="#">View</a> |
                             <a href="#">Edit</a> |
                             <a href="#">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No users found.</p>
    @endif

</body>
</html>
