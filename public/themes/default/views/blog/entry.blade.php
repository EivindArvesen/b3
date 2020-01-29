@extends('layouts.blog')

@section('content')

    <article class="blog-post">

        @if (isset($cover) && $cover !== '' && $cover !== '0')
            <header class="cover-header">
                <div class="cover-container">
                <div class="cover-overlay">
                    <figure class="cover-img" style="background-image: url('{{$cover}}')"></figure>
                    <div class="col-sm-12 cover-title-container">

                        <div id="blog-title">
                            <h1 class="blog-post-title">{{$title}}</h1>
                            @if (isset($lead) && $lead !== '' && $lead !== '0')
                                <h3 class="lead">{{$lead}}
                                </h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="blog-post-meta">
                        <p>{{date_links([$year, $month, $day])}}
                    @if ($modified_at !== '1000-01-01 00:00:00')
                        <span class="edit-time">(edited {{format_time($modified_at)}} )</span>
                    @endif
                    </p>
                    <p>
                    on <a href="/blog/category/{{slugify($category)}}" >{{$category}}</a> in <a href="/blog/language/{{strtolower(slugify($language))}}" >{{ucwords($language)}}</a></p>
                    <p>{{read_time($post_id, true, true)}} read</p>
                    </div>
            </header>

            <div class="col-sm-8 col-sm-offset-2 blog-entry">
        @else
            <div class="col-sm-8 col-sm-offset-2 blog-entry">

              <header>
                <div id="blog-title">
                    <h1 class="blog-post-title">{{$title}}</h1>
                    @if (isset($lead) && $lead !== '' && $lead !== '0')
                        <h3 class="lead">{{$lead}}
                        </h3>
                    @endif
                </div>
                <div class="blog-post-meta">
                    <p>{{date_links([$year, $month, $day])}}
                @if ($modified_at !== '1000-01-01 00:00:00')
                    <span class="edit-time">(edited {{format_time($modified_at)}} )</span>
                @endif
                </p>
                <p>
                on <a href="/blog/category/{{slugify($category)}}" >{{$category}}</a> in <a href="/blog/language/{{strtolower(slugify($language))}}" >{{ucwords($language)}}</a></p>
                <p>{{read_time($post_id, true, true)}} read</p>
                </div>
            </header>
        @endif

            <section class="blog-body">
                <?=$body;?>
            </section>

            <div class="tags col-sm-10 col-sm-offset-1">
                <p><strong>Tags</strong></p>
                <div class="tag-container">
                @foreach ($tags as $tag)
                    <a href="/blog/tag/{{slugify($tag)}}" class="label label-default">{{ucwords(strtolower($tag))}}</a>&nbsp;
                @endforeach
                </div>
            </div>

        </article><!-- /.blog-post -->

        <div class="col-sm-12">

            @include('layouts.sharebuttons')

            @include('layouts.pager')

            @if (isset($next_url))
            <div class="col-xs-12 col-sm-6 prev-next pull-right" id="entry-next">
                <div class="desc">Newer post</div>
                <a href="{{$next_url}}"><span class="title">
                    {{$next_title}}</span><span class="glyphicon glyphicon-menu-right" aria-hidden="true">
                </a>
            </div>
            @endif

            @if (isset($prev_url))
            <div class="col-xs-12 col-sm-6 prev-next" id="entry-left">
                <div class="desc">Older post</div>
                <a href="{{$prev_url}}">
                    <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>{{$prev_title}}
                </a>
            </div>
            @endif

        </div>

        <!-- Comment here? -->

        </div><!-- /.blog-main -->
@stop
