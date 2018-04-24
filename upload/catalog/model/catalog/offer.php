<?php
class ModelCatalogOffer extends Model {

	public function getOfferProducts($product_id) {
		$this->language->load('total/offers');

		$this->load->model('checkout/offers');

		$offer_products = array();

		// Product Product
		$offer_product_products = $this->model_checkout_offers->getOfferProductProducts();

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
						'group' => 'G241',
						'one'   => $result['one'],
						'two'   => $result['two'],
						'type'  => $type
					);

				} elseif ($result['two'] == $product_id) {
					$offer_products[] = array(
						'group' => 'G142D',
						'one'   => $result['one'],
						'two'   => $result['two'],
						'type'  => $type
					);

				} elseif ($result['one'] == $product_id) {
					$offer_products[] = array(
						'group' => 'G242D',
						'one'   => $result['one'],
						'two'   => $result['two'],
						'type'  => $type
					);

				} else {
					continue;
				}
			}
		}

		// Product Category
		$offer_product_categories = $this->model_checkout_offers->getOfferProductCategories();

		if ($offer_product_categories) {
			foreach ($offer_product_categories as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				$product_lists = $this->getCategoryProducts($result['two']);

				if ($product_lists) {
					$product = 0;

					foreach ($product_lists as $product) {
						if (($result['one'] == $product_id) && ($product == $product_id)) {
							$offer_products[] = array(
								'group' => 'G241D',
								'one'   => $result['one'],
								'two'   => $product,
								'type'  => $type
							);

						} elseif ($product == $product_id) {
							$offer_products[] = array(
								'group' => 'G142D',
								'one'   => $result['one'],
								'two'   => $product,
								'type'  => $type
							);

						} elseif ($result['one'] == $product_id) {
							$offer_products[] = array(
								'group' => 'G242D',
								'one'   => $result['one'],
								'two'   => $product,
								'type'  => $type
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
		$offer_category_products = $this->model_checkout_offers->getOfferCategoryProducts();

		if ($offer_category_products) {
			foreach ($offer_category_products as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				$product_lists = $this->getCategoryProducts($result['one']);

				if ($product_lists) {
					$product = 0;

					foreach ($product_lists as $product) {
						if (($product == $product_id) && ($result['two'] == $product_id)) {
							$offer_products[] = array(
								'group' => 'G241D',
								'one'   => $product,
								'two'   => $result['two'],
								'type'  => $type
							);

						} elseif ($result['two'] == $product_id) {
							$offer_products[] = array(
								'group' => 'G142D',
								'one'   => $product,
								'two'   => $result['two'],
								'type'  => $type
							);

						} elseif ($product == $product_id) {
							$offer_products[] = array(
								'group' => 'G242D',
								'one'   => $product,
								'two'   => $result['two'],
								'type'  => $type
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
		$offer_category_categories = $this->model_checkout_offers->getOfferCategoryCategories();

		if ($offer_category_categories) {
			foreach ($offer_category_categories as $result) {
				if ($result['type'] == 'F') {
					$type = $this->currency->format($result['disc']) . ' ' . $this->language->get('text_off');
				} elseif (($result['type'] == 'P') && ((int)$result['disc'] == '100')) {
					$type = $this->language->get('text_free');
				} else {
					$type = (int)$result['disc'] . '% ' . $this->language->get('text_off');
				}

				$product_one_lists = $this->getCategoryProducts($result['one']);
				$product_two_lists = $this->getCategoryProducts($result['two']);

				if ($product_one_lists && $product_two_lists) {
					$product_one = 0;
					$product_two = 0;

					foreach ($product_one_lists as $product_one) {
						foreach ($product_two_lists as $product_two) {
							if (($product_one == $product_id) && ($product_two == $product_id)) {
								$offer_products[] = array(
									'group' => 'G241D',
									'one'   => $product_one,
									'two'   => $product_two,
									'type'  => $type
								);

							} elseif ($product_two == $product_id) {
								$offer_products[] = array(
									'group' => 'G142D',
									'one'   => $product_one,
									'two'   => $product_two,
									'type'  => $type
								);

							} elseif ($product_one == $product_id) {
								$offer_products[] = array(
									'group' => 'G242D',
									'one'   => $product_one,
									'two'   => $product_two,
									'type'  => $type
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

	// Called in Shopping Cart
	public function getListProductOffers() {
		$this->load->model('checkout/offers');

		$offer_products = array();

		// Product Product
		$offer_product_products = $this->model_checkout_offers->getOfferProductProducts();

		if ($offer_product_products) {
			foreach ($offer_product_products as $pp_result) {
				if ($pp_result['one'] && (!in_array($pp_result['one'], $offer_products))) {
					$offer_products[] = $pp_result['one'];
				}

				if ($pp_result['two'] && (!in_array($pp_result['two'], $offer_products))) {
					$offer_products[] = $pp_result['two'];
				}
			}
		}

		// Product Category
		$offer_product_categories = $this->model_checkout_offers->getOfferProductCategories();

		if ($offer_product_categories) {
			foreach ($offer_product_categories as $pc_result) {
				if (($pc_result['one']) && (!in_array($pc_result['one'], $offer_products))) {
					$offer_products[] = $pc_result['one'];
				}

				$product_lists = array();

				$product_lists = $this->getCategoryProducts($pc_result['two']);

				if ($product_lists) {
					foreach ($product_lists as $pc_product) {
						if ($pc_product && (!in_array($pc_product, $offer_products))) {
							$offer_products[] = $pc_product;
						}
					}
				}
			}
		}

		// Category Product
		$offer_category_products = $this->model_checkout_offers->getOfferCategoryProducts();

		if ($offer_category_products) {
			foreach ($offer_category_products as $cp_result) {
				$product_lists = array();

				$product_lists = $this->getCategoryProducts($cp_result['one']);

				if ($product_lists) {
					foreach ($product_lists as $cp_product) {
						if (($cp_product) && (!in_array($cp_product, $offer_products))) {
							$offer_products[] = $cp_product;
						}
					}
				}

				if ($cp_result['two'] && (!in_array($cp_result['two'], $offer_products))) {
					$offer_products[] = $cp_result['two'];
				}
			}
		}

		// Category Category
		$offer_category_categories = $this->model_checkout_offers->getOfferCategoryCategories();

		if ($offer_category_categories) {
			foreach ($offer_category_categories as $cc_result) {
				$product_one_lists = array();

				$product_one_lists = $this->getCategoryProducts($cc_result['one']);

				if ($product_one_lists) {
					foreach ($product_one_lists as $product_one) {
						if ($product_one && (!in_array($product_one, $offer_products))) {
							$offer_products[] = $product_one;
						}
					}
				}

				$product_two_lists = array();

				$product_two_lists = $this->getCategoryProducts($cc_result['two']);

				if ($product_two_lists) {
					foreach ($product_two_lists as $product_two) {
						if ($product_two && (!in_array($product_two, $offer_products))) {
							$offer_products[] = $product_two;
						}
					}
				}
			}
		}

		return $offer_products;
	}

	// Product List from Category
	protected function getCategoryProducts($category_id) {
		$product_list = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE category_id = '" . (int)$category_id . "'");

		if ($query->num_rows) {
			foreach ($query->rows as $result) {
				$product_list[] = $result['product_id'];
			}
		}

		return $product_list;
	}

	// Product Image
	public function getOfferProductImage($product_id) {
		$query = $this->db->query("SELECT image FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "' AND status = '1'");

		return $query->row['image'];
	}

	// Product Name
	public function getOfferProductName($product_id) {
		$query = $this->db->query("SELECT pd.name AS name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.product_id = '" . (int)$product_id . "' AND p.status = '1'");

		return $query->row['name'];
	}
}
