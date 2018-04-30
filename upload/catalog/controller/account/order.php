<?php
class ControllerAccountOrder extends Controller {

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->customer->isSecure() || $this->customer->loginExpired()) {
			$this->customer->logout();

			$this->session->data['redirect'] = $this->url->link('account/order', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/order');

		$this->load->model('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_info = $this->model_account_order->getOrder($this->request->get['order_id']);

			if ($order_info) {
				$order_products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

				foreach ($order_products as $order_product) {
					$option_data = array();

					$order_options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $order_product['order_product_id']);

					foreach ($order_options as $order_option) {
						if ($order_option['type'] == 'select' || $order_option['type'] == 'radio' || $order_option['type'] == 'image') {
							$option_data[$order_option['product_option_id']] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'checkbox') {
							$option_data[$order_option['product_option_id']][] = $order_option['product_option_value_id'];
						} elseif ($order_option['type'] == 'text' || $order_option['type'] == 'textarea' || $order_option['type'] == 'date' || $order_option['type'] == 'datetime' || $order_option['type'] == 'time') {
							$option_data[$order_option['product_option_id']] = $order_option['value'];
						} elseif ($order_option['type'] == 'file') {
							$option_data[$order_option['product_option_id']] = $this->encryption->encrypt($order_option['value']);
						}
					}

					$this->session->data['success'] = sprintf($this->language->get('text_success'), $this->request->get['order_id']);

					$this->cart->add($order_product['product_id'], $order_product['quantity'], $option_data);
				}

				$this->redirect($this->url->link('checkout/cart', '', 'SSL'));
			}
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/order', $url, 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['button_pick'] = $this->language->get('button_pick');
		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_invoice'] = $this->language->get('button_invoice');
		$this->data['button_reorder'] = $this->language->get('button_reorder');
		$this->data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['orders'] = array();

		$order_total = $this->model_account_order->getTotalOrders();

		$results = $this->model_account_order->getOrders(($page - 1) * 10, 10);

		foreach ($results as $result) {
			$product_total = $this->model_account_order->getTotalOrderProductsByOrderId($result['order_id']);
			$voucher_total = $this->model_account_order->getTotalOrderVouchersByOrderId($result['order_id']);

			$this->data['orders'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['firstname'] . ' ' . $result['lastname'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'products'   => ($product_total + $voucher_total),
				'total'      => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'picklist'   => $this->url->link('account/order/picklist', 'order_id=' . $result['order_id'], 'SSL'),
				'href'       => $this->url->link('account/order/info', 'order_id=' . $result['order_id'], 'SSL'),
				'download'   => $this->url->link('account/order/download', 'order_id=' . $result['order_id'], 'SSL'),
				'reorder'    => $this->url->link('account/order', 'order_id=' . $result['order_id'], 'SSL')
			);
		}

		$this->data['picklist_status'] = $this->config->get('config_picklist_status');

		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/order', 'page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/order_list.tpl';
		} else {
			$this->template = 'default/template/account/order_list.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

	public function picklist() {
		$this->language->load('account/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->customer->isSecure()) {
			$this->customer->logout();

			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			$this->document->setTitle($this->language->get('heading_title_pick_list'));

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', '', 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$url = '';

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order_pick_list'),
				'href'      => $this->url->link('account/order/picklist', 'order_id=' . $this->request->get['order_id'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('heading_title_pick_list');

			$this->data['text_comment'] = $this->language->get('text_comment');

			$this->data['column_name'] = $this->language->get('column_name');
			$this->data['column_model'] = $this->language->get('column_model');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_status'] = $this->language->get('column_status');
			$this->data['column_order_picked'] = $this->language->get('column_order_picked');
			$this->data['column_order_none'] = $this->language->get('column_order_none');

			$this->data['button_return'] = $this->language->get('button_return');
			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				if ($product['backordered'] > 0) {
					$this->data['backorder'] = nl2br($product['backordered']);
				} else {
					$this->data['backorder'] = '';
				}

				$this->data['products'][] = array(
					'name'        => $product['name'],
					'model'       => $product['model'],
					'option'      => $option_data,
					'quantity'    => $product['quantity'],
					'price'       => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'total'       => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'return'      => $this->url->link('account/return/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL'),
					'picked'      => $product['picked'],
					'backordered' => $product['backordered']
				);
			}

			$this->data['picklist_status'] = $this->config->get('config_picklist_status');

			$this->data['continue'] = $this->url->link('account/order', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_picklist.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/order_picklist.tpl';
			} else {
				$this->template = 'default/template/account/order_picklist.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_header',
				'common/content_top',
				'common/content_bottom',
				'common/content_footer',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());

		} else {
			$this->document->setTitle($this->language->get('text_order'));

			$this->data['heading_title'] = $this->language->get('text_order');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', '', 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['continue'] = $this->url->link('account/order', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_header',
				'common/content_top',
				'common/content_bottom',
				'common/content_footer',
				'common/footer',
				'common/header'
			);

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->render());
		}
	}

	public function info() {
		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		if (!$this->customer->isSecure()) {
			$this->customer->logout();

			$this->session->data['redirect'] = $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/order');

		$this->load->model('account/order');

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			$this->document->setTitle($this->language->get('text_order'));

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', '', 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $this->request->get['order_id'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('text_order');

			$this->data['text_order_detail'] = $this->language->get('text_order_detail');
			$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
			$this->data['text_order_id'] = $this->language->get('text_order_id');
			$this->data['text_date_added'] = $this->language->get('text_date_added');
			$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
			$this->data['text_payment_method'] = $this->language->get('text_payment_method');
			$this->data['text_payment_address'] = $this->language->get('text_payment_address');
			$this->data['text_history'] = $this->language->get('text_history');
			$this->data['text_comment'] = $this->language->get('text_comment');

			$this->data['column_name'] = $this->language->get('column_name');
			$this->data['column_model'] = $this->language->get('column_model');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_price'] = $this->language->get('column_price');
			$this->data['column_tax_value'] = $this->language->get('column_tax_value');
			$this->data['column_tax_percent'] = $this->language->get('column_tax_percent');
			$this->data['column_total'] = $this->language->get('column_total');
			$this->data['column_action'] = $this->language->get('column_action');
			$this->data['column_date_added'] = $this->language->get('column_date_added');
			$this->data['column_status'] = $this->language->get('column_status');
			$this->data['column_comment'] = $this->language->get('column_comment');

			$this->data['button_return'] = $this->language->get('button_return');
			$this->data['button_continue'] = $this->language->get('button_continue');

			// Get tax breakdown
			if ($this->config->get('config_tax_breakdown')) {
				$this->data['tax_breakdown'] = true;
				$this->data['tax_colspan'] = 4;
			} else {
				$this->data['tax_breakdown'] = false;
				$this->data['tax_colspan'] = 2;
			}

			if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}

			$this->data['order_id'] = $this->request->get['order_id'];

			$this->data['date_added'] = date($this->language->get('date_format_time'), strtotime($order_info['date_added']));

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['payment_method'] = $order_info['payment_method'];

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];

			$this->data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$this->data['products'][] = array(
					'name'        => $product['name'],
					'model'       => $product['model'],
					'option'      => $option_data,
					'quantity'    => $product['quantity'],
					'price'       => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'tax_value'   => $this->currency->format(($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'tax_percent' => number_format(((($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0) * 100) / (($product['price'] > 0) ? ($product['price'] * $product['quantity']) : $product['quantity'])), 2, '.', ''),
					'total'       => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'return'      => $this->url->link('account/return/insert', 'order_id=' . $order_info['order_id'] . '&product_id=' . $product['product_id'], 'SSL')
				);
			}

			$this->data['picklist_status'] = $this->config->get('config_picklist_status');

			// Voucher
			$this->data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			$this->data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);

			$this->data['comment'] = nl2br($order_info['comment']);

			$this->data['histories'] = array();

			$results = $this->model_account_order->getOrderHistories($this->request->get['order_id']);

			foreach ($results as $result) {
				$this->data['histories'][] = array(
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
					'status'     => $result['status'],
					'comment'    => nl2br($result['comment'])
				);
			}

			$this->data['continue'] = $this->url->link('account/order', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_info.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/order_info.tpl';
			} else {
				$this->template = 'default/template/account/order_info.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_header',
				'common/content_top',
				'common/content_bottom',
				'common/content_footer',
				'common/footer',
				'common/header'
			);

			$this->response->setOutput($this->render());

		} else {
			$this->document->setTitle($this->language->get('text_order'));

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', '', 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/order', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_order'),
				'href'      => $this->url->link('account/order/info', 'order_id=' . $order_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);

			$this->data['heading_title'] = $this->language->get('text_order');

			$this->data['text_error'] = $this->language->get('text_error');

			$this->data['button_continue'] = $this->language->get('button_continue');

			$this->data['continue'] = $this->url->link('account/order', '', 'SSL');

			// Theme
			$this->data['template'] = $this->config->get('config_template');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}

			$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_header',
				'common/content_top',
				'common/content_bottom',
				'common/content_footer',
				'common/footer',
				'common/header'
			);

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
			$this->response->setOutput($this->render());
		}
	}

	public function download() {
		$this->language->load('account/order');

		$this->data['title'] = $this->language->get('heading_title');

		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$this->data['base'] = HTTPS_SERVER;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_order_detail'] = $this->language->get('text_order_detail');
		$this->data['text_order_invoice'] = $this->language->get('text_order_invoice');
		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_damages'] = $this->language->get('text_damages');
		$this->data['text_bank_name'] = $this->language->get('text_bank_name');
		$this->data['text_bank_account'] = $this->language->get('text_bank_account');
		$this->data['text_copyrights'] = $this->language->get('text_copyrights');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_tax_value'] = $this->language->get('column_tax_value');
		$this->data['column_tax_percent'] = $this->language->get('column_tax_percent');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['token'] = $this->session->data['token'];

		// Get tax breakdown
		if ($this->config->get('config_tax_breakdown')) {
			$this->data['tax_breakdown'] = true;
			$this->data['tax_colspan'] = 6;
		} else {
			$this->data['tax_breakdown'] = false;
			$this->data['tax_colspan'] = 4;
		}

		$this->load->model('account/order');
		$this->load->model('setting/setting');

		$pdf = (isset($this->request->get['pdf'])) ? true : false;

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->request->server['HTTPS'] ? HTTPS_IMAGE . $this->config->get('config_logo') : HTTP_IMAGE . $this->config->get('config_logo');
		} else {
			$this->data['logo'] = '';
		}

		$this->data['bank_name'] = $this->config->get('config_bank_name') ? $this->config->get('config_bank_name') : '';
		$this->data['bank_sort_code'] = $this->config->get('config_bank_sort_code') ? $this->config->get('config_bank_sort_code') : '';
		$this->data['bank_account'] = $this->config->get('config_bank_account') ? $this->config->get('config_bank_account') : '';

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_account_order->getOrder($order_id);

		if ($order_info) {
			$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);

			if ($store_info) {
				$this->data['store_address'] = nl2br($store_info['config_address']);
				$this->data['store_email'] = $store_info['config_email'];
				$this->data['store_telephone'] = $store_info['config_telephone'];
				$this->data['store_fax'] = $store_info['config_fax'];
			} else {
				$this->data['store_address'] = nl2br($this->config->get('config_address'));
				$this->data['store_email'] = $this->config->get('config_email');
				$this->data['store_telephone'] = $this->config->get('config_telephone');
				$this->data['store_fax'] = $this->config->get('config_fax');
			}

			$this->data['store_name'] = $order_info['store_name'];

			if ($order_info['store_id'] == 0) {
				$this->data['store_url'] = $this->request->server['HTTPS'] ? rtrim(HTTPS_SERVER, '/') : rtrim(HTTP_SERVER, '/');
			} else {
				$this->data['store_url'] = rtrim($order_info['store_url'], '/');
			}

			$this->data['store_company_id'] = $this->config->get('config_company_id') ? $this->config->get('config_company_id') : '';
			$this->data['store_company_tax_id'] = $this->config->get('config_company_tax_id') ? $this->config->get('config_company_tax_id') : '';

			if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}

			$this->data['order_id'] = $order_id;

			if ($order_info['order_status_id'] == $this->config->get('config_complete_status_id')) {
				$this->data['heading_order'] = $this->language->get('text_order_invoice');
			} else {
				$this->data['heading_order'] = $this->language->get('text_order_detail');
			}

			$this->data['date_added'] = date($this->language->get('date_format_time'), strtotime($order_info['date_added']));

			if ($order_info['payment_address_format']) {
				$format = $order_info['payment_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['payment_firstname'],
				'lastname'  => $order_info['payment_lastname'],
				'company'   => $order_info['payment_company'],
				'address_1' => $order_info['payment_address_1'],
				'address_2' => $order_info['payment_address_2'],
				'city'      => $order_info['payment_city'],
				'postcode'  => $order_info['payment_postcode'],
				'zone'      => $order_info['payment_zone'],
				'zone_code' => $order_info['payment_zone_code'],
				'country'   => $order_info['payment_country']
			);

			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['email'] = $order_info['email'];
			$this->data['telephone'] = $order_info['telephone'];

			$this->data['payment_method'] = $order_info['payment_method'];

			if ($order_info['shipping_address_format']) {
				$format = $order_info['shipping_address_format'];
			} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}

			$find = array(
				'{firstname}',
				'{lastname}',
				'{company}',
				'{address_1}',
				'{address_2}',
				'{city}',
				'{postcode}',
				'{zone}',
				'{zone_code}',
				'{country}'
			);

			$replace = array(
				'firstname' => $order_info['shipping_firstname'],
				'lastname'  => $order_info['shipping_lastname'],
				'company'   => $order_info['shipping_company'],
				'address_1' => $order_info['shipping_address_1'],
				'address_2' => $order_info['shipping_address_2'],
				'city'      => $order_info['shipping_city'],
				'postcode'  => $order_info['shipping_postcode'],
				'zone'      => $order_info['shipping_zone'],
				'zone_code' => $order_info['shipping_zone_code'],
				'country'   => $order_info['shipping_country']
			);

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $order_info['shipping_method'];

			$this->data['payment_company'] = ($order_info['payment_company']) ? $order_info['payment_company'] : false;
			$this->data['payment_company_id'] = ($order_info['payment_company_id']) ? $order_info['payment_company_id'] : false;

			$this->data['products'] = array();

			$products = $this->model_account_order->getOrderProducts($this->request->get['order_id']);

			foreach ($products as $product) {
				$option_data = array();

				$options = $this->model_account_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);

				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				$this->data['products'][] = array(
					'name'        => $product['name'],
					'model'       => $product['model'],
					'option'      => $option_data,
					'quantity'    => $product['quantity'],
					'price'       => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
					'tax_value'   => $this->currency->format(($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
					'tax_percent' => number_format(((($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0) * 100) / (($product['price'] > 0) ? ($product['price'] * $product['quantity']) : $product['quantity'])), 2, '.', ''),
					'total'       => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			// Voucher
			$this->data['vouchers'] = array();

			$vouchers = $this->model_account_order->getOrderVouchers($this->request->get['order_id']);

			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])
				);
			}

			$this->data['totals'] = $this->model_account_order->getOrderTotals($this->request->get['order_id']);
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/order_download.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/order_download.tpl';
		} else {
			$this->template = 'default/template/account/order_download.tpl';
		}

		if ($pdf) {
			$document_type = $this->language->get('text_order');

			$document = str_replace(' ', '-', $document_type);

			$this->response->setOutput(pdf($this->render(), $document, $order_id));
		} else {
			$this->response->setOutput($this->render());
		}
	}
}
