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
    <link rel="icon" href="/themes/{{config('b3_config.theme')}}/assets/favicon.ico">

    <title>{{config('b3_config.site_name')}} - {{$page_title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/themes/{{config('b3_config.theme')}}/assets/dist/main.min.7320b183e8c16afc.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/styles/tomorrow-night.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.7.0/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
  </head>

  <body class="{{ config('b3_config.status') != 'live' ? 'status' : ''}} {{ isset($style) && $style == 'light' ? 'light-bg' : ''}} {{ isset($style) && $style == 'dark' ? 'dark-bg' : ''}} {{ isset($page) && $page->type == 'index' ? 'index-bg' : ''}}"
    @if (isset($bg) && $bg !== '' && $bg !== '0')
      style="background-image: url({{ $bg }}); "
    @endif
  >
