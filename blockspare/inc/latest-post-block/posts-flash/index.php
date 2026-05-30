<?php
if (!function_exists('latest_posts_style_control_flash')) {
  function latest_posts_style_control_flash($blockuniqueclass, $attributes)
  {


    // Build CSS separately
    $inline_css = '';
    $inline_css .= blockspare_visibility_css($attributes, $blockuniqueclass);
    //post-flash-background
    if ($attributes['background']) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts{
                background-color:' . $attributes['backGroundColor'] . ';
            }';
    }

    //post-flash-border-radius
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts{
            border-radius:' . $attributes['borderRadius'] . 'px;
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-now-txt-animation-wrap{
            border-radius:' . $attributes['borderRadius'] . 'px;
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides{
            border-radius:' . $attributes['borderRadius'] . 'px;
        }';

    //post-image-border-radius
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides .bs-circle-marq{
            border-radius:' . $attributes['imgBorderRadius'] . 'px;
        }';

    //post-flash-animation-speed
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides .bs-marquee .bs-marquee-wrapper{
            animation-duration:' . $attributes['animationSpeed'] . 's;
        }';

    //post-widht
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap.has-fixed-width  h2.bs-post-title{
            width:' . $attributes['postWidth'] . 'px;
        }';

    //Title color
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides a .bs-post-title{
            color:' . $attributes['postTitleColor'] . ';
        }';

    //Title hover color
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides a:hover .bs-post-title{
            color:' . $attributes['titleOnHoverColor'] . ';
        }';

    //Exclusive News color and background
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap{
            color:' . $attributes['newsColor'] . ';
            background-color: ' . $attributes['newsBgColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap.flash-style-2 .bs-exclusive-posts .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap::after{
            border-left-color:' . $attributes['newsBgColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap.flash-style-3 .bs-exclusive-posts .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap::after{
            background-color:' . $attributes['newsBgColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap.flash-style-4 .bs-exclusive-posts .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap::after{
            background-color:' . $attributes['newsBgColor'] . ';
        }';

    //Border
    if ($attributes['border']) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts{
                border-width:' . $attributes['borderWidth'] . 'px;
                border-color:' . $attributes['borderColor'] . ';
            }';
    }

    //Exclusive Subtitle color and background
    if ($attributes['exclusiveSubtitle']) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-now > span{
                color:' . $attributes['exclusiveColor'] . ';
                background-color: ' . $attributes['exclusiveBgColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-now > span::before{
                border-top-color:' . $attributes['exclusiveBgColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-now > span::after{
                border-bottom-color:' . $attributes['exclusiveBgColor'] . ';
            }';
    }

    //Block Gaps
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts{
            margin-top:' . $attributes['marginTop'] . 'px;
            margin-right:' . $attributes['marginRight'] . 'px;
            margin-bottom:' . $attributes['marginBottom'] . 'px;
            margin-left:' . $attributes['marginLeft'] . 'px;
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-slides{
            padding-top:' . $attributes['paddingTop'] . 'px;
            padding-right:' . $attributes['paddingRight'] . 'px;
            padding-bottom:' . $attributes['paddingBottom'] . 'px;
            padding-left:' . $attributes['paddingLeft'] . 'px;
        }';

    // Post Number Color
    if ($attributes['enableCount']) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides .bs-marquee h2.bs-post-title a .bs-circle-marq .bs-trending-no{
                color: ' . $attributes['countColor'] . '; 
            }';
    }

    //Font Settings

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides a .bs-post-title{
            font-size: ' . $attributes['postTitleFontSize'] . $attributes['titleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['titleFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['titleFontWeight']) . ';
            line-height: ' . $attributes['postTitleLineHeight'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap .bs-exclusive-texts-wrapper{
            font-size: ' . $attributes['exclusiveFontSize'] . $attributes['exclusiveFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['exclusiveFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['exclusiveFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-now .bs-exclusive-news-title{
            font-size: ' . $attributes['exclusiveSubtitleFontSize'] . $attributes['exclusiveSubtitleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['exclusiveSubtitleFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['exclusiveSubtitleFontWeight']) . ';
        }';

    $inline_css .= '@media (max-width: 1025px) { ';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides a .bs-post-title{
                font-size: ' . $attributes['titleFontSizeTablet'] . $attributes['titleFontSizeType'] . ';
            }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap .bs-exclusive-texts-wrapper{
                font-size: ' . $attributes['exclusiveFontSizeTablet'] . $attributes['exclusiveFontSizeType'] . ';
            }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-now .bs-exclusive-news-title{
                font-size: ' . $attributes['exclusiveSubtitleFontSizeTablet'] . $attributes['exclusiveSubtitleFontSizeType'] . ';
            }';
    $inline_css .= '}';

    $inline_css .= '@media (max-width: 767px) { ';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-posts .bs-exclusive-slides a .bs-post-title{
                font-size: ' . $attributes['titleFontSizeMobile'] . $attributes['titleFontSizeType'] . ';
            }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-now .bs-exclusive-now-txt-animation-wrap .bs-exclusive-texts-wrapper{
                font-size: ' . $attributes['exclusiveFontSizeMobile'] . $attributes['exclusiveFontSizeType'] . ';
            }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-flash-wrap .bs-exclusive-now .bs-exclusive-news-title{
                font-size: ' . $attributes['exclusiveSubtitleFontSizeMobile'] . $attributes['exclusiveSubtitleFontSizeType'] . ';
            }';
    $inline_css .= '}';

    // $block_content .= blockspare_minify_css($inline_css);

    // $block_content .= '</style>';
    // return $block_content;

    if (!empty($inline_css)) {
      wp_register_style('bs-flash-inline', false);
      wp_enqueue_style('bs-flash-inline');
      wp_add_inline_style('bs-flash-inline', blockspare_minify_css($inline_css));
    }
  }
}
