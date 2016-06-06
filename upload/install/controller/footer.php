<?php
class ControllerFooter extends Controller {

	public function index() {
		$this->data['text_project'] = $this->language->get('text_project');
		$this->data['text_opencart'] = $this->language->get('text_opencart');
		$this->data['text_documentation'] = $this->language->get('text_documentation');
		$this->data['text_support'] = $this->language->get('text_support');
		$this->data['text_footer'] = $this->language->get('text_footer');

		$this->template = 'footer.tpl';

		$this->render();
	}
}
?>