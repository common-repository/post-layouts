/**
 * External dependencies
 */

import get from 'lodash/get';
import isUndefined from 'lodash/isUndefined';
import pickBy from 'lodash/pickBy';
import moment from 'moment';
import classnames from 'classnames';
import {stringify} from 'querystringify';
import pl_styling from './pl_styling';
import icons from '../icons/icons';

// Import all of our Text Options requirements.
import TypographyControl from "./components/typography";

const { Component, Fragment } = wp.element;

const { __, sprintf } = wp.i18n;

const { decodeEntities } = wp.htmlEntities;

const { apiFetch } = wp;

const { registerStore, withSelect, } = wp.data;

const {
  PanelBody,
  Placeholder,
  QueryControls,
  RangeControl,
  SelectControl,
  Spinner,
  TextControl,
  ToggleControl,
  Toolbar,
  withAPIData,
} = wp.components;

const {
  InspectorControls,
  BlockAlignmentToolbar,
  BlockControls,
  ColorPalette,
  PanelColorSettings
} = wp.editor;

const MAX_POSTS_COLUMNS = 4;

class LatestPostsBlock extends Component {
  constructor() {
    super(...arguments);
    this.toggleDisplayPostDate = this.toggleDisplayPostDate.bind(this);
    this.toggleDisplayPostExcerpt = this.toggleDisplayPostExcerpt.bind(this);
    this.toggleDisplayPostAuthor = this.toggleDisplayPostAuthor.bind(this);
    this.toggleDisplayPostTag = this.toggleDisplayPostTag.bind(this);
    this.toggleDisplayPostCategory = this.toggleDisplayPostCategory.bind(this);
    this.toggleDisplayPostImage = this.toggleDisplayPostImage.bind(this);
    this.toggleequlaHeight = this.toggleequlaHeight.bind(this);
    this.toggleDisplayPostLink = this.toggleDisplayPostLink.bind(this);
    this.toggleDisplayPostComments = this.toggleDisplayPostComments.bind(this);
    this.toggleDisplayPostSocialshare = this.toggleDisplayPostSocialshare.bind(this);
  }

  toggleDisplayPostDate() {
    const { displayPostDate } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostDate: !displayPostDate });
  }

  toggleDisplayPostExcerpt() {
    const { displayPostExcerpt } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostExcerpt: !displayPostExcerpt });
  }

  customizeWordsExcerpt() {
    const { wordsExcerpt } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ wordsExcerpt: !wordsExcerpt });
  }

  toggleequlaHeight(){
    const { isequalheight } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ isequalheight: !isequalheight });
  }

  toggleDisplayPostAuthor() {
    const { displayPostAuthor } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostAuthor: !displayPostAuthor });
  }

  toggleDisplayPostTag() {
    const { displayPostTag } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostTag: !displayPostTag });
  }

  toggleDisplayPostCategory() {
    const { displayPostCategory } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostCategory: !displayPostCategory });
  }

  toggleDisplayPostImage() {
    const { displayPostImage } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostImage: !displayPostImage });
  }

  toggleDisplayPostComments() {
    const { displayPostComments } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostComments: !displayPostComments });
  }

  toggleDisplayPostLink() {
    const { displayPostLink } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostLink: !displayPostLink });
  }
  toggleDisplayPostSocialshare() {
    const { displayPostSocialshare } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ displayPostSocialshare: !displayPostSocialshare });
  }
  customizeReadMoreText() {
    const { readMoreText } = this.props.attributes;
    const { setAttributes } = this.props;
    setAttributes({ readMoreText: !readMoreText });
  }

 componentDidMount() {
    this.props.setAttributes( { block_id: this.props.clientId } )
    const $style = document.createElement( "style" )
    $style.setAttribute( "id", "pl-style-" + this.props.clientId )
    document.head.appendChild( $style ) 
  }


  render() {
      const {
        attributes,
        categoriesList,
        setAttributes,
        latestPosts,
        isSelected 
      } = this.props;
      const {
        block_id, 
        layoutcount,
        targetLevel,
        targetLeveltwo,
        displayPostDate,
        layoutopt,
        primaryColor,
        pltitle,
        readmoreView,
        titleTag,
        displayPostExcerpt,
        displayPostAuthor,
        displayPostTag,
        displayPostCategory,
        displayPostImage,
        displayPostLink,
        displayPostComments,
        displayPostSocialshare,
        align,
        columns,
        order,
        orderBy,
        designtwoboxbgColor,
        listlayouttwobgColor,
        isequalheight,
        categories,
        postsToShow,
        width,
        imageCrop,
        readMoreText,
        wordsExcerpt,
        boxbgColor,
        titleColor,
        postmetaColor,
        postexcerptColor,
        postctaColor,
        socialShareColor,
        titlefontSize,
        postmetafontSize,
        postexcerptfontSize,
        postctafontSize,
        socialSharefontSize,
        secondaryColor,
        readmoreBgColor,
        rowSpace,
        columnSpace,
        belowTitleSpace,
        belowImageSpace,
        belowexerptSpace,
        belowctaSpace,
        innerSpace,
        titleFontSize,
        titleFontFamily,
        titleFontWeight,
        titleFontSubset,
        excerptFontFamily,
        excerptFontWeight,
        excerptFontSubset,
        metaFontFamily,
        metaFontSubset,
        metafontWeight,
        ctaFontFamily,
        ctaFontSubset,
        ctafontWeight,

      } = attributes;

     function createLevelControl( targetLevel ) {
          return {
              icon: 'shield',
              title: sprintf( __( 'Grid Template %d' ), targetLevel ),
              default:1,
              isActive: targetLevel === layoutcount,
              onClick: () => setAttributes( { layoutcount: targetLevel } ),
              subscript: String( targetLevel ),
          };
     }

     function createListLevelControl( targetLeveltwo ) {
          return {
              icon: 'shield',
              title: sprintf( __( 'List Template %d' ), targetLeveltwo ),
              isActive: targetLeveltwo === layoutcount,
              default:1,
              onClick: () => setAttributes( { layoutcount: targetLeveltwo } ),
              subscript: String( targetLeveltwo ),
          };
     }

      // Thumbnail options
      const imageCropOptions = [
          { value: 'landscape', label: __('Landscape') },
          { value: 'square', label: __('Square') },
        ];

      const layoutoptions = [
          { value: 'grid', label: __('Grid') },
          { value: 'list', label: __('List') },
        ];

      const pltitletag = [
            { value: 'h1', label: __('H1') },
            { value: 'h2', label: __('H2') },
            { value: 'h3', label: __('H3') },
            { value: 'h4', label: __('H4') },
            { value: 'h5', label: __('H5') },
            { value: 'h6', label: __('H6') },
          ];

     const reamoreText = [
            { value: 'text-only', label: __('Text Only') },
            { value: 'pl-button', label: __('Button') },
           ];     

      const isLandscape = imageCrop === 'landscape';
      
      const Tag = attributes.titleTag;

      const eqheight = isequalheight ? "pl_same-height" : "";

      const inspectorControls = ( <InspectorControls >
        <PanelBody title = {__('Layout Options') } >
        <SelectControl label = { __('Select Layout') }
            options = { layoutoptions }
            value = {layoutopt}
            onChange = { (value) => this.props.setAttributes({ layoutopt: value}) }
          />
          { layoutopt === 'grid' &&
          <Toolbar className="post-grid-template-selection" controls={ _.range( 1, 3 ).map( createLevelControl ) } />
        } { layoutopt === 'list' &&
            <Toolbar className="post-grid-template-selection" controls={ _.range( 1, 4 ).map( createListLevelControl ) } />
        } 
           </PanelBody> 
           <PanelBody title = {  __('Post Settings') } initialOpen={ false } >
              <QueryControls { ...{ order, orderBy } }
                numberOfItems = { postsToShow }
                categoriesList = { categoriesList }
                selectedCategoryId = { categories }
                onOrderChange = { (value) => setAttributes({ order: value }) }
                onOrderByChange = { (value) => setAttributes({ orderBy: value }) }
                onCategoryChange = { (value) => setAttributes({ categories: '' !== value ? value : undefined }) }
                onNumberOfItemsChange = { (value) => setAttributes({ postsToShow: value }) }
              /> 
          { layoutopt === 'grid' &&
            <Fragment>
              <RangeControl 
                  label = { __('Columns') } value = { columns }
                  onChange = { (value) => setAttributes({ columns: value }) }
                  min = { 2 } max = {!hasPosts ? MAX_POSTS_COLUMNS : Math.min(MAX_POSTS_COLUMNS, latestPosts.length) } 
              />,
              
              <ToggleControl label = { __('Is Equal Height') }
                  checked = { isequalheight }
                  onChange = { this.toggleequlaHeight }
              />
            </Fragment> 
          } 
            <ToggleControl label = { __('Display Featured Image') }
                checked = { displayPostImage }
                onChange = { this.toggleDisplayPostImage }
            /> 

          { displayPostImage && 
                <SelectControl label = { __('Featured Image Style')}
                    options = { imageCropOptions }
                    value = { imageCrop }
                    onChange = { (value) => this.props.setAttributes({ imageCrop: value }) }
                /> } 
              
              <ToggleControl label = {  __('Display Post Author') }
                  checked = { displayPostAuthor }
                  onChange = { this.toggleDisplayPostAuthor }
              />
              
              <ToggleControl label = { __('Display Post Category') }
                  checked = { displayPostCategory }
                  onChange = { this.toggleDisplayPostCategory }
              />
              
              <ToggleControl label = { __('Display Post Tag') }
                  checked = { displayPostTag }
                  onChange = { this.toggleDisplayPostTag }
              />  
            
              <ToggleControl label = { __('Display Post Comment') }
                  checked = { displayPostComments }
                  onChange = { this.toggleDisplayPostComments } />  
            
              <ToggleControl label = { __('Display Post Date') }
                  checked = { displayPostDate }
                  onChange = { this.toggleDisplayPostDate }
              />
            
              <ToggleControl label = { __('Display Post Excerpt') }
                  checked = { displayPostExcerpt }
                  onChange = { this.toggleDisplayPostExcerpt }
              /> 
              {
                displayPostExcerpt &&
                  <TextControl label = { __('Number of words for Excerpt') }
                    type = "text" value = { wordsExcerpt }
                    onChange = { (value) => this.props.setAttributes({ wordsExcerpt: value }) }
                />
              } 
               <ToggleControl label = { __('Display Social share Icon') }
                  checked = { displayPostSocialshare }
                  onChange = { this.toggleDisplayPostSocialshare }
               /> 
          </PanelBody>
          <PanelBody title = {  __('Readmore Settings') } initialOpen={ false } >
              <ToggleControl label = { __('Display Read More Link') } 
                      checked = { displayPostLink }
                      onChange = { this.toggleDisplayPostLink  }
                /> 
              { displayPostLink &&
                 <Fragment>
                     <TextControl label = { __('Customize Read More Link') }
                      type = "text"
                      value = { readMoreText }
                      onChange = { (value) => this.props.setAttributes({ readMoreText: value }) }
                    />

                   <SelectControl label = { __('Readmore View') }
                      options = { reamoreText }
                      value = {readmoreView}
                      onChange = { (value) => this.props.setAttributes({ readmoreView: value}) }
                  />
                 </Fragment>
              }
          </PanelBody>
          <PanelBody title={ __('Typography Settings')} initialOpen={ false }>

              <SelectControl label = { __('Select Title tag') }
                  options = { pltitletag }
                  value = {titleTag}
                  onChange = { (value) => this.props.setAttributes({ titleTag: value}) }
              />

              <RangeControl 
                  label = { __('Title Fontsize') } value = { titlefontSize } 
                  onChange = { (value) => setAttributes({ titlefontSize: value }) } 
                  min = { 12 } 
                  max = { 100 }
                  beforeIcon="editor-textcolor" 
                  allowReset
              />
              <TypographyControl
                  label={ __( "Title Fontfamily" ) }
                  attributes = { attributes }
                  setAttributes = { setAttributes }
                  fontFamily = { { value: titleFontFamily, label: __( "titleFontFamily" ) } }
                  fontWeight = { { value: titleFontWeight, label: __( "titleFontWeight" ) } }
                  fontSubset = { { value: titleFontSubset, label: __( "titleFontSubset" ) } }
              />  

              <hr class="pl-divider"/>
              <RangeControl 
                  label = { __('Meta Fontsize') } value = { postmetafontSize } 
                  onChange = { (value) => setAttributes({ postmetafontSize: value }) } 
                  min = { 12 } 
                  max = { 100 }
                  beforeIcon="editor-textcolor" 
                  allowReset
              />
              <TypographyControl
                  label={ __( "Meta Fontfamily" ) }
                  attributes = { attributes }
                  setAttributes = { setAttributes }
                  fontFamily = { { value: metaFontFamily, label: __( "metaFontFamily" ) } }
                  fontWeight = { { value: metafontWeight, label: __( "metafontWeight" ) } }
                  fontSubset = { { value: metaFontSubset, label: __( "metaFontSubset" ) } }
              />

              <hr class="pl-divider"/>
              <RangeControl 
                  label = { __('Excerpt Fontsize') } value = { postexcerptfontSize } 
                  onChange = { (value) => setAttributes({ postexcerptfontSize: value }) } 
                  min = { 12 } 
                  max = { 100 }
                  beforeIcon="editor-textcolor" 
                  allowReset
              />
              <TypographyControl
                  label={ __( "Excerpt Fontfamily" ) }
                  attributes = { attributes }
                  setAttributes = { setAttributes }
                  fontFamily = { { value: excerptFontFamily, label: __( "excerptFontFamily" ) } }
                  fontWeight = { { value: excerptFontWeight, label: __( "excerptFontWeight" ) } }
                  fontSubset = { { value: excerptFontSubset, label: __( "excerptFontSubset" ) } }
              />

              <hr class="pl-divider"/>
              <RangeControl 
                  label = { __('Readmore Fontsize') } value = { postctafontSize } 
                  onChange = { (value) => setAttributes({ postctafontSize: value }) } 
                  min = { 12 } 
                  max = { 100 }
                  beforeIcon="editor-textcolor" 
                  allowReset
              />
              <TypographyControl
                  label={ __( "Readmore Fontfamily" ) }
                  attributes = { attributes }
                  setAttributes = { setAttributes }
                  fontFamily = { { value: ctaFontFamily, label: __( "ctaFontFamily" ) } }
                  fontWeight = { { value: ctafontWeight, label: __( "ctafontWeight" ) } }
                  fontSubset = { { value: ctaFontSubset, label: __( "ctaFontSubset  " ) } }
              />

              <hr class="pl-divider"/>
              <RangeControl 
                  label = { __('Social Icon Fontsize') } value = { socialSharefontSize } 
                  onChange = { (value) => setAttributes({ socialSharefontSize: value }) } 
                  min = { 12 } 
                  max = { 100 }
                  beforeIcon="editor-textcolor" 
                  allowReset
              />          
          </PanelBody>
          <PanelBody title={ __( 'Space Settings' )} initialOpen={ false } >

            { layoutopt === 'grid' &&

              <Fragment>
                  <RangeControl 
                    label = { __('Raw Space') } value = { rowSpace } 
                    onChange = { (value) => setAttributes({ rowSpace: value }) } 
                    min = { 12 } 
                    max = { 100 }
                    beforeIcon="excerpt-view" 
                    allowReset
                  />
                  <RangeControl 
                      label = { __('Column Space') } value = { columnSpace } 
                      onChange = { (value) => setAttributes({ columnSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="grid-view" 
                      allowReset
                  />
                  <RangeControl 
                      label = { __('Inner Space') } value = { innerSpace } 
                      onChange = { (value) => setAttributes({ innerSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="editor-textcolor" 
                      allowReset
                  />
                  <RangeControl 
                      label = { __('Below Image Space') } value = { belowImageSpace } 
                      onChange = { (value) => setAttributes({ belowImageSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="arrow-down-alt" 
                      allowReset
                  />
                  <RangeControl 
                      label = { __('Below Title Space') } value = { belowTitleSpace } 
                      onChange = { (value) => setAttributes({ belowTitleSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="arrow-down-alt" 
                      allowReset
                  />
                  <RangeControl 
                      label = { __('Below Exerpt Space') } value = { belowexerptSpace } 
                      onChange = { (value) => setAttributes({ belowexerptSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="arrow-down-alt" 
                      allowReset
                  /> 
                  <RangeControl 
                      label = { __('Below Readmore Space') } value = { belowctaSpace } 
                      onChange = { (value) => setAttributes({ belowctaSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="arrow-down-alt" 
                      allowReset
                  />
              </Fragment> 
            }

            { layoutopt === 'list' &&

              <Fragment>
                  <RangeControl 
                    label = { __('Raw Space') } value = { rowSpace } 
                    onChange = { (value) => setAttributes({ rowSpace: value }) } 
                    min = { 12 } 
                    max = { 100 }
                    beforeIcon="excerpt-view" 
                    allowReset
                  />
                  <RangeControl 
                      label = { __('Inner Space') } value = { innerSpace } 
                      onChange = { (value) => setAttributes({ innerSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="editor-textcolor" 
                      allowReset
                  />
                  <RangeControl 
                      label = { __('Below Title Space') } value = { belowTitleSpace } 
                      onChange = { (value) => setAttributes({ belowTitleSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="arrow-down-alt" 
                      allowReset
                  />
                  <RangeControl 
                      label = { __('Below Exerpt Space') } value = { belowexerptSpace } 
                      onChange = { (value) => setAttributes({ belowexerptSpace: value }) } 
                      min = { 12 } 
                      max = { 100 }
                      beforeIcon="arrow-down-alt" 
                      allowReset
                  /> 
              </Fragment>

             }
           
          </PanelBody>
           <PanelBody title={ __( 'Color Settings' )} initialOpen={ false }>
            { layoutopt == 'grid' && layoutcount == '1' &&
               <Fragment>  
                    <p className="pl-color-label">{ __( "Background Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: boxbgColor }} ></span></span></p>
                    <ColorPalette
                        value={boxbgColor}
                        onChange={ ( colorValue ) => setAttributes( { boxbgColor: colorValue } )}
                        allowReset
                      />
               </Fragment> 
              }
              { layoutopt == 'grid' && layoutcount == 2 &&
                <Fragment>
                    <p className="pl-color-label">{ __( "Background Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: designtwoboxbgColor }} ></span></span></p>
                    <ColorPalette
                      value={ designtwoboxbgColor}
                      onChange={ ( colorValue ) => setAttributes( { designtwoboxbgColor: colorValue } )}
                      allowReset
                    />  
                </Fragment>     
               }
               { layoutopt == 'list' &&
                  <Fragment>
                      <p className="pl-color-label">{ __( "Background Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: listlayouttwobgColor }} ></span></span></p>
                      <ColorPalette
                        value={ listlayouttwobgColor}
                        onChange={ ( colorValue ) => setAttributes( { listlayouttwobgColor: colorValue } )}
                        allowReset
                      />  
                  </Fragment>     
               }   
              <p className="pl-color-label">{ __( "Title Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: titleColor }} ></span></span></p>
              <ColorPalette
                  value={titleColor}
                  onChange={ ( colorValue ) => setAttributes( { titleColor: colorValue } )}
                  allowReset
                />

              <p className="pl-color-label">{ __( "Meta Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: postmetaColor }} ></span></span></p>  
              <ColorPalette
                value={ postmetaColor}
                onChange={ ( colorValue ) => setAttributes( { postmetaColor: colorValue } )}
                allowReset
              />

              <p className="pl-color-label">{ __( "Excerpt Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: postexcerptColor }} ></span></span></p>
              <ColorPalette
                value={ postexcerptColor}
                onChange={ ( colorValue ) => setAttributes( { postexcerptColor: colorValue } )}
                allowReset  
              />
               { readmoreView == 'text-only' &&
                  <Fragment>
                     <p className="pl-color-label">{ __( "Readmore Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: postctaColor }} ></span></span></p>
                        <ColorPalette
                          value={ postctaColor}
                          onChange={ ( colorValue ) => setAttributes( { postctaColor: colorValue } )}
                          allowReset
                        />
                  </Fragment> 
               }

               { readmoreView === 'pl-button' &&
                    <Fragment>  
                    <p className="pl-color-label">{ __( "Readmore text Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: postctaColor }} ></span></span></p>
                    <ColorPalette
                      value={ postctaColor}
                      onChange={ ( colorValue ) => setAttributes( { postctaColor: colorValue } )}
                      allowReset
                    />

                    <p className="pl-color-label">{ __( "Readmore Background Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: readmoreBgColor }} ></span></span></p>
                    <ColorPalette
                    value={readmoreBgColor}
                    onChange={( colorValue ) => setAttributes( { readmoreBgColor: colorValue } )}
                    allowReset
                  />
                 </Fragment> 
                }
               { layoutopt === 'list' && 
                  <Fragment>  
                    <p className="pl-color-label">{ __( "Primary Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: primaryColor }} ></span></span></p>
                    <ColorPalette
                      value={ primaryColor}
                      onChange={ ( colorValue ) => setAttributes( { primaryColor: colorValue } )}
                      allowReset
                    />

                     <p className="pl-color-label">{ __( "Secondary Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: secondaryColor }} ></span></span></p>
                     <ColorPalette
                        value={secondaryColor}
                        onChange={( colorValue ) => setAttributes( { secondaryColor: colorValue } )}
                        allowReset
                     />
                 </Fragment> 
               }
              <p className="pl-color-label">{ __( "Social Share Color" ) }<span className="components-base-control__label"><span className="component-color-indicator" style={{ backgroundColor: socialShareColor }} ></span></span></p>
              <ColorPalette
                value={ socialShareColor}
                onChange={ ( colorValue ) => setAttributes( { socialShareColor: colorValue } )}
                allowReset  
              />
              
        </PanelBody>
    </InspectorControls>
   );
      
      var plelement = document.getElementById( "pl-style-" + this.props.clientId )

        if( null != plelement && "undefined" != typeof plelement ) {
          plelement.innerHTML = pl_styling( this.props, "pl_post_layouts" )
        }

        const hasPosts = Array.isArray(latestPosts) && latestPosts.length;
        if (!hasPosts) {
          return ( <Fragment> {
              inspectorControls
            } 
              <Placeholder icon = "admin-post" label = { __('Post Layouts for Gutenberg by Techeshta') } >
                {!Array.isArray(latestPosts) ?
                  <Spinner / > : __('No posts found.')
                } 
            </Placeholder> 
            </Fragment>
          );
        }

        // Removing posts from display should be instant.
        const displayPosts = latestPosts.length > postsToShow ?
          latestPosts.slice(0, postsToShow) :
          latestPosts;

        return ( <Fragment > { inspectorControls } 
          <BlockControls >
          <BlockAlignmentToolbar 
              value = { align } 
              onChange = { (value) => { setAttributes({ align: value }); } }  
              controls = {['center', 'wide'] } />
          </BlockControls>

        <div id={ `pl_post_layouts-${ block_id }` } className = { classnames( this.props.className, `pl-${ layoutopt }-template${ layoutcount }` ) } >
          { layoutopt == "grid" && layoutcount == 1 &&
            <div className = {
              classnames({ 'pl-is-grid': layoutopt === 'grid', 'pl-is-list': layoutopt === 'list', [`pl_columns-${ columns }`]: layoutopt === 'grid',
                'gb-post-grid-items': 'pl-template' }, `${eqheight}`)
            } >
            {
              displayPosts.map((post, i) =>
               <article className={`pl-post-grid`}>
                <div key = { i } className = { classnames( post.featured_image_src && displayPostImage ? 'has-thumb pl-items' : 'no-thumb pl-items' ) }>
                {
                  displayPostImage && post.featured_image_src !== undefined && post.featured_image_src ? ( <div class = "pl-image" >
                    <a href = { post.link } target = "_blank" rel = "bookmark" >
                    <img src = { isLandscape ? post.featured_image_src : post.featured_image_src_square } 
                         alt = { decodeEntities(post.title.rendered.trim()) || __('(Untitled)') } /> </a> </div>
                  ) : ( null )
                }

                <div class = "pl-text" > {
                  displayPostCategory && post.category_info && post.category_info.length !== 0 &&
                  <div class = "category-link"
                  dangerouslySetInnerHTML = {
                    {
                      __html: post.category_info
                    }
                  }
                  />
                }
                 <div class = "pl-blogpost-title" > 
                    <Tag className="pl-title">
                    <a href = { post.link } target = "_blank" rel = "bookmark" > { decodeEntities(post.title.rendered.trim()) || __('(Untitled)') }</a>
                    </Tag>
                </div >
                <div class = "pl-blogpost-byline" >
                <div class = " metadatabox" >{
                  displayPostAuthor && post.author_info.display_name &&
                  <div class = "post-author" > By <span class = "pl-blogpost-author">
                    <a class = "gb-famoustext-link" target = "_blank" href = "{ post.author_info.author_link } " > { post.author_info.display_name } </a> </span> 
                  </div>
                }
                {
                  displayPostDate && post.date_gmt &&
                    <div class = "mdate " > 
                        On <span> { moment(post.date_gmt).local().format('MMMM DD, Y') } </span> 
                    </div>
                } 
                { displayPostComments && post.comment_info && 
                  <div class = "post-comments" > { post.comment_info } </div> } </div> 
                    <div class = "pl-blogpost-excerpt" > {
                      displayPostExcerpt &&
                        <div dangerouslySetInnerHTML = {
                          {
                            __html: post.wordExcerpt_info.split(/\s+/).slice(0, wordsExcerpt).join(" ")
                          }
                        }
                  />
                } 
                {
                  displayPostLink && readmoreView == 'text-only' &&
                    <div className={`${readmoreView}`}> 
                      <a class = "pl-link gb-text-link" href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                    </div>
                }
                {
                  displayPostLink && readmoreView == 'pl-button' &&
                      <a className = {`${readmoreView} pl-link gb-text-link`} href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                }
                 </div> 
                <div class = "pl-blogpost-bototm-wrap" > 
                  {
                    displayPostTag && post.tags_info && post.tags_info.length !== 0 &&
                  <div class = "pl-post-tags" dangerouslySetInnerHTML = {
                    {
                      __html: post.tags_info
                    }
                  }
                  />
                } {
                  displayPostSocialshare &&
                    <div class = "pl-social-wrap"
                      dangerouslySetInnerHTML = {
                        {
                          __html: post.social_share_info
                        }
                      }
                  />
                } </div> </div>

                </div> 
                </div>
              </article>
              )
            }

            </div> } 
            { layoutopt == "grid" && layoutcount == 2 &&
                <div className = { classnames({ 'pl-is-grid': layoutopt === 'grid', 'pl-is-list': layoutopt === 'list',
                     [`pl_columns-${ columns }`]: layoutopt === 'grid', 'gb-post-grid-items': 'pl-template' }) } >
                {
                  displayPosts.map((post, i) =>
                    <article className={`pl-post-grid`}>
                    <div key = { i } className = { classnames( post.featured_image_src && displayPostImage ? 'has-thumb pl-grid-2' : 'no-thumb pl-grid-2' ) }>
                    {
                      displayPostImage && post.featured_image_src !== undefined && post.featured_image_src ? ( 
                        <div class = "pl-image" >
                          <a href = { post.link } target = "_blank" rel = "bookmark" >
                          <img src = { isLandscape ? post.featured_image_src : post.featured_image_src_square }
                          alt = { decodeEntities(post.title.rendered.trim()) || __('(Untitled)') } /> </a> 
                        </div>
                      ) : (
                        null
                      )
                    }

                    <div class = "pl-blogpost-2-text" > {
                      displayPostCategory && post.category_info && post.category_info.length !== 0 &&
                      <div class = "pl-category-link-wraper" >
                      <div class = "category-link" dangerouslySetInnerHTML = {
                        {
                          __html: post.category_info.replace(",", "&")
                        }
                      }
                      /> </div>
                    } 
                    <div class = "pl-blogpost-title" >
                      <Tag className="pl-title"> 
                        <a href = { post.link } target = "_blank" rel = "bookmark" > { decodeEntities(post.title.rendered.trim()) || __('(Untitled)') } </a>
                      </Tag> 
                    </div>
                    <div class = "pl-blogpost-byline" >
                    <div class = " metadatabox" >
                  { displayPostAuthor && post.author_info.display_name &&
                    <div class = "post-author" > By <span class = "pl-blogpost-author" >
                      <a class = "gb-famoustext-link" target = "_blank" href = "{ post.author_info.author_link } " > { post.author_info.display_name } </a> </span> 
                    </div>
                    } {
                      displayPostDate && post.date_gmt &&
                        <div class = "mdate " > On <span> {
                          moment(post.date_gmt).local().format('MMMM, Y')
                        } </span>
                        </div>
                    } { displayPostComments && post.comment_info &&
                        <div class = "post-comments" > {
                          post.comment_info
                        } </div>
                    } </div> <div class = "pl-blogpost-excerpt" > {
                      displayPostExcerpt &&
                      <div dangerouslySetInnerHTML = {
                        {
                          __html: post.wordExcerpt_info.split(/\s+/).slice(0, wordsExcerpt).join(" ")
                        }
                      }
                      />
                    }
                    { displayPostLink && readmoreView == 'text-only' &&
                          <div className={`${readmoreView}`}> 
                            <a class = "pl-link gb-text-link" href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                          </div>
                      }
                      {
                        displayPostLink && readmoreView == 'pl-button' &&
                            <a className = {`${readmoreView} pl-button gb-text-link`} href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                      } 
                    </div> <div class = "pl-blogpost-bototm-wrap" > {
                      displayPostTag && post.tags_info && post.tags_info.length !== 0 &&
                      <div class = "pl-tags-wrap" > < span class = "link-label" > < i class = "fas fa-tags" > < /i></span >
                      <div class = "pl-post-tags"
                      dangerouslySetInnerHTML = {
                        {
                          __html: post.tags_info
                        }
                      }
                      /> </div>
                    } 
                    {
                      displayPostSocialshare &&
                        <div class = "pl-social-wrap" > <i class = "fas fa-share-alt"> </i> 
                        <div class = "social-share-data"
                      dangerouslySetInnerHTML = { {__html: post.social_share_info }}
                      /> </div>
                    }
                    </div> </div>

                    </div></div> </article>
                  )
                } 
                </div>
            } 
            { layoutopt == "list" && layoutcount == 1 &&
                <div className = { classnames({ 'pl-is-grid': layoutopt === 'grid', 'pl-is-list': layoutopt === 'list',
                  [`pl_columns-${ columns }`]: layoutopt === 'grid', 'pl-blogpost-items': 'pl-blogpost-items' },) } >
                {
                  displayPosts.map((post, i) =>
                    <article key = { i }
                    className = { classnames( post.featured_image_src && displayPostImage ? 'has-thumb pl-list-one' : 'no-thumb pl-list-one' ) } >

                    <div class = "pl-first-inner-wrap" > { displayPostImage && post.featured_image_src !== undefined && post.featured_image_src ? ( <div class = "pl-image" >
                          <a href = { post.link } target = "_blank" rel = "bookmark" >
                          <img src = { isLandscape ? post.featured_image_src : post.featured_image_src_square }
                               alt = { decodeEntities(post.title.rendered.trim()) || __('(Untitled)') } /> 
                        </a> 
                      </div> ) : 
                      ( null )
                    } 
                    {
                      displayPostCategory && post.category_info && post.category_info.length !== 0 &&
                        <div class = "pl-category-link-wraper" >
                        <div class = "category-link" dangerouslySetInnerHTML = {
                          {
                            __html: post.category_info
                          }
                      } /> 
                    </div>
                    } </div> <div class = "pl-second-inner-wrap" >
                    <div class = "pl-blogpost-byline" >
                    <div class = "metadatabox" > {
                      displayPostAuthor && post.author_info.display_name &&
                      <div class = "post-author" > By <span class = "pl-blogpost-author" >
                      <a class = "gb-famoustext-link"
                      target = "_blank"
                      href = "{ post.author_info.author_link } " > { post.author_info.display_name} </a> </span> </div>
                    } {
                      displayPostDate && post.date_gmt &&
                        <div class = "mdate " > On <span> {
                          moment(post.date_gmt).local().format('MMMM, Y')
                        } </span>
                        </div>
                    } { displayPostComments && post.comment_info &&
                        <div class = "post-comments" > {
                          post.comment_info
                        } </div>
                    } </div> <div class = "pl-text" >
                    <div class = "pl-blogpost-title" > 
                       <Tag className="pl-title">
                          <a href = { post.link } target = "_blank" rel = "bookmark" > { decodeEntities(post.title.rendered.trim()) || __('(Untitled)') } </a>
                       </Tag>
                    </div>

                    <div class = "pl-blogpost-excerpt" > {
                      displayPostExcerpt &&
                      <div dangerouslySetInnerHTML = {
                        {
                          __html: post.wordExcerpt_info.split(/\s+/).slice(0, wordsExcerpt).join(" ")
                        }
                      }
                      />
                    } 
                   { displayPostLink && readmoreView == 'text-only' &&
                          <p className={`${readmoreView}`}> 
                            <a class = "pl-link gb-text-link" href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                          </p>
                      }
                      {
                        displayPostLink && readmoreView == 'pl-button' &&
                            <a className = {`${readmoreView} pl-link gb-text-link`} href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                      } 

                    </div>

                    <div class = "pl-blogpost-bototm-wrap" > {
                      displayPostTag && post.tags_info && post.tags_info.length !== 0 &&
                      <div class = "pl-tags-wrap" >
                      <div class = "pl-post-tags"
                      dangerouslySetInnerHTML = {
                        {
                          __html: post.tags_info
                        }
                      }
                      /> </div>
                    } {
                      displayPostSocialshare &&
                        <div class = "pl-social-wrap" >
                        <div class = "social-share-data"
                         dangerouslySetInnerHTML = {
                          {
                            __html: post.social_share_info
                          }
                        }
                      />
                      </div>
                    } 
                    </div></div> </div> 
                    <div class = "pl-clearfix"></div> </div> 
                    </article>
                  )
                } </div>
            }
            { layoutopt == "list" && layoutcount == 2 &&
                <div className = { classnames({
                    'pl-is-grid': layoutopt === 'grid',
                    'pl-is-list': layoutopt === 'list',
                  [`pl_columns-${ columns }`]: layoutopt === 'grid',
                    'pl-blogpost-items': 'pl-blogpost-items'
                  },)
                } >
                {
                  displayPosts.map((post, i) =>
                <article key={ i }
                    className={ classnames(
                        post.featured_image_src && displayPostImage ? 'has-thumb pl-items-2' : 'no-thumb pl-items-2'
                    ) }
                    >
                    <div class="pl-first-inner-wrap">
                    {   displayPostImage && post.featured_image_src !== undefined && post.featured_image_src ? (
                        <div class="pl-image">
                        <a href={ post.link } target="_blank" rel="bookmark">
                            <img
                                    src={ isLandscape ? post.featured_image_src : post.featured_image_src_square }
                                    alt={ decodeEntities( post.title.rendered.trim() ) || __( '(Untitled)' ) }
                            />
                        </a>
                        </div>
                    ) : ( null) }
                    { displayPostCategory && post.category_info && post.category_info.length !== 0 &&
                            <div class="pl-category-link-wraper tmp-2">
                                <div class="category-link" dangerouslySetInnerHTML={ { __html: post.category_info } } />
                            </div>
                        }
                    </div>
                    <div class="pl-second-inner-wrap">
                    <div class="pl-blogpost-byline">
                    <div class="metadatabox">
                    { displayPostAuthor && post.author_info.display_name &&
                        <div class="post-author"> <i class="fas fa-pencil-alt"></i>&nbsp;
                        <span class="pl-blogpost-author">
                            <a class="gb-famoustext-link" target="_blank" href="{ post.author_info.author_link } "> { post.author_info.display_name } </a>
                        </span>
                        </div>
                    } 
                    { displayPostDate && post.date_gmt &&
                        <div class="mdate "> <i class="fas fa-calendar-alt"></i> 
                            <span> { moment( post.date_gmt ).local().format( 'MMMM, Y' )  }</span>
                        </div>
                    }
                    { displayPostComments && post.comment_info &&
                        <div class="post-comments">
                            { post.comment_info }
                        </div>
                    }
                    </div>
                    <div class="pl-text">
                    <div class="pl-blogpost-title">
                       <Tag className="pl-title">
                        <a href={ post.link } target="_blank" rel="bookmark">{ decodeEntities( post.title.rendered.trim() ) || __( '(Untitled)' ) }</a>
                       </Tag>
                     </div>
                        <div class="pl-blogpost-excerpt">
                        { displayPostExcerpt && 
                            <div dangerouslySetInnerHTML={ { __html: post.wordExcerpt_info.split(/\s+/).slice(0,wordsExcerpt).join(" ") } } />
                        }
                        { displayPostLink && readmoreView == 'text-only' &&
                          <p className={`${readmoreView}`}> 
                            <a class = "pl-link gb-text-link" href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                          </p>
                      }
                      {
                        displayPostLink && readmoreView == 'pl-button' &&
                            <a className = {`${readmoreView} pl-link gb-text-link`} href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a>
                      }
                        </div> 
                        <div class="pl-blogpost-bototm-wrap">
                        { displayPostTag && post.tags_info && post.tags_info.length !== 0 &&
                            <div class="pl-tags-wrap">
                            <div class="pl-post-tags" dangerouslySetInnerHTML={ { __html: post.tags_info } } />
                            </div>
                        }{ displayPostSocialshare &&
                        <div class="pl-social-wrap">
                            <div class="social-share-data" dangerouslySetInnerHTML={ { __html: post.social_share_info } } />
                        </div>
                        }
                        </div></div></div>
                        <div class="pl-clearfix"></div>
                    </div>
                </article>
                  )
                } </div>
            }
          { layoutopt == "list"  && layoutcount == 3 &&
            <div className={ classnames( {
                  'pl-is-grid': layoutopt === 'grid', 'pl-is-list': layoutopt === 'list',
                  [ `pl_columns-${ columns }` ]: layoutopt === 'grid', 'pl-blogpost-items' : 'pl-blogpost-items' } ) } >
           { displayPosts.map( ( post, i ) =>
            <article key={ i }
                className={ classnames(
                        post.featured_image_src && displayPostImage ? 'has-thumb pl-blog-template-3 pl-items-3' : 'no-thumb pl-blog-template-3 pl-items-3' ) } >
            <div class="pl-clearfix">
            <div class="pl-first-inner-wrap">
            {  
                displayPostImage && post.featured_image_src !== undefined && post.featured_image_src ? (
                <div class="pl-image">
                <a href={ post.link } target="_blank" rel="bookmark">
                    <img src={ isLandscape ? post.featured_image_src : post.featured_image_src_square } alt={ decodeEntities( post.title.rendered.trim() ) || __( '(Untitled)' ) } />
                </a>
                </div>
                ) : ( null )
            }
            { displayPostCategory && post.category_info && post.category_info.length !== 0 &&
                <div class="pl-category-link-wraper">
                    <div class="category-link" dangerouslySetInnerHTML={ { __html: post.category_info } } />
                </div>
            }
            </div>
            <div class="pl-second-inner-wrap">
                <div class="pl-blogpost-byline">
                <div class="pl-text">
                    <div class="pl-blogpost-title">
                      <Tag className="pl-title">
                        <a href={ post.link } target="_blank" rel="bookmark">{ decodeEntities( post.title.rendered.trim() ) || __( '(Untitled)' ) }</a>
                      </Tag>  
                    </div>
                    
                    <div class="metadatabox">
                    { displayPostAuthor && post.author_info.display_name &&
                        <div class="post-author"> <i class="fas fa-pencil-alt"></i>&nbsp;
                        <span class="pl-blogpost-author">
                            <a class="gb-famoustext-link" target="_blank" href="{ post.author_info.author_link } "> { post.author_info.display_name } </a>
                        </span>
                        </div>
                    } 
                    { displayPostDate && post.date_gmt &&
                        <div class="mdate "> <i class="fas fa-calendar-alt"></i> 
                            <span> { moment( post.date_gmt ).local().format( 'MMMM, Y' )  }</span>
                        </div>
                    }
                    { displayPostComments && post.comment_info &&
                    <div class="post-comments">
                        { post.comment_info }
                    </div>
                    }
                    </div>
                    <div class="pl-blogpost-excerpt">
                        { displayPostExcerpt && 
                            <div dangerouslySetInnerHTML={ { __html: post.wordExcerpt_info.split(/\s+/).slice(0,wordsExcerpt).join(" ") } } />
                        }
                        <div class="pl-blogpost-bototm-wrap">
                        
                         { displayPostLink && readmoreView == 'text-only' &&
                          <div class="list-3-readview is-pl-inline"><a class="pl-link gb-text-link" href={ post.link } target="_blank" rel="bookmark">{ readMoreText }</a></div>
                         }
                         {
                            displayPostLink && readmoreView == 'pl-button' &&
                                <div class="list-3-readview is-pl-inline"><a className = {`${readmoreView} pl-link gb-text-link`} href = { post.link } target = "_blank" rel = "bookmark" > { readMoreText } </a></div>
                         }
                        { displayPostTag && post.tags_info && post.tags_info.length !== 0 &&
                            <div class="pl-tags-wrap">
                            <i class="fas fa-tags"></i>
                            <span class="" dangerouslySetInnerHTML={ { __html: post.tags_info } } />
                            </div>
                        }
                        { displayPostSocialshare &&
                        <div class="pl-social-wrap">
                            <div class="social-share-data" dangerouslySetInnerHTML={ { __html: post.social_share_info } } />
                        </div>
                        }
                        </div>  
                    </div> 
                </div>
                </div>
            </div>
            </div>
            </article>
        )}
        </div>
        }
        </div>
    </Fragment>
    );
    }
}

      export default withSelect((select, props) => {
        const {
          postsToShow,
          order,
          orderBy,
          categories
        } = props.attributes;
        const {
          getEntityRecords
        } = select('core');
        const latestPostsQuery = pickBy({
          categories,
          order,
          orderby: orderBy,
          per_page: postsToShow,
        }, (value) => !isUndefined(value));
        const categoriesListQuery = {
          per_page: 100,
        };
        return {
          latestPosts: getEntityRecords('postType', 'post', latestPostsQuery),
          categoriesList: getEntityRecords('taxonomy', 'category', categoriesListQuery),
        };
      })(LatestPostsBlock);
