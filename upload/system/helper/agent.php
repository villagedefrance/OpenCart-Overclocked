<?php
/*
| -------------------------------------------------------------------
| USER AGENT TYPES
| -------------------------------------------------------------------
| This file contains five arrays of user agent data. It is used by the
| Browser Class to help identify browser, platform, robot, and
| mobile device data. The array keys are used to identify the device
| and the array values are used to set the actual name of the item.
|
*/

$platforms = array (
	'windows nt 10.0' => 'Windows 10',
	'windows nt 6.3'  => 'Windows 8.1',
	'windows nt 6.2'  => 'Windows 8',
	'windows nt 6.1'  => 'Windows 7',
	'windows nt 6.0'  => 'Windows Vista',
	'windows nt 5.2'  => 'Windows 2003',
	'windows nt 5.1'  => 'Windows XP',
	'windows nt 5.01' => 'Windows 2000 (SP1)',
	'windows nt 5.0'  => 'Windows 2000',
	'windows nt 4.0'  => 'Windows NT 4.0',
	'winnt4.0'        => 'Windows NT 4.0',
	'winnt 4.0'       => 'Windows NT',
	'winnt'           => 'Windows NT',
	'win 9x 4.90'     => 'Windows Me',
	'windows 98'      => 'Windows 98',
	'win98'           => 'Windows 98',
	'windows 95'      => 'Windows 95',
	'win95'           => 'Windows 95',
	'windows'         => 'Unknown Windows OS',
	'os x'            => 'Mac OS X',
	'ppc mac'         => 'Power PC Mac',
	'freebsd'         => 'FreeBSD',
	'ppc'             => 'Macintosh',
	'android'         => 'Android',
	'linux'           => 'Linux',
	'debian'          => 'Debian',
	'sunos'           => 'Sun Solaris',
	'beos'            => 'BeOS',
	'apachebench'     => 'ApacheBench',
	'aix'             => 'AIX',
	'irix'            => 'Irix',
	'osf'             => 'DEC OSF',
	'hp-ux'           => 'HP-UX',
	'netbsd'          => 'NetBSD',
	'bsdi'            => 'BSDi',
	'openbsd'         => 'OpenBSD',
	'gnu'             => 'GNU/Linux',
	'unix'            => 'Unknown Unix OS'
);

$browsers = array(
	'Flock'        => 'Flock',
	'Edge'         => 'Microsoft Edge',
	'OPR'          => 'Opera',
	'Opera'        => 'Opera',
	'Trident/7.0'  => 'Internet Explorer 11',
	'Trident/6.0'  => 'Internet Explorer 10',
	'Trident/5.0'  => 'Internet Explorer 9',
	'Trident/4.0'  => 'Internet Explorer 8',
	'MSIE'         => 'Internet Explorer',
	'IE'           => 'Internet Explorer',
	'Shiira'       => 'Shiira',
	'Firefox'      => 'Firefox',
	'Chimera'      => 'Chimera',
	'Maxthon'      => 'Maxthon',
	'Comodo'       => 'Comodo Dragon',
	'Dragon'       => 'Chromodo',
	'Chrome'       => 'Chrome',
	'Chromium'     => 'Chromium',
	'Deepnet'      => 'Deepnet Explorer',
	'Phoenix'      => 'Phoenix',
	'Firebird'     => 'Firebird',
	'Camino'       => 'Camino',
	'Netscape'     => 'Netscape',
	'baidubrowser' => 'Baidu Browser',
	'OmniWeb'      => 'OmniWeb',
	'Safari'       => 'Safari',
	'Mozilla'      => 'Mozilla',
	'Yandex'       => 'Yandex Browser',
	'Konqueror'    => 'Konqueror',
	'icab'         => 'iCab',
	'Sleipnir'     => 'Sleipnir',
	'Lynx'         => 'Lynx',
	'Links'        => 'Links',
	'Lunascape'    => 'Lunascape',
	'hotjava'      => 'HotJava',
	'Dolfin'       => 'Dolphin',
	'amaya'        => 'Amaya',
	'Vivaldi'      => 'Vivaldi',
	'IBrowse'      => 'IBrowse',
	'Android'      => 'Android Browser'
);

$pads = array(
	'ipad'     => 'Apple iPad',
	'kindle'   => 'Kindle',
	'kobo'     => 'Kobo',
	'linx'     => 'Linx',
	'nook'     => 'Nook',
	'playbook' => 'PlayBook',
	'silk'     => 'Silk',
	'touchpad' => 'TouchPad',
	'android'  => 'Android',
	'tablet'   => 'Tablet',
	'xoom'     => 'Xoom'
);

$mobiles = array(
	'mobileexplorer' => 'Mobile Explorer',
	'palmsource'     => 'Palm',
	'palmscape'      => 'Palmscape',
	'motorola'       => 'Motorola',
	'nokia'          => 'Nokia',
	'palm'           => 'Palm',
	'ipod'           => 'Apple iPod Touch',
	'iphone'         => 'Apple iPhone',
	'sony'           => 'Sony Ericsson',
	'ericsson'       => 'Sony Ericsson',
	'blackberry'     => 'BlackBerry',
	'cocoon'         => 'O2 Cocoon',
	'blazer'         => 'Treo',
	'lg'             => 'LG',
	'lge'            => 'LGE',
	'amoi'           => 'Amoi',
	'xda'            => 'XDA',
	'mda'            => 'MDA',
	'vario'          => 'Vario',
	'htc'            => 'HTC',
	'kazam'          => 'Kazam',
	'nexus'          => 'Nexus',
	'huawey'         => 'Huawey',
	'samsung'        => 'Samsung',
	'sharp'          => 'Sharp',
	'sie-'           => 'Siemens',
	'alcatel'        => 'Alcatel',
	'benq'           => 'BenQ',
	'ipaq'           => 'HP iPaq',
	'mot-'           => 'Motorola',
	'playstation'    => 'PlayStation Portable',
	'hiptop'         => 'Danger Hiptop',
	'nec-'           => 'NEC',
	'panasonic'      => 'Panasonic',
	'philips'        => 'Philips',
	'sagem'          => 'Sagem',
	'sanyo'          => 'Sanyo',
	'spv'            => 'SPV',
	'zte'            => 'ZTE',
	'sendo'          => 'Sendo',
	'dsi'            => 'Nintendo DSi',
	'ds'             => 'Nintendo DS',
	'wii'            => 'Nintendo Wii',
	'3ds'            => 'Nintendo 3DS',
	'open web'       => 'Open Web',
	'openweb'        => 'OpenWeb',
	'ruggex'         => 'Ruggex',

	// Operating Systems
	'symbian'        => 'Symbian',
	'symbianos'      => 'SymbianOS',
	'elaine'         => 'Palm',
	'palm'           => 'Palm',
	'series60'       => 'Symbian S60',
	'windows ce'     => 'Windows CE',
	'windows phone'  => 'Windows Phone',
	'webos'          => 'WebOS',
	'android'        => 'Android',

	// Browsers
	'obigo'          => 'Obigo',
	'netfront'       => 'Netfront Browser',
	'openwave'       => 'Openwave Browser',
	'mobilexplorer'  => 'Mobile Explorer',
	'mobile safari'  => 'Mobile Safari',
	'operamini'      => 'Opera Mini',
	'opera mini'     => 'Opera Mini',
	'opera mobi'     => 'Opera Mobile',
	'crmo'           => 'Chrome Mobile',
	'crios'          => 'Chrome Mobile iOS',
	'chrome'         => 'Chrome Mobile',
	'iemobile'       => 'IE Mobile',
	'fennec'         => 'Fennec',
	'firefox'        => 'Firefox',
	'android'        => 'Android Browser',
	'dorothy'        => 'Dorothy Browser',
	'gobrowser'      => 'Go Browser',

	// Other
	'digital paths'  => 'Digital Paths',
	'avantgo'        => 'AvantGo',
	'xiino'          => 'Xiino',
	'novarra'        => 'Novarra Transcoder',
	'vodafone'       => 'Vodafone',
	'docomo'         => 'NTT DoCoMo',
	'o2'             => 'O2',

	// Fallback
	'mobile'         => 'Generic Mobile',
	'wireless'       => 'Generic Mobile',
	'j2me'           => 'Generic Mobile',
	'midp'           => 'Generic Mobile',
	'cldc'           => 'Generic Mobile',
	'up.link'        => 'Generic Mobile',
	'up.browser'     => 'Generic Mobile',
	'smartphone'     => 'Generic Mobile',
	'cellphone'      => 'Generic Mobile'
);

// Most common robots
$robots = array(
	'Yandex'                      => 'Yandex',
	'Googlebot'                   => 'Google',
	'Mediapartners-Google'        => 'Mediapartners-Google (Adsense)',
	'askjeeves'                   => 'AskJeeves',
	'fastcrawler'                 => 'FastCrawler',
	'infoseek'                    => 'InfoSeek Robot 1.0',
	'facebot'                     => 'Facebook',
	'WebCrawler'                  => 'WebCrawler search',
	'ZyBorg'                      => 'Wisenut search',
	'scooter'                     => 'AltaVista',
	'StackRambler'                => 'Rambler',
	'Aport'                       => 'Aport',
	'lycos'                       => 'Lycos',
	'WebAlta'                     => 'WebAlta',
	'yahoo'                       => 'Yahoo',
	'msnbot'                      => 'msnbot 1.0',
	'ia_archiver'                 => 'Alexa search engine',
	'FAST'                        => 'AllTheWeb',
	'Slurp'                       => 'Hot Bot search',
	'Teoma'                       => 'Ask',
	'Baiduspider'                 => 'Baidu',
	'Gigabot'                     => 'Gigabot',
	'AdsBot-Google'               => 'Google-Adwords',
	'gsa-crawler'                 => 'Google-SA',
	'Googlebot-Image'             => 'Googlebot-Image',
	'ia_archiver-web.archive.org' => 'InternetArchive',
	'omgilibot'                   => 'Omgili',
	'Speedy Spider'               => 'Speedy Spider',
	'Y!J'                         => 'Yahoo JP',
	'link validator'              => 'DeadLinksChecker',
	'W3C_Validator'               => 'W3C Validator',
	'W3C_CSS_Validator'           => 'W3C CSSValidator',
	'FeedValidator'               => 'W3C FeedValidator',
	'W3C-checklink'               => 'W3C LinkChecker',
	'W3C-mobileOK'                => 'W3C mobileOK',
	'P3P Validator'               => 'W3C P3PValidator',
	'Bloglines'                   => 'Bloglines',
	'Feedburner'                  => 'Feedburner',
	'Snapbot'                     => 'SnapBot',
	'psbot'                       => 'Picsearch',
	'Websnapr'                    => 'Websnapr',
	'asterias'                    => 'Asterias',
	'192.comAgent'                => '192bot',
	'ABACHOBot'                   => 'AbachoBot',
	'ABCdatos'                    => 'Abdcatos',
	'Acoon'                       => 'Acoon',
	'Accoona'                     => 'Accoona',
	'BecomeBot'                   => 'BecomeBot',
	'BlogRefsBot'                 => 'BlogRefsBot',
	'Daumoa'                      => 'Daumoa',
	'DuckDuckBot'                 => 'DuckDuckBot',
	'Exabot'                      => 'Exabot',
	'Furlbot'                     => 'Furl',
	'FyberSpider'                 => 'FyberSpider',
	'GeonaBot'                    => 'Geona',
	'Girafabot'                   => 'GirafaBot',
	'GoSeeBot'                    => 'GoSeeBot',
	'ichiro'                      => 'Ichiro',
	'LapozzBot'                   => 'LapozzBot',
	'WISENutbot'                  => 'Looksmart',
	'MJ12bot/v2'                  => 'Majestic12',
	'MLBot'                       => 'MLBot',
	'msrbot'                      => 'MSRBOT',
	'MSR-ISRCCrawler'             => 'MSR-ISRCCrawler',
	'NaverBot'                    => 'Naver',
	'Yeti'                        => 'Yeti',
	'noxtrumbot'                  => 'NoxTrumBot',
	'OmniExplorer_Bot'            => 'OmniExplorer',
	'OnetSzukaj'                  => 'OnetSzukaj',
	'Scrubby'                     => 'ScrubTheWeb',
	'SearchSight'                 => 'SearchSight',
	'Seeqpod'                     => 'Seeqpod',
	'ShablastBot'                 => 'Shablast',
	'SitiDiBot'                   => 'SitiDiBot',
	'silk/1.0'                    => 'Slider',
	'Sogou'                       => 'Sogou',
	'Sosospider'                  => 'Sosospider',
	'StackRambler'                => 'StackRambler',
	'SurveyBot'                   => 'SurveyBot',
	'Touche'                      => 'Touche',
	'appie'                       => 'Walhello',
	'wisponbot'                   => 'Wisponbot',
	'yacybot'                     => 'YacyBot',
	'YodaoBot'                    => 'YodaoBot',
	'Charlotte'                   => 'Charlotte',
	'DiscoBot'                    => 'DiscoBot',
	'EnaBot'                      => 'EnaBot',
	'Gaisbot'                     => 'Gaisbot',
	'kalooga'                     => 'Kalooga',
	'ScoutJet'                    => 'ScoutJet',
	'TinEye'                      => 'TinEye',
	'twiceler'                    => 'Twiceler',
	'GSiteCrawler'                => 'GSiteCrawler',
	'HTTrack'                     => 'HTTrack',
	'Wget'                        => 'Wget'
);
