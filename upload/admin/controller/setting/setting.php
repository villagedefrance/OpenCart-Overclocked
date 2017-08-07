<?php
class ControllerSettingSetting extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('setting/setting');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('config', $this->request->post);

			if ($this->config->get('config_currency_auto')) {
				$this->load->model('localisation/currency');

				$this->model_localisation_currency->updateCurrencies();
			}

			if ($this->config->get('config_seo_url') && !file_exists('../.htaccess')) {
				$this->load->model('tool/system');

				$this->model_tool_system->setupSeo();
			}

			$this->session->data['success'] = $this->language->get('text_success');

			if (isset($this->request->post['apply'])) {
				$this->redirect($this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL'));
			} else {
				$this->redirect($this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL'));
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_required'] = $this->language->get('text_required');
		$this->data['text_choice'] = $this->language->get('text_choice');
		$this->data['text_automatic'] = $this->language->get('text_automatic');
		$this->data['text_hide'] = $this->language->get('text_hide');
		$this->data['text_characters'] = $this->language->get('text_characters');
		$this->data['text_datetime'] = $this->language->get('text_datetime');
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_location'] = $this->language->get('text_location');
		$this->data['text_preview'] = $this->language->get('text_preview');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_account'] = $this->language->get('text_account');
		$this->data['text_one_page'] = $this->language->get('text_one_page');
		$this->data['text_express'] = $this->language->get('text_express');
		$this->data['text_stock'] = $this->language->get('text_stock');
		$this->data['text_supplier'] = $this->language->get('text_supplier');
		$this->data['text_affiliate'] = $this->language->get('text_affiliate');
		$this->data['text_return'] = $this->language->get('text_return');
		$this->data['text_voucher'] = $this->language->get('text_voucher');
		$this->data['text_forms'] = $this->language->get('text_forms');
		$this->data['text_colorbox'] = $this->language->get('text_colorbox');
		$this->data['text_fancybox'] = $this->language->get('text_fancybox');
		$this->data['text_magnific'] = $this->language->get('text_magnific');
		$this->data['text_swipebox'] = $this->language->get('text_swipebox');
		$this->data['text_zoomlens'] = $this->language->get('text_zoomlens');
		$this->data['text_captcha'] = $this->language->get('text_captcha');
		$this->data['text_cookies'] = $this->language->get('text_cookies');
		$this->data['text_black'] = $this->language->get('text_black');
		$this->data['text_white'] = $this->language->get('text_white');
		$this->data['text_top'] = $this->language->get('text_top');
		$this->data['text_bottom'] = $this->language->get('text_bottom');
		$this->data['text_news'] = $this->language->get('text_news');
		$this->data['text_image_resize'] = $this->language->get('text_image_resize');
		$this->data['text_image_labels'] = $this->language->get('text_image_labels');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_shipping'] = $this->language->get('text_shipping');
		$this->data['text_payment'] = $this->language->get('text_payment');
		$this->data['text_mail'] = $this->language->get('text_mail');
		$this->data['text_smtp'] = $this->language->get('text_smtp');
		$this->data['text_verification'] = $this->language->get('text_verification');
		$this->data['text_analytic'] = $this->language->get('text_analytic');
		$this->data['text_security'] = $this->language->get('text_security');
		$this->data['text_search_page'] = $this->language->get('text_search_page');
		$this->data['text_block_page'] = $this->language->get('text_block_page');
		$this->data['text_upload'] = $this->language->get('text_upload');

		$this->data['info_one_page'] = $this->language->get('info_one_page');
		$this->data['info_express'] = $this->language->get('info_express');
		$this->data['info_meta_name'] = $this->language->get('info_meta_name');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_store'] = $this->language->get('tab_store');
		$this->data['tab_local'] = $this->language->get('tab_local');
		$this->data['tab_checkout'] = $this->language->get('tab_checkout');
		$this->data['tab_option'] = $this->language->get('tab_option');
		$this->data['tab_preference'] = $this->language->get('tab_preference');
		$this->data['tab_image'] = $this->language->get('tab_image');
		$this->data['tab_ftp'] = $this->language->get('tab_ftp');
		$this->data['tab_mail'] = $this->language->get('tab_mail');
		$this->data['tab_media'] = $this->language->get('tab_media');
		$this->data['tab_server'] = $this->language->get('tab_server');

		$google_api_link = 'https://developers.google.com/maps/documentation/embed/start';

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_owner'] = $this->language->get('entry_owner');
		$this->data['entry_address'] = $this->language->get('entry_address');
		$this->data['entry_email'] = $this->language->get('entry_email');
		$this->data['entry_email_noreply'] = $this->language->get('entry_email_noreply');
		$this->data['entry_telephone'] = $this->language->get('entry_telephone');
		$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_company_tax_id'] = $this->language->get('entry_company_tax_id');
		$this->data['entry_title'] = $this->language->get('entry_title');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_template'] = $this->language->get('entry_template');
		$this->data['entry_country'] = $this->language->get('entry_country');
		$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_language'] = $this->language->get('entry_language');
		$this->data['entry_admin_language'] = $this->language->get('entry_admin_language');
		$this->data['entry_currency'] = $this->language->get('entry_currency');
		$this->data['entry_currency_auto'] = $this->language->get('entry_currency_auto');
		$this->data['entry_length_class'] = $this->language->get('entry_length_class');
		$this->data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$this->data['entry_date_format'] = $this->language->get('entry_date_format');
		$this->data['entry_time_offset'] = $this->language->get('entry_time_offset');
		$this->data['entry_store_address'] = $this->language->get('entry_store_address');
		$this->data['entry_store_latitude'] = $this->language->get('entry_store_latitude');
		$this->data['entry_store_longitude'] = $this->language->get('entry_store_longitude');
		$this->data['entry_store_location'] = $this->language->get('entry_store_location');
		$this->data['entry_map_code'] = sprintf($this->language->get('entry_map_code'), html_entity_decode($google_api_link, ENT_QUOTES, 'UTF-8'));
		$this->data['entry_map_display'] = $this->language->get('entry_map_display');
		$this->data['entry_cart_weight'] = $this->language->get('entry_cart_weight');
		$this->data['entry_guest_checkout'] = $this->language->get('entry_guest_checkout');
		$this->data['entry_checkout'] = $this->language->get('entry_checkout');
		$this->data['entry_invoice_prefix'] = $this->language->get('entry_invoice_prefix');
		$this->data['entry_auto_invoice'] = $this->language->get('entry_auto_invoice');
		$this->data['entry_order_edit'] = $this->language->get('entry_order_edit');
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_complete_status'] = $this->language->get('entry_complete_status');
		$this->data['entry_one_page_checkout'] = $this->language->get('entry_one_page_checkout');
		$this->data['entry_one_page_phone'] = $this->language->get('entry_one_page_phone');
		$this->data['entry_one_page_newsletter'] = $this->language->get('entry_one_page_newsletter');
		$this->data['entry_one_page_coupon'] = $this->language->get('entry_one_page_coupon');
		$this->data['entry_one_page_voucher'] = $this->language->get('entry_one_page_voucher');
		$this->data['entry_one_page_point'] = $this->language->get('entry_one_page_point');
		$this->data['entry_express_checkout'] = $this->language->get('entry_express_checkout');
		$this->data['entry_express_password'] = $this->language->get('entry_express_password');
		$this->data['entry_express_phone'] = $this->language->get('entry_express_phone');
		$this->data['entry_express_autofill'] = $this->language->get('entry_express_autofill');
		$this->data['entry_express_billing'] = $this->language->get('entry_express_billing');
		$this->data['entry_express_postcode'] = $this->language->get('entry_express_postcode');
		$this->data['entry_express_comment'] = $this->language->get('entry_express_comment');
		$this->data['entry_express_newsletter'] = $this->language->get('entry_express_newsletter');
		$this->data['entry_express_coupon'] = $this->language->get('entry_express_coupon');
		$this->data['entry_express_voucher'] = $this->language->get('entry_express_voucher');
		$this->data['entry_express_point'] = $this->language->get('entry_express_point');
		$this->data['entry_empty_category'] = $this->language->get('entry_empty_category');
		$this->data['entry_product_count'] = $this->language->get('entry_product_count');
		$this->data['entry_coupon_special'] = $this->language->get('entry_coupon_special');
		$this->data['entry_review'] = $this->language->get('entry_review');
		$this->data['entry_download'] = $this->language->get('entry_download');
		$this->data['entry_tax'] = $this->language->get('entry_tax');
		$this->data['entry_vat'] = $this->language->get('entry_vat');
		$this->data['entry_tax_default'] = $this->language->get('entry_tax_default');
		$this->data['entry_tax_customer'] = $this->language->get('entry_tax_customer');
		$this->data['entry_stock_display'] = $this->language->get('entry_stock_display');
		$this->data['entry_stock_warning'] = $this->language->get('entry_stock_warning');
		$this->data['entry_stock_checkout'] = $this->language->get('entry_stock_checkout');
		$this->data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$this->data['entry_supplier_group'] = $this->language->get('entry_supplier_group');
		$this->data['entry_customer_online'] = $this->language->get('entry_customer_online');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_customer_group_display'] = $this->language->get('entry_customer_group_display');
		$this->data['entry_customer_price'] = $this->language->get('entry_customer_price');
		$this->data['entry_customer_redirect'] = $this->language->get('entry_customer_redirect');
		$this->data['entry_customer_fax'] = $this->language->get('entry_customer_fax');
		$this->data['entry_customer_gender'] = $this->language->get('entry_customer_gender');
		$this->data['entry_customer_dob'] = $this->language->get('entry_customer_dob');
		$this->data['entry_picklist_status'] = $this->language->get('entry_picklist_status');
		$this->data['entry_login_attempts'] = $this->language->get('entry_login_attempts');
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_affiliate_approval'] = $this->language->get('entry_affiliate_approval');
		$this->data['entry_affiliate_auto'] = $this->language->get('entry_affiliate_auto');
		$this->data['entry_affiliate_commission'] = $this->language->get('entry_affiliate_commission');
		$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
		$this->data['entry_affiliate_mail'] = $this->language->get('entry_affiliate_mail');
		$this->data['entry_affiliate_fax'] = $this->language->get('entry_affiliate_fax');
		$this->data['entry_affiliate_activity'] = $this->language->get('entry_affiliate_activity');
		$this->data['entry_affiliate_disable'] = $this->language->get('entry_affiliate_disable');
		$this->data['entry_return'] = $this->language->get('entry_return');
		$this->data['entry_return_status'] = $this->language->get('entry_return_status');
		$this->data['entry_return_disable'] = $this->language->get('entry_return_disable');
		$this->data['entry_voucher_min'] = $this->language->get('entry_voucher_min');
		$this->data['entry_voucher_max'] = $this->language->get('entry_voucher_max');
		$this->data['entry_admin_stylesheet'] = $this->language->get('entry_admin_stylesheet');
		$this->data['entry_admin_width_limit'] = $this->language->get('entry_admin_width_limit');
		$this->data['entry_admin_menu_icons'] = $this->language->get('entry_admin_menu_icons');
		$this->data['entry_admin_limit'] = $this->language->get('entry_admin_limit');
		$this->data['entry_catalog_limit'] = $this->language->get('entry_catalog_limit');
		$this->data['entry_pagination_hi'] = $this->language->get('entry_pagination_hi');
		$this->data['entry_pagination_lo'] = $this->language->get('entry_pagination_lo');
		$this->data['entry_autocomplete_category'] = $this->language->get('entry_autocomplete_category');
		$this->data['entry_autocomplete_product'] = $this->language->get('entry_autocomplete_product');
		$this->data['entry_autocomplete_offer'] = $this->language->get('entry_autocomplete_offer');
		$this->data['entry_catalog_barcode'] = $this->language->get('entry_catalog_barcode');
		$this->data['entry_admin_barcode'] = $this->language->get('entry_admin_barcode');
		$this->data['entry_barcode_type'] = $this->language->get('entry_barcode_type');
		$this->data['entry_buy_now'] = $this->language->get('entry_buy_now');
		$this->data['entry_lightbox'] = $this->language->get('entry_lightbox');
		$this->data['entry_share_addthis'] = $this->language->get('entry_share_addthis');
		$this->data['entry_price_free'] = $this->language->get('entry_price_free');
		$this->data['entry_captcha_font'] = $this->language->get('entry_captcha_font');
		$this->data['entry_cookie_consent'] = $this->language->get('entry_cookie_consent');
		$this->data['entry_cookie_theme'] = $this->language->get('entry_cookie_theme');
		$this->data['entry_cookie_position'] = $this->language->get('entry_cookie_position');
		$this->data['entry_cookie_privacy'] = $this->language->get('entry_cookie_privacy');
		$this->data['entry_cookie_age'] = $this->language->get('entry_cookie_age');
		$this->data['entry_news_addthis'] = $this->language->get('entry_news_addthis');
		$this->data['entry_news_style'] = $this->language->get('entry_news_style');
		$this->data['entry_news_chars'] = $this->language->get('entry_news_chars');
		$this->data['entry_logo'] = $this->language->get('entry_logo');
		$this->data['entry_icon'] = $this->language->get('entry_icon');
		$this->data['entry_image_category'] = $this->language->get('entry_image_category');
		$this->data['entry_image_thumb'] = $this->language->get('entry_image_thumb');
		$this->data['entry_image_popup'] = $this->language->get('entry_image_popup');
		$this->data['entry_image_product'] = $this->language->get('entry_image_product');
		$this->data['entry_image_additional'] = $this->language->get('entry_image_additional');
		$this->data['entry_image_brand'] = $this->language->get('entry_image_brand');
		$this->data['entry_image_related'] = $this->language->get('entry_image_related');
		$this->data['entry_image_compare'] = $this->language->get('entry_image_compare');
		$this->data['entry_image_wishlist'] = $this->language->get('entry_image_wishlist');
		$this->data['entry_image_newsthumb'] = $this->language->get('entry_image_newsthumb');
		$this->data['entry_image_newspopup'] = $this->language->get('entry_image_newspopup');
		$this->data['entry_image_cart'] = $this->language->get('entry_image_cart');
		$this->data['entry_label_size_ratio'] = $this->language->get('entry_label_size_ratio');
		$this->data['entry_label_stock'] = $this->language->get('entry_label_stock');
		$this->data['entry_label_offer'] = $this->language->get('entry_label_offer');
		$this->data['entry_label_special'] = $this->language->get('entry_label_special');
		$this->data['entry_ftp_status'] = $this->language->get('entry_ftp_status');
		$this->data['entry_ftp_host'] = $this->language->get('entry_ftp_host');
		$this->data['entry_ftp_port'] = $this->language->get('entry_ftp_port');
		$this->data['entry_ftp_username'] = $this->language->get('entry_ftp_username');
		$this->data['entry_ftp_password'] = $this->language->get('entry_ftp_password');
		$this->data['entry_ftp_root'] = $this->language->get('entry_ftp_root');
		$this->data['entry_mail_protocol'] = $this->language->get('entry_mail_protocol');
		$this->data['entry_mail_parameter'] = $this->language->get('entry_mail_parameter');
		$this->data['entry_smtp_host'] = $this->language->get('entry_smtp_host');
		$this->data['entry_smtp_username'] = $this->language->get('entry_smtp_username');
		$this->data['entry_smtp_password'] = $this->language->get('entry_smtp_password');
		$this->data['entry_smtp_port'] = $this->language->get('entry_smtp_port');
		$this->data['entry_smtp_timeout'] = $this->language->get('entry_smtp_timeout');
		$this->data['entry_alert_mail'] = $this->language->get('entry_alert_mail');
		$this->data['entry_account_mail'] = $this->language->get('entry_account_mail');
		$this->data['entry_alert_emails'] = $this->language->get('entry_alert_emails');
		$this->data['entry_facebook'] = $this->language->get('entry_facebook');
		$this->data['entry_twitter'] = $this->language->get('entry_twitter');
		$this->data['entry_google'] = $this->language->get('entry_google');
		$this->data['entry_pinterest'] = $this->language->get('entry_pinterest');
		$this->data['entry_instagram'] = $this->language->get('entry_instagram');
		$this->data['entry_skype'] = $this->language->get('entry_skype');
		$this->data['entry_addthis'] = $this->language->get('entry_addthis');
		$this->data['entry_meta_google'] = $this->language->get('entry_meta_google');
		$this->data['entry_meta_bing'] = $this->language->get('entry_meta_bing');
		$this->data['entry_meta_yandex'] = $this->language->get('entry_meta_yandex');
		$this->data['entry_meta_baidu'] = $this->language->get('entry_meta_baidu');
		$this->data['entry_meta_alexa'] = $this->language->get('entry_meta_alexa');
		$this->data['entry_google_analytics'] = $this->language->get('entry_google_analytics');
		$this->data['entry_alexa_analytics'] = $this->language->get('entry_alexa_analytics');
		$this->data['entry_piwik_analytics'] = $this->language->get('entry_piwik_analytics');
		$this->data['entry_maintenance'] = $this->language->get('entry_maintenance');
		$this->data['entry_seo_url'] = $this->language->get('entry_seo_url');
		$this->data['entry_seo_url_cache'] = $this->language->get('entry_seo_url_cache');
		$this->data['entry_encryption'] = $this->language->get('entry_encryption');
		$this->data['entry_compression'] = $this->language->get('entry_compression');
		$this->data['entry_error_display'] = $this->language->get('entry_error_display');
		$this->data['entry_error_log'] = $this->language->get('entry_error_log');
		$this->data['entry_error_filename'] = $this->language->get('entry_error_filename');
		$this->data['entry_mail_filename'] = $this->language->get('entry_mail_filename');
		$this->data['entry_quote_filename'] = $this->language->get('entry_quote_filename');
		$this->data['entry_secure'] = $this->language->get('entry_secure');
		$this->data['entry_shared'] = $this->language->get('entry_shared');
		$this->data['entry_robots'] = $this->language->get('entry_robots');
		$this->data['entry_robots_online'] = $this->language->get('entry_robots_online');
		$this->data['entry_password'] = $this->language->get('entry_password');
		$this->data['entry_ban_page'] = $this->language->get('entry_ban_page');
		$this->data['entry_file_max_size'] = $this->language->get('entry_file_max_size');
		$this->data['entry_file_extension_allowed'] = $this->language->get('entry_file_extension_allowed');
		$this->data['entry_file_mime_allowed'] = $this->language->get('entry_file_mime_allowed');

		$this->data['button_themes'] = $this->language->get('button_themes');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_apply'] = $this->language->get('button_apply');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['help_meta_keyword'] = $this->language->get('help_meta_keyword');
		$this->data['help_currency'] = $this->language->get('help_currency');
		$this->data['help_currency_auto'] = $this->language->get('help_currency_auto');
		$this->data['help_date_format'] = $this->language->get('help_date_format');
		$this->data['help_time_offset'] = $this->language->get('help_time_offset');
		$this->data['help_store_address'] = $this->language->get('help_file_extension_allowed');
		$this->data['help_store_latitude'] = $this->language->get('help_store_latitude');
		$this->data['help_store_longitude'] = $this->language->get('help_store_longitude');
		$this->data['help_store_location'] = $this->language->get('help_store_location');
		$this->data['help_map_code'] = $this->language->get('help_map_code');
		$this->data['help_map_display'] = $this->language->get('help_map_display');
		$this->data['help_cart_weight'] = $this->language->get('help_cart_weight');
		$this->data['help_guest_checkout'] = $this->language->get('help_guest_checkout');
		$this->data['help_checkout'] = $this->language->get('help_checkout');
		$this->data['help_invoice_prefix'] = $this->language->get('help_invoice_prefix');
		$this->data['help_auto_invoice'] = $this->language->get('help_auto_invoice');
		$this->data['help_order_edit'] = $this->language->get('help_order_edit');
		$this->data['help_order_status'] = $this->language->get('help_order_status');
		$this->data['help_complete_status'] = $this->language->get('help_complete_status');
		$this->data['help_one_page_checkout'] = $this->language->get('help_one_page_checkout');
		$this->data['help_express_checkout'] = $this->language->get('help_express_checkout');
		$this->data['help_express_autofill'] = $this->language->get('help_express_autofill');
		$this->data['help_express_password'] = $this->language->get('help_express_password');
		$this->data['help_express_billing'] = $this->language->get('help_express_billing');
		$this->data['help_express_postcode'] = $this->language->get('help_express_postcode');
		$this->data['help_express_comment'] = $this->language->get('help_express_comment');
		$this->data['help_empty_category'] = $this->language->get('help_empty_category');
		$this->data['help_product_count'] = $this->language->get('help_product_count');
		$this->data['help_coupon_special'] = $this->language->get('help_coupon_special');
		$this->data['help_review'] = $this->language->get('help_review');
		$this->data['help_vat'] = $this->language->get('help_vat');
		$this->data['help_tax_default'] = $this->language->get('help_tax_default');
		$this->data['help_tax_customer'] = $this->language->get('help_tax_customer');
		$this->data['help_stock_display'] = $this->language->get('help_stock_display');
		$this->data['help_stock_warning'] = $this->language->get('help_stock_warning');
		$this->data['help_stock_checkout'] = $this->language->get('help_stock_checkout');
		$this->data['help_stock_status'] = $this->language->get('help_stock_status');
		$this->data['help_supplier_group'] = $this->language->get('help_supplier_group');
		$this->data['help_customer_online'] = $this->language->get('help_customer_online');
		$this->data['help_customer_group'] = $this->language->get('help_customer_group');
		$this->data['help_customer_group_display'] = $this->language->get('help_customer_group_display');
		$this->data['help_customer_price'] = $this->language->get('help_customer_price');
		$this->data['help_customer_redirect'] = $this->language->get('help_customer_redirect');
		$this->data['help_customer_dob'] = $this->language->get('help_customer_dob');
		$this->data['help_picklist_status'] = $this->language->get('help_picklist_status');
		$this->data['help_account'] = $this->language->get('help_account');
		$this->data['help_affiliate_approval'] = $this->language->get('help_affiliate_approval');
		$this->data['help_affiliate_auto'] = $this->language->get('help_affiliate_auto');
		$this->data['help_affiliate_commission'] = $this->language->get('help_affiliate_commission');
		$this->data['help_login_attempts'] = $this->language->get('help_login_attempts');
		$this->data['help_affiliate'] = $this->language->get('help_affiliate');
		$this->data['help_affiliate_mail'] = $this->language->get('help_affiliate_mail');
		$this->data['help_affiliate_activity'] = $this->language->get('help_affiliate_activity');
		$this->data['help_affiliate_disable'] = $this->language->get('help_affiliate_disable');
		$this->data['help_return'] = $this->language->get('help_return');
		$this->data['help_return_status'] = $this->language->get('help_return_status');
		$this->data['help_return_disable'] = $this->language->get('help_return_disable');
		$this->data['help_voucher_min'] = $this->language->get('help_voucher_min');
		$this->data['help_voucher_max'] = $this->language->get('help_voucher_max');
		$this->data['help_admin_width_limit'] = $this->language->get('help_admin_width_limit');
		$this->data['help_admin_limit'] = $this->language->get('help_admin_limit');
		$this->data['help_catalog_limit'] = $this->language->get('help_catalog_limit');
		$this->data['help_pagination_hi'] = $this->language->get('help_pagination_hi');
		$this->data['help_pagination_lo'] = $this->language->get('help_pagination_lo');
		$this->data['help_autocomplete_category'] = $this->language->get('help_autocomplete_category');
		$this->data['help_autocomplete_product'] = $this->language->get('help_autocomplete_product');
		$this->data['help_autocomplete_offer'] = $this->language->get('help_autocomplete_offer');
		$this->data['help_catalog_barcode'] = $this->language->get('help_catalog_barcode');
		$this->data['help_admin_barcode'] = $this->language->get('help_admin_barcode');
		$this->data['help_buy_now'] = $this->language->get('help_buy_now');
		$this->data['help_lightbox'] = $this->language->get('help_lightbox');
		$this->data['help_share_addthis'] = $this->language->get('help_share_addthis');
		$this->data['help_price_free'] = $this->language->get('help_price_free');
		$this->data['help_captcha_font'] = $this->language->get('help_captcha_font');
		$this->data['help_cookie_privacy'] = $this->language->get('help_cookie_privacy');
		$this->data['help_cookie_age'] = $this->language->get('help_cookie_age');
		$this->data['help_news_addthis'] = $this->language->get('help_news_addthis');
		$this->data['help_news_style'] = $this->language->get('help_news_style');
		$this->data['help_news_chars'] = $this->language->get('help_news_chars');
		$this->data['help_icon'] = $this->language->get('help_icon');
		$this->data['help_image_category'] = $this->language->get('help_image_category');
		$this->data['help_image_thumb'] = $this->language->get('help_image_thumb');
		$this->data['help_image_popup'] = $this->language->get('help_image_popup');
		$this->data['help_image_product'] = $this->language->get('help_image_product');
		$this->data['help_image_additional'] = $this->language->get('help_image_additional');
		$this->data['help_image_brand'] = $this->language->get('help_image_brand');
		$this->data['help_image_related'] = $this->language->get('help_image_related');
		$this->data['help_image_compare'] = $this->language->get('help_image_compare');
		$this->data['help_image_wishlist'] = $this->language->get('help_image_wishlist');
		$this->data['help_image_newsthumb'] = $this->language->get('help_image_newsthumb');
		$this->data['help_image_newspopup'] = $this->language->get('help_image_newspopup');
		$this->data['help_image_cart'] = $this->language->get('help_image_cart');
		$this->data['help_label_size_ratio'] = $this->language->get('help_label_size_ratio');
		$this->data['help_label_stock'] = $this->language->get('help_label_stock');
		$this->data['help_label_offer'] = $this->language->get('help_label_offer');
		$this->data['help_label_special'] = $this->language->get('help_label_special');
		$this->data['help_ftp_root'] = $this->language->get('help_ftp_root');
		$this->data['help_mail_protocol'] = $this->language->get('help_mail_protocol');
		$this->data['help_mail_parameter'] = $this->language->get('help_mail_parameter');
		$this->data['help_account_mail'] = $this->language->get('help_account_mail');
		$this->data['help_alert_mail'] = $this->language->get('help_alert_mail');
		$this->data['help_alert_emails'] = $this->language->get('help_alert_emails');
		$this->data['help_addthis'] = $this->language->get('help_addthis');
		$this->data['help_meta_google'] = $this->language->get('help_meta_google');
		$this->data['help_meta_bing'] = $this->language->get('help_meta_bing');
		$this->data['help_meta_yandex'] = $this->language->get('help_meta_yandex');
		$this->data['help_meta_baidu'] = $this->language->get('help_meta_baidu');
		$this->data['help_meta_alexa'] = $this->language->get('help_meta_alexa');
		$this->data['help_google_analytics'] = $this->language->get('help_google_analytics');
		$this->data['help_alexa_analytics'] = $this->language->get('help_alexa_analytics');
		$this->data['help_piwik_analytics'] = $this->language->get('help_piwik_analytics');
		$this->data['help_maintenance'] = $this->language->get('help_maintenance');
		$this->data['help_seo_url'] = $this->language->get('help_seo_url');
		$this->data['help_seo_url_cache'] = $this->language->get('help_seo_url_cache');
		$this->data['help_encryption'] = $this->language->get('help_encryption');
		$this->data['help_compression'] = $this->language->get('help_compression');
		$this->data['help_secure'] = $this->language->get('help_secure');
		$this->data['help_shared'] = $this->language->get('help_shared');
		$this->data['help_robots'] = $this->language->get('help_robots');
		$this->data['help_robots_online'] = $this->language->get('help_robots_online');
		$this->data['help_password'] = $this->language->get('help_password');
		$this->data['help_ban_page'] = $this->language->get('help_ban_page');
		$this->data['help_file_max_size'] = $this->language->get('help_file_max_size');
		$this->data['help_file_extension_allowed'] = $this->language->get('help_file_extension_allowed');
		$this->data['help_file_mime_allowed'] = $this->language->get('help_file_mime_allowed');

		$this->data['themes'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		if (isset($this->error['owner'])) {
			$this->data['error_owner'] = $this->error['owner'];
		} else {
			$this->data['error_owner'] = '';
		}

		if (isset($this->error['address'])) {
			$this->data['error_address'] = $this->error['address'];
		} else {
			$this->data['error_address'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['email_noreply'])) {
			$this->data['error_email_noreply'] = $this->error['email_noreply'];
		} else {
			$this->data['error_email_noreply'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}

		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		if (isset($this->error['multiple_checkout'])) {
			$this->data['error_multiple_checkout'] = $this->error['multiple_checkout'];
		} else {
			$this->data['error_multiple_checkout'] = '';
		}

		if (isset($this->error['customer_group_display'])) {
			$this->data['error_customer_group_display'] = $this->error['customer_group_display'];
		} else {
			$this->data['error_customer_group_display'] = '';
		}

		if (isset($this->error['login_attempts'])) {
			$this->data['error_login_attempts'] = $this->error['login_attempts'];
		} else {
			$this->data['error_login_attempts'] = '';
		}

		if (isset($this->error['voucher_min'])) {
			$this->data['error_voucher_min'] = $this->error['voucher_min'];
		} else {
			$this->data['error_voucher_min'] = '';
		}

		if (isset($this->error['voucher_max'])) {
			$this->data['error_voucher_max'] = $this->error['voucher_max'];
		} else {
			$this->data['error_voucher_max'] = '';
		}

		if (isset($this->error['catalog_limit'])) {
			$this->data['error_catalog_limit'] = $this->error['catalog_limit'];
		} else {
			$this->data['error_catalog_limit'] = '';
		}

		if (isset($this->error['admin_limit'])) {
			$this->data['error_admin_limit'] = $this->error['admin_limit'];
		} else {
			$this->data['error_admin_limit'] = '';
		}

		if (isset($this->error['preference_pagination'])) {
			$this->data['error_preference_pagination'] = $this->error['preference_pagination'];
		} else {
			$this->data['error_preference_pagination'] = '';
		}

		if (isset($this->error['image_category'])) {
			$this->data['error_image_category'] = $this->error['image_category'];
		} else {
			$this->data['error_image_category'] = '';
		}

		if (isset($this->error['image_thumb'])) {
			$this->data['error_image_thumb'] = $this->error['image_thumb'];
		} else {
			$this->data['error_image_thumb'] = '';
		}

		if (isset($this->error['image_popup'])) {
			$this->data['error_image_popup'] = $this->error['image_popup'];
		} else {
			$this->data['error_image_popup'] = '';
		}

		if (isset($this->error['image_product'])) {
			$this->data['error_image_product'] = $this->error['image_product'];
		} else {
			$this->data['error_image_product'] = '';
		}

		if (isset($this->error['image_additional'])) {
			$this->data['error_image_additional'] = $this->error['image_additional'];
		} else {
			$this->data['error_image_additional'] = '';
		}

		if (isset($this->error['image_brand'])) {
			$this->data['error_image_brand'] = $this->error['image_brand'];
		} else {
			$this->data['error_image_brand'] = '';
		}

		if (isset($this->error['image_related'])) {
			$this->data['error_image_related'] = $this->error['image_related'];
		} else {
			$this->data['error_image_related'] = '';
		}

		if (isset($this->error['image_compare'])) {
			$this->data['error_image_compare'] = $this->error['image_compare'];
		} else {
			$this->data['error_image_compare'] = '';
		}

		if (isset($this->error['image_wishlist'])) {
			$this->data['error_image_wishlist'] = $this->error['image_wishlist'];
		} else {
			$this->data['error_image_wishlist'] = '';
		}

		if (isset($this->error['image_newsthumb'])) {
			$this->data['error_image_newsthumb'] = $this->error['image_newsthumb'];
		} else {
			$this->data['error_image_newsthumb'] = '';
		}

		if (isset($this->error['image_newspopup'])) {
			$this->data['error_image_newspopup'] = $this->error['image_newspopup'];
		} else {
			$this->data['error_image_newspopup'] = '';
		}

		if (isset($this->error['image_cart'])) {
			$this->data['error_image_cart'] = $this->error['image_cart'];
		} else {
			$this->data['error_image_cart'] = '';
		}

		if (isset($this->error['ftp_host'])) {
			$this->data['error_ftp_host'] = $this->error['ftp_host'];
		} else {
			$this->data['error_ftp_host'] = '';
		}

		if (isset($this->error['ftp_port'])) {
			$this->data['error_ftp_port'] = $this->error['ftp_port'];
		} else {
			$this->data['error_ftp_port'] = '';
		}

		if (isset($this->error['ftp_username'])) {
			$this->data['error_ftp_username'] = $this->error['ftp_username'];
		} else {
			$this->data['error_ftp_username'] = '';
		}

		if (isset($this->error['ftp_password'])) {
			$this->data['error_ftp_password'] = $this->error['ftp_password'];
		} else {
			$this->data['error_ftp_password'] = '';
		}

		if (isset($this->error['error_filename'])) {
			$this->data['error_error_filename'] = $this->error['error_filename'];
		} else {
			$this->data['error_error_filename'] = '';
		}

		if (isset($this->error['mail_filename'])) {
			$this->data['error_mail_filename'] = $this->error['mail_filename'];
		} else {
			$this->data['error_mail_filename'] = '';
		}

		if (isset($this->error['quote_filename'])) {
			$this->data['error_quote_filename'] = $this->error['quote_filename'];
		} else {
			$this->data['error_quote_filename'] = '';
		}

		if (isset($this->error['file_max_size'])) {
			$this->data['error_file_max_size'] = $this->error['file_max_size'];
		} else {
			$this->data['error_file_max_size'] = '';
		}

		if (isset($this->error['encryption'])) {
			$this->data['error_encryption'] = $this->error['encryption'];
		} else {
			$this->data['error_encryption'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		// General
		if (isset($this->request->post['config_name'])) {
			$this->data['config_name'] = $this->request->post['config_name'];
		} else {
			$this->data['config_name'] = $this->config->get('config_name');
		}

		if (isset($this->request->post['config_owner'])) {
			$this->data['config_owner'] = $this->request->post['config_owner'];
		} else {
			$this->data['config_owner'] = $this->config->get('config_owner');
		}

		if (isset($this->request->post['config_address'])) {
			$this->data['config_address'] = $this->request->post['config_address'];
		} else {
			$this->data['config_address'] = $this->config->get('config_address');
		}

		if (isset($this->request->post['config_email'])) {
			$this->data['config_email'] = $this->request->post['config_email'];
		} else {
			$this->data['config_email'] = $this->config->get('config_email');
		}

		if (isset($this->request->post['config_email_noreply'])) {
			$this->data['config_email_noreply'] = $this->request->post['config_email_noreply'];
		} elseif ($this->config->get('config_email_noreply')) {
			$this->data['config_email_noreply'] = $this->config->get('config_email_noreply');
		} else {
			$this->data['config_email_noreply'] = 'noreply@' . $this->request->server['SERVER_NAME'];
		}

		if (isset($this->request->post['config_telephone'])) {
			$this->data['config_telephone'] = $this->request->post['config_telephone'];
		} else {
			$this->data['config_telephone'] = $this->config->get('config_telephone');
		}

		if (isset($this->request->post['config_fax'])) {
			$this->data['config_fax'] = $this->request->post['config_fax'];
		} else {
			$this->data['config_fax'] = $this->config->get('config_fax');
		}

		if (isset($this->request->post['config_company_id'])) {
			$this->data['config_company_id'] = $this->request->post['config_company_id'];
		} else {
			$this->data['config_company_id'] = $this->config->get('config_company_id');
		}

		if (isset($this->request->post['config_company_tax_id'])) {
			$this->data['config_company_tax_id'] = $this->request->post['config_company_tax_id'];
		} else {
			$this->data['config_company_tax_id'] = $this->config->get('config_company_tax_id');
		}

		// Store
		if (isset($this->request->post['config_title'])) {
			$this->data['config_title'] = $this->request->post['config_title'];
		} else {
			$this->data['config_title'] = $this->config->get('config_title');
		}

		if (isset($this->request->post['config_meta_description'])) {
			$this->data['config_meta_description'] = $this->request->post['config_meta_description'];
		} else {
			$this->data['config_meta_description'] = $this->config->get('config_meta_description');
		}

		if (isset($this->request->post['config_meta_keyword'])) {
			$this->data['config_meta_keyword'] = $this->request->post['config_meta_keyword'];
		} else {
			$this->data['config_meta_keyword'] = $this->config->get('config_meta_keyword');
		}

		$this->data['templates'] = array();

		$directories = glob(DIR_CATALOG . 'view/theme/*', GLOB_ONLYDIR);

		foreach ($directories as $directory) {
			$this->data['templates'][] = basename($directory);
		}

		if (isset($this->request->post['config_template'])) {
			$this->data['config_template'] = $this->request->post['config_template'];
		} else {
			$this->data['config_template'] = $this->config->get('config_template');
		}

		$this->data['configure_theme'] = $this->url->link('extension/theme', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		if (isset($this->request->post['config_layout_id'])) {
			$this->data['config_layout_id'] = $this->request->post['config_layout_id'];
		} else {
			$this->data['config_layout_id'] = $this->config->get('config_layout_id');
		}

		$this->data['configure_layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');

		// Local
		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['config_country_id'])) {
			$this->data['config_country_id'] = $this->request->post['config_country_id'];
		} else {
			$this->data['config_country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['config_zone_id'])) {
			$this->data['config_zone_id'] = $this->request->post['config_zone_id'];
		} else {
			$this->data['config_zone_id'] = $this->config->get('config_zone_id');
		}

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['config_language'])) {
			$this->data['config_language'] = $this->request->post['config_language'];
		} else {
			$this->data['config_language'] = $this->config->get('config_language');
		}

		$this->data['configure_language'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['config_admin_language'])) {
			$this->data['config_admin_language'] = $this->request->post['config_admin_language'];
		} else {
			$this->data['config_admin_language'] = $this->config->get('config_admin_language');
		}

		$this->load->model('localisation/currency');

		$this->data['currencies'] = $this->model_localisation_currency->getCurrencies();

		if (isset($this->request->post['config_currency'])) {
			$this->data['config_currency'] = $this->request->post['config_currency'];
		} else {
			$this->data['config_currency'] = $this->config->get('config_currency');
		}

		$this->data['configure_currency'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['config_currency_auto'])) {
			$this->data['config_currency_auto'] = $this->request->post['config_currency_auto'];
		} else {
			$this->data['config_currency_auto'] = $this->config->get('config_currency_auto');
		}

		$this->load->model('localisation/length_class');

		$this->data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['config_length_class_id'])) {
			$this->data['config_length_class_id'] = $this->request->post['config_length_class_id'];
		} else {
			$this->data['config_length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->data['configure_length_class'] = $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model('localisation/weight_class');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['config_weight_class_id'])) {
			$this->data['config_weight_class_id'] = $this->request->post['config_weight_class_id'];
		} else {
			$this->data['config_weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		$this->data['configure_weight_class'] = $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['date_formats'] = array();

		$this->data['date_formats'][] = array('format' => 'short', 'title' => $this->language->get('date_format_short'));
		$this->data['date_formats'][] = array('format' => 'long', 'title' => $this->language->get('date_format_long'));

		if (isset($this->request->post['config_date_format'])) {
			$this->data['config_date_format'] = $this->request->post['config_date_format'];
		} else {
			$this->data['config_date_format'] = $this->config->get('config_date_format');
		}

		$this->data['time_offsets'] = array('+11', '+10', '+9', '+8', '+7', '+6', '+5', '+4', '+3', '+2', '+1', '0', '-1', '-2', '-3', '-4', '-5', '-6', '-7', '-8', '-9', '-10', '-11');

		if (isset($this->request->post['config_time_offset'])) {
			$this->data['config_time_offset'] = $this->request->post['config_time_offset'];
		} elseif ($this->config->get('config_time_offset')) {
			$this->data['config_time_offset'] = $this->config->get('config_time_offset');
		} else {
			$this->data['config_time_offset'] = '0';
		}

		if (isset($this->request->post['config_store_address'])) {
			$this->data['config_store_address'] = $this->request->post['config_store_address'];
		} else {
			$this->data['config_store_address'] = $this->config->get('config_store_address');
		}

		if (isset($this->request->post['config_store_latitude'])) {
			$this->data['config_store_latitude'] = $this->request->post['config_store_latitude'];
		} else {
			$this->data['config_store_latitude'] = $this->config->get('config_store_latitude');
		}

		if (isset($this->request->post['config_store_longitude'])) {
			$this->data['config_store_longitude'] = $this->request->post['config_store_longitude'];
		} else {
			$this->data['config_store_longitude'] = $this->config->get('config_store_longitude');
		}

		if (isset($this->request->post['config_store_location'])) {
			$this->data['config_store_location'] = $this->request->post['config_store_location'];
		} else {
			$this->data['config_store_location'] = $this->config->get('config_store_location');
		}

		if (isset($this->request->post['config_map_code'])) {
			$this->data['config_map_code'] = $this->request->post['config_map_code'];
		} else {
			$this->data['config_map_code'] = $this->config->get('config_map_code');
		}

		if (isset($this->request->post['config_map_display'])) {
			$this->data['config_map_display'] = $this->request->post['config_map_display'];
		} else {
			$this->data['config_map_display'] = $this->config->get('config_map_display');
		}

		// Checkout
		if (isset($this->request->post['config_cart_weight'])) {
			$this->data['config_cart_weight'] = $this->request->post['config_cart_weight'];
		} else {
			$this->data['config_cart_weight'] = $this->config->get('config_cart_weight');
		}

		if (isset($this->request->post['config_guest_checkout'])) {
			$this->data['config_guest_checkout'] = $this->request->post['config_guest_checkout'];
		} else {
			$this->data['config_guest_checkout'] = $this->config->get('config_guest_checkout');
		}

		if (isset($this->request->post['config_checkout_id'])) {
			$this->data['config_checkout_id'] = $this->request->post['config_checkout_id'];
		} else {
			$this->data['config_checkout_id'] = $this->config->get('config_checkout_id');
		}

		if (isset($this->request->post['config_invoice_prefix'])) {
			$this->data['config_invoice_prefix'] = $this->request->post['config_invoice_prefix'];
		} elseif ($this->config->get('config_invoice_prefix')) {
			$this->data['config_invoice_prefix'] = $this->config->get('config_invoice_prefix');
		} else {
			$this->data['config_invoice_prefix'] = 'INV-' . date('Y') . '-00';
		}

		if (isset($this->request->post['config_auto_invoice'])) {
			$this->data['config_auto_invoice'] = $this->request->post['config_auto_invoice'];
		} else {
			$this->data['config_auto_invoice'] = $this->config->get('config_auto_invoice');
		}

		if (isset($this->request->post['config_order_edit'])) {
			$this->data['config_order_edit'] = $this->request->post['config_order_edit'];
		} elseif ($this->config->get('config_order_edit')) {
			$this->data['config_order_edit'] = $this->config->get('config_order_edit');
		} else {
			$this->data['config_order_edit'] = 7;
		}

		if (isset($this->request->post['config_order_status_id'])) {
			$this->data['config_order_status_id'] = $this->request->post['config_order_status_id'];
		} else {
			$this->data['config_order_status_id'] = $this->config->get('config_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['config_complete_status_id'])) {
			$this->data['config_complete_status_id'] = $this->request->post['config_complete_status_id'];
		} else {
			$this->data['config_complete_status_id'] = $this->config->get('config_complete_status_id');
		}

		// One Page Checkout
		if (isset($this->request->post['config_one_page_checkout'])) {
			$this->data['config_one_page_checkout'] = $this->request->post['config_one_page_checkout'];
		} else {
			$this->data['config_one_page_checkout'] = $this->config->get('config_one_page_checkout');
		}

		if (isset($this->request->post['config_one_page_phone'])) {
			$this->data['config_one_page_phone'] = $this->request->post['config_one_page_phone'];
		} else {
			$this->data['config_one_page_phone'] = $this->config->get('config_one_page_phone');
		}

		if (isset($this->request->post['config_one_page_newsletter'])) {
			$this->data['config_one_page_newsletter'] = $this->request->post['config_one_page_newsletter'];
		} else {
			$this->data['config_one_page_newsletter'] = $this->config->get('config_one_page_newsletter');
		}

		if (isset($this->request->post['config_one_page_coupon'])) {
			$this->data['config_one_page_coupon'] = $this->request->post['config_one_page_coupon'];
		} else {
			$this->data['config_one_page_coupon'] = $this->config->get('config_one_page_coupon');
		}

		if (isset($this->request->post['config_one_page_voucher'])) {
			$this->data['config_one_page_voucher'] = $this->request->post['config_one_page_voucher'];
		} else {
			$this->data['config_one_page_voucher'] = $this->config->get('config_one_page_voucher');
		}

		if (isset($this->request->post['config_one_page_point'])) {
			$this->data['config_one_page_point'] = $this->request->post['config_one_page_point'];
		} else {
			$this->data['config_one_page_point'] = $this->config->get('config_one_page_point');
		}

		// Express Checkout
		if (isset($this->request->post['config_express_checkout'])) {
			$this->data['config_express_checkout'] = $this->request->post['config_express_checkout'];
		} else {
			$this->data['config_express_checkout'] = $this->config->get('config_express_checkout');
		}

		if (isset($this->request->post['config_express_autofill'])) {
			$this->data['config_express_autofill'] = $this->request->post['config_express_autofill'];
		} else {
			$this->data['config_express_autofill'] = $this->config->get('config_express_autofill');
		}

		if (isset($this->request->post['config_express_password'])) {
			$this->data['config_express_password'] = $this->request->post['config_express_password'];
		} else {
			$this->data['config_express_password'] = $this->config->get('config_express_password');
		}

		if (isset($this->request->post['config_express_phone'])) {
			$this->data['config_express_phone'] = $this->request->post['config_express_phone'];
		} else {
			$this->data['config_express_phone'] = $this->config->get('config_express_phone');
		}

		if (isset($this->request->post['config_express_billing'])) {
			$this->data['config_express_billing'] = $this->request->post['config_express_billing'];
		} else {
			$this->data['config_express_billing'] = $this->config->get('config_express_billing');
		}

		if (isset($this->request->post['config_express_postcode'])) {
			$this->data['config_express_postcode'] = $this->request->post['config_express_postcode'];
		} else {
			$this->data['config_express_postcode'] = $this->config->get('config_express_postcode');
		}

		if (isset($this->request->post['config_express_comment'])) {
			$this->data['config_express_comment'] = $this->request->post['config_express_comment'];
		} else {
			$this->data['config_express_comment'] = $this->config->get('config_express_comment');
		}

		if (isset($this->request->post['config_express_newsletter'])) {
			$this->data['config_express_newsletter'] = $this->request->post['config_express_newsletter'];
		} else {
			$this->data['config_express_newsletter'] = $this->config->get('config_express_newsletter');
		}

		if (isset($this->request->post['config_express_coupon'])) {
			$this->data['config_express_coupon'] = $this->request->post['config_express_coupon'];
		} else {
			$this->data['config_express_coupon'] = $this->config->get('config_express_coupon');
		}

		if (isset($this->request->post['config_express_voucher'])) {
			$this->data['config_express_voucher'] = $this->request->post['config_express_voucher'];
		} else {
			$this->data['config_express_voucher'] = $this->config->get('config_express_voucher');
		}

		if (isset($this->request->post['config_express_point'])) {
			$this->data['config_express_point'] = $this->request->post['config_express_point'];
		} else {
			$this->data['config_express_point'] = $this->config->get('config_express_point');
		}

		// Options
		if (isset($this->request->post['config_empty_category'])) {
			$this->data['config_empty_category'] = $this->request->post['config_empty_category'];
		} else {
			$this->data['config_empty_category'] = $this->config->get('config_empty_category');
		}

		if (isset($this->request->post['config_product_count'])) {
			$this->data['config_product_count'] = $this->request->post['config_product_count'];
		} else {
			$this->data['config_product_count'] = $this->config->get('config_product_count');
		}

		if (isset($this->request->post['config_coupon_special'])) {
			$this->data['config_coupon_special'] = $this->request->post['config_coupon_special'];
		} else {
			$this->data['config_coupon_special'] = $this->config->get('config_coupon_special');
		}

		if (isset($this->request->post['config_review_status'])) {
			$this->data['config_review_status'] = $this->request->post['config_review_status'];
		} else {
			$this->data['config_review_status'] = $this->config->get('config_review_status');
		}

		if (isset($this->request->post['config_download'])) {
			$this->data['config_download'] = $this->request->post['config_download'];
		} else {
			$this->data['config_download'] = $this->config->get('config_download');
		}

		if (isset($this->request->post['config_tax'])) {
			$this->data['config_tax'] = $this->request->post['config_tax'];
		} else {
			$this->data['config_tax'] = $this->config->get('config_tax');
		}

		if (isset($this->request->post['config_vat'])) {
			$this->data['config_vat'] = $this->request->post['config_vat'];
		} else {
			$this->data['config_vat'] = $this->config->get('config_vat');
		}

		if (isset($this->request->post['config_tax_default'])) {
			$this->data['config_tax_default'] = $this->request->post['config_tax_default'];
		} else {
			$this->data['config_tax_default'] = $this->config->get('config_tax_default');
		}

		if (isset($this->request->post['config_tax_customer'])) {
			$this->data['config_tax_customer'] = $this->request->post['config_tax_customer'];
		} else {
			$this->data['config_tax_customer'] = $this->config->get('config_tax_customer');
		}

		if (isset($this->request->post['config_stock_display'])) {
			$this->data['config_stock_display'] = $this->request->post['config_stock_display'];
		} else {
			$this->data['config_stock_display'] = $this->config->get('config_stock_display');
		}

		if (isset($this->request->post['config_stock_warning'])) {
			$this->data['config_stock_warning'] = $this->request->post['config_stock_warning'];
		} else {
			$this->data['config_stock_warning'] = $this->config->get('config_stock_warning');
		}

		if (isset($this->request->post['config_stock_checkout'])) {
			$this->data['config_stock_checkout'] = $this->request->post['config_stock_checkout'];
		} else {
			$this->data['config_stock_checkout'] = $this->config->get('config_stock_checkout');
		}

		$this->load->model('localisation/stock_status');

		$this->data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['config_stock_status_id'])) {
			$this->data['config_stock_status_id'] = $this->request->post['config_stock_status_id'];
		} else {
			$this->data['config_stock_status_id'] = $this->config->get('config_stock_status_id');
		}

		$this->load->model('sale/supplier_group');

		$this->data['supplier_groups'] = $this->model_sale_supplier_group->getSupplierGroups();

		if (isset($this->request->post['config_supplier_group_id'])) {
			$this->data['config_supplier_group_id'] = $this->request->post['config_supplier_group_id'];
		} else {
			$this->data['config_supplier_group_id'] = $this->config->get('config_supplier_group_id');
		}

		if (isset($this->request->post['config_customer_online'])) {
			$this->data['config_customer_online'] = $this->request->post['config_customer_online'];
		} else {
			$this->data['config_customer_online'] = $this->config->get('config_customer_online');
		}

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['config_customer_group_id'])) {
			$this->data['config_customer_group_id'] = $this->request->post['config_customer_group_id'];
		} else {
			$this->data['config_customer_group_id'] = $this->config->get('config_customer_group_id');
		}

		if (isset($this->request->post['config_customer_group_display'])) {
			$this->data['config_customer_group_display'] = $this->request->post['config_customer_group_display'];
		} elseif ($this->config->get('config_customer_group_display')) {
			$this->data['config_customer_group_display'] = $this->config->get('config_customer_group_display');
		} else {
			$this->data['config_customer_group_display'] = array();
		}

		if (isset($this->request->post['config_customer_price'])) {
			$this->data['config_customer_price'] = $this->request->post['config_customer_price'];
		} else {
			$this->data['config_customer_price'] = $this->config->get('config_customer_price');
		}

		if (isset($this->request->post['config_customer_redirect'])) {
			$this->data['config_customer_redirect'] = $this->request->post['config_customer_redirect'];
		} else {
			$this->data['config_customer_redirect'] = $this->config->get('config_customer_redirect');
		}

		if (isset($this->request->post['config_customer_fax'])) {
			$this->data['config_customer_fax'] = $this->request->post['config_customer_fax'];
		} else {
			$this->data['config_customer_fax'] = $this->config->get('config_customer_fax');
		}

		if (isset($this->request->post['config_customer_gender'])) {
			$this->data['config_customer_gender'] = $this->request->post['config_customer_gender'];
		} else {
			$this->data['config_customer_gender'] = $this->config->get('config_customer_gender');
		}

		if (isset($this->request->post['config_customer_dob'])) {
			$this->data['config_customer_dob'] = $this->request->post['config_customer_dob'];
		} else {
			$this->data['config_customer_dob'] = $this->config->get('config_customer_dob');
		}

		if (isset($this->request->post['config_picklist_status'])) {
			$this->data['config_picklist_status'] = $this->request->post['config_picklist_status'];
		} else {
			$this->data['config_picklist_status'] = $this->config->get('config_picklist_status');
		}

		if (isset($this->request->post['config_login_attempts'])) {
			$this->data['config_login_attempts'] = $this->request->post['config_login_attempts'];
		} elseif ($this->config->get('config_login_attempts')) {
			$this->data['config_login_attempts'] = $this->config->get('config_login_attempts');
		} else {
			$this->data['config_login_attempts'] = 5;
		}

		$this->load->model('catalog/information');

		$this->data['informations'] = $this->model_catalog_information->getInformations();

		if (isset($this->request->post['config_account_id'])) {
			$this->data['config_account_id'] = $this->request->post['config_account_id'];
		} else {
			$this->data['config_account_id'] = $this->config->get('config_account_id');
		}

		if (isset($this->request->post['config_affiliate_approval'])) {
			$this->data['config_affiliate_approval'] = $this->request->post['config_affiliate_approval'];
		} else {
			$this->data['config_affiliate_approval'] = $this->config->get('config_affiliate_approval');
		}

		if (isset($this->request->post['config_affiliate_auto'])) {
			$this->data['config_affiliate_auto'] = $this->request->post['config_affiliate_auto'];
		} else {
			$this->data['config_affiliate_auto'] = $this->config->get('config_affiliate_auto');
		}

		if (isset($this->request->post['config_affiliate_commission'])) {
			$this->data['config_affiliate_commission'] = $this->request->post['config_affiliate_commission'];
		} elseif ($this->config->get('config_affiliate_commission')) {
			$this->data['config_affiliate_commission'] = $this->config->get('config_affiliate_commission');
		} else {
			$this->data['config_affiliate_commission'] = '5.00';
		}

		if (isset($this->request->post['config_affiliate_id'])) {
			$this->data['config_affiliate_id'] = $this->request->post['config_affiliate_id'];
		} else {
			$this->data['config_affiliate_id'] = $this->config->get('config_affiliate_id');
		}

		if (isset($this->request->post['config_affiliate_mail'])) {
			$this->data['config_affiliate_mail'] = $this->request->post['config_affiliate_mail'];
		} elseif ($this->config->get('config_affiliate_mail')) {
			$this->data['config_affiliate_mail'] = $this->config->get('config_affiliate_mail');
		} else {
			$this->data['config_affiliate_mail'] = '';
		}

		if (isset($this->request->post['config_affiliate_fax'])) {
			$this->data['config_affiliate_fax'] = $this->request->post['config_affiliate_fax'];
		} elseif ($this->config->get('config_affiliate_fax')) {
			$this->data['config_affiliate_fax'] = $this->config->get('config_affiliate_fax');
		} else {
			$this->data['config_affiliate_fax'] = '';
		}

		if (isset($this->request->post['config_affiliate_activity'])) {
			$this->data['config_affiliate_activity'] = $this->request->post['config_affiliate_activity'];
		} else {
			$this->data['config_affiliate_activity'] = $this->config->get('config_affiliate_activity');
		}

		if (isset($this->request->post['config_affiliate_disable'])) {
			$this->data['config_affiliate_disable'] = $this->request->post['config_affiliate_disable'];
		} else {
			$this->data['config_affiliate_disable'] = $this->config->get('config_affiliate_disable');
		}

		if (isset($this->request->post['config_return_id'])) {
			$this->data['config_return_id'] = $this->request->post['config_return_id'];
		} else {
			$this->data['config_return_id'] = $this->config->get('config_return_id');
		}

		$this->load->model('localisation/return_status');

		$this->data['return_statuses'] = $this->model_localisation_return_status->getReturnStatuses();

		if (isset($this->request->post['config_return_status_id'])) {
			$this->data['config_return_status_id'] = $this->request->post['config_return_status_id'];
		} else {
			$this->data['config_return_status_id'] = $this->config->get('config_return_status_id');
		}

		if (isset($this->request->post['config_return_disable'])) {
			$this->data['config_return_disable'] = $this->request->post['config_return_disable'];
		} else {
			$this->data['config_return_disable'] = $this->config->get('config_return_disable');
		}

		if (isset($this->request->post['config_voucher_min'])) {
			$this->data['config_voucher_min'] = $this->request->post['config_voucher_min'];
		} else {
			$this->data['config_voucher_min'] = $this->config->get('config_voucher_min');
		}

		if (isset($this->request->post['config_voucher_max'])) {
			$this->data['config_voucher_max'] = $this->request->post['config_voucher_max'];
		} else {
			$this->data['config_voucher_max'] = $this->config->get('config_voucher_max');
		}

		// Preference
		$this->load->model('design/administration');

		$this->data['admin_stylesheets'] = $this->model_design_administration->getAdministrations(0);

		if (isset($this->request->post['config_admin_stylesheet'])) {
			$this->data['config_admin_stylesheet'] = $this->request->post['config_admin_stylesheet'];
		} elseif ($this->config->get('config_admin_stylesheet')) {
			$this->data['config_admin_stylesheet'] = $this->config->get('config_admin_stylesheet');
		} else {
			$this->data['config_admin_stylesheet'] = 'classic';
		}

		if (isset($this->request->post['config_admin_width_limit'])) {
			$this->data['config_admin_width_limit'] = $this->request->post['config_admin_width_limit'];
		} else {
			$this->data['config_admin_width_limit'] = $this->config->get('config_admin_width_limit');
		}

		if (isset($this->request->post['config_admin_menu_icons'])) {
			$this->data['config_admin_menu_icons'] = $this->request->post['config_admin_menu_icons'];
		} else {
			$this->data['config_admin_menu_icons'] = $this->config->get('config_admin_menu_icons');
		}

		if (isset($this->request->post['config_admin_limit'])) {
			$this->data['config_admin_limit'] = $this->request->post['config_admin_limit'];
		} else {
			$this->data['config_admin_limit'] = $this->config->get('config_admin_limit');
		}

		if (isset($this->request->post['config_catalog_limit'])) {
			$this->data['config_catalog_limit'] = $this->request->post['config_catalog_limit'];
		} else {
			$this->data['config_catalog_limit'] = $this->config->get('config_catalog_limit');
		}

		if (isset($this->request->post['config_pagination_hi'])) {
			$this->data['config_pagination_hi'] = $this->request->post['config_pagination_hi'];
		} else {
			$this->data['config_pagination_hi'] = $this->config->get('config_pagination_hi');
		}

		if (isset($this->request->post['config_pagination_lo'])) {
			$this->data['config_pagination_lo'] = $this->request->post['config_pagination_lo'];
		} else {
			$this->data['config_pagination_lo'] = $this->config->get('config_pagination_lo');
		}

		if (isset($this->request->post['config_autocomplete_category'])) {
			$this->data['config_autocomplete_category'] = $this->request->post['config_autocomplete_category'];
		} else {
			$this->data['config_autocomplete_category'] = $this->config->get('config_autocomplete_category');
		}

		if (isset($this->request->post['config_autocomplete_product'])) {
			$this->data['config_autocomplete_product'] = $this->request->post['config_autocomplete_product'];
		} else {
			$this->data['config_autocomplete_product'] = $this->config->get('config_autocomplete_product');
		}

		if (isset($this->request->post['config_autocomplete_offer'])) {
			$this->data['config_autocomplete_offer'] = $this->request->post['config_autocomplete_offer'];
		} else {
			$this->data['config_autocomplete_offer'] = $this->config->get('config_autocomplete_offer');
		}

		if (isset($this->request->post['config_catalog_barcode'])) {
			$this->data['config_catalog_barcode'] = $this->request->post['config_catalog_barcode'];
		} else {
			$this->data['config_catalog_barcode'] = $this->config->get('config_catalog_barcode');
		}

		if (isset($this->request->post['config_admin_barcode'])) {
			$this->data['config_admin_barcode'] = $this->request->post['config_admin_barcode'];
		} else {
			$this->data['config_admin_barcode'] = $this->config->get('config_admin_barcode');
		}

		$this->data['barcode_types'] = array();

		$this->data['barcode_types'][] = array('format' => 'TYPE_CODE_39', 'title' => 'Barcode Code 39');
		$this->data['barcode_types'][] = array('format' => 'TYPE_CODE_93', 'title' => 'Barcode Code 93');
		$this->data['barcode_types'][] = array('format' => 'TYPE_CODE_128', 'title' => 'Barcode Code 128');

		if (isset($this->request->post['config_barcode_type'])) {
			$this->data['config_barcode_type'] = $this->request->post['config_barcode_type'];
		} elseif ($this->config->get('config_barcode_type')) {
			$this->data['config_barcode_type'] = $this->config->get('config_barcode_type');
		} else {
			$this->data['config_barcode_type'] = 'TYPE_CODE_128';
		}

		if (isset($this->request->post['config_buy_now'])) {
			$this->data['config_buy_now'] = $this->request->post['config_buy_now'];
		} else {
			$this->data['config_buy_now'] = $this->config->get('config_buy_now');
		}

		if (isset($this->request->post['config_lightbox'])) {
			$this->data['config_lightbox'] = $this->request->post['config_lightbox'];
		} else {
			$this->data['config_lightbox'] = $this->config->get('config_lightbox');
		}

		if (isset($this->request->post['config_share_addthis'])) {
			$this->data['config_share_addthis'] = $this->request->post['config_share_addthis'];
		} else {
			$this->data['config_share_addthis'] = $this->config->get('config_share_addthis');
		}

		if (isset($this->request->post['config_price_free'])) {
			$this->data['config_price_free'] = $this->request->post['config_price_free'];
		} else {
			$this->data['config_price_free'] = $this->config->get('config_price_free');
		}

		$this->data['fontnames'] = array();

		$fonts = glob(DIR_SYSTEM . 'fonts/*.ttf');

		if ($fonts) {
			foreach ($fonts as $font) {
				$this->data['fontnames'][] = basename($font, '.ttf');
			}
		}

		if (isset($this->request->post['config_captcha_font'])) {
			$this->data['config_captcha_font'] = $this->request->post['config_captcha_font'];
		} else {
			$this->data['config_captcha_font'] = $this->config->get('config_captcha_font');
		}

		if (isset($this->request->post['config_cookie_consent'])) {
			$this->data['config_cookie_consent'] = $this->request->post['config_cookie_consent'];
		} else {
			$this->data['config_cookie_consent'] = $this->config->get('config_cookie_consent');
		}

		if (isset($this->request->post['config_cookie_theme'])) {
			$this->data['config_cookie_theme'] = $this->request->post['config_cookie_theme'];
		} else {
			$this->data['config_cookie_theme'] = $this->config->get('config_cookie_theme');
		}

		if (isset($this->request->post['config_cookie_position'])) {
			$this->data['config_cookie_position'] = $this->request->post['config_cookie_position'];
		} else {
			$this->data['config_cookie_position'] = $this->config->get('config_cookie_position');
		}

		$this->data['information_pages'] = $this->model_catalog_information->getInformationPages();

		if (isset($this->request->post['config_cookie_privacy'])) {
			$this->data['config_cookie_privacy'] = $this->request->post['config_cookie_privacy'];
		} else {
			$this->data['config_cookie_privacy'] = $this->config->get('config_cookie_privacy');
		}

		if (isset($this->request->post['config_cookie_age'])) {
			$this->data['config_cookie_age'] = $this->request->post['config_cookie_age'];
		} else {
			$this->data['config_cookie_age'] = $this->config->get('config_cookie_age');
		}

		if (isset($this->request->post['config_news_addthis'])) {
			$this->data['config_news_addthis'] = $this->request->post['config_news_addthis'];
		} else {
			$this->data['config_news_addthis'] = $this->config->get('config_news_addthis');
		}

		if (isset($this->request->post['config_news_style'])) {
			$this->data['config_news_style'] = $this->request->post['config_news_style'];
		} else {
			$this->data['config_news_style'] = $this->config->get('config_news_style');
		}

		if (isset($this->request->post['config_news_chars'])) {
			$this->data['config_news_chars'] = $this->request->post['config_news_chars'];
		} else {
			$this->data['config_news_chars'] = $this->config->get('config_news_chars');
		}

		// Image
		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['config_logo'])) {
			$this->data['config_logo'] = $this->request->post['config_logo'];
		} else {
			$this->data['config_logo'] = $this->config->get('config_logo');
		}

		if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo')) && is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$this->data['logo'] = $this->model_tool_image->resize($this->config->get('config_logo'), 100, 100);
		} else {
			$this->data['logo'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['config_icon'])) {
			$this->data['config_icon'] = $this->request->post['config_icon'];
		} else {
			$this->data['config_icon'] = $this->config->get('config_icon');
		}

		if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon')) && is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->data['icon'] = $this->model_tool_image->resize($this->config->get('config_icon'), 100, 100);
		} else {
			$this->data['icon'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['config_image_category_width'])) {
			$this->data['config_image_category_width'] = $this->request->post['config_image_category_width'];
		} else {
			$this->data['config_image_category_width'] = $this->config->get('config_image_category_width');
		}

		if (isset($this->request->post['config_image_category_height'])) {
			$this->data['config_image_category_height'] = $this->request->post['config_image_category_height'];
		} else {
			$this->data['config_image_category_height'] = $this->config->get('config_image_category_height');
		}

		if (isset($this->request->post['config_image_thumb_width'])) {
			$this->data['config_image_thumb_width'] = $this->request->post['config_image_thumb_width'];
		} else {
			$this->data['config_image_thumb_width'] = $this->config->get('config_image_thumb_width');
		}

		if (isset($this->request->post['config_image_thumb_height'])) {
			$this->data['config_image_thumb_height'] = $this->request->post['config_image_thumb_height'];
		} else {
			$this->data['config_image_thumb_height'] = $this->config->get('config_image_thumb_height');
		}

		if (isset($this->request->post['config_image_popup_width'])) {
			$this->data['config_image_popup_width'] = $this->request->post['config_image_popup_width'];
		} else {
			$this->data['config_image_popup_width'] = $this->config->get('config_image_popup_width');
		}

		if (isset($this->request->post['config_image_popup_height'])) {
			$this->data['config_image_popup_height'] = $this->request->post['config_image_popup_height'];
		} else {
			$this->data['config_image_popup_height'] = $this->config->get('config_image_popup_height');
		}

		if (isset($this->request->post['config_image_product_width'])) {
			$this->data['config_image_product_width'] = $this->request->post['config_image_product_width'];
		} else {
			$this->data['config_image_product_width'] = $this->config->get('config_image_product_width');
		}

		if (isset($this->request->post['config_image_product_height'])) {
			$this->data['config_image_product_height'] = $this->request->post['config_image_product_height'];
		} else {
			$this->data['config_image_product_height'] = $this->config->get('config_image_product_height');
		}

		if (isset($this->request->post['config_image_additional_width'])) {
			$this->data['config_image_additional_width'] = $this->request->post['config_image_additional_width'];
		} else {
			$this->data['config_image_additional_width'] = $this->config->get('config_image_additional_width');
		}

		if (isset($this->request->post['config_image_additional_height'])) {
			$this->data['config_image_additional_height'] = $this->request->post['config_image_additional_height'];
		} else {
			$this->data['config_image_additional_height'] = $this->config->get('config_image_additional_height');
		}

		if (isset($this->request->post['config_image_brand_width'])) {
			$this->data['config_image_brand_width'] = $this->request->post['config_image_brand_width'];
		} else {
			$this->data['config_image_brand_width'] = $this->config->get('config_image_brand_width');
		}

		if (isset($this->request->post['config_image_brand_height'])) {
			$this->data['config_image_brand_height'] = $this->request->post['config_image_brand_height'];
		} else {
			$this->data['config_image_brand_height'] = $this->config->get('config_image_brand_height');
		}

		if (isset($this->request->post['config_image_related_width'])) {
			$this->data['config_image_related_width'] = $this->request->post['config_image_related_width'];
		} else {
			$this->data['config_image_related_width'] = $this->config->get('config_image_related_width');
		}

		if (isset($this->request->post['config_image_related_height'])) {
			$this->data['config_image_related_height'] = $this->request->post['config_image_related_height'];
		} else {
			$this->data['config_image_related_height'] = $this->config->get('config_image_related_height');
		}

		if (isset($this->request->post['config_image_compare_width'])) {
			$this->data['config_image_compare_width'] = $this->request->post['config_image_compare_width'];
		} else {
			$this->data['config_image_compare_width'] = $this->config->get('config_image_compare_width');
		}

		if (isset($this->request->post['config_image_compare_height'])) {
			$this->data['config_image_compare_height'] = $this->request->post['config_image_compare_height'];
		} else {
			$this->data['config_image_compare_height'] = $this->config->get('config_image_compare_height');
		}

		if (isset($this->request->post['config_image_wishlist_width'])) {
			$this->data['config_image_wishlist_width'] = $this->request->post['config_image_wishlist_width'];
		} else {
			$this->data['config_image_wishlist_width'] = $this->config->get('config_image_wishlist_width');
		}

		if (isset($this->request->post['config_image_wishlist_height'])) {
			$this->data['config_image_wishlist_height'] = $this->request->post['config_image_wishlist_height'];
		} else {
			$this->data['config_image_wishlist_height'] = $this->config->get('config_image_wishlist_height');
		}

		if (isset($this->request->post['config_image_newsthumb_width'])) {
			$this->data['config_image_newsthumb_width'] = $this->request->post['config_image_newsthumb_width'];
		} else {
			$this->data['config_image_newsthumb_width'] = $this->config->get('config_image_newsthumb_width');
		}

		if (isset($this->request->post['config_image_newsthumb_height'])) {
			$this->data['config_image_newsthumb_height'] = $this->request->post['config_image_newsthumb_height'];
		} else {
			$this->data['config_image_newsthumb_height'] = $this->config->get('config_image_newsthumb_height');
		}

		if (isset($this->request->post['config_image_newspopup_width'])) {
			$this->data['config_image_newspopup_width'] = $this->request->post['config_image_newspopup_width'];
		} else {
			$this->data['config_image_newspopup_width'] = $this->config->get('config_image_newspopup_width');
		}

		if (isset($this->request->post['config_image_newspopup_height'])) {
			$this->data['config_image_newspopup_height'] = $this->request->post['config_image_newspopup_height'];
		} else {
			$this->data['config_image_newspopup_height'] = $this->config->get('config_image_newspopup_height');
		}

		if (isset($this->request->post['config_image_cart_width'])) {
			$this->data['config_image_cart_width'] = $this->request->post['config_image_cart_width'];
		} else {
			$this->data['config_image_cart_width'] = $this->config->get('config_image_cart_width');
		}

		if (isset($this->request->post['config_image_cart_height'])) {
			$this->data['config_image_cart_height'] = $this->request->post['config_image_cart_height'];
		} else {
			$this->data['config_image_cart_height'] = $this->config->get('config_image_cart_height');
		}

		// Image > Labels
		$this->data['label_ratios'] = array();

		$this->data['label_ratios'][] = array('ratio' => '20', 'title' => '20%');
		$this->data['label_ratios'][] = array('ratio' => '25', 'title' => '25%');
		$this->data['label_ratios'][] = array('ratio' => '30', 'title' => '30%');
		$this->data['label_ratios'][] = array('ratio' => '35', 'title' => '35%');
		$this->data['label_ratios'][] = array('ratio' => '40', 'title' => '40%');
		$this->data['label_ratios'][] = array('ratio' => '45', 'title' => '45%');
		$this->data['label_ratios'][] = array('ratio' => '50', 'title' => '50%');
		$this->data['label_ratios'][] = array('ratio' => '55', 'title' => '55%');
		$this->data['label_ratios'][] = array('ratio' => '60', 'title' => '60%');

		if (isset($this->request->post['config_label_size_ratio'])) {
			$this->data['config_label_size_ratio'] = $this->request->post['config_label_size_ratio'];
		} elseif ($this->config->get('config_label_size_ratio')) {
			$this->data['config_label_size_ratio'] = $this->config->get('config_label_size_ratio');
		} else {
			$this->data['config_label_size_ratio'] = '40';
		}

		if (isset($this->request->post['config_label_stock'])) {
			$this->data['config_label_stock'] = $this->request->post['config_label_stock'];
		} else {
			$this->data['config_label_stock'] = $this->config->get('config_label_stock');
		}

		if ($this->config->get('config_label_stock') && file_exists(DIR_IMAGE . $this->config->get('config_label_stock')) && is_file(DIR_IMAGE . $this->config->get('config_label_stock'))) {
			$this->data['label_stock'] = $this->model_tool_image->resize($this->config->get('config_label_stock'), 100, 100);
		} else {
			$this->data['label_stock'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['config_label_offer'])) {
			$this->data['config_label_offer'] = $this->request->post['config_label_offer'];
		} else {
			$this->data['config_label_offer'] = $this->config->get('config_label_offer');
		}

		if ($this->config->get('config_label_offer') && file_exists(DIR_IMAGE . $this->config->get('config_label_offer')) && is_file(DIR_IMAGE . $this->config->get('config_label_offer'))) {
			$this->data['label_offer'] = $this->model_tool_image->resize($this->config->get('config_label_offer'), 100, 100);
		} else {
			$this->data['label_offer'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		if (isset($this->request->post['config_label_special'])) {
			$this->data['config_label_special'] = $this->request->post['config_label_special'];
		} else {
			$this->data['config_label_special'] = $this->config->get('config_label_special');
		}

		if ($this->config->get('config_label_special') && file_exists(DIR_IMAGE . $this->config->get('config_label_special')) && is_file(DIR_IMAGE . $this->config->get('config_label_special'))) {
			$this->data['label_special'] = $this->model_tool_image->resize($this->config->get('config_label_special'), 100, 100);
		} else {
			$this->data['label_special'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		// Transfer
		if (isset($this->request->post['config_ftp_status'])) {
			$this->data['config_ftp_status'] = $this->request->post['config_ftp_status'];
		} else {
			$this->data['config_ftp_status'] = $this->config->get('config_ftp_status');
		}

		if (isset($this->request->post['config_ftp_host'])) {
			$this->data['config_ftp_host'] = $this->request->post['config_ftp_host'];
		} elseif ($this->config->get('config_ftp_host')) {
			$this->data['config_ftp_host'] = $this->config->get('config_ftp_host');
		} else {
			$this->data['config_ftp_host'] = str_replace('www.', '', $this->request->server['HTTP_HOST']);
		}

		if (isset($this->request->post['config_ftp_port'])) {
			$this->data['config_ftp_port'] = $this->request->post['config_ftp_port'];
		} elseif ($this->config->get('config_ftp_port')) {
			$this->data['config_ftp_port'] = $this->config->get('config_ftp_port');
		} else {
			$this->data['config_ftp_port'] = 21;
		}

		if (isset($this->request->post['config_ftp_username'])) {
			$this->data['config_ftp_username'] = $this->request->post['config_ftp_username'];
		} else {
			$this->data['config_ftp_username'] = $this->config->get('config_ftp_username');
		}

		if (isset($this->request->post['config_ftp_password'])) {
			$this->data['config_ftp_password'] = $this->request->post['config_ftp_password'];
		} else {
			$this->data['config_ftp_password'] = $this->config->get('config_ftp_password');
		}

		if (isset($this->request->post['config_ftp_root'])) {
			$this->data['config_ftp_root'] = $this->request->post['config_ftp_root'];
		} else {
			$this->data['config_ftp_root'] = $this->config->get('config_ftp_root');
		}

		// Mail
		if (isset($this->request->post['config_mail_protocol'])) {
			$this->data['config_mail_protocol'] = $this->request->post['config_mail_protocol'];
		} else {
			$this->data['config_mail_protocol'] = $this->config->get('config_mail_protocol');
		}

		if (isset($this->request->post['config_mail_parameter'])) {
			$this->data['config_mail_parameter'] = $this->request->post['config_mail_parameter'];
		} else {
			$this->data['config_mail_parameter'] = $this->config->get('config_mail_parameter');
		}

		if (isset($this->request->post['config_smtp_host'])) {
			$this->data['config_smtp_host'] = $this->request->post['config_smtp_host'];
		} else {
			$this->data['config_smtp_host'] = $this->config->get('config_smtp_host');
		}

		if (isset($this->request->post['config_smtp_username'])) {
			$this->data['config_smtp_username'] = $this->request->post['config_smtp_username'];
		} else {
			$this->data['config_smtp_username'] = $this->config->get('config_smtp_username');
		}

		if (isset($this->request->post['config_smtp_password'])) {
			$this->data['config_smtp_password'] = $this->request->post['config_smtp_password'];
		} else {
			$this->data['config_smtp_password'] = $this->config->get('config_smtp_password');
		}

		if (isset($this->request->post['config_smtp_port'])) {
			$this->data['config_smtp_port'] = $this->request->post['config_smtp_port'];
		} elseif ($this->config->get('config_smtp_port')) {
			$this->data['config_smtp_port'] = $this->config->get('config_smtp_port');
		} else {
			$this->data['config_smtp_port'] = 25;
		}

		if (isset($this->request->post['config_smtp_timeout'])) {
			$this->data['config_smtp_timeout'] = $this->request->post['config_smtp_timeout'];
		} elseif ($this->config->get('config_smtp_timeout')) {
			$this->data['config_smtp_timeout'] = $this->config->get('config_smtp_timeout');
		} else {
			$this->data['config_smtp_timeout'] = 5;
		}

		if (isset($this->request->post['config_alert_mail'])) {
			$this->data['config_alert_mail'] = $this->request->post['config_alert_mail'];
		} else {
			$this->data['config_alert_mail'] = $this->config->get('config_alert_mail');
		}

		if (isset($this->request->post['config_account_mail'])) {
			$this->data['config_account_mail'] = $this->request->post['config_account_mail'];
		} else {
			$this->data['config_account_mail'] = $this->config->get('config_account_mail');
		}

		if (isset($this->request->post['config_alert_emails'])) {
			$this->data['config_alert_emails'] = $this->request->post['config_alert_emails'];
		} else {
			$this->data['config_alert_emails'] = $this->config->get('config_alert_emails');
		}

		// Media
		if (isset($this->request->post['config_facebook'])) {
			$this->data['config_facebook'] = $this->request->post['config_facebook'];
		} else {
			$this->data['config_facebook'] = $this->config->get('config_facebook');
		}

		if (isset($this->request->post['config_twitter'])) {
			$this->data['config_twitter'] = $this->request->post['config_twitter'];
		} else {
			$this->data['config_twitter'] = $this->config->get('config_twitter');
		}

		if (isset($this->request->post['config_google'])) {
			$this->data['config_google'] = $this->request->post['config_google'];
		} else {
			$this->data['config_google'] = $this->config->get('config_google');
		}

		if (isset($this->request->post['config_pinterest'])) {
			$this->data['config_pinterest'] = $this->request->post['config_pinterest'];
		} else {
			$this->data['config_pinterest'] = $this->config->get('config_pinterest');
		}

		if (isset($this->request->post['config_instagram'])) {
			$this->data['config_instagram'] = $this->request->post['config_instagram'];
		} else {
			$this->data['config_instagram'] = $this->config->get('config_instagram');
		}

		if (isset($this->request->post['config_skype'])) {
			$this->data['config_skype'] = $this->request->post['config_skype'];
		} else {
			$this->data['config_skype'] = $this->config->get('config_skype');
		}

		if (isset($this->request->post['config_addthis'])) {
			$this->data['config_addthis'] = $this->request->post['config_addthis'];
		} else {
			$this->data['config_addthis'] = $this->config->get('config_addthis');
		}

		if (isset($this->request->post['config_meta_google'])) {
			$this->data['config_meta_google'] = $this->request->post['config_meta_google'];
		} else {
			$this->data['config_meta_google'] = $this->config->get('config_meta_google');
		}

		if (isset($this->request->post['config_meta_bing'])) {
			$this->data['config_meta_bing'] = $this->request->post['config_meta_bing'];
		} else {
			$this->data['config_meta_bing'] = $this->config->get('config_meta_bing');
		}

		if (isset($this->request->post['config_meta_yandex'])) {
			$this->data['config_meta_yandex'] = $this->request->post['config_meta_yandex'];
		} else {
			$this->data['config_meta_yandex'] = $this->config->get('config_meta_yandex');
		}

		if (isset($this->request->post['config_meta_baidu'])) {
			$this->data['config_meta_baidu'] = $this->request->post['config_meta_baidu'];
		} else {
			$this->data['config_meta_baidu'] = $this->config->get('config_meta_baidu');
		}

		if (isset($this->request->post['config_meta_alexa'])) {
			$this->data['config_meta_alexa'] = $this->request->post['config_meta_alexa'];
		} else {
			$this->data['config_meta_alexa'] = $this->config->get('config_meta_alexa');
		}

		if (isset($this->request->post['config_google_analytics'])) {
			$this->data['config_google_analytics'] = $this->request->post['config_google_analytics'];
		} else {
			$this->data['config_google_analytics'] = $this->config->get('config_google_analytics');
		}

		if (isset($this->request->post['config_alexa_analytics'])) {
			$this->data['config_alexa_analytics'] = $this->request->post['config_alexa_analytics'];
		} else {
			$this->data['config_alexa_analytics'] = $this->config->get('config_alexa_analytics');
		}

		if (isset($this->request->post['config_piwik_analytics'])) {
			$this->data['config_piwik_analytics'] = $this->request->post['config_piwik_analytics'];
		} else {
			$this->data['config_piwik_analytics'] = $this->config->get('config_piwik_analytics');
		}

		$this->data['google_web'] = 'https://www.google.com/webmasters/tools/home';
		$this->data['bing_web'] = 'https://ssl.bing.com/webmaster/home/mysites';
		$this->data['yandex_web'] = 'http://webmaster.yandex.com/sites/';
		$this->data['baidu_web'] = 'http://zhanzhang.baidu.com/sitemap/index';
		$this->data['alexa_web'] = 'http://www.alexa.com/';
		$this->data['piwik_web'] = 'https://piwik.org/';

		// Server
		if (isset($this->request->post['config_secure'])) {
			$this->data['config_secure'] = $this->request->post['config_secure'];
		} else {
			$this->data['config_secure'] = $this->config->get('config_secure');
		}

		if (isset($this->request->post['config_shared'])) {
			$this->data['config_shared'] = $this->request->post['config_shared'];
		} else {
			$this->data['config_shared'] = $this->config->get('config_shared');
		}

		if (isset($this->request->post['config_robots'])) {
			$this->data['config_robots'] = $this->request->post['config_robots'];
		} else {
			$this->data['config_robots'] = $this->config->get('config_robots');
		}

		if (isset($this->request->post['config_robots_online'])) {
			$this->data['config_robots_online'] = $this->request->post['config_robots_online'];
		} else {
			$this->data['config_robots_online'] = $this->config->get('config_robots_online');
		}

		if (isset($this->request->post['config_password'])) {
			$this->data['config_password'] = $this->request->post['config_password'];
		} else {
			$this->data['config_password'] = $this->config->get('config_password');
		}

		if (isset($this->request->post['config_ban_page'])) {
			$this->data['config_ban_page'] = $this->request->post['config_ban_page'];
		} else {
			$this->data['config_ban_page'] = $this->config->get('config_ban_page');
		}

		if (isset($this->request->post['config_file_max_size'])) {
			$this->data['config_file_max_size'] = $this->request->post['config_file_max_size'];
		} elseif ($this->config->get('config_file_max_size')) {
			$this->data['config_file_max_size'] = $this->config->get('config_file_max_size');
		} else {
			$this->data['config_file_max_size'] = 300000;
		}

		if (isset($this->request->post['config_file_extension_allowed'])) {
			$this->data['config_file_extension_allowed'] = $this->request->post['config_file_extension_allowed'];
		} else {
			$this->data['config_file_extension_allowed'] = $this->config->get('config_file_extension_allowed');
		}

		if (isset($this->request->post['config_file_mime_allowed'])) {
			$this->data['config_file_mime_allowed'] = $this->request->post['config_file_mime_allowed'];
		} else {
			$this->data['config_file_mime_allowed'] = $this->config->get('config_file_mime_allowed');
		}

		if (isset($this->request->post['config_maintenance'])) {
			$this->data['config_maintenance'] = $this->request->post['config_maintenance'];
		} else {
			$this->data['config_maintenance'] = $this->config->get('config_maintenance');
		}

		if (isset($this->request->post['config_seo_url'])) {
			$this->data['config_seo_url'] = $this->request->post['config_seo_url'];
		} else {
			$this->data['config_seo_url'] = $this->config->get('config_seo_url');
		}

		if (isset($this->request->post['config_seo_url_cache'])) {
			if (isset($this->request->post['config_seo_url']) && ($this->request->post['config_seo_url'] == 1)) {
				$this->data['config_seo_url_cache'] = $this->request->post['config_seo_url_cache'];
			} else {
				$this->data['config_seo_url_cache'] = 0;
			}
		} else {
			if ($this->config->get('config_seo_url') == 1) {
				$this->data['config_seo_url_cache'] = $this->config->get('config_seo_url_cache');
			} else {
				$this->data['config_seo_url_cache'] = 0;
			}
		}

		if (isset($this->request->post['config_encryption'])) {
			$this->data['config_encryption'] = $this->request->post['config_encryption'];
		} else {
			$this->data['config_encryption'] = $this->config->get('config_encryption');
		}

		if (isset($this->request->post['config_compression'])) {
			$this->data['config_compression'] = $this->request->post['config_compression'];
		} else {
			$this->data['config_compression'] = $this->config->get('config_compression');
		}

		if (isset($this->request->post['config_error_display'])) {
			$this->data['config_error_display'] = $this->request->post['config_error_display'];
		} else {
			$this->data['config_error_display'] = $this->config->get('config_error_display');
		}

		if (isset($this->request->post['config_error_log'])) {
			$this->data['config_error_log'] = $this->request->post['config_error_log'];
		} else {
			$this->data['config_error_log'] = $this->config->get('config_error_log');
		}

		if (isset($this->request->post['config_error_filename'])) {
			$this->data['config_error_filename'] = $this->request->post['config_error_filename'];
		} else {
			$this->data['config_error_filename'] = $this->config->get('config_error_filename');
		}

		if (isset($this->request->post['config_mail_filename'])) {
			$this->data['config_mail_filename'] = $this->request->post['config_mail_filename'];
		} else {
			$this->data['config_mail_filename'] = $this->config->get('config_mail_filename');
		}

		if (isset($this->request->post['config_quote_filename'])) {
			$this->data['config_quote_filename'] = $this->request->post['config_quote_filename'];
		} else {
			$this->data['config_quote_filename'] = $this->config->get('config_quote_filename');
		}

		$this->template = 'setting/setting.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'setting/setting')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['config_name'] || (utf8_strlen($this->request->post['config_name']) < 3) || (utf8_strlen($this->request->post['config_name']) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['config_owner']) < 3) || (utf8_strlen($this->request->post['config_owner']) > 64)) {
			$this->error['owner'] = $this->language->get('error_owner');
		}

		if ((utf8_strlen($this->request->post['config_address']) < 3) || (utf8_strlen($this->request->post['config_address']) > 256)) {
			$this->error['address'] = $this->language->get('error_address');
		}

		if ((utf8_strlen($this->request->post['config_email']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['config_email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['config_email_noreply']) > 96) || !preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i', $this->request->post['config_email_noreply'])) {
			$this->error['email_noreply'] = $this->language->get('error_email_noreply');
		}

		if ((utf8_strlen($this->request->post['config_telephone']) < 3) || (utf8_strlen($this->request->post['config_telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if (!$this->request->post['config_title'] || (utf8_strlen($this->request->post['config_title']) < 3) || (utf8_strlen($this->request->post['config_title']) > 32)) {
			$this->error['title'] = $this->language->get('error_title');
		}

		if (($this->request->post['config_one_page_checkout'] == 1) && ($this->request->post['config_express_checkout'] == 1)) {
			$this->error['multiple_checkout'] = $this->language->get('error_multiple_checkout');
		}

		if (!empty($this->request->post['config_customer_group_display']) && !in_array($this->request->post['config_customer_group_id'], $this->request->post['config_customer_group_display'])) {
			$this->error['customer_group_display'] = $this->language->get('error_customer_group_display');
		}

		if ($this->request->post['config_login_attempts'] < 1) {
			$this->error['login_attempts'] = $this->language->get('error_login_attempts');
		}

		if (!$this->request->post['config_voucher_min']) {
			$this->error['voucher_min'] = $this->language->get('error_voucher_min');
		}

		if (!$this->request->post['config_voucher_max']) {
			$this->error['voucher_max'] = $this->language->get('error_voucher_max');
		}

		if (!$this->request->post['config_catalog_limit']) {
			$this->error['catalog_limit'] = $this->language->get('error_limit');
		}

		if (!$this->request->post['config_admin_limit']) {
			$this->error['admin_limit'] = $this->language->get('error_limit');
		}

		if (!$this->request->post['config_pagination_hi'] && !$this->request->post['config_pagination_lo']) {
			$this->error['preference_pagination'] = $this->language->get('error_preference_pagination');
		}

		if (!$this->request->post['config_image_category_width'] || !$this->request->post['config_image_category_height']) {
			$this->error['image_category'] = $this->language->get('error_image_category');
		}

		if (!$this->request->post['config_image_thumb_width'] || !$this->request->post['config_image_thumb_height']) {
			$this->error['image_thumb'] = $this->language->get('error_image_thumb');
		}

		if (!$this->request->post['config_image_popup_width'] || !$this->request->post['config_image_popup_height']) {
			$this->error['image_popup'] = $this->language->get('error_image_popup');
		}

		if (!$this->request->post['config_image_product_width'] || !$this->request->post['config_image_product_height']) {
			$this->error['image_product'] = $this->language->get('error_image_product');
		}

		if (!$this->request->post['config_image_additional_width'] || !$this->request->post['config_image_additional_height']) {
			$this->error['image_additional'] = $this->language->get('error_image_additional');
		}

		if (!$this->request->post['config_image_brand_width'] || !$this->request->post['config_image_brand_height']) {
			$this->error['image_brand'] = $this->language->get('error_image_brand');
		}

		if (!$this->request->post['config_image_related_width'] || !$this->request->post['config_image_related_height']) {
			$this->error['image_related'] = $this->language->get('error_image_related');
		}

		if (!$this->request->post['config_image_compare_width'] || !$this->request->post['config_image_compare_height']) {
			$this->error['image_compare'] = $this->language->get('error_image_compare');
		}

		if (!$this->request->post['config_image_wishlist_width'] || !$this->request->post['config_image_wishlist_height']) {
			$this->error['image_wishlist'] = $this->language->get('error_image_wishlist');
		}

		if (!$this->request->post['config_image_newsthumb_width'] || !$this->request->post['config_image_newsthumb_height']) {
			$this->error['image_newsthumb'] = $this->language->get('error_image_newsthumb');
		}

		if (!$this->request->post['config_image_newspopup_width'] || !$this->request->post['config_image_newspopup_height']) {
			$this->error['image_newspopup'] = $this->language->get('error_image_newspopup');
		}

		if (!$this->request->post['config_image_cart_width'] || !$this->request->post['config_image_cart_height']) {
			$this->error['image_cart'] = $this->language->get('error_image_cart');
		}

		if ($this->request->post['config_ftp_status']) {
			if (!$this->request->post['config_ftp_host']) {
				$this->error['ftp_host'] = $this->language->get('error_ftp_host');
			}

			if (!$this->request->post['config_ftp_port']) {
				$this->error['ftp_port'] = $this->language->get('error_ftp_port');
			}

			if (!$this->request->post['config_ftp_username']) {
				$this->error['ftp_username'] = $this->language->get('error_ftp_username');
			}

			if (!$this->request->post['config_ftp_password']) {
				$this->error['ftp_password'] = $this->language->get('error_ftp_password');
			}
		}

		if (!$this->request->post['config_error_filename'] || !preg_match('/\.txt$/i', $this->request->post['config_error_filename'])) {
			$this->error['error_filename'] = $this->language->get('error_error_filename');
		}

		if (!$this->request->post['config_mail_filename'] || !preg_match('/\.txt$/i', $this->request->post['config_mail_filename'])) {
			$this->error['mail_filename'] = $this->language->get('error_mail_filename');
		}

		if (!$this->request->post['config_quote_filename'] || !preg_match('/\.txt$/i', $this->request->post['config_quote_filename'])) {
			$this->error['quote_filename'] = $this->language->get('error_quote_filename');
		}

		if ($this->request->post['config_file_max_size'] < 100000) {
			$this->error['file_max_size'] = $this->language->get('error_file_max_size');
		}

		if ($this->request->post['config_seo_url'] && !file_exists('../.htaccess')) {
			$this->load->model('tool/system');

			$this->model_tool_system->setupSeo();
		}

		if ((utf8_strlen($this->request->post['config_encryption']) < 3) || (utf8_strlen($this->request->post['config_encryption']) > 32)) {
			$this->error['encryption'] = $this->language->get('error_encryption');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return empty($this->error);
	}

	public function template() {
		if ((isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) || ($this->request->server['HTTPS'] == '443')) {
			$server = HTTPS_CATALOG;
		} elseif (isset($this->request->server['HTTP_X_FORWARDED_PROTO']) && $this->request->server['HTTP_X_FORWARDED_PROTO'] == 'https') {
			$server = HTTPS_CATALOG;
		} else {
			$server = HTTP_CATALOG;
		}

		if (file_exists(DIR_IMAGE . 'templates/' . basename($this->request->get['template']) . '.png')) {
			$image = $server . 'image/templates/' . basename($this->request->get['template']) . '.png';
		} else {
			$image = $server . 'image/no_image.jpg';
		}

		$this->response->setOutput('<img src="' . $image . '" alt="" title="" style="border:1px solid #EEE;" />');
	}
}
