$(function(){
	$('.post-box .navbar-toggler').on('click', function(){
		if($(this).data('expand') == 1){
			$('.post-box .content-sidebar').hide('100');
			$(this).data('expand', 0);
			$(this).find('.fas').removeClass('fas fa-chevron-up').addClass('fas fa-chevron-down');
		}
		else {
			$('.post-box .content-sidebar').slideDown();
			$(this).data('expand', 1);
			$(this).find('.fas').removeClass('fas fa-chevron-down').addClass('fas fa-chevron-up');
		}
	});
});