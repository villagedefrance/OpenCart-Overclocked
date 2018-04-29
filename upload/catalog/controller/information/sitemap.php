<?php
class ControllerInformationSitemap extends Controller {

	public function index() {
		$this->language->load('information/sitemap');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/sitemap', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_cart'] = $this->language->get('text_cart');
		$this->data['text_checkout'] = $this->language->get('text_checkout');

		$this->data['text_product_list'] = $this->language->get('text_product_list');
		$this->data['text_product_wall'] = $this->language->get('text_product_wall');
		$this->data['text_category_list'] = $this->language->get('text_category_list');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_review_list'] = $this->language->get('text_review_list');
		$this->data['text_search'] = $this->language->get('text_search');

		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_login'] = $this->language->get('text_login');
		$this->data['text_edit'] = $this->language->get('text_edit');
		$this->data['text_password'] = $this->language->get('text_password');
		$this->data['text_address'] = $this->language->get('text_address');
		$this->data['text_wishlist'] = $this->language->get('text_wishlist');
		$this->data['text_history'] = $this->language->get('text_history');
		$this->data['text_transaction'] = $this->language->get('text_transaction');
		$this->data['text_download'] = $this->language->get('text_download');
		$this->data['text_addreturn'] = $this->language->get('text_addreturn');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_reward'] = $this->language->get('text_reward');
		$this->data['text_giftvoucher'] = $this->language->get('text_giftvoucher');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');

		$this->data['text_affiliate_account'] = $this->language->get('text_affiliate_account');
		$this->data['text_affiliate_login'] = $this->language->get('text_affiliate_login');
		$this->data['text_affiliate_edit'] = $this->language->get('text_affiliate_edit');
		$this->data['text_affiliate_password'] = $this->language->get('text_affiliate_password');
		$this->data['text_affiliate_payment'] = $this->language->get('text_affiliate_payment');
		$this->data['text_affiliate_product'] = $this->language->get('text_affiliate_product');
		$this->data['text_affiliate_tracking'] = $this->language->get('text_affiliate_tracking');
		$this->data['text_affiliate_transaction'] = $this->language->get('text_affiliate_transaction');

		$this->data['text_information'] = $this->language->get('text_information');
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_quote'] = $this->language->get('text_quote');
		$this->data['text_contact'] = $this->language->get('text_contact');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$this->data['sitemap_links'] = $this->config->get('config_sitemap_links');

		$empty_category = $this->config->get('config_empty_category');

		$this->data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$data = array(
						'filter_category_id'  => $category_3['category_id'],
						'filter_sub_category' => true
					);

					if (!$empty_category) {
						$product_total = $this->model_catalog_product->getTotalProducts($data);
					} else {
						$product_total = 0;
					}

					if ($empty_category || $product_total > 0) {
						$level_3_data[] = array(
							'name' => $category_3['name'],
							'href' => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'], 'SSL')
						);
					}
				}

				$level_2_data[] = array(
					'name'     => $category_2['name'],
					'children' => $level_3_data,
					'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'], 'SSL')
				);
			}

			$this->data['categories'][] = array(
				'name'     => $category_1['name'],
				'children' => $level_2_data,
				'href'     => $this->url->link('product/category', 'path=' . $category_1['category_id'], 'SSL')
			);
		}

		$this->data['cart'] = $this->url->link('checkout/cart', '', 'SSL');
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

		$this->data['product_list'] = $this->url->link('product/product_list', '', 'SSL');
		$this->data['product_wall'] = $this->url->link('product/product_wall', '', 'SSL');
		$this->data['category_list'] = $this->url->link('product/category_list', '', 'SSL');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special', '', 'SSL');
		$this->data['review_list'] = $this->url->link('product/review_list', '', 'SSL');
		$this->data['search'] = $this->url->link('product/search', '', 'SSL');

		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['login'] = $this->url->link('account/login', '', 'SSL');
		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['history'] = $this->url->link('account/order', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['addreturn'] = $this->url->link('account/return/insert', '', 'SSL');
		$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		$this->data['giftvoucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$this->data['affiliate_account'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['affiliate_login'] =$this->url->link('affiliate/login', '', 'SSL');
		$this->data['affiliate_edit'] = $this->url->link('affiliate/edit', '', 'SSL');
		$this->data['affiliate_password'] = $this->url->link('affiliate/password', '', 'SSL');
		$this->data['affiliate_payment'] = $this->url->link('affiliate/payment', '', 'SSL');
		$this->data['affiliate_product'] = $this->url->link('affiliate/product', '', 'SSL');
		$this->data['affiliate_tracking'] = $this->url->link('affiliate/tracking', '', 'SSL');
		$this->data['affiliate_transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');

		$this->data['sitemap'] = $this->url->link('information/sitemap', '', 'SSL');
		$this->data['news'] = $this->url->link('information/news_list', '', 'SSL');
		$this->data['quote'] = $this->url->link('information/quote', '', 'SSL');
		$this->data['contact'] = $this->url->link('information/contact', '', 'SSL');

		$this->load->model('catalog/information');

		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			$this->data['informations'][] = array(
				'title' => $result['title'],
				'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'], 'SSL')
			);
		}

		// Returns
		if ($this->config->get('config_return_disable')) {
			$this->data['allow_return'] = false;
		} else {
			$this->data['allow_return'] = true;
		}

		// Affiliates
		if ($this->config->get('config_affiliate_disable')) {
			$this->data['allow_affiliate'] = false;
		} else {
			$this->data['allow_affiliate'] = true;
		}

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/sitemap.tpl';
		} else {
			$this->template = 'default/template/information/sitemap.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}
}
