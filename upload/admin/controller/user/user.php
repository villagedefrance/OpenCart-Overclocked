<?php
class ControllerUserUser extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('user/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user');

		$this->getList();
	}

	public function insert() {
		$this->language->load('user/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_user->addUser($this->request->post);

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
				$user_id = $this->session->data['new_user_id'];

				if ($user_id) {
					unset($this->session->data['new_user_id']);

					$this->redirect($this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $user_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('user/user', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('user/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_user->editUser($this->request->get['user_id'], $this->request->post);

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
				$user_id = $this->request->get['user_id'];

				if ($user_id) {
					$this->redirect($this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $user_id . $url, 'SSL'));
				}

			} else {
				$this->redirect($this->url->link('user/user', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('user/user');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('user/user');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $user_id) {
				$this->model_user_user->deleteUser($user_id);
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

			$this->redirect($this->url->link('user/user', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			$sort = 'username';
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
			'href'      => $this->url->link('user/user', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('user/user/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('user/user/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->load->model('tool/image');

		$this->data['users'] = array();

		$data = array(
			'filter_name' => $filter_name,
			'sort'        => $sort,
			'order'       => $order,
			'start'       => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'       => $this->config->get('config_admin_limit')
		);

		$user_total = $this->model_user_user->getTotalUsers();

		$results = $this->model_user_user->getUsers($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $result['user_id'] . $url, 'SSL')
			);

			if ($result['user_id'] && $result['user_group_id']) {
				$group_name = $this->model_user_user->getUserGroup($result['user_id'], $result['user_group_id']);
			} else {
				$group_name = '';
			}

			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_avatar.jpg', 40, 40);
			}

			$this->data['users'][] = array(
				'user_id'    => $result['user_id'],
				'image'      => $image,
				'username'   => $result['username'],
				'group_name' => $group_name,
				'email'      => $result['email'],
				'date_added' => date($this->language->get('date_format_time'), strtotime($result['date_added'])),
				'status'     => $result['status'],
				'selected'   => isset($this->request->post['selected']) && in_array($result['user_id'], $this->request->post['selected']),
				'action'     => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_delete'] = $this->language->get('text_confirm_delete');

		$this->data['column_user_id'] = $this->language->get('column_user_id');
		$this->data['column_avatar'] = $this->language->get('column_avatar');
		$this->data['column_username'] = $this->language->get('column_username');
		$this->data['column_user_group'] = $this->language->get('column_user_group');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

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

		$this->data['sort_user_id'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . '&sort=user_id' . $url, 'SSL');
		$this->data['sort_username'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . '&sort=username' . $url, 'SSL');
		$this->data['sort_user_group'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . '&sort=user_group' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . '&sort=email' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . '&sort=date_added' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');

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
		$pagination->total = $user_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('user/user', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_name'] = $filter_name;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'user/user_list.tpl';
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
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');

		$this->data['entry_username'] = $this->language->get('entry_username');
		$this->data['entry_old_password'] = $this->language->get('entry_old_password');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_confirm'] = $this->language->get('entry_confirm');
		$this->data['entry_firstname'] = $this->language->get('entry_firstname');
		$this->data['entry_lastname'] = $this->language->get('entry_lastname');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_user_group'] = $this->language->get('entry_user_group');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['help_image'] = $this->language->get('help_image');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}

		if (isset($this->error['old_password'])) {
			$this->data['error_old_password'] = $this->error['old_password'];
		} else {
			$this->data['error_old_password'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
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

		if (isset($this->request->get['user_id'])) {
			$user_name = $this->model_user_user->getUserName($this->request->get['user_id']);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title') . ' :: ' . $user_name,
				'href'      => $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $this->request->get['user_id'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['user_title'] = $user_name;

		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('user/user', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['user_title'] = $this->language->get('heading_title');
		}

		if (!isset($this->request->get['user_id'])) {
			$this->data['action'] = $this->url->link('user/user/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $this->request->get['user_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('user/user', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['user_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$user_info = $this->model_user_user->getUser($this->request->get['user_id']);
		}

		if (isset($this->request->post['username'])) {
			$this->data['username'] = $this->request->post['username'];
		} elseif (!empty($user_info)) {
			$this->data['username'] = $user_info['username'];
		} else {
			$this->data['username'] = '';
		}

		$this->data['user_exist'] = isset($this->request->get['user_id']) ? true : false;
		$this->data['is_required'] = isset($this->request->get['user_id']) ? 'advised' : 'required';

		if (isset($this->request->post['old_password'])) {
			$this->data['old_password'] = $this->request->post['old_password'];
		} else {
			$this->data['old_password'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($user_info)) {
			$this->data['firstname'] = $user_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($user_info)) {
			$this->data['lastname'] = $user_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($user_info)) {
			$this->data['email'] = $user_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($user_info)) {
			$this->data['image'] = $user_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($user_info) && $user_info['image'] && file_exists(DIR_IMAGE . $user_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($user_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_avatar.jpg', 100, 100);
		}

		$this->data['no_avatar'] = $this->model_tool_image->resize('no_avatar.jpg', 100, 100);

		if (isset($this->request->post['user_group_id'])) {
			$this->data['user_group_id'] = $this->request->post['user_group_id'];
		} elseif (!empty($user_info)) {
			$this->data['user_group_id'] = $user_info['user_group_id'];
		} else {
			$this->data['user_group_id'] = '';
		}

		$this->load->model('user/user_group');

		$this->data['user_groups'] = $this->model_user_user_group->getUserGroups();

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($user_info)) {
			$this->data['status'] = $user_info['status'];
		} else {
			$this->data['status'] = 0;
		}

		$this->template = 'user/user_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'user/user')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$user_info = $this->model_user_user->getUserByUsername($this->request->post['username']);

		if (!isset($this->request->get['user_id'])) {
			if ($user_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($user_info && ($this->request->get['user_id'] != $user_info['user_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if (isset($this->request->get['user_id']) && $user_info) {
			// Existing user
			if ($this->request->post['username']) {
				// Current Password Check
				if ($this->request->post['old_password'] && (utf8_strlen($this->request->post['old_password']) > 3) && (utf8_strlen($this->request->post['old_password']) < 21)) {
					$password_no_match = $this->model_user_user->checkUserPassword($this->request->post['old_password'], $user_info['user_id'], $this->request->post['username']);

					if ($password_no_match) {
						$this->error['old_password'] = $this->language->get('error_old_password');
					}
				} else {
					$this->error['old_password'] = $this->language->get('error_old_password');
				}

				if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 20)) {
					$this->error['username'] = $this->language->get('error_username');
				}

				if (!$this->user->checkUsername($this->request->post['username'])) {
					$this->error['username'] = $this->language->get('error_syntax');
				}
			}

			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				// Current Password Check
				if ($this->request->post['old_password'] && (utf8_strlen($this->request->post['old_password']) > 3) && (utf8_strlen($this->request->post['old_password']) < 21)) {
					$password_no_match = $this->model_user_user->checkUserPassword($this->request->post['old_password'], $user_info['user_id'], $this->request->post['username']);

					if ($password_no_match) {
						$this->error['old_password'] = $this->language->get('error_old_password');
					}
				} else {
					$this->error['old_password'] = $this->language->get('error_old_password');
				}

				$this->error['firstname'] = $this->language->get('error_firstname');
			}

			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				// Current Password Check
				if ($this->request->post['old_password'] && (utf8_strlen($this->request->post['old_password']) > 3) && (utf8_strlen($this->request->post['old_password']) < 21)) {
					$password_no_match = $this->model_user_user->checkUserPassword($this->request->post['old_password'], $user_info['user_id'], $this->request->post['username']);

					if ($password_no_match) {
						$this->error['old_password'] = $this->language->get('error_old_password');
					}
				} else {
					$this->error['old_password'] = $this->language->get('error_old_password');
				}

				$this->error['lastname'] = $this->language->get('error_lastname');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				// Current Password Check
				if ($this->request->post['old_password'] && (utf8_strlen($this->request->post['old_password']) > 3) && (utf8_strlen($this->request->post['old_password']) < 21)) {
					$password_no_match = $this->model_user_user->checkUserPassword($this->request->post['old_password'], $user_info['user_id'], $this->request->post['username']);

					if ($password_no_match) {
						$this->error['old_password'] = $this->language->get('error_old_password');
					}
				} else {
					$this->error['old_password'] = $this->language->get('error_old_password');
				}

				$this->error['email'] = $this->language->get('error_email');
			}

			$user_email = $this->model_user_user->getUserByEmail($this->request->post['email']);

			if (!isset($this->request->get['user_id'])) {
				if ($user_email) {
					$this->error['email'] = $this->language->get('error_email_exists');
				}
			} else {
				if ($user_email && ($this->request->get['user_id'] != $user_email['user_id'])) {
					$this->error['email'] = $this->language->get('error_email_exists');
				}
			}

			if ($this->request->post['password'] != "") {
				// Current Password Check
				if ($this->request->post['old_password'] && (utf8_strlen($this->request->post['old_password']) > 3) && (utf8_strlen($this->request->post['old_password']) < 21)) {
					$password_no_match = $this->model_user_user->checkUserPassword($this->request->post['old_password'], $user_info['user_id'], $this->request->post['username']);

					if ($password_no_match) {
						$this->error['old_password'] = $this->language->get('error_old_password');
					}
				} else {
					$this->error['old_password'] = $this->language->get('error_old_password');
				}

				if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
					$this->error['password'] = $this->language->get('error_password');
				}

				if ($this->request->post['confirm'] != $this->request->post['password']) {
					$this->error['confirm'] = $this->language->get('error_confirm');
				}
			}

		} else {
			// New user
			if ($this->request->post['username']) {
				if ((utf8_strlen($this->request->post['username']) < 3) || (utf8_strlen($this->request->post['username']) > 20)) {
					$this->error['username'] = $this->language->get('error_username');
				}

				if (!$this->user->checkUsername($this->request->post['username'])) {
					$this->error['username'] = $this->language->get('error_syntax');
				}
			}

			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$this->error['firstname'] = $this->language->get('error_firstname');
			}

			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				$this->error['lastname'] = $this->language->get('error_lastname');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
				$this->error['email'] = $this->language->get('error_email');
			}

			$user_email = $this->model_user_user->getUserByEmail($this->request->post['email']);

			if (!isset($this->request->get['user_id'])) {
				if ($user_email) {
					$this->error['email'] = $this->language->get('error_email_exists');
				}
			} else {
				if ($user_email && ($this->request->get['user_id'] != $user_email['user_id'])) {
					$this->error['email'] = $this->language->get('error_email_exists');
				}
			}

			if ($this->request->post['password'] != "") {
				if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
					$this->error['password'] = $this->language->get('error_password');
				}

				if ($this->request->post['confirm'] != $this->request->post['password']) {
					$this->error['confirm'] = $this->language->get('error_confirm');
				}

			} else {
				$this->error['password'] = $this->language->get('error_password');
			}
		}

		return empty($this->error);
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'user/user')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['selected'] as $user_id) {
			if ($this->user->getId() == $user_id) {
				$this->error['warning'] = $this->language->get('error_account');
			}
		}

		return empty($this->error);
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('user/user');

			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);

			$results = $this->model_user_user->getUsers($data);

			foreach ($results as $result) {
				$json[] = array(
					'user_id'  => $result['user_id'],
					'username' => strip_tags(html_entity_decode($result['username'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['username'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
