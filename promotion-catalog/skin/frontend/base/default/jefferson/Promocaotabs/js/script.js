$jbp =  jQuery.noConflict();

$jbp(document).ready(function(){
	
	$jbp('#jeffersonTabs .nav-tabs > a').click(function (e) {
	  $jbp(this).tab('show');
	  return false;
	});	
	
	$jbp('#jeffersonTabs .nav-tabs li:first-child').addClass('active');
	$jbp('#jeffersonTabs .tab-pane:first-child').addClass('active');
	

});