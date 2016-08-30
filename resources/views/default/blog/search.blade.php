@extends(config('bbb_config.theme') . '.layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

            <ol class="breadcrumb">
                <li><a href="/blog">Blog</a></li>
                <li><a href="/blog/search/">Search</a></li>
                <li class="active">{{$query}}</li>
            </ol>

            @foreach ($results as $result)
                @include(config('bbb_config.theme') . '.blog.item')
            @endforeach

            @if (count($results) === 0)
                <h2>No results</h2>
            @endif

            @include(config('bbb_config.theme') . '.layouts.pagination')
        </div><!-- /.blog-main -->
        @include(config('bbb_config.theme') . '.blog.sidebar')
@stop
