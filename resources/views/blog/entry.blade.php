@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h1 class="blog-post-title"><a href="<?php echo '/blog/'.$year.'/'.$month.'/'.$day.'/'.$url_title; ?>"><?php echo $title; ?></a></h1>
            @if (isset($result->lead) && $result->lead !== '' && $result->lead !== '0')
                <h2 class="lead><?php echo $lead; ?></h2>
            @endif
            <p class="blog-post-meta"><?php date_links([$year, $month, $day], "span"); ?><!--by <a href="#"><?php //echo config('bbb_config.user') ?></a> -->on <a href="/blog/category/<?php echo $category ?>" ><?php echo $category ?></a> in <a href="/blog/language/<?php echo ucfirst(strtolower($language)) ?>" ><?php echo $language ?></a></p>
            <p>
    <?php foreach ($tags as $tag) {?>
        <!-- <span class="glyphicon glyphicon-tag"></span> -->
        <a href="/blog/tag/<?php echo $tag?>" class="label label-default"><?php echo ucfirst(strtolower($tag)); ?></a>&nbsp;
    <?php }
    ?>
</p>

            <?php echo $body; ?>
          </div><!-- /.blog-post -->

        @include('layouts.pager')

        </div><!-- /.blog-main -->
@stop
