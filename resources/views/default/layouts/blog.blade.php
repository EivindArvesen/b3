@include(config('bbb_config.theme') . '.layouts.top')

    <div class="container">

@yield('content')

@include(config('bbb_config.theme') . '.layouts.bottom')
