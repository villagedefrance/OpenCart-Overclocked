<?php
class ControllerExtensionModification extends Controller {

	public function index() {
		$this->language->load('extension/modification');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_confirm_uninstall'] = $this->language->get('text_confirm_uninstall');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_close'] = $this->language->get('button_close');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

		$this->load->model('setting/extension');

		$extensions = $this->model_setting_extension->getInstalled('modification');

		foreach ($extensions as $key => $value) {
			if (!file_exists(DIR_APPLICATION . 'controller/modification/' . $value . '.php')) {
				$this->model_setting_extension->uninstall('modification', $value);

				unset($extensions[$key]);
			}
		}

		$this->data['extensions'] = array();

		$files = glob(DIR_APPLICATION . 'controller/modification/*.php');

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');

				if (!$this->user->hasPermission('access', 'modification/' . $extension)) {
					continue;
				}

				$this->language->load('modification/' . $extension);

				$action = array();

				if (!in_array($extension, $extensions)) {
					$action[] = array(
						'text' => $this->language->get('text_install'),
						'type' => 'install',
						'href' => $this->url->link('extension/modification/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);

				} else {
					$action[] = array(
						'text' => $this->language->get('text_edit'),
						'type' => 'edit',
						'href' => $this->url->link('modification/' . $extension, 'token=' . $this->session->data['token'], 'SSL')
					);

					$action[] = array(
						'text' => $this->language->get('text_uninstall'),
						'type' => 'uninstall',
						'href' => $this->url->link('extension/modification/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);
				}

				$this->data['extensions'][] = array(
					'name'   => $this->language->get('heading_title'),
					'action' => $action
				);
			}
		}

		$this->template = 'extension/modification.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->language->load('extension/modification');

		if (!$this->user->hasPermission('modify', 'extension/modification')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('setting/extension');

			$this->model_setting_extension->install('modification', $this->request->get['extension']);

			$this->load->model('user/user_group');

			$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'modification/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'modification/' . $this->request->get['extension']);

			require_once(DIR_APPLICATION . 'controller/modification/' . $this->request->get['extension'] . '.php');

			$class = 'ControllerModification' . str_replace('_', '', $this->request->get['extension']);

			$class = new $class($this->registry);

			if (method_exists($class, 'install')) {
				$class->install();
			}

			$this->redirect($this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function uninstall() {
		$this->language->load('extension/modification');

		if (!$this->user->hasPermission('modify', 'extension/modification')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('setting/extension');
			$this->load->model('setting/setting');

			$this->model_setting_extension->uninstall('modification', $this->request->get['extension']);

			$this->model_setting_setting->deleteSetting($this->request->get['extension']);

			require_once(DIR_APPLICATION . 'controller/modification/' . $this->request->get['extension'] . '.php');

			$class = 'ControllerModification' . str_replace('_', '', $this->request->get['extension']);

			$class = new $class($this->registry);

			if (method_exists($class, 'uninstall')) {
				$class->uninstall();
			}

			$this->redirect($this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
