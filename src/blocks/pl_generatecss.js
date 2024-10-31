function pl_generateCSS ( selectors, id, isResponsive = false, responsiveType = "" ) {

	var pl_styling_css = ""
	
	for( var i in selectors ) {

		pl_styling_css += id

		pl_styling_css += i + " { "

		var sel = selectors[i]
		var css = ""

		for( var j in sel ) {

			css += j + ": " + sel[j] + ";"
		}

		pl_styling_css += css + " } "
	}

	// if ( isResponsive ) {
	// 	styling_css += " }"
	// }

	return pl_styling_css
}

export default pl_generateCSS
