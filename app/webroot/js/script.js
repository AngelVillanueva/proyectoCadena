/* Author: Sinapse

*/

/* Search Form */
var textoInterior = $('header form .input label').text();
createValueLabel($('header form #searchinput'), textoInterior);
/* End of Search Form */

/* Home slider init */
if($('#slider-home').size()) {
	
	$('#slider-home .slidesh')
		.after('<div class="slide-nav-wrap"><a class="next-prev-slide-button prev-slide" href="#">&lt;</a><span class="slide-nav"></span><a class="next-prev-slide-button next-slide" href="#">&gt;</a> </div>')
		.cycle({
            fx:     'scrollHorz', 
            speed:   200, 
            timeout: 0, 
            pause: 1,
            pager: '#slider-home .slide-nav',
             next: '#slider-home .next-slide', 
             prev: '#slider-home .prev-slide'
        });
}
/* End of Home slider init */

/* Chain slider init */
if($('.slides').size()) {
	$('.slides').css('height', 'auto').jcarousel({
		scroll: 1,
		animation: 500,
		initCallback: carousel_callback
	});
	$('.slides li').css('width', '197px');
	$('.jcarousel-prev, .jcarousel-next').css('cursor', 'pointer');
}
/* End of Chain slider init */

/* Trigger hover state on bubble if mouseover My Account */
$('#main-nav li').bind('mouseover', function() {if($(this).next().children().attr('class') == 'bubble') {$(this).next().addClass('hover');} });
$('#main-nav li ul li').bind('mouseover', function() {if($(this).parent().parent().next().children().attr('class') == 'bubble') {$(this).parent().parent().next().addClass('nohover');} });
$('#main-nav li, #main-nav li ul li').bind('mouseout', function() {$('li.hover').removeClass('hover'); $('li.nohover').removeClass('nohover');});
/* End of Trigger hover state on bubble */

/* FUNCTIONS
   Common functions
*/

/*   ***   */
// function to set a default value in an input field
function createValueLabel (selector, defaultValue){
  //assign the default value to the form selector
  $(selector).data("default", defaultValue);
 
  //if the selector is empty, initialize the default value
  if(!$(selector).val()) $(selector).val(defaultValue);
 
  //assign a function to the focus and blur events
  $(selector).bind("focus blur", function(){
    value = $(this).val();
 
    //if the current and default value are the same, clear the input field
    if(value==defaultValue) {$(this). val("") .removeClass("auto-label");}
 
    //if the field is empty, set the value to default
    if(!value) {$(this) .val(defaultValue) .addClass("auto-label");}
  });
  //invoke the events to initialize the default value
    $(selector).trigger("focus").trigger("blur");
}

/*   ***   */
// callback function for the slider
function carousel_callback(carousel) {
	// Disable autoscrolling if the user clicks the prev or next button.
	carousel.buttonNext.bind('click', function() {
		carousel.startAuto(0);
	});
	
	carousel.buttonPrev.bind('click', function() {
		carousel.startAuto(0);
	});
	
	// Pause autoscrolling if the user moves with the cursor over the clip.
	carousel.clip.hover(function() {
		carousel.stopAuto();
	}, function() {
		carousel.startAuto();
	});
	
	$('.next-slide').bind('click', function() {
		carousel.next();
		return false;
	});
	
	$('.prev-slide').bind('click', function() {
		carousel.prev();
		return false;
	});
	
}

/*   ***   */
// function to 





















