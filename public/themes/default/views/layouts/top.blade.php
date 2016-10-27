<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @if (config('b3_config.description') !== '')
      <meta name="description" content="{{config('b3_config.description')}}">
    @endif
    @if (config('b3_config.user') !== '')
      <meta name="author" content="{{config('b3_config.user')}}">
    @endif

    <title>{{config('b3_config.site-name')}} - {{$page_title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/themes/{{config('b3_config.theme')}}/assets/dist/main.min.a5c00c16a8b157e2.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/styles/tomorrow-night.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>

    <!-- Icons -->
    <link rel="icon" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="57x57" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/favicon-16x16.png">
    <link rel="manifest" href="/themes/{{config('b3_config.theme')}}/assets/dist/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/themes/{{config('b3_config.theme')}}/assets/dist/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

  </head>

  <body class="{{ config('b3_config.status') != 'live' ? 'status' : ''}} {{ isset($style) && $style == 'light' ? 'light-bg' : ''}} {{ isset($style) && $style == 'dark' ? 'dark-bg' : ''}} {{ isset($page) && $page->type == 'index' ? 'index-bg' : ''}}"
    @if (isset($bg) && $bg !== '' && $bg !== '0')
      style="background-image: url({{ $bg }}); "
    @endif
  >

    @if (isset($indicator))
        <div class="scroll-line"></div>
    @endif
