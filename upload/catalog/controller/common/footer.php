<?php
class ControllerCommonFooter extends Controller {

	protected function index() {
		$this->language->load('common/footer');

		$this->load->model('design/footer');

		$total_footers = $this->model_design_footer->getTotalFooters();

		if ($total_footers) {
			$this->data['footer_routes'] = array();

			$routes = $this->model_design_footer->getFooterRouteList(0);

			if ($routes) {
				foreach ($routes as $route) {
					$this->data['footer_routes'][] = array(
						'footer_id'	=> $route['footer_id'],
						'title'			=> $route['title'],
						'route'		=> html_entity_decode($route['route'], ENT_QUOTES, 'UTF-8')
					);

					$this->data['footer_blocks'] = array();

					$blocks = $this->model_design_footer->getFooterList(0);

					if ($blocks) {
						foreach ($blocks as $block) {
							$this->data['footer_blocks'][] = array(
								'footer_id'	=> $block['footer_id'],
								'name'		=> $block['name'],
								'position'		=> $block['position'],
								'status'		=> $block['status']
							);
						}
					}
				}
			}

			$this->data['footer_block_exist'] = true;

		} else {
			$this->data['text_information'] = $this->language->get('text_information');
			$this->data['text_service'] = $this->language->get('text_service');
			$this->data['text_extra'] = $this->language->get('text_extra');
			$this->data['text_contact'] = $this->language->get('text_contact');
			$this->data['text_search'] = $this->language->get('text_search');
			$this->data['text_return'] = $this->language->get('text_return');
			$this->data['text_sitemap'] = $this->language->get('text_sitemap');
			$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$this->data['text_special'] = $this->language->get('text_special');
			$this->data['text_voucher'] = $this->language->get('text_voucher');
			$this->data['text_affiliate'] = $this->language->get('text_affiliate');
			$this->data['text_account'] = $this->language->get('text_account');
			$this->data['text_order'] = $this->language->get('text_order');
			$this->data['text_wishlist'] = $this->language->get('text_wishlist');
			$this->data['text_newsletter'] = $this->language->get('text_newsletter');

			$this->load->model('catalog/information');

			$this->data['informations'] = array();

			foreach ($this->model_catalog_information->getInformations() as $result) {
				if ($result['bottom']) {
					$this->data['informations'][] = array(
						'title' 	=> $result['title'],
						'href'	=> $this->url->link('information/information', 'information_id=' . $result['information_id'])
					);
				}
			}

			$this->data['contact'] = $this->url->link('information/contact');
			$this->data['search'] = $this->url->link('product/search');
			$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
			$this->data['sitemap'] = $this->url->link('information/sitemap');
			$this->data['manufacturer'] = $this->url->link('product/manufacturer');
			$this->data['special'] = $this->url->link('product/special');
			$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
			$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
			$this->data['account'] = $this->url->link('account/account', '', 'SSL');
			$this->data['order'] = $this->url->link('account/order', '', 'SSL');
			$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
			$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

			// Returns
			if ($this->config->get('config_return_disable')) {
				$this->data['allow_return'] = false;
			} else {
				$this->data['allow_return'] = true;
			}

			// Affiliates
			if ($this->config->get('config_affiliate_disable')) {
				$this->data['allow_affiliate'] = false;
			} else {
				$this->data['allow_affiliate'] = true;
			}

			$this->data['footer_block_exist'] = false;
		}

		$this->data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

		$this->data['back_to_top'] = $this->config->get('config_back_to_top');

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}

		$this->render();
	}
}
?>