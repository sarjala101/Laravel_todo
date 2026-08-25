<!DOCTYPE html>
<html>

<head>
    <title>Edit Todo</title>
</head>

<body>

    <h1>Edit Todo</h1>

    <form action="/todo/{{ $todo->id }}" method="POST">

        @csrf
        @method('PUT')

        <input
            type="text"
            name="task"
            value="{{ $todo->task }}"
            required
        >

        <button type="submit">
            Update
        </button>

    </form>

    <br>

    <a href="/todo">
        Back to Todo List
    </a>

</body>

</html>