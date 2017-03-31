<?php
class ControllerExtensionPayment extends Controller {

	public function index() {
		$this->language->load('extension/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_images'] = $this->language->get('button_images');
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

		$this->data['payment_images'] = $this->url->link('design/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('design/payment');

		$total_payment_images = $this->model_design_payment->getTotalPaymentImages();

		$this->load->model('setting/extension');

		$total_extensions = $this->model_setting_extension->getTotalInstalled('payment');

		// CSS class modifier
		if ($total_payment_images < $total_extensions) {
			$this->data['payment_button'] = '-repair';
		} else {
			$this->data['payment_button'] = '';
		}

		$extensions = $this->model_setting_extension->getInstalled('payment');

		foreach ($extensions as $key => $value) {
			if (!file_exists(DIR_APPLICATION . 'controller/payment/' . $value . '.php')) {
				$this->model_setting_extension->uninstall('payment', $value);

				unset($extensions[$key]);
			}
		}

		// Payments accepting recurring transactions
		$is_recurring = array('pp_express', 'sagepay_direct', 'sagepay_server', 'worldpay_online');

		$this->data['extensions'] = array();

		$files = glob(DIR_APPLICATION . 'controller/payment/*.php');

		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');

				if (!$this->user->hasPermission('access', 'payment/' . $extension)) {
					continue;
				}

				$this->language->load('payment/' . $extension);

				$action = array();

				if (!in_array($extension, $extensions)) {
					$action[] = array(
						'text' => $this->language->get('text_install'),
						'type' => 'install',
						'href' => $this->url->link('extension/payment/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);

					$installed = false;

				} else {
					$action[] = array(
						'text' => $this->language->get('text_edit'),
						'type' => 'edit',
						'href' => $this->url->link('payment/' . $extension, 'token=' . $this->session->data['token'], 'SSL')
					);

					$action[] = array(
						'text' => $this->language->get('text_uninstall'),
						'type' => 'uninstall',
						'href' => $this->url->link('extension/payment/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);

					$installed = true;
				}

				$text_link = $this->language->get('text_' . $extension);

				if ($text_link != 'text_' . $extension) {
					$link = $this->language->get('text_' . $extension);
				} else {
					$link = '';
				}

				if (in_array($extension, $is_recurring)) {
					$name = $this->language->get('heading_title') . ' <img src="view/image/extra.png" alt="recurring" title="' . $this->language->get('text_is_recurring') . '" style="float:right; vertical-align:middle;" />';
				} else {
					$name = $this->language->get('heading_title');
				}

				$this->data['extensions'][] = array(
					'name'       => $name,
					'link'       => $link,
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'status'     => $this->config->get($extension . '_status'),
					'set'        => $installed,
					'action'     => $action
				);
			}
		}

		$this->data['total_extensions'] = $total_extensions;

		$this->template = 'extension/payment.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function install() {
		$this->language->load('extension/payment');

		if (!$this->user->hasPermission('modify', 'extension/payment')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('setting/extension');

			$this->model_setting_extension->install('payment', $this->request->get['extension']);

			$this->load->model('user/user_group');

			$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'payment/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'payment/' . $this->request->get['extension']);

			require_once(DIR_APPLICATION . 'controller/payment/' . $this->request->get['extension'] . '.php');

			$class = 'ControllerPayment' . str_replace('_', '', $this->request->get['extension']);

			$class = new $class($this->registry);

			if (method_exists($class, 'install')) {
				$class->install();
			}

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	public function uninstall() {
		$this->language->load('extension/payment');

		if (!$this->user->hasPermission('modify', 'extension/payment')) {
			$this->session->data['error'] = $this->language->get('error_permission');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$this->load->model('setting/extension');
			$this->load->model('setting/setting');

			$this->model_setting_extension->uninstall('payment', $this->request->get['extension']);

			$this->model_setting_setting->deleteSetting($this->request->get['extension']);

			require_once(DIR_APPLICATION . 'controller/payment/' . $this->request->get['extension'] . '.php');

			$class = 'ControllerPayment' . str_replace('_', '', $this->request->get['extension']);

			$class = new $class($this->registry);

			if (method_exists($class, 'uninstall')) {
				$class->uninstall();
			}

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
}
