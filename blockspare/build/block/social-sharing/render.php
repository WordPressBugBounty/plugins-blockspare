<?php
global $post;

if (has_post_thumbnail()) {
  $thumbnail_id = get_post_thumbnail_id($post->ID);
  $thumbnail = $thumbnail_id ? current(wp_get_attachment_image_src($thumbnail_id, 'large', true)) : '';
} else {
  $thumbnail = null;
}


$unq_class = mt_rand(100000, 999999);
$blockuniqueclass = '';

if (!empty($attributes['uniqueClass'])) {
  $blockuniqueclass = $attributes['uniqueClass'];
} else {
  $blockuniqueclass = 'blockspare-share-' . $unq_class;
}

$icon_style = '';

if ($attributes['iconColorOption'] != 'blockspare-default-official-color') {

  $icon_style = "color:" . $attributes['customfontColorOption'] . ';';
  $icon_style .= " background-color:" . $attributes['custombackgroundColorOption'] . ';';
}


$animation_class  = '';
if ($attributes['animation']) {
  $animation_class = 'blockspare-block-animation';
}
$is_amp_endpoint = function_exists('is_amp_endpoint') && is_amp_endpoint();

$share_url = '';


if (isset($attributes['facebook']) && $attributes['facebook']) {
  $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '&title=' . get_the_title() . '';
  $share_url .= blockspare_render_social_sharing_block_item($attributes['facebookTitle'], $facebook_url, 'blockspare-share-facebook', 'fab fa-facebook-f', $icon_style, $is_amp_endpoint);
}

if (isset($attributes['twitter']) && $attributes['twitter']) {
  $twitter_url = 'http://twitter.com/share?text=' . get_the_title() . '&url=' . get_the_permalink() . '';
  $share_url .= blockspare_render_social_sharing_block_item($attributes['twitterTitle'], $twitter_url, 'blockspare-share-twitter', 'fab fa-twitter', $icon_style, $is_amp_endpoint);
}


if (isset($attributes['pinterest']) && $attributes['pinterest']) {

  $pinterest_url = 'https://pinterest.com/pin/create/button/?&url=' . get_the_permalink() . '&description=' . get_the_title();
  if (!empty($thumbnail)) {
    $pinterest_url .= '&media=' . esc_url($thumbnail);
  }
}

if (isset($attributes['linkedin']) && $attributes['linkedin']) {

  $linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . get_the_title() . '';
  $share_url .= blockspare_render_social_sharing_block_item($attributes['linkedinTitle'], $linkedin_url, 'blockspare-share-linkedin', 'fab fa-linkedin-in', $icon_style, $is_amp_endpoint);
}

if (isset($attributes['reddit']) && $attributes['reddit']) {


  $reddit_url = 'https://www.reddit.com/submit?url=' . get_the_permalink() . '';
  $share_url .= blockspare_render_social_sharing_block_item($attributes['redditTitle'], $reddit_url, 'blockspare-share-reddit', 'fab fa-reddit-alien', $icon_style, $is_amp_endpoint);
}

if (isset($attributes['email']) && $attributes['email']) {

  $email_url = 'mailto:?subject=' . get_the_title() . '&body=' . get_the_title() . '&mdash;' . get_the_permalink() . '';
  $share_url .= blockspare_render_social_sharing_block_item($attributes['emailTitle'], $email_url, 'blockspare-share-email', 'fas fa-envelope', $icon_style, false);
}

$iconColorOption = isset($attributes['iconColorOption']) ? esc_attr($attributes['iconColorOption']) : '';
$buttonOptions   = isset($attributes['buttonOptions']) ? esc_attr($attributes['buttonOptions']) : '';
$buttonShapes    = isset($attributes['buttonShapes']) ? esc_attr($attributes['buttonShapes']) : '';
$buttonSizes     = isset($attributes['buttonSizes']) ? esc_attr($attributes['buttonSizes']) : '';
$buttonFills     = isset($attributes['buttonFills']) ? esc_attr($attributes['buttonFills']) : '';

$layoutClass = ($attributes['buttonOptions'] == 'blockspare-icon-only')
  ? 'blockspare-social-sharing-horizontal'
  : esc_attr($attributes['iconLayoutType']);

$alignmentClass = 'blockspare-social-sharing-' . esc_attr($attributes['sectionAlignments']);
?>

<div class="<?php echo esc_attr("$blockuniqueclass $attributes[animation] $attributes[blockHoverEffect] $layoutClass $alignmentClass"); ?>">

  <?php echo blockspare_social_share_style($blockuniqueclass, $attributes); ?>

  <div class="blockspare-blocks blockspare-social-wrapper">

    <ul class="blockspare-social-sharing <?php echo "$iconColorOption $buttonOptions $buttonShapes $buttonSizes $buttonFills $layoutClass"; ?>">

      <?php echo $share_url; ?>

    </ul>

  </div>

</div>