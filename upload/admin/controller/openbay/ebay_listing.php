<?php
class ControllerOpenbayEbayListing extends Controller {
	private $error = array();

	public function bulkStep1() {
		$this->load->language('openbay/ebay_listing');
		$this->load->model('catalog/category');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->post['selected']) || empty($this->request->post['selected'])) {
				$this->error['warning'] = $this->language->get('error_select_category');
			} else {
				$this->session->data['bulk_category_list']['categories'] = $this->request->post['selected'];

				$this->redirect($this->url->link('openbay/ebay_listing/bulkstep2', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['selected_categories'] = isset($this->session->data['bulk_category_list']['categories']) ? $this->session->data['bulk_category_list']['categories'] : array();

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/openbay.css');
		$this->document->addScript('view/javascript/openbay/faq.js');

		$this->template = 'openbay/ebay_bulk_step1.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->data['url_return']  = $this->url->link('openbay/ebay/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['form_action'] = $this->url->link('openbay/ebay_listing/bulkstep1', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['error_select_category'] = $this->language->get('error_select_category');
		$this->data['text_category'] = $this->language->get('text_category');

		$this->data['token'] = $this->session->data['token'];

		$this->data['categories'] = $this->model_catalog_category->getCategories(array());

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_openbay'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_ebay'),
			'separator' => ' :: '
		);

		$status = $this->openbay->ebay->call('lms/status/', array());

		if ($status['bulk_listing'] == 0) {
			$this->error['warning'] = $this->language->get('error_permission_bulk');
		}

		if ($status['active_jobs'] == 1) {
			$this->error['warning'] = $this->language->get('error_active_jobs');
		}

		$this->data['available'] = '';

		if (isset($status['available']) && $status['available'] < 1) {
			$this->error['warning'] = $this->language->get('error_limit_available');
		} elseif (isset($status['available']) && $status['available'] > 0) {
			$this->data['available'] = sprintf($this->language->get('text_available'), $status['available']);
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	public function bulkStep2() {
		$this->load->language('openbay/ebay_listing');
		$this->load->model('catalog/product');

		if (!isset($this->session->data['bulk_category_list']['categories']) || empty($this->session->data['bulk_category_list']['categories'])) {
			$this->redirect($this->url->link('openbay/ebay_listing/bulkstep1', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->post['selected']) || empty($this->request->post['selected'])) {
				$this->error['warning'] = $this->language->get('error_select_product');
			} else {
				$this->session->data['bulk_category_list']['products'] = $this->request->post['selected'];

				$this->redirect($this->url->link('openbay/ebay_listing/bulkstep3', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['selected_products'] = isset($this->session->data['bulk_category_list']['products']) ? $this->session->data['bulk_category_list']['products'] : array();

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/openbay.css');
		$this->document->addScript('view/javascript/openbay/faq.js');

		$this->template = 'openbay/ebay_bulk_step2.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->data['url_return']  = $this->url->link('openbay/ebay/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']  = $this->url->link('openbay/ebay_listing/bulkstep1', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['form_action'] = $this->url->link('openbay/ebay_listing/bulkstep2', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_model'] = $this->language->get('text_model');
		$this->data['text_price'] = $this->language->get('text_price');
		$this->data['text_quantity'] = $this->language->get('text_quantity');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_fail_reason'] = $this->language->get('text_fail_reason');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['error_select_category'] = $this->language->get('error_select_category');

		$this->data['token'] = $this->session->data['token'];

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_openbay'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_ebay'),
			'separator' => ' :: '
		);

		$categories = $this->session->data['bulk_category_list']['categories'];

		$ebay_active = $this->openbay->ebay->getLiveListingArray();

		$products = array();
		$products_fail = array();

		foreach ($categories as $category_id) {
			$category_products = $this->model_catalog_product->getProductsByCategoryId($category_id);

			foreach ($category_products as $category_product) {
				if (!array_key_exists($category_product['product_id'], $products)) {
					// can't list due to stock
					if ($category_product['quantity'] < 1) {
						$products_fail[$category_product['product_id']] = array(
							'name' => $category_product['name'],
							'price' => $category_product['price'],
							'model' => $category_product['model'],
							'quantity' => $category_product['quantity'],
							'reason' => $this->language->get('error_no_stock'),
						);
					} elseif ($category_product['price'] < 1) {
						$products_fail[$category_product['product_id']] = array(
							'name' => $category_product['name'],
							'price' => $category_product['price'],
							'model' => $category_product['model'],
							'quantity' => $category_product['quantity'],
							'reason' => $this->language->get('error_price'),
						);
					} elseif (strlen($category_product['name']) > 75) {
						$products_fail[$category_product['product_id']] = array('name' => $category_product['name'], 'price' => $category_product['price'], 'model' => $category_product['model'], 'quantity' => $category_product['quantity'], 'reason' => $this->language->get('error_title_length'),);
					//} elseif () { // check the image size

					} elseif (array_key_exists($category_product['product_id'], $ebay_active)) {
						$products_fail[$category_product['product_id']] = array(
							'name' => $category_product['name'],
							'price' => $category_product['price'],
							'model' => $category_product['model'],
							'quantity' => $category_product['quantity'],
							'reason' => $this->language->get('error_existing_item'),
						);
					} else {
						$products[$category_product['product_id']] = array(
							'name' => $category_product['name'],
							'price' => $category_product['price'],
							'model' => $category_product['model'],
							'quantity' => $category_product['quantity'],
						);
					}
				}
			}
		}

		$this->data['products'] = $products;
		$this->data['products_count'] = count($products);
		$this->data['text_products_count'] = sprintf($this->language->get('text_available_to_list'), count($products));

		$this->data['products_fail'] = $products_fail;
		$this->data['products_fail_count'] = count($products_fail);
		$this->data['text_products_fail_count'] = sprintf($this->language->get('text_unavailable_to_list'), count($products_fail));

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if ($this->data['products_count'] == 0) {
			$this->data['error_warning'] = $this->language->get('error_no_products');
		}

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	public function bulkStep3() {
		$this->load->language('openbay/ebay_listing');
		$this->load->model('openbay/ebay');
		$this->load->model('openbay/ebay_profile');

		if (!isset($this->session->data['bulk_category_list']['products']) || empty($this->session->data['bulk_category_list']['products'])) {
			$this->redirect($this->url->link('openbay/ebay_listing/bulkstep1', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->post['category_id']) || empty($this->request->post['category_id'])) {
				$this->error['warning'] = $this->language->get('error_select_ebay_category');
			} else {
				$this->model_openbay_ebay->logCategoryUsed($this->request->post['category_id']);

				$this->session->data['bulk_category_list']['ebay_data'] = $this->request->post;

				$this->redirect($this->url->link('openbay/ebay_listing/bulkstep4', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->document->setTitle($this->language->get('heading_title'));
		$this->document->addStyle('view/stylesheet/openbay.css');
		$this->document->addScript('view/javascript/openbay/faq.js');

		$this->template = 'openbay/ebay_bulk_step3.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->data['url_return']  = $this->url->link('openbay/ebay/dashboard', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['url_back']  = $this->url->link('openbay/ebay_listing/bulkstep2', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['form_action'] = $this->url->link('openbay/ebay_listing/bulkstep3', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['button_submit'] = $this->language->get('button_submit');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['error_ajax_noload'] = $this->language->get('error_ajax_noload');
		$this->data['error_category_sync'] = $this->language->get('error_category_sync');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_other'] = $this->language->get('text_other');
		$this->data['text_feature_loading'] = $this->language->get('text_feature_loading');
		$this->data['entry_category_features'] = $this->language->get('entry_category_features');
		$this->data['entry_listing_condition'] = $this->language->get('entry_listing_condition');
		$this->data['entry_listing_duration'] = $this->language->get('entry_listing_duration');
		$this->data['entry_profile_shipping'] = $this->language->get('entry_profile_shipping');
		$this->data['entry_profile_returns'] = $this->language->get('entry_profile_returns');
		$this->data['entry_profile_theme'] = $this->language->get('entry_profile_theme');
		$this->data['entry_profile_generic'] = $this->language->get('entry_profile_generic');
		$this->data['entry_category_popular'] = $this->language->get('entry_category_popular');
		$this->data['entry_mapping_choose'] = $this->language->get('entry_mapping_choose');
		$this->data['text_listing_1day'] = $this->language->get('text_listing_1day');
		$this->data['text_listing_3day'] = $this->language->get('text_listing_3day');
		$this->data['text_listing_5day'] = $this->language->get('text_listing_5day');
		$this->data['text_listing_7day'] = $this->language->get('text_listing_7day');
		$this->data['text_listing_10day'] = $this->language->get('text_listing_10day');
		$this->data['text_listing_30day'] = $this->language->get('text_listing_30day');
		$this->data['text_listing_gtc'] = $this->language->get('text_listing_gtc');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['help_category_popular'] = $this->language->get('help_category_popular');

		$this->data['profiles']['shipping'] = $this->model_openbay_ebay_profile->getAll(0);
		$this->data['profiles']['shipping_default'] = $this->model_openbay_ebay_profile->getDefault(0);

		$this->data['profiles']['returns'] = $this->model_openbay_ebay_profile->getAll(1);
		$this->data['profiles']['returns_default'] = $this->model_openbay_ebay_profile->getDefault(1);

		$this->data['profiles']['theme'] = $this->model_openbay_ebay_profile->getAll(2);
		$this->data['profiles']['theme_default'] = $this->model_openbay_ebay_profile->getDefault(2);

		$this->data['profiles']['generic'] = $this->model_openbay_ebay_profile->getAll(3);
		$this->data['profiles']['generic_default'] = $this->model_openbay_ebay_profile->getDefault(3);

		$this->data['defaults']['listing_duration'] = $this->config->get('openbaypro_duration');
		if ($this->data['defaults']['listing_duration'] == '') {
			$this->data['defaults']['listing_duration'] = 'Days_30';
		}

		$this->data['popular_categories'] = $this->model_openbay_ebay->getPopularCategories();

		$this->data['token'] = $this->session->data['token'];

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_openbay'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'href' => $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL'),
			'text' => $this->language->get('text_ebay'),
			'separator' => ' :: '
		);

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
	}

	public function bulkStep4() {
		$this->load->language('openbay/ebay_listing');
		$this->load->model('openbay/ebay');
		$this->load->model('openbay/ebay_profile');
		$this->load->model('openbay/ebay_template');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		if (isset($this->session->data['bulk_category_list']['ebay_data'])) {
			$bulk_data = array();

			//load all of the listing defaults and assign to correct variable names
			$profile_shipping = $this->model_openbay_ebay_profile->get($this->session->data['bulk_category_list']['ebay_data']['profile_shipping']);
			$profile_return = $this->model_openbay_ebay_profile->get($this->session->data['bulk_category_list']['ebay_data']['profile_returns']);
			$profile_template = $this->model_openbay_ebay_profile->get($this->session->data['bulk_category_list']['ebay_data']['profile_theme']);
			$profile_generic = $this->model_openbay_ebay_profile->get($this->session->data['bulk_category_list']['ebay_data']['profile_generic']);
			$payments = $this->model_openbay_ebay->getPaymentTypes();
			$payments_accepted = $this->config->get('ebay_payment_types');

			/**
			 * get the eBay category features again if auto-mapping
			 */
			$recommendation_data_names = array();
			$recommendation_data_values = array();

			if ($this->session->data['bulk_category_list']['ebay_data']['auto_mapping'] == 1) {
				$category_specifics = $this->model_openbay_ebay->getEbayCategorySpecifics($this->session->data['bulk_category_list']['ebay_data']['category_id']);

				if (isset($category_specifics['data']['Recommendations']['NameRecommendation'])) {
					$recommendation_count = 1;

					foreach($category_specifics['data']['Recommendations']['NameRecommendation'] as $name_recommendation_key => $name_recommendation) {
						$recommendation_data_names[$recommendation_count] = strtolower((string)$name_recommendation['Name']);

						$recommendation_data_option = array(
							'max_values' => (int)$name_recommendation['ValidationRules']['MaxValues'],
							'selection_mode' => (string)$name_recommendation['ValidationRules']['SelectionMode'],
							'options' => array(),
						);

						if (isset($name_recommendation['ValueRecommendation'])) {
							if (!isset($name_recommendation['ValueRecommendation']['Value'])) {
								foreach($name_recommendation['ValueRecommendation'] as $value_recommendation_key => $value_recommendation) {
									$recommendation_data_option['options'][] = strtolower((string)$value_recommendation['Value']);
								}
							}
						}

						$recommendation_data_values[$recommendation_count] = $recommendation_data_option;

						$recommendation_count++;
					}
				}
			}

			foreach($this->session->data['bulk_category_list']['products'] as $product_id) {
				$product_data = array();

				$product_info = $this->model_catalog_product->getProduct($product_id);

				$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				$product_data['product_info'] 		= $query->row;

				$product_data['description'] 		= $product_info['description'];
				$product_data['name'] 				= $product_info['name'];
				$product_data['sub_name'] 			= '';
				$product_data['bestoffer'] 			= 0;
				$product_data['category_id'] 		= $this->session->data['bulk_category_list']['ebay_data']['category_id'];
				$product_data['price'][0] 			= $product_info['price'];
				$product_data['qty'][0] 			= (int)$product_info['quantity'];
				$product_data['product_id'] 		= (int)$product_id;
				$product_data['feat'] 				= !empty($this->session->data['bulk_category_list']['ebay_data']['feat']) ? $this->session->data['bulk_category_list']['ebay_data']['feat'] : array();
				$product_data['featother'] 			= !empty($this->session->data['bulk_category_list']['ebay_data']['featother']) ? $this->session->data['bulk_category_list']['ebay_data']['featother'] : array();
				$product_data['auction_duration'] 	= $this->session->data['bulk_category_list']['ebay_data']['auction_duration'];
				$product_data['condition'] 			= (isset($this->session->data['bulk_category_list']['ebay_data']['condition']) && $this->session->data['bulk_category_list']['ebay_data']['condition'] != 0 ? $this->session->data['bulk_category_list']['ebay_data']['condition'] : '');
				$product_data['auction_type'] 		= 'FixedPriceItem';
				$product_data['catalog_epid'] 		= '';
				$product_data['payment_immediate'] 	= $this->config->get('payment_immediate');
				$product_data['paypal_email'] 		= $this->config->get('field_payment_paypal_address');
				$product_data['payment_instruction'] = $this->config->get('field_payment_instruction');

				if (!empty($product_info['sku'])) {
					$product_data['sku'] = $product_info['sku'];
				}

				if (isset($profile_return['data']['returns_accepted'])) {
					$product_data['returns_accepted'] = $profile_return['data']['returns_accepted'];
				}
				if (isset($profile_return['data']['returns_policy'])) {
					$product_data['return_policy'] = $profile_return['data']['returns_policy'];
				}
				if (isset($profile_return['data']['returns_option'])) {
					$product_data['returns_option'] = $profile_return['data']['returns_option'];
				}
				if (isset($profile_return['data']['returns_within'])) {
					$product_data['returns_within'] = $profile_return['data']['returns_within'];
				}
				if (isset($profile_return['data']['returns_shipping'])) {
					$product_data['returns_shipping'] = $profile_return['data']['returns_shipping'];
				}
				if (isset($profile_return['data']['returns_restocking_fee'])) {
					$product_data['returns_restocking_fee'] = $profile_return['data']['returns_restocking_fee'];
				}

				$product_data['location'] 			= $profile_shipping['data']['location'];
				$product_data['postcode'] 			= $profile_shipping['data']['postcode'];
				$product_data['dispatch_time'] 		= $profile_shipping['data']['dispatch_time'];
				$product_data['get_it_fast'] 		= (isset($profile_shipping['data']['get_it_fast']) ? $profile_shipping['data']['get_it_fast'] : 0);

				if (isset($profile_shipping['data']['country'])) {
					$product_data['country'] = $profile_shipping['data']['country'];
				}

				if (isset($profile_template['data']['ebay_template_id'])) {
					$template = $this->model_openbay_ebay_template->get($profile_template['data']['ebay_template_id']);
					$product_data['template_html'] = (isset($template['html']) ? base64_encode($template['html']) : '');
					$product_data['template'] = $profile_template['data']['ebay_template_id'];
				} else {
					$product_data['template_html'] = '';
					$product_data['template'] = '';
				}

				$product_data['gallery_plus'] 		= $profile_template['data']['ebay_gallery_plus'];
				$product_data['gallery_super'] 		= $profile_template['data']['ebay_supersize'];
				$product_data['private_listing'] 	= $profile_generic['data']['private_listing'];
				$product_data['attributes'] 		= base64_encode(json_encode($this->model_openbay_ebay->getProductAttributes($product_id)));

				$product_data['payments'] = array();
				foreach($payments as $payment) {
					if ($payments_accepted[$payment['ebay_name']] == 1) {
						$product_data['payments'][$payment['ebay_name']] = 1;
					}
				}

				$product_data['main_image'] 		= 0;
				$product_data['img'] 				= array();

				$product_images 					= $this->model_catalog_product->getProductImages($product_id);
				$product_info['product_images'] 	= array();

				if (!empty($product_info['image'])) {
					$product_data['img'][] = $product_info['image'];
				}

				if (isset($profile_template['data']['ebay_img_ebay']) && $profile_template['data']['ebay_img_ebay'] == 1) {
					foreach($product_images as $product_image) {
						if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
							$product_data['img'][] = $product_image['image'];
						}
					}
				}

				if (isset($profile_template['data']['ebay_img_template']) && $profile_template['data']['ebay_img_template'] == 1) {
					$tmp_gallery_array = array();
					$tmp_thumb_array = array();

					//if the user has not set the exclude default image, add it to the array for theme images.
					$key_offset = 0;
					if (!isset($profile_template['data']['default_img_exclude']) || $profile_template['data']['default_img_exclude'] != 1) {
						$tmp_gallery_array[0] = $this->model_tool_image->resize($product_info['image'], $profile_template['data']['ebay_gallery_width'], $profile_template['data']['ebay_gallery_height']);
						$tmp_thumb_array[0] = $this->model_tool_image->resize($product_info['image'], $profile_template['data']['ebay_thumb_width'], $profile_template['data']['ebay_thumb_height']);
						$key_offset = 1;
					}

					//loop through the product images and add them.
					foreach($product_images as $k => $v) {
						$tmp_gallery_array[$k + $key_offset] = $this->model_tool_image->resize($v['image'], $profile_template['data']['ebay_gallery_width'], $profile_template['data']['ebay_gallery_height']);
						$tmp_thumb_array[$k + $key_offset] = $this->model_tool_image->resize($v['image'], $profile_template['data']['ebay_thumb_width'], $profile_template['data']['ebay_thumb_height']);
					}

					$product_data['img_tpl'] = $tmp_gallery_array;
					$product_data['img_tpl_thumb'] = $tmp_thumb_array;
				}

				if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
					$product_data['image_location'] = HTTPS_CATALOG . 'image/';
				} else {
					$product_data['image_location'] = HTTP_CATALOG . 'image/';
				}

				$product_attributes = $this->model_openbay_ebay->getProductAttributes($product_id);

				$product_data['attributes'] = base64_encode(json_encode($product_attributes));

				if ($this->session->data['bulk_category_list']['ebay_data']['auto_mapping'] == 1) {
					$product_data['feat'] = array();
					$product_data['featother'] = array();

					if (!empty($product_attributes)) {
						foreach ($product_attributes as $product_attribute_group) {
							if (!empty($product_attribute_group['attribute'])) {
								foreach ($product_attribute_group['attribute'] as $product_attribute) {
									if (in_array(strtolower($product_attribute['name']), $recommendation_data_names)) {
										// get the array key
										$attribute_key = array_search(strtolower($product_attribute['name']), $recommendation_data_names);

										if (in_array(strtolower($product_attribute['text']), $recommendation_data_values[$attribute_key]['options'])) {
											$product_data['feat'][$product_attribute['name']] = $product_attribute['text'];
										} else {
											if ($recommendation_data_values[$attribute_key]['selection_mode'] == 'FreeText') {
												$product_data['feat'][$product_attribute['name']] = 'Other';
												$product_data['featother'][$product_attribute['name']] = $product_attribute['text'];
											}
										}
									}
								}
							}
						}
					}
				} else {
					$product_data['feat'] = !empty($this->session->data['bulk_category_list']['ebay_data']['feat']) ? $this->session->data['bulk_category_list']['ebay_data']['feat'] : array();
					$product_data['featother'] = !empty($this->session->data['bulk_category_list']['ebay_data']['featother']) ? $this->session->data['bulk_category_list']['ebay_data']['featother'] : array();
				}

				$product_data = array_merge($product_data, $profile_shipping['data']);

				$bulk_data[(int)$product_id] = $product_data;
			}

			$this->data['response'] = $this->openbay->ebay->call('lms/create/', $bulk_data);

			$this->data['success'] = '';

			if ($this->openbay->ebay->lasterror == true) {
				$this->error['warning'] = $this->openbay->ebay->lastmsg;
			} else {
				$this->data['success'] = $this->openbay->ebay->lastmsg;
			}

			unset($this->session->data['bulk_category_list']);

			$this->document->setTitle($this->language->get('heading_title'));
			$this->document->addStyle('view/stylesheet/openbay.css');
			$this->document->addScript('view/javascript/openbay/faq.js');

			$this->template = 'openbay/ebay_bulk_step4.tpl';

			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->data['url_return']  = $this->url->link('openbay/ebay/dashboard', 'token=' . $this->session->data['token'], 'SSL');

			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['button_cancel'] = $this->language->get('button_cancel');
			$this->data['text_success'] = $this->language->get('text_success');
			$this->data['error_upload_fail'] = $this->language->get('error_upload_fail');

			$this->data['token'] = $this->session->data['token'];

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'text' => $this->language->get('text_home'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'href' => $this->url->link('extension/openbay', 'token=' . $this->session->data['token'], 'SSL'),
				'text' => $this->language->get('text_openbay'),
				'separator' => ' :: '
			);

			$this->data['breadcrumbs'][] = array(
				'href' => $this->url->link('openbay/openbay', 'token=' . $this->session->data['token'], 'SSL'),
				'text' => $this->language->get('text_ebay'),
				'separator' => ' :: '
			);

			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} else {
				$this->data['error_warning'] = '';
			}

			$this->response->setOutput($this->render(true), $this->config->get('config_compression'));
		} else {
			$this->redirect($this->url->link('openbay/ebay_listing/bulkstep1', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}