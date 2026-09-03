import Swal from 'sweetalert2';

window.Swal = Swal;

document.addEventListener('DOMContentLoaded', function () {

    // Toast messages
    const toastMessages = document.querySelectorAll('[data-toast]');

    toastMessages.forEach(function (toast) {

        const type = toast.dataset.toastType;
        const message = toast.dataset.toastMessage;

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,

            // Less animation
            showClass: {
                popup: ''
            },
            hideClass: {
                popup: ''
            },

            timer: 3000,
            timerProgressBar: true,

            // Custom colors
            background: '#ffffff',
            color: '#111111'
        });

    });


    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {

            event.preventDefault();

            Swal.fire({
                title: 'Delete this task?',
                //text: 'This task will be moved to the trash.',
                icon: 'warning',
                iconColor: '#dc2626',
                draggable: true,

                width: '400px',

                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',


                // Less animation
                showClass: {
                    popup: ''
                },
                hideClass: {
                    popup: ''
                },

                background: '#ffffff',
                color: '#1f2937',

                confirmButtonColor: '#aa0000',
                cancelButtonColor: '#6b7280'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});