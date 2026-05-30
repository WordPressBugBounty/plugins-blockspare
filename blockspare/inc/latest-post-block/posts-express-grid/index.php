<?php
if (!function_exists('blockspare_latest_posts_style_control')) {

  function blockspare_latest_posts_style_control($blockuniqueclass, $attributes)
  {


    // Build CSS separately
    $inline_css = '';
    $inline_css .= blockspare_visibility_css($attributes, $blockuniqueclass);
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-wrap{
            margin-top:' . $attributes['marginTop'] . 'px;
            margin-bottom:' . $attributes['marginBottom'] . 'px;
            margin-left:' . $attributes['marginLeft'] . 'px;
            margin-right:' . $attributes['marginRight'] . 'px;
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content{
            padding-top:' . $attributes['contentPaddingTop'] . 'px;
            padding-right:' . $attributes['contentPaddingRight'] . 'px;
            padding-bottom:' . $attributes['contentPaddingBottom'] . 'px;
            padding-left:' . $attributes['contentPaddingLeft'] . 'px;
        }';

    $inline_css  .= blockspare_posts_category_style(
      $inline_css,
      $attributes,
      $blockuniqueclass,
      $attributes['categoryTextColor'],
      $attributes['categoryBackgroundColor'],
      $attributes['categoryBorderColor'],
      $attributes['secondCategoryTextColor'],
      $attributes['secondCategoryBackgroundColor'],
      $attributes['secondCategoryBorderColor'],
      $attributes['thirdCategoryTextColor'],
      $attributes['thirdCategoryBackgroundColor'],
      $attributes['thirdCategoryBorderColor'],
    );

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-byline{ 
            margin-top:' . $attributes['metaMarginTop'] . 'px' . ';
            margin-bottom:' . $attributes['metaMarginBottom'] . 'px' . ';
            margin-left:' . $attributes['metaMarginLeft'] . 'px' . ';
            margin-right:' . $attributes['metaMarginRight'] . 'px' . ';
        }';


    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-more-link{
            margin-top:' . $attributes['moreLinkMarginTop'] . 'px' . ';
            margin-bottom:' . $attributes['moreLinkMarginBottom'] . 'px' . ';
            margin-left:' . $attributes['moreLinkMarginLeft'] . 'px' . ';
            margin-right:' . $attributes['moreLinkMarginRight'] . 'px' . '; 
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{
            color: ' . $attributes['postTitleColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-author a span{
            color:' . $attributes['linkColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-more-link span{
            color:' . $attributes['linkColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-date{
            color:' . $attributes['generalColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-excerpt-content{
            color:' . $attributes['generalColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .comment_count{
            color:' . $attributes['generalColor'] . '; 
        }';

    $layoutstyle = explode('-', $attributes['express']);

    if ($layoutstyle[6] > 3) {
      $inline_css .= ' .' . $blockuniqueclass . '  .blockspare-posts-block-post-single .blockspare-posts-block-post-img {
                border-radius:' . $attributes['borderRadius'] . 'px' . ';          
            }';
      if ($attributes['enableBoxShadow']) {
        $inline_css .= ' .' . $blockuniqueclass . '  .blockspare-posts-block-post-single .blockspare-posts-block-post-img {
                    box-shadow: ' . $attributes['xOffset'] . 'px ' . $attributes['yOffset'] . 'px ' . $attributes['blur'] . 'px ' . $attributes['spread'] . 'px ' . $attributes['shadowColor'] . ';
                }';
      }
    } else {
      $inline_css .= ' .' . $blockuniqueclass . '  .blockspare-posts-block-post-single{
                border-radius:' . $attributes['borderRadius'] . 'px' . ';
                background-color:' . $attributes['backGroundColor'] . '
            }';

      if ($attributes['enableBoxShadow']) {
        $inline_css .= ' .' . $blockuniqueclass . '  .blockspare-posts-block-post-single{
                    box-shadow: ' . $attributes['xOffset'] . 'px ' . $attributes['yOffset'] . 'px ' . $attributes['blur'] . 'px ' . $attributes['spread'] . 'px ' . $attributes['shadowColor'] . ';
                }';
      }

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content{
                padding-top:' . $attributes['contentPaddingTop'] . 'px;
                padding-right:' . $attributes['contentPaddingRight'] . 'px;
                padding-bottom:' . $attributes['contentPaddingBottom'] . 'px;
                padding-left:' . $attributes['contentPaddingLeft'] . 'px;
            }';
    }

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title{
            margin-top:' . $attributes['titleMarginTop'] . 'px' . ';
            margin-bottom:' . $attributes['titleMarginBottom'] . 'px' . ';
            margin-left:' . $attributes['titleMarginLeft'] . 'px' . ';
            margin-right:' . $attributes['titleMarginRight'] . 'px' . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-excerpt-content{
            margin-top:' . $attributes['exceprtMarginTop'] . 'px' . ';
            margin-bottom:' . $attributes['exceprtMarginBottom'] . 'px' . ';
            margin-left:' . $attributes['exceprtMarginLeft'] . 'px' . ';
            margin-right:' . $attributes['exceprtMarginRight'] . 'px' . ';
        }';

    //Title Hover
    if ($attributes['titleOnHover'] == 'lpc-title-hover') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-title-link:hover span{
                color: ' . $attributes['titleOnHoverColor'] . ';
            }';
    }

    if ($attributes['titleOnHover'] == 'lpc-title-border') {
      $inline_css .= ' .' . $blockuniqueclass . ' .lpc-title-border .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link span:hover{
                box-shadow: inset 0 -2px 0 0 ' . $attributes['titleOnHoverColor'] . ';
            }';
    }


    //Font Settings
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{  
            font-size: ' . $attributes['postTitleFontSize'] . $attributes['titleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['titleFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['titleFontWeight']) . ';
            line-height: ' . $attributes['postTitleLineHeight'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-excerpt .blockspare-posts-block-post-grid-excerpt-content{
            font-size:' . $attributes['descriptionFontSize'] . $attributes['descriptionFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['descriptionFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['descriptionFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-author a span {
            font-size:' . $attributes['postMetaFontSize'] . $attributes['postMetaFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['postMetaFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['postMetaFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-date {
            font-size:' . $attributes['postMetaFontSize'] . $attributes['postMetaFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['postMetaFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['postMetaFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .comment_count {
            font-size:' . $attributes['postMetaFontSize'] . $attributes['postMetaFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['postMetaFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['postMetaFontWeight']) . ';
        }';

    $inline_css .= '@media (max-width: 1025px) { ';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{
            font-size: ' . $attributes['titleFontSizeTablet'] . $attributes['titleFontSizeType'] . ';
        }';

    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-excerpt .blockspare-posts-block-post-grid-excerpt-content{
            font-size:' . $attributes['descriptionFontSizeTablet'] . $attributes['descriptionFontSizeType'] . '
        }';
    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-grid-author a span {
            font-size:' . $attributes['postMetaFontSizeTablet'] . $attributes['postMetaFontSizeType'] . '
        }';
    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-grid-date {
            font-size:' . $attributes['postMetaFontSizeTablet'] . $attributes['postMetaFontSizeType'] . '
        }';
    $inline_css .= ' .' .  $blockuniqueclass . ' .comment_count {
            font-size:' . $attributes['postMetaFontSizeTablet'] . $attributes['postMetaFontSizeType'] . '
        }';

    $inline_css .= '}';

    $inline_css .= '@media (max-width: 767px) { ';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{
            font-size: ' . $attributes['titleFontSizeMobile'] . $attributes['titleFontSizeType'] . ';
        }';

    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-excerpt .blockspare-posts-block-post-grid-excerpt-content{
            font-size:' . $attributes['descriptionFontSizeMobile'] . $attributes['descriptionFontSizeType'] . '
        }';
    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-grid-author a span {
            font-size:' . $attributes['postMetaFontSizeMobile'] . $attributes['postMetaFontSizeType'] . '
        }';
    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-grid-date {
            font-size:' . $attributes['postMetaFontSizeMobile'] . $attributes['postMetaFontSizeType'] . '
        }';
    $inline_css .= ' .' .  $blockuniqueclass . ' .comment_count {
            font-size:' . $attributes['postMetaFontSizeMobile'] . $attributes['postMetaFontSizeType'] . '
        }';

    $inline_css .= '}';

    if ($attributes['express'] != 'blockspare-posts-block-express-grid-layout-3' &&  $attributes['express'] != 'blockspare-posts-block-express-grid-layout-6') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(1) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSize'] . $attributes['spostTitleFontSizeType'] . ';
                ' . bscheckFontfamily($attributes['spostTitleFontFamily']) . ';
                ' . bscheckFontfamilyWeight($attributes['spostTitleFontWeight']) . ';
            }';

      $inline_css .= '@media (max-width: 1025px) { ';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(1) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSizeTablet'] . $attributes['spostTitleFontSizeType'] . ';
            }';

      $inline_css .= '}';
      $inline_css .= '@media (max-width: 767px) { ';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(1) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSizeMobile'] . $attributes['spostTitleFontSizeType'] . ';
            }';

      $inline_css .= '}';
    } else {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(1) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSize'] . $attributes['spostTitleFontSizeType'] . ';  
                ' . bscheckFontfamily($attributes['spostTitleFontFamily']) . ';
                ' . bscheckFontfamilyWeight($attributes['spostTitleFontWeight']) . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(2) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSize'] . $attributes['spostTitleFontSizeType'] . ';  
                ' . bscheckFontfamily($attributes['spostTitleFontFamily']) . ';
                ' . bscheckFontfamilyWeight($attributes['spostTitleFontWeight']) . ';
            }';

      $inline_css .= '@media (max-width: 1025px) { ';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(1) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSizeTablet'] . $attributes['spostTitleFontSizeType'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(2) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSizeTablet'] . $attributes['spostTitleFontSizeType'] . ';
            }';

      $inline_css .= '}';

      $inline_css .= '@media (max-width: 767px) { ';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(1) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSizeMobile'] . $attributes['spostTitleFontSizeType'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single:nth-child(2) .blockspare-posts-block-post-grid-title a span{
                font-size: ' . $attributes['spostTitleFontSizeMobile'] . $attributes['spostTitleFontSizeType'] . ';
            }';

      $inline_css .= '}';
    }

    //Pagination
    if ($attributes['enablePagination']) {
      if ($attributes['loadMoreStyle'] == 'bs-loadmore-solid') {
        $inline_css .= ' .' . $blockuniqueclass . '  .bs_blockspare_loadmore a.blockspare-readmore .load-btn{
                        color:' . $attributes['loadMoreSolidTextColor'] . ';
                        background-color:' . $attributes['loadMoreTextBgColor'] . ';
                    }';
        $inline_css .= ' .' . $blockuniqueclass . '  .bs_blockspare_loadmore a.blockspare-readmore .load-btn:hover{
                        color:' . $attributes['loadMoreSolidTextHoverColor'] . ';
                        background-color:' . $attributes['loadMoreTextBgHoverColor'] . ';
                    }';
      } else {
        $inline_css .= ' .' . $blockuniqueclass . '  .bs_blockspare_loadmore a.blockspare-readmore .load-btn{
                        color:' . $attributes['loadMoreTextColor'] . ';
                    }';
        $inline_css .= ' .' . $blockuniqueclass . '  .bs_blockspare_loadmore a.blockspare-readmore .load-btn:hover{
                        color:' . $attributes['loadMoreTextHoverColor'] . ';
                    }';
      }

      $inline_css .= ' .' . $blockuniqueclass . '  .bs_blockspare_loadmore{
                    text-align:' . $attributes['loadMoreAlignment'] . ';
                }';
      $inline_css .= ' .' . $blockuniqueclass . ' .bs_blockspare_loadmore a.blockspare-readmore .ajax-loader-enabled{
                    border-top-color:' . $attributes['loadMoreColor'] . ';
                }';
      $inline_css .= '}';
    }


    // $block_content .= blockspare_minify_css($inline_css);

    // $block_content .= '</style>';
    // return $block_content;
    if (!empty($inline_css)) {
      wp_register_style('bs-express-grid', false);
      wp_enqueue_style('bs-express-grid');
      wp_add_inline_style('bs-express-grid', blockspare_minify_css($inline_css));
    }
  }
}


function blockspare_epxpress_query_loop_and_wrapper($attributes, $blockclass = '', $design = '', $blockName = '', $layoutClass = false)
{
  $unq_class = mt_rand(100000, 999999);
  $blockuniqueclass = '';

  if (!empty($attributes['uniqueClass'])) {
    $blockuniqueclass = $attributes['uniqueClass'];
  } else {
    $blockuniqueclass = 'blockspare-posts-block-list-' . $unq_class;
  }

  $grid_query = blockspare_post_query($attributes);

  $count = 0;
  if ($grid_query->have_posts()) {
    $alignclass = blockspare_checkalignment($attributes['align']);


    /* Build the block classes */
    $class = "wp-block-blockspare-posts-block-blockspare-posts-block-latest-posts align" . $alignclass . " " . $attributes['blockHoverEffect'];

    if (isset($attributes['className'])) {
      $class .= ' ' . $attributes['className'];
    }

    if ($attributes['animation']) {
      $class .= ' blockspare-block-animation';
    }



    $list_layout_class = $design;
    $listgridClass = $blockclass . " ";


    /* Layout orientation class */
    $grid_class = 'blockspare-posts-block-latest-post-wrap '  . $listgridClass . ' ' . $list_layout_class;
    $class .= ' ' . $blockuniqueclass;
    $category_class = 'blockspare-posts-block-post-category';

    if ($attributes['categoryLayoutOption'] == 'none') {
      $category_class .= ' has-no-category-style';
    } ?>

    <section class="blockspare-posts-block-post-wrap">
      <div class="<?php echo esc_attr($grid_class); ?>">
        <?php while ($grid_query->have_posts()) {
          $grid_query->the_post();

          /* Setup the post ID */
          $post_id = get_the_ID();

          /* Setup the featured image ID */
          $post_thumb_id = get_post_thumbnail_id($post_id);

          $has_img_class = '';

          if (!$post_thumb_id) {
            $has_img_class = "post-has-no-image";
          }




          if ($attributes['enableEqualHeight']) {
            $has_img_class .= ' bs-has-equal-height';
          }
          $contentOrderClass = '';
          if ($attributes['contentOrder'] == 'content-order-1') {
            $contentOrderClass .= 'contentorderone';
          }
          if ($attributes['contentOrder'] == 'content-order-2') {
            $contentOrderClass .= 'contentordertwo';
          }

          /* Setup the post classes */
          $post_classes = 'blockspare-posts-block-post-single blockspare-hover-item ' . $contentOrderClass;

          if ($layoutClass) {
            $post_classes .= ' has-background';
          } else {
            $post_classes .= ' blockspare-hover-child';
          }

          $className = '';

          if (isset($attributes['full'])) {
            if ($attributes['full'] == 'blockspare-posts-block-full-layout-6') {
              $post_classes .= ' blockspare-hover-child';
              $className .= 'hover-child';
            }
          }


          /* Add sticky class */
          if (is_sticky($post_id)) {
            $post_classes .= ' sticky';
          } else {
            $post_classes .= null;
          }
          $post_classes .= ' has-background';
        ?>
          <div id="<?php echo esc_attr($post_id); ?>" class="<?php echo esc_attr($post_classes) . ' ' . $has_img_class; ?>">
            <?php blockspare_express_post_image($attributes, $post_id, $category_class, $blockName, $className, $count); ?>
            <?php blockspare_express_post_content($attributes, $post_id, $category_class, $blockName, $className, $count); ?>
          </div>

        <?php $count++;
        } ?>

      </div>
      <?php
      if ($attributes['enablePagination'] == 'true' && $grid_query->max_num_pages > 1) {
        $loadmore_class = '';
        if ($attributes['loadMoreStyle']) {
          $loadmore_class = $attributes['loadMoreStyle'];
        }
        if ($attributes['loadMoreAlignment']) {
          $loadmore_class .=  ' bs_blockspare_loadmore_' . $attributes['loadMoreAlignment'];
        }
      ?>
        <div class="bs_blockspare_loadmore blockspare-readmore-wrapper <?php echo esc_attr($loadmore_class); ?>" data-layout="<?php echo $layoutClass; ?>" block-name="express" data-page='2' blockspare-att=<?php echo "'" .  wp_kses_post(wp_json_encode($attributes)) . "'"; ?> max-paged="<?php echo $grid_query->max_num_pages; ?>">
          <a href="#" class="blockspare-readmore">
            <div class="load-btn "><?php echo ($attributes['loadMoreText']); ?><span class="ajax-loader"></span></div>
          </a>
        </div><?php
            }
              ?>
    </section>

  <?php
  }

  wp_reset_postdata();
}

function blockspare_express_post_image($attributes, $post_id, $cat_class, $blockName = '', $className = '', $count = '')
{


  $spotlightItems = 0;
  if ($attributes['express'] == 'blockspare-posts-block-express-grid-layout-3' || $attributes['express'] == 'blockspare-posts-block-express-grid-layout-6') {
    $spotlightItems = 1;
  }
  /* Setup the featured image ID */
  $post_thumb_id = get_post_thumbnail_id($post_id);


  if (!empty($attributes['imageSize'])) {
    $post_thumb_size = $attributes['imageSize'];
  }

  $content_order = false;
  if ($attributes['contentOrder'] == 'content-order-1' || $attributes['contentOrder'] == 'content-order-2') {
    $content_order = true;
  }




  if (isset($attributes['enableFeatureImage'])  && $attributes['enableFeatureImage'] == 'true') {
  ?>
    <figure class="blockspare-posts-block-post-img hover-child">
      <a href="<?php echo esc_url(get_permalink($post_id)); ?>" aria-label="<?php echo esc_attr(get_the_title($post_id)); ?>">
        <?php
        if (has_post_thumbnail($post_id)) {
          if ($count <=  $spotlightItems) {
            echo wp_kses_post(wp_get_attachment_image($post_thumb_id, $attributes['spotslightImageSize']));
          }
          if ($count > $spotlightItems) {
            echo wp_kses_post(wp_get_attachment_image($post_thumb_id, $post_thumb_size));
          }
        } else { ?>
          <div class="bs-no-thumbnail-img"> </div>
        <?php  } ?>
      </a>
      <?php if ($attributes['displaySpotlightPostCategory'] == 'true' && $content_order == true && $count <= $spotlightItems) { ?>
        <!-- Spotlight Category     -->
        <div class="<?php echo esc_attr($cat_class); ?>">
          <?php blockspare_get_cat_tax_tags($attributes['taxType'], $post_id, $attributes['postType']); ?>
        </div>
        <!-- Spotlight Category     -->
      <?php } ?>
      <?php if ($attributes['displayPostCategory'] == 'true' && $content_order == true && $count > $spotlightItems) { ?>
        <!-- Category     -->
        <div class="<?php echo esc_attr($cat_class); ?>">
          <?php blockspare_get_cat_tax_tags($attributes['taxType'], $post_id, $attributes['postType']); ?>
        </div>
        <!-- Category     -->
      <?php } ?>
    </figure>
  <?php
  }
}

function blockspare_express_post_content($attributes, $post_id, $cat_class, $blockName = '', $className = '', $count = '')
{
  $spotlightItems = 0;
  if ($attributes['express'] == 'blockspare-posts-block-express-grid-layout-3' || $attributes['express'] == 'blockspare-posts-block-express-grid-layout-6') {
    $spotlightItems = 1;
  }
  $content_order = false;
  if ($attributes['contentOrder'] == 'content-order-1' || $attributes['contentOrder'] == 'content-order-2') {
    $content_order = true;
  }
  if ($blockName == 'full') {
    $content_order = false;
  }
  ?>
  <div class="blockspare-posts-block-post-content <?php echo esc_attr($className); ?> <?php echo esc_attr($attributes['contentOrder']); ?> <?php echo esc_attr($attributes['titleOnHover']) ?>">
    <div class="blockspare-posts-block-bg-overlay"></div>
    <!-- blockspare-posts-block-post-grid-header -->
    <header class="blockspare-posts-block-post-grid-header">
      <!--display category when feature image is disable -->
      <?php if ($attributes['displayPostCategory'] == 'true' && $attributes['enableFeatureImage'] != 'true') { ?>
        <!-- Category     -->
        <div class="<?php echo esc_attr($cat_class); ?>">
          <?php blockspare_get_cat_tax_tags($attributes['taxType'], $post_id, $attributes['postType']); ?>
        </div>
        <!-- Category     -->
      <?php } ?>
      <!--display category when feature image is enable-->
      <?php if ($attributes['displayPostCategory'] == 'true' && $attributes['enableFeatureImage'] == 'true' && $content_order == false) { ?>
        <!-- Category     -->
        <div class="<?php echo esc_attr($cat_class); ?>">
          <?php blockspare_get_cat_tax_tags($attributes['taxType'], $post_id, $attributes['postType']); ?>
        </div>
        <!-- Category     -->
      <?php } ?>
      <!-- blockspare-posts-block-post-grid-title -->

      <?php if ($attributes['displaySpotlightPostTitle'] == 'true' && $count <= $spotlightItems) { ?>
        <h2 class="blockspare-posts-block-post-grid-title">
          <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="blockspare-posts-block-title-link"
            rel="bookmark">
            <span><?php echo get_the_title(); ?></span>
          </a>
        </h2>
      <?php } ?>
      <?php if ($attributes['displayPostTitle'] == 'true'  && $count > $spotlightItems) { ?>
        <h2 class="blockspare-posts-block-post-grid-title">
          <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="blockspare-posts-block-title-link"
            rel="bookmark">
            <span><?php echo get_the_title(); ?></span>
          </a>
        </h2>

      <?php } ?>

      <!-- blockspare-posts-block-post-grid-title -->

      <!-- blockspare-posts-block-post-grid-byline -->
      <div class="blockspare-posts-block-post-grid-byline">
        <!-- blockspare-posts-block-post-grid-author -->
        <?php if (isset($attributes['displaySpotlightPostAuthor']) && $attributes['displaySpotlightPostAuthor'] == 'true' && $count <= $spotlightItems) { ?>
          <div class="blockspare-posts-block-post-grid-author">

            <?php
            $author_id = get_post_field('post_author', $post_id);
            $blockspare_get_multiauthor =  new BlocksapreMultiAuthorForFrontend();
            $blockspare_get_multiauthor->blockspare_front_by_author($post_id, $attributes['authorIcon'], $author_id);
            ?>
          </div>
        <?php } ?>
        <!-- spotlight blockspare-posts-block-post-grid-author -->
        <!-- blockspare-posts-block-post-grid-author -->
        <?php if (isset($attributes['displayPostAuthor']) && $attributes['displayPostAuthor'] == 'true' && $count > $spotlightItems) { ?>
          <div class="blockspare-posts-block-post-grid-author">

            <?php
            $author_id = get_post_field('post_author', $post_id);
            $blockspare_get_multiauthor =  new BlocksapreMultiAuthorForFrontend();
            $blockspare_get_multiauthor->blockspare_front_by_author($post_id, $attributes['authorIcon'], $author_id);
            ?>
          </div>
        <?php } ?>
        <!-- blockspare-posts-block-post-grid-author -->

        <!-- Spotlight blockspare-posts-block-post-grid-date -->
        <?php if (isset($attributes['displaySpotlightPostDate']) && $attributes['displaySpotlightPostDate'] == 'true' && $count <= $spotlightItems) { ?>
          <time datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>" class="blockspare-posts-block-post-grid-date" itemprop="datePublished"><i class="<?php echo esc_attr($attributes['dateIcon']); ?>" aria-hidden="true"></i><?php echo esc_html(get_the_date('', $post_id)); ?></time>
        <?php } ?>
        <!-- Spotlight blockspare-posts-block-post-grid-date -->
        <!-- blockspare-posts-block-post-grid-date -->
        <?php if (isset($attributes['displayPostDate']) && $attributes['displayPostDate'] == 'true' && $count > $spotlightItems) { ?>
          <time datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>" class="blockspare-posts-block-post-grid-date" itemprop="datePublished"><i class="<?php echo esc_attr($attributes['dateIcon']); ?>" aria-hidden="true"></i><?php echo esc_html(get_the_date('', $post_id)); ?></time>
        <?php } ?>
        <!-- blockspare-posts-block-post-grid-date -->

        <!--  Spotlight comment_count -->
        <?php if ($attributes['enableSpotlightComment'] == 'true' && $count <= $spotlightItems) { ?>
          <span class="comment_count"><i class='<?php echo esc_attr($attributes['commentIcon']); ?>' aria-hidden="true"></i><?php echo esc_html(get_comments_number($post_id)); ?></span>
        <?php } ?>
        <!--  Spotlight -->
        <?php if ($attributes['enableComment'] == 'true' && $count > $spotlightItems) { ?>
          <span class="comment_count"><i class='<?php echo esc_attr($attributes['commentIcon']); ?>' aria-hidden="true"></i><?php echo esc_html(get_comments_number($post_id)); ?></span>
        <?php } ?>
        <!-- comment_count -->
      </div>
      <!-- blockspare-posts-block-post-grid-byline -->
    </header>
    <!-- blockspare-posts-block-post-grid-header -->


    <?php

    if ($attributes['displaySpotlightPostExcerpt'] == 'true' && $count <= $spotlightItems) {
      $excerpts = blockspare_excerpt($post_id, $attributes['excerptSpotlightLength']);
      $new_excerpt = apply_filters('the_excerpt', $excerpts); ?>
      <!-- Spotlight blockspare-posts-block-post-grid-excerpt -->
      <?php if ($attributes['displaySpotlightPostExcerpt'] && $new_excerpt != null) { ?>
        <div class="blockspare-posts-block-post-grid-excerpt">
          <!-- blockspare-posts-block-post-grid-excerpt-content -->
          <?php if (isset($attributes['displaySpotlightPostExcerpt']) && $attributes['displaySpotlightPostExcerpt'] == 'true') { ?>
            <div class="blockspare-posts-block-post-grid-excerpt-content">
              <?php echo wp_kses_post($excerpts); ?>
            </div>
          <?php } ?>
          <!-- blockspare-posts-block-post-grid-excerpt-content -->
          <!-- blockspare-posts-block-post-grid-more-link -->
          <?php if (isset($attributes['displaySpotPostLink']) && $attributes['displaySpotPostLink'] == 'true') { ?>
            <p>


              <a
                class="blockspare-posts-block-post-grid-more-link blockspare-posts-block-text-link"
                href="<?php echo esc_url(get_permalink($post_id)); ?>"
                aria-label="<?php echo sprintf(esc_attr__('Read more about %s', 'blockspare'), esc_html(get_the_title($post_id))); ?>">
                <span aria-hidden="true"><?php echo esc_html($attributes['readMoreText']); ?></span>
              </a>

            </p>
          <?php } ?>
          <!-- blockspare-posts-block-post-grid-more-link -->
        </div>
    <?php }
    } ?>
    <!-- Spotlight blockspare-posts-block-post-grid-excerpt -->
    <?php
    if ($attributes['displayPostExcerpt'] == 'true' && $count > $spotlightItems) {

      $excerpt = blockspare_excerpt($post_id, $attributes['excerptLength']);
      $new_excerpt = apply_filters('the_excerpt', $excerpt); ?>
      <!-- blockspare-posts-block-post-grid-excerpt -->
      <?php if ($attributes['displayPostExcerpt'] && $new_excerpt != null) { ?>
        <div class="blockspare-posts-block-post-grid-excerpt">
          <!-- blockspare-posts-block-post-grid-excerpt-content -->
          <?php if (isset($attributes['displayPostExcerpt']) && $attributes['displayPostExcerpt'] == 'true'  && $count > $spotlightItems) { ?>
            <div class="blockspare-posts-block-post-grid-excerpt-content">
              <?php echo wp_kses_post($excerpt); ?>
            </div>
          <?php } ?>
          <!-- blockspare-posts-block-post-grid-excerpt-content -->
          <!-- blockspare-posts-block-post-grid-more-link -->
          <?php if (isset($attributes['displayPostLink']) && $attributes['displayPostLink'] == 'true'  && $count > $spotlightItems) { ?>
            <p>
              <a
                class="blockspare-posts-block-post-grid-more-link blockspare-posts-block-text-link"
                href="<?php echo esc_url(get_permalink($post_id)); ?>"
                aria-label="<?php echo sprintf(esc_attr__('Read more about %s', 'blockspare'), esc_html(get_the_title($post_id))); ?>">
                <span aria-hidden="true"><?php echo esc_html($attributes['readMoreText']); ?></span>
              </a>

            </p>
          <?php } ?>
          <!-- blockspare-posts-block-post-grid-more-link -->
        </div>
    <?php }
    } ?>
    <!-- blockspare-posts-block-post-grid-excerpt -->

  </div>
<?php }
