<!DOCTYPE html>
<html>
<head>
    <title>My To-Do List</title>
</head>

<body>

    <h1>My To-Do List</h1>

    <form action="/todo" method="POST">

        @csrf

        <input
            type="text"
            name="task"
            placeholder="Enter a task"
            required
        >

        <button type="submit">Add</button>

    </form>

    <br>

    <ul>

        @foreach ($todos as $todo)

            <li>
                {{ $todo->task }}

                <button onclick="deleteFromUI(this)">
                    Delete
                </button>
            </li>

        @endforeach

    </ul>

    <script>

        function deleteFromUI(button) {
            button.parentElement.remove();
        }

    </script>

</body>
</html>