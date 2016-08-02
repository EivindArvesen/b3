@include('layouts.top')

    <div class="container">

      <!--
      <div class="row">
        <div class="col-sm-12">
          <h1 class="blog-title">Blog</h1>
          <p class="lead">Description...</p>
        </div>
      </div>
      -->

      <div class="row">

@yield('content')

      <div class="col-md-3 col-md-offset-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <form action="/blog/search" method="GET">
              <div class="input-group">
                <input id="blog-search-field" type="text" name="query" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                  <button id="blog-search" class="btn btn-default" aria-label="search" value="Submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
              </div><!-- /input-group -->
            </form>
          </div>
          <div class="sidebar-module">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>
          <div class="sidebar-module">
            <h4>Languages</h4>
            <ol class="list-unstyled">
              @foreach ($sidebar['languages'] as $language)
                <li><a href="/blog/language/{{$language}}"><?=ucfirst($language)?></a></li>
              @endforeach
              <li><a href="/blog/language">More...</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Categories</h4>
            <ol class="list-unstyled">
              @foreach ($sidebar['categories'] as $category)
                <li><a href="/blog/category/{{$category}}"><?=ucfirst($category)?></a></li>
              @endforeach
              <li><a href="/blog/category">More...</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Tags</h4>
            <ol class="list-unstyled">
              @foreach ($sidebar['tags'] as $tag)
                  <li><a href="/blog/tag/{{$tag}}"><?=ucfirst($tag)?></a></li>
              @endforeach
              <li><a href="/blog/tag">More...</a></li>
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              @foreach ($sidebar['dates'] as $date)
                  <li><a href="/blog/{{$date['link']}}"><?=ucfirst($date['text'])?></a></li>
              @endforeach
              <li><a href="/blog/archive">More...</a></li>
            </ol>
          </div>
        </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

@include('layouts.bottom')
