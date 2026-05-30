<?php
if (!function_exists('blockspare_popular_tags_style_control')) {
  function blockspare_popular_tags_style_control($blockuniqueclass, $attributes)
  {
    $inline_css = '';

    $inline_css .= blockspare_visibility_css($attributes, $blockuniqueclass);
    // popular tags/cats title color
    if (isset($attributes['popularTagColor'])) {
      $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-tag-title-wrapper .bs-tag-title-text{
                color:' . $attributes['popularTagColor'] . ';
            }';
    }



    //tags/cats title color
    if (isset($attributes['tagsColor'])) {
      $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-tag-wrapper .bs-tag-text{
                color:' . $attributes['tagsColor'] . ';
            }';
    }

    // tags/cats title hover color
    if (isset($attributes['tagsHoverColor'])) {
      $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-tag-wrapper .bs-tag-text:hover{
                color:' . $attributes['tagsHoverColor'] . ';
            }';
    }

    // primary icon color
    if (isset($attributes['primaryIconColor'])) {
      $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-primary-icon{
                 color:' . $attributes['primaryIconColor'] . ';
             }';
    }

    // secondary icon color
    if (isset($attributes['secondaryIconColor'])) {
      $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-secondary-icon{
                color:' . $attributes['secondaryIconColor'] . ';
            }';
    }

    // secondary background color
    if ($attributes['tagStyle'] != "popular-tag-style-1") {
      if (isset($attributes['secondaryColor'])) {
        $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-popular-taxonomies-lists .bs-popular-tags-text{
                    background-color:' . $attributes['secondaryColor'] . ';
                }';
      }
    }

    //Block Gaps
    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper{
            margin-top:' . $attributes['marginTop'] . 'px;
            margin-right:' . $attributes['marginRight'] . 'px;
            margin-bottom:' . $attributes['marginBottom'] . 'px;
            margin-left:' . $attributes['marginLeft'] . 'px;
            padding-top:' . $attributes['paddingTop'] . 'px;
            padding-right:' . $attributes['paddingRight'] . 'px;
            padding-bottom:' . $attributes['paddingBottom'] . 'px;
            padding-left:' . $attributes['paddingLeft'] . 'px;
        }';

    //Font Settings

    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-popular-tags-text{
            font-size: ' . $attributes['popularTagsFontSize'] . $attributes['popularTagsFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['popularTagsFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['popularTagsFontWeight']) . ';
        }';

    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-secondry-wrap{
            font-size: ' . $attributes['tagsFontSize'] . $attributes['tagsFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['tagsFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['tagsFontWeight']) . ';
        }';

    $inline_css  .= '@media (max-width: 1025px) { ';
    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-popular-tags-text{
                font-size: ' . $attributes['popularTagsFontSizeTablet'] . $attributes['popularTagsFontSizeType'] . ';
            }';

    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-secondry-wrap{
                font-size: ' . $attributes['tagsFontSizeTablet'] . $attributes['tagsFontSizeType'] . ';
            }';
    $inline_css  .= '}';

    $inline_css  .= '@media (max-width: 767px) { ';
    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-popular-tags-text{
                font-size: ' . $attributes['popularTagsFontSizeMobile'] . $attributes['popularTagsFontSizeType'] . ';
            }';

    $inline_css  .= ' .' . $blockuniqueclass . ' .bs-popular-tags-wrapper .bs-secondry-wrap{
                font-size: ' . $attributes['tagsFontSizeMobile'] . $attributes['tagsFontSizeType'] . ';
            }';
    $inline_css  .= '}';


    if (!empty($inline_css)) {
      wp_register_style('bs-post-popular', false);
      wp_enqueue_style('bs-post-popular');
      wp_add_inline_style('bs-post-popular', blockspare_minify_css($inline_css));
    }
  }
}
