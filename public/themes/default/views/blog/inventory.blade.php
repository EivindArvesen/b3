@extends('layouts.blog')

@section('content')

        <section class="col-sm-8 blog-main blog-inventory">

            <ol class="breadcrumb">
                <li><a href="/blog">Blog</a></li>
                @if (isset($group_title) && $group_title !== '')
                    <li><a href="/blog/{{strtolower($group_title)}}">{{ucfirst(strtolower($group_title))}}</a></li>
                @endif

                @if (isset($group) && $group !== '')
                    {{breadcrumb_links($group)}}
                @endif
            </ol>


            @foreach ($results as $result)
                @include('blog.item')
            @endforeach

        </section><!-- /.blog-main -->
        @include('blog.sidebar')

        @include('layouts.pagination')

@stop
