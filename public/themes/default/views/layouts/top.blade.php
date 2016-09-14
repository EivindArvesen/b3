<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @if (config('bbb_config.description') !== '')
      <meta name="description" content="{{config('bbb_config.description')}}">
    @endif
    @if (config('bbb_config.user') !== '')
      <meta name="author" content="{{config('bbb_config.user')}}">
    @endif
    <link rel="icon" href="/themes/{{config('bbb_config.theme')}}/assets/favicon.ico">

    <title>{{config('bbb_config.site_name')}} - {{$page_title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/themes/{{config('bbb_config.theme')}}/assets/dist/main.min.231deba104fa1a81.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
