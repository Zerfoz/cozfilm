(function ($) {

	"use strict";

	var fullHeight = function () {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function () {
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebarCollapse').on('click', function () {
		$('#sidebar').toggleClass('active');
	});

})(jQuery);

// JavaScript is used to add click event listener to the links
const neonLinks = document.querySelectorAll('.neon-text');

neonLinks.forEach(link => {
	link.addEventListener('click', () => {
		link.classList.add('neon-animation');
		setTimeout(() => {
			link.classList.remove('neon-animation');
		}, 1000); // Menghapus kelas animasi setelah 1 detik
	});
});
