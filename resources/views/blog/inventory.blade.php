@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

            <ol class="breadcrumb">
                <li><a href="/blog">Blog</a></li>
                <?php
                if (isset($group_title) && $group_title !== ''){
                    echo '<li><a href="/blog/'.strtolower($group_title).'">'.ucfirst(strtolower($group_title)).'</a></li>';
                }
                if (isset($group) && $group !== ''){
                    date_links($group, "li");
                }
                ?>
            </ol>


            @foreach ($results as $result)
                @include('blog.item')
            @endforeach

        @include('layouts.pagination')

        </div><!-- /.blog-main -->
@stop
