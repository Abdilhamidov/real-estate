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

		var post_data = $(this).serializeObject();
		post_data['action'] = 'addpost';

		console.log('post_data', post_data);

		$.ajax({
			type: "POST",
			url: myajax.url,
			data: post_data,
			dataType: 'json',
			success: function(responce){
				console.log('responce', responce);
				if(responce.errors.length){
					alert(responce.errors.join('; '));
				}else{
					
				}
			},
			error: function (jqXHR, exception) {
				var msg = '';
				if (jqXHR.status === 0) {
				   msg = 'Not connect.\n Verify Network.';
				} else if (jqXHR.status == 404) {
				   msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
				   msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
				   msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
				   msg = 'Time out error.';
				} else if (exception === 'abort') {
				   msg = 'Ajax request aborted.';
				} else {
				   msg = 'Uncaught Error.\n' + jqXHR.responseText;
				}
				console.warn(msg);
			},
		});
	})
	;

	/*	------------------
		Helper functions
	--------------------- */
	// get form values as object
	if ( !(typeof $.fn.serializeObject == 'function') ) {
		$.fn.serializeObject = function() {
			var o = {};
			var a = this.serializeArray();
			$.each(a, function() {
				if (o[this.name]) {
					if (!o[this.name].push) {
						o[this.name] = [o[this.name]];
					}
					o[this.name].push(this.value || '');
				} else {
					o[this.name] = this.value || '';
				}
			});
			return o;
		};
	}


})(jQuery);