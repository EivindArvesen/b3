@extends('layouts.blog')

@section('content')

        <section class="col-sm-12 blog-top">
            <ol class="breadcrumb col-sm-8">
                <li><a href="/blog">Blog</a></li>
                @if (isset($group_title) && $group_title !== '')
                    <li><a href="/blog/{{strtolower($group_title)}}">{{ucfirst(strtolower($group_title))}}</a></li>
                @endif

                @if (isset($group) && $group !== '')
                    {{breadcrumb_links($group)}}
                @endif
            </ol>
            <div class="col-sm-3 col-sm-offset-1 searchbar">
                @include('blog.searchbar')
            </div>
        </section>

        <section class="col-sm-8 blog-main blog-inventory">

            @foreach ($results as $result)
                @include('blog.item')
            @endforeach

            @include('layouts.pagination')

        </section><!-- /.blog-main -->
        @include('blog.sidebar')

        </div>

@stop
