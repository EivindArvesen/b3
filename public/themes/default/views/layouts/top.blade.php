<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>{{config('bbb_config.site_name')}} - {{$page_title}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/themes/{{config('bbb_config.theme')}}/assets/main.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    {{-- @section('sidebar')
    This is the master sidebar.
    @show --}}

    @if (isset($menu_style) && $menu_style == 'white' && isset($menu_transparent) && $menu_transparent == true)
    <nav class="navbar navbar-default navbar-transparent navbar-fixed-top">
    @elseif (isset($menu_style) && $menu_style == 'white')
    <nav class="navbar navbar-default navbar-fixed-top">
    @elseif (isset($menu_style) && $menu_style == 'black' && isset($menu_transparent) && $menu_transparent == true)
    <nav class="navbar navbar-inverse navbar-transparent navbar-fixed-top">
    @elseif (isset($menu_style) && $menu_style == 'black')
    <nav class="navbar navbar-inverse navbar-fixed-top">
    @else
    <nav class="navbar navbar-inverse navbar-fixed-top">
    @endif
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">{{config('bbb_config.site_name')}}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            @foreach (getMenu() as $menu_element)
              @if ($nav_active==$menu_element->slug)
                <li class="active"><a href="/{{ $menu_element->slug }}">{{ $menu_element->page_title }}</a></li>
              @else
                <li><a href="/{{ $menu_element->slug }}">{{ $menu_element->page_title }}</a></li>
              @endif
            @endforeach
            <?php
            if (config('bbb_config.debug')==True){
              $debug_nav='<li><a href="/debug">DEBUG</a></li>';
              if ($nav_active=="debug")
                $debug_nav=substr_replace($debug_nav, ' class="active"', 3, 0);
              echo '<li class="debug-menu"><a>&nbsp;</a></li>' . $debug_nav;
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
