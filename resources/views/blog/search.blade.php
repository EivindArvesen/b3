@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

            <h3><small>Results for: </small><?php echo $query; ?></h3>
            <hr />

            @foreach ($results as $result)
                @include('blog.item')
            @endforeach

            @include('layouts.pagination')

        </div><!-- /.blog-main -->
@stop
