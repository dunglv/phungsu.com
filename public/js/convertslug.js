(function($) {
    $.fn.slug = function(options) {
    	var t = this;
        var config = $.extend({
            out: '.classinput'
        }, options);

        return this.each(function() {
        	// console.log(th)
            if ($(this).length < 1) {
                return false;
            }
            var v = $(this).val();
            if (v.length < 1) {
                return false;
            }
            v = v.replace(/[^a-zA-Z0-9-_.\s]/, '');

            $(this).on('click', function() {
            	console.log(v);
                $(config.out).val(v);
            });
        });
    }
}(jQuery));
