<?php
class ControllerPaymentPPProIframe extends Controller {

	protected function index() {
		$this->load->model('checkout/order');
		$this->load->model('payment/pp_pro_iframe');

		$this->language->load('payment/pp_pro_iframe');

		if ($this->config->get('pp_pro_iframe_checkout_method') == 'redirect') {
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

			if ($order_info) {
				$hosted_button_id = $this->constructButtonData($order_info);

				if ($hosted_button_id) {
					$this->data['code'] = $hosted_button_id;

					if ($this->config->get('pp_pro_iframe_test')) {
						$this->data['url'] = 'https://securepayments.sandbox.paypal.com/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess';
					} else {
						$this->data['url'] = 'https://securepayments.paypal.com/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess';
					}

				} else {
					$this->data['error'] = $this->language->get('error_connection');
				}

			} else {
				$this->data['error'] = $this->language->get('error_missing_order');
			}
		}

		$this->data['checkout_method'] = $this->config->get('pp_pro_iframe_checkout_method');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_pro_iframe.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_pro_iframe.tpl';
		} else {
			$this->template = 'default/template/payment/pp_pro_iframe.tpl';
		}

		$this->render();
	}

	public function create() {
		$this->language->load('payment/pp_pro_iframe');

		$this->load->model('checkout/order');
		$this->load->model('payment/pp_pro_iframe');

		$this->data['text_secure_connection'] = $this->language->get('text_secure_connection');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($order_info) {
			$hosted_button_id = $this->constructButtonData($order_info);

			if ($hosted_button_id) {
				$this->data['code'] = $hosted_button_id;

				if ($this->config->get('pp_pro_iframe_test')) {
					$this->data['url'] = 'https://securepayments.sandbox.paypal.com/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess';
				} else {
					$this->data['url'] = 'https://securepayments.paypal.com/webapps/HostedSoleSolutionApp/webflow/sparta/hostedSoleSolutionProcess';
				}

			} else {
				$this->data['error'] = $this->language->get('error_connection');
			}

		} else {
			$this->data['error'] = $this->language->get('error_missing_order');
		}

		if (file_exists(DIR_APPLICATION . 'view/theme/' . $this->config->get('config_template') . '/stylesheet/stylesheet.css')) {
			$this->data['stylesheet'] = 'catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/stylesheet.css';
		} else {
			$this->data['stylesheet'] = 'catalog/view/theme/default/stylesheet/stylesheet.css';
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_pro_iframe_body.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/pp_pro_iframe_body.tpl';
		} else {
			$this->template = 'default/template/payment/pp_pro_iframe_body.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function notify() {
		$this->load->model('payment/pp_pro_iframe');

		if (isset($this->request->post['custom'])) {
			$order_id = $this->encryption->decrypt($this->request->post['custom']);
		} else {
			$order_id = 0;
		}

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($order_id);

		if ($order_info) {
			if ($this->config->get('pp_pro_iframe_test')) {
				$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			} else {
				$url = 'https://www.paypal.com/cgi-bin/webscr';
			}

			$request = 'cmd=_notify-validate';

			if (!empty($this->request->post)) {
				$request .= '&' . http_build_query($this->request->post, '', '&');
			}

			$options = array(
				CURLOPT_POST            => true,
				CURLOPT_HEADER          => false,
				CURLOPT_URL             => $url,
				CURLOPT_RETURNTRANSFER  => true,
				CURLOPT_TIMEOUT         => 30,
				CURLOPT_SSL_VERIFYPEER  => false,
				CURLOPT_POSTFIELDS      => $request
			);

			$ch = curl_init();

			curl_setopt_array($ch, $options);

			$response = curl_exec($ch);

			if (curl_errno($ch) != CURLE_OK) {
				$log_data = array(
					'curl_errno' => curl_errno($ch),
					'curl_error' => curl_error($ch)
				);

				$this->model_payment_pp_pro_iframe->log($log_data, 'CURL failed');

			} else {
				$log_data = array(
					'IPN REQUEST'  => $request,
					'IPN RESPONSE' => $response
				);

				$this->model_payment_pp_pro_iframe->log($log_data, 'Notify');

				if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {
					$order_status_id = $this->config->get('pp_pro_iframe_canceled_reversal_status_id');

					switch ($this->request->post['payment_status']) {
						case 'Canceled_Reversal':
							$order_status_id = $this->config->get('pp_pro_iframe_canceled_reversal_status_id');
							break;
						case 'Completed':
							$order_status_id = $this->config->get('pp_pro_iframe_completed_status_id');
							break;
						case 'Denied':
							$order_status_id = $this->config->get('pp_pro_iframe_denied_status_id');
							break;
						case 'Expired':
							$order_status_id = $this->config->get('pp_pro_iframe_expired_status_id');
							break;
						case 'Failed':
							$order_status_id = $this->config->get('pp_pro_iframe_failed_status_id');
							break;
						case 'Pending':
							$order_status_id = $this->config->get('pp_pro_iframe_pending_status_id');
							break;
						case 'Processed':
							$order_status_id = $this->config->get('pp_pro_iframe_processed_status_id');
							break;
						case 'Refunded':
							$order_status_id = $this->config->get('pp_pro_iframe_refunded_status_id');
							break;
						case 'Reversed':
							$order_status_id = $this->config->get('pp_pro_iframe_reversed_status_id');
							break;
						case 'Voided':
							$order_status_id = $this->config->get('pp_pro_iframe_voided_status_id');
							break;
					}

					if (!empty($order_info['order_status_id'])) {
						$paypal_order_data = array(
							'order_id'         => $order_id,
							'capture_status'   => ($this->config->get('pp_pro_iframe_transaction_method') == 'sale' ? 'Complete' : 'NotComplete'),
							'currency_code'    => $this->request->post['mc_currency'],
							'authorization_id' => $this->request->post['txn_id'],
							'total'            => $this->request->post['mc_gross']
						);

						$paypal_iframe_order_id = $this->model_payment_pp_pro_iframe->addOrder($paypal_order_data);

						$paypal_transaction_data = array(
							'paypal_iframe_order_id' => $paypal_iframe_order_id,
							'transaction_id'         => $this->request->post['txn_id'],
							'parent_transaction_id'  => '',
							'note'                   => '',
							'msgsubid'               => '',
							'receipt_id'             => $this->request->post['receipt_id'],
							'payment_type'           => $this->request->post['payment_type'],
							'payment_status'         => $this->request->post['payment_status'],
							'pending_reason'         => (isset($this->request->post['pending_reason']) ? $this->request->post['pending_reason'] : ''),
							'transaction_entity'     => ($this->config->get('pp_pro_iframe_transaction_method') == 'sale' ? 'payment' : 'auth'),
							'amount'                 => $this->request->post['mc_gross'],
							'debug_data'             => json_encode($this->request->post)
						);

						$this->model_payment_pp_pro_iframe->addTransaction($paypal_transaction_data);

						$this->model_checkout_order->confirm($order_id, $order_status_id);

					} else {
						$this->model_checkout_order->update($order_id, $order_status_id);
					}

				} else {
					$this->model_checkout_order->confirm($order_id, $this->config->get('config_order_status_id'));
				}
			}

			curl_close($ch);
		}
	}

	private function constructButtonData($order_info) {
		$this->load->model('payment/pp_pro_iframe');

		$s_data = array();

		$s_data['METHOD'] = 'BMCreateButton';
		$s_data['VERSION'] = '65.2';
		$s_data['BUTTONCODE'] = 'TOKEN';

		$s_data['BUTTONLANGUAGE'] = 'en';
		$s_data['BUTTONSOURCE'] = 'OpenCart_Cart_WPP';

		$s_data['USER'] = $this->config->get('pp_pro_iframe_user');
		$s_data['SIGNATURE'] = $this->config->get('pp_pro_iframe_sig');
		$s_data['PWD'] = $this->config->get('pp_pro_iframe_password');

		$s_data['BUTTONTYPE'] = 'PAYMENT';

		$s_data['L_BUTTONVAR0'] = 'subtotal=' . $this->currency->format($order_info['total'], $order_info['currency_code'], false, false);
		$s_data['L_BUTTONVAR1'] = 'tax=0.00';
		$s_data['L_BUTTONVAR2'] = 'shipping=0.00';
		$s_data['L_BUTTONVAR3'] = 'handling=0.00';

		if ($this->cart->hasShipping()) {
			$s_data['L_BUTTONVAR4'] = 'first_name=' . urlencode($order_info['shipping_firstname']);
			$s_data['L_BUTTONVAR5'] = 'last_name=' . urlencode($order_info['shipping_lastname']);
			$s_data['L_BUTTONVAR6'] = 'address1=' . urlencode($order_info['shipping_address_1']);
			$s_data['L_BUTTONVAR7'] = 'address2=' . urlencode($order_info['shipping_address_2']);
			$s_data['L_BUTTONVAR8'] = 'city=' . urlencode($order_info['shipping_city']);
			$s_data['L_BUTTONVAR9'] = 'state=' . urlencode($order_info['shipping_zone']);
			$s_data['L_BUTTONVAR10'] = 'zip=' . urlencode($order_info['shipping_postcode']);
			$s_data['L_BUTTONVAR11'] = 'country=' . urlencode($order_info['shipping_iso_code_2']);
		} else {
			$s_data['L_BUTTONVAR4'] = 'first_name=' . urlencode($order_info['payment_firstname']);
			$s_data['L_BUTTONVAR5'] = 'last_name=' . urlencode($order_info['payment_lastname']);
			$s_data['L_BUTTONVAR6'] = 'address1=' . urlencode($order_info['payment_address_1']);
			$s_data['L_BUTTONVAR7'] = 'address2=' . urlencode($order_info['payment_address_2']);
			$s_data['L_BUTTONVAR8'] = 'city=' . urlencode($order_info['payment_city']);
			$s_data['L_BUTTONVAR9'] = 'state=' . urlencode($order_info['payment_zone']);
			$s_data['L_BUTTONVAR10'] = 'zip=' . urlencode($order_info['payment_postcode']);
			$s_data['L_BUTTONVAR11'] = 'country=' . urlencode($order_info['payment_iso_code_2']);
		}

		$s_data['L_BUTTONVAR12'] = 'billing_first_name=' . urlencode($order_info['payment_firstname']);
		$s_data['L_BUTTONVAR13'] = 'billing_last_name=' . urlencode($order_info['payment_lastname']);
		$s_data['L_BUTTONVAR14'] = 'billing_address1=' . urlencode($order_info['payment_address_1']);
		$s_data['L_BUTTONVAR15'] = 'billing_address2=' . urlencode($order_info['payment_address_2']);
		$s_data['L_BUTTONVAR16'] = 'billing_city=' . urlencode($order_info['payment_city']);
		$s_data['L_BUTTONVAR17'] = 'billing_state=' . urlencode($order_info['payment_zone']);
		$s_data['L_BUTTONVAR18'] = 'billing_zip=' . urlencode($order_info['payment_postcode']);
		$s_data['L_BUTTONVAR19'] = 'billing_country=' . urlencode($order_info['payment_iso_code_2']);

		$s_data['L_BUTTONVAR20'] = 'notify_url=' . $this->url->link('payment/pp_pro_iframe/notify', '', 'SSL');
		$s_data['L_BUTTONVAR21'] = 'cancel_return=' . $this->url->link('checkout/checkout', '', 'SSL');
		$s_data['L_BUTTONVAR22'] = 'paymentaction=' . $this->config->get('pp_pro_iframe_transaction_method');
		$s_data['L_BUTTONVAR23'] = 'currency_code=' . urlencode($order_info['currency_code']);
		$s_data['L_BUTTONVAR26'] = 'showBillingAddress=false';
		$s_data['L_BUTTONVAR27'] = 'showShippingAddress=false';
		$s_data['L_BUTTONVAR28'] = 'showBillingEmail=false';
		$s_data['L_BUTTONVAR29'] = 'showBillingPhone=false';
		$s_data['L_BUTTONVAR30'] = 'showCustomerName=true';
		$s_data['L_BUTTONVAR31'] = 'showCardInfo=true';
		$s_data['L_BUTTONVAR32'] = 'showHostedThankyouPage=false';
		$s_data['L_BUTTONVAR33'] = 'bn=GBD';
		$s_data['L_BUTTONVAR35'] = 'address_override=true';
		$s_data['L_BUTTONVAR36'] = 'cpp_header_image=Red';
		$s_data['L_BUTTONVAR44'] = 'bodyBgColor=#AEAEAE';
		$s_data['L_BUTTONVAR47'] = 'PageTitleTextColor=Blue';
		$s_data['L_BUTTONVAR48'] = 'PageCollapseBgColor=#AEAEAE';
		$s_data['L_BUTTONVAR49'] = 'PageCollapseTextColor=#AEAEAE';
		$s_data['L_BUTTONVAR50'] = 'PageButtonBgColor=#AEAEAE';
		$s_data['L_BUTTONVAR51'] = 'orderSummaryBgColor=#AEAEAE';
		$s_data['L_BUTTONVAR55'] = 'template=templateD';
		$s_data['L_BUTTONVAR56'] = 'return=' . $this->url->link('checkout/success', '', 'SSL');
		$s_data['L_BUTTONVAR57'] = 'custom=' . $this->encryption->encrypt($order_info['order_id']);

		if ($this->config->get('pp_pro_iframe_test')) {
			$url = 'https://api-3t.sandbox.paypal.com/nvp';
		} else {
			$url = 'https://api-3t.paypal.com/nvp';
		}

		$options = array(
			CURLOPT_POST           => true,
			CURLOPT_HEADER         => false,
			CURLOPT_HTTPHEADER     => array('X-VPS-REQUEST-ID: ' . md5($order_info['order_id'] . mt_rand())),
			CURLOPT_URL            => $url,
			CURLOPT_PORT           => 443,
			CURLOPT_FRESH_CONNECT  => true,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FORBID_REUSE   => true,
			CURLOPT_POSTFIELDS     => http_build_query($s_data, '', '&')
		);

		$ch = curl_init();

		curl_setopt_array($ch, $options);

		$response = curl_exec($ch);

		if (curl_errno($ch) != CURLE_OK) {
			$log_data = array(
				'curl_errno' => curl_errno($ch),
				'curl_error' => curl_error($ch)
			);

			$this->model_payment_pp_pro_iframe->log($log_data, 'cURL failed');

			return false;
		}

		curl_close($ch);

		$response_data = array();

		parse_str($response, $response_data);

		$this->model_payment_pp_pro_iframe->log($response_data, 'Hosted Button');

		return (isset($response_data['HOSTEDBUTTONID']) ? $response_data['HOSTEDBUTTONID'] : false);
	}
}
