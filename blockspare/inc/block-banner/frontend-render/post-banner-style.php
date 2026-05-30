<?php

function banner_control_slider($attributes, $blockuniqueclass, $blockName = '')
{


  // Build CSS separately
  $inline_css = '';
  $slider_grid = false;

  if ($blockName == 'blockspare-banner-11') {
    $slider_grid = true;
  }

  //Slider Title Meta Color
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-title{
        line-height:' . $attributes['sliderTitleLineHeight'] . ';
    }';

  if ($slider_grid) {

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-title a span{
            color:' . $attributes['sliderGridPostTitleColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-author a span{
            color:' . $attributes['sliderGridPostLinkColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-text-link a{
            color:' . $attributes['sliderGridPostLinkColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-date{
            color:' . $attributes['sliderGridPostGeneralColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .comment_count{
            color:' . $attributes['sliderGridPostGeneralColor'] . ';
        }';
    //sliderTitle Hover
    if ($attributes['sliderTitleOnHover'] == 'lpc-title-hover') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content.has-slider-title-hover .blockspare-posts-block-title-link:hover span{
                color: ' . $attributes['sliderGridTitleOnHoverColor'] . ';
                
            }';
    }
    if ($attributes['sliderTitleOnHover'] == 'lpc-title-border') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content.has-slider-title-hover .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link span:hover{
                box-shadow: inset 0 -2px 0 0 ' . $attributes['sliderGridTitleOnHoverColor'] . ';
                
            }';
    }
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-title a span{
            color:' . $attributes['sliderPostTitleColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-author a span{
            color:' . $attributes['sliderPostLinkColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-text-link a{
            color:' . $attributes['sliderPostLinkColor'] . ';
        }';

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-date{
            color:' . $attributes['sliderPostGeneralColor'] . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .comment_count{
            color:' . $attributes['sliderPostGeneralColor'] . ';
        }';

    //sliderTitle Hover
    if ($attributes['sliderTitleOnHover'] == 'lpc-title-hover') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content.has-slider-title-hover .blockspare-posts-block-title-link:hover span{
                color: ' . $attributes['sliderTitleOnHoverColor'] . ';
                
            }';
    }
    if ($attributes['sliderTitleOnHover'] == 'lpc-title-border') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content.has-slider-title-hover .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link span:hover{
                box-shadow: inset 0 -2px 0 0 ' . $attributes['sliderTitleOnHoverColor'] . ';
                
            }';
    }
  }


  // slider background color 

  if ($blockName == 'blockspare-banner-11' && $attributes['sliderBackground']) {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-data .blockspare-posts-block-post-content{
            background-color: ' . $attributes['sliderBackgroundColor'] . ';
            
        }';
  }


  //slider title Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-banner-slider .blockspare-posts-block-post-grid-title{
    margin-top: ' . $attributes['sliderTitleMarginTop'] . "px" . ';
    margin-Bottom: ' . $attributes['sliderTitleMarginBottom'] . "px" . ';
    margin-left: ' . $attributes['sliderTitleMarginLeft'] . "px" . ';
    margin-right: ' . $attributes['sliderTitleMarginRight'] . "px" . ';
    }';


  //slider category Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-banner-slider .blockspare-posts-block-post-category{
        margin-top: ' . $attributes['sliderCategoryMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['sliderCategoryMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['sliderCategoryMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['sliderCategoryMarginRight'] . "px" . ';
    }';

  //slider meta Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-banner-slider .blockspare-posts-block-post-grid-byline{
        margin-top: ' . $attributes['sliderMetaMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['sliderMetaMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['sliderMetaMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['sliderMetaMarginRight'] . "px" . ';
    }';

  ///block Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper{
        --gap: ' . $attributes['gutter'] . "px" . ';
        margin-top: ' . $attributes['marginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['marginBottom'] . "px" . ';
        margin-left: ' . $attributes['marginLeft'] . "px" . ';
        margin-right: ' . $attributes['marginRight'] . "px" . ';
    }';

  ///content Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper .blockspare-banner-slider-wrapper .blockspare-posts-block-post-content{
        padding-top: ' . $attributes['contentPaddingTop'] . "px" . ';
        padding-Bottom: ' . $attributes['contentPaddingBottom'] . "px" . ';
        padding-left: ' . $attributes['contentPaddingLeft'] . "px" . ';
        padding-right: ' . $attributes['contentPaddingRight'] . "px" . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper .blockspare-editor-picks-items .blockspare-posts-block-post-content{
        padding-top: ' . $attributes['contentPaddingTop'] . "px" . ';
        padding-Bottom: ' . $attributes['contentPaddingBottom'] . "px" . ';
        padding-left: ' . $attributes['contentPaddingLeft'] . "px" . ';
        padding-right: ' . $attributes['contentPaddingRight'] . "px" . ';
    }';

  ///border radius
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper:not(.blockspare-banner-11-main-wrapper) .blockspare-banner-slider-wrapper{
        border-radius: ' . $attributes['borderRadius'] . "px" . ';
        overflow: ' . "hidden" . ';
    }';

  if ($attributes['sliderBackground']) {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-11-main-wrapper .blockspare-banner-slider-wrapper{
            border-radius: ' . $attributes['borderRadius'] . "px" . ';
            overflow: ' . "hidden" . ';
        }';
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-11-main-wrapper .blockspare-banner-slider-wrapper .blockspare-posts-block-post-img{
            border-radius: ' . $attributes['borderRadius'] . "px" . ';
            overflow: ' . "hidden" . ';
        }';
  }

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper .blockspare-editor-picks-items .blockspare-post-items{
        border-radius: ' . $attributes['borderRadius'] . "px" . ';
        overflow: ' . "hidden" . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper .blockspare-banner-trending-carousel-wrapper .blockspare-post-items.has-bg-layout{
        border-radius: ' . $attributes['borderRadius'] . "px" . ';
        overflow: ' . "hidden" . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-wrapper .blockspare-banner-trending-carousel-wrapper .blockspare-post-items:not(.has-bg-layout) .blockspare-posts-block-post-img{
        border-radius: ' . $attributes['borderRadius'] . "px" . ';
        overflow: ' . "hidden" . ';
    }';


  // slider category border-radius
  if ($attributes['sliderCategoryLayoutOption'] == 'border' || $attributes['sliderCategoryLayoutOption'] == 'solid') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
            border-radius:' . $attributes['sliderCategoryBorderRadius'] . "px" . ';
        }';
  }

  // slider category  border
  if ($attributes['sliderCategoryLayoutOption'] == 'border') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
            border-style: solid;
            border-width:' . $attributes['sliderCategoryBorderWidth'] . "px" . ';
        }';
  }

  // slider  category  underline
  if ($attributes['sliderCategoryLayoutOption'] == 'underline') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
            border-bottom-style: solid;
            border-bottom-width:' . $attributes['sliderCategoryBorderWidth'] . "px" . ';
            padding-left: 0;
            padding-right: 0;
        }';
  }

  // slider Category colors
  if ($attributes['sliderColorType'] == 'bs-single-color') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
            color:' . $attributes['sliderCategoryTextColor'] . "!important" . ';
        }';
    if ($attributes['sliderCategoryLayoutOption'] == 'solid') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
                background-color:' . $attributes['sliderCategoryBackgroundColor'] . "!important" . ';
            }';
    }
    if ($slider_grid) {
      if ($attributes['sliderCategoryLayoutOption'] == 'border' || $attributes['sliderCategoryLayoutOption'] == 'underline') {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
                    border-color:' . $attributes['sliderGridCategoryBorderColor'] . ';
                }';
      }
    } else {
      if ($attributes['sliderCategoryLayoutOption'] == 'border' || $attributes['sliderCategoryLayoutOption'] == 'underline') {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
                    border-color:' . $attributes['sliderCategoryBorderColor'] . ';
                }';
      }
    }
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
            color:' . $attributes['sliderCategoryTextColor'] . "!important" . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
            color:' . $attributes['sliderSecondCategoryTextColor'] . "!important" . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
            color:' . $attributes['sliderThirdCategoryTextColor'] . "!important" . ';
        }';
    if ($attributes['sliderCategoryLayoutOption'] == 'solid') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                background-color:' . $attributes['sliderCategoryBackgroundColor'] . "!important" . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                background-color:' . $attributes['sliderSecondCategoryBackgroundColor'] . "!important" . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                background-color:' . $attributes['sliderThirdCategoryBackgroundColor'] . "!important" . ';
            }';
    }
    if ($slider_grid) {
      if ($attributes['sliderCategoryLayoutOption'] == 'border' || $attributes['sliderCategoryLayoutOption'] == 'underline') {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                    border-color:' . $attributes['sliderGridCategoryBorderColor'] . ';
                }';
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                    border-color:' . $attributes['sliderGridSecondCategoryBorderColor'] . ';
                }';
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                    border-color:' . $attributes['sliderGridThirdCategoryBorderColor'] . ';
                }';
      }
    } else {
      if ($attributes['sliderCategoryLayoutOption'] == 'border' || $attributes['sliderCategoryLayoutOption'] == 'underline') {
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                    border-color:' . $attributes['sliderCategoryBorderColor'] . ';
                }';
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                    border-color:' . $attributes['sliderSecondCategoryBorderColor'] . ';
                }';
        $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                    border-color:' . $attributes['sliderThirdCategoryBorderColor'] . ';
                }';
      }
    }
  }

  //slider nav color
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper span:before{
        color:' . $attributes['sliderNavigationColor'] . ';
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-wrap .blockspare-banner-slider-wrapper .slick-slider .slick-dots > li button{
        background-color:' . $attributes['sliderNavigationColor'] . ';
        }';

  if ($attributes['sliderNextPrevShow']) {
    if ($attributes['sliderNavigationShape'] === 'bs-navigation-1' || $attributes['sliderNavigationShape'] === 'bs-navigation-2') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider .slick-arrow:after{
                background-color:' . $attributes['sliderNavigationShapeColor'] . ';
                }';
    } elseif ($attributes['sliderNavigationShape'] === 'bs-navigation-3' || $attributes['sliderNavigationShape'] === 'bs-navigation-4') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider .slick-arrow{
                border-color:' . $attributes['sliderNavigationShapeColor'] . ';
                }';
    } else {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider .slick-slider .slick-arrow{
                border-color:' . "transparent" . ';
                background-color:' . "transparent" . ';
                }';
    }
  }

  //slider overlay color
  if ($blockName == 'blockspare-banner-1' || $blockName == 'blockspare-banner-2' || $blockName == 'blockspare-banner-3' || $blockName == 'blockspare-banner-4') {
    if ($attributes['bannerOneLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerOneLayout'] === 'banner-style-2 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-2 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-2 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-2 has-bg-layout') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-img::before{
                background:' . "linear-gradient(to bottom, rgba(0, 0, 0, 0) 40%, " . $attributes['sliderPostOverlayColor'] . " 100%)" . ';
            }';
    }
    if ($attributes['bannerOneLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerOneLayout'] === 'banner-style-4 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-4 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-4 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-4 has-bg-layout') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link{
                background:' . $attributes['sliderPostOverlayColor'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-byline{
                background:' . $attributes['sliderPostOverlayColor'] . ';
            }';
    }
    if ($attributes['bannerOneLayout'] === 'banner-style-5' || $attributes['bannerOneLayout'] === 'banner-style-6' || $attributes['bannerTwoLayout'] === 'banner-style-5' || $attributes['bannerTwoLayout'] === 'banner-style-6' || $attributes['bannerThreeLayout'] === 'banner-style-5' || $attributes['bannerThreeLayout'] === 'banner-style-6' || $attributes['bannerFourLayout'] === 'banner-style-5' || $attributes['bannerFourLayout'] === 'banner-style-6') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-content::after{
                background:' . $attributes['sliderPostOverlayColor'] . ';
            }';
    }
    if ($attributes['bannerOneLayout'] === 'banner-style-7' || $attributes['bannerOneLayout'] === 'banner-style-8' || $attributes['bannerTwoLayout'] === 'banner-style-7' || $attributes['bannerTwoLayout'] === 'banner-style-8' || $attributes['bannerThreeLayout'] === 'banner-style-7' || $attributes['bannerThreeLayout'] === 'banner-style-8' || $attributes['bannerFourLayout'] === 'banner-style-7' || $attributes['bannerFourLayout'] === 'banner-style-8') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-img::before{
                background:' . $attributes['sliderPostOverlayColor'] . ';
            }';
    }
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-img::before{
            background:' . "linear-gradient(to bottom, rgba(0, 0, 0, 0) 40%, " . $attributes['sliderPostOverlayColor'] . " 100%)" . ';
        }';
  }


  //trending Bg color

  $bg = 'transparent';

  if ($blockName == 'blockspare-banner-1') {
    $bg = $attributes['bannerOneTrendingBg'];
  } else if ($blockName == 'blockspare-banner-2') {
    $bg = $attributes['bannerTwoTrendingBg'];
  } else if ($blockName == 'blockspare-banner-3') {
    $bg = $attributes['bannerThreeTrendingBg'];
  } else if ($blockName == 'blockspare-banner-4') {
    $bg = $attributes['bannerFourTrendingBg'];
  } else if ($blockName == 'blockspare-banner-5') {
    $bg = $attributes['bannerFiveTrendingBg'];
  } else if ($blockName == 'blockspare-banner-6') {
    $bg = $attributes['bannerSixTrendingBg'];
  } else if ($blockName == 'blockspare-banner-7') {
    $bg = $attributes['bannerSevenTrendingBg'];
  } else if ($blockName == 'blockspare-banner-8') {
    $bg = $attributes['bannerEightTrendingBg'];
  } else if ($blockName == 'blockspare-banner-9') {
    $bg = $attributes['bannerNineTrendingBg'];
  } else if ($blockName == 'blockspare-banner-10') {
    $bg = $attributes['bannerTenTrendingBg'];
  } else if ($blockName == 'blockspare-banner-11') {
    $bg = $attributes['bannerElevenTrendingBg'];
  } else if ($blockName == 'blockspare-banner-12') {
    $bg = $attributes['bannerTwelveTrendingBg'];
  }

  if ($attributes['trendingBackground']) {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-post-items.has-bg-layout .blockspare-post-data{
            background-color:' . $bg . ';
        }';
  }


  //Trending Title Meta Color
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-title a span{
        color:' . $attributes['trendingPostTitleColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-title{
        line-height:' . $attributes['trendingTitleLineHeight'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-author a span{
        color:' . $attributes['trendingPostLinkColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-text-link a{
        color:' . $attributes['trendingPostLinkColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-date{
        color:' . $attributes['trendingPostGeneralColor'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .comment_count{
        color:' . $attributes['trendingPostGeneralColor'] . ';
    }';

  //trending Title Hover

  if ($attributes['trendingTitleOnHover'] == 'lpc-title-hover') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-content.has-trending-title-hover .blockspare-posts-block-title-link:hover span{
        color: ' . $attributes['trendingTitleOnHoverColor'] . ';
        
         }';
  }

  //trending title Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-title{
        margin-top: ' . $attributes['trendingTitleMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['trendingTitleMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['trendingTitleMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['trendingTitleMarginRight'] . "px" . ';
    }';

  //trending category Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category{
        margin-top: ' . $attributes['trendingCategoryMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['trendingCategoryMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['trendingCategoryMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['trendingCategoryMarginRight'] . "px" . ';
    }';

  //trending meta Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-byline{
        margin-top: ' . $attributes['trendingMetaMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['trendingMetaMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['trendingMetaMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['trendingMetaMarginRight'] . "px" . ';
    }';


  if ($attributes['trendingTitleOnHover'] == 'lpc-title-border') {

    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-content.has-trending-title-hover .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link span:hover{
            box-shadow: inset 0 -2px 0 0 ' . $attributes['trendingTitleOnHoverColor'] . ';
            
            }';
  }

  // trending category border-radius
  if ($attributes['trendingCategoryLayoutOption'] == 'border' || $attributes['trendingCategoryLayoutOption'] == 'solid') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
            border-radius:' . $attributes['trendingCategoryBorderRadius'] . "px" . ';
        }';
  }

  // trending category  border
  if ($attributes['trendingCategoryLayoutOption'] == 'border') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
            border-style: solid;
            border-width:' . $attributes['trendingCategoryBorderWidth'] . "px" . ';
        }';
  }

  // trending  category  underline
  if ($attributes['trendingCategoryLayoutOption'] == 'underline') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
            border-bottom-style: solid;
            border-bottom-width:' . $attributes['trendingCategoryBorderWidth'] . "px" . ';
            padding-left: 0;
            padding-right: 0;
        }';
  }

  // trending Category colors
  if ($attributes['trendingColorType'] == 'bs-single-color') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
            color:' . $attributes['trendingCategoryTextColor'] . "!important" . ';
        }';
    if ($attributes['trendingCategoryLayoutOption'] == 'solid') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
                background-color:' . $attributes['trendingCategoryBackgroundColor'] . "!important" . ';
            }';
    }
    if ($attributes['trendingCategoryLayoutOption'] == 'border' || $attributes['trendingCategoryLayoutOption'] == 'underline') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
                border-color:' . $attributes['trendingCategoryBorderColor'] . ';
            }';
    }
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
            color:' . $attributes['trendingCategoryTextColor'] . "!important" . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
            color:' . $attributes['trendingSecondCategoryTextColor'] . "!important" . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
            color:' . $attributes['trendingThirdCategoryTextColor'] . "!important" . ';
        }';
    if ($attributes['trendingCategoryLayoutOption'] == 'solid') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                background-color:' . $attributes['trendingCategoryBackgroundColor'] . "!important" . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                background-color:' . $attributes['trendingSecondCategoryBackgroundColor'] . "!important" . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                background-color:' . $attributes['trendingThirdCategoryBackgroundColor'] . "!important" . ';
            }';
    }
    if ($attributes['trendingCategoryLayoutOption'] == 'border' || $attributes['trendingCategoryLayoutOption'] == 'underline') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                border-color:' . $attributes['trendingCategoryBorderColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                border-color:' . $attributes['trendingSecondCategoryBorderColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                border-color:' . $attributes['trendingThirdCategoryBorderColor'] . ';
            }';
    }
  }

  //Trending nav color
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper span:before{
        color:' . $attributes['trendingNavigationColor'] . ';
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .slick-slider .slick-dots > li button{
        background-color:' . $attributes['trendingNavigationColor'] . ';
        }';

  if ($attributes['trendingNextPrevShow']) {
    if ($attributes['trendingNavigationShape'] == 'bs-navigation-1' || $attributes['trendingNavigationShape'] == 'bs-navigation-2') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .slick-slider .slick-arrow:after{
                background-color:' . $attributes['trendingNavigationShapeColor'] . ';
                }';
    } elseif ($attributes['trendingNavigationShape'] == 'bs-navigation-3' || $attributes['trendingNavigationShape'] == 'bs-navigation-4') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .slick-slider .slick-arrow{
                border-color:' . $attributes['trendingNavigationShapeColor'] . ';
                }';
    } else {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-wrap .blockspare-banner-trending-carousel-wrapper .slick-slider .slick-arrow{
                border-color:' . "transparent" . ';
                background-color:' . "transparent" . ';
                }';
    }
  }

  // trending tab

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-trending-tabs .components-tab-panel__tabs .blockspare-trending-tab i{
        color:' . $attributes['trendingTabIconColor'] . ';
        font-size:' . $attributes['trendingTabIconSize'] . "px" . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-trending-tabs .components-tab-panel__tabs .blockspare-trending-tab{
        color:' . $attributes['trendingTabTextColor'] . ';
        background-color:' . $attributes['trendingTabBgColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-trending-tabs .components-tab-panel__tabs .blockspare-trending-tab.active-tab{
        background-color:' . $attributes['trendingTabActiveColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-trending-tabs .components-tab-panel__tabs{
        border-color:' . $attributes['trendingTabActiveColor'] . " !important" . ';
    }';


  //Editor Picks Title Meta Color
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-title a span{
        color:' . $attributes['editorPostTitleColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-title{
        line-height:' . $attributes['editorTitleLineHeight'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-author a span{
        color:' . $attributes['editorPostLinkColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-text-link a{
        color:' . $attributes['editorPostLinkColor'] . ';
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-date{
        color:' . $attributes['editorPostGeneralColor'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .comment_count{
        color:' . $attributes['editorPostGeneralColor'] . ';
    }';

  //sliderTitle Hover

  if ($attributes['editorTitleOnHover'] == 'lpc-title-hover') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content.has-editor-title-hover .blockspare-posts-block-title-link:hover span{
            color: ' . $attributes['editorTitleOnHoverColor'] . ';
        }';
  }

  if ($attributes['editorTitleOnHover'] == 'lpc-title-border') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-posts-block-post-content.has-editor-title-hover .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link span:hover{
            box-shadow: inset 0 -2px 0 0 ' . $attributes['editorTitleOnHoverColor'] . '; 
        }';
  }

  //editor title Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-editor-picks-items .blockspare-posts-block-post-grid-title{
        margin-top: ' . $attributes['editorTitleMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['editorTitleMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['editorTitleMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['editorTitleMarginRight'] . "px" . ';
    }';

  //editor category Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-editor-picks-items .blockspare-posts-block-post-category{
        margin-top: ' . $attributes['editorCategoryMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['editorCategoryMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['editorCategoryMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['editorCategoryMarginRight'] . "px" . ';
    }';

  //editor meta Gaps
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-editor-picks-items .blockspare-posts-block-post-grid-byline{
        margin-top: ' . $attributes['editorMetaMarginTop'] . "px" . ';
        margin-Bottom: ' . $attributes['editorMetaMarginBottom'] . "px" . ';
        margin-left: ' . $attributes['editorMetaMarginLeft'] . "px" . ';
        margin-right: ' . $attributes['editorMetaMarginRight'] . "px" . ';
    }';


  // editor category border-radius
  if ($attributes['editorCategoryLayoutOption'] == 'border' || $attributes['editorCategoryLayoutOption'] == 'solid') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
            border-radius:' . $attributes['editorCategoryBorderRadius'] . "px" . ';
        }';
  }

  // editor category  border
  if ($attributes['editorCategoryLayoutOption'] == 'border') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
            border-style: solid;
            border-width:' . $attributes['editorCategoryBorderWidth'] . "px" . ';
        }';
  }

  // editor  category  underline
  if ($attributes['editorCategoryLayoutOption'] == 'underline') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
            border-bottom-style: solid;
            border-bottom-width:' . $attributes['editorCategoryBorderWidth'] . "px" . ';
            padding-left: 0;
            padding-right: 0;
        }';
  }

  // editor Category colors
  if ($attributes['editorColorType'] == 'bs-single-color') {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
            color:' . $attributes['editorCategoryTextColor'] . "!important" . ';
        }';
    if ($attributes['editorCategoryLayoutOption'] == 'solid') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
                background-color:' . $attributes['editorCategoryBackgroundColor'] . "!important" . ';
            }';
    }
    if ($attributes['editorCategoryLayoutOption'] == 'border' || $attributes['editorCategoryLayoutOption'] == 'underline') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
                border-color:' . $attributes['editorCategoryBorderColor'] . ';
            }';
    }
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
            color:' . $attributes['editorCategoryTextColor'] . "!important" . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
            color:' . $attributes['editorSecondCategoryTextColor'] . "!important" . ';
        }';
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
            color:' . $attributes['editorThirdCategoryTextColor'] . "!important" . ';
        }';
    if ($attributes['editorCategoryLayoutOption'] == 'solid') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                background-color:' . $attributes['editorCategoryBackgroundColor'] . "!important" . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                background-color:' . $attributes['editorSecondCategoryBackgroundColor'] . "!important" . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                background-color:' . $attributes['editorThirdCategoryBackgroundColor'] . "!important" . ';
            }';
    }
    if ($attributes['editorCategoryLayoutOption'] == 'border' || $attributes['editorCategoryLayoutOption'] == 'underline') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 1){
                border-color:' . $attributes['editorCategoryBorderColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n + 2){
                border-color:' . $attributes['editorSecondCategoryBorderColor'] . ';
            }';
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a:nth-child(3n){
                border-color:' . $attributes['editorThirdCategoryBorderColor'] . ';
            }';
    }
  }

  //Editor overlay color
  if ($blockName == 'blockspare-banner-1' || $blockName == 'blockspare-banner-2' || $blockName == 'blockspare-banner-3' || $blockName == 'blockspare-banner-4') {
    if ($attributes['bannerOneLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerOneLayout'] === 'banner-style-2 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-2 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-2 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-1 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-2 has-bg-layout') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-img::before{
                background:' . "linear-gradient(to bottom, rgba(0, 0, 0, 0) 40%, " . $attributes['editorPostOverlayColor'] . " 100%)" . ';
            }';
    }
    if ($attributes['bannerOneLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerOneLayout'] === 'banner-style-4 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerTwoLayout'] === 'banner-style-4 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerThreeLayout'] === 'banner-style-4 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-3 has-bg-layout' || $attributes['bannerFourLayout'] === 'banner-style-4 has-bg-layout') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-title .blockspare-posts-block-title-link{
                background:' . $attributes['editorPostOverlayColor'] . ';
            }';

      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-content .blockspare-posts-block-post-grid-byline{
                background:' . $attributes['editorPostOverlayColor'] . ';
            }';
    }
    if ($attributes['bannerOneLayout'] === 'banner-style-5' || $attributes['bannerOneLayout'] === 'banner-style-6' || $attributes['bannerTwoLayout'] === 'banner-style-5' || $attributes['bannerTwoLayout'] === 'banner-style-6' || $attributes['bannerThreeLayout'] === 'banner-style-5' || $attributes['bannerThreeLayout'] === 'banner-style-6' || $attributes['bannerFourLayout'] === 'banner-style-5' || $attributes['bannerFourLayout'] === 'banner-style-6') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-content::after{
                background:' . $attributes['editorPostOverlayColor'] . ';
            }';
    }
    if ($attributes['bannerOneLayout'] === 'banner-style-7' || $attributes['bannerOneLayout'] === 'banner-style-8' || $attributes['bannerTwoLayout'] === 'banner-style-7' || $attributes['bannerTwoLayout'] === 'banner-style-8' || $attributes['bannerThreeLayout'] === 'banner-style-7' || $attributes['bannerThreeLayout'] === 'banner-style-8' || $attributes['bannerFourLayout'] === 'banner-style-7' || $attributes['bannerFourLayout'] === 'banner-style-8') {
      $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-img::before{
                background:' . $attributes['editorPostOverlayColor'] . ';
            }';
    }
  } else {
    $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-post-data .blockspare-posts-block-post-img::before{
            background:' . "linear-gradient(to bottom, rgba(0, 0, 0, 0) 40%, " . $attributes['editorPostOverlayColor'] . " 100%)" . ';
        }';
  }


  /**
   * Font Size styles
   */

  //Slider Title Font size
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
          
        font-size: ' . $attributes['sliderTitleFontSize'] . $attributes['sliderTitleFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['sliderTitleFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['sliderTitleFontWeight']) . ';
      
         }';

  //Category Fornt
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
          
        font-size: ' . $attributes['sliderCategoryFontSize'] . $attributes['sliderTitleFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['sliderCategoryFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['sliderCategoryFontWeight']) . ';
          
             }';

  //Editor picks
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
          
        font-size: ' . $attributes['editorTitleFontSize'] . $attributes['editorTitleFontSizeType'] . ';
        
        ' . bscheckFontfamily($attributes['editorTitleFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['editorTitleFontWeight']) . ';
      
         }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-category a{
          
            font-size: ' . $attributes['editorCategoryFontSize'] . $attributes['editorTitleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['editorCategoryFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['editorCategoryFontWeight']) . ';
              
                 }';
  //Trending Carousel


  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title {
          
        font-size: ' . $attributes['trendingTitleFontSize'] . $attributes['trendingTitleFontSizeType'] . ';
        
        ' . bscheckFontfamily($attributes['trendingTitleFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['trendingTitleFontWeight']) . ';
          
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-category a{
          
            font-size: ' . $attributes['trendingCategoryFontSize'] . $attributes['trendingTitleFontSizeType'] . ';
            ' . bscheckFontfamily($attributes['trendingCategoryFontFamily']) . ';
            ' . bscheckFontfamilyWeight($attributes['trendingCategoryFontWeight']) . ';
              
                 }';

  //Slider Meta
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-author a span{
            
        font-size: ' . $attributes['sliderMetaFontSize'] . $attributes['sliderMetaFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['sliderMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['sliderMetaFontWeight']) . ';
    
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-date{
        
        font-size: ' . $attributes['sliderMetaFontSize'] . $attributes['sliderMetaFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['sliderMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['sliderMetaFontWeight']) . ';
    
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .comment_count{
    
        font-size: ' . $attributes['sliderMetaFontSize'] . $attributes['sliderMetaFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['sliderMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['sliderMetaFontWeight']) . ';
    
    }';
  //Editor picks Meta
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-author a span{
          
        font-size: ' . $attributes['editorMetaFontSize'] . $attributes['editorTitleFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['editorMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['editorMetaFontWeight']) . ';
      
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-date{
          
        font-size: ' . $attributes['editorMetaFontSize'] . $attributes['editorTitleFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['editorMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['editorMetaFontWeight']) . ';
      
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .comment_count{
          
        font-size: ' . $attributes['editorMetaFontSize'] . $attributes['editorTitleFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['editorMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['editorMetaFontWeight']) . ';
      
    }';

  //Trending Carousel Meta
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-author a span{
            
        font-size: ' . $attributes['trendingMetaFontSize'] . $attributes['trendingMetaFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['trendingMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['trendingMetaFontWeight']) . ';
        
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-date{
            
        font-size: ' . $attributes['trendingMetaFontSize'] . $attributes['trendingMetaFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['trendingMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['trendingMetaFontWeight']) . ';
        
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .comment_count{
            
        font-size: ' . $attributes['trendingMetaFontSize'] . $attributes['trendingMetaFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['trendingMetaFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['trendingMetaFontFamily']) . ';
        
    }';

  // trending tab font size
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-trending-tabs .components-tab-panel__tabs .blockspare-trending-tab{
            
        font-size: ' . $attributes['trendingTabFontSize'] . $attributes['trendingTabFontSizeType'] . ';
        ' . bscheckFontfamily($attributes['trendingTabFontFamily']) . ';
        ' . bscheckFontfamilyWeight($attributes['trendingTabFontWeight']) . ';
        
    }';

  $inline_css .= '@media (max-width: 1025px) { ';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
        font-size: ' . $attributes['sliderTitleFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
          
        font-size: ' . $attributes['sliderCategoryFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';    
    }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
        font-size: ' . $attributes['editorTitleFontSizeTablet'] . $attributes['editorTitleFontSizeType'] . ';
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-editor-picks-wrapper .blockspare-posts-block-post-category a{
          
            font-size: ' . $attributes['editorCategoryFontSizeTablet'] . $attributes['editorTitleFontSizeType'] . ';    
            }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
          
        font-size: ' . $attributes['trendingTitleFontSizeTablet'] . $attributes['trendingTitleFontSizeType'] . ';          
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
          
        font-size: ' . $attributes['trendingTitleFontSizeTablet'] . $attributes['trendingTitleFontSizeType'] . ';          
        }';

  //Meta
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-author a span{
        font-size: ' . $attributes['sliderMetaFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-date{
        font-size: ' . $attributes['sliderMetaFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .comment_count{
        font-size: ' . $attributes['sliderMetaFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-author a span{
        font-size: ' . $attributes['editorMetaFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-date{
        font-size: ' . $attributes['editorMetaFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .comment_count{
        font-size: ' . $attributes['editorMetaFontSizeTablet'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-author a span{
        font-size: ' . $attributes['trendingMetaFontSizeTablet'] . $attributes['trendingMetaFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . '  .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-date{
        font-size: ' . $attributes['trendingMetaFontSizeTablet'] . $attributes['trendingMetaFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper  .comment_count{
        font-size: ' . $attributes['trendingMetaFontSizeTablet'] . $attributes['trendingMetaFontSizeType'] . ';
    }';
  //End Meta  

  // trending tab font size  
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-trending-tabs .components-tab-panel__tabs .blockspare-trending-tab{
        font-size: ' . $attributes['trendingTabFontSizeTablet'] . $attributes['trendingTabFontSizeType'] . ';
        }';

  $inline_css .= '}';

  $inline_css .= '@media (max-width: 767px) { ';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
        font-size: ' . $attributes['sliderTitleFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-category a{
          
        font-size: ' . $attributes['sliderCategoryFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';    
        }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
        font-size: ' . $attributes['editorTitleFontSizeMobile'] . $attributes['editorTitleFontSizeType'] . ';
        }';


  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-editor-picks-wrapper .blockspare-posts-block-post-category a{
          
            font-size: ' . $attributes['editorCategoryFontSizeMobile'] . $attributes['editorTitleFontSizeType'] . ';    
            }';

  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-post-items .blockspare-posts-block-post-grid-title{
        font-size: ' . $attributes['trendingTitleFontSizeMobile'] . $attributes['trendingTitleFontSizeType'] . ';          
        }';

  //Meta
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-author a span{
        font-size: ' . $attributes['sliderMetaFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .blockspare-posts-block-post-grid-date{
        font-size: ' . $attributes['sliderMetaFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-slider-wrapper .comment_count{
        font-size: ' . $attributes['sliderMetaFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-author a span{
        font-size: ' . $attributes['editorMetaFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .blockspare-posts-block-post-grid-date{
        font-size: ' . $attributes['editorMetaFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-editor-picks-wrapper .comment_count{
        font-size: ' . $attributes['editorMetaFontSizeMobile'] . $attributes['sliderTitleFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-author a span{
        font-size: ' . $attributes['trendingMetaFontSizeMobile'] . $attributes['trendingMetaFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-posts-block-post-grid-date{
        font-size: ' . $attributes['trendingMetaFontSizeMobile'] . $attributes['trendingMetaFontSizeType'] . ';
    }';
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper  .comment_count{
        font-size: ' . $attributes['trendingMetaFontSizeMobile'] . $attributes['trendingMetaFontSizeType'] . ';
    }';

  // trending tab font size
  $inline_css .= ' .' . $blockuniqueclass . ' .blockspare-banner-trending-carousel-wrapper .blockspare-trending-tabs .components-tab-panel__tabs .blockspare-trending-tab{
        font-size: ' . $attributes['trendingTabFontSizeMobile'] . $attributes['trendingTabFontSizeType'] . ';
        }';


  if (!empty($inline_css)) {
    $rand =  $blockuniqueclass;
    wp_register_style('bs-banners' . $rand, false);
    wp_enqueue_style('bs-banners' . $rand);
    wp_add_inline_style('bs-banners' . $rand, blockspare_minify_css($inline_css));
  }
}
