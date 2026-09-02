@if(session('success'))

    <div
        data-toast
        data-toast-type="success"
        data-toast-message="{{ session('success') }}"
    ></div>

@endif


@if(session('error'))

    <div
        data-toast
        data-toast-type="error"
        data-toast-message="{{ session('error') }}"
    ></div>

@endif


@if($errors->any())

    @foreach($errors->all() as $error)

        <div
            data-toast
            data-toast-type="error"
            data-toast-message="{{ $error }}"
        ></div>

    @endforeach

@endif