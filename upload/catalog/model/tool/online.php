<?php
class ModelToolOnline extends Model {

	public function whosOnline($ip, $customer_id, $url, $referer, $user_agent) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_online WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-1 hour')) . "'");

		$this->db->query("REPLACE INTO " . DB_PREFIX . "customer_online SET ip = '" . $ip . "', customer_id = '" . (int)$customer_id . "', url = '" . $this->db->escape($url) . "', referer = '" . $this->db->escape($referer) . "', user_agent = '" . $this->db->escape($user_agent) . "', date_added = NOW()");
	}

	// Ban
	public function isBlockedIp($ip) {
		$status = false;

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "block_ip WHERE INET_ATON('" . $ip . "') BETWEEN INET_ATON(from_ip) AND INET_ATON(to_ip)");

		if ($query->num_rows) {
			$status = true;
		}

		return $status;
	}

	// Robots
	public function robotsOnline($ip, $robot, $user_agent) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "robot_online WHERE date_added < '" . date('Y-m-d H:i:s', strtotime('-6 hour')) . "'");

		$this->db->query("REPLACE INTO " . DB_PREFIX . "robot_online SET ip = '" . $ip . "', robot = '" . $this->db->escape($robot) . "', user_agent = '" . $this->db->escape($user_agent) . "', date_added = NOW()");
	}

	public function getRobotSignatures() {
		$robots = array();

		$robots[] = array('signature' => 'Yandex', 'name' => 'Yandex');
		$robots[] = array('signature' => 'Googlebot', 'name' => 'Google');
		$robots[] = array('signature' => 'Mediapartners-Google', 'name' => 'Mediapartners-Google (Adsense)');
		$robots[] = array('signature' => 'askjeeves', 'name' => 'AskJeeves');
		$robots[] = array('signature' => 'fastcrawler', 'name' => 'FastCrawler');
		$robots[] = array('signature' => 'infoseek', 'name' => 'InfoSeek Robot 1.0');
		$robots[] = array('signature' => 'facebot', 'name' => 'Facebook');
		$robots[] = array('signature' => 'WebCrawler', 'name' => 'WebCrawler search');
		$robots[] = array('signature' => 'ZyBorg', 'name' => 'Wisenut search');
		$robots[] = array('signature' => 'scooter', 'name' => 'AltaVista');
		$robots[] = array('signature' => 'StackRambler', 'name' => 'Rambler');
		$robots[] = array('signature' => 'Aport', 'name' => 'Aport');
		$robots[] = array('signature' => 'lycos', 'name' => 'Lycos');
		$robots[] = array('signature' => 'WebAlta', 'name' => 'WebAlta');
		$robots[] = array('signature' => 'yahoo', 'name' => 'Yahoo');
		$robots[] = array('signature' => 'msnbot', 'name' => 'msnbot 1.0');
		$robots[] = array('signature' => 'ia_archiver', 'name' => 'Alexa search engine');
		$robots[] = array('signature' => 'FAST', 'name' => 'AllTheWeb');
		$robots[] = array('signature' => 'Slurp', 'name' => 'Hot Bot search');
		$robots[] = array('signature' => 'Teoma', 'name' => 'Ask');
		$robots[] = array('signature' => 'Baiduspider', 'name' => 'Baidu');
		$robots[] = array('signature' => 'Gigabot', 'name' => 'Gigabot');
		$robots[] = array('signature' => 'AdsBot-Google', 'name' => 'Google-Adwords');
		$robots[] = array('signature' => 'gsa-crawler', 'name' => 'Google-SA');
		$robots[] = array('signature' => 'Googlebot-Image', 'name' => 'Googlebot-Image');
		$robots[] = array('signature' => 'ia_archiver-web.archive.org', 'name' => 'InternetArchive');
		$robots[] = array('signature' => 'omgilibot', 'name' => 'Omgili');
		$robots[] = array('signature' => 'Speedy Spider', 'name' => 'Speedy Spider');
		$robots[] = array('signature' => 'Y!J', 'name' => 'Yahoo JP');
		$robots[] = array('signature' => 'link validator', 'name' => 'DeadLinksChecker');
		$robots[] = array('signature' => 'W3C_Validator', 'name' => 'W3C Validator');
		$robots[] = array('signature' => 'W3C_CSS_Validator', 'name' => 'W3C CSSValidator');
		$robots[] = array('signature' => 'FeedValidator', 'name' => 'W3C FeedValidator');
		$robots[] = array('signature' => 'W3C-checklink', 'name' => 'W3C LinkChecker');
		$robots[] = array('signature' => 'W3C-mobileOK', 'name' => 'W3C mobileOK');
		$robots[] = array('signature' => 'P3P Validator', 'name' => 'W3C P3PValidator');
		$robots[] = array('signature' => 'Bloglines', 'name' => 'Bloglines');
		$robots[] = array('signature' => 'Feedburner', 'name' => 'Feedburner');
		$robots[] = array('signature' => 'Snapbot', 'name' => 'SnapBot');
		$robots[] = array('signature' => 'psbot', 'name' => 'Picsearch');
		$robots[] = array('signature' => 'Websnapr', 'name' => 'Websnapr');
		$robots[] = array('signature' => 'asterias', 'name' => 'Asterias');
		$robots[] = array('signature' => '192.comAgent', 'name' => '192bot');
		$robots[] = array('signature' => 'ABACHOBot', 'name' => 'AbachoBot');
		$robots[] = array('signature' => 'ABCdatos', 'name' => 'Abcdatos');
		$robots[] = array('signature' => 'Acoon', 'name' => 'Acoon');
		$robots[] = array('signature' => 'Accoona', 'name' => 'Accoona');
		$robots[] = array('signature' => 'BecomeBot', 'name' => 'BecomeBot');
		$robots[] = array('signature' => 'BlogRefsBot', 'name' => 'BlogRefsBot');
		$robots[] = array('signature' => 'Daumoa', 'name' => 'Daumoa');
		$robots[] = array('signature' => 'DuckDuckBot', 'name' => 'DuckDuckBot');
		$robots[] = array('signature' => 'Exabot', 'name' => 'Exabot');
		$robots[] = array('signature' => 'Furlbot', 'name' => 'Furl');
		$robots[] = array('signature' => 'FyberSpider', 'name' => 'FyberSpider');
		$robots[] = array('signature' => 'GeonaBot', 'name' => 'Geona');
		$robots[] = array('signature' => 'Girafabot', 'name' => 'GirafaBot');
		$robots[] = array('signature' => 'GoSeeBot', 'name' => 'GoSeeBot');
		$robots[] = array('signature' => 'ichiro', 'name' => 'Ichiro');
		$robots[] = array('signature' => 'LapozzBot', 'name' => 'LapozzBot');
		$robots[] = array('signature' => 'WISENutbot', 'name' => 'Looksmart');
		$robots[] = array('signature' => 'MJ12bot/v2', 'name' => 'Majestic12');
		$robots[] = array('signature' => 'MLBot', 'name' => 'MLBot');
		$robots[] = array('signature' => 'msrbot', 'name' => 'MSRBOT');
		$robots[] = array('signature' => 'MSR-ISRCCrawler', 'name' => 'MSR-ISRCCrawler');
		$robots[] = array('signature' => 'NaverBot', 'name' => 'Naver');
		$robots[] = array('signature' => 'Yeti', 'name' => 'Yeti');
		$robots[] = array('signature' => 'noxtrumbot', 'name' => 'NoxTrumBot');
		$robots[] = array('signature' => 'OmniExplorer_Bot', 'name' => 'OmniExplorer');
		$robots[] = array('signature' => 'OnetSzukaj', 'name' => 'OnetSzukaj');
		$robots[] = array('signature' => 'Scrubby', 'name' => 'ScrubTheWeb');
		$robots[] = array('signature' => 'SearchSight', 'name' => 'SearchSight');
		$robots[] = array('signature' => 'Seeqpod', 'name' => 'Seeqpod');
		$robots[] = array('signature' => 'ShablastBot', 'name' => 'Shablast');
		$robots[] = array('signature' => 'SitiDiBot', 'name' => 'SitiDiBot');
		$robots[] = array('signature' => 'silk/1.0', 'name' => 'Slider');
		$robots[] = array('signature' => 'Sogou', 'name' => 'Sogou');
		$robots[] = array('signature' => 'Sosospider', 'name' => 'Sosospider');
		$robots[] = array('signature' => 'StackRambler', 'name' => 'StackRambler');
		$robots[] = array('signature' => 'SurveyBot', 'name' => 'SurveyBot');
		$robots[] = array('signature' => 'Touche', 'name' => 'Touche');
		$robots[] = array('signature' => 'appie', 'name' => 'Walhello');
		$robots[] = array('signature' => 'wisponbot', 'name' => 'Wisponbot');
		$robots[] = array('signature' => 'yacybot', 'name' => 'YacyBot');
		$robots[] = array('signature' => 'YodaoBot', 'name' => 'YodaoBot');
		$robots[] = array('signature' => 'Charlotte', 'name' => 'Charlotte');
		$robots[] = array('signature' => 'DiscoBot', 'name' => 'DiscoBot');
		$robots[] = array('signature' => 'EnaBot', 'name' => 'EnaBot');
		$robots[] = array('signature' => 'Gaisbot', 'name' => 'Gaisbot');
		$robots[] = array('signature' => 'kalooga', 'name' => 'Kalooga');
		$robots[] = array('signature' => 'ScoutJet', 'name' => 'ScoutJet');
		$robots[] = array('signature' => 'TinEye', 'name' => 'TinEye');
		$robots[] = array('signature' => 'twiceler', 'name' => 'Twiceler');
		$robots[] = array('signature' => 'GSiteCrawler', 'name' => 'GSiteCrawler');
		$robots[] = array('signature' => 'HTTrack', 'name' => 'HTTrack');
		$robots[] = array('signature' => 'Wget', 'name' => 'Wget');

		return $robots;
	}
}
