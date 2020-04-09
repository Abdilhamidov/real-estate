(function($) {
	"use strict";
	// 
	$(document).ready(function(){

		$(".fractional-number").inputmask({ regex: "[\\d,.]+", greedy: false });
		
	})
	// 
	// .on('submit', 'form.add-realty-form', function(e){
	// 	e.preventDefault();
	// })
	;

	/*	------------------
		Helper functions
	--------------------- */
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
})(jQuery);