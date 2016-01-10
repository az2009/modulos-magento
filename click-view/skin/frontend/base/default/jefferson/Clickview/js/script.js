$clickview =  jQuery.noConflict();

$clickview(document).ready(function(){
	
	$clickview('.bxslider_clickview').bxSlider({
		
		  minSlides: 1,
		  maxSlides: 15,
		  slideWidth: 200,
		  slideMargin: 10
		    
	});

	$clickview('.bxslider_clickview_recents').bxSlider({
		
		  minSlides: 1,
		  maxSlides: 15,
		  slideWidth: 200,
		  slideMargin: 10
		    
	});
	
	$clickview('.bxslider_clickview_best_selling').bxSlider({
		
		  minSlides: 1,
		  maxSlides: 15,
		  slideWidth: 200,
		  slideMargin: 10
		    
	});
	
	
		
	
		
	
	  
	  
	
});