<?php
class ModelTotalReward extends Model {

	public function getTotal(&$total_data, &$total, &$taxes) {
		if (isset($this->session->data['reward'])) {
			$this->language->load('total/reward');

			$points_rate = $this->config->get('config_reward_rate');

			$points = $this->customer->getRewardPoints();

			if ($this->session->data['reward'] <= $points) {
				$points = $this->session->data['reward'];

				$discount_total = 0;
				$points_total = 0;

				foreach ($this->cart->getProducts() as $product) {
					if ($product['points']) {
						$points_total += $product['points'];
					}
				}

				$max_points = min($points / $points_rate, $points_total);

				$sub_total = $this->cart->getSubTotal();

				if ($points && $max_points > $sub_total) {
					$reward_points = $sub_total;
				} else {
					$reward_points = $max_points;
				}

				foreach ($this->cart->getProducts() as $product) {
					$discount = 0;

					if ($product['points']) {
						$discount = $reward_points;

						if ($product['tax_class_id']) {
							$tax_rates = $this->tax->getRates($discount, $product['tax_class_id']);

							foreach ($tax_rates as $tax_rate) {
								if ($tax_rate['type'] == 'P') {
									$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								}
							}
						}
					}

					$discount_total += $discount;
				}

				$total_data[] = array(
					'code'       => 'reward',
					'title'      => sprintf($this->language->get('text_reward'), $reward_points * $points_rate),
					'text'       => $this->currency->format(-$discount_total),
					'value'      => -$discount_total,
					'sort_order' => $this->config->get('reward_sort_order')
				);

				$total -= $discount_total;
			}
		}
	}

	public function confirm($order_info, $order_total) {
		$this->language->load('total/reward');

		$points = 0;

		$start = strpos($order_total['title'], '(') + 1;
		$end = strrpos($order_total['title'], ')');

		if ($start && $end) {
			$points = substr($order_total['title'], $start, $end - $start);
		}

		if ($points) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_reward SET customer_id = '" . (int)$order_info['customer_id'] . "', description = '" . $this->db->escape(sprintf($this->language->get('text_order_id'), (int)$order_info['order_id'])) . "', points = '" . (float)-$points . "', date_added = NOW()");
		}
	}
}
