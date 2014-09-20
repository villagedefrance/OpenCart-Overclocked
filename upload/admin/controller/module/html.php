<?php
class ControllerModuleHtml extends Controller {
	private $error = array();
	private $_name = 'html';

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
		$this->data['text_no']	= $this->language->get('text_no');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');

		$this->data['tab_code'] = $this->language->get('tab_code');

		$this->data['entry_theme'] = $this->language->get('entry_theme');
		$this->data['entry_title'] = $this->language->get('entry_title');

		$this->data['entry_code'] = $this->language->get('entry_code');

		$this->data['entry_tab_id'] = $this->language->get('entry_tab_id');
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

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('text_module'),
			'href'		=> $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/'.$this->_name, 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		// Module
		if (isset($this->request->post[$this->_name . '_theme1'])) {
			$this->data[$this->_name . '_theme1'] = $this->request->post[$this->_name . '_theme1'];
		} else {
			$this->data[$this->_name . '_theme1'] = $this->config->get($this->_name . '_theme1');
		}

		if (isset( $this->request->post[$this->_name . '_theme2'])) {
			$this->data[$this->_name . '_theme2'] = $this->request->post[$this->_name . '_theme2'];
		} else {
			$this->data[$this->_name . '_theme2'] = $this->config->get($this->_name . '_theme2');
		}

		if (isset( $this->request->post[$this->_name . '_theme3'])) {
			$this->data[$this->_name . '_theme3'] = $this->request->post[$this->_name . '_theme3'];
		} else {
			$this->data[$this->_name . '_theme3'] = $this->config->get($this->_name . '_theme3');
		}

		if (isset( $this->request->post[$this->_name . '_theme4'])) {
			$this->data[$this->_name . '_theme4'] = $this->request->post[$this->_name . '_theme4'];
		} else {
			$this->data[$this->_name . '_theme4'] = $this->config->get($this->_name . '_theme4');
		}

		if (isset( $this->request->post[$this->_name . '_theme5'])) {
			$this->data[$this->_name . '_theme5'] = $this->request->post[$this->_name . '_theme5'];
		} else {
			$this->data[$this->_name . '_theme5'] = $this->config->get($this->_name . '_theme5');
		}

		if (isset( $this->request->post[$this->_name . '_theme6'])) {
			$this->data[$this->_name . '_theme6'] = $this->request->post[$this->_name . '_theme6'];
		} else {
			$this->data[$this->_name . '_theme6'] = $this->config->get($this->_name . '_theme6');
		}

		if (isset( $this->request->post[$this->_name . '_theme7'])) {
			$this->data[$this->_name . '_theme7'] = $this->request->post[$this->_name . '_theme7'];
		} else {
			$this->data[$this->_name . '_theme7'] = $this->config->get($this->_name . '_theme7');
		}

		if (isset( $this->request->post[$this->_name . '_theme8'])) {
			$this->data[$this->_name . '_theme8'] = $this->request->post[$this->_name . '_theme8'];
		} else {
			$this->data[$this->_name . '_theme8'] = $this->config->get($this->_name . '_theme8');
		}

		if (isset( $this->request->post[$this->_name . '_theme9'])) {
			$this->data[$this->_name . '_theme9'] = $this->request->post[$this->_name . '_theme9'];
		} else {
			$this->data[$this->_name . '_theme9'] = $this->config->get($this->_name . '_theme9');
		}

		if (isset( $this->request->post[$this->_name . '_theme10'])) {
			$this->data[$this->_name . '_theme10'] = $this->request->post[$this->_name . '_theme10'];
		} else {
			$this->data[$this->_name . '_theme10'] = $this->config->get($this->_name . '_theme10');
		}

		$this->load->model('localisation/language');

		$languages = $this->model_localisation_language->getLanguages();

		foreach ($languages as $language) {
			if (isset($this->request->post[$this->_name . '_title1' . $language['language_id']])) {
				$this->data[$this->_name . '_title1' . $language['language_id']] = $this->request->post[$this->_name . '_title1' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title1' . $language['language_id']] = $this->config->get($this->_name . '_title1' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title2' . $language['language_id']])) {
				$this->data[$this->_name . '_title2' . $language['language_id']] = $this->request->post[$this->_name . '_title2' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title2' . $language['language_id']] = $this->config->get($this->_name . '_title2' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title3' . $language['language_id']])) {
				$this->data[$this->_name . '_title3' . $language['language_id']] = $this->request->post[$this->_name . '_title3' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title3' . $language['language_id']] = $this->config->get($this->_name . '_title3' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title4' . $language['language_id']])) {
				$this->data[$this->_name . '_title4' . $language['language_id']] = $this->request->post[$this->_name . '_title4' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title4' . $language['language_id']] = $this->config->get($this->_name . '_title4' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title5' . $language['language_id']])) {
				$this->data[$this->_name . '_title5' . $language['language_id']] = $this->request->post[$this->_name . '_title5' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title5' . $language['language_id']] = $this->config->get($this->_name . '_title5' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title6' . $language['language_id']])) {
				$this->data[$this->_name . '_title6' . $language['language_id']] = $this->request->post[$this->_name . '_title6' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title6' . $language['language_id']] = $this->config->get($this->_name . '_title6' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title7' . $language['language_id']])) {
				$this->data[$this->_name . '_title7' . $language['language_id']] = $this->request->post[$this->_name . '_title7' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title7' . $language['language_id']] = $this->config->get($this->_name . '_title7' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title8' . $language['language_id']])) {
				$this->data[$this->_name . '_title8' . $language['language_id']] = $this->request->post[$this->_name . '_title8' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title8' . $language['language_id']] = $this->config->get($this->_name . '_title8' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title9' . $language['language_id']])) {
				$this->data[$this->_name . '_title9' . $language['language_id']] = $this->request->post[$this->_name . '_title9' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title9' . $language['language_id']] = $this->config->get($this->_name . '_title9' . $language['language_id']);
			}

			if (isset($this->request->post[$this->_name . '_title10' . $language['language_id']])) {
				$this->data[$this->_name . '_title10' . $language['language_id']] = $this->request->post[$this->_name . '_title10' . $language['language_id']];
			} else {
				$this->data[$this->_name . '_title10' . $language['language_id']] = $this->config->get($this->_name . '_title10' . $language['language_id']);
			}
		}

		$this->data['languages'] = $languages;

		if (isset($this->request->post[$this->_name . '_code1'])) {
			$this->data[$this->_name . '_code1'] = $this->request->post[$this->_name . '_code1'];
		} else {
			$this->data[$this->_name . '_code1'] = $this->config->get($this->_name . '_code1');
		}

		if (isset($this->request->post[$this->_name . '_code2'])) {
			$this->data[$this->_name . '_code2'] = $this->request->post[$this->_name . '_code2'];
		} else {
			$this->data[$this->_name . '_code2'] = $this->config->get($this->_name . '_code2');
		}

		if (isset($this->request->post[$this->_name . '_code3'])) {
			$this->data[$this->_name . '_code3'] = $this->request->post[$this->_name . '_code3'];
		} else {
			$this->data[$this->_name . '_code3'] = $this->config->get($this->_name . '_code3');
		}

		if (isset($this->request->post[$this->_name . '_code4'])) {
			$this->data[$this->_name . '_code4'] = $this->request->post[$this->_name . '_code4'];
		} else {
			$this->data[$this->_name . '_code4'] = $this->config->get($this->_name . '_code4');
		}

		if (isset($this->request->post[$this->_name . '_code5'])) {
			$this->data[$this->_name . '_code5'] = $this->request->post[$this->_name . '_code5'];
		} else {
			$this->data[$this->_name . '_code5'] = $this->config->get($this->_name . '_code5');
		}

		if (isset($this->request->post[$this->_name . '_code6'])) {
			$this->data[$this->_name . '_code6'] = $this->request->post[$this->_name . '_code6'];
		} else {
			$this->data[$this->_name . '_code6'] = $this->config->get($this->_name . '_code6');
		}

		if (isset($this->request->post[$this->_name . '_code7'])) {
			$this->data[$this->_name . '_code7'] = $this->request->post[$this->_name . '_code7'];
		} else {
			$this->data[$this->_name . '_code7'] = $this->config->get($this->_name . '_code7');
		}

		if (isset($this->request->post[$this->_name . '_code8'])) {
			$this->data[$this->_name . '_code8'] = $this->request->post[$this->_name . '_code8'];
		} else {
			$this->data[$this->_name . '_code8'] = $this->config->get($this->_name . '_code8');
		}

		if (isset($this->request->post[$this->_name . '_code9'])) {
			$this->data[$this->_name . '_code9'] = $this->request->post[$this->_name . '_code9'];
		} else {
			$this->data[$this->_name . '_code9'] = $this->config->get($this->_name . '_code9');
		}

		if (isset($this->request->post[$this->_name . '_code10'])) {
			$this->data[$this->_name . '_code10'] = $this->request->post[$this->_name . '_code10'];
		} else {
			$this->data[$this->_name . '_code10'] = $this->config->get($this->_name . '_code10');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->data['modules'] = array();

		if (isset($this->request->post[$this->_name . '_module'])) {
			$this->data['modules'] = $this->request->post[$this->_name . '_module'];
		} elseif ($this->config->get($this->_name . '_module')) {
			$this->data['modules'] = $this->config->get($this->_name . '_module');
		}

		$this->template = 'module/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/' . $this->_name)) {
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