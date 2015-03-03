<?php
class ModelTotalPayPalFee extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {
		$paypal_fee = $this->config->get('paypal_fee_total');

		if ($this->cart->getTotal() && (empty($paypal_fee) || ($this->cart->getSubTotal() < $paypal_fee))) {
			$this->load->language('total/paypal_fee');

			if ((isset($this->session->data['payment_method']) && ((substr($this->session->data['payment_method']['code'], 0, 3) == 'pp_') || ($this->session->data['payment_method']['code'] == "paypal_email"))) || (isset($this->request->post['payment']) && ((substr($this->request->post['payment'], 0, 3) == 'pp_') || ($this->request->post['payment'] == "paypal_email")))) {
				if ($this->config->get('paypal_fee_fee_type') == 'P') {
					$min = $this->config->get('paypal_fee_fee_min');
					$max = $this->config->get('paypal_fee_fee_max');

					$fee = ($this->cart->getTotal() * $this->config->get('paypal_fee_fee')) / 100;

					if (!empty($min) && ($fee < $min)) {
						$fee = $min;
					}

					if (!empty($max) && ($fee > $max)) {
						$fee = $max;
					}

				} else {
					$fee = $this->config->get('paypal_fee_fee');
				}

				$total_data[] = array(
					'code'		=> 'paypal_fee',
					'title'			=> $this->language->get('text_paypal_fee'),
					'text'			=> $this->currency->format($fee),
					'value'		=> $fee,
					'sort_order'	=> $this->config->get('paypal_fee_sort_order')
				);

				if ($this->config->get('paypal_fee_tax_class_id')) {
					$tax_rates = $this->tax->getRates($fee, $this->config->get('paypal_fee_tax_class_id'));

					foreach ($tax_rates as $tax_rate) {
						if (!isset($taxes[$tax_rate['tax_rate_id']])) {
							$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
						} else {
							$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
						}
					}
				}

				$total += $fee;
			}
		}
	}
}
?>