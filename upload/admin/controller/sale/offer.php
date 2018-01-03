<?php
class ControllerSaleOffer extends Controller {

	public function index() {
		$this->language->load('sale/offer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_overview'] = $this->language->get('text_overview');
		$this->data['text_quicklinks'] = $this->language->get('text_quicklinks');
		$this->data['text_status'] = $this->language->get('text_status');

		$this->data['text_total_offers'] = $this->language->get('text_total_offers');
		$this->data['text_total_p2p'] = $this->language->get('text_total_p2p');
		$this->data['text_total_p2c'] = $this->language->get('text_total_p2c');
		$this->data['text_total_c2p'] = $this->language->get('text_total_c2p');
		$this->data['text_total_c2c'] = $this->language->get('text_total_c2c');

		$this->data['text_total_discount'] = $this->language->get('text_total_discount');
		$this->data['text_total_special'] = $this->language->get('text_total_special');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['button_exit'] = $this->language->get('button_exit');

		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		// Breadcrumbs
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/offer', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['token'] = $this->session->data['token'];

		// Check if Order Totals Offers is enabled
		$this->load->model('setting/extension');

		$offers_status = $this->config->get('offers_status');

		if (!$offers_status) {
			$this->data['error_offers'] = $this->language->get('error_offers');
		} else {
			$this->data['error_offers'] = '';
		}

		if ($offers_status) {
			$this->data['success_offers'] = sprintf($this->language->get('success_offers'), $this->config->get('offers_sort_order'));
		} else {
			$this->data['success_offers'] = '';
		}

		// Overview
		$this->load->model('sale/offer');

		$this->data['total_p2p'] = $this->model_sale_offer->getTotalOfferProductProduct();
		$this->data['total_p2c'] = $this->model_sale_offer->getTotalOfferProductCategory();
		$this->data['total_c2p'] = $this->model_sale_offer->getTotalOfferCategoryProduct();
		$this->data['total_c2c'] = $this->model_sale_offer->getTotalOfferCategoryCategory();

		$this->data['total_offers'] = $this->data['total_p2p'] + $this->data['total_p2c'] + $this->data['total_c2p'] + $this->data['total_c2c'];

		$this->data['total_discount'] = $this->model_sale_offer->getTotalProductDiscounts();
		$this->data['total_special'] = $this->model_sale_offer->getTotalProductSpecials();

		// Quicklinks
		$this->data['text_p2p'] = $this->language->get('text_p2p');
		$this->data['text_p2c'] = $this->language->get('text_p2c');
		$this->data['text_c2p'] = $this->language->get('text_c2p');
		$this->data['text_c2c'] = $this->language->get('text_c2c');

		$this->data['link_p2p'] = $this->url->link('sale/offer_product_product', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['link_p2c'] = $this->url->link('sale/offer_product_category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['link_c2p'] = $this->url->link('sale/offer_category_product', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['link_c2c'] = $this->url->link('sale/offer_category_category', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['button_view'] = $this->language->get('button_view');

		// Status
		$this->data['column_group'] = $this->language->get('column_group');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_logged'] = $this->language->get('column_logged');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_validity'] = $this->language->get('column_validity');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$date_now = date('Y-m-d');
		$date_week = date('Y-m-d', strtotime('+7 day'));

		$this->data['button_edit'] = $this->language->get('button_edit');

		// P2P
		$this->data['offer_product_products'] = array();

		$product_product_infos = $this->model_sale_offer->getOfferProductProducts(0);

		if ($product_product_infos) {
			foreach ($product_product_infos as $result) {
				$end_date = date('Y-m-d', strtotime($result['date_end']));

				if ($end_date <= $date_now) {
					$validity = $this->language->get('text_offer_expired');
				} elseif ($end_date <= $date_week) {
					$validity = $this->language->get('text_offer_expiring');
				} else {
					$validity = $this->language->get('text_offer_valid');
				}

				$this->data['offer_product_products'][] = array(
					'group'    => 'P2P',
					'name'     => $result['name'],
					'type'     => $result['type'],
					'discount' => $result['discount'],
					'logged'   => $result['logged'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
					'date_end' => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
					'validity' => $validity,
					'status'   => $result['status'],
					'href'     => $this->url->link('sale/offer_product_product/update', 'token=' . $this->session->data['token'] . '&offer_product_product_id=' . $result['offer_product_product_id'], 'SSL')
				);
			}

		} else {
			$this->data['offer_product_products'] = false;
		}

		// P2C
		$this->data['offer_product_categories'] = array();

		$product_category_infos = $this->model_sale_offer->getOfferProductCategories(0);

		if ($product_category_infos) {
			foreach ($product_category_infos as $result) {
				$end_date = date('Y-m-d', strtotime($result['date_end']));

				if ($end_date <= $date_now) {
					$validity = $this->language->get('text_offer_expired');
				} elseif ($end_date <= $date_week) {
					$validity = $this->language->get('text_offer_expiring');
				} else {
					$validity = $this->language->get('text_offer_valid');
				}

				$this->data['offer_product_categories'][] = array(
					'group'    => 'P2C',
					'name'     => $result['name'],
					'type'     => $result['type'],
					'discount' => $result['discount'],
					'logged'   => $result['logged'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
					'date_end' => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
					'validity' => $validity,
					'status'   => $result['status'],
					'href'     => $this->url->link('sale/offer_product_category/update', 'token=' . $this->session->data['token'] . '&offer_product_category_id=' . $result['offer_product_category_id'], 'SSL')
				);
			}

		} else {
			$this->data['offer_product_categories'] = false;
		}

		// C2P
		$this->data['offer_category_products'] = array();

		$category_product_infos = $this->model_sale_offer->getOfferCategoryProducts(0);

		if ($category_product_infos) {
			foreach ($category_product_infos as $result) {
				$end_date = date('Y-m-d', strtotime($result['date_end']));

				if ($end_date <= $date_now) {
					$validity = $this->language->get('text_offer_expired');
				} elseif ($end_date <= $date_week) {
					$validity = $this->language->get('text_offer_expiring');
				} else {
					$validity = $this->language->get('text_offer_valid');
				}

				$this->data['offer_category_products'][] = array(
					'group'    => 'C2P',
					'name'     => $result['name'],
					'type'     => $result['type'],
					'discount' => $result['discount'],
					'logged'   => $result['logged'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
					'date_end' => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
					'validity' => $validity,
					'status'   => $result['status'],
					'href'     => $this->url->link('sale/offer_category_product/update', 'token=' . $this->session->data['token'] . '&offer_category_product_id=' . $result['offer_category_product_id'], 'SSL')
				);
			}

		} else {
			$this->data['offer_category_products'] = false;
		}

		// C2C
		$this->data['offer_category_categories'] = array();

		$category_category_infos = $this->model_sale_offer->getOfferCategoryCategories(0);

		if ($category_category_infos) {
			foreach ($category_category_infos as $result) {
				$end_date = date('Y-m-d', strtotime($result['date_end']));

				if ($end_date <= $date_now) {
					$validity = $this->language->get('text_offer_expired');
				} elseif ($end_date <= $date_week) {
					$validity = $this->language->get('text_offer_expiring');
				} else {
					$validity = $this->language->get('text_offer_valid');
				}

				$this->data['offer_category_categories'][] = array(
					'group'    => 'C2C',
					'name'     => $result['name'],
					'type'     => $result['type'],
					'discount' => $result['discount'],
					'logged'   => $result['logged'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
					'date_end' => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
					'validity' => $validity,
					'status'   => $result['status'],
					'href'     => $this->url->link('sale/offer_category_category/update', 'token=' . $this->session->data['token'] . '&offer_category_category_id=' . $result['offer_category_category_id'], 'SSL')
				);
			}

		} else {
			$this->data['offer_category_categories'] = false;
		}

		$this->template = 'sale/offer.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
