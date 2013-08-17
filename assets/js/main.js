jQuery(document).ready(function($){	 

	$(".bs-sidebar ul li a[href^='#']").on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({ scrollTop: $(this.hash).offset().top }, 800); 
   // edit: Opera and IE requires the "html" elm. animated
	});
	
	$('.bs-sidebar ul li').click(function() {
      $("li.active").removeClass("active");
      $(this).addClass('active');
	});

});