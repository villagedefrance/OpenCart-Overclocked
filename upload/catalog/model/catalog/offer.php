<?php
class ModelCatalogOffer extends Model {

	public function getOfferProducts($product_id) {
		$this->load->language('total/offers');

		$this->load->model('checkout/offers');

		$offer_products = array();

		// Product Product
		$offer_product_products = $this->model_checkout_offers->getOfferProductProducts(0);

		if ($offer_product_products) {
			foreach ($offer_product_products as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				if (($result['one'] == $product_id) && ($result['two'] == $product_id)) {
					$offer_products[] = array(
						'group'	=> 'G241',
						'one'		=> $result['one'],
						'two'		=> $result['two'],
						'type'		=> $type
					);

				} elseif ($result['two'] == $product_id) {
					$offer_products[] = array(
						'group'	=> 'G142D',
						'one'		=> $result['one'],
						'two'		=> $result['two'],
						'type'		=> $type
					);

				} elseif ($result['one'] == $product_id) {
					$offer_products[] = array(
						'group'	=> 'G242D',
						'one'		=> $result['one'],
						'two'		=> $result['two'],
						'type'		=> $type
					);

				} else {
					continue;
				}
			}
		}

		// Product Category
		$offer_product_categories = $this->model_checkout_offers->getOfferProductCategories(0);

		if ($offer_product_categories) {
			foreach ($offer_product_categories as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				$product_lists = array();

				$product_lists = $this->getCategoryProducts($result['two']);

				if ($product_lists) {
					$product = 0;

					foreach ($product_lists as $product) {
						if (($result['one'] == $product_id) && ($product == $product_id)) {
							$offer_products[] = array(
								'group'	=> 'G241D',
								'one'		=> $result['one'],
								'two'		=> $product,
								'type'		=> $type
							);

						} elseif ($product == $product_id) {
							$offer_products[] = array(
								'group'	=> 'G142D',
								'one'		=> $result['one'],
								'two'		=> $product,
								'type'		=> $type
							);

						} elseif ($result['one'] == $product_id) {
							$offer_products[] = array(
								'group'	=> 'G242D',
								'one'		=> $result['one'],
								'two'		=> $product,
								'type'		=> $type
							);

						} else {
							continue;
						}
					}

				} else {
					continue;
				}
			}
		}

		// Category Product
		$offer_category_products = $this->model_checkout_offers->getOfferCategoryProducts(0);

		if ($offer_category_products) {
			foreach ($offer_category_products as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				$product_lists = array();

				$product_lists = $this->getCategoryProducts($result['one']);

				if ($product_lists) {
					$product = 0;

					foreach ($product_lists as $product) {
						if (($product == $product_id) && ($result['two'] == $product_id)) {
							$offer_products[] = array(
								'group'	=> 'G241D',
								'one'		=> $product,
								'two'		=> $result['two'],
								'type'		=> $type
							);

						} elseif ($result['two'] == $product_id) {
							$offer_products[] = array(
								'group'	=> 'G142D',
								'one'		=> $product,
								'two'		=> $result['two'],
								'type'		=> $type
							);

						} elseif ($product == $product_id) {
							$offer_products[] = array(
								'group'	=> 'G242D',
								'one'		=> $product,
								'two'		=> $result['two'],
								'type'		=> $type
							);

						} else {
							continue;
						}
					}

				} else {
					continue;
				}
			}
		}

		// Category Category
		$offer_category_categories = $this->model_checkout_offers->getOfferCategoryCategories(0);

		if ($offer_category_categories) {
			foreach ($offer_category_categories as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				$product_one_lists = array();

				$product_one_lists = $this->getCategoryProducts($result['one']);

				$product_two_lists = array();

				$product_two_lists = $this->getCategoryProducts($result['two']);

				if ($product_one_lists && $product_two_lists) {
					$product_one = 0;
					$product_two = 0;

					foreach ($product_one_lists as $product_one) {
						foreach ($product_two_lists as $product_two) {
							if (($product_one == $product_id) && ($product_two == $product_id)) {
								$offer_products[] = array(
									'group'	=> 'G241D',
									'one'		=> $product_one,
									'two'		=> $product_two,
									'type'		=> $type
								);

							} elseif ($product_two == $product_id) {
								$offer_products[] = array(
									'group'	=> 'G142D',
									'one'		=> $product_one,
									'two'		=> $product_two,
									'type'		=> $type
								);

							} elseif ($product_one == $product_id) {
								$offer_products[] = array(
									'group'	=> 'G242D',
									'one'		=> $product_one,
									'two'		=> $product_two,
									'type'		=> $type
								);

							} else {
								continue;
							}
						}
					}
				}
			}
		}

		return $offer_products;
	}

	// Product List
	private function getCategoryProducts($category_id) {
        $product_list = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");

        if ($query->num_rows) {
            foreach ($query->rows as $result) {
                $product_list[] = $result['product_id'];
            }
        }

        return $product_list;
    }

	public function getOfferProductImage($product_id) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

		return $query->row['image'];
	}

	public function getOfferProductName($product_id) {
		$query = $this->db->query("SELECT pd.name AS name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.product_id = '" . (int)$product_id . "'");

		return $query->row['name'];
	}
}
?>