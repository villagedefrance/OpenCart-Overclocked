<?php
class ModelShippingCanadaPost extends Model {

	public function getQuote($address) {
		$this->language->load('shipping/canadapost');

		if ($this->config->get('canadapost_status')) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('canadapost_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$this->config->get('canadapost_geo_zone_id')) {
				$status = true;
			} elseif ($query->num_rows) {
				$status = true;
			} else {
				$status = false;
			}
		} else {
			$status = false;
		}

		$modified_weight = intval($this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), 2));

		$method_data = array();

		if ($status) {
			$quote_data = array();

			$return_error = false;

			$cp_server = $this->config->get('canadapost_server');
			$cp_port = $this->config->get('canadapost_port');

			if ($this->language->get('language_file') == 'fr') {
				$cp_language = 'fr';
			} else {
				$cp_language = 'en';
			}

			$cp_merchantID = $this->config->get('canadapost_merchant_id');
			$cp_fromPostalCode = $this->config->get('canadapost_origin');
			$cp_turnAroundTime = $this->config->get('canadapost_turnaround');
			$cp_itemsPrice = $this->cart->getSubTotal();
			$cp_readyToShip = $this->config->get('canadapost_packaging');
			$cp_destCity = $address['city'];
			$cp_destProvince = $address['zone'];
			$cp_destCountry = $address['country'];
			$cp_destPostalCode = str_replace(' ', '', $address['postcode']);

			// Prepare xml format
			$strXML = "<?xml version=\"1.0\" ?>";
			$strXML .= "<eparcel>\n";
			$strXML .= "  <language>" . $cp_language . "</language>\n";
			$strXML .= "  <ratesAndServicesRequest>\n";
			$strXML .= "    <merchantCPCID>" . $cp_merchantID . "</merchantCPCID>\n";
			$strXML .= "    <fromPostalCode>" . $cp_fromPostalCode . "</fromPostalCode>\n";
			$strXML .= "    <turnAroundTime>" . $cp_turnAroundTime . "</turnAroundTime>\n";
			$strXML .= "    <itemsPrice>" . $cp_itemsPrice . "</itemsPrice>\n";
			$strXML .= "    <lineItems>\n";

			foreach ($this->cart->getProducts() as $result) {
				$modified_weight = $result['weight'] / $result['quantity'];

				$strXML .= "      <item>\n";
				$strXML .= "        <quantity>" . $result['quantity'] . "</quantity>\n";
				$strXML .= "        <weight>" . $modified_weight . "</weight>\n";
				$strXML .= "        <length>" . $result['length'] . "</length>\n";
				$strXML .= "        <width>" . $result['width'] . "</width>\n";
				$strXML .= "        <height>" . $result['height'] . "</height>\n";
				$strXML .= "        <description>" . $result['name'] . ' [' . $result['model'] . ']' . "</description>\n";

				if ($cp_readyToShip == 1) {
					$strXML .= "        <readyToShip/>\n";
				}

				$strXML .= "      </item>\n";
			}

			$strXML .= "    </lineItems>\n";
			$strXML .= "    <city>" . html_entity_decode($cp_destCity) . "</city>\n";
			$strXML .= "    <provOrState>" . html_entity_decode($cp_destProvince) . "</provOrState>\n";
			$strXML .= "    <country>" . html_entity_decode($cp_destCountry) . "</country>\n";
			$strXML .= "    <postalCode>" . $cp_destPostalCode . "</postalCode>\n";
			$strXML .= "  </ratesAndServicesRequest>\n";
			$strXML .= "</eparcel>\n";

			// Make connection
			if ($resultXML = $this->sendToCanadaPost($cp_server, $cp_port, 'POST', '', $strXML)) {
				$j=0;

				if ($this->parseResults($resultXML)) {
					foreach ($this->parseResults($resultXML) as $canada_result) {
						$quote_data['canadapost_' . $j] = $canada_result;
						$j++;
					}
				} else {
					$return_error = $this->language->get('text_returnerror');
				}

			} else {
				$return_error = $this->language->get('text_returnerror').' 0x01';
			}
		}

		$method_data = array(
			'id'         => 'canadapost',
			'title'      => $this->language->get('text_title'),
			'quote'      => $quote_data,
			'sort_order' => $this->config->get('canadapost_sort_order'),
			'error'      => $return_error
		);

		return $method_data;
	}

    public function sendToCanadaPost($host, $port, $method, $path, $data, $useragent = 0) {
		if (empty($method)) {
			$method = 'GET';
		}

		$method = strtoupper($method);

		if ($method == 'GET') {
			$path .= '?' . $data;
		}

		$buf = "";

		// Try to connect to Canada Post server, for 2 second ...
		$fp = @fsockopen($host, $port, $errno, $errstr, 2);

		if ($fp) {
			fputs($fp, "$method $path HTTP/1.1\n");
			fputs($fp, "Host: $host\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
			fputs($fp, "Content-length: " . strlen($data) . "\n");

			if ($useragent) {
				fputs($fp, "User-Agent: PHP / OpenCart\n");
			}

			fputs($fp, "Connection: close\n\n");

			if ($method == 'POST') {
				fputs($fp, $data);
			}

			while (!feof($fp)) {
				$buf .= fgets($fp, 128);
			}

			fclose($fp);
		} else {
			$buf = '<?xml version="1.0" ?><eparcel><error><statusMessage>Cannot reach Canada Post Server. You may refresh this page (Press F5) to try again.</statusMessage></error></eparcel>';
		}

		return $buf;
	}

	public function parseResults($resultXML) {
		$statusMessage = substr(substr($resultXML, strpos($resultXML, "<statusMessage>") + strlen("<statusMessage>"), strpos($resultXML, "</statusMessage>") - strlen("<statusMessage>") - strpos($resultXML, "<statusMessage>")), 0, 2);

		$cp_title = $this->language->get('text_title');

		$cp_estdelevery = $this->language->get('text_estimated');

		if ($statusMessage == 'OK') {
			$index = 0;

			$aryProducts = false;

			while (strpos($resultXML, "</product>")) {
				$name = substr($resultXML, strpos($resultXML, "<name>") + strlen("<name>"), strpos($resultXML, "</name>") - strlen("<name>") - strpos($resultXML, "<name>"));
				$rate = substr($resultXML, strpos($resultXML, "<rate>") + strlen("<rate>"), strpos($resultXML, "</rate>") - strlen("<rate>") - strpos($resultXML, "<rate>"));

				$deliveryDate = substr($resultXML, strpos($resultXML, "<deliveryDate>") + strlen("<deliveryDate>"), strpos($resultXML, "</deliveryDate>") - strlen("<deliveryDate>") - strpos($resultXML, "<deliveryDate>"));

				$cp_handling = $this->config->get('canadapost_handling');

				$rate = $rate + $cp_handling;

				$aryProducts[$index] = array(
					'id'           => 'canadapost.canadapost_' . $index,
					'code'         => 'canadapost.canadapost_' . $index,
					'title'        => '<strong>' . $name . '</strong> | ' . $cp_title . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [' . $cp_estdelevery . ': ' . $deliveryDate . ']',
					'cost'         => $rate,
					'tax_class_id' => $this->config->get('canadapost_tax_class_id'),
					'text'         => '$' . number_format($rate, 2, '.', ',')
				);

				$index++;

				$resultXML = substr($resultXML, strpos($resultXML, "</product>") + strlen("</product>"));
			}

			return $aryProducts;

		} else {
			return false;
		}
	}
}
