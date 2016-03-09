          <div class="blog-post">
            <h2 class="blog-post-title"><a href="<?php echo '/blog/'.substr($result->modified_at, 0, 4).'/'.substr($result->modified_at, 5, 2).'/'.substr($result->modified_at, 8, 2).'/'.$result->url_title; ?>">{{ $result->post_title }}</a></h2>
            @if (isset($result->lead) && $result->lead !== '' && $result->lead !== '0')
                <h3 class="lead"><?php echo $result->lead; ?>
                </h3>

            @endif
            <p class="blog-post-meta"><?php date_links([substr($result->modified_at, 0, 4), substr($result->modified_at, 5, 2), substr($result->modified_at, 8, 2)], "span"); ?><!--by <a href="#"><?php //echo config('bbb_config.user') ?></a> -->on <a href="/blog/category/<?php echo $result->category ?>" ><?php echo $result->category ?></a> in <a href="/blog/language/<?php echo ucfirst(strtolower($result->language)) ?>" ><?php echo $result->language ?></a></p>
            <p>
    <?php foreach ($result->tags as $tag) {?>
        <!-- <span class="glyphicon glyphicon-tag"></span> -->
        <a href="/blog/tag/<?php echo $tag?>" class="label label-default"><?php echo ucfirst(strtolower($tag)); ?></a>&nbsp;
    <?php }
    ?>
</p>

            <?php echo $result->body; ?>
          </div><!-- /.blog-post -->
