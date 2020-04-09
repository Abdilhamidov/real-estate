(function($) {
	"use strict";

	// bootstrap form validation
	window.addEventListener('load', function() {
		//Fetch all the forms we want to apply custom Bootstrap validation styles to
		var forms = document.getElementsByClassName('needs-validation');
		// Loop over them and prevent submission
		var validation = Array.prototype.filter.call(forms, function(form) {
			form.addEventListener('submit', function(event) {
				$(form).find('.alert').css({'display':'none'});
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
	})

	// добавление имени загружаемого файла в инпут
	.on('change', 'form.add-realty-form .realty-photo', function(e){
		var fileObj =  e.target.files[0];
		$(this).next('.realty-photo-label').text(fileObj.name);
	})

	// добавление поста недвижимости
	.on('submit', 'form.add-realty-form', function(e){
		e.preventDefault();
		var form = $(this);

		$(form).find('.add-post-spinner').css({'display':'inline-block'});
		$(form).find('.form-overlay').fadeIn();
		$(form).find('.alert').css({'display':'none'});

		var form_data = new FormData($(form)[0]); 
		form_data.append('action', 'addpost');
		form_data.append('file', $('input.realty-photo').prop('files')[0]);

		$.ajax({
			type: "POST",
			url: myajax.url,
			processData: false,
			contentType: false,
			data: form_data,
			dataType: 'json',
			success: function(responce){
				console.log('responce', responce);
				if(responce.errors.length){
					alert(responce.errors.join('; '));
				}else{
					$(form).find('.alert').css({'display':'block'});
				}
				$(form).find('.add-post-spinner').css({'display':'none'});
				$(form).find('.form-overlay').fadeOut();
				$(form).trigger("reset");
				$(form).removeClass("was-validated");
				$(form).find('.realty-photo-label').text("");
			},
			error: function (jqXHR, exception) {
				console.warn('add post ajax error');
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