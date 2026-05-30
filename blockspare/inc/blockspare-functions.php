<?php
if (!function_exists('blockspare_checkalignment')) {
  function blockspare_checkalignment($alignment = '', $attributes = '')
  {
    $align_class = $alignment == '' ? 'center' : $alignment;
    $align_class .= ' ' . blockspare_visibility_classes($attributes);
    return trim($align_class);
  }
}

function blockspare_visibility_classes($attributes)
{
  $classes = [];

  if (!empty($attributes['hideOnDesktop'])) {
    $classes[] = 'blockspare-hide-frontend-desktop';
  }
  if (!empty($attributes['hideOnTablet'])) {
    $classes[] = 'blockspare-hide-frontend-tablet';
  }
  if (!empty($attributes['hideOnMobile'])) {
    $classes[] = 'blockspare-hide-frontend-mobile';
  }

  return implode(' ', $classes);
}

function blockspare_minify_css($css)
{

  // Remove comments
  $css = preg_replace('!/\*.*?\*/!s', '', $css);
  // Remove whitespace
  $css = preg_replace('/\s+/', ' ', $css);
  // Remove space around symbols
  $css = str_replace([' {', '{ '], '{', $css);
  $css = str_replace([' }', '} '], '}', $css);
  $css = str_replace([' ;', '; '], ';', $css);
  $css = str_replace([' :', ': '], ':', $css);
  $css = str_replace([' ,', ', '], ',', $css);
  return trim($css);
}

function blockspare_visibility_css($attributes, $blockuniqueclass)
{
  $css = '';

  if (!empty($attributes['hideOnDesktop'])) {
    $css .= '@media (min-width: 1025px) {';
    $css .= '.' . $blockuniqueclass . '.blockspare-hide-frontend-desktop {';
    $css .= 'display: none !important;';
    $css .= '}}';
  }

  if (!empty($attributes['hideOnTablet'])) {
    $css .= '@media (min-width: 768px) and (max-width: 1024px) {';
    $css .= '.' . $blockuniqueclass . '.blockspare-hide-frontend-tablet {';
    $css .= 'display: none !important;';
    $css .= '}}';
  }

  if (!empty($attributes['hideOnMobile'])) {
    $css .= '@media (max-width: 767px) {';
    $css .= '.' . $blockuniqueclass . '.blockspare-hide-frontend-mobile {';
    $css .= 'display: none !important;';
    $css .= '}}';
  }

  return $css;
}
