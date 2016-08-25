<?php
class ModelTotalGiftWrapping extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {
		if (isset($this->session->data['wrapping']) && $this->config->get('gift_wrapping_status') && $this->cart->getSubTotal() > 0) {
			$this->language->load('total/gift_wrapping');

			$total_data[] = array(
				'code'       => 'gift_wrapping',
				'title'      => $this->language->get('text_gift_wrapping'),
				'text'       => $this->currency->format($this->config->get('gift_wrapping_price')),
				'value'      => $this->config->get('gift_wrapping_price'),
				'sort_order' => $this->config->get('gift_wrapping_sort_order')
			);

			$total += $this->config->get('gift_wrapping_price');
		}
	}
}
