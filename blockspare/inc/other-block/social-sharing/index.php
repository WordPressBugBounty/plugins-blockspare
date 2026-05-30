<?php

/**
 * Add the pop-up share window to the footer
 */
if (! function_exists('blockspare_social_sharing_block_icon_footer_script')) {
  function blockspare_social_sharing_block_icon_footer_script()
  {

    if (function_exists('is_amp_endpoint') && is_amp_endpoint()) {
      return;
    }
?>
    <script type="text/javascript">
      function blockspareBlocksShare(url, title, w, h) {
        var left = (window.innerWidth / 2) - (w / 2);
        var top = (window.innerHeight / 2) - (h / 2);
        return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=600, height=600, top=' + top + ', left=' + left);
      }
    </script>
<?php
  }


  add_action('wp_footer', 'blockspare_social_sharing_block_icon_footer_script');
}
function blockspare_social_share_style($blockuniqueclass, $attributes)
{
  $block_content = '';

  $block_content .= '<style type="text/css">';

  if ($attributes['iconColorOption'] != 'blockspare-default-official-color') {

    if ($attributes['buttonFills'] == 'blockspare-social-icon-solid') {

      $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-sharing a span{
        color:' . $attributes['customfontColorOption'] . ';
        background-color:' . $attributes['custombackgroundColorOption'] . ';
        }';
    } else if ($attributes['buttonFills'] == 'blockspare-social-icon-border') {
      $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-wrapper .blockspare-social-sharing a{
        color:' . $attributes['customfontColorOption'] . ';
        border:' . "2px solid " . $attributes['custombackgroundColorOption'] . ';
        }';
    } else {
      $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-sharing a span{
        color:' . $attributes['customfontColorOption'] . ';
      
        }';
    }
  }
  $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-wrapper{
        text-align:' . $attributes['sectionAlignments'] . ';
        margin-top:' . $attributes['marginTop'] . 'px;
        margin-right:' . $attributes['marginRight'] . 'px;
        margin-bottom:' . $attributes['marginBottom'] . 'px;
        margin-left:' . $attributes['marginLeft'] . 'px;
        
    }';

  $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-wrapper .blockspare-social-icons > span{
        font-size: ' . $attributes['socialFontSize'] . $attributes['socialFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['socialFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['socialFontWeight']) . ';
        
    }';

  $block_content .= '@media (max-width: 1025px) { ';
  $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-wrapper .blockspare-social-icons > span{
            font-size: ' . $attributes['socialFontSizeTablet'] . $attributes['socialFontSizeType'] . ';
        }';
  $block_content .= '}';

  $block_content .= '@media (max-width: 767px) { ';
  $block_content .= ' .' . $blockuniqueclass . ' .blockspare-social-wrapper .blockspare-social-icons > span{
            font-size: ' . $attributes['socialFontSizeMobile'] . $attributes['socialFontSizeType'] . ';
        }';
  $block_content .= '}';

  $block_content .= '</style>';
  return $block_content;
}

if (!function_exists('blockspare_render_social_sharing_block_item')) {

  function blockspare_render_social_sharing_block_item($attribute_title, $attribute_url, $item_class, $icon_class, $icon_style, $is_amp_endpoint)
  {


    $share_url = '';

    if (!$is_amp_endpoint) {
      $share_url .= sprintf(
        '<li class="blockspare-hover-item">
				<a
					href="%1$s"
					class="%3$s"
				
					>
					<span class="blockspare-social-icons">
					<i class="%4$s"></i> <span class="blockspare-social-text">%2$s</span>
					</span>
				</a>
			</li>',
        $attribute_url,
        esc_html__($attribute_title),
        esc_attr__($item_class),
        esc_attr__($icon_class),


      );
    } else {

      $href_format = sprintf('href="javascript:void(0)" onClick="javascript:blockspareBlocksShare(\'%1$s\', \'%2$s\', \'600\', \'600\')"', esc_url($attribute_url), esc_html__($attribute_title));

      if ($is_amp_endpoint) {
        $href_format = sprintf('href="%1$s"', esc_url($attribute_url));
      }
      $share_url .= sprintf(
        '<li class="blockspare-hover-item">
				<a
					%1$s
					class="%3$s"
					title="%2$s" 
					><span class="blockspare-social-icons">
					<i class="%4$s"></i> <span class="blockspare-social-text">%2$s</span>
					</span>
				</a>
			</li>',
        $href_format,
        esc_html__($attribute_title),
        esc_attr__($item_class),
        esc_attr__($icon_class)

      );
    }


    return $share_url;
  }
}
