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
		'icon-notification': '&#xe900;',
		'icon-configuration': '&#xe901;',
		'icon-note': '&#xe902;',
		'icon-edit': '&#xe903;',
		'icon-calender': '&#xe904;',
		'icon-delete': '&#xe905;',
		'icon-more': '&#xe906;',
		'icon-checkbox-multiple': '&#xe907;',
		'icon-checkbox-select': '&#xe908;',
		'icon-checkbox-outline': '&#xe909;',
		'icon-message': '&#xe90a;',
		'icon-video': '&#xe90b;',
		'icon-attachment': '&#xe90c;',
		'icon-sent': '&#xe90d;',
		'icon-call': '&#xe90e;',
		'icon-meeting': '&#xe90f;',
		'icon-ligh': '&#xe910;',
		'icon-dark': '&#xe911;',
		'icon-mail': '&#xe912;',
		'icon-leads': '&#xe913;',
		'icon-filter': '&#xe914;',
		'icon-setting': '&#xe915;',
		'icon-product': '&#xe916;',
		'icon-contact': '&#xe917;',
		'icon-activity': '&#xe918;',
		'icon-perosnal': '&#xe919;',
		'icon-quote': '&#xe91a;',
		'icon-dashboard': '&#xe91b;',
		'icon-cross-large': '&#xe91c;',
		'icon-left-arrow': '&#xe91d;',
		'icon-right-arrow': '&#xe91e;',
		'icon-up-arrow': '&#xe91f;',
		'icon-down-arrow': '&#xe920;',
		'icon-search': '&#xe921;',
		'icon-add': '&#xe922;',
		'icon-add-2': '&#xe923;',
		'icon-radio-selected': '&#xe924;',
		'icon-radio-normal': '&#xe925;',
		'icon-folder': '&#xe926;',
		'icon-file': '&#xe927;',
		'icon-eye': '&#xe928;',
		'icon-eye-hide': '&#xe929;',
		'icon-percentage': '&#xe92a;',
		'icon-dollar': '&#xe92b;',
		'icon-bookmark-not-selected': '&#xe92c;',
		'icon-bookmark-selected': '&#xe92d;',
		'icon-list': '&#xe92e;',
		'icon-enter': '&#xe92f;',
		'icon-kanban': '&#xe930;',
		'icon-tick': '&#xe931;',
		'icon-attached-file': '&#xe932;',
		'icon-forward': '&#xe933;',
		'icon-location': '&#xe934;',
		'icon-pin': '&#xe935;',
		'icon-print': '&#xe936;',
		'icon-reply-all': '&#xe937;',
		'icon-reply': '&#xe938;',
		'icon-rotten': '&#xe939;',
		'icon-tag': '&#xe93a;',
		'icon-settings-attributes': '&#xe93b;',
		'icon-settings-flow': '&#xe93c;',
		'icon-settings-group': '&#xe93d;',
		'icon-settings-mail': '&#xe93e;',
		'icon-settings-pipedrive': '&#xe93f;',
		'icon-settings-roles': '&#xe940;',
		'icon-settings-sources': '&#xe941;',
		'icon-settings-tag': '&#xe942;',
		'icon-settings-type': '&#xe943;',
		'icon-settings-user': '&#xe944;',
		'icon-settings-webforms': '&#xe945;',
		'icon-settings-webhooks': '&#xe946;',
		'icon-attribute': '&#xe947;',
		'icon-download': '&#xe948;',
		'icon-move': '&#xe949;',
		'icon-organisation': '&#xe94a;',
		'icon-role': '&#xe94b;',
		'icon-user': '&#xe94c;',
		'icon-warehouse': '&#xe94d;',
		'icon-icon-settings-warehouse': '&#xe94e;',
		'icon-controle-diario': '&#xe94f;',
		'icon-sidebar': '&#xe950;',
		'icon-blacklist': '&#xe951;',
		'icon-cart': '&#xe952;',
		'icon-bank': '&#xe953;',
		'icon-despesa': '&#xe954;',
		'icon-remarketing': '&#xe955;',
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
