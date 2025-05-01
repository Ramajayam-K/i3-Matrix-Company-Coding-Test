<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="shortcut icon" href="{{asset('build/assets/image/Application Logo.jpg')}}" type="image/jpg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.0/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.3.0/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.3.0/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <style>
            .backgroundLoarding{
                position: absolute;
                background: #80808024;
                width: 100%;
                height: 100vh;
            }
            .backgroundLoarding img{
                position: absolute;
                top: 45%;
                left: 45%;
                z-index: 9;
                transform: translate(-50px, -50px);
            }
        </style>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script type="text/javascript">
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });


            $(document).ajaxError(function(event,jqxhr,settings){
                if(jqxhr.status==500){
                    swal.fire({
                        icon:'error',
                        text:'A server error occurred. Please refresh the page and try again.',
                        allowotsideClick:false,
                    })
                }else if(jqxhr.status==419){
                    swal.fire({
                        icon:'error',
                        text:'Something went wrong. Please contact the administrator.',
                        allowotsideClick:false,
                    })
                }else{
                    swal.fire({
                        icon:'error',
                        text:jqxhr.responseJSON.message,
                        allowotsideClick:false,
                    })
                }
            })
        </script>

    </head>
    <body class="font-sans antialiased">
        <div class="backgroundLoarding">
            <img src="{{asset('build/assets/image/Loeading Screen.gif')}}"/>
        </div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')


            <!-- Page Content -->
            <main>
                {{ $slot }}
                @stack('scripts')
            </main>
        </div>
    </body>
</html>
