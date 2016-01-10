	$jbp =  jQuery.noConflict();
	
	$jbp(document).ready(function(){
		
		$jbp('.jefferson_promocao .bxslider').bxSlider({
		
			auto:true,
			mode: 'fade',
			minSlides: 1,
		    maxSlides: 1,
		    moveSlides: 1,
		    
		  });
		
		$jbp(window).load(function(){
			$jbp('.jefferson_promocao .bxslider').css('opacity','1');
		});
		
	});