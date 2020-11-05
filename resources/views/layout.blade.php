<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Classlife</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="antialiased">
    <div id="app" class="container-fluid" style="margin-top: 30px">

        <div class="card">
            <div class="card-header">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{ route('web.sessions') }}" role="button"
                        class="btn btn-danger mx-1 {{ Route::current()->getName() == 'web.sessions' ? 'active' : '' }}">Sesiones</a>
                    <a href="{{ route('web.calendar') }}" role="button"
                        class="btn btn-danger mx-1 {{ Route::current()->getName() == 'web.calendar' ? 'active' : '' }}">Calendario</a>
                    <a href="{{ route('web.students') }}" role="button"
                        class="btn btn-danger mx-1 {{ Route::current()->getName() == 'web.students' ? 'active' : '' }}">Alumnos</a>
                </div>
            </div>

            <div class="card-body">

                @yield('content')

            </div>
        </div>


        {{-- <example-component></example-component> --}}

    </div>

    {{--  JQuery, Boostrap, VueJS  --}}
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
