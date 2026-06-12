/**
 * Scroll-reveal animations.
 *
 * Every element carrying a `data-animate="<animate.css class>"` attribute is
 * watched by a single IntersectionObserver. When it scrolls into view the
 * animation class is applied once, then the element is unobserved — no
 * per-frame work, no flicker. Users who prefer reduced motion are revealed
 * immediately without animation.
 */
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
