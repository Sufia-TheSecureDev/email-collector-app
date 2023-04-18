<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.meta')   
    @include('partials.styles')

    {{-- Injectable styles --}}
    @yield('styles')
</head>

<body class="antialiased">
    @include('partials.nav')

    <div class="my-5">
        {{-- Dynamically Injectable Content --}}
        @yield('content')
    </div>

    @include('partials.footer')
    @include('partials.scripts')

    @include('sweetalert::alert')
    <script>
        $(document).ready(function(){
           //confirmation for delation
            $('.delete').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                Swal.fire({
                    title: 'Are You Sure?',
                    text: 'record will be deleted!',
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Delete!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = url;
                        Swal.fire({title: 'Selected Email deleted successfully!', icon: 'success'});
                    }else {
                        Swal.fire({
                            title: 'Operation Cancelled!',
                            icon: 'success'
                        });
                    }
                })
            });
        });
       
        </script>

    {{-- Injectable script --}}
    @yield('scripts')
</body>

</html>