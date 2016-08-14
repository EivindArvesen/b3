<div class="col-md-3 col-md-offset-1 blog-sidebar">
  <div class="sidebar-module sidebar-module-inset">
    @include('blog.searchbar')
  </div>
  @if (config('bbb_config.about'))
  <div class="sidebar-module">
    <h4>About</h4>
    <p><?php echo config('bbb_config.about');?></p>
  </div>
  @endif
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
