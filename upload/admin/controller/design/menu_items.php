<?php
class ControllerDesignMenuItems extends Controller {
	private $error = array();
	private $_name = 'menu_items';

	public function index() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$menu_item_id = $this->model_design_menu_items->addMenuItem($this->request->get['menu_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_insert_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

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
				$menu_item_id = $this->session->data['new_menu_item_id'];

				if ($menu_item_id) {
					unset($this->session->data['new_menu_item_id']);

					$this->redirect($this->url->link('design/menu_items/update', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . '&menu_item_id=' . $menu_item_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_menu_items->editMenuItem($this->request->get['menu_item_id'], $this->request->get['menu_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_update_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

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
				$menu_item_id = $this->request->get['menu_item_id'];

				if ($menu_item_id) {
					$this->redirect($this->url->link('design/menu_items/update', '&token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . '&menu_item_id=' . $menu_item_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $menu_item_id) {
				$this->model_design_menu_items->deleteMenuItem($menu_item_id);
			}

			$this->session->data['success'] = $this->language->get('text_delete_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function repair() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		if ($this->validateRepair()) {
			$this->model_design_menu_items->repairMenuItems();

			$this->session->data['success'] = $this->language->get('text_repair_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name, mi.sort_order';
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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$menu_id = $this->request->get['menu_id'];

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['back'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['enabled'] = $this->url->link('design/menu_items/enable', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');
		$this->data['disabled'] = $this->url->link('design/menu_items/disable', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');
		$this->data['insert'] = $this->url->link('design/menu_items/insert', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');
		$this->data['repair'] = $this->url->link('design/menu_items/repair', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/menu_items/delete', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['menu_items'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'sort'        => $sort,
			'order'       => $order,
			'start'       => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'       => $this->config->get('config_admin_limit')
		);

		$menu_item_total = $this->model_design_menu_items->getTotalMenuItems($menu_id, $data);

		$results = $this->model_design_menu_items->getMenuItems($menu_id, $data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/menu_items/update', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . '&menu_item_id=' . $result['menu_item_id'] . $url, 'SSL')
			);

			$this->data['menu_items'][] = array(
				'menu_item_id' => $result['menu_item_id'],
				'name'         => $result['name'],
				'external'     => $result['external_link'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'sort_order'   => $result['sort_order'],
				'status'       => $result['status'],
				'selected'     => isset($this->request->post['selected']) && in_array($result['menu_item_id'], $this->request->post['selected']),
				'action'       => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_menu'] = $this->language->get('text_menu');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_external'] = $this->language->get('column_external');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_back'] = $this->language->get('button_back');
		$this->data['button_enable'] = $this->language->get('button_enable');
		$this->data['button_disable'] = $this->language->get('button_disable');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_repair'] = $this->language->get('button_repair');
		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['token'] = $this->session->data['token'];

		$this->data['menu_id'] = $menu_id;

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . '&sort=name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . '&sort=mi.sort_order' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . '&sort=mi.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $menu_item_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/menu_items_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_selector'] = $this->language->get('text_selector');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_link'] = $this->language->get('entry_link');
		$this->data['entry_external_link'] = $this->language->get('entry_external_link');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');

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

		$this->document->addScript('view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('view/javascript/jquery/colorbox/colorbox.css');

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$menu_id = $this->request->get['menu_id'];

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_menu'),
			'href'      => $this->url->link('design/menu', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['menu_item_id'])) {
			$this->data['action'] = $this->url->link('design/menu_items/insert', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/menu_items/update', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . '&menu_item_id=' . $this->request->get['menu_item_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $menu_id . $url, 'SSL');

		$this->data['text_info'] = sprintf($this->language->get('text_info'), $this->url->link('design/menu_items/info', 'token=' . $this->session->data['token'], 'SSL'));

		if (isset($this->request->get['menu_item_id']) && isset($menu_id) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$menu_item_info = $this->model_design_menu_items->getMenuItem($this->request->get['menu_item_id'], $menu_id);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['menu_item_description'])) {
			$this->data['menu_item_description'] = $this->request->post['menu_item_description'];
		} elseif (isset($this->request->get['menu_item_id'])) {
			$this->data['menu_item_description'] = $this->model_design_menu_items->getMenuItemDescription($this->request->get['menu_item_id']);
		} else {
			$this->data['menu_item_description'] = array();
		}

		$menu_items = $this->model_design_menu_items->getMenuItems($menu_id, 0);

		// Remove own Id from list
		if (!empty($menu_item_info)) {
			foreach ($menu_items as $key => $menu_item) {
				if ($menu_item['menu_item_id'] == $menu_item_info['menu_item_id']) {
					unset($menu_items[$key]);
				}
			}
		}

		$this->data['menu_items'] = $menu_items;

		$this->data['menu_id'] = $this->request->get['menu_id'];

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($menu_item_info)) {
			$this->data['parent_id'] = $menu_item_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}

		if (isset($this->request->post['link'])) {
			$this->data['link'] = $this->request->post['link'];
		} elseif (!empty($menu_item_info)) {
			$this->data['link'] = $menu_item_info['menu_item_link'];
		} else {
			$this->data['link'] = '';
		}

		if (isset($this->request->post['external_link'])) {
			$this->data['external_link'] = $this->request->post['external_link'];
		} elseif (!empty($menu_item_info)) {
			$this->data['external_link'] = $menu_item_info['external_link'];
		} else {
			$this->data['external_link'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($menu_item_info)) {
			$this->data['sort_order'] = $menu_item_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($menu_item_info)) {
			$this->data['status'] = $menu_item_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		$this->template = 'design/menu_items_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/menu_items')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['menu_item_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/menu_items')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'design/menu_items')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function enable() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $menu_item_id) {
				$this->model_design_menu_items->editMenuItemStatus($menu_item_id, 1);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function disable() {
		$this->language->load('design/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/menu_items');

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $menu_item_id) {
				$this->model_design_menu_items->editMenuItemStatus($menu_item_id, 0);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('design/menu_items', 'token=' . $this->session->data['token'] . '&menu_id=' . $this->request->get['menu_id'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function info() {
		$this->language->load('design/' . $this->_name);

		$language = $this->language->get('code');
		$direction = $this->language->get('direction');
		$info_title = $this->language->get('info_title');

		$this->load->model('tool/route');

		$routes = $this->model_tool_route->getRoutes(0);

		if ($routes) {
			$output  = '<html dir="' . $direction . '" lang="' . $language . '">' . "\n";
			$output .= '<head>' . "\n";
			$output .= '  <title>' . $info_title . '</title>' . "\n";
			$output .= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
			$output .= '  <meta name="robots" content="noindex">' . "\n";
			$output .= '</head>' . "\n";
			$output .= '<body>' . "\n";
			$output .= '  <h1>' . $info_title . '</h1>' . "\n";
			$output .= '  <ul style="list-style:square outside none;">';
			foreach ($routes as $route) {
				$output .= '    <li>' . $route['link'] . '  ' . $route['name'] . '</li>' . "\n";
			}
			$output .= '  </ul>';
			$output .= '  </body>' . "\n";
			$output .= '</html>' . "\n";

			$this->response->setOutput($output);
		}
	}
}
