<?php
class ControllerCommonFooterLogin extends Controller {

	protected function index() {
		$this->template = 'common/footer_login.tpl';

		$this->render();
	}
}
