<?php
class ControllerInformationQuote extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('information/quote');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			unset($this->session->data['captcha']);

			// Log quote
			$quote_log = $this->request->post['name'] . " ( " . $this->request->post['email'] . " ) :\n";
			$quote_log .= sprintf($this->language->get('email_product'), $this->request->post['product']) . "\n\n";
			$quote_log .= $this->request->post['enquiry'] . "\n\n";
			$quote_log .= "------------------------------------------------------------- \n";

			$quote_file = DIR_LOGS . $this->config->get('config_quote_filename');

			$handle = fopen($quote_file, 'a+');

			fwrite($handle, date('Y-m-d G:i:s') . ' - ' . print_r($quote_log, true));

			fclose($handle);

			// Send mail
			$message = sprintf($this->language->get('email_product'), $this->request->post['product']) . "\n\n";
			$message .= strip_tags(html_entity_decode($this->request->post['enquiry'], ENT_QUOTES, 'UTF-8')) . "\n";

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');

			$mail->setTo($this->config->get('config_email'));
			$mail->setFrom($this->request->post['email']);
			$mail->setSender($this->request->post['name']);
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('email_subject'), $this->request->post['name']), ENT_QUOTES, 'UTF-8'));
			$mail->setText($message);
			$mail->send();

			$this->redirect($this->url->link('information/quote/success', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/quote', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_quote'] = $this->language->get('text_quote');
		$this->data['text_location'] = $this->language->get('text_location');
		$this->data['text_file_upload'] = $this->language->get('text_file_upload');
		$this->data['text_file_size'] = sprintf($this->language->get('text_file_size'), $this->config->get('config_file_max_size'));
		$this->data['text_none'] = $this->language->get('text_none');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_product'] = $this->language->get('entry_product');
		$this->data['entry_enquiry'] = $this->language->get('entry_enquiry');
		$this->data['entry_captcha'] = $this->language->get('entry_captcha');

		$this->data['button_upload'] = $this->language->get('button_upload');

		$this->data['hide_address'] = $this->config->get('config_store_address');

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['enquiry'])) {
			$this->data['error_enquiry'] = $this->error['enquiry'];
		} else {
			$this->data['error_enquiry'] = '';
		}

		if (isset($this->error['captcha'])) {
			$this->data['error_captcha'] = $this->error['captcha'];
		} else {
			$this->data['error_captcha'] = '';
		}

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['action'] = $this->url->link('information/quote', '', 'SSL');

		$this->data['store'] = $this->config->get('config_name');
		$this->data['address'] = nl2br($this->config->get('config_address'));
		$this->data['telephone'] = $this->config->get('config_telephone');
		$this->data['fax'] = $this->config->get('config_fax');

		$this->load->model('catalog/product');

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif ($this->customer->isLogged() && $this->customer->isSecure()) {
			$this->data['name'] = $this->customer->getFirstName() . ' ' . $this->customer->getLastName();
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif ($this->customer->isLogged() && $this->customer->isSecure()) {
			$this->data['email'] = $this->customer->getEmail();
		} else {
			$this->data['email'] = '';
		}

		$this->data['products'] = array();

		$results = $this->model_catalog_product->getProducts(0);

		foreach ($results as $result) {
			if ($result['model']) {
				$model = $result['model'];
			} else {
				$model = false;
			}

			if ($result['quote']) {
				$this->data['products'][] = array(
					'product_id' => $result['product_id'],
					'name'       => $result['name'],
					'quote'      => $result['quote'],
					'model'      => $model
				);
			}
		}

		if (isset($this->request->post['product'])) {
			$this->data['product'] = $this->request->post['product'];
		} else {
			$this->data['product'] = '';
		}

		if (isset($this->request->post['enquiry'])) {
			$this->data['enquiry'] = $this->request->post['enquiry'];
		} else {
			$this->data['enquiry'] = '';
		}

		if (isset($this->request->post['captcha'])) {
			$this->data['captcha'] = $this->request->post['captcha'];
		} else {
			$this->data['captcha'] = '';
		}

		$this->data['captcha_image'] = $this->url->link('information/quote/captcha', '', 'SSL');

		// Create directory if it does not exist
		$directory = DIR_SYSTEM . 'logs/';

		if (!is_dir($directory)) {
			mkdir(DIR_SYSTEM . 'logs', 0777);
		}

		// Create file if it does not exist
		$quote_file = DIR_LOGS . $this->config->get('config_quote_filename');

		if (!file_exists($quote_file)) {
			$handle = fopen($quote_file, 'w+');

			fclose($handle);
		}

		clearstatcache();

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/quote.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/quote.tpl';
		} else {
			$this->template = 'default/template/information/quote.tpl';
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

	public function success() {
		$this->language->load('information/quote');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/quote', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_message'] = $this->language->get('text_message');

		$this->data['button_continue'] = $this->language->get('button_continue');

		$this->data['continue'] = $this->url->link('common/home', '', 'SSL');

		// Theme
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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
		if (!isset($this->request->post['name']) || (utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!isset($this->request->post['email']) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if (isset($this->request->post['email'])) {
			// Email MX Record check
			$this->load->model('tool/email');

			$email_valid = $this->model_tool_email->verifyMail($this->request->post['email']);

			if (!$email_valid) {
				$this->error['email'] = $this->language->get('error_email');
			}
		}

		if (!isset($this->request->post['enquiry']) || (utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000)) {
			$this->error['enquiry'] = $this->language->get('error_enquiry');
		}

		if (!isset($this->request->post['captcha']) || empty($this->session->data['captcha']) || ($this->session->data['captcha'] != strtolower($this->request->post['captcha']))) {
			$this->error['captcha'] = $this->language->get('error_captcha');
		}

		return empty($this->error);
	}

	public function upload() {
		$this->language->load('information/quote');

		$json = array();

		if (!empty($this->request->files['file']['name']) && is_file($this->request->files['file']['tmp_name'])) {
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 64)) {
				$json['error'] = $this->language->get('error_filename');
			}

			// Allowed file extension types
			$allowed = array();

			$filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", $this->config->get('config_file_extension_allowed')));

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array(substr(strrchr($filename, '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Allowed file mime types
			$allowed = array();

			$filetypes = explode("\n", str_replace(array("\r\n", "\r"), "\n", $this->config->get('config_file_mime_allowed')));

			foreach ($filetypes as $filetype) {
				$allowed[] = trim($filetype);
			}

			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}

			// Check to see if any PHP files are trying to be uploaded
 			$content = file_get_contents($this->request->files['file']['tmp_name']);

			if (preg_match('/\<\?php/i', $content)) {
				$json['error'] = $this->language->get('error_filetype');
 			}

			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}

		} else {
			$json['error'] = $this->language->get('error_upload');
		}

		if (!$json && is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
			$file = basename($filename) . '.' . hash_rand('md5');

			move_uploaded_file($this->request->files['file']['tmp_name'], DIR_UPLOAD . $file);

			// Hide the uploaded file name so people can not link to it directly.
			$this->load->model('tool/upload');

			$json['code'] = $this->model_tool_upload->addUpload($filename, $file);

			$json['success'] = $this->language->get('text_upload');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function captcha() {
		$this->load->library('captcha');

		$captcha = new Captcha();

		$this->session->data['captcha'] = $captcha->getCode();

		$captcha->showImage($this->config->get('config_captcha_font'));
	}
}
