@if(session('success'))
    <script>
        Swal.fire('Success', '{{ session('success') }}', 'success');
    </script>
@endif

@if(session('info'))
    <script>
        Swal.fire('Info', '{{ session('info') }}', 'info');
    </script>
@endif

@if(session('warning'))
    <script>
        Swal.fire('Warning', '{{ session('warning') }}', 'warning');
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire('Error', '{{ session('error') }}', 'error');
    </script>
@endif