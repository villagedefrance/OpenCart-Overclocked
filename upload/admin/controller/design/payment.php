<?php
class ControllerDesignPayment extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('design/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/payment');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/payment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_payment->addPaymentImage($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['apply'])) {
				$payment_image_id = $this->session->data['new_payment_image_id'];

				if ($payment_image_id) {
					unset($this->session->data['new_payment_image_id']);

					$this->redirect($this->url->link('design/payment/update', 'token=' . $this->session->data['token'] . '&payment_image_id=' . $payment_image_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/payment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_payment->editPaymentImage($this->request->get['payment_image_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['apply'])) {
				$payment_image_id = $this->request->get['payment_image_id'];

				if ($payment_image_id) {
					$this->redirect($this->url->link('design/payment/update', 'token=' . $this->session->data['token'] . '&payment_image_id=' . $payment_image_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/payment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $payment_image_id) {
				$this->model_design_payment->deletePaymentImage($payment_image_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['extension'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['insert'] = $this->url->link('design/payment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/payment/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('setting/extension');
		$this->load->model('tool/image');

		$this->data['payment_images'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$payment_image_total = $this->model_design_payment->getTotalPaymentImages();

		$results = $this->model_design_payment->getPaymentImages($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/payment/update', 'token=' . $this->session->data['token'] . '&payment_image_id=' . $result['payment_image_id'] . $url, 'SSL')
			);

			$image = $this->model_design_payment->getPaymentImageImage($result['payment_image_id']);

			if ($image && file_exists(DIR_IMAGE . $image)) {
				$thumb = $this->model_tool_image->resize($image, 80, 20);
			} else {
				$thumb = $this->model_tool_image->resize('no_image.jpg', 80, 20);
			}

			$this->data['payment_images'][] = array(
				'payment_image_id' => $result['payment_image_id'],
				'image'            => $thumb,
				'name'             => $result['name'],
				'method'           => $this->config->get(strtolower($result['payment']) . '_status'),
				'status'           => $result['status'],
				'selected'         => isset($this->request->post['selected']) && in_array($result['payment_image_id'], $this->request->post['selected']),
				'action'           => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_method'] = $this->language->get('column_method');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_extension'] = $this->language->get('button_extension');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('design/payment', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $payment_image_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/payment_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_payment'] = $this->language->get('entry_payment');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

		if (isset($this->error['payment'])) {
			$this->data['error_payment'] = $this->error['payment'];
		} else {
			$this->data['error_payment'] = array();
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['payment_image_id'])) {
			$this->data['action'] = $this->url->link('design/payment/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/payment/update', 'token=' . $this->session->data['token'] . '&payment_image_id=' . $this->request->get['payment_image_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/payment', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['payment_image_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$payment_image_info = $this->model_design_payment->getPaymentImage($this->request->get['payment_image_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($payment_image_info)) {
			$this->data['name'] = $payment_image_info['name'];
		} else {
			$this->data['name'] = '';
		}

		$this->data['payment_methods'] = array();

		$files = $this->model_design_payment->getExtensions('payment');

		if ($files) {
			foreach ($files as $file) {
				$filename = $file['code'];

				$this->language->load('payment/' . $filename);

				$this->data['payment_methods'][] = array(
					'filename' => $filename,
					'name'     => $this->language->get('heading_title')
				);
			}
		}

		if (isset($this->request->post['payment'])) {
			$this->data['payment'] = $this->request->post['payment'];
		} elseif (!empty($payment_image_info)) {
			$this->data['payment'] = $payment_image_info['payment'];
		} else {
			$this->data['payment'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($payment_image_info)) {
			$this->data['image'] = $payment_image_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($payment_image_info) && $payment_image_info['image'] && file_exists(DIR_IMAGE . $payment_image_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($payment_image_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($payment_image_info)) {
			$this->data['status'] = $payment_image_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		$this->template = 'design/payment_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		$results = $this->model_design_payment->getPaymentImages(0);

		foreach ($results as $result) {
			if (isset($this->request->get['payment_image_id'])) {
				if (($this->request->post['payment'] == $result['payment']) && ($this->request->get['payment_image_id'] != $result['payment_image_id'])) {
					$this->error['payment'] = $this->language->get('error_payment_exist');
				}
			} else {
				if ($this->request->post['payment'] == $result['payment']) {
					$this->error['payment'] = $this->language->get('error_payment_exist');
				}
			}
		}

		if (!$this->request->post['payment']) {
			$this->error['payment'] = $this->language->get('error_payment');
		}

		$allowed = array('jpg','jpeg','png','gif');

		if ($this->request->post['image']) {
			$ext = utf8_substr(strrchr($this->request->post['image'], '.'), 1);

			if (!in_array(strtolower($ext), $allowed)) {
				$this->error['image'] = $this->language->get('error_image_format');
			}

		} else {
			$this->error['image'] = $this->language->get('error_image');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
