<?php
class ControllerDesignFooter extends Controller {
	private $error = array();
	private $_name = 'footer';

	public function index() {
		$this->language->load('design/footer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/footer');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/footer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/footer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_footer->addFooter($this->request->post);

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
				$footer_id = $this->session->data['new_footer_id'];

				if ($footer_id) {
					unset($this->session->data['new_footer_id']);

					$this->redirect($this->url->link('design/footer/update', 'token=' . $this->session->data['token'] . '&footer_id=' . $footer_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/footer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/footer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_footer->editFooter($this->request->get['footer_id'], $this->request->post);

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
				$footer_id = $this->request->get['footer_id'];

				if ($footer_id) {
					$this->redirect($this->url->link('design/footer/update', 'token=' . $this->session->data['token'] . '&footer_id=' . $footer_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/footer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/footer');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $footer_id) {
				$this->model_design_footer->deleteFooter($footer_id);
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

			$this->redirect($this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'fd.name';
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
			'href'      => $this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['theme'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['insert'] = $this->url->link('design/footer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/footer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['footer_blocks'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$footer_total = $this->model_design_footer->getTotalFooters();

		$results = $this->model_design_footer->getFooters($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/footer/update', 'token=' . $this->session->data['token'] . '&footer_id=' . $result['footer_id'] . $url, 'SSL')
			);

			$this->data['footer_blocks'][] = array(
				'footer_id' => $result['footer_id'],
				'name'      => $result['name'],
				'position'  => $result['position'],
				'status'    => $result['status'],
				'selected'  => isset($this->request->post['selected']) && in_array($result['footer_id'], $this->request->post['selected']),
				'action'    => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_position'] = $this->language->get('column_position');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_theme'] = $this->language->get('button_theme');
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

		$this->data['sort_name'] = $this->url->link('design/footer', 'token=' . $this->session->data['token'] . '&sort=fd.name' . $url, 'SSL');
		$this->data['sort_position'] = $this->url->link('design/footer', 'token=' . $this->session->data['token'] . '&sort=f.position' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('design/footer', 'token=' . $this->session->data['token'] . '&sort=f.status' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $footer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/footer_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_block'] = $this->language->get('heading_block');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_position'] = $this->language->get('text_position');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_link'] = $this->language->get('text_link');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_route'] = $this->language->get('entry_route');
		$this->data['entry_external_link'] = $this->language->get('entry_external_link');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_route'] = $this->language->get('button_add_route');
		$this->data['button_remove'] = $this->language->get('button_remove');

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
			$this->data['error_name'] = '';
		}

		if (isset($this->error['footer_route'])) {
			$this->data['error_footer_route'] = $this->error['footer_route'];
		} else {
			$this->data['error_footer_route'] = array();
		}

		$this->document->addScript('view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('view/javascript/jquery/colorbox/colorbox.css');

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

		if (isset($this->request->get['footer_id'])) {
			$footer_name = $this->model_design_footer->getFooterName($this->request->get['footer_id']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title') . ' :: ' . $footer_name,
				'href'      => $this->url->link('design/footer/update', 'token=' . $this->session->data['token'] . '&footer_id=' . $this->request->get['footer_id'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['footer_title'] = $this->language->get('text_block') . ': ' . $footer_name;

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['footer_title'] = $this->language->get('heading_title');
		}

		if (!isset($this->request->get['footer_id'])) {
			$this->data['action'] = $this->url->link('design/footer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/footer/update', 'token=' . $this->session->data['token'] . '&footer_id=' . $this->request->get['footer_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/footer', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['text_info'] = sprintf($this->language->get('text_info'), $this->url->link('design/footer/info', 'token=' . $this->session->data['token'], 'SSL'));

		if (isset($this->request->get['footer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$footer_info = $this->model_design_footer->getFooter($this->request->get['footer_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['footer_description'])) {
			$this->data['footer_description'] = $this->request->post['footer_description'];
		} elseif (isset($this->request->get['footer_id'])) {
			$this->data['footer_description'] = $this->model_design_footer->getFooterDescriptions($this->request->get['footer_id']);
		} else {
			$this->data['footer_description'] = array();
		}

		if (isset($this->request->post['position'])) {
			$this->data['position'] = $this->request->post['position'];
		} elseif (!empty($footer_info)) {
			$this->data['position'] = $footer_info['position'];
		} else {
			$this->data['position'] = '';
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['footer_store'])) {
			$this->data['footer_store'] = $this->request->post['footer_store'];
		} elseif (isset($this->request->get['footer_id'])) {
			$this->data['footer_store'] = $this->model_design_footer->getFooterStores($this->request->get['footer_id']);
		} else {
			$this->data['footer_store'] = array(0);
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($footer_info)) {
			$this->data['status'] = $footer_info['status'];
		} else {
			$this->data['status'] = 0;
		}

		if (isset($this->request->post['footer_route'])) {
			$footer_routes = $this->request->post['footer_route'];
		} elseif (isset($this->request->get['footer_id'])) {
			$footer_routes = $this->model_design_footer->getFooterRoutes($this->request->get['footer_id']);
		} else {
			$footer_routes = array();
		}

		$this->data['footer_routes'] = array();

		foreach ($footer_routes as $footer_route) {
			$this->data['footer_routes'][] = array(
				'footer_route_description' => $footer_route['footer_route_description'],
				'route'                    => $footer_route['route'],
				'external_link'            => $footer_route['external_link'],
				'sort_order'               => $footer_route['sort_order']
			);
		}

		$this->template = 'design/footer_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/footer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['footer_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 64)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}

		if (isset($this->request->post['footer_route'])) {
			foreach ($this->request->post['footer_route'] as $footer_route_id => $footer_route) {
				foreach ($footer_route['footer_route_description'] as $language_id => $footer_route_description) {
					if ((utf8_strlen($footer_route_description['title']) < 2) || (utf8_strlen($footer_route_description['title']) > 64)) {
						$this->error['footer_route'][$footer_route_id][$language_id] = $this->language->get('error_title');
					}
				}
			}
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/footer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
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
