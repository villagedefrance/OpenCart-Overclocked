<?php
/*
| -------------------------------------------------------------------
| USER AGENT TYPES
| -------------------------------------------------------------------
| This file contains four arrays of user agent data.  It is used by the
| User Agent Class to help identify browser, platform, robot, and
| mobile device data.  The array keys are used to identify the device
| and the array values are used to set the actual name of the item.
|
*/

$platforms = array (
	'windows nt 10.0'	=> 'Windows 10',
	'windows nt 6.3'	=> 'Windows 8.1',
	'windows nt 6.2'	=> 'Windows 8',
	'windows nt 6.1'	=> 'Windows 7',
	'windows nt 6.0'	=> 'Windows Vista',
	'windows nt 5.2'	=> 'Windows 2003',
	'windows nt 5.1'	=> 'Windows XP',
	'windows nt 5.0'	=> 'Windows 2000',
	'windows nt 4.0'	=> 'Windows NT 4.0',
	'winnt4.0'			=> 'Windows NT 4.0',
	'winnt 4.0'			=> 'Windows NT',
	'winnt'				=> 'Windows NT',
	'windows 98'		=> 'Windows 98',
	'win98'				=> 'Windows 98',
	'windows 95'		=> 'Windows 95',
	'win95'				=> 'Windows 95',
	'windows'			=> 'Unknown Windows OS',
	'os x'					=> 'Mac OS X',
	'ppc mac'			=> 'Power PC Mac',
	'freebsd'				=> 'FreeBSD',
	'ppc'					=> 'Macintosh',
	'linux'					=> 'Linux',
	'debian'				=> 'Debian',
	'sunos'				=> 'Sun Solaris',
	'beos'					=> 'BeOS',
	'apachebench'		=> 'ApacheBench',
	'aix'					=> 'AIX',
	'irix'					=> 'Irix',
	'osf'					=> 'DEC OSF',
	'hp-ux'				=> 'HP-UX',
	'netbsd'				=> 'NetBSD',
	'bsdi'					=> 'BSDi',
	'openbsd'			=> 'OpenBSD',
	'gnu'					=> 'GNU/Linux',
	'unix'					=> 'Unknown Unix OS'
);

$browsers = array(
	'Flock'				=> 'Flock',
	'Chrome'				=> 'Chrome',
	'Chromium'			=> 'Chromium',
	'Opera'				=> 'Opera',
	'Edge'				=> 'Microsoft Edge',
	'Trident/4.0'		=> 'Internet Explorer 8',
	'Trident/5.0'		=> 'Internet Explorer 9',
	'Trident/6.0'		=> 'Internet Explorer 10',
	'Trident/7.0'		=> 'Internet Explorer 11',
	'MSIE'				=> 'Internet Explorer',
	'IE'					=> 'Internet Explorer',
	'Shiira'				=> 'Shiira',
	'Firefox'				=> 'Firefox',
	'Chimera'			=> 'Chimera',
	'Comodo'			=> 'Comodo Dragon',
	'Deepnet' 			=> 'Deepnet Explorer',
	'Phoenix'				=> 'Phoenix',
	'Firebird'				=> 'Firebird',
	'Camino'				=> 'Camino',
	'Netscape'			=> 'Netscape',
	'baidubrowser'		=> 'Baidu Browser',
	'Maxthon'			=> 'Maxthon',
	'OmniWeb'			=> 'OmniWeb',
	'Safari'				=> 'Safari',
	'Mozilla'				=> 'Mozilla',
	'Konqueror'			=> 'Konqueror',
	'icab'					=> 'iCab',
	'Sleipnir'				=> 'Sleipnir',
	'Lynx'					=> 'Lynx',
	'Links'				=> 'Links',
	'Lunascape'			=> 'Lunascape',
	'hotjava'				=> 'HotJava',
	'Dolfin'				=> 'Dolphin',
	'amaya'				=> 'Amaya',
	'Vivaldi'				=> 'Vivaldi',
	'IBrowse'			=> 'IBrowse'
);

$pads = array(
	'ipad'					=> 'iPad',
	'android'				=> 'Android',
	'kindle'				=> 'Kindle',
	'kobo'					=> 'Kobo',
	'nook'					=> 'Nook',
	'playbook'			=> 'PlayBook',
	'silk'					=> 'Silk',
	'touchpad'			=> 'TouchPad',
	'tablet'				=> 'Tablet',
	'xoom' 				=> 'Xoom'
);

$mobiles = array(
	// Phones and Manufacturers
	'mobileexplorer'	=> 'Mobile Explorer',
	'palmsource'		=> 'Palm',
	'palmscape'			=> 'Palmscape',
	'motorola'			=> 'Motorola',
	'nokia'				=> 'Nokia',
	'palm'					=> 'Palm',
	'ipod'					=> 'Apple iPod Touch',
	'iphone'				=> 'Apple iPhone',
	'ipad'					=> 'Apple iPad',
	'sony'					=> 'Sony Ericsson',
	'ericsson'			=> 'Sony Ericsson',
	'blackberry'			=> 'BlackBerry',
	'cocoon'				=> 'O2 Cocoon',
	'blazer'				=> 'Treo',
	'lg'						=> 'LG',
	'amoi'					=> 'Amoi',
	'xda'					=> 'XDA',
	'mda'					=> 'MDA',
	'vario'				=> 'Vario',
	'htc'					=> 'HTC',
	'samsung'			=> 'Samsung',
	'sharp'				=> 'Sharp',
	'sie-'					=> 'Siemens',
	'alcatel'				=> 'Alcatel',
	'benq'				=> 'BenQ',
	'ipaq'					=> 'HP iPaq',
	'mot-'				=> 'Motorola',
	'playstation' 		=> 'PlayStation Portable',
	'hiptop'				=> 'Danger Hiptop',
	'nec-'					=> 'NEC',
	'panasonic'			=> 'Panasonic',
	'philips'				=> 'Philips',
	'sagem'				=> 'Sagem',
	'sanyo'				=> 'Sanyo',
	'spv'					=> 'SPV',
	'zte'					=> 'ZTE',
	'sendo'				=> 'Sendo',
	'dsi'					=> 'Nintendo DSi',
	'ds'					=> 'Nintendo DS',
	'wii'					=> 'Nintendo Wii',
	'3ds'					=> 'Nintendo 3DS',
	'open web'			=> 'Open Web',
	'openweb'			=> 'OpenWeb',
	'kazam'				=> 'Kazam',
	'nexus'				=> 'Nexus',

	// Operating Systems
	'android'				=> 'Android',
	'symbian'			=> 'Symbian',
	'SymbianOS'		=> 'SymbianOS',
	'elaine'				=> 'Palm',
	'palm'					=> 'Palm',
	'series60'			=> 'Symbian S60',
	'windows ce'		=> 'Windows CE',
	'windows phone'	=> 'Windows Phone',
	'webos'				=> 'WebOS',

	// Browsers
	'obigo'				=> 'Obigo',
	'netfront'			=> 'Netfront Browser',
	'openwave'			=> 'Openwave Browser',
	'mobilexplorer'		=> 'Mobile Explorer',
	'mobile safari'		=> 'Mobile Safari',
	'operamini'			=> 'Opera Mini',
	'opera mini'			=> 'Opera Mini',
	'opera mobi'		=> 'Opera Mobile',
	'CrMo'				=> 'Chrome Mobile',
	'CriOS'				=> 'Chrome Mobile iOS',
	'Chrome'				=> 'Chrome Mobile',
	'IEMobile'			=> 'IE Mobile',
	'Fennec'				=> 'Fennec',

	// Other
	'digital paths'		=> 'Digital Paths',
	'avantgo'			=> 'AvantGo',
	'xiino'					=> 'Xiino',
	'novarra'				=> 'Novarra Transcoder',
	'vodafone'			=> 'Vodafone',
	'docomo'				=> 'NTT DoCoMo',
	'o2'					=> 'O2',

	// Fallback
	'mobile'				=> 'Generic Mobile',
	'wireless'			=> 'Generic Mobile',
	'j2me'					=> 'Generic Mobile',
	'midp'					=> 'Generic Mobile',
	'cldc'					=> 'Generic Mobile',
	'up.link'				=> 'Generic Mobile',
	'up.browser'		=> 'Generic Mobile',
	'smartphone'		=> 'Generic Mobile',
	'cellphone'			=> 'Generic Mobile'
);

// There are hundreds of bots but these are the most common.
$robots = array(
	'googlebot'			=> 'Googlebot',
	'msnbot'				=> 'MSNBot',
	'bingbot'				=> 'Bing',
	'slurp'					=> 'Inktomi Slurp',
	'yahoo'				=> 'Yahoo',
	'askjeeves'			=> 'AskJeeves',
	'fastcrawler'		=> 'FastCrawler',
	'infoseek'			=> 'InfoSeek Robot 1.0',
	'facebot'				=> 'Facebook',
	'lycos'				=> 'Lycos'
);
?>