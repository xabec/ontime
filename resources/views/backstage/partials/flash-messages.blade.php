<script>

    @if( Session::has('success') )
        swal.fire({
            title: "Valio!",
            text: "{{ Session::get('success') }}",
            timer: 5000,
            button: false,
            icon: 'success'
        });
    @endif

    @if( Session::has('error') )
    swal.fire({
        title: "Ojojoj!",
        text: "{{ Session::get('error') }}",
        timer: 5000,
        button: false,
        icon: 'error'
    });
    @endif

</script>
