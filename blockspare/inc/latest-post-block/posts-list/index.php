<?php
if (!function_exists('blockspare_posts_style_control_list')) {
  function blockspare_posts_style_control_list($blockuniqueclass, $attributes)
  {
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

    $inline_css .= blockspare_posts_category_style(
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

    $layoutstyle = explode('-', $attributes['design']);

    if ($layoutstyle[5] > 3) {
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
    }

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

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-excerpt .blockspare-posts-block-post-grid-excerpt-content {
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
    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-excerpt .blockspare-posts-block-post-grid-excerpt-content {
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
    $inline_css .= ' .' .  $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-excerpt .blockspare-posts-block-post-grid-excerpt-content {
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


    if (!empty($inline_css)) {
      wp_register_style('bs-post-list', false);
      wp_enqueue_style('bs-post-list');
      wp_add_inline_style('bs-post-list', blockspare_minify_css($inline_css));
    }
  }
}
