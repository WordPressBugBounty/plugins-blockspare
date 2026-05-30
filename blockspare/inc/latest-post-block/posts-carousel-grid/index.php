<?php
if (!function_exists('latest_posts_style_control_carousel')) {
  function latest_posts_style_control_carousel($blockuniqueclass, $attributes)
  {


    $block_content = '<style type="text/css">';
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

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel span:before{
            color:' . $attributes['navigationColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-latest-post-carousel-wrap ul li button{
            color:' . $attributes['navigationColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel .slick-slider .slick-dots > li button{
            background-color:' . $attributes['navigationColor'] . ';
        }';

    if ($attributes['navigationShape'] == 'lpc-navigation-1' ||  $attributes['navigationShape'] == 'lpc-navigation-2') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel .slick-slider .slick-arrow:after{
                background-color:' . $attributes['navigationShapeColor'] . '
            }';
    } elseif ($attributes['navigationShape'] == 'lpc-navigation-3' ||  $attributes['navigationShape'] == 'lpc-navigation-4') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel .slick-slider .slick-arrow{
                border-color:' . $attributes['navigationShapeColor'] . '
            }';
    } else {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel .slick-slider .slick-arrow{
                border-color:transparent ;
                background-color:transparent
            }';
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

    //Content Bakcground

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


    //end Content Background

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

    $boxshadow = false;

    if (!empty($attributes['grid']) && isset($attributes['grid'])) {
      if ($attributes['grid'] == 'blockspare-posts-block-grid-layout-1' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-2' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-5' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-6' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-9' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-10' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-13' || $attributes['grid'] == 'blockspare-posts-block-grid-layout-14') {
        $boxshadow = true;
      }
    }

    if ($boxshadow) {
      if ($attributes['enableBoxShadow']) {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single{
                    box-shadow: ' . $attributes['xOffset'] . 'px ' . $attributes['yOffset'] . 'px ' . $attributes['blur'] . 'px ' . $attributes['spread'] . 'px ' . $attributes['shadowColor'] . ';
                    border-radius:' . $attributes['borderRadius'] . 'px' . ';
                }';
      } else {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single{
                    border-radius:' . $attributes['borderRadius'] . 'px' . ';
                }';
      }
    } else {
      if ($attributes['enableBoxShadow']) {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-wrap .blockspare-posts-block-post-single .blockspare-posts-block-post-img {
                    box-shadow: ' . $attributes['xOffset'] . 'px ' . $attributes['yOffset'] . 'px ' . $attributes['blur'] . 'px ' . $attributes['spread'] . 'px ' . $attributes['shadowColor'] . ';
                    border-radius:' . $attributes['borderRadius'] . 'px' . ';
                }';
      } else {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-wrap .blockspare-posts-block-post-single .blockspare-posts-block-post-img {
                    border-radius:' . $attributes['borderRadius'] . 'px' . ';
                }';
      }
    }

    if ($attributes['grid'] != 'blockspare-posts-block-grid-layout-3' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-4' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-7' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-8' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-11' && $attributes['grid'] != 'blockspare-posts-block-grid-layout-12') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single{
                background-color:' . $attributes['backGroundColor'] . ';
            }';
    }

    //Font Settings

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{
            font-size: ' . $attributes['postTitleFontSize'] . $attributes['titleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['titleFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['titleFontWeight']) . ';
            line-height:' . $attributes['lineHeight'] . ';
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

    // $block_content .= blockspare_minify_css($inline_css);

    // $block_content .= '</style>';
    // return $block_content;

    if (!empty($inline_css)) {
      wp_register_style('bs-postcarousel-grid', false);
      wp_enqueue_style('bs-postcarousel-grid');
      wp_add_inline_style('bs-postcarousel-grid', blockspare_minify_css($inline_css));
    }
  }
}
