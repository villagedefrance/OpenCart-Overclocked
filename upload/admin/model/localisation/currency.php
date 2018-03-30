<?php
class ModelLocalisationCurrency extends Model {

	public function addCurrency($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "currency SET title = '" . $this->db->escape($data['title']) . "', code = '" . $this->db->escape($data['code']) . "', symbol_left = '" . $this->db->escape($data['symbol_left']) . "', symbol_right = '" . $this->db->escape($data['symbol_right']) . "', decimal_place = '" . $this->db->escape($data['decimal_place']) . "', `value` = '" . $this->db->escape($data['value']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW()");

		$currency_id = $this->db->getLastId();

		// Save and Continue
		$this->session->data['new_currency_id'] = $currency_id;

		if ($this->config->get('config_currency_auto')) {
			$this->updateCurrencies(true);
		}

		$this->cache->delete('currency');
	}

	public function editCurrency($currency_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "currency SET title = '" . $this->db->escape($data['title']) . "', code = '" . $this->db->escape($data['code']) . "', symbol_left = '" . $this->db->escape($data['symbol_left']) . "', symbol_right = '" . $this->db->escape($data['symbol_right']) . "', decimal_place = '" . $this->db->escape($data['decimal_place']) . "', `value` = '" . $this->db->escape($data['value']) . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE currency_id = '" . (int)$currency_id . "'");

		$this->cache->delete('currency');
	}

	public function editValueByCode($code, $value) {
		$this->db->query("UPDATE " . DB_PREFIX . "currency SET `value` = '" . (float)$value . "', date_modified = NOW() WHERE code = '" . $this->db->escape((string)$code) . "'");

		$this->cache->delete('currency');
	}

	public function deleteCurrency($currency_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "currency WHERE currency_id = '" . (int)$currency_id . "'");

		$this->cache->delete('currency');
	}

	public function getCurrency($currency_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE currency_id = '" . (int)$currency_id . "'");

		return $query->row;
	}

	public function getCurrencyByCode($code) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "currency WHERE code = '" . $this->db->escape(trim($code)) . "'");

		return $query->row;
	}

	public function getCurrencies($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "currency";

			$sort_data = array(
				'title',
				'code',
				'value',
				'date_modified',
				'status'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY title";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$query = $this->db->query($sql);

			return $query->rows;

		} else {
			$currency_data = $this->cache->get('currency');

			if (!$currency_data) {
				$currency_data = array();

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency ORDER BY title ASC");

				foreach ($query->rows as $result) {
					$currency_data[$result['code']] = array(
						'currency_id'   => $result['currency_id'],
						'title'         => $result['title'],
						'code'          => $result['code'],
						'symbol_left'   => $result['symbol_left'],
						'symbol_right'  => $result['symbol_right'],
						'decimal_place' => $result['decimal_place'],
						'value'         => $result['value'],
						'status'        => $result['status'],
						'date_modified' => $result['date_modified']
					);
				}

				$this->cache->set('currency', $currency_data);
			}

			return $currency_data;
		}
	}

//----------------------------------------------------------------------------------
// FloatRates follows 148 currencies using 19 data sources.
//
// Example USD: http://www.floatrates.com/daily/usd.xml
//
// Example XML Response:
// <item>
//	<title>1 USD = 0.81253219 EUR</title>
//	<link>http://www.floatrates.com/usd/eur/</link>
//	<description>1 U.S. Dollar = 0.81253219 Euro</description>
//	<pubDate>Mon, 12 Mar 2018 12:00:01 GMT</pubDate>
//	<baseCurrency>USD</baseCurrency>
//	<baseName>U.S. Dollar</baseName>
//	<targetCurrency>EUR</targetCurrency>
//	<targetName>Euro</targetName>
//	<exchangeRate>0.81253219</exchangeRate>
// </item>
//----------------------------------------------------------------------------------

	public function updateCurrencies($default = '') {
		$default = $this->config->get('config_currency');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . trim($default) . "' AND date_modified < '" . date('Y-m-d H:i:s', strtotime('-1 day')) . "' AND status = '1'");

		if ($query->rows) {
			$currencies = array();

			$file_url = 'http://www.floatrates.com/daily/' . strtolower($default) . '.xml';

			$file_exists = $this->checkFileExists($file_url);

			$data = array(
				'sort'  => 'code',
				'order' => 'ASC'
			);

			$results = $this->getCurrencies($data);

			if ($results && $file_exists) {
				foreach ($results as $result) {
					if ($result['code'] != strtoupper($default)) {
						$currencies[] = $result['code'];
					}
				}

				if (!empty($currencies)) {
					$xml = simplexml_load_file($file_url);

					foreach ($xml->children() as $response) {
						if (in_array($response->targetCurrency, $currencies)) {
							$this->db->query("UPDATE " . DB_PREFIX . "currency SET `value` = '" . $response->exchangeRate . "', date_modified = NOW() WHERE code = '" . strtoupper($response->targetCurrency) . "'");
						}
					}
				}

				$this->cache->delete('currency');
			}

			$this->editValueByCode($default, '1.000000');
		} else {
			return;
		}
	}

	public function updateAlphaVantageCurrencies() {
		$default = $this->config->get('config_currency');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "currency WHERE code != '" . $default . "' AND date_modified < '" . date('Y-m-d H:i:s', strtotime('-1 day')) . "' AND status = '1'");

		if ($query->rows) {
			$api_key = $this->config->get('config_alpha_vantage');

			$api_key = (isset($api_key) && $api_key) ? strtoupper($api_key) : 'P6WGY9G9LB22GMBJ';

			foreach ($query->rows as $result) {
				$url = 'https://www.alphavantage.co/query?function=CURRENCY_EXCHANGE_RATE&from_currency=' . strtoupper($default) . '&to_currency=' . strtoupper($result['code']) . '&apikey=' . $api_key;

				$curl = curl_init();

				curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
				curl_setopt($curl, CURLOPT_TIMEOUT, 30);

				$response = curl_exec($curl);

				curl_close($curl);

				$response_info = json_decode($response, true);

				if (isset($response_info)) {
					$value = (float) $response_info["Realtime Currency Exchange Rate"]["5. Exchange Rate"];

					$this->db->query("UPDATE " . DB_PREFIX . "currency SET `value` = '" . $value . "', date_modified = NOW() WHERE code = '" . $this->db->escape($result['code']) . "'");
				}
			}

			$this->editValueByCode($default, '1.000000');

			$this->cache->delete('currency');
		} else {
			return;
		}
	}

	protected function checkFileExists($url) {
		$file_headers = @get_headers($url);

		if (!$file_headers || strpos($file_headers[0], '200') === false) {
			return false;
		} else {
			return true;
		}
	}

	public function getTotalCurrencies() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "currency");

		return $query->row['total'];
	}
}
