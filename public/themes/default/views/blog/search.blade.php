@extends('layouts.blog')

@section('content')

        <section class="col-sm-12 blog-top">
            <ol class="breadcrumb col-sm-8">
                <li><a href="/blog">Blog</a></li>
                <li><a href="/blog/search/">Search</a></li>
                <li class="active">{{$query}}</li>
            </ol>
            <div class="col-sm-3 col-sm-offset-1 searchbar">
                @include('blog.searchbar')
            </div>

        <section class="col-sm-8 blog-main blog-inventory">

            @foreach ($results as $result)
                @include('blog.item')
            @endforeach

            @if (count($results) === 0)
                <h2>No results</h2>
            @endif

        </section><!-- /.blog-main -->
        @include('blog.sidebar')

        @include('layouts.pagination')

@stop
