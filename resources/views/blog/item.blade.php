          <div class="blog-post">
            <h2 class="blog-post-title"><a href="/blog/{{substr($result->created_at, 0, 4)}}/{{substr($result->created_at, 5, 2)}}/{{substr($result->created_at, 8, 2)}}/{{$result->slug}}">{{$result->post_title}}</a></h2>

            <p class="blog-post-meta">{{date_links([substr($result->created_at, 0, 4), substr($result->created_at, 5, 2), substr($result->created_at, 8, 2)], "span")}}
            @if ($result->modified_at !== '0000-00-00 00:00:00')
                {{'(edited ' . substr($result->modified_at, 0, 10) . ')'}}
            @endif
            on <a href="/blog/category/{{$result->category}}" >{{$result->category}}</a> in <a href="/blog/language/{{ucfirst(strtolower($result->language))}}" >{{$result->language}}</a></p>
            <p>
    @foreach ($result->tags as $tag)
        <a href="/blog/tag/{{$tag}}" class="label label-default tag">{{ucfirst(strtolower($tag))}}</a>&nbsp;
    @endforeach
</p>

            @if (isset($result->lead) && $result->lead !== '' && $result->lead !== '0')
                <h3 class="lead">{{$result->lead}}
                </h3>
            @endif

            <?=$result->body;?>

            <a class="btn btn-primary read-more" href="/blog/{{substr($result->created_at, 0, 4)}}/{{substr($result->created_at, 5, 2)}}/{{substr($result->created_at, 8, 2)}}/{{$result->slug}}">Read more</a>
          </div><!-- /.blog-post -->
