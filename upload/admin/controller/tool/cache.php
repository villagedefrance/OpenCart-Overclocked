<?php
class ControllerToolCache extends Controller {

	public function index() {
		$this->language->load('tool/cache');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('tool/cache', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_size'] = $this->language->get('column_size');
		$this->data['column_expire'] = $this->language->get('column_expire');

		$this->data['button_clean'] = $this->language->get('button_clean');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['clean'] = $this->url->link('tool/cache/clean', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('tool/cache/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['caches'] = array();

		$files = glob(DIR_CACHE . 'cache.*');

		foreach ($files as $file) {
			if (file_exists($file)) {
				$size = filesize($file);

				$i = 0;

				$suffix = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');

				while (($size / 1024) > 1) { $size = $size / 1024; $i++; }
			}

			$data = explode('/', $file);

			if (strpos(end($data), '.') > 0) {
				if (end($data) != 'index.html') {
					$time = substr(strrchr(end($data), '.'), 1);

					$this->data['caches'][] = array(
						'name' 		=> end($data),
						'size'			=> round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i],
						'time'			=> round(($time - time()) / 60),
						'selected'	=> isset($this->request->post['selected']) && in_array(end($data), $this->request->post['selected'])
					);
				}
			}
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->template = 'tool/cache.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function clean() {
		$this->language->load('tool/cache');

		$this->document->setTitle($this->language->get('heading_title'));

		$files = glob(DIR_CACHE . 'cache.*');

		if ($files) {
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

				if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
				}
			}
		}

		$this->redirect($this->url->link('tool/cache', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function delete() {
		$this->language->load('tool/cache');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $name) {
				$files = glob(DIR_CACHE . $name);

				if ($files) {
					foreach ($files as $file) {
						if (file_exists($file)) {
							unlink($file);
						}
					}
				}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('tool/cache', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'tool/cache')) {
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