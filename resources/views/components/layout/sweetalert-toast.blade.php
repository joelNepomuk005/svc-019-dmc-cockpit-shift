@if (@$errors->any())
    <script>
        $(function(){
            @foreach ($errors->all() as $error)
                SwalToast.fire({
                    icon: 'error',
                    title: '{{ $error }}'
                });
            @endforeach
        });
    </script>
@endif
