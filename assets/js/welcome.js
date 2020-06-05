$(function () {
	$('#preloader').remove();

	$.post('./assets/hndlr/Welcome.php', { carousel: '1' }, function (res) {
		$('.carousel-inner').html('');

		try {
			$.each(JSON.parse(res), function (idx, el) {
				$('.carousel-inner').append(`
					<div class="carousel-item" data-index="${idx}">
						<img class="d-block w-100" src="../files/events/${el.image}" alt="Slide ${el.title}">
					</div>
					`);

				$('.carousel-inner').find('[data-index="0"]').addClass('active');
			});
		} catch (e) {
			console.error('ERR', e.message);
		}
	});

	$('.carousel').carousel({
		interval: 4000
	});

	$.post('./assets/hndlr/Welcome.php', { vmgo: 'vision' }, function (res) {
		try {
			$.each(JSON.parse(res), function (idx, el) {
				$('#vision').html(el.content);
			});
		} catch (e) {
			console.error('ERR', e.message);
		}
	});

	$.post('./assets/hndlr/Welcome.php', { vmgo: 'mission' }, function (res) {
		try {
			$.each(JSON.parse(res), function (idx, el) {
				$('#mission').html(el.content);
			});
		} catch (e) {
			console.error('ERR', e.message);
		}
	});

	$.post('./assets/hndlr/Welcome.php', { vmgo: 'objectives' }, function (res) {
		try {
			$.each(JSON.parse(res), function (idx, el) {
				$('#objectives').html(el.content);
			});
		} catch (e) {
			console.error('ERR', e.message);
		}
	});

	DocumentReady();
});
