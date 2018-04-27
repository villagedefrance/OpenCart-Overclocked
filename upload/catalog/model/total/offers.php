<?php
define('PRO_TO_PRO', '1');
define('PRO_TO_CAT', '2');
define('CAT_TO_CAT', '3');
define('CAT_TO_PRO', '4');

class Offer {
	var $item1;
	var $item2;
	var $type;
	var $amount;
	var $variation;
	var $isvalid;

	public function init($item1, $item2, $type, $amount, $variation) {
		$this->isvalid = 0;

		if ($type != "$" && $type != "%") {
			die("Unknown type " . $type);
		}

		if ($variation != PRO_TO_PRO && $variation != PRO_TO_CAT && $variation != CAT_TO_PRO && $variation != CAT_TO_CAT) {
			die("Unknown variation " . $variation);
		}

		$this->item1 = $item1;
		$this->item2 = $item2;
		$this->type = $type;
		$this->amount = $amount;
		$this->variation = $variation;
		$this->isvalid = 1;
	}

	public function getId() {
		return $this->item1;
	}
}

class ModelTotalOffers {
	protected $registry;

	public function __construct(Registry $registry) {
		$this->registry = $registry;
		$this->discount_list = array();
		$this->offers();
	}

	public function __get($name) {
		return $this->registry->get($name);
	}

	protected function getDiscount($discount_item, &$discountable_products, &$already_discounted_items = array(), $one_to_many = 0) {
		$discount_total = 0;

		$offer_taxes = $this->config->get('offers_taxes');

		for ($disc = 0, $n = count($this->discount_list); $disc < $n; $disc++) {
			$line = $this->discount_list[$disc];

			if (($line->variation == PRO_TO_PRO) || ($line->variation == PRO_TO_CAT)) {
				if ($line->item1 != $discount_item['product_id']) {
					continue;
				}
			} else {
				if (!in_array($line->item1, $discount_item['category_id'])) {
					continue;
				}
			}

			for ($i = sizeof($discountable_products) - 1; $i >= 0; $i--) {
				if ($discountable_products[$i]['quantity'] == 0) {
					continue;
				}

				$match = 0;

				if (($line->variation == PRO_TO_PRO) || ($line->variation == CAT_TO_PRO)) {
					if ($discountable_products[$i]['product_id'] == $line->item2) {
						$match = 1;
					}
				} else {
					if (in_array($line->item2, $discountable_products[$i]['category_id'])) {
						$match = 1;
					}
				}

				if ($match == 1 && $one_to_many != 0) {
					$pro_id = $discountable_products[$i]['product_id'];

					if ($one_to_many == 1) {
						if (in_array($pro_id, $already_discounted_items)) {
							continue;
						}

						$already_discounted_items[] = $pro_id;
					}
				}

				if ($match == 1) {
					$discountable_products[$i]['quantity'] -= 1;

					$discount_total = 0;

					if ($line->type == "$") {
						$product_amount = $line->amount;

						if ($offer_taxes && $product_amount > 0) {
							$discount_total = $this->tax->calculate($line->amount, $discountable_products[$i]['tax_class_id'], $this->config->get('config_tax'));
						} else {
							$discount_total = $line->amount;
						}

					} else {
						$product_amount = $discountable_products[$i]['price'] * $line->amount;

						if ($offer_taxes && $product_amount > 0) {
							$discount_total = $this->tax->calculate(($discountable_products[$i]['price'] * $line->amount), $discountable_products[$i]['tax_class_id'], $this->config->get('config_tax')) / 100;
						} else {
							$discount_total = $discountable_products[$i]['price'] * $line->amount;
						}
					}
				}
			}
		}

		return $discount_total;
	}

	public function getTotal(&$total_data, &$total, &$taxes) {
		$products = $this->cart->getProducts();

		reset($products);
		sort($products);

		$offer_taxes = $this->config->get('offers_taxes');

		$discountable_products = array();

		$this->load->model('checkout/offers');

		for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
			$products[$i]['category_id'] = $this->model_checkout_offers->getCategoryList($products[$i]['product_id']);

			$discountable_products[$i] = $products[$i];
		}

		$discount_total = 0;
		$one_to_many = 0;

		for ($i = 0, $n = sizeof($discountable_products); $i < $n; $i++) {
			$already_discounted_items = array();

			while ($discountable_products[$i]['quantity'] > 0) {
				if ($one_to_many == 0) {
					$discountable_products[$i]['quantity'] -= 1;
				}

				$item_discountable = $this->getDiscount($discountable_products[$i], $discountable_products, $already_discounted_items, $one_to_many);

				if ($item_discountable == 0) {
					if ($one_to_many == 0) {
						$discountable_products[$i]['quantity'] += 1;
						break;
					} else {
						if (sizeof($already_discounted_items) > 0) {
							$discountable_products[$i]['quantity'] -= 1;

							$already_discounted_items = array();
							continue;
						} else {
							break;
						}
					}

				} else {
					$discount_total += $item_discountable;

					if ($offer_taxes) {
						foreach ($products as $product) {
							if ($product['tax_class_id'] && $product['total'] > 0) {
								$tax_rates = $this->tax->getRates($product['total'], $product['tax_class_id']);

								foreach ($tax_rates as $tax_rate) {
									if (in_array($item_discountable, $products)) {
										$taxes[$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
									}
								}
							}
						}
					}
				}
			}
		}

		if ($discount_total > 0) {
			$this->language->load('total/offers');

			$total_data[] = array(
				'code'       => 'offers',
				'title'      => $this->language->get('text_offers'),
				'text'       => '-' . $this->currency->format($discount_total),
				'value'      => '-' . number_format($discount_total, 2, '.', ''),
				'sort_order' => $this->config->get('offers_sort_order')
			);

			$total -= number_format($discount_total, 2, '.', '');
		}
	}

	protected function addProToPro($item1, $item2, $type, $amount) {
		$add_to_list = new Offer;

		$add_to_list->init($item1, $item2, $type, $amount, PRO_TO_PRO);

		if ($add_to_list->isvalid == 1) {
			$this->discount_list[] =& $add_to_list;
		}
	}

	protected function addProToCat($item1, $item2, $type, $amount) {
		$add_to_list = new Offer;

		$add_to_list->init($item1, $item2, $type, $amount, PRO_TO_CAT);

		if ($add_to_list->isvalid == 1) {
			$this->discount_list[] =& $add_to_list;
		}
	}

	protected function addCatToCat($item1, $item2, $type, $amount) {
		$add_to_list = new Offer;

		$add_to_list->init($item1, $item2, $type, $amount, CAT_TO_CAT);

		if ($add_to_list->isvalid == 1) {
			$this->discount_list[] =& $add_to_list;
		}
	}

	protected function addCatToPro($item1, $item2, $type, $amount) {
		$add_to_list = new Offer;

		$add_to_list->init($item1, $item2, $type, $amount, CAT_TO_PRO);

		if ($add_to_list->isvalid == 1) {
			$this->discount_list[] =& $add_to_list;
		}
	}

	protected function offers() {
		$this->load->model('checkout/offers');

		// Product Product
		$offer_product_products = $this->model_checkout_offers->getOfferProductProducts();

		if ($offer_product_products) {
			foreach ($offer_product_products as $result) {
				if ($result['type'] == 'F') {
					$type = "$";
				} else {
					$type = "%";
				}

				$this->addProToPro($result['one'], $result['two'], $type, $result['disc']);
			}
		}

		// Product Category
		$offer_product_categories = $this->model_checkout_offers->getOfferProductCategories();

		if ($offer_product_categories) {
			foreach ($offer_product_categories as $result) {
				if ($result['type'] == 'F') {
					$type = "$";
				} else {
					$type = "%";
				}

				$this->addProToCat($result['one'], $result['two'], $type, $result['disc']);
			}
		}

		// Category Product
		$offer_category_products = $this->model_checkout_offers->getOfferCategoryProducts();

		if ($offer_category_products) {
			foreach ($offer_category_products as $result) {
				if ($result['type'] == 'F') {
					$type = "$";
				} else {
					$type = "%";
				}

				$this->addCatToPro($result['one'], $result['two'], $type, $result['disc']);
			}
		}

		// Category Category
		$offer_category_categories = $this->model_checkout_offers->getOfferCategoryCategories();

		if ($offer_category_categories) {
			foreach ($offer_category_categories as $result) {
				if ($result['type'] == 'F') {
					$type = "$";
				} else {
					$type = "%";
				}

				$this->addCatToCat($result['one'], $result['two'], $type, $result['disc']);
			}
		}
	}
}
