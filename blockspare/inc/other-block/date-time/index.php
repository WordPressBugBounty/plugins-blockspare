<?php
if (!function_exists('blockspare_date_time_style_control')) {
  function blockspare_date_time_style_control($blockuniqueclass, $attributes)
  {
    $inline_css = '';
    $inline_css .= blockspare_visibility_css($attributes, $blockuniqueclass);
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-time-widget{
            margin-top:' . $attributes['marginTop'] . 'px;
            margin-right:' . $attributes['marginRight'] . 'px;
            margin-bottom:' . $attributes['marginBottom'] . 'px;
            margin-left:' . $attributes['marginLeft'] . 'px;
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-wrapper i.bs-date-icon{
            color:' . $attributes['dateIconColor'] . ';
            font-size: ' . $attributes['dateIconSize'] . $attributes['dateFontSizeType'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-wrapper time.bs-date-text{
            color:' . $attributes['dateColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-wrapper .bs-date .bs-before-date-text{
            color:' . $attributes['textBeforeColor'] . ';
        }';


    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-wrapper .bs-date .bs-after-date-text{
            color:' . $attributes['textAfterColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-time-wrapper i.bs-time-icon{
            color:' . $attributes['timeIconColor'] . ';
            font-size: ' . $attributes['timeIconSize'] . $attributes['dateFontSizeType'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-time-wrapper span.bs-time-text{
            color:' . $attributes['timeColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-time-widget:not(.date-time-style-1) .bs-time-wrapper{
            background-color:' . $attributes['bgColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-time-widget:not(.date-time-style-1) .bs-date-wrapper{
            background-color:' . $attributes['bgColor'] . ';
        }';

    //Font Settings

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-text{
            font-size: ' . $attributes['dateFontSize'] . $attributes['dateFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['dateFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['dateFontWeight']) . ';
            
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-before-date-text{
            font-size: ' . $attributes['beforeDateFontSize'] . $attributes['beforeDateFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['beforeDateFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['beforeDateFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-after-date-text{
            font-size: ' . $attributes['afterDateFontSize'] . $attributes['afterDateFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['afterDateFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['afterDateFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-time-text{
            font-size: ' . $attributes['timeFontSize'] . $attributes['timeFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['timeFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['timeFontWeight']) . ';
        }';


    $inline_css .= '@media (max-width: 1025px) { ';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-text{
                font-size: ' . $attributes['dateFontSizeTablet'] . $attributes['dateFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-before-date-text{
                font-size: ' . $attributes['beforeDateFontSizeTablet'] . $attributes['beforeDateFontSizeTablet'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-after-date-text{
                font-size: ' . $attributes['afterDateFontSizeTablet'] . $attributes['afterDateFontSizeType'] . ';
            }';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-time-text{
                font-size: ' . $attributes['timeFontSizeTablet'] . $attributes['timeFontSizeType'] . ';
            }';
    $inline_css .= '}';

    $inline_css .= '@media (max-width: 767px) { ';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-date-text{
                font-size: ' . $attributes['dateFontSizeMobile'] . $attributes['dateFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-before-date-text{
                font-size: ' . $attributes['beforeDateFontSizeMobile'] . $attributes['beforeDateFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-after-date-text{
                font-size: ' . $attributes['afterDateFontSizeMobile'] . $attributes['afterDateFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-time-text{
                font-size: ' . $attributes['timeFontSizeMobile'] . $attributes['timeFontSizeType'] . ';
            }';
    $inline_css .= '}';


    if (!empty($inline_css)) {
      wp_register_style('bs-post-date-time', false);
      wp_enqueue_style('bs-post-date-time');
      wp_add_inline_style('bs-post-date-time', blockspare_minify_css($inline_css));
    }
  }
}
