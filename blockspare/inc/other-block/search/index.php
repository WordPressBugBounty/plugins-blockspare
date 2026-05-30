<?php
if (!function_exists('search_style_control')) {
  function search_style_control($blockuniqueclass, $attributes)
  {
    $inline_css = '';
    $inline_css .= blockspare_visibility_css($attributes, $blockuniqueclass);

    //icon font size
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs-search-icon--toggle{
            font-size:' . $attributes['iconSize'] . 'px;
        }';

    //search form bordar radius
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-form{
            border-radius:' . $attributes['borderRadius'] . 'px;
        }';

    //search form height
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs-search-form-header .site-search-field{
            height:' . $attributes['height'] . 'px;
        }';

    //search form background color
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .site-search-form{
            background-color:' . $attributes['bgColor'] . ';
        }';

    //search button background color
    if (isset($attributes['buttonBgColor'])) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .btn-bs-search-form{
                background-color:' . $attributes['buttonBgColor'] . ';
            }';
    }

    //placeholder color
    if (isset($attributes['placeholderTextColor'])) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field::placeholder{
                color:' . $attributes['placeholderTextColor'] . ';
            }';
    }

    //input color
    if (isset($attributes['inputTextColor'])) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field{
                color:' . $attributes['inputTextColor'] . ';
            }';
    }

    //close icon color
    if (isset($attributes['closeIconColor'])) {
      $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--site-search-close{
                color:' . $attributes['closeIconColor'] . ';
            }';
    }

    //icon color
    if ($attributes['searchStyle'] == "icon" || $attributes['buttonType'] == "icon") {
      if (isset($attributes['iconColor'])) {
        $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs-search-icon--toggle{
                    color:' . $attributes['iconColor'] . ';
                }';
      }
    }
    if ($attributes['searchStyle'] == "icon" || $attributes['buttonType'] == "icon") {
      if (isset($attributes['formIconColor'])) {
        $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .btn-bs-search-form::before{
                    color:' . $attributes['formIconColor'] . ';
                }';
      }
    }

    //button text color
    if ($attributes['buttonType'] == "text") {
      if (isset($attributes['buttonTextColor'])) {
        $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .btn-bs-search-form{
                    color:' . $attributes['buttonTextColor'] . ';
                }';
      }
    }

    //toogle icon Gaps
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs-search-icon--toggle{
            padding-top:' . $attributes['toggleIconPaddingTop'] . 'px;
            padding-right:' . $attributes['toggleIconPaddingRight'] . 'px;
            padding-bottom:' . $attributes['toggleIconPaddingBottom'] . 'px;
            padding-left:' . $attributes['toggleIconPaddingLeft'] . 'px;
        }';

    //search form Gaps
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .site-search-form{
            padding-top:' . $attributes['searchFormPaddingTop'] . 'px;
            padding-right:' . $attributes['searchFormPaddingRight'] . 'px;
            padding-bottom:' . $attributes['searchFormPaddingBottom'] . 'px;
            padding-left:' . $attributes['searchFormPaddingLeft'] . 'px;
        }';

    //Block Gaps
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper{
            margin-top:' . $attributes['marginTop'] . 'px;
            margin-right:' . $attributes['marginRight'] . 'px;
            margin-bottom:' . $attributes['marginBottom'] . 'px;
            margin-left:' . $attributes['marginLeft'] . 'px;
            padding-top:' . $attributes['paddingTop'] . 'px;
            padding-right:' . $attributes['paddingRight'] . 'px;
            padding-bottom:' . $attributes['paddingBottom'] . 'px;
            padding-left:' . $attributes['paddingLeft'] . 'px;
        }';

    //search input gaps
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-form .site-search-field{
            padding-right:' . $attributes['searchInputPaddingRight'] . 'px;
            padding-left:' . $attributes['searchInputPaddingLeft'] . 'px;
        }';

    //Font Settings

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field::placeholder{
            font-size: ' . $attributes['placeholderFontSize'] . $attributes['placeholderFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['placeholderFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['placeholderFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field{
            font-size: ' . $attributes['inputFontSize'] . $attributes['inputFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['inputFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['inputFontWeight']) . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .btn-bs-search-form:not(.fas){
            font-size: ' . $attributes['searchFontSize'] . $attributes['searchFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['searchFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['searchFontWeight']) . ';
        }';

    $inline_css .= '@media (max-width: 1025px) { ';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field::placeholder{
                font-size: ' . $attributes['placeholderFontSizeTablet'] . $attributes['placeholderFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field{
                font-size: ' . $attributes['inputFontSizeTablet'] . $attributes['inputFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .btn-bs-search-form:not(.fas){
                font-size: ' . $attributes['searchFontSizeTablet'] . $attributes['searchFontSizeType'] . ';
            }';
    $inline_css .= '}';

    $inline_css .= '@media (max-width: 767px) { ';
    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field::placeholder{
                font-size: ' . $attributes['placeholderFontSizeMobile'] . $attributes['placeholderFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .site-search-field{
                font-size: ' . $attributes['inputFontSizeMobile'] . $attributes['inputFontSizeType'] . ';
            }';

    $inline_css .= ' .' . $blockuniqueclass . ' .bs-search-wrapper .bs--search-sidebar-wrapper .btn-bs-search-form:not(.fas){
                font-size: ' . $attributes['searchFontSizeMobile'] . $attributes['searchFontSizeType'] . ';
            }';
    $inline_css .= '}';


    if (!empty($inline_css)) {
      wp_register_style('bs-search', false);
      wp_enqueue_style('bs-search');
      wp_add_inline_style('bs-search', blockspare_minify_css($inline_css));
    }
  }
}
function blockspare_search_html($attributes)
{
  ob_start();
  $btnIconClass = 'btn-bs-search-form';
  if ($attributes['buttonType'] == "icon") {
    $btnIconClass .= ' ' . $attributes['buttonIcon'];
  }
?>
  <div
    class="bs--search-sidebar-wrapper"
    aria-expanded="false"
    role="form">
    <form role="search" action="<?php echo home_url('/'); ?>" method="get" class="search-form site-search-form  blockspare-hover-item">
      <span class="screen-reader-text">Search for:</span>

      <input
        type="text"
        class="search-field site-search-field"
        placeholder="<?php echo esc_attr($attributes['placeholder']); ?>"
        name="s"
        aria-label="<?php echo esc_html__('search input', 'blockspare'); ?>" />
      <button
        type="submit"
        class="<?php echo esc_attr($btnIconClass); ?>">
        <?php if ($attributes['buttonType'] == "icon") { ?>
          <span class="screen-reader-text">Search</span>
        <?php } ?>
        <?php if ($attributes['buttonType'] == "text") { ?>
          <?php echo $attributes['buttonLabel'] != "" ?  $attributes['buttonLabel'] : "Search"; ?>
        <?php } ?>
      </button>
    </form>
  </div>
<?php return ob_get_clean();
}
