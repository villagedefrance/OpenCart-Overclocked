<?php
class ControllerStep4 extends Controller {

	public function index() {
		$this->document->setTitle($this->language->get('heading_step_4'));

		$this->data['heading_step_4'] = $this->language->get('heading_step_4');

		$this->data['text_license'] = $this->language->get('text_license');
		$this->data['text_installation'] = $this->language->get('text_installation');
		$this->data['text_configuration'] = $this->language->get('text_configuration');
		$this->data['text_finished'] = $this->language->get('text_finished');
		$this->data['text_congratulation'] = $this->language->get('text_congratulation');
		$this->data['text_forget'] = $this->language->get('text_forget');
		$this->data['text_shop'] = $this->language->get('text_shop');
		$this->data['text_login'] = $this->language->get('text_login');

		$this->template = 'step_4.tpl';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->setOutput($this->render());
	}
}

?>