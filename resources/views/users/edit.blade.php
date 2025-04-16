<!DOCTYPE html>
<html>
<head>
    <title>Edit User: {{ $user->name }}</title>
    <style> /* Basic Styles */
        body { font-family: sans-serif; }
        label { display: block; margin-top: 1em; }
        input[type=text], input[type=email], input[type=tel], input[type=password], input[type=file], select { width: 300px; padding: 0.3em; box-sizing: border-box; margin-bottom: 0.5em;}
        button { margin-top: 1.5em; padding: 0.5em 1em; }
        img { max-width: 100%; height: auto; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>Edit User: {{ $user->name }} {{ $user->surname }}</h1>

    <p>
        <a href="{{ route('users.show', $user->id) }}">« Back to View User</a> |
        <a href="{{ route('users.index') }}">Back to User List</a>
    </p>

     {{-- Display validation errors if any --}}
     @if ($errors->any())
        <div style="color: red; margin-bottom: 1em;">
            <strong>Whoops! Something went wrong.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
     @endif

    {{-- Form points to the update route, using PUT method --}}
     {{-- ADDED: enctype="multipart/form-data" --}}
    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT') {{-- Specify PUT HTTP method for update --}}

        {{-- Include the common form fields from the partial --}}
        {{-- Pass the existing $user object and specify submit button text --}}
         {{-- Pass countries variable if you implemented the dropdown --}}
        @include('users._form', [
            'user' => $user,
            'submitButtonText' => 'Update User',
            'countries' => $countries ?? [] // Pass countries if available
        ])

    </form>

</body>
</html>
