@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

          @foreach ($results as $result)
            @include('blog.item')
          @endforeach

        @include('layouts.pagination')

        </div><!-- /.blog-main -->
@stop
