<?php
class ControllerDesignPalette extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('design/palette');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/palette');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/palette');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/palette');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_palette->addPalette($this->request->post);

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
				$palette_id = $this->session->data['new_palette_id'];

				if ($palette_id) {
					unset($this->session->data['new_palette_id']);

					$this->redirect($this->url->link('design/palette/update', 'token=' . $this->session->data['token'] . '&palette_id=' . $palette_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/palette');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/palette');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_palette->editPalette($this->request->get['palette_id'], $this->request->post);

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
				$palette_id = $this->request->get['palette_id'];

				if ($palette_id) {
					$this->redirect($this->url->link('design/palette/update', 'token=' . $this->session->data['token'] . '&palette_id=' . $palette_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/palette');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/palette');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $palette_id) {
				$this->model_design_palette->deletePalette($palette_id);
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

			$this->redirect($this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('design/palette/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/palette/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->data['palettes'] = array();

		$data = array(
			'sort'  	=> $sort,
			'order' 	=> $order,
			'start' 	=> ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' 		=> $this->config->get('config_admin_limit')
		);

		$palette_total = $this->model_design_palette->getTotalPalettes();

		$results = $this->model_design_palette->getPalettes($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text'	=> $this->language->get('text_edit'),
				'href'	=> $this->url->link('design/palette/update', 'token=' . $this->session->data['token'] . '&palette_id=' . $result['palette_id'] . $url, 'SSL')
			);

			$this->data['palettes'][] = array(
				'palette_id'	=> $result['palette_id'],
				'name'		=> $result['name'],
				'colors'		=> $this->model_design_palette->getTotalColorsByPaletteId($result['palette_id']),
				'selected'	=> isset($this->request->post['selected']) && in_array($result['palette_id'], $this->request->post['selected']),
				'action'		=> $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_colors'] = $this->language->get('column_colors');
		$this->data['column_action'] = $this->language->get('column_action');

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

		$this->data['sort_name'] = $this->url->link('design/palette', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $palette_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/palette_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_default'] = $this->language->get('text_default');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_color'] = $this->language->get('entry_color');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_color'] = $this->language->get('button_add_color');
		$this->data['button_remove'] = $this->language->get('button_remove');

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

		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		if (isset($this->error['color'])) {
			$this->data['error_color'] = $this->error['color'];
		} else {
			$this->data['error_color'] = array();
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
			'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['palette_id'])) {
			$this->data['action'] = $this->url->link('design/palette/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/palette/update', 'token=' . $this->session->data['token'] . '&palette_id=' . $this->request->get['palette_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/palette', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['palette_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$palette_info = $this->model_design_palette->getPalette($this->request->get['palette_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($palette_info)) {
			$this->data['name'] = $palette_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['palette_color'])) {
			$palette_colors = $this->request->post['palette_color'];
		} elseif (isset($this->request->get['palette_id'])) {
			$palette_colors = $this->model_design_palette->getPaletteColors($this->request->get['palette_id']);
		} else {
			$palette_colors = array();
		}

		$this->data['palette_colors'] = array();

		foreach ($palette_colors as $palette_color) {
			$this->data['palette_colors'][] = array(
				'title'		=> $palette_color['title'],
				'color'	=> $palette_color['color']
			);
		}

		$this->template = 'design/palette_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/palette')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (isset($this->request->post['palette_color'])) {
			foreach ($this->request->post['palette_color'] as $key => $value) {
				if ((utf8_strlen($value['title']) < 3) || (utf8_strlen($value['title']) > 64)) {
					$this->error['title'][$key] = $this->language->get('error_title');
				}

				if ((utf8_strlen($value['color']) != 6) || (!preg_match('/^[a-f0-9]{6}$/i', $value['color']))) {
					$this->error['color'][$key] = $this->language->get('error_color');
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/palette')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>