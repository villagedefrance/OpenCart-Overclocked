<?php
class ControllerCatalogNews extends Controller {
	private $error = array();
	private $_name = 'news';

	public function index() {
		$this->language->load('catalog/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/news');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/' . $this->_name);

		$this->load->model('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_news->addNews($this->request->post);

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
				$news_id = $this->session->data['new_news_id'];

				if ($news_id) {
					unset($this->session->data['new_news_id']);

					$this->redirect($this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $news_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/' . $this->_name);

		$this->load->model('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_news->editNews($this->request->get['news_id'], $this->request->post);

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
				$news_id = $this->request->get['news_id'];

				if ($news_id) {
					$this->redirect($this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $news_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/' . $this->_name);

		$this->load->model('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$this->model_catalog_news->deleteNews($news_id);
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

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function reset() {
		$this->language->load('catalog/' . $this->_name);

		$this->load->model('catalog/news');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateReset()) {
			foreach ($this->request->post['selected'] as $news_id) {
				$news_info = $this->model_catalog_news->getNewsStory($news_id);

				if ($news_info && ($news_info['viewed'] > 0)) {
					$this->model_catalog_news->resetViews($news_id);
				}
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

			$this->redirect($this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'nd.title';
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

		$this->language->load('catalog/' . $this->_name);

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		$this->load->model('setting/extension');

		$extensions = $this->model_setting_extension->getInstalled('module');

		foreach ($extensions as $key => $value) {
			if ($value = 'news' && file_exists(DIR_APPLICATION . 'controller/module/news.php')) {
				$this->data['module'] = $this->url->link('module/news', 'token=' . $this->session->data['token'], 'SSL');
			} else {
				$this->data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			}
		}

		$this->data['downloads'] = $this->url->link('catalog/news_download', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['reset'] = $this->url->link('catalog/news/reset', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/news/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('catalog/news');
		$this->load->model('tool/image');

		$this->data['news'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$news_total = $this->model_catalog_news->getTotalNews();

		$this->data['total_news'] = $news_total;

		$results = $this->model_catalog_news->getNews($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $result['news_id'] . $url, 'SSL')
			);

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			$this->data['news'][] = array(
				'news_id'    => $result['news_id'],
				'title'      => $result['title'],
				'image'      => $image,
				'date_added' => date($this->language->get('date_format_time'), strtotime($result['date_added'])),
				'sort_order' => $result['sort_order'],
				'status'     => $result['status'],
				'viewed'     => $result['viewed'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['news_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_viewed'] = $this->language->get('column_viewed');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_downloads'] = $this->language->get('button_downloads');
		$this->data['button_module'] = $this->language->get('button_module');
		$this->data['button_reset'] = $this->language->get('button_reset');
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

		$this->data['sort_title'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=nd.title' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=n.date_added' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=n.sort_order' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=n.status' . $url, 'SSL');
		$this->data['sort_viewed'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . '&sort=n.viewed' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $news_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/news_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->language->load('catalog/' . $this->_name);

		$this->load->model('catalog/news');

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_related'] = $this->language->get('tab_related');

		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_download'] = $this->language->get('entry_download');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_lightbox'] = $this->language->get('entry_lightbox');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_product_search'] = $this->language->get('entry_product_search');
		$this->data['entry_category'] = $this->language->get('entry_category');
		$this->data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$this->data['entry_related_method'] = $this->language->get('entry_related_method');
		$this->data['entry_product_wise'] = $this->language->get('entry_product_wise');
		$this->data['entry_category_wise'] = $this->language->get('entry_category_wise');
		$this->data['entry_manufacturer_wise'] = $this->language->get('entry_manufacturer_wise');

		$this->data['help_meta_description'] = $this->language->get('help_meta_description');
		$this->data['help_image'] = $this->language->get('help_image');
		$this->data['help_keyword'] = $this->language->get('help_keyword');
		$this->data['help_store'] = $this->language->get('help_store');
		$this->data['help_lightbox'] = $this->language->get('help_lightbox');
		$this->data['help_related_method'] = $this->language->get('help_related_method');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_new_download'] = $this->language->get('button_new_download');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = '';
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
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
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'text'      => $this->language->get('text_home'),
			'separator' => false
		);

		if (isset($this->request->get['news_id'])) {
			$news_name = $this->model_catalog_news->getNewsStory($this->request->get['news_id']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title') . ' :: ' . $news_name['title'],
				'href'      => $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['news_title'] = $news_name['title'];
			$this->data['new_entry'] = false;

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['news_title'] = $this->language->get('heading_title');
			$this->data['new_entry'] = true;
		}

		if (!isset($this->request->get['news_id'])) {
			$this->data['action'] = $this->url->link('catalog/news/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/news/update', 'token=' . $this->session->data['token'] . '&news_id=' . $this->request->get['news_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/news', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['new_download'] = $this->url->link('catalog/news_download/insert', 'token=' . $this->session->data['token'], 'SSL');

		if ((isset($this->request->get['news_id'])) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$news_info = $this->model_catalog_news->getNewsStory($this->request->get['news_id']);
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['news_description'])) {
			$this->data['news_description'] = $this->request->post['news_description'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_description'] = $this->model_catalog_news->getNewsDescriptions($this->request->get['news_id']);
		} else {
			$this->data['news_description'] = array();
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($news_info)) {
			$this->data['image'] = $news_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($news_info) && $news_info['image'] && file_exists(DIR_IMAGE . $news_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($news_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($news_info)) {
			$this->data['keyword'] = $news_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		$this->load->model('catalog/news_download');

		$this->data['downloads'] = $this->model_catalog_news_download->getDownloads();

		if (isset($this->request->post['news_download'])) {
			$this->data['news_download'] = $this->request->post['news_download'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_download'] = $this->model_catalog_news->getNewsDownloads($this->request->get['news_id']);
		} else {
			$this->data['news_download'] = array();
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['news_store'])) {
			$this->data['news_store'] = $this->request->post['news_store'];
		} elseif (isset($this->request->get['news_id'])) {
			$this->data['news_store'] = $this->model_catalog_news->getNewsStores($this->request->get['news_id']);
		} else {
			$this->data['news_store'] = array(0);
		}

		if (isset($this->request->post['lightbox'])) {
			$this->data['lightbox'] = $this->request->post['lightbox'];
		} elseif (!empty($news_info)) {
			$this->data['lightbox'] = $news_info['lightbox'];
		} else {
			$this->data['lightbox'] = 'magnific';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($news_info)) {
			$this->data['sort_order'] = $news_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($news_info)) {
			$this->data['status'] = $news_info['status'];
		} else {
			$this->data['status'] = 1;
		}

		$this->load->model('catalog/product');

		if (isset($this->request->post['related'])) {
			$this->data['related'] = $this->request->post['related'];

			if (isset($this->request->post['category_wise'])) {
				$this->data['category_ids'] = $this->request->post['category_wise'];
			} elseif (isset($this->request->post['manufacturer_wise'])) {
				$this->data['manufacturer_ids'] = $this->request->post['manufacturer_wise'];
			} else {
				if (isset($this->request->post['product_wise'])) {
					$this->data['products'] = array();

					foreach ($this->request->post['product_wise'] as $product_id) {
						$product_info = $this->model_catalog_product->getProduct($product_id);

						$this->data['products'][] = array(
							'product_id' => $product_info['product_id'],
							'name'       => $product_info['name']
						);
					}
				}
			}

		} elseif (!empty($news_info)) {
			if ($news_info['related_method']) {
				$this->data['related'] = $news_info['related_method'];

				$options = unserialize($news_info['related_option']);

				if ($this->data['related'] == 'category_wise' && $options) {
					foreach ($options['category_wise'] as $option) {
						$this->data['category_ids'][] = $option;
					}
				} elseif ($this->data['related'] == 'manufacturer_wise' && $options) {
					foreach ($options['manufacturer_wise'] as $option) {
						$this->data['manufacturer_ids'][] = $option;
					}
				} else {
					$products = $this->model_catalog_news->getNewsProduct($this->request->get['news_id']);

					foreach ($products as $product) {
						$product_info = $this->model_catalog_product->getProduct($product['product_id']);

						$this->data['products'][] = array(
							'product_id' => $product_info['product_id'],
							'name'       => $product_info['name']
						);
					}
				}

			} else {
				$this->data['related'] = 'product_wise';
			}

		} else {
			$this->data['related'] = 'product_wise';
		}

		$this->load->model('catalog/category');

		$this->data['default_categories'] = $this->model_catalog_category->getCategories(0);

		$this->load->model('catalog/manufacturer');

		$this->data['default_manufacturers'] = $this->model_catalog_manufacturer->getManufacturers(0);

		$this->template = 'catalog/news_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['news_description'] as $language_id => $value) {
			if ((strlen($value['title']) < 3) || (strlen($value['title']) > 250)) {
				$this->error['title'][$language_id] = $this->language->get('error_title');
			}

			if (strlen($value['description']) < 3) {
				$this->error['description'][$language_id] = $this->language->get('error_description');
			}
		}

		$allowed = array('jpg','jpeg','png','gif');

		if ($this->request->post['image']) {
			$ext = utf8_substr(strrchr($this->request->post['image'], '.'), 1);

			if (!in_array(strtolower($ext), $allowed)) {
				$this->error['image'] = $this->language->get('error_image');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	protected function validateReset() {
		if (!$this->user->hasPermission('modify', 'catalog/news')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
