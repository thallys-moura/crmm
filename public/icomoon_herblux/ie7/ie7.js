/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'icomoon\'">' + entity + '</span>' + html;
	}
	var icons = {
		'icon-success': '&#xe956;',
		'icon-settings': '&#xe955;',
		'icon-box': '&#xe954;',
		'icon-despesa2': '&#xe950;',
		'icon-despesa': '&#xe953;',
		'icon-banco': '&#xe958;',
		'icon-controle': '&#xe959;',
		'icon-blacklist': '&#xe952;',
		'icon-cart': '&#xe900;',
		'icon-ordem': '&#xe957;',
		'icon-notification': '&#xe901;',
		'icon-configuration': '&#xe902;',
		'icon-note': '&#xe903;',
		'icon-edit': '&#xe904;',
		'icon-calender': '&#xe905;',
		'icon-delete': '&#xe906;',
		'icon-more': '&#xe907;',
		'icon-checkbox-multiple': '&#xe908;',
		'icon-checkbox-select': '&#xe909;',
		'icon-checkbox-outline': '&#xe90a;',
		'icon-message': '&#xe90b;',
		'icon-video': '&#xe90c;',
		'icon-attachment': '&#xe90d;',
		'icon-sent': '&#xe90e;',
		'icon-call': '&#xe90f;',
		'icon-meeting': '&#xe910;',
		'icon-light': '&#xe911;',
		'icon-dark': '&#xe912;',
		'icon-mail': '&#xe913;',
		'icon-leads': '&#xe914;',
		'icon-filter': '&#xe915;',
		'icon-setting': '&#xe916;',
		'icon-product': '&#xe917;',
		'icon-contact': '&#xe918;',
		'icon-activity': '&#xe919;',
		'icon-perosnal': '&#xe91a;',
		'icon-quote': '&#xe91b;',
		'icon-dashboard': '&#xe91c;',
		'icon-cross-large': '&#xe91d;',
		'icon-left-arrow': '&#xe91e;',
		'icon-right-arrow': '&#xe91f;',
		'icon-up-arrow': '&#xe920;',
		'icon-down-arrow': '&#xe921;',
		'icon-search': '&#xe922;',
		'icon-add': '&#xe923;',
		'icon-add-2': '&#xe924;',
		'icon-radio-selected': '&#xe925;',
		'icon-radio-normal': '&#xe926;',
		'icon-folder': '&#xe927;',
		'icon-file': '&#xe928;',
		'icon-eye': '&#xe929;',
		'icon-eye-hide': '&#xe92a;',
		'icon-percentage': '&#xe92b;',
		'icon-dollar': '&#xe92c;',
		'icon-bookmark-not-selected': '&#xe92d;',
		'icon-bookmark-selected': '&#xe92e;',
		'icon-list': '&#xe92f;',
		'icon-enter': '&#xe930;',
		'icon-kanban': '&#xe931;',
		'icon-tick': '&#xe932;',
		'icon-attached-file': '&#xe933;',
		'icon-forward': '&#xe934;',
		'icon-location': '&#xe935;',
		'icon-pin': '&#xe936;',
		'icon-print': '&#xe937;',
		'icon-reply-all': '&#xe938;',
		'icon-reply': '&#xe939;',
		'icon-rotten': '&#xe93a;',
		'icon-tag': '&#xe93b;',
		'icon-settings-attributes': '&#xe93c;',
		'icon-settings-flow': '&#xe93d;',
		'icon-settings-group': '&#xe93e;',
		'icon-settings-mail': '&#xe93f;',
		'icon-settings-pipedrive': '&#xe940;',
		'icon-settings-roles': '&#xe941;',
		'icon-settings-sources': '&#xe942;',
		'icon-settings-tag': '&#xe943;',
		'icon-settings-type': '&#xe944;',
		'icon-settings-user': '&#xe945;',
		'icon-settings-webforms': '&#xe946;',
		'icon-settings-webhooks': '&#xe947;',
		'icon-attribute': '&#xe948;',
		'icon-download': '&#xe949;',
		'icon-move': '&#xe94a;',
		'icon-organisation': '&#xe94b;',
		'icon-role': '&#xe94c;',
		'icon-user': '&#xe94d;',
		'icon-warehouse': '&#xe94e;',
		'icon-icon-settings-warehouse': '&#xe94f;',
		'icon-sidebar': '&#xe951;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/icon-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
