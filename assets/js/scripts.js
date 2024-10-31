jQuery.noConflict();
(function( $ ) {
 
    // More code using $ as alias to jQuery
jQuery( document ).ready(function( $ ) {

console.log(ci_multistep.login);

// Smart Wizard
            $('#ci_multistep_checkout').smartWizard({
                    selected: 0,
                    theme: 'default', // arrows ,circles , dots , default
                    transitionEffect:'fade',
                    showStepURLhash: false,
                    lang: { // Language variables for button
			           
			            placeorder: 'Place service',
                        login: 'Skip Login'
			        },
                    toolbarSettings: {
                	
                	showNextButton: true, // show/hide a Next button
                	showPreviousButton: true, // show/hide a Previous button
                	
            }, 
            });

           

           
 
                 
           

setTimeout(function(){
 $("#ci_multistep_checkout .checkout_coupon").show();
 $("#ci_multistep_checkout").animate({opacity: 1}, 200);
}, 2000);

setInterval(function(){
$('.ci_multistep .checkout_coupon, ').fadeIn();
}, 1000);


var checkout_width = $('#ci_multistep_checkout').width();
var checkout_li = $('#ci_multistep_checkout ul.multistep-nav-tabs li').size();
    $('#ci_multistep_checkout ul.multistep-nav-tabs li').addClass('done');
    $('#ci_multistep_checkout ul.multistep-nav-tabs li:first-child').removeClass('done');
var equal_width = checkout_width / checkout_li-0.1;
if(ci_multistep.multistep_style =='progress_bar'){
    if ($(window).width() > 600){
$('#ci_multistep_checkout ul.multistep-nav-tabs li').css('width', equal_width);

} 
}

       

$('.btn-wapper .button').click(function(){
    $('html, body').animate({
        scrollTop: $('#ci_multistep_checkout').offset().top
    }, 1000);
    
}); 


if(ci_multistep.login){
    $('.sw-btn-next').text('Next');
      $("#ci_multistep_checkout").on("showStep", function(e, anchorObject, stepNumber, stepDirection) {
         if(stepNumber == '0'){
            $('.sw-btn-next').text('Next');
         }
      });
}

}); 




})(jQuery);