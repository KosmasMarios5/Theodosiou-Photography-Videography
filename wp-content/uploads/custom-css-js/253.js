<!-- start Simple Custom CSS and JS -->
<script type="text/javascript">
jQuery(document).ready(function($) {
  var container = $('#fullpage');
  
  if(container.length){
    
    var footer = $('.elementor-location-footer');
    footer.addClass('section');
    footer.addClass('fp-auto-height');
    footer.appendTo(container);
    
  	container.fullpage({  
        scrollingSpeed: 1000,
        //navigation: true,
        //slidesNavigation: true,
      	responsive: 768
    });
    
$('.fullpage-go-down').click(function() {
    $.fn.fullpage.moveSectionDown();
});


$('.fullpage-go-up').click(function() {
    $.fn.fullpage.moveSectionUp();
});

  }
});</script>
<!-- end Simple Custom CSS and JS -->
