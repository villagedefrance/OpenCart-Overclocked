<?php
class ControllerAffiliateForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->affiliate->isLogged()) {
			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

		$this->language->load('affiliate/forgotten');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('affiliate/affiliate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->language->load('mail/forgotten');

			$password = substr(hash_rand('md5'), 0, 10);

			$this->model_affiliate_affiliate->editPassword($this->request->post['email'], $password);

			$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

			$message = sprintf($this->language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
			$message .= $this->language->get('text_password') . "\n\n";
			$message .= $password;

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = html_entity_decode($this->config->get('config_smtp_password'), ENT_QUOTES, 'UTF-8');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');

			$mail->setTo($this->request->post['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
			$mail->setSubject($subject);
			$mail->setText($message);
			$mail->send();

			// Add to activity log
			if ($this->config->get('config_affiliate_activity')) {
				$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByEmail($this->request->post['email']);

				if ($affiliate_info) {
					$affiliate_id = $this->affiliate->getId();
					$affiliate_name = $this->affiliate->getFirstName() . ' ' . $this->affiliate->getLastName();

					$this->model_affiliate_affiliate->addActivity($affiliate_id, 'forgotten', $affiliate_name);
				}
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_forgotten'),
			'href'      => $this->url->link('affiliate/forgotten', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_your_email'] = $this->language->get('text_your_email');
		$this->data['text_email'] = $this->language->get('text_email');

		$this->data['entry_email'] = $this->language->get('entry_email');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['action'] = $this->url->link('affiliate/forgotten', '', 'SSL');
		$this->data['back'] = $this->url->link('affiliate/login', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/forgotten.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/forgotten.tpl';
		} else {
			$this->template = 'default/template/affiliate/forgotten.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_header',
			'common/content_top',
			'common/content_bottom',
			'common/content_footer',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!isset($this->request->post['email']) || (utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		$this->load->model('affiliate/affiliate');

		if (isset($this->request->post['email'])) {
			// Email exists check
			$email_unknown = $this->model_affiliate_affiliate->getTotalAffiliatesByEmail($this->request->post['email']) ? false : true;

			if ($email_unknown) {
				$this->error['warning'] = $this->language->get('error_unknown');
			}

			// Email MX Record check
			$this->load->model('tool/email');

			$email_valid = $this->model_tool_email->verifyMail($this->request->post['email']);

			if (!$email_valid) {
				$this->error['email'] = $this->language->get('error_email');
			}
		}

		$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByEmail($this->request->post['email']);

		if ($affiliate_info && !$affiliate_info['approved']) {
		    $this->error['warning'] = $this->language->get('error_approved');
		}

		return empty($this->error);
	}
}
