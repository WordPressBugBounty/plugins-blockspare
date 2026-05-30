<?php
if (!function_exists('blockspare_post_tile_img')) {
  function blockspare_post_tile_img($post_id, $category_class, $attributes, $post_thumb_id, $post_thumb_size)
  { ?>
    <figure class="blockspare-posts-block-post-img">
      <a href="<?php echo esc_url(get_permalink($post_id)); ?>" aria-label="<?php echo esc_attr(get_the_title($post_id)); ?>">
        <?php
        if (has_post_thumbnail($post_id)) {
          echo wp_kses_post(wp_get_attachment_image($post_thumb_id, $post_thumb_size, '', ["class" => 'hover-child']));
        } else { ?>
          <div class="bs-no-thumbnail-img"> </div><?php
                                                } ?>
      </a>
      <?php if ($attributes['displayPostCategory'] == 'true' && ($attributes['contentOrder'] == 'content-order-2')) { ?>
        <div class="<?php echo esc_attr($category_class); ?>">
          <?php $categories_list = get_the_category_list(' ', '', $post_id);
          if ($categories_list) {
            printf(esc_html__('%1$s', "blockspare"), $categories_list); // WPCS: XSS OK.
          }
          if ($attributes['postType'] != 'post') {
            $terms = get_the_terms($post_id, $attributes['taxType']);
            if ($terms) {
              foreach ($terms as $trem) { ?>
                <a herf=><?php echo $trem->name; ?></a><?php
                                                      }
                                                    }
                                                  } ?>
        </div><?php
            } ?>
    </figure>
  <?php }
}

if (!function_exists('blockspare_post_tile_content')) {
  function blockspare_post_tile_content($attributes, $post_id, $category_class, $className = '')
  { ?>
    <div class="blockspare-posts-block-post-content <?php echo esc_attr($className); ?> <?php echo esc_attr($attributes['contentOrder']); ?> <?php echo esc_attr($attributes['titleOnHover']) ?>">
      <div class="blockspare-posts-block-bg-overlay"></div>
      <header class="blockspare-posts-block-post-grid-header">
        <?php
        if ($attributes['displayPostCategory'] == 'true' && ($attributes['contentOrder'] != 'content-order-2')) { ?>
          <div class="<?php echo esc_attr($category_class); ?>">
            <?php
            $categories_list = get_the_category_list(' ', '', $post_id);
            if ($categories_list) {
              printf(esc_html__('%1$s', "blockspare"), $categories_list); // WPCS: XSS OK.
            }
            if ($attributes['postType'] != 'post') {
              $terms = get_the_terms($post_id, $attributes['taxType']);
              if ($terms) {
                foreach ($terms as $trem) { ?>
                  <a herf=><?php echo $trem->name; ?></a>
            <?php }
              }
            }
            ?>
          </div><?php
              }

              $title = get_the_title($post_id);
              if (isset($attributes['displayPostTitle']) && $attributes['displayPostTitle'] == 'true') { ?>
          <h2 class="blockspare-posts-block-post-grid-title">
            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="blockspare-posts-block-title-link"
              rel="bookmark">
              <span><?php echo get_the_title(); ?></span>
            </a>
          </h2>
        <?php
              }
              if (isset($attributes['postType'])  && (isset($attributes['displayPostAuthor']) || isset($attributes['displayPostDate']))) { ?>
          <div class="blockspare-posts-block-post-grid-byline">
            <?php
                if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor'] == 'true') { ?>
              <div class="blockspare-posts-block-post-grid-author">
                <!-- <a class="blockspare-posts-block-text-link"
                                            href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"
                                            itemprop="url" rel="author">
                                            <span itemprop="name"><i
                                                    class="<?php echo esc_attr($attributes['authorIcon']); ?>"></i><?php echo esc_html(get_the_author_meta('display_name', get_the_author_meta('ID'))); ?></span>
                                        </a> -->
                <?php
                  $author_id = get_post_field('post_author', $post_id);
                  $blockspare_get_multiauthor =  new BlocksapreMultiAuthorForFrontend();
                  $blockspare_get_multiauthor->blockspare_front_by_author($post_id, $attributes['authorIcon'], $author_id); ?>
              </div>
            <?php
                }

                if (isset($attributes['displayPostDate']) && $attributes['displayPostDate'] == 'true') { ?>
              <time datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>" class="blockspare-posts-block-post-grid-date" itemprop="datePublished"><i class="<?php echo esc_attr($attributes['dateIcon']); ?>" aria-hidden="true"></i><?php echo esc_html(get_the_date('', $post_id)); ?></time>
            <?php
                }
                if ($attributes['enableComment'] == 'true') { ?>
              <span class="comment_count"><i class='<?php echo esc_attr($attributes['commentIcon']); ?>' aria-hidden="true"></i><?php echo esc_html(get_comments_number($post_id)); ?></span>
            <?php
                } ?>
          </div>

        <?php } ?>

      </header>

      <?php
      /* Get the excerpt */
      $excerpt = blockspare_post_excerpt($attributes, $post_id);
      if ($attributes['displayPostExcerpt'] == 'true' && $excerpt != null) { ?>
        <div class="blockspare-posts-block-post-grid-excerpt">
          <?php
          if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt'] == 'true') { ?>
            <div class="blockspare-posts-block-post-grid-excerpt-content"><?php echo wp_kses_post($excerpt); ?></div>
          <?php
          } ?>


          <?php if (isset($attributes['displayPostLink']) && $attributes['displayPostLink'] == 'true') { ?>
            <p>
              <a
                class="blockspare-posts-block-post-grid-more-link blockspare-posts-block-text-link"
                href="<?php echo esc_url(get_permalink($post_id)); ?>"
                aria-label="<?php echo sprintf(esc_attr__('Read more about %s', 'blockspare'), esc_html(get_the_title($post_id))); ?>">
                <span aria-hidden="true"><?php echo esc_html($attributes['readMoreText']); ?></span>
              </a>

            </p>
          <?php
          } ?>
        </div>
      <?php } ?>

    </div>
    </div>
<?php
  }
}


if (!function_exists('blockspare_post_excerpt')) {
  function blockspare_post_excerpt($attributes, $post_id)
  {
    /* Get the excerpt */
    $excerpt = get_post_field(
      'post_excerpt',
      $post_id,
      'display'
    );

    if (empty($excerpt)) {
      $excerpt = preg_replace(
        array(
          '/\<figcaption>.*\<\/figcaption>/',
          '/\[caption.*\[\/caption\]/',
        ),
        '',
        get_the_content()
      );
    }

    // Trim the excerpt if necessary.
    if (isset($attributes['excerptLength'])) {
      $excerpt = wp_trim_words(
        $excerpt,
        $attributes['excerptLength']
      );
    }

    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- This is a WP core filter.
    $excerpt = apply_filters('the_excerpt', $excerpt);

    return $excerpt;
  }
}
