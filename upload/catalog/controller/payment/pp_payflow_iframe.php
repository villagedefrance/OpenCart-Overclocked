<?php
class ControllerPaymentPPPayflowIframe extends Controller {

	protected function index() {
		$this->language->load('payment/pp_payflow_iframe');

		$this->load->model('checkout/order');
		$this->load->model('payment/pp_payflow_iframe');
		$this->load->model('localisation/country');
		$this->load->model('localisation/zone');

		if (isset($this->session->data['order_id']) && ($this->session->data['order_id'] != '')) {
			$order_id = $this->session->data['order_id'];
			$order_info = $this->model_checkout_order->getOrder($order_id);

			if ($order_info) {
				if (in_array(strtoupper($order_info['currency_code']), array('AUD','CAD','EUR','GBP','JPY','USD'))) {
					if ($this->config->get('pp_payflow_iframe_test')) {
						$mode = 'TEST';
						$payflow_url = 'https://pilot-payflowlink.paypal.com';
					} else {
						$mode = 'LIVE';
						$payflow_url = 'https://payflowlink.paypal.com';
					}

					if ($this->config->get('pp_payflow_iframe_transaction_method') == 'sale') {
						$transaction_type = 'S';
					} else {
						$transaction_type = 'A';
					}

					if ($this->config->get('pp_payflow_iframe_checkout_method') == 'iframe') {
						$template = 'MINLAYOUT';
					} else {
						$template = 'TEMPLATEA';
					}

					// Create a secure token ID
					$secure_token_id = md5($order_id . mt_rand() . microtime());

					$bill_to_street = explode('@_@', wordwrap(trim($order_info['payment_address_1'] . ' ' . $order_info['payment_address_2']), 30, '@_@'));
					$ship_to_street = explode('@_@', wordwrap(trim($order_info['shipping_address_1'] . ' ' . $order_info['shipping_address_2']), 30, '@_@'));

					$request = array(
						'TENDER'                => 'C',
						'TRXTYPE'               => $transaction_type,
						'AMT'                   => number_format($order_info['total'], 2, '.', ''),
						'CURRENCY'              => strtoupper($order_info['currency_code']),
						'CREATESECURETOKEN'     => 'Y',
						'SECURETOKENID'         => $secure_token_id,
						'TEMPLATE'              => $template,  // Dynamically configure the hosted checkout page.
						// Passing the URLs here gives bad results: Payflow adds $payflow_url as prefix and encodes them.

						// Color parameters (unused but seems working)
//						'PAGECOLLAPSEBGCOLOR'   => '993300',
//						'PAGECOLLAPSETEXTCOLOR' => '990000',
//						'PAGEBUTTONBGCOLOR'     => 'AA66FF',
//						'PAGEBUTTONTEXTCOLOR'   => '33FFFF',
//						'LABELTEXTCOLOR'        => '330000',

						// Address Verification Service Parameters
						'BILLTOFIRSTNAME'   => $order_info['payment_firstname'],
						'BILLTOLASTNAME'    => $order_info['payment_lastname'],
						'BILLTOSTREET'      => isset($bill_to_street[0]) ? trim($bill_to_street[0]) : '',
						'BILLTOSTREET2'     => isset($bill_to_street[1]) ? trim($bill_to_street[1]) : '',
						'BILLTOCITY'        => $order_info['payment_city'],
						'BILLTOSTATE'       => $order_info['payment_zone_code'],
						'BILLTOZIP'         => $order_info['payment_postcode'],
						'BILLTOCOUNTRY'     => $order_info['payment_iso_code_2'],

						'SHIPTOFIRSTNAME'   => $order_info['shipping_firstname'],
						'SHIPTOLASTNAME'    => $order_info['shipping_lastname'],
						'SHIPTOSTREET'      => isset($ship_to_street[0]) ? trim($ship_to_street[0]) : '',
						'SHIPTOSTREET2'     => isset($ship_to_street[1]) ? trim($ship_to_street[1]) : '',
						'SHIPTOCITY'        => $order_info['shipping_city'],
						'SHIPTOSTATE'       => $order_info['shipping_zone_code'],
						'SHIPTOZIP'         => $order_info['shipping_postcode'],
						'SHIPTOCOUNTRY'     => $order_info['shipping_iso_code_2'],

						'CUSTIP'            => $order_info['ip'],
						// Session information is lost when redirected so we pass 'order_id' as user parameter.
						'USER1'             => $order_info['order_id']
					);

					$response = $this->model_payment_pp_payflow_iframe->call($request);

					if ($response === false) {
						$this->data['error'] = $this->language->get('error_connection');

					} elseif (is_array($response) && isset($response['RESULT'])) {
						if (intval($response['RESULT']) == 0) {
							// Get the secure token
							$secure_token = (isset($response['SECURETOKEN']) ? $response['SECURETOKEN'] : '');

							$iframe_params = array(
								'MODE'          => $mode, // Deprecated
								'SECURETOKENID' => $request['SECURETOKENID'],
								'SECURETOKEN'   => $secure_token
							);

							// Use parameters to embed the PayPal hosted page in an iframe tag.
							$this->data['iframe_url'] = $payflow_url . '?' . http_build_query($iframe_params, '', '&');
							$this->data['checkout_method'] = $this->config->get('pp_payflow_iframe_checkout_method');
							$this->data['button_confirm'] = $this->language->get('button_confirm');

						} elseif (intval($response['RESULT']) < 0) {
							$this->data['error'] = sprintf($this->language->get('error_communication'), $response['RESULT'], $response['RESPMSG']);
						} else {
							$this->data['error'] = sprintf($this->language->get('error_declined_transaction'), $response['RESULT'], $response['RESPMSG']);
						}

					} else {
						$this->data['error'] = $this->language->get('error_response');
					}

				} else {
					$this->data['error'] = $this->language->get('error_currency_not_supported');
				}

			} else {
				$this->data['error'] = $this->language->get('error_missing_order');
			}

		} else {
			$this->data['error'] = $this->language->get('error_missing_data');
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_payflow_iframe.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_payflow_iframe.tpl';
		} else {
			$this->template = 'default/template/payment/pp_payflow_iframe.tpl';
		}

		$this->render();
	}

	public function pf_cancel() {
		$this->data['url'] = $this->url->link('checkout/checkout', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_payflow_iframe_cancel.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_payflow_iframe_cancel.tpl';
		} else {
			$this->template = 'default/template/payment/pp_payflow_iframe_cancel.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function pf_error() {
		$this->data['url'] = $this->url->link('checkout/checkout', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_payflow_iframe_error.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_payflow_iframe_error.tpl';
		} else {
			$this->template = 'default/template/payment/pp_payflow_iframe_error.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function pf_return() {
		$this->data['url'] = $this->url->link('checkout/success', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_payflow_iframe_return.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_payflow_iframe_return.tpl';
		} else {
			$this->template = 'default/template/payment/pp_payflow_iframe_return.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function pf_silent_post() {
		$this->load->model('payment/pp_payflow_iframe');
		$this->load->model('checkout/order');

		$this->model_payment_pp_payflow_iframe->log($this->request->post, 'SILENT POST');

		$order_id = isset($this->request->post['USER1']) ? $this->request->post['USER1'] : 0;

		$order_info = $this->model_checkout_order->getOrder($order_id);

		if ($order_info) {
			// Inquire status of the transaction from Paypal
			$request = array(
				'TENDER'    => 'C',
				'TRXTYPE'   => 'I',
				'ORIGID'    => $this->request->post['PNREF'],
//  			'VERBOSITY' => 'HIGH'
			);

			$response = $this->model_payment_pp_payflow_iframe->call($request);

			if ($response === false) {
				$this->data['error'] = $this->language->get('error_connection');

			} elseif (is_array($response) && isset($response['RESULT']) && $order_info['order_status_id'] == 0) {

				if (intval($response['RESULT']) == 0) {
					$paypal_order = array(
						'order_id'        => $order_info['order_id'],
						'secure_token_id' => $this->request->post['SECURETOKENID'],
						'complete'        => ($this->request->post['TYPE'] == 'S') ? 1 : 0,
						'currency'        => strtoupper($order_info['currency_code'])
					);

					$this->model_payment_pp_payflow_iframe->addPaypalOrder($paypal_order);

					$paypal_transaction = array(
						'order_id'                     => $order_info['order_id'],
						'transaction_reference'        => $this->request->post['PNREF'],
						'transaction_type'             => $this->request->post['TYPE'],
						'parent_transaction_reference' => '',
						'amount'                       => $this->request->post['AMT']
					);

					$this->model_payment_pp_payflow_iframe->addPaypalTransaction($paypal_transaction);

					$this->model_checkout_order->confirm($order_info['order_id'], $this->config->get('pp_payflow_iframe_order_status_id'));

				} elseif ($response['RESULT'] < 0) {
					$this->data['error'] = sprintf($this->language->get('error_communication'), $response['RESULT'], $response['RESPMSG']);
				} else {
					$this->data['error'] = sprintf($this->language->get('error_declined_transaction'), $response['RESULT'], $response['RESPMSG']);
				}
			}

		} else {
			$this->data['error'] = $this->language->get('error_missing_order');
		}

		$this->response->setOutput('Ok');
	}
}
