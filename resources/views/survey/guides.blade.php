
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('vendor/stisla-2.2.0/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/stisla-2.2.0/assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/stisla-2.2.0/assets/modules/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/stisla-2.2.0/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/stisla-2.2.0/assets/css/components.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/modules/jquery.min.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/modules/popper.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/modules/tooltip.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/modules/bootstrap/js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/modules/nicescroll/jquery.nicescroll.min.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/modules/moment.min.js') }}" defer></script>
    <script src="{{ asset('vendor/stisla-2.2.0/assets/js/stisla.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @livewireScripts
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @include('layouts.navigation')
            @include('layouts.side-navigation')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    {{ $header ?? '' }}

                    <div class="section-body">
                        <div>
                            <x-slot name="header">
                                <div class="section-header">
                                    <h1>Petunjuk</h1>
                                </div>
                            </x-slot>
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{$content->title}}</h4>
                                </div>
                                <div class="card-body">
                                    <p>{{$content->content}}</p>
                                    This user have role
                                    <div class="form-group row mb-0 mt-3">
                                        <div class="col-md-6">
                                            <a href="{{Route('test')}}" class="btn btn-primary" name="aksi" value="simpan">
                                                Mulai Test
                                            </a>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    <small class="text-muted">Laravel Breeze + Stisla by Fahmi Jabbar ©2022</small>
                </div>
            </footer>

        </div>
        <script src="{{ asset('vendor/stisla-2.2.0/assets/js/scripts.js') }}" defer></script>
</body>

</html>
