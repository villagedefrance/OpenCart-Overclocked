<?php 
//------------------------
// Overclocked Edition		
//------------------------

class ControllerInformationSitemap extends Controller { 

	public function index() { 

		$this->language->load('information/sitemap'); 

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->data['breadcrumbs'] = array(); 

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		); 

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/sitemap'),
			'separator' => $this->language->get('text_separator')
		); 

		$this->data['heading_title'] = $this->language->get('heading_title'); 

		$this->data['text_cart'] = $this->language->get('text_cart'); 
		$this->data['text_checkout'] = $this->language->get('text_checkout'); 

		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer'); 
		$this->data['text_special'] = $this->language->get('text_special'); 
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
		$this->data['text_affiliate_tracking'] = $this->language->get('text_affiliate_tracking'); 
		$this->data['text_affiliate_transaction'] = $this->language->get('text_affiliate_transaction'); 

		$this->data['text_information'] = $this->language->get('text_information'); 
		$this->data['text_contact'] = $this->language->get('text_contact'); 

		$this->load->model('catalog/category'); 
		$this->load->model('catalog/product'); 

		$this->data['categories'] = array(); 

		$categories_1 = $this->model_catalog_category->getCategories(0); 

		foreach ($categories_1 as $category_1) { 
			$level_2_data = array(); 

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']); 

			foreach ($categories_2 as $category_2) { 
				$level_3_data = array(); 

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']); 

				foreach ($categories_3 as $category_3) { 
					$level_3_data[] = array(
						'name' 	=> $category_3['name'],
						'href' 	=> $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'] . '_' . $category_3['category_id'])
					); 
				} 

				$level_2_data[] = array(
					'name'     	=> $category_2['name'],
					'children' 	=> $level_3_data,
					'href'     	=> $this->url->link('product/category', 'path=' . $category_1['category_id'] . '_' . $category_2['category_id'])
				); 
			} 

			$this->data['categories'][] = array(
				'name'     	=> $category_1['name'],
				'children' 	=> $level_2_data,
				'href'     	=> $this->url->link('product/category', 'path=' . $category_1['category_id'])
			); 
		} 

		$this->data['cart'] = $this->url->link('checkout/cart'); 
		$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL'); 

		$this->data['manufacturer'] = $this->url->link('product/manufacturer'); 
		$this->data['special'] = $this->url->link('product/special'); 
		$this->data['search'] = $this->url->link('product/search'); 

		$this->data['account'] = $this->url->link('account/account', '', 'SSL'); 
		$this->data['login'] = $this->url->link('account/login', '', 'SSL'); 
		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL'); 
		$this->data['password'] = $this->url->link('account/password', '', 'SSL'); 
		$this->data['address'] = $this->url->link('account/address', '', 'SSL'); 
		$this->data['wishlist'] = $this->url->link('account/wishlist'); 
		$this->data['history'] = $this->url->link('account/order', '', 'SSL'); 
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL'); 
		$this->data['download'] = $this->url->link('account/download', '', 'SSL'); 
		$this->data['addreturn'] = $this->url->link('account/return/insert', '', 'SSL'); 
		$this->data['return'] = $this->url->link('account/return', '', 'SSL'); 
		$this->data['reward'] = $this->url->link('account/reward', '', 'SSL'); 
		$this->data['giftvoucher'] = $this->url->link('account/voucher', '', 'SSL'); 
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL'); 

		$this->data['affiliate_account'] = $this->url->link('affiliate/account', '', 'SSL'); 
		$this->data['affiliate_login'] =$this->url->link('affiliate/login', '', 'SSL'); 
		$this->data['affiliate_edit'] = $this->url->link('affiliate/edit', '', 'SSL'); 
		$this->data['affiliate_password'] = $this->url->link('affiliate/password', '', 'SSL'); 
		$this->data['affiliate_payment'] = $this->url->link('affiliate/payment', '', 'SSL'); 
		$this->data['affiliate_tracking'] = $this->url->link('affiliate/tracking', '', 'SSL'); 
		$this->data['affiliate_transaction'] = $this->url->link('affiliate/transaction', '', 'SSL'); 

		$this->data['sitemap'] = $this->url->link('information/sitemap'); 
		$this->data['contact'] = $this->url->link('information/contact'); 

		$this->load->model('catalog/information'); 

		$this->data['informations'] = array(); 

		foreach ($this->model_catalog_information->getInformations() as $result) { 
			$this->data['informations'][] = array(
				'title' 	=> $result['title'], 
				'href'  	=> $this->url->link('information/information', 'information_id=' . $result['information_id'])
			); 
		} 

		// Custom Template Connector
		$this->data['template'] = $this->config->get('config_template'); 

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/sitemap.tpl')) { 
			$this->template = $this->config->get('config_template') . '/template/information/sitemap.tpl'; 
		} else { 
			$this->template = 'default/template/information/sitemap.tpl'; 
		} 

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		); 

		$this->response->setOutput($this->render()); 
	} 
} 
?>