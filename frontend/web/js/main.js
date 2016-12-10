$(function() {
	$('body').on('click', '.card', function() {
		window.location.href = $(this).data('href');
	});
});