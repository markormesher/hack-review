var FiveStar = {
	init: function () {
		$('input.replace-five-star').each(function (i, e) {
			var origName = $(e).attr('name');
			$('<div class="five-star-module" data-orig-name="' + origName + '">' +
				'<i class="fa fa-2x fa-star-o five-star-1" data-orig-name="' + origName + '" data-position="1"></i>' +
				'<i class="fa fa-2x fa-star-o five-star-2" data-orig-name="' + origName + '" data-position="2"></i>' +
				'<i class="fa fa-2x fa-star-o five-star-3" data-orig-name="' + origName + '" data-position="3"></i>' +
				'<i class="fa fa-2x fa-star-o five-star-4" data-orig-name="' + origName + '" data-position="4"></i>' +
				'<i class="fa fa-2x fa-star-o five-star-5" data-orig-name="' + origName + '" data-position="5"></i>' +
				'</div>').insertAfter(e);
		});

		$('.five-star-module i.fa').mouseenter(function (e) {
			var s = $(this);
			var position = s.attr('data-position');
			for (var i = 1; i <= position; ++i) {
				s.parent().find('.five-star-' + i).css('color', '#ff9900').removeClass('fa-star-o').addClass('fa-star');
			}
		});

		$('.five-star-module i.fa').mouseout(function (e) {
			var s = $(this);
			s.parent().find('.fa').css('color', '#c0c0c0').removeClass('fa-star').addClass('fa-star-o');
			var origName = s.attr('data-orig-name');
			var setPosition = $('input[name="' + origName + '"]').val();
			for (var i = 1; i <= setPosition; ++i) {
				s.parent().find('.five-star-' + i).css('color', '#ff9900').removeClass('fa-star-o').addClass('fa-star');
			}
		});

		$('.five-star-module i.fa').click(function (e) {
			var s = $(this);
			var position = s.attr('data-position');
			var origName = s.attr('data-orig-name');
			$('input[name="' + origName + '"]').val(position);
		});
	}
};