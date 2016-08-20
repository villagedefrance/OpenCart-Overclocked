<?php
class ControllerModificationOpenbaypro extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('modification/openbaypro');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_modification'),
			'href'      => $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('modification/openbaypro', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_installed'] = $this->language->get('text_installed');

		$this->data['button_close'] = $this->language->get('button_close');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['close'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'modification/openbaypro.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'modification/openbaypro')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}

	public function install() {
		$this->load->model('setting/setting');

		$settings = $this->model_setting_setting->getSetting('openbaymanager');
		$settings['openbaymanager_show_menu'] = 1;

		$this->model_setting_setting->editSetting('openbaymanager', $settings);
	}

	public function uninstall() {
		$this->load->model('setting/setting');

		$settings = $this->model_setting_setting->getSetting('openbaymanager');
		$settings['openbaymanager_show_menu'] = 0;

		$this->model_setting_setting->editSetting('openbaymanager', $settings);
	}
}
?>
