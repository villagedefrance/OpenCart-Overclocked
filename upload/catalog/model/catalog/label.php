<?php
class ModelCatalogLabel extends Model {

	public function getProductDiscountLabel($label_size, $image_width, $image_height, $product_id) {
		$discount_label = $this->config->get('config_discount_label');

		if ($discount_label) {
			return;
		} else {
			$this->language->load('product/label');

			$discount_label_size = 0;

			$discount_label_size = abs($label_size);

			$discount_label_shape = $this->config->get('config_discount_label_shape');
			$discount_label_color = $this->config->get('config_discount_label_color');
			$discount_label_position = $this->config->get('config_discount_label_position');

			// Positions
			if ($discount_label_position == 'top-left') {
				$top_position = 0;
				$left_position = 0;
			} elseif ($discount_label_position == 'top-right') {
				$top_position = 0;
				$left_position = $image_width - $discount_label_size;
			} elseif ($discount_label_position == 'bottom-left') {
				$top_position = ($image_height + 6) - $discount_label_size;
				$left_position = 0;
			} elseif ($discount_label_position == 'bottom-right') {
				$top_position = ($image_height + 6) - $discount_label_size;
				$left_position = $image_width - $discount_label_size;
			} else {
				$top_position = 0;
				$left_position = 0;
			}

			$font_color = $this->getFontColor($discount_label_color);

			// Output
			$discount_label_output = '<figure class="label-' . $discount_label_shape . '-' . $discount_label_size . '"';
			$discount_label_output .= ' style="position:relative; top:' . $top_position . 'px; left:' . $left_position . 'px; background:' . $discount_label_color . '; display:block;">';

			if ($discount_label_size == 75) {
				$discount_label_output .= '<a style="color:' . $font_color . '; font-size:11px; font-weight:bold; text-decoration:none; line-height:15px;">' . $this->language->get('text_label_discount') . '</a>';
			} elseif ($discount_label_size == 45) {
				$discount_label_output .= '<a style="color:' . $font_color . '; font-size:8px; font-weight:bold; text-decoration:none; line-height:12px;">' . $this->language->get('text_label_discount') . '</a>';
			} else {
				$discount_label_output .= '';
			}

			$discount_label_output .= '</figure>';

			return $discount_label_output;
		}
	}

	public function getProductSpecialLabel($label_size, $image_width, $image_height, $product_id) {
		$special_label = $this->config->get('config_special_label');

		if ($special_label) {
			return;
		} else {
			$this->language->load('product/label');

			$special_label_size = 0;

			$special_label_size = abs($label_size);

			$special_label_shape = $this->config->get('config_special_label_shape');
			$special_label_color = $this->config->get('config_special_label_color');
			$special_label_position = $this->config->get('config_special_label_position');

			// Positions
			if ($special_label_position == 'top-left') {
				$top_position = 0;
				$left_position = 0;
			} elseif ($special_label_position == 'top-right') {
				$top_position = 0;
				$left_position = $image_width - $special_label_size;
			} elseif ($special_label_position == 'bottom-left') {
				$top_position = ($image_height + 6) - $special_label_size;
				$left_position = 0;
			} elseif ($special_label_position == 'bottom-right') {
				$top_position = ($image_height + 6) - $special_label_size;
				$left_position = $image_width - $special_label_size;
			} else {
				$top_position = 0;
				$left_position = 0;
			}

			$font_color = $this->getFontColor($special_label_color);

			// Output
			$special_label_output = '<figure class="label-' . $special_label_shape . '-' . $special_label_size . '"';
			$special_label_output .= ' style="position:relative; top:' . $top_position . 'px; left:' . $left_position . 'px; background:' . $special_label_color . '; display:block;">';

			if ($special_label_size == 75) {
				$special_label_output .= '<a style="color:' . $font_color . '; font-size:11px; font-weight:bold; text-decoration:none; line-height:15px;">' . $this->language->get('text_label_special') . '</a>';
			} elseif ($special_label_size == 45) {
				$special_label_output .= '<a style="color:' . $font_color . '; font-size:8px; font-weight:bold; text-decoration:none; line-height:12px;">' . $this->language->get('text_label_special') . '</a>';
			} else {
				$special_label_output .= '';
			}

			$special_label_output .= '</figure>';

			return $special_label_output;
		}
	}

	public function getProductOfferLabel($label_size, $image_width, $image_height, $product_id) {
		$offer_label = $this->config->get('config_offer_label');

		if ($offer_label) {
			return;
		} else {
			$this->language->load('product/label');

			$offer_label_size = 0;

			$offer_label_size = abs($label_size);

			$offer_label_shape = $this->config->get('config_offer_label_shape');
			$offer_label_color = $this->config->get('config_offer_label_color');
			$offer_label_position = $this->config->get('config_offer_label_position');

			// Positions
			if ($offer_label_position == 'top-left') {
				$top_position = 0;
				$left_position = 0;
			} elseif ($offer_label_position == 'top-right') {
				$top_position = 0;
				$left_position = $image_width - $offer_label_size;
			} elseif ($offer_label_position == 'bottom-left') {
				$top_position = ($image_height + 6) - $offer_label_size;
				$left_position = 0;
			} elseif ($offer_label_position == 'bottom-right') {
				$top_position = ($image_height + 6) - $offer_label_size;
				$left_position = $image_width - $offer_label_size;
			} else {
				$top_position = 0;
				$left_position = 0;
			}

			$font_color = $this->getFontColor($offer_label_color);

			// Output
			$offer_label_output = '<figure class="label-' . $offer_label_shape . '-' . $offer_label_size . '"';
			$offer_label_output .= ' style="position:relative; top:' . $top_position . 'px; left:' . $left_position . 'px; background:' . $offer_label_color . '; display:block;">';

			if ($offer_label_size == 75) {
				$offer_label_output .= '<a style="color:' . $font_color . '; font-size:11px; font-weight:bold; text-decoration:none; line-height:15px;">' . $this->language->get('text_label_offer') . '</a>';
			} elseif ($offer_label_size == 45) {
				$offer_label_output .= '<a style="color:' . $font_color . '; font-size:8px; font-weight:bold; text-decoration:none; line-height:12px;">' . $this->language->get('text_label_offer') . '</a>';
			} else {
				$offer_label_output .= '';
			}

			$offer_label_output .= '</figure>';

			return $offer_label_output;
		}
	}

	public function getProductStockLabel($label_size, $image_width, $image_height, $product_id) {
		$stock_label = $this->config->get('config_stock_label');

		if ($stock_label) {
			return;
		} else {
			$this->language->load('product/label');

			$stock_label_size = 0;

			$stock_label_size = abs($label_size);

			$stock_label_shape = $this->config->get('config_stock_label_shape');
			$stock_label_color = $this->config->get('config_stock_label_color');
			$stock_label_position = $this->config->get('config_stock_label_position');

			// Positions
			if ($stock_label_position == 'top-left') {
				$top_position = 0;
				$left_position = 0;
			} elseif ($stock_label_position == 'top-right') {
				$top_position = 0;
				$left_position = $image_width - $stock_label_size;
			} elseif ($stock_label_position == 'bottom-left') {
				$top_position = ($image_height + 6) - $stock_label_size;
				$left_position = 0;
			} elseif ($stock_label_position == 'bottom-right') {
				$top_position = ($image_height + 6) - $stock_label_size;
				$left_position = $image_width - $stock_label_size;
			} else {
				$top_position = 0;
				$left_position = 0;
			}

			$font_color = $this->getFontColor($stock_label_color);

			// Output
			$stock_label_output = '<figure class="label-' . $stock_label_shape . '-' . $stock_label_size . '"';
			$stock_label_output .= ' style="position:relative; top:' . $top_position . 'px; left:' . $left_position . 'px; background:' . $stock_label_color . '; display:block;">';

			if ($stock_label_size == 75) {
				$stock_label_output .= '<a style="color:' . $font_color . '; font-size:11px; font-weight:bold; text-decoration:none; line-height:15px;">' . $this->language->get('text_label_stock') . '</a>';
			} elseif ($stock_label_size == 45) {
				$stock_label_output .= '<a style="color:' . $font_color . '; font-size:8px; font-weight:bold; text-decoration:none; line-height:12px;">' . $this->language->get('text_label_stock') . '</a>';
			} else {
				$stock_label_output .= '';
			}

			$stock_label_output .= '</figure>';

			return $stock_label_output;
		}
	}

	public function getProductHasDiscounts($product_id) {
		if ($this->customer->isLogged()) {
			$customer_group_id = $this->customer->getCustomerGroupId();
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity > '1' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		if ($query->num_rows) {
			return true;
		} else {
			return false;
		}
	}

	protected function getFontColor($color) {
		$font_color = '';

		$inverted_colors = array('#FFFFFF', '#F5F5DC', '#E5E5D0', '#C2C2C2', '#FFF033', '#E3C800', '#F2F2F2');

		if ($color && in_array($color, $inverted_colors)) {
			$font_color = '#222';
		} else {
			$font_color = '#FFF';
		}

		return $font_color;
	}
}
