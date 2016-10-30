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
                    @if ($modified_at !== '0000-00-00 00:00:00')
                        <span class="edit-time">{{edit_time($modified_at)}}</span>
                    @endif
                    </p>
                    <p>
                    on <a href="/blog/category/{{slugify($category)}}" >{{$category}}</a> in <a href="/blog/language/{{strtolower(slugify($language))}}" >{{ucfirst($language)}}</a></p>
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
                @if ($modified_at !== '0000-00-00 00:00:00')
                    <span class="edit-time">{{edit_time($modified_at)}}</span>
                @endif
                </p>
                <p>
                on <a href="/blog/category/{{slugify($category)}}" >{{$category}}</a> in <a href="/blog/language/{{strtolower(slugify($language))}}" >{{ucfirst($language)}}</a></p>
                <p>{{read_time($post_id, true, true)}} read</p>
                </div>
            </header>
        @endif

            <section class="blog-body">
                <?=$body;?>
            </section>

            <div class="tags col-sm-6 col-sm-offset-3">
                <div class="lead">Tags:</div>
                <p>
                @foreach ($tags as $tag)
                    <a href="/blog/tag/{{slugify($tag)}}" class="label label-default">{{ucfirst(strtolower($tag))}}</a>&nbsp;
                @endforeach
                </p>
            </div>

        </article><!-- /.blog-post -->

        <div class="col-sm-12">

        @include('layouts.pager')

        @if (isset($prev_url))
            <a class="prev-next btn btn-primary btn-ghost" href="{{$prev_url}}"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Previous</a>
        @endif

        @if (isset($next_url))
        <a class="prev-next btn btn-primary btn-ghost pull-right" href="{{$next_url}}">Next <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></a>
        @endif

        </div><!-- /.blog-main -->
        </div>
@stop
