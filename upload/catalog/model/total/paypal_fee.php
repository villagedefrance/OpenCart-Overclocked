<?php
class ModelTotalPayPalFee extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {
		$paypal_fee_total = $this->config->get('paypal_fee_total');

		if ($this->cart->getTotal() && (empty($paypal_fee_total) || ($this->cart->getTotal() < $paypal_fee_total))) {
			$this->language->load('total/paypal_fee');

			if ((isset($this->session->data['payment_method']) && ((substr($this->session->data['payment_method']['code'], 0, 3) == 'pp_') || ($this->session->data['payment_method']['code'] == "paypal_email"))) || (isset($this->request->post['payment']) && ((substr($this->request->post['payment'], 0, 3) == 'pp_') || ($this->request->post['payment'] == "paypal_email")))) {
				if ($this->config->get('paypal_fee_fee_type') == 'F') {
					$paypal_fee = $this->config->get('paypal_fee_fee');
				} else {
					$paypal_fee = ($this->cart->getTotal() * $this->config->get('paypal_fee_fee')) / 100;

					$min = $this->config->get('paypal_fee_fee_min');
					$max = $this->config->get('paypal_fee_fee_max');

					if (!empty($min) && ($paypal_fee < $min)) {
						$paypal_fee = $min;
					}

					if (!empty($max) && ($paypal_fee > $max)) {
						$paypal_fee = $max;
					}
				}

				$total_data[] = array(
					'code'       => 'paypal_fee',
					'title'      => $this->language->get('text_paypal_fee'),
					'text'       => $this->currency->format($paypal_fee),
					'value'      => $paypal_fee,
					'sort_order' => $this->config->get('paypal_fee_sort_order')
				);

				if ($this->config->get('paypal_fee_tax_class_id')) {
					$tax_rates = $this->tax->getRates($paypal_fee, $this->config->get('paypal_fee_tax_class_id'));

					foreach ($tax_rates as $tax_rate) {
						if (!isset($taxes[$tax_rate['tax_rate_id']])) {
							$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
						} else {
							$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
						}
					}
				}

				$total += $paypal_fee;
			}
		}
	}
}
