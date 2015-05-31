@extends('layouts.blog')

@section('content')

        <div class="col-sm-8 blog-main">

            <ol class="breadcrumb">
              <li><a href="/blog">Blog</a></li>
              <?php
              if ($group_title!=''){
              echo '<li><a href="/blog/'.strtolower($group_title).'">'.ucfirst(strtolower($group_title)).'</a></li>';
            }
            date_links($group, "li");
            ?>
            </ol>

            <ul class="list-unstyled inventory">
                <li>
                    <h2><a href="<?php echo '/blog/2015/10/09/yeah'; ?>">Result</a></h2>
                    <p class="blog-post-meta"><?php date_links(['2015', '10', '09'], "span"); ?>by <a href="#"><?php echo config('bbb_config.user') ?></a></p>
                    <p>
    <a href="/blog/language/language" class="label label-default">Language</a>&nbsp;
    <a href="/blog/category/category" class="label label-primary">Category</a>&nbsp;
    <a href="/blog/tag/tag" class="label label-info">Tag</a>&nbsp;
</p>
                    <p>Body slug goes here.</p>
                </li>
                <li>
                    <h2><a href="<?php echo '/blog/2015/10/09/yeah'; ?>">Result</a></h2>
                    <p class="blog-post-meta"><?php date_links(['2015', '10', '09'], "span"); ?>by <a href="#"><?php echo config('bbb_config.user') ?></a></p>
                    <p>
    <a href="/blog/language/language" class="label label-default">Language</a>&nbsp;
    <a href="/blog/category/category" class="label label-primary">Category</a>&nbsp;
    <a href="/blog/tag/tag" class="label label-info">Tag</a>&nbsp;
</p>
                    <p>Body slug goes here.</p>
                </li>
            </ul>

        @include('layouts.pagination')

        </div><!-- /.blog-main -->
@stop
