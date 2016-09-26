<?php
class ControllerReportRobotOnline extends Controller {

	public function index() {
		$this->language->load('report/robot_online');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_ip'])) {
			$filter_ip = $this->request->get['filter_ip'];
		} else {
			$filter_ip = null;
		}

		if (isset($this->request->get['filter_robot'])) {
			$filter_robot = $this->request->get['filter_robot'];
		} else {
			$filter_robot = null;
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_robot'])) {
			$url .= '&filter_robot=' . urlencode(html_entity_decode($this->request->get['filter_robot'], ENT_QUOTES, 'UTF-8'));
		}

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
			'href'      => $this->url->link('report/robot_online', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		// Pagination
		$this->data['navigation_hi'] = $this->config->get('config_pagination_hi');
		$this->data['navigation_lo'] = $this->config->get('config_pagination_lo');

		$this->load->model('report/online');

		$this->data['robots'] = array();

		$data = array(
			'filter_ip'    => $filter_ip,
			'filter_robot' => $filter_robot,
			'start'        => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'        => $this->config->get('config_admin_limit')
		);

		$robot_total = $this->model_report_online->getTotalRobotsOnline($data);

		$results = $this->model_report_online->getRobotsOnline($data);

		foreach ($results as $result) {
			$this->data['robots'][] = array(
				'ip'         => $result['ip'],
				'robot'      => $result['robot'],
				'user_agent' => $result['user_agent'],
				'date_added' => date($this->language->get('date_format_time'), strtotime($result['date_added']))
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_tracking'] = $this->language->get('text_tracking');

		$this->data['column_ip'] = $this->language->get('column_ip');
		$this->data['column_robot'] = $this->language->get('column_robot');
		$this->data['column_user_agent'] = $this->language->get('column_user_agent');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_close'] = $this->language->get('button_close');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['close'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['tracking'] = $this->config->get('config_robots_online');

		$this->data['token'] = $this->session->data['token'];

		$url = '';

		if (isset($this->request->get['filter_ip'])) {
			$url .= '&filter_ip=' . $this->request->get['filter_ip'];
		}

		if (isset($this->request->get['filter_robot'])) {
			$url .= '&filter_robot=' . urlencode(html_entity_decode($this->request->get['filter_robot'], ENT_QUOTES, 'UTF-8'));
		}

		$pagination = new Pagination();
		$pagination->total = $robot_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/robot_online', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_ip'] = $filter_ip;
		$this->data['filter_robot'] = $filter_robot;

		$this->template = 'report/robot_online.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
