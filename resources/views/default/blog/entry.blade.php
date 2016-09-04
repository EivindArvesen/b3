@extends(config('bbb_config.theme') . '.layouts.blog')

@section('content')

        <div class="col-sm-12 blog-main">

          <div class="blog-post">
            <h1 class="blog-post-title"><a href="{{'/blog/'.$year.'/'.$month.'/'.$day.'/'.$slug}}">{{$title}}</a></h1>
            <p class="blog-post-meta">{{date_links([$year, $month, $day], "span")}}
            @if ($modified_at !== '0000-00-00 00:00:00')
                {{'(edited ' . substr($modified_at, 0, 10) . ')'}}
            @endif
            on <a href="/blog/category/{{$category}}" >{{$category}}</a> in <a href="/blog/language/{{ucfirst(strtolower($language))}}" >{{$language}}</a></p>
            <p>
    @foreach ($tags as $tag)
        <a href="/blog/tag/{{$tag}}" class="label label-default">{{ucfirst(strtolower($tag))}}</a>&nbsp;
    @endforeach
</p>
        @if (isset($lead) && $lead !== '' && $lead !== '0')
            <h3 class="lead">{{$lead}}
            </h3>
        @endif

            <?=$body;?>
          </div><!-- /.blog-post -->

        @include(config('bbb_config.theme') . '.layouts.pager')

        @if (isset($prev_url))
            <a class="prev-next btn btn-primary btn-ghost" href="{{$prev_url}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Previous</a>
        @endif

        @if (isset($next_url))
        <a class="prev-next btn btn-primary btn-ghost pull-right" href="{{$next_url}}">Next <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></a>
        @endif

        </div><!-- /.blog-main -->
        </div>
@stop
