<?php
class ControllerShippingRoyalMail extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('shipping/royal_mail');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('royal_mail', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('shipping/royal_mail', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['entry_rate'] = $this->language->get('entry_rate');
		$this->data['entry_rate_eu'] = $this->language->get('entry_rate_eu');
		$this->data['entry_rate_non_eu'] = $this->language->get('entry_rate_non_eu');
		$this->data['entry_rate_zone_1'] = $this->language->get('entry_rate_zone_1');
		$this->data['entry_rate_zone_2'] = $this->language->get('entry_rate_zone_2');
		$this->data['entry_insurance'] = $this->language->get('entry_insurance');
		$this->data['entry_display_weight'] = $this->language->get('entry_display_weight');
		$this->data['entry_display_insurance'] = $this->language->get('entry_display_insurance');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['help_international'] = $this->language->get('help_international');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_special_delivery_500'] = $this->language->get('tab_special_delivery_500');
		$this->data['tab_special_delivery_1000'] = $this->language->get('tab_special_delivery_1000');
		$this->data['tab_special_delivery_2500'] = $this->language->get('tab_special_delivery_2500');
		$this->data['tab_1st_class_signed'] = $this->language->get('tab_1st_class_signed');
		$this->data['tab_2nd_class_signed'] = $this->language->get('tab_2nd_class_signed');
		$this->data['tab_1st_class_standard'] = $this->language->get('tab_1st_class_standard');
		$this->data['tab_2nd_class_standard'] = $this->language->get('tab_2nd_class_standard');
		$this->data['tab_international_standard'] = $this->language->get('tab_international_standard');
		$this->data['tab_international_tracked_signed'] = $this->language->get('tab_international_tracked_signed');
		$this->data['tab_international_tracked'] = $this->language->get('tab_international_tracked');
		$this->data['tab_international_signed'] = $this->language->get('tab_international_signed');
		$this->data['tab_international_economy'] = $this->language->get('tab_international_economy');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_shipping'),
			'href'      => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('shipping/royal_mail', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		$this->data['action'] = $this->url->link('shipping/royal_mail', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		// Special Delivery < 500
		if (isset($this->request->post['royal_mail_special_delivery_500_rate'])) {
			$this->data['royal_mail_special_delivery_500_rate'] = $this->request->post['royal_mail_special_delivery_500_rate'];
		} elseif ($this->config->has('royal_mail_special_delivery_500_rate')) {
			$this->data['royal_mail_special_delivery_500_rate'] = $this->config->get('royal_mail_special_delivery_500_rate');
		} else {
			$this->data['royal_mail_special_delivery_500_rate'] = '0.1:6.40,0.5:7.15,1:8.45,2:11.00,10:26.60,20:41.20';
		}

		if (isset($this->request->post['royal_mail_special_delivery_500_insurance'])) {
			$this->data['royal_mail_special_delivery_500_insurance'] = $this->request->post['royal_mail_special_delivery_500_insurance'];
		} elseif ($this->config->has('royal_mail_special_delivery_500_insurance')) {
			$this->data['royal_mail_special_delivery_500_insurance'] = $this->config->get('royal_mail_special_delivery_500_insurance');
		} else {
			$this->data['royal_mail_special_delivery_500_insurance'] = '0:500';
		}

		if (isset($this->request->post['royal_mail_special_delivery_500_status'])) {
			$this->data['royal_mail_special_delivery_500_status'] = $this->request->post['royal_mail_special_delivery_500_status'];
		} else {
			$this->data['royal_mail_special_delivery_500_status'] = $this->config->get('royal_mail_special_delivery_500_status');
		}

		// Special Delivery < 1000
		if (isset($this->request->post['royal_mail_special_delivery_1000_rate'])) {
			$this->data['royal_mail_special_delivery_1000_rate'] = $this->request->post['royal_mail_special_delivery_1000_rate'];
		} elseif ($this->config->has('royal_mail_special_delivery_1000_rate')) {
			$this->data['royal_mail_special_delivery_1000_rate'] = $this->config->get('royal_mail_special_delivery_1000_rate');
		} else {
			$this->data['royal_mail_special_delivery_1000_rate'] = '0.1:7.40,0.5:8.15,1:9.45,2:12.00,10:27.60,20:42.20';
		}

		if (isset($this->request->post['royal_mail_special_delivery_1000_insurance'])) {
			$this->data['royal_mail_special_delivery_1000_insurance'] = $this->request->post['royal_mail_special_delivery_1000_insurance'];
		} elseif ($this->config->has('royal_mail_special_delivery_1000_insurance')) {
			$this->data['royal_mail_special_delivery_1000_insurance'] = $this->config->get('royal_mail_special_delivery_1000_insurance');
		} else {
			$this->data['royal_mail_special_delivery_1000_insurance'] = '0:1000';
		}

		if (isset($this->request->post['royal_mail_special_delivery_1000_status'])) {
			$this->data['royal_mail_special_delivery_1000_status'] = $this->request->post['royal_mail_special_delivery_1000_status'];
		} else {
			$this->data['royal_mail_special_delivery_1000_status'] = $this->config->get('royal_mail_special_delivery_1000_status');
		}

		// Special Delivery < 2500
		if (isset($this->request->post['royal_mail_special_delivery_2500_rate'])) {
			$this->data['royal_mail_special_delivery_2500_rate'] = $this->request->post['royal_mail_special_delivery_2500_rate'];
		} elseif ($this->config->has('royal_mail_special_delivery_2500_rate')) {
			$this->data['royal_mail_special_delivery_2500_rate'] = $this->config->get('royal_mail_special_delivery_2500_rate');
		} else {
			$this->data['royal_mail_special_delivery_2500_rate'] = '0.1:9.40,0.5:10.15,1:11.45,2:14.00,10:29.60,20:44.20';
		}

		if (isset($this->request->post['royal_mail_special_delivery_2500_insurance'])) {
			$this->data['royal_mail_special_delivery_2500_insurance'] = $this->request->post['royal_mail_special_delivery_2500_insurance'];
		} elseif ($this->config->has('royal_mail_special_delivery_2500_insurance')) {
			$this->data['royal_mail_special_delivery_2500_insurance'] = $this->config->get('royal_mail_special_delivery_2500_insurance');
		} else {
			$this->data['royal_mail_special_delivery_2500_insurance'] = '0:2500';
		}

		if (isset($this->request->post['royal_mail_special_delivery_2500_status'])) {
			$this->data['royal_mail_special_delivery_2500_status'] = $this->request->post['royal_mail_special_delivery_2500_status'];
		} else {
			$this->data['royal_mail_special_delivery_2500_status'] = $this->config->get('royal_mail_special_delivery_2500_status');
		}

		// 1st Class Signed
		if (isset($this->request->post['royal_mail_1st_class_signed_rate'])) {
			$this->data['royal_mail_1st_class_signed_rate'] = $this->request->post['royal_mail_1st_class_signed_rate'];
		} elseif ($this->config->has('royal_mail_1st_class_signed_rate')) {
			$this->data['royal_mail_1st_class_signed_rate'] = $this->config->get('royal_mail_1st_class_signed_rate');
		} else {
			$this->data['royal_mail_1st_class_signed_rate'] = '0.1:2.03,0.25:2.34,0.5:2.75,0.75:3.48,1:6.75,2:10.00,5:16.95,10:23.00,20:34.50';
		}

		if (isset($this->request->post['royal_mail_1st_class_signed_status'])) {
			$this->data['royal_mail_1st_class_signed_status'] = $this->request->post['royal_mail_1st_class_signed_status'];
		} else {
			$this->data['royal_mail_1st_class_signed_status'] = $this->config->get('royal_mail_1st_class_signed_status');
		}

		// 2nd Class Signed
		if (isset($this->request->post['royal_mail_2nd_class_signed_rate'])) {
			$this->data['royal_mail_2nd_class_signed_rate'] = $this->request->post['royal_mail_2nd_class_signed_rate'];
		} elseif ($this->config->has('royal_mail_2nd_class_signed_rate')) {
			$this->data['royal_mail_2nd_class_signed_rate'] = $this->config->get('royal_mail_2nd_class_signed_rate');
		} else {
			$this->data['royal_mail_2nd_class_signed_rate'] = '0.1:1.83,0.25:2.27,0.5:2.58,0.75:3.11,1:6.30,2:9.10,5:14.85,10:21.35,20:29.65';
		}

		if (isset($this->request->post['royal_mail_2nd_class_signed_status'])) {
			$this->data['royal_mail_2nd_class_signed_status'] = $this->request->post['royal_mail_2nd_class_signed_status'];
		} else {
			$this->data['royal_mail_2nd_class_signed_status'] = $this->config->get('royal_mail_2nd_class_signed_status');
		}

		// 1st Class Standard
		if (isset($this->request->post['royal_mail_1st_class_standard_rate'])) {
			$this->data['royal_mail_1st_class_standard_rate'] = $this->request->post['royal_mail_1st_class_standard_rate'];
		} elseif ($this->config->has('royal_mail_1st_class_standard_rate')) {
			$this->data['royal_mail_1st_class_standard_rate'] = $this->config->get('royal_mail_1st_class_standard_rate');
		} else {
			$this->data['royal_mail_1st_class_standard_rate'] = '0.1:0.93,0.25:1.24,0.5:1.65,0.75:2.38,1:5.65,2:8.90,5:15.85,10:21.90,20:33.40';
		}

		if (isset($this->request->post['royal_mail_1st_class_standard_status'])) {
			$this->data['royal_mail_1st_class_standard_status'] = $this->request->post['royal_mail_1st_class_standard_status'];
		} else {
			$this->data['royal_mail_1st_class_standard_status'] = $this->config->get('royal_mail_1st_class_standard_status');
		}

		// 2nd Class Standard
		if (isset($this->request->post['royal_mail_2nd_class_standard_rate'])) {
			$this->data['royal_mail_2nd_class_standard_rate'] = $this->request->post['royal_mail_2nd_class_standard_rate'];
		} elseif ($this->config->has('royal_mail_2nd_class_standard_rate')) {
			$this->data['royal_mail_2nd_class_standard_rate'] = $this->config->get('royal_mail_2nd_class_standard_rate');
		} else {
			$this->data['royal_mail_2nd_class_standard_rate'] = '0.1:0.73,.25:1.17,.5:1.48,.75:2.01,1:5.20,2:8.00,5:13.75,10:20.25,20:28.55';
		}

		if (isset($this->request->post['royal_mail_2nd_class_standard_status'])) {
			$this->data['royal_mail_2nd_class_standard_status'] = $this->request->post['royal_mail_2nd_class_standard_status'];
		} else {
			$this->data['royal_mail_2nd_class_standard_status'] = $this->config->get('royal_mail_2nd_class_standard_status');
		}

		// International Standard
		if (isset($this->request->post['royal_mail_international_standard_eu_rate'])) {
			$this->data['royal_mail_international_standard_eu_rate'] = $this->request->post['royal_mail_international_standard_eu_rate'];
		} elseif ($this->config->has('royal_mail_international_standard_eu_rate')) {
			$this->data['royal_mail_international_standard_eu_rate'] = $this->config->get('royal_mail_international_standard_eu_rate');
		} else {
			$this->data['royal_mail_international_standard_eu_rate'] = '0.01:0.97,0.02:0.97,0.06:1.47,0.1:3.20,0.25:3.70,0.5:5.15,0.75:6.60,1.25:9.50,1.5:10.95,1.75:12.40,2:13.85';
		}

		if (isset($this->request->post['royal_mail_international_standard_zone_1_rate'])) {
			$this->data['royal_mail_international_standard_zone_1_rate'] = $this->request->post['royal_mail_international_standard_zone_1_rate'];
		} elseif ($this->config->has('royal_mail_international_standard_zone_1_rate')) {
			$this->data['royal_mail_international_standard_zone_1_rate'] = $this->config->get('royal_mail_international_standard_zone_1_rate');
		} else {
			$this->data['royal_mail_international_standard_zone_1_rate'] = '0.01:0.97,0.02:1.28,0.06:2.15,0.1:3.80,0.25:4.75,0.5:7.45,0.75:10.15,1:12.85,1.25:15.55,1.5:18.25,1.75:20.95,2:23.65';
		}

		if (isset($this->request->post['royal_mail_international_standard_zone_2_rate'])) {
			$this->data['royal_mail_international_standard_zone_2_rate'] = $this->request->post['royal_mail_international_standard_zone_2_rate'];
		} elseif ($this->config->has('royal_mail_international_standard_zone_2_rate')) {
			$this->data['royal_mail_international_standard_zone_2_rate'] = $this->config->get('royal_mail_international_standard_zone_2_rate');
		} else {
			$this->data['royal_mail_international_standard_zone_2_rate'] = '0.01:0.97,0.02:1.28,0.06:2.15,0.1:4.00,0.25:5.05,0.5:7.90,0.75:10.75,1:13.60,1.25:16.45,1.5:19.30,1.75:22.15,2:25.00';
		}

		if (isset($this->request->post['royal_mail_international_standard_status'])) {
			$this->data['royal_mail_international_standard_status'] = $this->request->post['royal_mail_international_standard_status'];
		} else {
			$this->data['royal_mail_international_standard_status'] = $this->config->get('royal_mail_international_standard_status');
		}

		// International Tracked & Signed
		if (isset($this->request->post['royal_mail_international_tracked_signed_eu_rate'])) {
			$this->data['royal_mail_international_tracked_signed_eu_rate'] = $this->request->post['royal_mail_international_tracked_signed_eu_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_signed_eu_rate')) {
			$this->data['royal_mail_international_tracked_signed_eu_rate'] = $this->config->get('royal_mail_international_tracked_signed_eu_rate');
		} else {
			$this->data['royal_mail_international_tracked_signed_eu_rate'] = '0.02:5.97,0.06:6.47,0.1:8.20,0.25:8.70,0.50:10.15,0.75:11.60,1:13.05,1.25:14.50,1.5:15.95,1.75:17.40,2:18.85';
		}

		if (isset($this->request->post['royal_mail_international_tracked_signed_zone_1_rate'])) {
			$this->data['royal_mail_international_tracked_signed_zone_1_rate'] = $this->request->post['royal_mail_international_tracked_signed_zone_1_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_signed_zone_1_rate')) {
			$this->data['royal_mail_international_tracked_signed_zone_1_rate'] = $this->config->get('royal_mail_international_tracked_signed_zone_1_rate');
		} else {
			$this->data['royal_mail_international_tracked_signed_zone_1_rate'] = '0.02:6.28,0.06:7.15,0.1:8.80,0.25:9.75,0.5:12.45,0.75:15.15,1:17.85,1.25:20.55,1.5:23.25,1.75:25.95,2:28.65';
		}

		if (isset($this->request->post['royal_mail_international_tracked_signed_zone_2_rate'])) {
			$this->data['royal_mail_international_tracked_signed_zone_2_rate'] = $this->request->post['royal_mail_international_tracked_signed_zone_2_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_signed_zone_2_rate')) {
			$this->data['royal_mail_international_tracked_signed_zone_2_rate'] = $this->config->get('royal_mail_international_tracked_signed_zone_2_rate');
		} else {
			$this->data['royal_mail_international_tracked_signed_zone_2_rate'] = '0.02:6.28,0.06:7.15,0.1:9.00,0.25:10.05,0.5:12.90,0.75:15.75,1:18.60,1.25:21.45,1.5:24.30,1.75:27.15,2:30.00';
		}

		if (isset($this->request->post['royal_mail_international_tracked_signed_status'])) {
			$this->data['royal_mail_international_tracked_signed_status'] = $this->request->post['royal_mail_international_tracked_signed_status'];
		} else {
			$this->data['royal_mail_international_tracked_signed_status'] = $this->config->get('royal_mail_international_tracked_signed_status');
		}

		// International Tracked
		// Europe
		if (isset($this->request->post['royal_mail_international_tracked_eu_rate'])) {
			$this->data['royal_mail_international_tracked_eu_rate'] = $this->request->post['royal_mail_international_tracked_eu_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_eu_rate')) {
			$this->data['royal_mail_international_tracked_eu_rate'] = $this->config->get('royal_mail_international_tracked_eu_rate');
		} else {
			$this->data['royal_mail_international_tracked_eu_rate'] = '0.02:7.16,0.06:7.76,0.1:9.84,0.25:10.44,0.5:12.18,0.75:13.92,1:15.66,1.25:17.40,1.5:19.14,1.75:20.88,2:22.62';
		}

		// International Tracked
		// Non Europe
		if (isset($this->request->post['royal_mail_international_tracked_non_eu_rate'])) {
			$this->data['royal_mail_international_tracked_non_eu_rate'] = $this->request->post['royal_mail_international_tracked_non_eu_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_non_eu_rate')) {
			$this->data['royal_mail_international_tracked_non_eu_rate'] = $this->config->get('royal_mail_international_tracked_non_eu_rate');
		} else {
			$this->data['royal_mail_international_tracked_non_eu_rate'] = '0.02:5.97,0.06:6.47,0.1:8.20,0.25:8.70,0.5:10.15,0.75:11.60,1:13.05,1.25:14.50,1.5:15.95,1.75:17.40,2:18.85';
		}

		// International Tracked
		// World Zones 1
		if (isset($this->request->post['royal_mail_international_tracked_zone_1_rate'])) {
			$this->data['royal_mail_international_tracked_zone_1_rate'] = $this->request->post['royal_mail_international_tracked_zone_1_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_zone_1_rate')) {
			$this->data['royal_mail_international_tracked_zone_1_rate'] = $this->config->get('royal_mail_international_tracked_zone_1_rate');
		} else {
			$this->data['royal_mail_international_tracked_zone_1_rate'] = '0.02:5.97,0.06:6.47,0.1:8.80,0.25:9.75,0.5:12.45,0.75:15.15,1:17.85,1.25:20.55,1.5:23.25,1.75:25.95,2:28.65';
		}

		// International Tracked
		// World Zones 2
		if (isset($this->request->post['royal_mail_international_tracked_zone_2_rate'])) {
			$this->data['royal_mail_international_tracked_zone_2_rate'] = $this->request->post['royal_mail_international_tracked_zone_2_rate'];
		} elseif ($this->config->has('royal_mail_international_tracked_zone_2_rate')) {
			$this->data['royal_mail_international_tracked_zone_2_rate'] = $this->config->get('royal_mail_international_tracked_zone_2_rate');
		} else {
			$this->data['royal_mail_international_tracked_zone_2_rate'] = '0.02:6.28,0.06:7.15,0.1:9.00,0.25:10.05,0.5:12.90,0.75:15.75,1:18.60,1.25:21.45,1.5:24.30,1.75:27.15,2:30.00';
		}

		if (isset($this->request->post['royal_mail_international_tracked_status'])) {
			$this->data['royal_mail_international_tracked_status'] = $this->request->post['royal_mail_international_tracked_status'];
		} else {
			$this->data['royal_mail_international_tracked_status'] = $this->config->get('royal_mail_international_tracked_status');
		}

		// International Signed
		// Europe
		if (isset($this->request->post['royal_mail_international_signed_eu_rate'])) {
			$this->data['royal_mail_international_signed_eu_rate'] = $this->request->post['royal_mail_international_signed_eu_rate'];
		} elseif ($this->config->has('royal_mail_international_signed_eu_rate')) {
			$this->data['royal_mail_international_signed_eu_rate'] = $this->config->get('royal_mail_international_signed_eu_rate');
		} else {
			$this->data['royal_mail_international_signed_eu_rate'] = '0.02:5.97,0.06:6.47,0.1:8.20,0.25:8.70,0.5:10.15,0.75:11.60,1:13.05,1.25:14.50,1.5:15.95,1.75:17.40,2:18.85';
		}

		// International Signed
		// World Zones 1
		if (isset($this->request->post['royal_mail_international_signed_zone_1_rate'])) {
			$this->data['royal_mail_international_signed_zone_1_rate'] = $this->request->post['royal_mail_international_signed_zone_1_rate'];
		} elseif ($this->config->has('royal_mail_international_signed_zone_1_rate')) {
			$this->data['royal_mail_international_signed_zone_1_rate'] = $this->config->get('royal_mail_international_signed_zone_1_rate');
		} else {
			$this->data['royal_mail_international_signed_zone_1_rate'] = '0.02:6.28,0.06:7.15,0.1:8.80,0.25:9.75,0.5:12.45,0.75:15.15,1:17.85,1.25:20.55,1.5:23.25,1.75:25.95,2:28.65';
		}

		// International Signed
		// World Zones 2
		if (isset($this->request->post['royal_mail_international_signed_zone_2_rate'])) {
			$this->data['royal_mail_international_signed_zone_2_rate'] = $this->request->post['royal_mail_international_signed_zone_2_rate'];
		} elseif ($this->config->has('royal_mail_international_signed_zone_2_rate')) {
			$this->data['royal_mail_international_signed_zone_2_rate'] = $this->config->get('royal_mail_international_signed_zone_2_rate');
		} else {
			$this->data['royal_mail_international_signed_zone_2_rate'] = '0.02:6.28,0.06:7.15,0.1:9.00,0.25:10.05,0.5:12.90,0.75:15.75,1:18.60,1.25:21.45,1.5:24.30,1.75:27.15,2:30.00';
		}

		if (isset($this->request->post['royal_mail_international_signed_status'])) {
			$this->data['royal_mail_international_signed_status'] = $this->request->post['royal_mail_international_signed_status'];
		} else {
			$this->data['royal_mail_international_signed_status'] = $this->config->get('royal_mail_international_signed_status');
		}

		// International Economy
		if (isset($this->request->post['royal_mail_international_economy_rate'])) {
			$this->data['royal_mail_international_economy_rate'] = $this->request->post['royal_mail_international_economy_rate'];
		} elseif ($this->config->has('royal_mail_international_economy_rate')) {
			$this->data['royal_mail_international_economy_rate'] = $this->config->get('royal_mail_international_economy_rate');
		} else {
			$this->data['royal_mail_international_economy_rate'] = '0.02:0.81,0.06:1.43,0.1:2.80,0.25:3.65,0.5:5.10,0.75:6.55,1:8.00,1.25:9.45,1.5:10.90,1.75:12.35,2:13.80';
		}

		if (isset($this->request->post['royal_mail_international_economy_status'])) {
			$this->data['royal_mail_international_economy_status'] = $this->request->post['royal_mail_international_economy_status'];
		} else {
			$this->data['royal_mail_international_economy_status'] = $this->config->get('royal_mail_international_economy_status');
		}

		if (isset($this->request->post['royal_mail_display_weight'])) {
			$this->data['royal_mail_display_weight'] = $this->request->post['royal_mail_display_weight'];
		} else {
			$this->data['royal_mail_display_weight'] = $this->config->get('royal_mail_display_weight');
		}

		if (isset($this->request->post['royal_mail_display_insurance'])) {
			$this->data['royal_mail_display_insurance'] = $this->request->post['royal_mail_display_insurance'];
		} else {
			$this->data['royal_mail_display_insurance'] = $this->config->get('royal_mail_display_insurance');
		}

		if (isset($this->request->post['royal_mail_weight_class_id'])) {
			$this->data['royal_mail_weight_class_id'] = $this->request->post['royal_mail_weight_class_id'];
		} else {
			$this->data['royal_mail_weight_class_id'] = $this->config->get('royal_mail_weight_class_id');
		}

		$this->load->model('localisation/weight_class');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['royal_mail_tax_class_id'])) {
			$this->data['royal_mail_tax_class_id'] = $this->request->post['royal_mail_tax_class_id'];
		} else {
			$this->data['royal_mail_tax_class_id'] = $this->config->get('royal_mail_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['royal_mail_geo_zone_id'])) {
			$this->data['royal_mail_geo_zone_id'] = $this->request->post['royal_mail_geo_zone_id'];
		} else {
			$this->data['royal_mail_geo_zone_id'] = $this->config->get('royal_mail_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['royal_mail_status'])) {
			$this->data['royal_mail_status'] = $this->request->post['royal_mail_status'];
		} else {
			$this->data['royal_mail_status'] = $this->config->get('royal_mail_status');
		}

		if (isset($this->request->post['royal_mail_sort_order'])) {
			$this->data['royal_mail_sort_order'] = $this->request->post['royal_mail_sort_order'];
		} else {
			$this->data['royal_mail_sort_order'] = $this->config->get('royal_mail_sort_order');
		}

		$this->template = 'shipping/royal_mail.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/royal_mail')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return empty($this->error);
	}
}
