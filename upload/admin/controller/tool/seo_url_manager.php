<?php
class ControllerToolSeoUrlManager extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('tool/seo_url_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/seo_url_manager');

		$this->getList();
	}

	public function insert() {
		$this->language->load('tool/seo_url_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/seo_url_manager');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_tool_seo_url_manager->addUrl($this->request->post);

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
				$url_alias_id = $this->session->data['new_url_alias_id'];

				if ($url_alias_id) {
					unset($this->session->data['new_url_alias_id']);

					$this->redirect($this->url->link('tool/seo_url_manager/update', 'token=' . $this->session->data['token'] . '&url_alias_id=' . $url_alias_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('tool/seo_url_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/seo_url_manager');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_tool_seo_url_manager->editUrl($this->request->get['url_alias_id'], $this->request->post);

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
				$url_alias_id = $this->request->get['url_alias_id'];

				if ($url_alias_id) {
					$this->redirect($this->url->link('tool/seo_url_manager/update', 'token=' . $this->session->data['token'] . '&url_alias_id=' . $url_alias_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('tool/seo_url_manager');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('tool/seo_url_manager');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $url_alias_id) {
				$this->model_tool_seo_url_manager->deleteUrl($url_alias_id);
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

			$this->redirect($this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'keyword';
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

		$this->data['breadcrumbs'] =   array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('tool/seo_url_manager/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('tool/seo_url_manager/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('tool/image');

		$this->data['seo_urls'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$keyword_total = $this->model_tool_seo_url_manager->getTotalUniqueKeywords();
		$url_total = $this->model_tool_seo_url_manager->getTotalUrls();

		$this->data['keyword_total'] = $keyword_total;
		$this->data['seo_url_total'] = $url_total;

		$results = $this->model_tool_seo_url_manager->getUrls($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('tool/seo_url_manager/update', 'token=' . $this->session->data['token'] . '&url_alias_id=' . $result['url_alias_id'] . $url, 'SSL')
			);

			$query_link = false;

			if ($result['query']) {
				$check_query = strstr($result['query'], '_', true);

				if ($check_query == 'category') {
					$query_link = $this->url->link('catalog/category/update', 'token=' . $this->session->data['token'] . '&' . $result['query'], 'SSL');
				} elseif ($check_query == 'product') {
					$query_link = $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&' . $result['query'], 'SSL');
				} elseif ($check_query == 'manufacturer') {
					$query_link = $this->url->link('catalog/manufacturer/update', 'token=' . $this->session->data['token'] . '&' . $result['query'], 'SSL');
				} elseif ($check_query == 'information') {
					$query_link = $this->url->link('catalog/information/update', 'token=' . $this->session->data['token'] . '&' . $result['query'], 'SSL');
				} elseif ($check_query == 'news') {
					$query_link = $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&' . $result['query'], 'SSL');
				} else {
					$query_link = false;
				}
			}

			$this->data['seo_urls'][] = array(
				'url_alias_id' => $result['url_alias_id'],
				'query'        => $result['query'],
				'query_link'   => $query_link,
				'keyword'      => $result['keyword'],
				'selected'     => isset($this->request->post['selected']) && in_array($result['url_alias_id'], $this->request->post['selected']),
				'action'       => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_url_alias_id'] = $this->language->get('column_url_alias_id');
		$this->data['column_query'] = $this->language->get('column_query');
		$this->data['column_keyword'] = $this->language->get('column_keyword');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['link_seo_category'] = $this->language->get('link_seo_category');
		$this->data['link_seo_product'] = $this->language->get('link_seo_product');
		$this->data['link_seo_manufacturer'] = $this->language->get('link_seo_manufacturer');
		$this->data['link_seo_information'] = $this->language->get('link_seo_information');
		$this->data['link_seo_news'] = $this->language->get('link_seo_news');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		$this->data['seo_category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['seo_product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['seo_manufacturer'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['seo_information'] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['seo_news'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'], 'SSL');

		$seo_url_status = $this->config->get('config_seo_url');

		if (!$seo_url_status) {
			$this->data['error_url_status'] = $this->language->get('error_url_status');
		} else {
			$this->data['error_url_status'] = '';
		}

		if ($seo_url_status) {
			$this->data['success_url_status'] = $this->language->get('success_url_status');
		} else {
			$this->data['success_url_status'] = '';
		}

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

		$this->data['sort_url_alias_id'] = $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . '&sort=url_alias_id' . $url, 'SSL');
		$this->data['sort_keyword'] = $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . '&sort=keyword' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $url_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'tool/seo_url_manager_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_default'] = $this->language->get('text_default');

		$this->data['entry_query'] = $this->language->get('entry_query');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['query'])) {
			$this->data['error_query'] = $this->error['query'];
		} else {
			$this->data['error_query'] = '';
		}

		if (isset($this->error['keyword'])) {
			$this->data['error_keyword'] = $this->error['keyword'];
		} else {
			$this->data['error_keyword'] = '';
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
			'href'      => $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['url_alias_id'])) {
			$this->data['action'] = $this->url->link('tool/seo_url_manager/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('tool/seo_url_manager/update', 'token=' . $this->session->data['token'] . '&url_alias_id=' . $this->request->get['url_alias_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('tool/seo_url_manager', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['url_alias_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$url_info = $this->model_tool_seo_url_manager->getUrl($this->request->get['url_alias_id']);
		}

		if (isset($this->request->post['query'])) {
			$this->data['query'] = trim($this->request->post['query']);
		} elseif (!empty($url_info)) {
			$this->data['query'] = trim($url_info['query']);
		} else {
			$this->data['query'] = '';
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = trim($this->request->post['keyword']);
		} elseif (!empty($url_info)) {
			$this->data['keyword'] = trim($url_info['keyword']);
		} else {
			$this->data['keyword'] = '';
		}

		$this->template = 'tool/seo_url_manager_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'tool/seo_url_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['query']) < 3) || (utf8_strlen($this->request->post['query']) > 255)) {
			$this->error['query'] = $this->language->get('error_query');
		}

		if ((utf8_strlen($this->request->post['keyword']) < 3) || (utf8_strlen($this->request->post['keyword']) > 255)) {
			$this->error['keyword'] = $this->language->get('error_keyword');
		}

		$results = $this->model_tool_seo_url_manager->getUrls(0);

		foreach ($results as $result) {
			if (isset($this->request->get['url_alias_id'])) {
				if (($this->request->post['keyword'] == $result['keyword']) && ($this->request->get['url_alias_id'] != $result['url_alias_id'])) {
					$this->error['keyword'] = $this->language->get('error_keyword_exist');
				}
			} else {
				if ($this->request->post['keyword'] == $result['keyword']) {
					$this->error['keyword'] = $this->language->get('error_keyword_exist');
				}
			}
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'tool/seo_url_manager')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
