@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title"><a href="<?php echo '/blog/2015/10/09/yeah'; ?>"><?php echo $title; ?></a></h2>
            <p class="blog-post-meta"><?php date_links(['2015', '10', '09'], "span"); ?>by <a href="#"><?php echo config('bbb_config.user') ?></a></p>
            <p>
    <a href="/blog/language/language" class="label label-default">Language</a>&nbsp;
    <a href="/blog/category/category" class="label label-primary">Category</a>&nbsp;
    <a href="/blog/tag/tag" class="label label-info">Tag</a>&nbsp;
</p>

            <?php echo $body; ?>
          </div><!-- /.blog-post -->

        @include('layouts.pager')

        </div><!-- /.blog-main -->
@stop
