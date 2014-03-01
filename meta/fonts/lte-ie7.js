/* Use this script if you need to support IE 7 and IE 6. */

window.onload = function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
			'icon-picture' : '&#x22;',
			'icon-book' : '&#x23;',
			'icon-paper' : '&#x24;',
			'icon-compass' : '&#x25;',
			'icon-location' : '&#x26;',
			'icon-camera' : '&#x27;',
			'icon-database' : '&#x2a;',
			'icon-cog' : '&#x2b;',
			'icon-target' : '&#x2d;',
			'icon-share' : '&#x30;',
			'icon-share-2' : '&#x31;',
			'icon-map' : '&#x32;',
			'icon-browser' : '&#x33;',
			'icon-book-2' : '&#x34;',
			'icon-flight' : '&#x35;',
			'icon-facebook' : '&#x36;',
			'icon-facebook-2' : '&#x37;',
			'icon-facebook-3' : '&#x38;',
			'icon-twitter' : '&#x39;',
			'icon-twitter-2' : '&#x3a;',
			'icon-twitter-3' : '&#x3b;',
			'icon-feed' : '&#x3c;',
			'icon-feed-2' : '&#x3d;',
			'icon-feed-3' : '&#x3e;',
			'icon-youtube' : '&#x3f;',
			'icon-youtube-2' : '&#x40;',
			'icon-amazon' : '&#x28;',
			'icon-amazon-2' : '&#x41;',
			'icon-info' : '&#x2e;',
			'icon-info-circle' : '&#x42;',
			'icon-help' : '&#x43;',
			'icon-help-2' : '&#x44;',
			'icon-warning' : '&#x45;',
			'icon-list' : '&#x46;',
			'icon-arrow' : '&#x47;',
			'icon-arrow-2' : '&#x48;',
			'icon-arrow-3' : '&#x49;',
			'icon-arrow-4' : '&#x4a;',
			'icon-home' : '&#x4b;',
			'icon-search' : '&#x4c;',
			'icon-comment' : '&#x2f;',
			'icon-clock' : '&#x4d;',
			'icon-bars' : '&#x2c;',
			'icon-camera-2' : '&#x4e;',
			'icon-plus' : '&#x29;',
			'icon-minus' : '&#x4f;',
			'icon-close' : '&#x50;',
			'icon-plus-2' : '&#x51;',
			'icon-minus-2' : '&#x52;',
			'icon-creative-commons' : '&#x53;',
			'icon-user' : '&#x21;',
			'icon-retweet' : '&#x54;',
			'icon-map-pin-stroke' : '&#x55;',
			'icon-map-pin-fill' : '&#x56;',
			'icon-map-pin-alt' : '&#x57;'
		},
		els = document.getElementsByTagName('*'),
		i, attr, html, c, el;
	for (i = 0; i < els.length; i += 1) {
		el = els[i];
		attr = el.getAttribute('data-icon');
		if (attr) {
			addIcon(el, attr);
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c) {
			addIcon(el, icons[c[0]]);
		}
	}
};