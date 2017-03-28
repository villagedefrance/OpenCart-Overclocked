<?php
class ControllerPaymentFirstdata extends Controller {

	public function index() {
		$this->language->load('payment/firstdata');

		$this->data['button_confirm'] = $this->language->get('button_confirm');

		$this->data['text_new_card'] = $this->language->get('text_new_card');
		$this->data['text_store_card'] = $this->language->get('text_store_card');

		$this->load->model('checkout/order');
		$this->load->model('payment/firstdata');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		if ($this->config->get('firstdata_live_demo') == 1) {
			$this->data['action'] = $this->config->get('firstdata_live_url');
		} else {
			$this->data['action'] = $this->config->get('firstdata_demo_url');
		}

		$this->data['amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
		$this->data['currency'] = $this->model_payment_firstdata->mapCurrency($order_info['currency_code']);
		$this->data['merchant_id'] = $this->config->get('firstdata_merchant_id');
		$this->data['timestamp'] = date('Y:m:d-H:i:s');
		$this->data['order_id'] = 'CON-' . $this->session->data['order_id'] . 'T' . $this->data['timestamp'] . mt_rand(1, 999);

		$this->data['url_success'] = $this->url->link('checkout/success', '', true);
		$this->data['url_fail'] = $this->url->link('payment/firstdata/fail', '', true);
		$this->data['url_notify'] = $this->url->link('payment/firstdata/notify', '', true);

		if (preg_match("/Mobile|Android|BlackBerry|iPhone|Windows Phone/", $this->request->server['HTTP_USER_AGENT'])) {
			$this->data['mobile'] = true;
		} else {
			$this->data['mobile'] = false;
		}

		if ($this->config->get('firstdata_auto_settle') == 1) {
			$this->data['txntype'] = 'sale';
		} else {
			$this->data['txntype'] = 'preauth';
		}

		$tmp = $this->data['merchant_id'] . $this->data['timestamp'] . $this->data['amount'] . $this->data['currency'] . $this->config->get('firstdata_secret');
		$ascii = bin2hex($tmp);
		$this->data['hash'] = sha1($ascii);

		$this->data['version'] = 'OPENCART-C-' . VERSION;

		$this->data['bcompany'] = $order_info['payment_company'];
		$this->data['bname'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
		$this->data['baddr1'] = substr($order_info['payment_address_1'], 0, 30);
		$this->data['baddr2'] = substr($order_info['payment_address_2'], 0, 30);
		$this->data['bcity'] = substr($order_info['payment_city'], 0, 30);
		$this->data['bstate'] = substr($order_info['payment_zone'], 0, 30);
		$this->data['bcountry'] = $order_info['payment_iso_code_2'];
		$this->data['bzip'] = $order_info['payment_postcode'];
		$this->data['email'] = $order_info['email'];

		if ($this->cart->hasShipping()) {
			$this->data['sname'] = $order_info['shipping_firstname'] . ' ' . $order_info['shipping_lastname'];
			$this->data['saddr1'] = substr($order_info['shipping_address_1'], 0, 30);
			$this->data['saddr2'] = substr($order_info['shipping_address_2'], 0, 30);
			$this->data['scity'] = substr($order_info['shipping_city'], 0, 30);
			$this->data['sstate'] = substr($order_info['shipping_zone'], 0, 30);
			$this->data['scountry'] = $order_info['shipping_iso_code_2'];
			$this->data['szip'] = $order_info['shipping_postcode'];
		} else {
			$this->data['sname'] = $order_info['payment_firstname'] . ' ' . $order_info['payment_lastname'];
			$this->data['saddr1'] = substr($order_info['payment_address_1'], 0, 30);
			$this->data['saddr2'] = substr($order_info['payment_address_2'], 0, 30);
			$this->data['scity'] = substr($order_info['payment_city'], 0, 30);
			$this->data['sstate'] = substr($order_info['payment_zone'], 0, 30);
			$this->data['scountry'] = $order_info['payment_iso_code_2'];
			$this->data['szip'] = $order_info['payment_postcode'];
		}

		if ($this->config->get('firstdata_card_storage') == 1 && $this->customer->isLogged()) {
			$this->data['card_storage'] = 1;
			$this->data['stored_cards'] = $this->model_payment_firstdata->getStoredCards();
			$this->data['new_hosted_id'] = sha1($this->customer->getId() . '-' . date("Y-m-d-H-i-s") . rand(10, 500));
		} else {
			$this->data['card_storage'] = 0;
			$this->data['stored_cards'] = array();
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/firstdata.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/firstdata.tpl';
		} else {
			$this->template = 'default/template/payment/firstdata.tpl';
		}

		$this->render();
	}

	public function notify() {
		$this->language->load('payment/firstdata');

		$this->load->model('payment/firstdata');
		$this->load->model('checkout/order');

		$message = '';

		if ($this->config->get('firstdata_debug') == 1) {
			$this->model_payment_firstdata->logger(print_r($this->request->post, 1));
		}

		if (isset($this->request->post['txntype']) && isset($this->request->post['notification_hash']) && isset($this->request->post['oid'])) {
			$local_hash = $this->model_payment_firstdata->responseHash($this->request->post['chargetotal'], $this->request->post['currency'], $this->request->post['txndatetime'], $this->request->post['approval_code']);

			if ($local_hash == $this->request->post['notification_hash']) {
				$order_id_parts = explode('T', $this->request->post['oid']);

				$order_id = str_replace("CON-", "", $order_id_parts[0]);

				$order_info = $this->model_checkout_order->getOrder($order_id);

				if ($this->request->post['txntype'] == 'preauth' || $this->request->post['txntype'] == 'sale') {
					if (isset($this->request->post['approval_code'])) {
						$response_parts = explode(':', $this->request->post['approval_code']);

						$address_codes = array(
							'PPX' => $this->language->get('text_address_ppx'),
							'YYY' => $this->language->get('text_address_yyy'),
							'YNA' => $this->language->get('text_address_yna'),
							'NYZ' => $this->language->get('text_address_nyz'),
							'NNN' => $this->language->get('text_address_nnn'),
							'YPX' => $this->language->get('text_address_ypx'),
							'PYX' => $this->language->get('text_address_pyx'),
							'XXU' => $this->language->get('text_address_xxu')
						);

						$cvv_codes = array(
							'M'    => $this->language->get('text_card_code_m'),
							'N'    => $this->language->get('text_card_code_n'),
							'P'    => $this->language->get('text_card_code_p'),
							'S'    => $this->language->get('text_card_code_s'),
							'U'    => $this->language->get('text_card_code_u'),
							'X'    => $this->language->get('text_card_code_x'),
							'NONE' => $this->language->get('text_card_code_blank')
						);

						$card_types = array(
							'M'         => $this->language->get('text_card_type_m'),
							'V'         => $this->language->get('text_card_type_v'),
							'C'         => $this->language->get('text_card_type_c'),
							'A'         => $this->language->get('text_card_type_a'),
							'MA'        => $this->language->get('text_card_type_ma'),
							'MAESTROUK' => $this->language->get('text_card_type_mauk')
						);

						if ($response_parts[0] == 'Y') {
							if (isset($response_parts[3])) {
								if (strlen($response_parts[3]) == 4) {
									$address_pass = strtoupper(substr($response_parts[3], 0, 3));
									$cvv_pass = strtoupper(substr($response_parts[3], -1));

									if (!array_key_exists($cvv_pass, $cvv_codes)) {
										$cvv_pass = 'NONE';
									}
								} else {
									$address_pass = $response_parts[3];
									$cvv_pass = 'NONE';
								}

								$message .= $this->language->get('text_address_response') . $address_codes[$address_pass] . '<br />';
								$message .= $this->language->get('text_card_code_verify') . $cvv_codes[$cvv_pass] . '<br />';
								$message .= $this->language->get('text_response_code_full') . $this->request->post['approval_code'] . '<br />';
								$message .= $this->language->get('text_response_code') . $response_parts[1] . '<br />';

								if (isset($this->request->post['cardnumber'])) {
									$message .= $this->language->get('text_response_card') . $this->request->post['cardnumber'] . '<br />';
								}

								if (isset($this->request->post['processor_response_code'])) {
									$message .= $this->language->get('text_response_proc_code') . $this->request->post['processor_response_code'] . '<br />';
								}

								if (isset($this->request->post['refnumber'])) {
									$message .= $this->language->get('text_response_ref') . $this->request->post['refnumber'] . '<br />';
								}

								if (isset($this->request->post['paymentMethod'])) {
									$message .= $this->language->get('text_response_card_type') . $card_types[strtoupper($this->request->post['paymentMethod'])] . '<br />';
								}
							}

							if (isset($this->request->post['hosteddataid']) && $order_info['customer_id'] != 0) {
								$this->model_payment_firstdata->storeCard($this->request->post['hosteddataid'], $order_info['customer_id'], $this->request->post['expmonth'], $this->request->post['expyear'], $this->request->post['cardnumber']);
							}

							$fd_order_id = $this->model_payment_firstdata->addOrder($order_info, $this->request->post['oid'], $this->request->post['tdate']);

							if ($this->config->get('firstdata_auto_settle') == 1) {
								$this->model_payment_firstdata->addTransaction($fd_order_id, 'payment', $order_info);

								$this->model_checkout_order->update($order_id, $this->config->get('firstdata_order_status_success_settled_id'), $message, false);
							} else {
								$this->model_payment_firstdata->addTransaction($fd_order_id, 'auth');

								$this->model_checkout_order->update($order_id, $this->config->get('firstdata_order_status_success_unsettled_id'), $message, false);
							}

						} else {
							$message = $this->request->post['fail_reason'] . '<br />';
							$message .= $this->language->get('text_response_code_full') . $this->request->post['approval_code'];

							$this->model_checkout_order->update($order_id, $this->config->get('firstdata_order_status_decline_id'), $message);
						}
					}
				}

				if ($this->request->post['txntype'] == 'void') {
					if ($this->request->post['status'] == 'DECLINED') {
						$fd_order = $this->model_payment_firstdata->getOrder($order_id);

						$this->model_payment_firstdata->updateVoidStatus($order_id, 1);

						$this->model_payment_firstdata->addTransaction($fd_order['firstdata_order_id'], 'void');

						$this->model_checkout_order->update($order_id, $this->config->get('firstdata_order_status_void_id'), $message, false);
					}
				}

				if ($this->request->post['txntype'] == 'postauth') {
					if ($this->request->post['status'] == 'APPROVED') {
						$fd_order = $this->model_payment_firstdata->getOrder($order_id);

						$this->model_payment_firstdata->updateCaptureStatus($order_id, 1);

						$this->model_payment_firstdata->addTransaction($fd_order['firstdata_order_id'], 'payment', $order_info);

						$this->model_checkout_order->update($order_id, $this->config->get('firstdata_order_status_success_settled_id'), $message, false);
					}
				}

			} else {
				$this->model_payment_firstdata->logger('Hash does not match! Received: ' . $this->request->post['notification_hash'] . ', calculated: ' . $local_hash);
			}

		} else {
			$this->model_payment_firstdata->logger('Data is missing from request.');
		}
	}

	public function fail() {
		$this->language->load('payment/firstdata');

		if (isset($this->request->post['fail_reason']) && !empty($this->request->post['fail_reason'])) {
			$this->session->data['error'] = $this->request->post['fail_reason'];
		} else {
			$this->session->data['error'] = $this->language->get('error_failed');
		}

		$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));
	}
}
