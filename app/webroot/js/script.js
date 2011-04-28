/* Author: Sinapse

*/

/* Search Form */
var textoInterior = $('header form .input label').text();
createValueLabel($('header form #searchinput'), textoInterior);
/* End of Search Form */

/* First:n post */
if($('div.postear').size()) {
	$('div.post:nth-child(4n+1)').css('margin-left','0');
}
/* End of First:n post */

/* FUNCTIONS
   Common functions
*/
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






















