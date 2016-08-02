          <div class="blog-post">
            <h2 class="blog-post-title"><a href="<?php echo '/blog/'.substr($result->created_at, 0, 4).'/'.substr($result->created_at, 5, 2).'/'.substr($result->created_at, 8, 2).'/'.$result->slug; ?>">{{ $result->post_title }}</a></h2>

            <p class="blog-post-meta"><?php date_links([substr($result->created_at, 0, 4), substr($result->created_at, 5, 2), substr($result->created_at, 8, 2)], "span"); ?>
            <?php
            if ($result->modified_at !== '0000-00-00 00:00:00') {
                echo '(edited ' . substr($result->modified_at, 0, 10) . ')';
            }
            ?>
            <!--by <a href="#"><?php //echo config('bbb_config.user') ?></a> -->on <a href="/blog/category/<?php echo $result->category ?>" ><?php echo $result->category ?></a> in <a href="/blog/language/<?php echo ucfirst(strtolower($result->language)) ?>" ><?php echo $result->language ?></a></p>
            <p>
    <?php foreach ($result->tags as $tag) {?>
        <!-- <span class="glyphicon glyphicon-tag"></span> -->
        <a href="/blog/tag/<?php echo $tag?>" class="label label-default tag"><?php echo ucfirst(strtolower($tag)); ?></a>&nbsp;
    <?php }
    ?>
</p>

            @if (isset($result->lead) && $result->lead !== '' && $result->lead !== '0')
                <h3 class="lead"><?php echo $result->lead; ?>
                </h3>
            @endif

            <?php echo $result->body; ?>

            <a class="btn btn-primary read-more" href="<?php echo '/blog/'.substr($result->created_at, 0, 4).'/'.substr($result->created_at, 5, 2).'/'.substr($result->created_at, 8, 2).'/'.$result->slug; ?>">Read more</a>
          </div><!-- /.blog-post -->
