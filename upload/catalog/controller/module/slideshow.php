<?php 
//------------------------
// Overclocked Edition		
//------------------------

class ControllerModuleSlideshow extends Controller { 
	private $_name = 'slideshow'; 

	protected function index($setting) { 
		static $module = 0; 

		$this->language->load('module/' . $this->_name); 

		$this->data['heading_title'] = $this->language->get('heading_title'); 

		// Template
		$this->data['template'] = $this->config->get('config_template'); 

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme'); 

		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id')); 

		if (!$this->data['title']) { $this->data['title'] = $this->data['heading_title']; } 

		$this->data['pause'] = $this->config->get($this->_name . '_pause'); 

		$this->data['nivoarrows'] = $this->config->get($this->_name . '_arrows'); 
		$this->data['nivoautohide'] = $this->config->get($this->_name . '_autohide'); 
		$this->data['nivocontrols'] = $this->config->get($this->_name . '_controls'); 

		if ($this->data['nivoarrows'] == '1') { $this->data['arrows'] = 'true'; } else { $this->data['arrows'] = 'false'; } 
		if ($this->data['nivoautohide'] == '1') { $this->data['autohide'] = 'true'; } else { $this->data['autohide'] = 'false'; } 
		if ($this->data['nivocontrols'] == '1') { $this->data['controls'] = 'true'; } else { $this->data['controls'] = 'false'; } 

		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/slideshow.css')) { 
			$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/slideshow.css'); 
		} else { 
			$this->document->addStyle('catalog/view/theme/default/stylesheet/slideshow.css'); 
		} 

		$this->document->addScript('catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js'); 

		$this->load->model('design/banner'); 
		$this->load->model('tool/image'); 

		$this->data['width'] = $setting['width']; 
		$this->data['height'] = $setting['height']; 

		if (isset($setting['effect'])) { 
			$this->data['effect'] = $setting['effect']; 
		} else { 
			$this->data['effect'] = 'random'; 
		} 

		if (isset($setting['delay'])) { 
			$this->data['delay'] = $setting['delay']; 
		} else { 
			$this->data['delay'] = 5000; 
		} 

		$this->data['banners'] = array(); 

		$results = $this->model_design_banner->getBanner($setting['banner_id']); 

		foreach ($results as $result) { 
			if (file_exists(DIR_IMAGE . $result['image'])) { 
				$this->data['banners'][] = array(
					'title' 	=> $result['title'],
					'link'  	=> $result['link'],
					'image'	=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				); 
			} 
		} 

		$this->data['module'] = $module++; 

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) { 
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl'; 
		} else { 
			$this->template = 'default/template/module/' . $this->_name . '.tpl'; 
		} 

		$this->render(); 
	} 
} 
?>