@if (isset($style) && $style == 'white')
    <nav class="navbar navbar-default {{ isset($menu_transparent) && $menu_transparent == true ? 'navbar-transparent' : '' }} {{ !isset($menu_sticky) ? 'navbar-fixed-top' : '' }} {{ isset($menu_seamless) ? 'navbar-seamless' : '' }}">
    @else
    <nav class="navbar navbar-inverse {{ isset($menu_transparent) && $menu_transparent == true ? 'navbar-transparent' : '' }} {{ !isset($menu_sticky) ? 'navbar-fixed-top' : '' }} {{ isset($menu_seamless) ? 'navbar-seamless' : '' }}">
    @endif
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">{{config('b3_config.site-name')}}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            @foreach (getMenu() as $menu_element)
              @if (isset($nav_active) && $nav_active==$menu_element->slug)
                <li class="active"><a href="/{{ $menu_element->slug }}">{{ $menu_element->page_title }}</a></li>
              @else
                <li><a href="/{{ $menu_element->slug }}">{{ $menu_element->page_title }}</a></li>
              @endif
            @endforeach
            <?php
            if (config('b3_config.debug')==True){
              $debug_nav='<li><a href="/debug">DEBUG</a></li>';
              if (isset($nav_active) && $nav_active=="debug")
                $debug_nav=substr_replace($debug_nav, ' class="active"', 3, 0);
              echo '<li class="debug-menu"><a>&nbsp;</a></li>' . $debug_nav;
            }
            ?>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
