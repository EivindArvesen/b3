@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title"><a href="<?php echo '/blog/2015/10/09/yeah'; ?>"><?php echo $title; ?></a></h2>
            <p class="blog-post-meta"><?php date_links(['2015', '10', '09'], "span"); ?><!--by <a href="#"><?php //echo config('bbb_config.user') ?></a>--></p>
            <p>
    <a href="/blog/language/<?php echo ucfirst(strtolower($language)) ?>" class="label label-default"><?php echo $language ?></a>&nbsp;
    <a href="/blog/category/<?php echo $category ?>" class="label label-primary"><?php echo $category ?></a>&nbsp;
    <?php foreach ($tags as $tag) {?>
        <a href="/blog/tag/tag" class="label label-info"><?php echo ucfirst(strtolower($tag)); ?></a>&nbsp;
    <?php }
    ?>
</p>

            <?php echo $body; ?>
          </div><!-- /.blog-post -->

        @include('layouts.pager')

        </div><!-- /.blog-main -->
@stop
