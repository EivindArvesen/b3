@extends('layouts.blog')

@section('content')

        <div class="col-sm-12 blog-main">

          <div class="blog-post">
            <h1 class="blog-post-title"><a href="<?php echo '/blog/'.$year.'/'.$month.'/'.$day.'/'.$slug; ?>"><?php echo $title; ?></a></h1>
            <p class="blog-post-meta"><?php date_links([$year, $month, $day], "span"); ?>
            <?php
            if ($modified_at !== '0000-00-00 00:00:00') {
                echo '(edited ' . substr($modified_at, 0, 10) . ')';
            }
            ?>
            <!--by <a href="#"><?php //echo config('bbb_config.user') ?></a> -->on <a href="/blog/category/<?php echo $category ?>" ><?php echo $category ?></a> in <a href="/blog/language/<?php echo ucfirst(strtolower($language)) ?>" ><?php echo $language ?></a></p>
            <p>
    <?php foreach ($tags as $tag) {?>
        <!-- <span class="glyphicon glyphicon-tag"></span> -->
        <a href="/blog/tag/<?php echo $tag?>" class="label label-default tag"><?php echo ucfirst(strtolower($tag)); ?></a>&nbsp;
    <?php }
    ?>
</p>
        @if (isset($lead) && $lead !== '' && $lead !== '0')
            <h3 class="lead"><?php echo $lead; ?>
            </h3>
        @endif

            <?php echo $body; ?>
          </div><!-- /.blog-post -->

        @include('layouts.pager')

        @if (isset($prev_url))
            <a class="prev-next btn btn-primary" href="<?php echo $prev_url; ?>"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Previous</a>
        @endif

        @if (isset($next_url))
        <a class="prev-next btn btn-primary pull-right" href="<?php echo $next_url; ?>">Next <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></a>
        @endif

        </div><!-- /.blog-main -->
        </div>
@stop
