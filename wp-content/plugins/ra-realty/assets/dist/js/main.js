(function($) {
	"use strict";

	// bootstrap form validation
	window.addEventListener('load', function() {
		//Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				if (form.checkValidity() === false) {
					event.preventDefault();
					event.stopPropagation();
				}
				form.classList.add('was-validated');
			}, false);
		});
	}, false);

	// 
	$(document).ready(function(){

		// $(["input.input-phone", ".wpcf7-tel"]).inputmask("+7 (999) 999-99-99");

	})
	// 
	.on('submit', 'form.add-realty-form', function(e){
		e.preventDefault();
		var form_data = $(this).serialize();
		console.log('form_data', form_data);

		var ajaxUrl = $(this).attr('action');
		console.log('ajaxUrl', ajaxUrl);

		// console.log('post_data', post_data);

		// $.ajax({
		// 	type: "POST",
		// 	url: ajaxUrl,
		// 	data: post_data,
		// 	dataType: 'json',
		// 	success: function(responce){
		// 		var responce_content = responce;
		// 		console.log('responce', responce);
		// 		// вывод контента
		// 		$(root_block).find('.ajax-responce-content').empty();
		// 		$(root_block).find('.ajax-responce-content').text(JSON.stringify(responce));
		// 	},
		// 	error: function (jqXHR, exception) {
		// 		var msg = '';
		// 		if (jqXHR.status === 0) {
		// 		   msg = 'Not connect.\n Verify Network.';
		// 		} else if (jqXHR.status == 404) {
		// 		   msg = 'Requested page not found. [404]';
		// 		} else if (jqXHR.status == 500) {
		// 		   msg = 'Internal Server Error [500].';
		// 		} else if (exception === 'parsererror') {
		// 		   msg = 'Requested JSON parse failed.';
		// 		} else if (exception === 'timeout') {
		// 		   msg = 'Time out error.';
		// 		} else if (exception === 'abort') {
		// 		   msg = 'Ajax request aborted.';
		// 		} else {
		// 		   msg = 'Uncaught Error.\n' + jqXHR.responseText;
		// 		}
		// 		console.warn(msg);
		// 	},
		// });
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