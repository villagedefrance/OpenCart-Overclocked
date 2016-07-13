<?php
class	ControllerMarketingCoupon	extends	Controller {
	private	$error = array();

	public function	index()	{
		$this->language->load('marketing/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/coupon');

		$this->getList();
	}

	public function	insert() {
		$this->language->load('marketing/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/coupon');

		if (($this->request->server['REQUEST_METHOD']	== 'POST') &&	$this->validateForm()) {
			$new_coupon_id = $this->model_marketing_coupon->addCoupon($this->request->post);

			$this->session->data['success']	=	$this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort']))	{
				$url .=	'&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .=	'&order='	.	$this->request->get['order'];
			}

			if (isset($this->request->get['page']))	{
				$url .=	'&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['apply']))	{

				if ($new_coupon_id)	{
					$this->redirect($this->url->link('marketing/coupon/update',	'token=' . $this->session->data['token'] . '&coupon_id=' . $coupon_id	.	$url,	'SSL'));
				}

			}	else {
				$this->redirect($this->url->link('marketing/coupon', 'token='	.	$this->session->data['token']	.	$url,	'SSL'));
			}
		}

		$this->getForm();
	}

	public function	update() {
		$this->language->load('marketing/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/coupon');

		if (($this->request->server['REQUEST_METHOD']	== 'POST') &&	$this->validateForm()) {
			$this->model_marketing_coupon->editCoupon($this->request->get['coupon_id'],	$this->request->post);

			$this->session->data['success']	=	$this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort']))	{
				$url .=	'&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .=	'&order='	.	$this->request->get['order'];
			}

			if (isset($this->request->get['page']))	{
				$url .=	'&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['apply']))	{
				$coupon_id = $this->request->get['coupon_id'];

				if ($coupon_id)	{
					$this->redirect($this->url->link('marketing/coupon/update',	'token=' . $this->session->data['token'] . '&coupon_id=' . $coupon_id	.	$url,	'SSL'));
				}

			}	else {
				$this->redirect($this->url->link('marketing/coupon', 'token='	.	$this->session->data['token']	.	$url,	'SSL'));
			}
		}

		$this->getForm();
	}

	public function	delete() {
		$this->language->load('marketing/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('marketing/coupon');

		if (isset($this->request->post['selected'])	&& $this->validateDelete())	{
			foreach	($this->request->post['selected']	as $coupon_id) {
				$this->model_marketing_coupon->deleteCoupon($coupon_id);
			}

			$this->session->data['success']	=	$this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort']))	{
				$url .=	'&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .=	'&order='	.	$this->request->get['order'];
			}

			if (isset($this->request->get['page']))	{
				$url .=	'&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('marketing/coupon', 'token='	.	$this->session->data['token']	.	$url,	'SSL'));
		}

		$this->getList();
	}

	protected	function getList() {
		if (isset($this->request->get['sort']))	{
			$sort	=	$this->request->get['sort'];
		}	else {
			$sort	=	'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		}	else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page']))	{
			$page	=	$this->request->get['page'];
		}	else {
			$page	=	1;
		}

		$url = '';

		if (isset($this->request->get['sort']))	{
			$url .=	'&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .=	'&order='	.	$this->request->get['order'];
		}

		if (isset($this->request->get['page']))	{
			$url .=	'&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'			=> $this->language->get('text_home'),
			'href'			=> $this->url->link('common/home', 'token='	.	$this->session->data['token'], 'SSL'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'text'			=> $this->language->get('heading_title'),
			'href'			=> $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator'	=> ' ::	'
		);

		$this->data['insert']	=	$this->url->link('marketing/coupon/insert',	'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete']	=	$this->url->link('marketing/coupon/delete',	'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['coupons'] = array();

		$filter_data = array(
			'sort'	=> $sort,
			'order'	=> $order,
			'start'	=> ($page	-	1) * $this->config->get('config_admin_limit'),
			'limit'	=> $this->config->get('config_admin_limit')
		);

		$coupon_total	=	$this->model_marketing_coupon->getTotalCoupons();

		$results = $this->model_marketing_coupon->getCoupons($filter_data);

		foreach	($results	as $result)	{
			$action	=	array();

			$action[]	=	array(
				'text' =>	$this->language->get('text_edit'),
				'href' =>	$this->url->link('marketing/coupon/update',	'token=' . $this->session->data['token'] . '&coupon_id=' . $result['coupon_id']	.	$url,	'SSL')
			);

			$this->data['coupons'][] = array(
				'coupon_id'	 =>	$result['coupon_id'],
				'name'			 =>	$result['name'],
				'code'			 =>	$result['code'],
				'type'			 =>	$result['type']	== 'P' ? '%' : ' ',
				'discount'	 =>	$result['discount'],
				'date_start' =>	date($this->language->get('date_format_short'),	strtotime($result['date_start'])),
				'date_end'	 =>	date($this->language->get('date_format_short'),	strtotime($result['date_end'])),
				'status'		 =>	$result['status'],
				'selected'	 =>	isset($this->request->post['selected'])	&& in_array($result['coupon_id'],	$this->request->post['selected']),
				'action'		 =>	$action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled']	=	$this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_code'] = $this->language->get('column_code');
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning']))	{
			$this->data['error_warning'] = $this->error['warning'];
		}	else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success']))	{
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		}	else {
			$this->data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$this->data['selected']	=	(array)$this->request->post['selected'];
		}	else {
			$this->data['selected']	=	array();
		}

		$url = '';

		if ($order ==	'ASC') {
			$url .=	'&order=DESC';
		}	else {
			$url .=	'&order=ASC';
		}

		if (isset($this->request->get['page']))	{
			$url .=	'&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . '&sort=name'	.	$url,	'SSL');
		$this->data['sort_code'] = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . '&sort=code'	.	$url,	'SSL');
		$this->data['sort_discount'] = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . '&sort=discount'	.	$url,	'SSL');
		$this->data['sort_date_start'] = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . '&sort=date_start'	.	$url,	'SSL');
		$this->data['sort_date_end'] = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . '&sort=date_end'	.	$url,	'SSL');
		$this->data['sort_status'] = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . '&sort=status'	.	$url,	'SSL');

		$url = '';

		if (isset($this->request->get['sort']))	{
			$url .=	'&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .=	'&order='	.	$this->request->get['order'];
		}

		$pagination	=	new	Pagination();
		$pagination->total = $coupon_total;
		$pagination->page	=	$page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text	=	$this->language->get('text_pagination');
		$pagination->url = $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . $url	.	'&page={page}',	'SSL');

		$this->data['pagination']	=	$pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'),	($coupon_total)	?	(($page	-	1) * $this->config->get('config_admin_limit')) + 1 : 0,	((($page - 1)	*	$this->config->get('config_admin_limit'))	>	($coupon_total - $this->config->get('config_admin_limit')))	?	$coupon_total	:	((($page - 1)	*	$this->config->get('config_admin_limit'))	+	$this->config->get('config_admin_limit')), $coupon_total,	ceil($coupon_total / $this->config->get('config_admin_limit')));

		$this->data['sort']	=	$sort;
		$this->data['order'] = $order;

		$this->template	=	'marketing/coupon_list.tpl';
		$this->children	=	array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected	function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_form'] = !isset($this->request->get['coupon_id'])	?	$this->language->get('text_insert')	:	$this->language->get('text_update');
		$this->data['text_enabled']	=	$this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes']	=	$this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_percent']	=	$this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name']	=	$this->language->get('entry_name');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_code']	=	$this->language->get('entry_code');
		$this->data['entry_discount']	=	$this->language->get('entry_discount');
		$this->data['entry_logged']	=	$this->language->get('entry_logged');
		$this->data['entry_shipping']	=	$this->language->get('entry_shipping');
		$this->data['entry_type']	=	$this->language->get('entry_type');
		$this->data['entry_total'] = $this->language->get('entry_total');
		$this->data['entry_category']	=	$this->language->get('entry_category');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_date_start']	=	$this->language->get('entry_date_start');
		$this->data['entry_date_end']	=	$this->language->get('entry_date_end');
		$this->data['entry_uses_total']	=	$this->language->get('entry_uses_total');
		$this->data['entry_uses_customer'] = $this->language->get('entry_uses_customer');
		$this->data['entry_status']	=	$this->language->get('entry_status');

		$this->data['help_code'] = $this->language->get('help_code');
		$this->data['help_type'] = $this->language->get('help_type');
		$this->data['help_logged'] = $this->language->get('help_logged');
		$this->data['help_total']	=	$this->language->get('help_total');
		$this->data['help_category'] = $this->language->get('help_category');
		$this->data['help_product']	=	$this->language->get('help_product');
		$this->data['help_uses_total'] = $this->language->get('help_uses_total');
		$this->data['help_uses_customer']	=	$this->language->get('help_uses_customer');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply']	=	$this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_history'] = $this->language->get('tab_history');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning']))	{
			$this->data['error_warning'] = $this->error['warning'];
		}	else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success']))	{
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		}	else {
			$this->data['success'] = '';
		}

		if (isset($this->request->get['coupon_id'])) {
			$this->data['coupon_id'] = $this->request->get['coupon_id'];
		}	else {
			$this->data['coupon_id'] = 0;
		}

		if (isset($this->error['warning']))	{
			$this->data['error_warning'] = $this->error['warning'];
		}	else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name']	=	$this->error['name'];
		}	else {
			$this->data['error_name']	=	'';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code']	=	$this->error['code'];
		}	else {
			$this->data['error_code']	=	'';
		}

		if (isset($this->error['date_start'])) {
			$this->data['error_date_start']	=	$this->error['date_start'];
		}	else {
			$this->data['error_date_start']	=	'';
		}

		if (isset($this->error['date_end'])) {
			$this->data['error_date_end']	=	$this->error['date_end'];
		}	else {
			$this->data['error_date_end']	=	'';
		}

		$url = '';

		if (isset($this->request->get['sort']))	{
			$url .=	'&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .=	'&order='	.	$this->request->get['order'];
		}

		if (isset($this->request->get['page']))	{
			$url .=	'&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'			=> $this->language->get('text_home'),
			'href'			=> $this->url->link('common/home', 'token='	.	$this->session->data['token'], 'SSL'),
			'separator'	=> false
		);

		$this->data['breadcrumbs'][] = array(
			'text'			=> $this->language->get('heading_title'),
			'href'			=> $this->url->link('marketing/coupon',	'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator'	=> ' ::	'
		);

		if (!isset($this->request->get['coupon_id']))	{
			$this->data['action']	=	$this->url->link('marketing/coupon/insert',	'token=' . $this->session->data['token'] . $url, 'SSL');
		}	else {
			$this->data['action']	=	$this->url->link('marketing/coupon/update',	'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id']	.	$url,	'SSL');
		}

		$this->data['cancel']	=	$this->url->link('marketing/coupon', 'token='	.	$this->session->data['token']	.	$url,	'SSL');

		if (isset($this->request->get['coupon_id'])	&& (!$this->request->server['REQUEST_METHOD']	!= 'POST'))	{
			$coupon_info = $this->model_marketing_coupon->getCoupon($this->request->get['coupon_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name']	=	$this->request->post['name'];
		}	elseif (!empty($coupon_info))	{
			$this->data['name']	=	$coupon_info['name'];
		}	else {
			$this->data['name']	=	'';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code']	=	$this->request->post['code'];
		}	elseif (!empty($coupon_info))	{
			$this->data['code']	=	$coupon_info['code'];
		}	else {
			$this->data['code']	=	'';
		}

		if (isset($this->request->post['type'])) {
			$this->data['type']	=	$this->request->post['type'];
		}	elseif (!empty($coupon_info))	{
			$this->data['type']	=	$coupon_info['type'];
		}	else {
			$this->data['type']	=	'';
		}

		if (isset($this->request->post['discount'])) {
			$this->data['discount']	=	$this->request->post['discount'];
		}	elseif (!empty($coupon_info))	{
			$this->data['discount']	=	$coupon_info['discount'];
		}	else {
			$this->data['discount']	=	'';
		}

		if (isset($this->request->post['logged'])) {
			$this->data['logged']	=	$this->request->post['logged'];
		}	elseif (!empty($coupon_info))	{
			$this->data['logged']	=	$coupon_info['logged'];
		}	else {
			$this->data['logged']	=	'';
		}

		if (isset($this->request->post['shipping'])) {
			$this->data['shipping']	=	$this->request->post['shipping'];
		}	elseif (!empty($coupon_info))	{
			$this->data['shipping']	=	$coupon_info['shipping'];
		}	else {
			$this->data['shipping']	=	'';
		}

		if (isset($this->request->post['total']))	{
			$this->data['total'] = $this->request->post['total'];
		}	elseif (!empty($coupon_info))	{
			$this->data['total'] = $coupon_info['total'];
		}	else {
			$this->data['total'] = '';
		}

		if (isset($this->request->post['coupon_product'])) {
			$products	=	$this->request->post['coupon_product'];
		}	elseif (isset($this->request->get['coupon_id'])) {
			$products	=	$this->model_marketing_coupon->getCouponProducts($this->request->get['coupon_id']);
		}	else {
			$products	=	array();
		}

		$this->load->model('catalog/product');

		$this->data['coupon_products'] = array();

		foreach	($products as	$product_id) {
			$product_info	=	$this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				$this->data['coupon_products'][] = array(
					'product_id' =>	$product_info['product_id'],
					'name'			 =>	$product_info['name']
				);
			}
		}

		if (isset($this->request->post['coupon_category']))	{
			$categories	=	$this->request->post['coupon_category'];
		}	elseif (isset($this->request->get['coupon_id'])) {
			$categories	=	$this->model_marketing_coupon->getCouponCategories($this->request->get['coupon_id']);
		}	else {
			$categories	=	array();
		}

		$this->load->model('catalog/category');

		$this->data['coupon_categories'] = array();

		foreach	($categories as	$category_id)	{
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info)	{
				$this->data['coupon_categories'][] = array(
					'category_id'	=> $category_info['category_id'],
					'name'				=> ($category_info['path'] ? $category_info['path']	.	'	&gt; ' : '') . $category_info['name']
				);
			}
		}

		if (isset($this->request->post['date_start'])) {
			$this->data['date_start']	=	$this->request->post['date_start'];
		}	elseif (!empty($coupon_info))	{
			$this->data['date_start']	=	($coupon_info['date_start']	!= '0000-00-00'	?	$coupon_info['date_start'] : '');
		}	else {
			$this->data['date_start']	=	date('Y-m-d',	time());
		}

		if (isset($this->request->post['date_end'])) {
			$this->data['date_end']	=	$this->request->post['date_end'];
		}	elseif (!empty($coupon_info))	{
			$this->data['date_end']	=	($coupon_info['date_end']	!= '0000-00-00'	?	$coupon_info['date_end'] : '');
		}	else {
			$this->data['date_end']	=	date('Y-m-d',	strtotime('+1	month'));
		}

		if (isset($this->request->post['uses_total'])) {
			$this->data['uses_total']	=	$this->request->post['uses_total'];
		}	elseif (!empty($coupon_info))	{
			$this->data['uses_total']	=	$coupon_info['uses_total'];
		}	else {
			$this->data['uses_total']	=	1;
		}

		if (isset($this->request->post['uses_customer']))	{
			$this->data['uses_customer'] = $this->request->post['uses_customer'];
		}	elseif (!empty($coupon_info))	{
			$this->data['uses_customer'] = $coupon_info['uses_customer'];
		}	else {
			$this->data['uses_customer'] = 1;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status']	=	$this->request->post['status'];
		}	elseif (!empty($coupon_info))	{
			$this->data['status']	=	$coupon_info['status'];
		}	else {
			$this->data['status']	=	true;
		}

		$this->template	=	'marketing/coupon_form.tpl';
		$this->children	=	array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected	function validateForm()	{
		if (!$this->user->hasPermission('modify',	'marketing/coupon')) {
			$this->error['warning']	=	$this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3)	|| (utf8_strlen($this->request->post['name'])	>	128))	{
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['code']) < 3)	|| (utf8_strlen($this->request->post['code'])	>	10)) {
			$this->error['code'] = $this->language->get('error_code');
		}

		$coupon_info = $this->model_marketing_coupon->getCouponByCode($this->request->post['code']);

		if ($coupon_info)	{
			if (!isset($this->request->get['coupon_id']))	{
				$this->error['warning']	=	$this->language->get('error_exists');
			}	elseif ($coupon_info['coupon_id']	!= $this->request->get['coupon_id']) {
				$this->error['warning']	=	$this->language->get('error_exists');
			}
		}

		if ($this->error &&	!isset($this->error['warning'])) {
			$this->error['warning']	=	$this->language->get('error_warning');
		}

		return (empty($this->error));
	}

	protected	function validateDelete()	{
		if (!$this->user->hasPermission('modify',	'marketing/coupon')) {
			$this->error['warning']	=	$this->language->get('error_permission');
		}

		return (empty($this->error));
	}

	public function	history()	{
		$this->language->load('marketing/coupon');

		$this->load->model('marketing/coupon');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_amount'] = $this->language->get('column_amount');

		if (isset($this->request->get['page']))	{
			$page	=	$this->request->get['page'];
		}	else {
			$page	=	1;
		}

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['histories'] = array();

		$results = $this->model_marketing_coupon->getCouponHistories($this->request->get['coupon_id'], ($page	-	1) * 10, 10);

		foreach	($results	as $result)	{
			$this->data['histories'][] = array(
				'order_id'	 =>	$result['order_id'],
				'customer'	 =>	$result['customer'],
				'date_added' =>	date($this->language->get('date_format_time'), strtotime($result['date_added'])),
				'amount'		 =>	$result['amount']
			);
		}

		$history_total = $this->model_marketing_coupon->getTotalCouponHistories($this->request->get['coupon_id']);

		$pagination	=	new	Pagination();
		$pagination->total = $history_total;
		$pagination->page	=	$page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text	=	$this->language->get('text_pagination');
		$pagination->url = $this->url->link('marketing/coupon/history',	'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id']	.	'&page={page}',	'SSL');

		$this->data['pagination']	=	$pagination->render();

		$this->data['results'] = sprintf($this->language->get('text_pagination'),	($history_total) ? (($page - 1)	*	$this->config->get('config_admin_limit'))	+	1	:	0, ((($page	-	1) * $this->config->get('config_admin_limit')) > ($history_total - $this->config->get('config_admin_limit')))	?	$history_total : ((($page	-	1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')),	$history_total,	ceil($history_total	/	$this->config->get('config_admin_limit')));

		$this->template	=	'marketing/coupon_history.tpl';

		$this->response->setOutput($this->render());
	}
}
?>