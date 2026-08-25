<!DOCTYPE html>
<html>

<head>
    <title>My To-Do List</title>
</head>

<body>

    <h1>My To-Do List</h1>

    <!-- Add Todo -->

    <form action="/todo" method="POST">

        @csrf

        <input
            type="text"
            name="task"
            placeholder="Enter a task"
            required
        >

        <button type="submit">
            Add
        </button>

    </form>

    <br>

    <!-- Todo List -->

    <ul>

        @foreach ($todos as $todo)

            <li>

                {{ $todo->task }}

                <a href="/todo/{{ $todo->id }}/edit">
                    <button type="button">
                        Edit
                    </button>
                </a>

                <form
                    action="/todo/{{ $todo->id }}"
                    method="POST"
                    style="display:inline"
                >

                    @csrf
                    @method('DELETE')

                    <button type="submit">
                        Delete
                    </button>

                </form>

            </li>

        @endforeach

    </ul>

</body>

</html>