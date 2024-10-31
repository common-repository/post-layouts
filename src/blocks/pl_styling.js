/**
 * Set inline styles.
 * @param  {object} props - The block object.
 * @return {object} The inline background type CSS.
 */

import pl_generateCSS from "./pl_generateCSS"

function pl_styling( props, id ) {

	const {
		boxbgColor,
		designtwoboxbgColor,
		listlayouttwobgColor,
        titleColor,
        primaryColor,
        secondaryColor,
        postmetaColor,
        postexcerptColor,
        postctaColor,
        socialShareColor,
        titlefontSize,
        postmetafontSize,
        postexcerptfontSize,
        postctafontSize,
        readmoreBgColor,
        socialSharefontSize,
        rowSpace,
        columnSpace,
        belowTitleSpace,
        belowImageSpace,
        belowexerptSpace,
        belowctaSpace,
        innerSpace,
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
	} = props.attributes

	var selectors = {
		" .pl-post-grid": {
			"padding-left" : (columnSpace/2) + "px",
			"padding-right" : (columnSpace/2) + "px",
			"margin-bottom" : rowSpace + "px",
		},
		" .pl-items": {
			"background" : boxbgColor,
		},
		" .pl-blogpost-2-text": {
			"background" : designtwoboxbgColor,
			"padding-left" : innerSpace + "px",
			"padding-right" : innerSpace + "px",
		},
		" .pl-list-one, .pl-items-2, .pl-items-3 .pl-second-inner-wrap": {
			"background" : listlayouttwobgColor,
		},
		" .pl-blogpost-title": {
			"padding-bottom" : belowTitleSpace + "px",
		},
		" .pl-is-grid .pl-text, .pl-blogpost-2-text, .pl-is-list .pl-blogpost-byline": {
			"padding-left" : innerSpace + "px",
			"padding-right" : innerSpace + "px",
		},
		" .pl-image": {
			"padding-bottom" : belowImageSpace + "px",
		},
		" .pl-blogpost-excerpt a.pl-button, .pl-blogpost-excerpt a.pl-link":{
			"background":readmoreBgColor,
			"font-size":postctafontSize + "px",
			"font-family":ctaFontFamily,
			"font-weight":ctafontWeight,
			"color":postctaColor,
			"margin-bottom" : belowctaSpace + "px",
		},
		" .pl-is-list .pl-category-link-wraper div.category-link a": {
			"background":primaryColor,
			"color":secondaryColor,
		},
		" .pl-items-2 .pl-category-link-wraper": {
			"background":secondaryColor,
		},
		" .pl-is-list article": {
			"margin-bottom":rowSpace + "px",
		},
		"  .pl-items-2 .pl-blogpost-bototm-wrap": {
			"border-top":"2px solid" + secondaryColor,
			"border-bottom":"2px solid" + secondaryColor,
		},
		" .pl-blogpost-excerpt p": {
			"font-family":excerptFontFamily,
			"font-weight":excerptFontWeight,
			"color" : postexcerptColor,
			"font-size" : postexcerptfontSize + "px",
			"margin-bottom" : belowexerptSpace + "px",
		},
		" .pl-blogpost-title a": {
			"font-family":titleFontFamily,
			"font-weight":titleFontWeight,
			"color" : titleColor,
			"font-size" : titlefontSize + "px",
		},
		" .pl-blogpost-author a , .pl-post-tags a": {
			"font-family":metaFontFamily + " !important",
			"font-weight":metafontWeight + " !important",
			"color" : postmetaColor + " !important",
			"font-size" : postmetafontSize + "px" + " !important",
		},
		" .pl-blogpost-byline .metadatabox > div": {
			"font-family":metaFontFamily,
			"font-weight":metafontWeight,
			"color" : postmetaColor,
			"font-size" : postmetafontSize + "px",
		},
		" .pl-social-wrap a": {
			"color" : socialShareColor + " !important",
			"font-size" : socialSharefontSize + "px",
		},
		
	}

	var pl_styling_css = ""

	pl_styling_css = pl_generateCSS( selectors, `#${id}-${ props.clientId }` )

	return pl_styling_css
}

export default pl_styling
