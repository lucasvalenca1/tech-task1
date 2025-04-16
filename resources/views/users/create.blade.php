<!DOCTYPE html>
<html>
<head>
    <title>Create New User</title>
     <style> /* Basic Styles */
        body { font-family: sans-serif; }
        label { display: block; margin-top: 1em; }
        input[type=text], input[type=email], input[type=tel], input[type=password], input[type=file], select { width: 300px; padding: 0.3em; box-sizing: border-box; margin-bottom: 0.5em; }
        button { margin-top: 1.5em; padding: 0.5em 1em; }
    </style>
</head>
<body>
    <h1>Create New User</h1>

     <p>
        <a href="{{ route('users.index') }}">« Back to User List</a>
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

    {{-- Form points to the store route, using POST method --}}
    {{-- ADDED: enctype="multipart/form-data" --}}
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">

        {{-- Include the common form fields from the partial --}}
        {{-- Pass an empty user object (or null) and specify submit button text --}}
        {{-- Pass countries variable if you implemented the dropdown --}}
        @include('users._form', [
            'user' => new \App\Models\User,
            'submitButtonText' => 'Create User',
            'countries' => $countries ?? [] // Pass countries if available
         ])

    </form>

</body>
</html>
