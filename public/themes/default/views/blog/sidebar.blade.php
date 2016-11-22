<aside class="col-sm-3 col-sm-offset-1 blog-sidebar">
  <div class="sidebar-module sidebar-module-top">
    @include('blog.searchbar')
  </div>
  @if (config('b3_config.about'))
  <div class="sidebar-module">
    <h4>About</h4>
    @foreach (config('b3_config.about') as $about_para)
      <p><?=$about_para;?></p>
    @endforeach
  </div>
  @endif
  @if ($sidebar['languages'])
    <div class="sidebar-module">
      <h4>Languages</h4>
      <ol class="list-unstyled">
        @foreach ($sidebar['languages'] as $language)
          <li><a href="/blog/language/{{strtolower(slugify($language))}}">{{ucfirst($language)}}</a></li>
        @endforeach
        @if (count($sidebar['languages']) == 5)
          <li class="more"><a href="/blog/language">More...</a></li>
        @endif
      </ol>
    </div>
  @endif
  @if ($sidebar['categories'])
    <div class="sidebar-module">
      <h4>Categories</h4>
      <ol class="list-unstyled">
        @foreach ($sidebar['categories'] as $category)
          <li><a href="/blog/category/{{slugify($category)}}">{{ucfirst($category)}}</a></li>
        @endforeach
        @if (count($sidebar['categories']) == 5)
          <li class="more"><a href="/blog/category">More...</a></li>
        @endif
      </ol>
    </div>
  @endif
  @if ($sidebar['tags'])
    <div class="sidebar-module">
      <h4>Tags</h4>
      <ol class="list-unstyled">
        @foreach ($sidebar['tags'] as $tag)
            <li><a href="/blog/tag/{{slugify($tag)}}">{{ucfirst($tag)}}</a></li>
        @endforeach
        @if (count($sidebar['tags']) == 5)
          <li class="more"><a href="/blog/tag">More...</a></li>
        @endif
      </ol>
    </div>
  @endif
  @if ($sidebar['dates'])
    <div class="sidebar-module">
      <h4>Archives</h4>
      <ol class="list-unstyled">
        @foreach ($sidebar['dates'] as $date)
            <li><a href="/blog/{{$date['link']}}">{{ucfirst($date['text'])}}</a></li>
        @endforeach
        @if (count($sidebar['dates']) == 5)
          <li class="more"><a href="/blog/archive">More...</a></li>
        @endif
      </ol>
    </div>
  @endif
</aside><!-- /.blog-sidebar -->

</div><!-- /.row -->
