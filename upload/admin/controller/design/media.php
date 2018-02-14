<?php
class ControllerDesignMedia extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('design/media');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/media');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/media');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/media');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_media->addMedia($this->request->post);

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

			if (isset($this->request->post['apply'])) {
				$media_id = $this->session->data['new_media_id'];

				if ($media_id) {
					unset($this->session->data['new_media_id']);

					$this->redirect($this->url->link('design/media/update', 'token=' . $this->session->data['token'] . '&media_id=' . $media_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/media', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/media');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/media');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_media->editMedia($this->request->get['media_id'], $this->request->post);

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

			if (isset($this->request->post['apply'])) {
				$media_id = $this->request->get['media_id'];

				if ($media_id) {
					$this->redirect($this->url->link('design/media/update', 'token=' . $this->session->data['token'] . '&media_id=' . $media_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('design/media', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/media');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('design/media');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $media_id) {
				$this->model_design_media->deleteMedia($media_id);
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

			$this->redirect($this->url->link('design/media', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/media', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['module_mediaplayer'] = $this->url->link('module/mediaplayer', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['insert'] = $this->url->link('design/media/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/media/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('tool/image');

		$this->data['medias'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'sort'        => $sort,
			'order'       => $order,
			'start'       => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'       => $this->config->get('config_admin_limit')
		);

		$media_total = $this->model_design_media->getTotalMedias();

		$results = $this->model_design_media->getMedias($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('design/media/update', 'token=' . $this->session->data['token'] . '&media_id=' . $result['media_id'] . $url, 'SSL')
			);

			if ($result['media'] && file_exists(DIR_IMAGE . $result['media'])) {
				$size = $this->model_design_media->getMediaSize($result['media_id']);
				$media_image = $this->model_design_media->getMediaImage($result['media_id']);
				$thumb = $this->model_tool_image->resize($media_image, 40, 40);
			} else {
				$size = 0;
				$thumb = $this->model_tool_image->resize('no_file.jpg', 40, 40);
			}

			$this->data['medias'][] = array(
				'media_id' => $result['media_id'],
				'name'     => $result['name'],
				'media'    => utf8_substr(strrchr($result['media'], '/'), 1),
				'size'     => $size,
				'type'     => $thumb,
				'status'   => $result['status'],
				'selected' => isset($this->request->post['selected']) && in_array($result['media_id'], $this->request->post['selected']),
				'action'   => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_media'] = $this->language->get('column_media');
		$this->data['column_size'] = $this->language->get('column_size');
		$this->data['column_type'] = $this->language->get('column_type');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_module'] = $this->language->get('button_module');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

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

		$this->data['sort_name'] = $this->url->link('design/media', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('design/media', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

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
		$pagination->total = $media_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('design/media', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/media_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_link'] = $this->language->get('text_link');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_media'] = $this->language->get('entry_media');
		$this->data['entry_credit'] = $this->language->get('entry_credit');
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
			$this->data['error_name'] = '';
		}

		if (isset($this->error['media'])) {
			$this->data['error_media'] = $this->error['media'];
		} else {
			$this->data['error_media'] = array();
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

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('design/media', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['media_id'])) {
			$this->data['action'] = $this->url->link('design/media/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/media/update', 'token=' . $this->session->data['token'] . '&media_id=' . $this->request->get['media_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/media', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['text_info'] = sprintf($this->language->get('text_info'), $this->url->link('design/media/info', 'token=' . $this->session->data['token'], 'SSL'));

		if (isset($this->request->get['media_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$media_info = $this->model_design_media->getMedia($this->request->get['media_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($media_info)) {
			$this->data['name'] = $media_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['media'])) {
			$this->data['media'] = $this->request->post['media'];
		} elseif (!empty($media_info)) {
			$this->data['media'] = $media_info['media'];
		} else {
			$this->data['media'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['media']) && file_exists(DIR_IMAGE . $this->request->post['media'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['media'], 100, 100);
		} elseif (!empty($media_info) && $media_info['media'] && file_exists(DIR_IMAGE . $media_info['media'])) {
			$media_image = $this->model_design_media->getMediaImage($media_info['media_id']);

			$this->data['thumb'] = $this->model_tool_image->resize($media_image, 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_file.jpg', 100, 100);
		}

		$this->data['no_file'] = $this->model_tool_image->resize('no_file.jpg', 100, 100);

		if (isset($this->request->post['credit'])) {
			$this->data['credit'] = $this->request->post['credit'];
		} elseif (!empty($media_info)) {
			$this->data['credit'] = $media_info['credit'];
		} else {
			$this->data['credit'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($media_info)) {
			$this->data['status'] = $media_info['status'];
		} else {
			$this->data['status'] = true;
		}

		$this->template = 'design/media_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/media')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 128)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		$allowed = array('mp3','mp4','oga','ogv','ogg','webm','m4a','m4v','wav','wma','wmv','flv');

		if ($this->request->post['media']) {
			$ext = utf8_substr(strrchr($this->request->post['media'], '.'), 1);

			if (!in_array(strtolower($ext), $allowed)) {
				$this->error['media'] = $this->language->get('error_media_file');
			}

		} else {
			$this->error['media'] = $this->language->get('error_media');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/media')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('design/media');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_design_media->getMedias($data);

			foreach ($results as $result) {
				$json[] = array(
					'media_id' => $result['media_id'],
					'name'     => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
