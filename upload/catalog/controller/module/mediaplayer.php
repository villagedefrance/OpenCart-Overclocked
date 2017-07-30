<?php
class ControllerModuleMediaPlayer extends Controller {
	private $_name = 'mediaplayer';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_download'] = $this->language->get('text_download');

		$this->document->addStyle('catalog/view/javascript/jquery/plyr/dist/plyr.min.css');
		$this->document->addScript('catalog/view/javascript/jquery/plyr/dist/plyr.min.js');

		// Module
		$this->data['theme'] = $this->config->get($this->_name . '_theme');
		$this->data['title'] = $this->config->get($this->_name . '_title' . $this->config->get('config_language_id'));

		if (!$this->data['title']) {
			$this->data['title'] = $this->data['heading_title'];
		}

		$this->load->model('design/media');
		$this->load->model('tool/image');

		$media_id = $setting['media_id'];

		if ($media_id > 0) {
			$media = $this->model_design_media->getMedia($media_id);

			$this->data['media'] = html_entity_decode(HTTPS_SERVER . 'image/' . $media, ENT_QUOTES, 'UTF-8');

			$this->data['type'] = $this->model_design_media->getMediaType($media_id);
			$this->data['mime_type'] = $this->model_design_media->getMediaMimeType($media_id);
			$this->data['credit'] = $this->model_design_media->getCredit($media_id);

			$this->data['media_id'] = true;
		} else {
			$this->data['media_id'] = false;
		}

		if ($setting['image_width']) {
			$this->data['width'] = $setting['image_width'];
		} else {
			$this->data['width'] = 480;
		}

		if ($setting['image_height']) {
			$this->data['height'] = $setting['image_height'];
		} else {
			$this->data['height'] = 320;
		}

		$this->data['icons'] = HTTPS_SERVER . 'catalog/view/javascript/jquery/plyr/dist/plyr.svg';

		$poster = html_entity_decode($this->config->get($this->_name . '_image'), ENT_QUOTES, 'UTF-8');

		if ($poster) {
			$this->data['poster'] = $this->model_tool_image->resize($poster, $this->data['width'], $this->data['height']);
		} else {
			$this->data['poster'] = '';
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
			$this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
