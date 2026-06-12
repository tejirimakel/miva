
(function () {
	'use strict';

	var targets = document.querySelectorAll('[data-animate]');
	if (!targets.length) {
		return;
	}

	var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	if (reduceMotion || !('IntersectionObserver' in window)) {
		targets.forEach(function (el) {
			el.classList.add('is-visible');
		});
		return;
	}

	var observer = new IntersectionObserver(function (entries, obs) {
		entries.forEach(function (entry) {
			if (!entry.isIntersecting) {
				return;
			}
			var el = entry.target;
			el.classList.add('animate__animated', el.dataset.animate, 'is-visible');
			obs.unobserve(el);
		});
	}, { threshold: 0.15 });

	targets.forEach(function (el) {
		observer.observe(el);
	});
})();
