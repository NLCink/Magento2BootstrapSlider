/* SZero sliders functions plugin
|* by Don Nuwinda
|* http://www.stepzero.solutions
|* version: 1.0
|* updated: Jan 26, 2015
|* since 2015
|* licensed under the MIT License
|* Enjoy.
|* 
*/
define([
    "jquery",
    "jquery/ui",
	"stepzerosolutions/bootstrap"
], function($){
	$.fn.szeroslider = function( status ) {
		var bwidth = $(window).width();
		var resWidthData = $(this).data('responsivewidth');
		if( resWidthData!='' ) {
			resWidth = [1024,922,768];
		} else {
			resWidth = resWidthData.split(",");
		}
		
		var resType = parseInt( resWidth[2] );
		var maxValue = false
		$.each( resWidth, function( key, value ) {
			if( bwidth>parseInt( value ) && maxValue==false ){
				resType = parseInt( value );
				maxValue = true
			} 
		});

		
		$('.szcarousel').children('.item').each(function () {
			var divImg = $(this);
			$.each( resWidth, function( key, value ) {
				if( resType==parseInt( value ) ){
					if( resType==resWidth[0] ){
						var imgsrc = divImg.find('img').data('src');
					} else if( resType==resWidth[1]  ) {
						var imgsrc = divImg.find('img').data('mdsrc');
					} else if( resType==resWidth[2]  ) {		
						if( bwidth<resWidth[2] ){
							var imgsrc = divImg.find('img').data('xssrc');
						} else {
							var imgsrc = divImg.find('img').data('smsrc');
						}
					}
					divImg.find('img').attr('src', imgsrc);
				}
			});
		});

	}
	
	$('.szcarousel').szeroslider();
	$(window).resize(function() {
		$('.szcarousel').szeroslider();
	});
});