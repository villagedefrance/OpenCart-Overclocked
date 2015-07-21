<?php
class ControllerModuleCarousel extends Controller {
	private $error = array();
	private $_name = 'carousel';
	private $_plugin = 'Slick';
	private $_version = 'v1.5.6';

	public function index() {
		$this->language->load('module/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting($this->_name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_content_header'] = $this->language->get('text_content_header');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_content_footer'] = $this->language->get('text_content_footer');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_auto'] = $this->language->get('text_auto');

		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_skin'] = $this->language->get('entry_skin');

		$this->data['entry_banner'] = $this->language->get('entry_banner');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_width'] = $this->language->get('entry_width');
		$this->data['entry_height'] = $this->language->get('entry_height');
		$this->data['entry_show'] = $this->language->get('entry_show');
		$this->data['entry_auto'] = $this->language->get('entry_auto');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_position'] = $this->language->get('entry_position');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'  	=> $this->language->get('text_home'),
			'href'  	=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'   	=> $this->language->get('text_module'),
			'href' 		=> $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'   	=> $this->language->get('heading_title'),
			'href'   	=> $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		// Skins
		$this->data['skins'] = array();

		$this->data['skins'][] = array('skin' => 'amber','color' => '#FFBF00','title' => 'Amber');
		$this->data['skins'][] = array('skin' => 'ash','color' => '#B2BEB5','title' => 'Ash');
		$this->data['skins'][] = array('skin' => 'azure','color' => '#007FFF','title' => 'Azure');
		$this->data['skins'][] = array('skin' => 'beige','color' => '#F5F5DC','title' => 'Beige');
		$this->data['skins'][] = array('skin' => 'black','color' => '#000000','title' => 'Black');
		$this->data['skins'][] = array('skin' => 'blue','color' => '#0000FF','title' => 'Blue');
		$this->data['skins'][] = array('skin' => 'brown','color' => '#964B00','title' => 'Brown');
		$this->data['skins'][] = array('skin' => 'burgundy','color' => '#800020','title' => 'Burgundy');
		$this->data['skins'][] = array('skin' => 'charcoal','color' => '#36454F','title' => 'Charcoal');
		$this->data['skins'][] = array('skin' => 'chocolate','color' => '#D2691E','title' => 'Chocolate');
		$this->data['skins'][] = array('skin' => 'coffee','color' => '#6F4E37','title' => 'Coffee');
		$this->data['skins'][] = array('skin' => 'cyan','color' => '#00FFFF','title' => 'Cyan');
		$this->data['skins'][] = array('skin' => 'fuchsia','color' => '#FF00FF','title' => 'Fuchsia');
		$this->data['skins'][] = array('skin' => 'gold','color' => '#FFD700','title' => 'Gold');
		$this->data['skins'][] = array('skin' => 'green','color' => '#00FF00','title' => 'Green');
		$this->data['skins'][] = array('skin' => 'grey','color' => '#808080','title' => 'Grey');
		$this->data['skins'][] = array('skin' => 'indigo','color' => '#4B0082','title' => 'Indigo');
		$this->data['skins'][] = array('skin' => 'khaki','color' => '#BDB76B','title' => 'Khaki');
		$this->data['skins'][] = array('skin' => 'lime','color' => '#CCFF00','title' => 'Lime');
		$this->data['skins'][] = array('skin' => 'magenta','color' => '#CA1F7B','title' => 'Magenta');
		$this->data['skins'][] = array('skin' => 'maroon','color' => '#800000','title' => 'Maroon');
		$this->data['skins'][] = array('skin' => 'orange','color' => '#FF7F00','title' => 'Orange');
		$this->data['skins'][] = array('skin' => 'olive','color' => '#808000','title' => 'Olive');
		$this->data['skins'][] = array('skin' => 'pink','color' => '#FFC0CB','title' => 'Pink');
		$this->data['skins'][] = array('skin' => 'pistachio','color' => '#93C572','title' => 'Pistachio');
		$this->data['skins'][] = array('skin' => 'red','color' => '#FF0000','title' => 'Red');
		$this->data['skins'][] = array('skin' => 'tangerine','color' => '#F28500','title' => 'Tangerine');
		$this->data['skins'][] = array('skin' => 'turquoise','color' => '#40E0D0','title' => 'Turquoise');
		$this->data['skins'][] = array('skin' => 'violet','color' => '#7F00FF','title' => 'Violet');
		$this->data['skins'][] = array('skin' => 'white','color' => '#FFFFFF','title' => 'White');
		$this->data['skins'][] = array('skin' => 'yellow','color' => '#FFFF00','title' => 'Yellow');

		// Plugin
		$this->data[$this->_name . '_plugin'] = $this->_plugin;
		$this->data[$this->_name . '_version'] = $this->_version;

		// Module
		if (isset($this->request->post[$this->_name . '_theme'])) {
			$this->data[$this->_name . '_theme'] = $this->request->post[$this->_name . '_theme'];
		} else {
			$this->data[$this->_name . '_theme'] = $this->config->get($this->_name . '_theme');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->request->post[$this->_name . '_title' . $language['language_id']])) {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->request->post[$this->_name . '_title' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title' . $language['language_id']] = $this->config->get($this->_name . '_title' . $language['language_id']);
			}
		}

		$this->data['languages'] = $languages;

		if (isset($this->request->post[$this->_name . '_title'])) {
			$this->data[$this->_name . '_title'] = $this->request->post[$this->_name . '_title'];
		} else {
			$this->data[$this->_name . '_title'] = $this->config->get($this->_name . '_title' );
		}

		if (isset($this->request->post[$this->_name . '_skin'])) {
			$this->data[$this->_name . '_skin'] = $this->request->post[$this->_name . '_skin'];
		} else {
			$this->data[$this->_name . '_skin'] = $this->config->get($this->_name . '_skin');
		}

		$this->data['modules'] = array();

		if (isset($this->request->post[$this->_name . '_module'])) {
			$this->data['modules'] = $this->request->post[$this->_name . '_module'];
		} elseif ($this->config->get($this->_name . '_module')) {
			$this->data['modules'] = $this->config->get($this->_name . '_module');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('design/banner');

		$this->data['banners'] = $this->model_design_banner->getBanners();

		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post[$this->_name . '_module'])) {
			foreach ($this->request->post[$this->_name . '_module'] as $key => $value) {
				if (!$value['width'] || !$value['height']) {
					$this->error['image'][$key] = $this->language->get('error_image');
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>