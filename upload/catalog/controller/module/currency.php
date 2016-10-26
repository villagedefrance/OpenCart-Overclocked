<?php
class ControllerModuleCurrency extends Controller {

	protected function index() {
		if (isset($this->request->post['currency_code'])) {
			$this->currency->set($this->request->post['currency_code']);

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);

			// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) === 0 || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) === 0)) {
				$this->redirect($this->request->post['redirect']);
			} else {
				$this->redirect($this->url->link('common/home', '', 'SSL'));
			}
		}

		$this->language->load('module/currency');

		$this->data['text_currency'] = $this->language->get('text_currency');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$connection = 'SSL';
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$connection = 'SSL';
		} else {
			$connection = 'NONSSL';
		}

		$this->data['action'] = $this->url->link('module/currency', '', $connection);

		$this->data['currency_code'] = $this->currency->getCode();

		$this->load->model('localisation/currency');

		$this->data['currencies'] = array();

		$results = $this->model_localisation_currency->getCurrencies();

		foreach ($results as $result) {
			if ($result['status']) {
				$this->data['currencies'][] = array(
					'title'        => $result['title'],
					'code'         => $result['code'],
					'symbol_left'  => $result['symbol_left'],
					'symbol_right' => $result['symbol_right']
				);
			}
		}

		if (!isset($this->request->get['route'])) {
			$this->data['redirect'] = $this->url->link('common/home');
		} else {
			$data = $this->request->get;

			unset($data['_route_']);

			$route = $data['route'];

			unset($data['route']);

			$url = '';

			if ($data) {
				$url = '&' . urldecode(http_build_query($data, '', '&'));
			}

			$this->data['redirect'] = $this->url->link($route, $url, $connection);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/currency.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/currency.tpl';
		} else {
			$this->template = 'default/template/module/currency.tpl';
		}

		$this->render();
	}
}
