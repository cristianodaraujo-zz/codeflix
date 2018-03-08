<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Push Styles -->
    @stack('styles')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body>
    <div id="app">
        {!!
            Navbar::withBrand(config('app.name'), url('/admin/dashboard'))->withContent(Navigation::links([
                ['link' => url('/admin/users'), 'title' => 'Usuário', 'callback' => function() {
                    return Auth::check();
                }],
                ['link' => url('/admin/categories'), 'title' => 'Categoria', 'callback' => function() {
                    return Auth::check();
                }],
                ['link' => url('/admin/playlists'), 'title' => 'Playlist', 'callback' => function() {
                    return Auth::check();
                }],
                ['link' => url('/admin/videos'), 'title' => 'Vídeo', 'callback' => function() {
                    return Auth::check();
                }],
                [
                    'Venda', [
                        ['link' => route('admin.plans.index'), 'title' => 'Plano'],
                        ['link' => route('admin.web-profiles.index'), 'title' => 'Perfis PayPal'],
                        ['link' => route('admin.subscriptions.index'), 'title' => 'Assinaturas']
                    ]
                ]
            ]))->withContent(Navigation::links([
                [
                    'link' => url('/admin/login'),
                    'title' => 'Login',
                    'callback' => function() {
                        return ! Auth::check();
                    }
                ],
                [
                    (
                        Auth::check()
                            ? Auth::user()->name
                            : "<script>document.getElementsByClassName(\"dropdown\")[0].style.display = 'none';</script>"
                    ),
                    [
                        [
                            'link' => url('/admin/logout'),
                            'title' => 'Logout',
                            'linkAttributes' => [
                                'onclick' => "event.preventDefault(); document.getElementById(\"logout-form\").submit();"
                            ],
                            'callback' => function() {
                                return ! Auth::guest();
                            }
                        ],
                        [
                            'link' => url('/password/change'),
                            'title' => 'Alterar Senha',
                            'callback' => function() {
                                return ! Auth::guest();
                            }
                        ]
                    ]
                ]
            ])->right())
        !!}

        {!!
            form(FormBuilder::plain([
                'route' => ['admin.logout'],
                'method' => 'post',
                'class' => 'hidden',
                'id' => "logout-form"
            ]))
        !!}

        @if (Session::has('success'))
            <div class="container">
                {!! Alert::success(Session::get('success'))->close() !!}
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
