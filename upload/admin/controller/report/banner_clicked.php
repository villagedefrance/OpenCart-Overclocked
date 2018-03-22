<?php
class ControllerReportBannerClicked extends Controller {

	public function index() {
		$this->language->load('report/banner_clicked');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/banner_clicked', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$image_clicked_total = $this->model_design_banner->getTotalImagesClicked($data);

		$image_clicks_total = $this->model_design_banner->getTotalImagesClicks();

		$this->data['banners'] = array();

		$results = $this->model_design_banner->getImagesClicked($data);

		foreach ($results as $result) {
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			if ($result['clicked']) {
				$percent = round($result['clicked'] / $image_clicks_total * 100, 2);
			} else {
				$percent = 0;
			}

			$this->data['banners'][] = array(
				'banner_image_id' => $result['banner_image_id'],
				'image'           => $image,
				'title'           => $result['title'],
				'link'            => $result['link'],
				'clicked'         => $result['clicked'],
				'percent'         => $percent . '%'
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_id'] = $this->language->get('column_id');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_link'] = $this->language->get('column_link');
		$this->data['column_clicked'] = $this->language->get('column_clicked');
		$this->data['column_percent'] = $this->language->get('column_percent');

		$this->data['button_reset'] = $this->language->get('button_reset');
		$this->data['button_close'] = $this->language->get('button_close');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['reset'] = $this->url->link('report/banner_clicked/reset', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$pagination = new Pagination();
		$pagination->total = $image_clicked_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/banner_clicked', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'report/banner_clicked.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function reset() {
		$this->language->load('report/banner_clicked');

		$this->load->model('design/banner');

		$this->model_design_banner->resetClicks();

		$this->session->data['success'] = $this->language->get('text_success');

		$this->redirect($this->url->link('report/banner_clicked', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
