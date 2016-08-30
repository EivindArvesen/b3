@extends(config('bbb_config.theme') . '.layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

            <ol class="breadcrumb">
                <li><a href="/blog">Blog</a></li>
                @if (isset($group_title) && $group_title !== '')
                    <li><a href="/blog/{{strtolower($group_title)}}'">{{ucfirst(strtolower($group_title))}}</a></li>
                @endif

                @if (isset($group) && $group !== '')
                    {{date_links($group, "li")}}
                @endif
            </ol>


            @foreach ($results as $result)
                @include(config('bbb_config.theme') . '.blog.item')
            @endforeach

        @include(config('bbb_config.theme') . '.layouts.pagination')

        </div><!-- /.blog-main -->
        @include(config('bbb_config.theme') . '.blog.sidebar')
@stop
