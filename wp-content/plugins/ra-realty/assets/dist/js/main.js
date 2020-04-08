(function($) {
	"use strict";

	$(document).ready(function(){

		// $(["input.input-phone", ".wpcf7-tel"]).inputmask("+7 (999) 999-99-99");

	})
	// поведение главного моб. меню
	.on('click', '', function(e){
		e.preventDefault();
	})
	;

	/*	------------------
		Helper functions
	--------------------- */
	// check for ie10, ie11
	function isIE(){
		return /Trident\/|MSIE/.test(window.navigator.userAgent);
	}

	// helper: get form values as object{name: value, ...} 
	// from form.serializeArray()
	function get_form_values(form_items){
		var obj = {};
		form_items.forEach(function(form_item) {
			obj[form_item.name] = form_item.value;
		});
		return obj;
	}

})(jQuery);