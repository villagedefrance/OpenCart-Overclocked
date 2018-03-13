<?php
class ControllerCommonFooter extends Controller {

	protected function index() {
		$this->language->load('common/footer');

		$this->data['text_footer'] = sprintf($this->language->get('text_footer'), VERSION);

		$this->data['scripts'] = $this->document->getScripts();

		// Display Limit
		$display_limit = $this->config->get('config_admin_width_limit');

		$this->data['resolution'] = ($display_limit) ? 'limited' : 'normal';

		$this->template = 'common/footer.tpl';

		$this->render();
	}
}
