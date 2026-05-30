<?php

if (!function_exists('latest_posts_style_control_slider')) {
  function latest_posts_style_control_slider($blockuniqueclass, $attributes)
  {


    // Build CSS separately
    $inline_css = '';
    $inline_css .= blockspare_visibility_css($attributes, $blockuniqueclass);
    //Navigation
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel span:before{
             color:' . $attributes['navigationColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-latest-post-carousel-wrap ul li button{
            color:' . $attributes['navigationColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-is-carousel .slick-slider .slick-dots > li button{
            background-color:' . $attributes['navigationColor'] . '
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

    if ($attributes['slider'] == 'blockspare-posts-block-full-layout-5') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single > .blockspare-posts-block-post-grid-excerpt{
                padding-top:' . $attributes['contentPaddingTop'] . 'px;
                padding-right:' . $attributes['contentPaddingRight'] . 'px;
                padding-bottom:' . $attributes['contentPaddingBottom'] . 'px;
                padding-left:' . $attributes['contentPaddingLeft'] . 'px;
            }';
    }

    if ($attributes['slider'] == 'blockspare-posts-block-full-layout-4') {

      //Title Hover
      if ($attributes['titleOnHover'] == 'lpc-title-hover') {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content .blockspare-posts-block-title-link:hover span{
                    color: ' . $attributes['tileTitleOnHoverColor'] . ';
                    }';
      }

      if ($attributes['titleOnHover'] == 'lpc-title-border') {
        $inline_css .= ' .' . $blockuniqueclass . ' .lpc-title-border .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link span:hover{
                    box-shadow: inset 0 -2px 0 0 ' . $attributes['tileTitleOnHoverColor'] . ';
                }';
      }

      $inline_css  .= blockspare_posts_category_style(
        $inline_css,
        $attributes,
        $blockuniqueclass,
        $attributes['tileCategoryTextColor'],
        $attributes['tileCategoryBackgroundColor'],
        $attributes['tileCategoryBorderColor'],
        $attributes['tileSecondCategoryTextColor'],
        $attributes['tileSecondCategoryBackgroundColor'],
        $attributes['tileSecondCategoryBorderColor'],
        $attributes['tileThirdCategoryTextColor'],
        $attributes['tileThirdCategoryBackgroundColor'],
        $attributes['tileThirdCategoryBorderColor'],
      );
    } else {

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
    }


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


    if ($attributes['slider'] === 'blockspare-posts-block-full-layout-6') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single .blockspare-posts-block-post-content{
                    background-color:' . $attributes['backGroundColor'] . ';
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
    } else if ($attributes['slider'] === 'blockspare-posts-block-full-layout-4') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{
                color: ' . $attributes['fullPostTitleColor'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-author a span{
                color:' . $attributes['fullPostLinkColor'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-more-link span{
                color:' . $attributes['fullPostLinkColor'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-date{
                color:' . $attributes['fullPostGeneralColor'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-excerpt-content{
                color:' . $attributes['fullPostGeneralColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .comment_count{
                color:' . $attributes['fullPostGeneralColor'] . ';
            }';
    } else {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single{
                background-color:' . $attributes['backGroundColor'] . ';
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


    if ($attributes['slider'] != 'blockspare-posts-block-full-layout-6') {
      if ($attributes['enableBoxShadow']) {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single{
                    box-shadow: ' . $attributes['xOffset'] . 'px ' . $attributes['yOffset'] . 'px ' . $attributes['blur'] . 'px ' . $attributes['spread'] . 'px ' . $attributes['shadowColor'] . ';
                    border-radius:' . $attributes['borderRadius'] . 'px' . ';
                }';
      }

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-single{
                border-radius:' . $attributes['borderRadius'] . 'px' . ';
            }';
    } else {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content{
                box-shadow: ' . $attributes['xOffset'] . 'px ' . $attributes['yOffset'] . 'px ' . $attributes['blur'] . 'px ' . $attributes['spread'] . 'px ' . $attributes['shadowColor'] . ';
                border-radius:' . $attributes['borderRadius'] . 'px' . ';
            }';
    }




    //Font Settings

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-grid-title a span{
            font-size: ' . $attributes['postTitleFontSize'] . $attributes['titleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['titleFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['titleFontWeight']) . ';
            line-height: ' . $attributes['lineHeight'] . ';
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

    if (!empty($inline_css)) {
      wp_register_style('bs-post-slider', false);
      wp_enqueue_style('bs-post-slider');
      wp_add_inline_style('bs-post-slider', blockspare_minify_css($inline_css));
    }
  }
}
