/**
 * External dependencies
 */
import compact from 'lodash/compact';
import map from 'lodash/map';
/**
 * Latest Post Box depedencies
 */

import ImageDesignStyleFull1 from '../../utils/component/design-separator-control/images/blockspare-posts-block-full-layout1.png';
import ImageDesignStyleFull2 from '../../utils/component/design-separator-control/images/blockspare-posts-block-full-layout2.png';
import ImageDesignStyleFull3 from '../../utils/component/design-separator-control/images/blockspare-posts-block-full-layout3.png';
import ImageDesignStyleFull4 from '../../utils/component/design-separator-control/images/blockspare-posts-block-full-layout4.png';
import ImageDesignStyleFull5 from '../../utils/component/design-separator-control/images/blockspare-posts-block-full-layout5.png';
import ImageDesignStyleFull6 from '../../utils/component/design-separator-control/images/blockspare-posts-block-full-layout6.png';

import ImageDesignStyleContent1 from '../../utils/component/design-separator-control/images/blockspare-posts-block-content-order-layout-1.png';
import ImageDesignStyleContent2 from '../../utils/component/design-separator-control/images/blockspare-posts-block-content-order-layout-2.png';
import ImageDesignStyleContent3 from '../../utils/component/design-separator-control/images/blockspare-posts-block-content-order-layout-3.png';
import ImageDesignStyleContent4 from '../../utils/component/design-separator-control/images/blockspare-posts-block-content-order-layout-4.png';
import ImageDesignStyleContent5 from '../../utils/component/design-separator-control/images/blockspare-posts-block-content-order-layout-5.png';
import ImageDesignStyleContent6 from '../../utils/component/design-separator-control/images/blockspare-posts-block-content-order-layout-6.png';
import DesignPanelBody from '../../utils/component/design-panel-body';

import Margin from '../../utils/margin';
import TypographyControl from '../../utils/component/typography';
import BoxShadow from '../../utils/component/boxshadow';
import ImageFilltyle1 from '../../utils/component/design-separator-control/images/category-fill.png';
import ImageBorderStyle2 from '../../utils/component/design-separator-control/images/category-border.png';
import ImageNoneStyle3 from '../../utils/component/design-separator-control/images/category-none.png';
import BSIconSettings from '../../utils/post-meta-icons/icon-settings';
/**
 * WordPress dependencies
 */
import { Component } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
const { addFilter, applyFilters } = wp.hooks;
const MAX_POSTS_COLUMNS = 6;
// Import block components
import { InspectorControls, PanelColorSettings } from '@wordpress/block-editor';

// Import Inspector components
import {
	PanelBody,
	QueryControls,
	RangeControl,
	SelectControl,
	TextControl,
	ToggleControl,
} from '@wordpress/components';

const { addQueryArgs } = wp.url;

const { apiFetch } = wp;

/**
 * Create an Inspector Controls wrapper Component
 */
export default class Inspector extends Component {
	constructor() {
		super( ...arguments );
		this.state = { categoriesList: [] };
	}

	componentDidMount() {
		this.stillMounted = true;
		this.fetchRequest = apiFetch( {
			path: addQueryArgs( '/wp/v2/categories', { per_page: -1 } ),
		} )
			.then( ( categoriesList ) => {
				if ( this.stillMounted ) {
					this.setState( { categoriesList } );
				}
			} )
			.catch( () => {
				if ( this.stillMounted ) {
					this.setState( { categoriesList: [] } );
				}
			} );
	}

	componentWillUnmount() {
		this.stillMounted = false;
	}

	imageSizeSelect() {
		const getSettings = wp?.data
			?.select( 'core/editor' )
			?.getEditorSettings();

		return compact(
			map( getSettings?.imageSizes, ( { name, slug } ) => {
				return {
					value: slug,
					label: name,
				};
			} )
		);
	}

	render() {
		// Setup the attributes
		const {
			attributes: {
				postType,
				displayPostTitle,
				PostTitleLength,
				displayPostCategory,
				displayPostAuthor,
				displayPostDate,
				displayPostExcerpt,
				displayPostLink,
				excerptLength,
				readMoreText,
				design = 'blockspare-posts-block-list-layout-1',
				enableTwoColumn,
				grid = 'blockspare-posts-block-grid-layout-1',
				tile = 'blockspare-posts-block-tile-layout-1',
				express = 'blockspare-posts-block-express-layout-1',
				full = 'blockspare-posts-block-full-layout-1',
				columns,
				postsToShow,
				backGroundColor,
				enableBackgroundColor,
				marginTop,
				marginBottom,
				imageSize,
				order,
				orderBy,
				categories,
				offset,
				contentOrder,
				postTitleColor,
				postTitleFontSize,
				linkColor,
				generalColor,
				borderRadius,
				enableBoxShadow,
				xOffset,
				yOffset,
				blur,
				spread,
				shadowColor,

				titleLoadGoogleFonts,
				titleFontFamily,
				titleFontWeight,
				titleFontSubset,
				titleFontSizeType,
				titleFontSizeMobile,
				titleFontSizeTablet,

				descriptionFontSize,
				descriptionFontFamily,
				descriptionFontWeight,
				descriptionFontSubset,
				descriptionFontSizeType,
				descriptionFontSizeMobile,
				descriptionFontSizeTablet,
				descriptionLoadGoogleFonts,
				postListingOption,
				tileGaps,

				contentPaddingTop,
				contentPaddingLeft,
				contentPaddingBottom,
				contentPaddingRight,
				categoryMarginTop,
				categoryMarginBottom,
				titleMarginTop,
				titleMarginBottom,
				metaMarginTop,
				metaMarginBottom,
				exceprtMarginTop,
				exceprtMarginBottom,
				moreLinkMarginTop,
				moreLinkMarginBottom,

				categoryLayoutOption,
				categoryTextColor,
				categoryBackgroundColor,
				categoryBorderColor,
				categoryBorderWidth,
				categoryBorderRadius,

				tilePostTitleColor,
				tilePostLinkColor,
				tilePostGeneralColor,

				authorIcon,
				dateIcon,
				enableComment,
				commentIcon,

				expressLayout5TextOverLink,
				expressLayout5TextOverGeneral,

				spostTitleFontSize,
				spostTitleFontFamily,
				spostTitleFontWeight,
				spostTitleFontSubset,
				spostTitleFontSizeType,
				spostTitleFontSizeMobile,
				spostTitleFontSizeTablet,
				spostTitleLoadGoogleFonts,

				displaySpotLightExceprt,

				spotCategoryTextColor,
				spotCategoryBorderColor,
				spotCategoryBackgroundColor,
			},
			attributes,
			setAttributes,
			latestPosts,
		} = this.props;

		const hasPosts = Array.isArray( latestPosts ) && latestPosts.length;

		//const {categoriesList} = this.state;
		const onChangeTitlecolor = ( value ) =>
			setAttributes( { postTitleColor: value } );
		const onChangeLinkcolor = ( value ) =>
			setAttributes( { linkColor: value } );
		const onChangeGeneralcolor = ( value ) =>
			setAttributes( { generalColor: value } );
		const onChangeBackgroundcolor = ( value ) =>
			setAttributes( { backGroundColor: value } );

		const onChangeCategoryTextcolor = ( value ) =>
			setAttributes( { categoryTextColor: value } );
		const onChangeCategoryBackgroundcolor = ( value ) =>
			setAttributes( { categoryBackgroundColor: value } );
		const onChangeCategoryBordercolor = ( value ) =>
			setAttributes( { categoryBorderColor: value } );

		const onChangeSpotCategoryTextcolor = ( value ) =>
			setAttributes( { spotCategoryTextColor: value } );
		const onChangeSpotCategoryBackgroundcolor = ( value ) =>
			setAttributes( { spotCategoryBackgroundColor: value } );
		const onChangeSpotCategoryBordercolor = ( value ) =>
			setAttributes( { spotCategoryBorderColor: value } );

		const imageSizeOptions = this.imageSizeSelect();

		const imageSizeValue = () => {
			for ( let i = 0; i < imageSizeOptions.length; i++ ) {
				if ( imageSizeOptions[ i ].value === imageSize ) {
					return imageSize;
				}
			}
			return 'full';
		};

		// Check the post type
		const isPost = postType === 'post';

		const contentListGridOption = [
			{
				value: 'blockspare-posts-block-latestpost-grid',
				label: __( 'Grid', 'blockspare' ),
			},
			{
				value: 'blockspare-posts-block-latestpost-list',
				label: __( 'List', 'blockspare' ),
			},
			{
				value: 'blockspare-posts-block-latestpost-full',
				label: __( 'Full', 'blockspare' ),
			},
			{
				value: 'blockspare-posts-block-latestpost-express',
				label: __( 'Express', 'blockspare' ),
			},
			{
				value: 'blockspare-posts-block-latestpost-tile',
				label: __( 'Tile', 'blockspare' ),
			},
		];

		const metaColorDate = {
			value: generalColor,
			onChange: onChangeGeneralcolor,
			label: __( 'General Color', 'blockspare' ),
		};

		const authorLinkColor = {
			value: linkColor,
			onChange: onChangeLinkcolor,
			label: __( 'Link Color', 'blockspare' ),
		};

		const categoryBgColor = {
			value: categoryBackgroundColor,
			onChange: onChangeCategoryBackgroundcolor,
			label: __( 'Background Color', 'blockspare' ),
		};

		const categoryBorderColors = {
			value: categoryBorderColor,
			onChange: onChangeCategoryBordercolor,
			label: __( 'Border Color', 'blockspare' ),
		};

		const spotCategoryTextColorOpt = {
			value: spotCategoryTextColor,
			onChange: onChangeSpotCategoryTextcolor,
			label: __( 'Text Over Color', 'blockspare' ),
		};

		const spotcategoryBgColor = {
			value: spotCategoryBackgroundColor,
			onChange: onChangeSpotCategoryBackgroundcolor,
			label: __( 'Text Over Background Color', 'blockspare' ),
		};

		const spotCategoryBorderColors = {
			value: spotCategoryBorderColor,
			onChange: onChangeSpotCategoryBordercolor,
			label: __( 'Text Over Border Color', 'blockspare' ),
		};

		const titlePostColors = {
			value: postTitleColor,
			onChange: onChangeTitlecolor,
			label: __( 'Title Color', 'blockspare' ),
		};

		const onChangeTileTitlecolor = ( value ) =>
			setAttributes( { tilePostTitleColor: value } );
		const tilePostColors = {
			value: tilePostTitleColor,
			onChange: onChangeTileTitlecolor,
			label: __( 'Title Over Image Color', 'blockspare' ),
		};

		const onChangeTileLinkcolor = ( value ) =>
			setAttributes( { tilePostLinkColor: value } );
		const onChangeTileGeneralcolor = ( value ) =>
			setAttributes( { tilePostGeneralColor: value } );

		const tileMetaColorDate = {
			value: tilePostGeneralColor,
			onChange: onChangeTileGeneralcolor,
			label: __( 'Text Over General  Color', 'blockspare' ),
		};

		const TileAuthorLinkColor = {
			value: tilePostLinkColor,
			onChange: onChangeTileLinkcolor,
			label: __( 'Text Over Link Color', 'blockspare' ),
		};

		const onChangeexpressTextOverLinkColor = ( value ) =>
			setAttributes( { expressLayout5TextOverLink: value } );
		const onChangeexpressTextOverGeneralColor = ( value ) =>
			setAttributes( { expressLayout5TextOverGeneral: value } );

		const expressTextOverLinkColor = {
			value: expressLayout5TextOverLink,
			onChange: onChangeexpressTextOverLinkColor,
			label: __( 'Text Over Link Color', 'blockspare' ),
		};

		const expressTextOverGeneralColor = {
			value: expressLayout5TextOverGeneral,
			onChange: onChangeexpressTextOverGeneralColor,
			label: __( 'Text Over General  Color', 'blockspare' ),
		};

		const categoriesList = JSON.parse( blockspare_globals.taxonomies );

		const categorySelect = {
			value: '',
			label: __( 'Select Category ' ),
		};

		categoriesList.unshift( categorySelect );

		let iconPanel = false;

		if (
			displayPostAuthor == true ||
			displayPostDate == true ||
			enableComment == true
		) {
			iconPanel = true;
		}

		return (
			<InspectorControls>
				<div className="blockspare-posts-block-inspector-wrapper">
					<PanelBody
						title={ __( 'Layout Options', 'blockspare' ) }
						className={
							isPost ? null : 'blockspare-posts-block-hide-query'
						}
						initialOpen={ false }
					>
						<SelectControl
							label={ __( 'Choose Layout', 'blockspare' ) }
							value={ postListingOption }
							options={ contentListGridOption }
							onChange={ ( value ) =>
								this.props.setAttributes( {
									postListingOption: value,
								} )
							}
						/>

						{ postListingOption ===
							'blockspare-posts-block-latestpost-list' && (
							<DesignPanelBody
								initialOpen={ true }
								selected={ design }
								paneltitle={ _( 'Layouts', 'blockspare' ) }
								options={ applyFilters(
									'blockspare-posts-block.cta.edit.layouts',
									[
										{
											label: __(
												'List Style 1',
												'blockspare'
											),
											value: 'blockspare-posts-block-list-layout-1',
											image: ImageDesignStyle1,
										},
										{
											label: __(
												'List Style 2',
												'blockspare'
											),
											value: 'blockspare-posts-block-list-layout-2',
											image: ImageDesignStyle2,
										},
										{
											label: __(
												'List List Style 3',
												'blockspare'
											),
											value: 'blockspare-posts-block-list-layout-3',
											image: ImageDesignStyle3,
										},
										{
											label: __(
												'List Style 4',
												'blockspare'
											),
											value: 'blockspare-posts-block-list-layout-4',
											image: ImageDesignStyle4,
										},
										{
											label: __(
												'List Style 5',
												'blockspare'
											),
											value: 'blockspare-posts-block-list-layout-5',
											image: ImageDesignStyle5,
										},
										{
											label: __(
												'List Style 6',
												'blockspare'
											),
											value: 'blockspare-posts-block-list-layout-6',
											image: ImageDesignStyle6,
										},
									]
								) }
								onChange={ ( design ) =>
									setAttributes( { design } )
								}
							></DesignPanelBody>
						) }
						{ postListingOption ===
							'blockspare-posts-block-latestpost-grid' && (
							<DesignPanelBody
								initialOpen={ true }
								selected={ grid }
								paneltitle={ 'Layout' }
								options={ applyFilters(
									'blockspare-posts-block.cta.edit.layouts',
									[
										{
											label: __(
												'Grid Style 1',
												'blockspare'
											),
											value: 'blockspare-posts-block-grid-layout-1',
											image: ImageDesignStyleGrid1,
										},
										{
											label: __(
												'Grid Style 2',
												'blockspare'
											),
											value: 'blockspare-posts-block-grid-layout-2',
											image: ImageDesignStyleGrid2,
										},
										{
											label: __(
												'Grid Style 3',
												'blockspare'
											),
											value: 'blockspare-posts-block-grid-layout-3',
											image: ImageDesignStyleGrid3,
										},
										{
											label: __(
												'Grid Style 4',
												'blockspare'
											),
											value: 'blockspare-posts-block-grid-layout-4',
											image: ImageDesignStyleGrid4,
										},
										{
											label: __(
												'Grid Style 5',
												'blockspare'
											),
											value: 'blockspare-posts-block-grid-layout-5',
											image: ImageDesignStyleGrid5,
										},
										{
											label: __(
												'Grid Style 6',
												'blockspare'
											),
											value: 'blockspare-posts-block-grid-layout-6',
											image: ImageDesignStyleGrid6,
										},
									]
								) }
								onChange={ ( grid ) =>
									setAttributes( { grid } )
								}
							></DesignPanelBody>
						) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-tile' && (
							<DesignPanelBody
								initialOpen={ true }
								selected={ tile }
								paneltitle={ 'Layout' }
								options={ applyFilters(
									'blockspare-posts-block.cta.edit.layouts',
									[
										{
											label: __(
												'Tile Style 1',
												'blockspare'
											),
											value: 'blockspare-posts-block-tile-layout-1',
											image: ImageDesignStyleTile1,
										},
										{
											label: __(
												'Tile Style 2',
												'blockspare'
											),
											value: 'blockspare-posts-block-tile-layout-2',
											image: ImageDesignStyleTile2,
										},
										{
											label: __(
												'Tile Style 3',
												'blockspare'
											),
											value: 'blockspare-posts-block-tile-layout-3',
											image: ImageDesignStyleTile3,
										},
										{
											label: __(
												'Tile Style 4',
												'blockspare'
											),
											value: 'blockspare-posts-block-tile-layout-4',
											image: ImageDesignStyleTile4,
										},
										{
											label: __(
												'Tile Style 5',
												'blockspare'
											),
											value: 'blockspare-posts-block-tile-layout-5',
											image: ImageDesignStyleTile5,
										},
										{
											label: __(
												'Tile Style 6',
												'blockspare'
											),
											value: 'blockspare-posts-block-tile-layout-6',
											image: ImageDesignStyleTile6,
										},
									]
								) }
								onChange={ ( tile ) =>
									setAttributes( { tile } )
								}
							></DesignPanelBody>
						) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-express' && (
							<DesignPanelBody
								initialOpen={ true }
								selected={ express }
								paneltitle={ 'Layout' }
								options={ applyFilters(
									'blockspare-posts-block.cta.edit.layouts',
									[
										{
											label: __(
												'Express Style 1',
												'blockspare'
											),
											value: 'blockspare-posts-block-express-layout-1',
											image: ImageDesignStyleExpress1,
										},
										{
											label: __(
												'Express Style 2',
												'blockspare'
											),
											value: 'blockspare-posts-block-express-layout-2',
											image: ImageDesignStyleExpress2,
										},
										{
											label: __(
												'Express Style 3',
												'blockspare'
											),
											value: 'blockspare-posts-block-express-layout-3',
											image: ImageDesignStyleExpress3,
										},
										{
											label: __(
												'Express Style 4',
												'blockspare'
											),
											value: 'blockspare-posts-block-express-layout-4',
											image: ImageDesignStyleExpress4,
										},
										{
											label: __(
												'Express Style 5',
												'blockspare'
											),
											value: 'blockspare-posts-block-express-layout-5',
											image: ImageDesignStyleExpress5,
										},
										{
											label: __(
												'Express Style 6',
												'blockspare'
											),
											value: 'blockspare-posts-block-express-layout-6',
											image: ImageDesignStyleExpress6,
										},
									]
								) }
								onChange={ ( express ) =>
									setAttributes( { express } )
								}
							></DesignPanelBody>
						) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-full' && (
							<DesignPanelBody
								initialOpen={ true }
								selected={ full }
								paneltitle={ 'Layout' }
								options={ applyFilters(
									'blockspare-posts-block.cta.edit.layouts',
									[
										{
											label: __(
												'Full Style 1',
												'blockspare'
											),
											value: 'blockspare-posts-block-full-layout-1',
											image: ImageDesignStyleFull1,
										},
										{
											label: __(
												'Full Style 2',
												'blockspare'
											),
											value: 'blockspare-posts-block-full-layout-2',
											image: ImageDesignStyleFull2,
										},
										{
											label: __(
												'Full Style 3',
												'blockspare'
											),
											value: 'blockspare-posts-block-full-layout-3',
											image: ImageDesignStyleFull3,
										},
										{
											label: __(
												'Full Style 4',
												'blockspare'
											),
											value: 'blockspare-posts-block-full-layout-4',
											image: ImageDesignStyleFull4,
										},
										{
											label: __(
												'Full Style 5',
												'blockspare'
											),
											value: 'blockspare-posts-block-full-layout-5',
											image: ImageDesignStyleFull5,
										},
										{
											label: __(
												'Full Style 6',
												'blockspare'
											),
											value: 'blockspare-posts-block-full-layout-6',
											image: ImageDesignStyleFull6,
										},
									]
								) }
								onChange={ ( full ) =>
									setAttributes( { full } )
								}
							></DesignPanelBody>
						) }
					</PanelBody>

					<PanelBody
						title={ __( 'Post Settings', 'blockspare' ) }
						className={
							isPost ? null : 'blockspare-posts-block-hide-query'
						}
						initialOpen={ false }
					>
						<SelectControl
							label={ `Category` }
							value={ categories }
							onChange={ ( value ) =>
								setAttributes( { categories: value } )
							}
							options={ categoriesList }
						/>

						<QueryControls
							{ ...{ order, orderBy } }
							onCategoryChange={ ( value ) =>
								setAttributes( {
									categories:
										'' !== value ? value : undefined,
								} )
							}
							numberOfItems={ postsToShow }
							onOrderChange={ ( value ) =>
								setAttributes( { order: value } )
							}
							onOrderByChange={ ( value ) =>
								setAttributes( { orderBy: value } )
							}
							onNumberOfItemsChange={ ( value ) =>
								setAttributes( { postsToShow: value } )
							}
						/>

						<RangeControl
							label={ __(
								'Number of items to offset',
								'blockspare'
							) }
							value={ offset }
							onChange={ ( value ) =>
								setAttributes( { offset: value } )
							}
							min={ 0 }
							max={ 20 }
						/>
					</PanelBody>

					<PanelBody
						title={ __( 'Block Settings', 'blockspare' ) }
						className={
							isPost ? null : 'blockspare-posts-block-hide-query'
						}
						initialOpen={ false }
					>
						<SelectControl
							label={ __( 'Image Size', 'blockspare' ) }
							value={ imageSizeValue() }
							options={ imageSizeOptions }
							onChange={ ( value ) =>
								this.props.setAttributes( { imageSize: value } )
							}
						/>
						{ postListingOption ===
							'blockspare-posts-block-latestpost-grid' && (
							<RangeControl
								label={ __( 'Columns', 'blockspare' ) }
								value={ columns }
								onChange={ ( value ) =>
									setAttributes( { columns: value } )
								}
								min={ 1 }
								max={
									! hasPosts
										? MAX_POSTS_COLUMNS
										: Math.min(
												MAX_POSTS_COLUMNS,
												latestPosts.length
										  )
								}
							/>
						) }
						{ postListingOption ===
							'blockspare-posts-block-latestpost-list' && (
							<ToggleControl
								label={ __(
									'Display in Two Columns',
									'blockspare'
								) }
								checked={ enableTwoColumn }
								onChange={ () =>
									this.props.setAttributes( {
										enableTwoColumn: ! enableTwoColumn,
									} )
								}
							/>
						) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-tile' && (
							<RangeControl
								label={ __( 'Tile Gaps', 'blockspare' ) }
								value={ tileGaps }
								onChange={ ( value ) =>
									setAttributes( { tileGaps: value } )
								}
								min={ 0 }
								step={ 1 }
								max={ 5 }
							/>
						) }

						<ToggleControl
							label={ __( 'Display Title', 'blockspare' ) }
							checked={ displayPostTitle }
							onChange={ () =>
								this.props.setAttributes( {
									displayPostTitle: ! displayPostTitle,
								} )
							}
						/>

						<ToggleControl
							label={ __( 'Display Category', 'blockspare' ) }
							checked={ displayPostCategory }
							onChange={ () =>
								this.props.setAttributes( {
									displayPostCategory: ! displayPostCategory,
								} )
							}
						/>

						<ToggleControl
							label={ __( 'Display Author', 'blockspare' ) }
							checked={ displayPostAuthor }
							onChange={ () =>
								this.props.setAttributes( {
									displayPostAuthor: ! displayPostAuthor,
								} )
							}
						/>

						<ToggleControl
							label={ __( 'Display Date', 'blockspare' ) }
							checked={ displayPostDate }
							onChange={ () =>
								this.props.setAttributes( {
									displayPostDate: ! displayPostDate,
								} )
							}
						/>

						<ToggleControl
							label={ __(
								'Display Comment Count',
								'blockspare'
							) }
							checked={ enableComment }
							onChange={ () =>
								this.props.setAttributes( {
									enableComment: ! enableComment,
								} )
							}
						/>

						<ToggleControl
							label={ __( 'Display Excerpt', 'blockspare' ) }
							checked={ displayPostExcerpt }
							onChange={ () =>
								this.props.setAttributes( {
									displayPostExcerpt: ! displayPostExcerpt,
								} )
							}
						/>

						{ displayPostExcerpt &&
							postListingOption ===
								'blockspare-posts-block-latestpost-express' && (
								<ToggleControl
									label={ __(
										'Display  Excerpt On Spotlight Only',
										'blockspare'
									) }
									checked={ displaySpotLightExceprt }
									onChange={ () =>
										this.props.setAttributes( {
											displaySpotLightExceprt:
												! displaySpotLightExceprt,
										} )
									}
								/>
							) }

						{ displayPostExcerpt &&
							postListingOption ===
								'blockspare-posts-block-latestpost-tile' && (
								<div>
									{ tile !==
										'blockspare-posts-block-tile-layout-1' && (
										<ToggleControl
											label={ __(
												'Display Excerpt On Spotlight Only',
												'blockspare'
											) }
											checked={ displaySpotLightExceprt }
											onChange={ () =>
												this.props.setAttributes( {
													displaySpotLightExceprt:
														! displaySpotLightExceprt,
												} )
											}
										/>
									) }
								</div>
							) }
						{ displayPostExcerpt && (
							<RangeControl
								label={ __( 'Excerpt Length', 'blockspare' ) }
								value={ excerptLength }
								onChange={ ( value ) =>
									setAttributes( { excerptLength: value } )
								}
								min={ 0 }
								max={ 150 }
							/>
						) }

						<ToggleControl
							label={ __(
								'Display Read More Link',
								'blockspare'
							) }
							checked={ displayPostLink }
							onChange={ () =>
								this.props.setAttributes( {
									displayPostLink: ! displayPostLink,
								} )
							}
						/>
						{ displayPostLink && (
							<TextControl
								label={ __(
									'Customize Continue Reading Text',
									'blockspare'
								) }
								type="text"
								value={ readMoreText }
								onChange={ ( value ) =>
									this.props.setAttributes( {
										readMoreText: value,
									} )
								}
							/>
						) }

						{ categoryLayoutOption === 'solid' && (
							<div>
								<RangeControl
									label={ __(
										'Category Border Radius',
										'blockspare-posts-block'
									) }
									value={ categoryBorderRadius }
									onChange={ ( value ) =>
										setAttributes( {
											categoryBorderRadius: value,
										} )
									}
									min={ 1 }
									step={ 1 }
									max={ 100 }
								/>
							</div>
						) }
						{ categoryLayoutOption === 'border' && (
							<div>
								<RangeControl
									label={ __(
										'Category Border Width',
										'blockspare-posts-block'
									) }
									value={ categoryBorderWidth }
									onChange={ ( value ) =>
										setAttributes( {
											categoryBorderWidth: value,
										} )
									}
									min={ 1 }
									step={ 1 }
									max={ 5 }
								/>
								<RangeControl
									label={ __(
										'Category Border Radius',
										'blockspare-posts-block'
									) }
									value={ categoryBorderRadius }
									onChange={ ( value ) =>
										setAttributes( {
											categoryBorderRadius: value,
										} )
									}
									min={ 1 }
									step={ 1 }
									max={ 100 }
								/>
							</div>
						) }

						{ postListingOption !==
							'blockspare-posts-block-latestpost-express' && (
							<div>
								{ postListingOption !==
									'blockspare-posts-block-latestpost-full' &&
									design !==
										'blockspare-posts-block-list-layout-6' &&
									design !==
										'blockspare-posts-block-list-layout-5' &&
									design !==
										'blockspare-posts-block-list-layout-4' &&
									grid !==
										'blockspare-posts-block-grid-layout-6' &&
									grid !==
										'blockspare-posts-block-grid-layout-5' &&
									grid !==
										'blockspare-posts-block-grid-layout-4' && (
										<RangeControl
											label={ __(
												'Content Border Radius',
												'blockspare'
											) }
											value={ borderRadius }
											onChange={ ( value ) =>
												this.props.setAttributes( {
													borderRadius: value,
												} )
											}
											min={ 0 }
											max={ 50 }
											step={ 1 }
										/>
									) }

								{ postListingOption ===
									'blockspare-posts-block-latestpost-full' && (
									<RangeControl
										label={ __(
											'Content Border Radius',
											'blockspare'
										) }
										value={ borderRadius }
										onChange={ ( value ) =>
											this.props.setAttributes( {
												borderRadius: value,
											} )
										}
										min={ 0 }
										max={ 50 }
										step={ 1 }
									/>
								) }
								{ postListingOption !==
									'blockspare-posts-block-latestpost-full' && (
									<div>
										{ design !=
											'blockspare-posts-block-list-layout-6' &&
											design !=
												'blockspare-posts-block-list-layout-5' &&
											design !=
												'blockspare-posts-block-list-layout-4' &&
											grid !=
												'blockspare-posts-block-grid-layout-6' &&
											grid !=
												'blockspare-posts-block-grid-layout-5' &&
											grid !=
												'blockspare-posts-block-grid-layout-4' && (
												<ToggleControl
													label={ __(
														'Enable Box Shadow',
														'blockspare'
													) }
													checked={ enableBoxShadow }
													onChange={ () =>
														this.props.setAttributes(
															{
																enableBoxShadow:
																	! enableBoxShadow,
															}
														)
													}
												/>
											) }
									</div>
								) }

								{ postListingOption ===
									'blockspare-posts-block-latestpost-full' && (
									<ToggleControl
										label={ __(
											'Enable Box Shadow',
											'blockspare'
										) }
										checked={ enableBoxShadow }
										onChange={ () =>
											this.props.setAttributes( {
												enableBoxShadow:
													! enableBoxShadow,
											} )
										}
									/>
								) }

								{ postListingOption !==
									'blockspare-posts-block-latestpost-full' && (
									<div>
										{ enableBoxShadow &&
											design !=
												'blockspare-posts-block-list-layout-6' &&
											design !=
												'blockspare-posts-block-list-layout-5' &&
											design !=
												'blockspare-posts-block-list-layout-4' &&
											grid !=
												'blockspare-posts-block-grid-layout-6' &&
											grid !=
												'blockspare-posts-block-grid-layout-5' &&
											grid !=
												'blockspare-posts-block-grid-layout-4' && (
												<BoxShadow
													enableShadowColor={ false }
													enableOptions={ true }
													shadowColor={ shadowColor }
													onChangeShadowColor={ (
														shadowColor
													) =>
														setAttributes( {
															shadowColor,
														} )
													}
													xOffset={ xOffset }
													onChangeXOffset={ (
														xOffset
													) =>
														setAttributes( {
															xOffset,
														} )
													}
													yOffset={ yOffset }
													onChangeYOffset={ (
														yOffset
													) =>
														setAttributes( {
															yOffset,
														} )
													}
													blur={ blur }
													onChangeBlur={ ( blur ) =>
														setAttributes( {
															blur,
														} )
													}
													spread={ spread }
													onChangeSpread={ (
														spread
													) =>
														setAttributes( {
															spread,
														} )
													}
												/>
											) }
									</div>
								) }

								{ postListingOption ===
									'blockspare-posts-block-latestpost-full' &&
									enableBoxShadow && (
										<BoxShadow
											enableShadowColor={ false }
											enableOptions={ true }
											shadowColor={ shadowColor }
											onChangeShadowColor={ (
												shadowColor
											) =>
												setAttributes( { shadowColor } )
											}
											xOffset={ xOffset }
											onChangeXOffset={ ( xOffset ) =>
												setAttributes( { xOffset } )
											}
											yOffset={ yOffset }
											onChangeYOffset={ ( yOffset ) =>
												setAttributes( { yOffset } )
											}
											blur={ blur }
											onChangeBlur={ ( blur ) =>
												setAttributes( { blur } )
											}
											spread={ spread }
											onChangeSpread={ ( spread ) =>
												setAttributes( { spread } )
											}
										/>
									) }
							</div>
						) }
					</PanelBody>

					{ displayPostCategory && (
						<PanelBody
							title={ __( 'Category Style', 'blockspare' ) }
							initialOpen={ false }
						>
							<DesignPanelBody
								initialOpen={ true }
								selected={ categoryLayoutOption }
								paneltitle={ `Category layout` }
								options={ applyFilters(
									'blockspare-posts-block.cta.edit.layouts',
									[
										{
											label: __( 'Solid', 'blockspare' ),
											value: 'solid',
											image: ImageFilltyle1,
										},
										{
											label: __( 'Border', 'blockspare' ),
											value: 'border',
											image: ImageBorderStyle2,
										},
										{
											label: __( 'None', 'blockspare' ),
											value: 'none',
											image: ImageNoneStyle3,
										},
									]
								) }
								onChange={ ( categoryLayoutOption ) =>
									setAttributes( { categoryLayoutOption } )
								}
							></DesignPanelBody>
						</PanelBody>
					) }

					<DesignPanelBody
						initialOpen={ false }
						selected={ contentOrder }
						paneltitle={ 'Content Order' }
						options={ applyFilters(
							'blockspare-posts-block.cta.edit.layouts',
							[
								{
									label: __( 'Style 1', 'blockspare' ),
									value: 'content-order-1',
									image: ImageDesignStyleContent1,
								},

								{
									label: __( 'Style 2', 'blockspare' ),
									value: 'content-order-2',
									image: ImageDesignStyleContent2,
								},

								{
									label: __( 'Style 3', 'blockspare' ),
									value: 'content-order-3',
									image: ImageDesignStyleContent3,
								},

								{
									label: __( 'Style 4', 'blockspare' ),
									value: 'content-order-4',
									image: ImageDesignStyleContent4,
								},
								{
									label: __( 'Style 5', 'blockspare' ),
									value: 'content-order-5',
									image: ImageDesignStyleContent5,
								},

								{
									label: __( 'Style 6', 'blockspare' ),
									value: 'content-order-6',
									image: ImageDesignStyleContent6,
								},
							]
						) }
						onChange={ ( contentOrder ) =>
							setAttributes( { contentOrder } )
						}
					></DesignPanelBody>

					<PanelBody
						title={ __( 'Typography Settings', 'blockspare' ) }
						initialOpen={ false }
					>
						{ postListingOption ===
							'blockspare-posts-block-latestpost-tile' &&
							tile !== 'blockspare-posts-block-tile-layout-1' && (
								<TypographyControl
									label={ __(
										'Spotlight Title Fonts Settings'
									) }
									attributes={ attributes }
									setAttributes={ setAttributes }
									loadGoogleFonts={ {
										value: spostTitleLoadGoogleFonts,
										label: __(
											'spostTitleLoadGoogleFonts'
										),
									} }
									fontFamily={ {
										value: spostTitleFontFamily,
										label: __( 'spostTitleFontFamily' ),
									} }
									fontWeight={ {
										value: spostTitleFontWeight,
										label: __( 'spostTitleFontWeight' ),
									} }
									fontSubset={ {
										value: spostTitleFontSubset,
										label: __( 'spostTitleFontSubset' ),
									} }
									fontSizeType={ {
										value: spostTitleFontSizeType,
										label: __( 'spostTitleFontSizeType' ),
									} }
									fontSize={ {
										value: spostTitleFontSize,
										label: __( 'spostTitleFontSize' ),
									} }
									fontSizeMobile={ {
										value: spostTitleFontSizeMobile,
										label: __( 'spostTitleFontSizeMobile' ),
									} }
									fontSizeTablet={ {
										value: spostTitleFontSizeTablet,
										label: __( 'spostTitleFontSizeTablet' ),
									} }
									disableLineHeight={ true }
								/>
							) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-express' && (
							<TypographyControl
								label={ __( 'Spotlight Title Fonts Settings' ) }
								attributes={ attributes }
								setAttributes={ setAttributes }
								loadGoogleFonts={ {
									value: spostTitleLoadGoogleFonts,
									label: __( 'spostTitleLoadGoogleFonts' ),
								} }
								fontFamily={ {
									value: spostTitleFontFamily,
									label: __( 'spostTitleFontFamily' ),
								} }
								fontWeight={ {
									value: spostTitleFontWeight,
									label: __( 'spostTitleFontWeight' ),
								} }
								fontSubset={ {
									value: spostTitleFontSubset,
									label: __( 'spostTitleFontSubset' ),
								} }
								fontSizeType={ {
									value: spostTitleFontSizeType,
									label: __( 'spostTitleFontSizeType' ),
								} }
								fontSize={ {
									value: spostTitleFontSize,
									label: __( 'spostTitleFontSize' ),
								} }
								fontSizeMobile={ {
									value: spostTitleFontSizeMobile,
									label: __( 'spostTitleFontSizeMobile' ),
								} }
								fontSizeTablet={ {
									value: spostTitleFontSizeTablet,
									label: __( 'spostTitleFontSizeTablet' ),
								} }
								disableLineHeight={ true }
							/>
						) }

						{ displayPostTitle && (
							<TypographyControl
								label={ __( 'Title Fonts Settings' ) }
								attributes={ attributes }
								setAttributes={ setAttributes }
								loadGoogleFonts={ {
									value: titleLoadGoogleFonts,
									label: __( 'titleLoadGoogleFonts' ),
								} }
								fontFamily={ {
									value: titleFontFamily,
									label: __( 'titleFontFamily' ),
								} }
								fontWeight={ {
									value: titleFontWeight,
									label: __( 'titleFontWeight' ),
								} }
								fontSubset={ {
									value: titleFontSubset,
									label: __( 'titleFontSubset' ),
								} }
								fontSizeType={ {
									value: titleFontSizeType,
									label: __( 'titleFontSizeType' ),
								} }
								fontSize={ {
									value: postTitleFontSize,
									label: __( 'postTitleFontSize' ),
								} }
								fontSizeMobile={ {
									value: titleFontSizeMobile,
									label: __( 'titleFontSizeMobile' ),
								} }
								fontSizeTablet={ {
									value: titleFontSizeTablet,
									label: __( 'titleFontSizeTablet' ),
								} }
								disableLineHeight={ true }
							/>
						) }

						{ displayPostExcerpt && (
							<TypographyControl
								label={ __( 'Description Fonts Settings' ) }
								attributes={ attributes }
								setAttributes={ setAttributes }
								loadGoogleFonts={ {
									value: descriptionLoadGoogleFonts,
									label: __( 'descriptionLoadGoogleFonts' ),
								} }
								fontFamily={ {
									value: descriptionFontFamily,
									label: __( 'descriptionFontFamily' ),
								} }
								fontWeight={ {
									value: descriptionFontWeight,
									label: __( 'descriptionFontWeight' ),
								} }
								fontSubset={ {
									value: descriptionFontSubset,
									label: __( 'descriptionFontSubset' ),
								} }
								fontSizeType={ {
									value: descriptionFontSizeType,
									label: __( 'descriptionFontSizeType' ),
								} }
								fontSize={ {
									value: descriptionFontSize,
									label: __( 'descriptionFontSize' ),
								} }
								fontSizeMobile={ {
									value: descriptionFontSizeMobile,
									label: __( 'descriptionFontSizeMobile' ),
								} }
								fontSizeTablet={ {
									value: descriptionFontSizeTablet,
									label: __( 'descriptionFontSizeTablet' ),
								} }
								disableLineHeight={ true }
							/>
						) }
					</PanelBody>

					<PanelBody
						title={ __( 'Color Settings', 'blockspare' ) }
						className={
							isPost ? null : 'blockspare-posts-block-hide-query'
						}
						initialOpen={ false }
					>
						{ displayPostTitle &&
							postListingOption !==
								'blockspare-posts-block-latestpost-express' &&
							postListingOption !==
								'blockspare-posts-block-latestpost-tile' && (
								<PanelColorSettings
									title={ __( 'Colors', 'blockspare' ) }
									initialOpen={ true }
									colorSettings={ [
										full ===
										'blockspare-posts-block-full-layout-4'
											? tilePostColors
											: titlePostColors,
										full ===
										'blockspare-posts-block-full-layout-4'
											? TileAuthorLinkColor
											: authorLinkColor,
										full ===
										'blockspare-posts-block-full-layout-4'
											? tileMetaColorDate
											: metaColorDate,
									] }
								></PanelColorSettings>
							) }

						{ displayPostTitle &&
							postListingOption ===
								'blockspare-posts-block-latestpost-express' && (
								<PanelColorSettings
									title={ __( 'Colors', 'blockspare' ) }
									initialOpen={ true }
									colorSettings={ [
										express ===
										'blockspare-posts-block-express-layout-1'
											? tilePostColors
											: '',
										express ===
										'blockspare-posts-block-express-layout-3'
											? tilePostColors
											: '',
										express ===
										'blockspare-posts-block-express-layout-5'
											? tilePostColors
											: '',
										express ===
										'blockspare-posts-block-express-layout-6'
											? tilePostColors
											: '',
										titlePostColors,
										express ===
										'blockspare-posts-block-express-layout-1'
											? expressTextOverLinkColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-1'
											? expressTextOverGeneralColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-3'
											? expressTextOverLinkColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-3'
											? expressTextOverGeneralColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-5'
											? expressTextOverLinkColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-5'
											? expressTextOverGeneralColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-6'
											? expressTextOverLinkColor
											: '',
										express ===
										'blockspare-posts-block-express-layout-6'
											? expressTextOverGeneralColor
											: '',
										authorLinkColor,
										metaColorDate,
									] }
								></PanelColorSettings>
							) }
						{ displayPostTitle &&
							postListingOption ===
								'blockspare-posts-block-latestpost-tile' && (
								<PanelColorSettings
									title={ __( 'Colors', 'blockspare' ) }
									initialOpen={ true }
									colorSettings={ [
										tilePostColors,
										TileAuthorLinkColor,
										tileMetaColorDate,
									] }
								></PanelColorSettings>
							) }

						{ postListingOption !==
							'blockspare-posts-block-latestpost-express' && (
							<PanelColorSettings
								title={ __( 'Category Color', 'blockspare' ) }
								initialOpen={ false }
								colorSettings={ [
									{
										value: categoryTextColor,
										onChange: onChangeCategoryTextcolor,
										label: __( 'Text Color', 'blockspare' ),
									},
									categoryLayoutOption === 'solid'
										? categoryBgColor
										: '',
									categoryLayoutOption === 'border'
										? categoryBorderColors
										: '',
								] }
							></PanelColorSettings>
						) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-express' &&
							categoryLayoutOption === 'none' && (
								<PanelColorSettings
									title={ __(
										'Category Color',
										'blockspare'
									) }
									initialOpen={ false }
									colorSettings={ [
										{
											value: categoryTextColor,
											onChange: onChangeCategoryTextcolor,
											label: __(
												'Text Color',
												'blockspare'
											),
										},
										categoryLayoutOption === 'solid'
											? categoryBgColor
											: '',
										categoryLayoutOption === 'border'
											? categoryBorderColors
											: '',
									] }
								></PanelColorSettings>
							) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-express' &&
							categoryLayoutOption === 'solid' && (
								<PanelColorSettings
									title={ __(
										'Category Color',
										'blockspare'
									) }
									initialOpen={ false }
									colorSettings={ [
										{
											value: categoryTextColor,
											onChange: onChangeCategoryTextcolor,
											label: __(
												'Text Color',
												'blockspare'
											),
										},
										categoryLayoutOption === 'solid'
											? categoryBgColor
											: '',
										categoryLayoutOption === 'border'
											? categoryBorderColors
											: '',

										express ===
											'blockspare-posts-block-express-layout-1' ||
										express ===
											'blockspare-posts-block-express-layout-3' ||
										express ===
											'blockspare-posts-block-express-layout-5' ||
										express ===
											'blockspare-posts-block-express-layout-6'
											? spotCategoryTextColorOpt
											: '',
										express ===
											'blockspare-posts-block-express-layout-1' ||
										express ===
											'blockspare-posts-block-express-layout-3' ||
										express ===
											'blockspare-posts-block-express-layout-5' ||
										express ===
											'blockspare-posts-block-express-layout-6'
											? spotcategoryBgColor
											: '',
									] }
								></PanelColorSettings>
							) }

						{ postListingOption ===
							'blockspare-posts-block-latestpost-express' &&
							categoryLayoutOption === 'border' && (
								<PanelColorSettings
									title={ __(
										'Category Color',
										'blockspare'
									) }
									initialOpen={ false }
									colorSettings={ [
										{
											value: categoryTextColor,
											onChange: onChangeCategoryTextcolor,
											label: __(
												'Text Color',
												'blockspare'
											),
										},
										categoryLayoutOption === 'solid'
											? categoryBgColor
											: '',
										categoryLayoutOption === 'border'
											? categoryBorderColors
											: '',

										express ===
											'blockspare-posts-block-express-layout-1' ||
										express ===
											'blockspare-posts-block-express-layout-3' ||
										express ===
											'blockspare-posts-block-express-layout-5' ||
										express ===
											'blockspare-posts-block-express-layout-6'
											? spotCategoryTextColorOpt
											: '',
										express ===
											'blockspare-posts-block-express-layout-1' ||
										express ===
											'blockspare-posts-block-express-layout-3' ||
										express ===
											'blockspare-posts-block-express-layout-5' ||
										express ===
											'blockspare-posts-block-express-layout-6'
											? spotCategoryBorderColors
											: '',
									] }
								></PanelColorSettings>
							) }

						{ postListingOption !==
							'blockspare-posts-block-latestpost-tile' &&
							postListingOption !==
								'blockspare-posts-block-latestpost-express' && (
								<div>
									{ design !==
										'blockspare-posts-block-list-layout-6' &&
										design !==
											'blockspare-posts-block-list-layout-5' &&
										design !==
											'blockspare-posts-block-list-layout-4' &&
										grid !==
											'blockspare-posts-block-grid-layout-6' &&
										grid !==
											'blockspare-posts-block-grid-layout-5' &&
										grid !==
											'blockspare-posts-block-grid-layout-4' && (
											<PanelColorSettings
												title={ __(
													'Background Color',
													'blockspare'
												) }
												initialOpen={ false }
												colorSettings={ [
													{
														value: backGroundColor,
														onChange:
															onChangeBackgroundcolor,
														label: __(
															'Background Color',
															'blockspare'
														),
													},
												] }
											></PanelColorSettings>
										) }
								</div>
							) }

						{ enableBoxShadow &&
							postListingOption !==
								'blockspare-posts-block-latestpost-express' &&
							design != 'blockspare-posts-block-list-layout-6' &&
							design != 'blockspare-posts-block-list-layout-5' &&
							design != 'blockspare-posts-block-list-layout-4' &&
							design != 'blockspare-posts-block-grid-layout-6' &&
							design != 'blockspare-posts-block-grid-layout-5' &&
							design !=
								'blockspare-posts-block-grid-layout-4' && (
								<BoxShadow
									enableShadowColor={ true }
									enableOptions={ false }
									shadowColor={ shadowColor }
									onChangeShadowColor={ ( shadowColor ) =>
										setAttributes( { shadowColor } )
									}
									xOffset={ xOffset }
									onChangeXOffset={ ( xOffset ) =>
										setAttributes( { xOffset } )
									}
									yOffset={ yOffset }
									onChangeYOffset={ ( yOffset ) =>
										setAttributes( { yOffset } )
									}
									blur={ blur }
									onChangeBlur={ ( blur ) =>
										setAttributes( { blur } )
									}
									spread={ spread }
									onChangeSpread={ ( spread ) =>
										setAttributes( { spread } )
									}
								/>
							) }

						{ enableBoxShadow &&
							postListingOption ===
								'blockspare-posts-block-latestpost-full' && (
								<BoxShadow
									enableShadowColor={ true }
									enableOptions={ false }
									shadowColor={ shadowColor }
									onChangeShadowColor={ ( shadowColor ) =>
										setAttributes( { shadowColor } )
									}
									xOffset={ xOffset }
									onChangeXOffset={ ( xOffset ) =>
										setAttributes( { xOffset } )
									}
									yOffset={ yOffset }
									onChangeYOffset={ ( yOffset ) =>
										setAttributes( { yOffset } )
									}
									blur={ blur }
									onChangeBlur={ ( blur ) =>
										setAttributes( { blur } )
									}
									spread={ spread }
									onChangeSpread={ ( spread ) =>
										setAttributes( { spread } )
									}
								/>
							) }
					</PanelBody>

					{ iconPanel == true && (
						<PanelBody
							title={ __( 'Icon Settings' ) }
							initialOpen={ false }
						>
							{ displayPostAuthor && (
								<PanelBody
									title={ __( 'Author Icon' ) }
									initialOpen={ false }
								>
									<BSIconSettings
										name={ authorIcon }
										onChangeName={ ( authorIcon ) =>
											setAttributes( { authorIcon } )
										}
									/>
								</PanelBody>
							) }
							{ displayPostDate && (
								<PanelBody
									title={ __( 'Date Icon' ) }
									initialOpen={ false }
								>
									<BSIconSettings
										name={ dateIcon }
										onChangeName={ ( dateIcon ) =>
											setAttributes( { dateIcon } )
										}
									/>
								</PanelBody>
							) }
							{ enableComment && (
								<PanelBody
									title={ __( 'Comment Count Icon' ) }
									initialOpen={ false }
								>
									<BSIconSettings
										name={ commentIcon }
										onChangeName={ ( commentIcon ) =>
											setAttributes( { commentIcon } )
										}
									/>
								</PanelBody>
							) }
						</PanelBody>
					) }

					<PanelBody
						title={ __( 'Gaps Settings', 'blockspare' ) }
						initialOpen={ false }
					>
						<PanelBody
							title={ __( 'Block Gaps', 'blockspare' ) }
							initialOpen={ false }
						>
							<Margin
								// Top padding
								marginEnableTop={ true }
								marginTop={ marginTop }
								marginTopMin="-300"
								marginTopMax="300"
								onChangeMarginTop={ ( marginTop ) =>
									setAttributes( { marginTop } )
								}
								// Bottom margin
								marginEnableBottom={ true }
								marginBottom={ marginBottom }
								marginBottomMin="-300"
								marginBottomMax="300"
								onChangeMarginBottom={ ( marginBottom ) =>
									setAttributes( { marginBottom } )
								}
							/>
						</PanelBody>

						<PanelBody
							title={ __( 'Content Gaps', 'blockspare' ) }
							initialOpen={ false }
						>
							<RangeControl
								label={ __(
									'Padding Top',
									'blockspare-posts-block'
								) }
								value={ contentPaddingTop }
								onChange={ ( value ) =>
									setAttributes( {
										contentPaddingTop: value,
									} )
								}
								min={ 0 }
								step={ 1 }
								max={ 300 }
							/>

							<RangeControl
								label={ __(
									'Padding Right',
									'blockspare-posts-block'
								) }
								value={ contentPaddingRight }
								onChange={ ( value ) =>
									setAttributes( {
										contentPaddingRight: value,
									} )
								}
								min={ 0 }
								step={ 1 }
								max={ 300 }
							/>

							<RangeControl
								label={ __(
									'Padding Bottom',
									'blockspare-posts-block'
								) }
								value={ contentPaddingBottom }
								onChange={ ( value ) =>
									setAttributes( {
										contentPaddingBottom: value,
									} )
								}
								min={ 0 }
								step={ 1 }
								max={ 300 }
							/>

							<RangeControl
								label={ __(
									'Padding Left',
									'blockspare-posts-block'
								) }
								value={ contentPaddingLeft }
								onChange={ ( value ) =>
									setAttributes( {
										contentPaddingLeft: value,
									} )
								}
								min={ 0 }
								step={ 1 }
								max={ 300 }
							/>
						</PanelBody>
						{ displayPostTitle && (
							<PanelBody
								title={ __( 'Title Gap', 'blockspare' ) }
								initialOpen={ false }
							>
								<Margin
									// Top padding
									marginEnableTop={ true }
									marginTop={ titleMarginTop }
									marginTopMin="-300"
									marginTopMax="300"
									onChangeMarginTop={ ( titleMarginTop ) =>
										setAttributes( { titleMarginTop } )
									}
									// Bottom margin
									marginEnableBottom={ true }
									marginBottom={ titleMarginBottom }
									marginBottomMin="-300"
									marginBottomMax="300"
									onChangeMarginBottom={ (
										titleMarginBottom
									) =>
										setAttributes( { titleMarginBottom } )
									}
								/>
							</PanelBody>
						) }

						{ displayPostCategory && (
							<PanelBody
								title={ __( 'Category Gap', 'blockspare' ) }
								initialOpen={ false }
							>
								<Margin
									// Top padding
									marginEnableTop={ true }
									marginTop={ categoryMarginTop }
									marginTopMin="-300"
									marginTopMax="300"
									onChangeMarginTop={ ( categoryMarginTop ) =>
										setAttributes( { categoryMarginTop } )
									}
									// Bottom margin
									marginEnableBottom={ true }
									marginBottom={ categoryMarginBottom }
									marginBottomMin="-300"
									marginBottomMax="300"
									onChangeMarginBottom={ (
										categoryMarginBottom
									) =>
										setAttributes( {
											categoryMarginBottom,
										} )
									}
								/>
							</PanelBody>
						) }

						{ displayPostDate && displayPostAuthor && (
							<PanelBody
								title={ __( 'Meta Gap', 'blockspare' ) }
								initialOpen={ false }
							>
								<Margin
									// Top padding
									marginEnableTop={ true }
									marginTop={ metaMarginTop }
									marginTopMin="-300"
									marginTopMax="300"
									onChangeMarginTop={ ( metaMarginTop ) =>
										setAttributes( { metaMarginTop } )
									}
									// Bottom margin
									marginEnableBottom={ true }
									marginBottom={ metaMarginBottom }
									marginBottomMin="-300"
									marginBottomMax="300"
									onChangeMarginBottom={ (
										metaMarginBottom
									) => setAttributes( { metaMarginBottom } ) }
								/>
							</PanelBody>
						) }

						{ displayPostExcerpt && (
							<PanelBody
								title={ __( 'Excerpt Gap', 'blockspare' ) }
								initialOpen={ false }
							>
								<Margin
									// Top padding
									marginEnableTop={ true }
									marginTop={ exceprtMarginTop }
									marginTopMin="-300"
									marginTopMax="300"
									onChangeMarginTop={ ( exceprtMarginTop ) =>
										setAttributes( { exceprtMarginTop } )
									}
									// Bottom margin
									marginEnableBottom={ true }
									marginBottom={ exceprtMarginBottom }
									marginBottomMin="-300"
									marginBottomMax="300"
									onChangeMarginBottom={ (
										exceprtMarginBottom
									) =>
										setAttributes( { exceprtMarginBottom } )
									}
								/>
							</PanelBody>
						) }
						{ displayPostLink && (
							<PanelBody
								title={ __(
									'Read More Link Gap',
									'blockspare'
								) }
								initialOpen={ false }
							>
								<Margin
									// Top padding
									marginEnableTop={ true }
									marginTop={ moreLinkMarginTop }
									marginTopMin="-300"
									marginTopMax="300"
									onChangeMarginTop={ ( moreLinkMarginTop ) =>
										setAttributes( { moreLinkMarginTop } )
									}
									// Bottom margin
									marginEnableBottom={ true }
									marginBottom={ moreLinkMarginBottom }
									marginBottomMin="-300"
									marginBottomMax="300"
									onChangeMarginBottom={ (
										moreLinkMarginBottom
									) =>
										setAttributes( {
											moreLinkMarginBottom,
										} )
									}
								/>
							</PanelBody>
						) }
					</PanelBody>
				</div>
			</InspectorControls>
		);
	}
}
