<?php 
//------------------------
// Overclocked Edition		
//------------------------

class ControllerToolFeatures extends Controller { 
	private $error = array(); 
	private $_name = 'features'; 

	public function index() { 

		$this->language->load('tool/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title')); 

		$this->data['breadcrumbs'] = array(); 

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		); 

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		); 

		$this->data['heading_title'] = $this->language->get('heading_title'); 

		$this->data['text_on'] = $this->language->get('text_on'); 
		$this->data['text_off'] = $this->language->get('text_off'); 
		$this->data['text_introduction'] = $this->language->get('text_introduction'); 
		$this->data['text_general'] = $this->language->get('text_general'); 
		$this->data['text_admin'] = $this->language->get('text_admin'); 
		$this->data['text_catalog'] = $this->language->get('text_catalog'); 
		$this->data['text_module'] = $this->language->get('text_module'); 

		$this->data['column_general'] = $this->language->get('column_general'); 
		$this->data['column_admin'] = $this->language->get('column_admin'); 
		$this->data['column_catalog'] = $this->language->get('column_catalog'); 
		$this->data['column_module'] = $this->language->get('column_module'); 
		$this->data['column_opencart'] = $this->language->get('column_opencart'); 
		$this->data['column_overclocked'] = $this->language->get('column_overclocked'); 
		$this->data['column_extreme'] = $this->language->get('column_extreme'); 

		// General Overclocked
		$this->data['text_license'] = $this->language->get('text_license'); 
		$this->data['text_jquery'] = $this->language->get('text_jquery'); 
		$this->data['text_jquery_ui'] = $this->language->get('text_jquery_ui'); 
		$this->data['text_jquery_ui_theme'] = $this->language->get('text_jquery_ui_theme'); 
		$this->data['text_rss_feed'] = $this->language->get('text_rss_feed'); 
		$this->data['text_tag_table'] = $this->language->get('text_tag_table'); 
		$this->data['text_time_format'] = $this->language->get('text_time_format'); 
		$this->data['text_clean_code'] = $this->language->get('text_clean_code'); 
		$this->data['text_robots'] = $this->language->get('text_robots'); 
		// General Extreme
		$this->data['text_cache_manager'] = $this->language->get('text_cache_manager'); 
		$this->data['text_menu_manager'] = $this->language->get('text_menu_manager'); 
		$this->data['text_tab_manager'] = $this->language->get('text_tab_manager'); 
		$this->data['text_news_manager'] = $this->language->get('text_news_manager'); 
		$this->data['text_faqs_manager'] = $this->language->get('text_faqs_manager'); 
		$this->data['text_gallery_manager'] = $this->language->get('text_gallery_manager'); 
		$this->data['text_news_layout'] = $this->language->get('text_news_layout'); 
		$this->data['text_faqs_layout'] = $this->language->get('text_faqs_layout'); 
		$this->data['text_gallery_layout'] = $this->language->get('text_gallery_layout'); 
		$this->data['text_special_layout'] = $this->language->get('text_special_layout'); 
		$this->data['text_content_header'] = $this->language->get('text_content_header'); 
		$this->data['text_html_email'] = $this->language->get('text_html_email'); 
		$this->data['text_cookie_consent'] = $this->language->get('text_cookie_consent'); 
		$this->data['text_fraudlabspro'] = $this->language->get('text_fraudlabspro'); 

		// Admin Overclocked
		$this->data['text_ckeditor'] = $this->language->get('text_ckeditor'); 
		$this->data['text_save_continue'] = $this->language->get('text_save_continue'); 
		$this->data['text_dash_month'] = $this->language->get('text_dash_month'); 
		$this->data['text_dash_review'] = $this->language->get('text_dash_review'); 
		$this->data['text_country_mod'] = $this->language->get('text_country_mod'); 
		$this->data['text_image_manager'] = $this->language->get('text_image_manager'); 
		$this->data['text_jstree_theme'] = $this->language->get('text_jstree_theme'); 
		$this->data['text_config_page'] = $this->language->get('text_config_page'); 
		$this->data['text_database_page'] = $this->language->get('text_database_page'); 
		$this->data['text_features_page'] = $this->language->get('text_features_page'); 
		$this->data['text_addthis_pub'] = $this->language->get('text_addthis_pub'); 
		$this->data['text_admin_menu'] = $this->language->get('text_admin_menu'); 
		$this->data['text_button_form'] = $this->language->get('text_button_form'); 
		$this->data['text_image_limit'] = $this->language->get('text_image_limit'); 
		$this->data['text_jquery_flot'] = $this->language->get('text_jquery_flot'); 
		$this->data['text_php_upload'] = $this->language->get('text_php_upload'); 
		$this->data['text_dash_layout'] = $this->language->get('text_dash_layout'); 
		// Admin Extreme
		$this->data['text_dash_tabs'] = $this->language->get('text_dash_tabs'); 
		$this->data['text_sitemap_tool'] = $this->language->get('text_sitemap_tool'); 
		$this->data['text_tooltips'] = $this->language->get('text_tooltips'); 
		$this->data['text_invoice_logo'] = $this->language->get('text_invoice_logo'); 
		$this->data['text_delivery_note'] = $this->language->get('text_delivery_note'); 
		$this->data['text_page_load'] = $this->language->get('text_page_load'); 
		$this->data['text_preference'] = $this->language->get('text_preference'); 
		$this->data['text_login_home'] = $this->language->get('text_login_home'); 
		$this->data['text_ajax_cart'] = $this->language->get('text_ajax_cart'); 
		$this->data['text_autocomplete'] = $this->language->get('text_autocomplete'); 
		$this->data['text_backtotop'] = $this->language->get('text_backtotop'); 
		$this->data['text_menu_off'] = $this->language->get('text_menu_off'); 
		$this->data['text_tooltips_off'] = $this->language->get('text_tooltips_off'); 

		// Catalog Overclocked
		$this->data['text_module_style'] = $this->language->get('text_module_style'); 
		$this->data['text_magnific_zoom'] = $this->language->get('text_magnific_zoom'); 
		$this->data['text_template_variable'] = $this->language->get('text_template_variable'); 
		$this->data['text_meta_names'] = $this->language->get('text_meta_names'); 
		$this->data['text_grid_list'] = $this->language->get('text_grid_list'); 
		$this->data['text_search_box'] = $this->language->get('text_search_box'); 
		$this->data['text_addthis_script'] = $this->language->get('text_addthis_script'); 
		$this->data['text_sitemap_page'] = $this->language->get('text_sitemap_page'); 
		$this->data['text_new_captcha'] = $this->language->get('text_new_captcha'); 
		// Catalog Extreme
		$this->data['text_brand_list'] = $this->language->get('text_brand_list'); 
		$this->data['text_category_list'] = $this->language->get('text_category_list'); 
		$this->data['text_product_list'] = $this->language->get('text_product_list'); 
		$this->data['text_review_list'] = $this->language->get('text_review_list'); 
		$this->data['text_news_list'] = $this->language->get('text_news_list'); 
		$this->data['text_addtocart'] = $this->language->get('text_addtocart'); 

		// Module Overclocked
		$this->data['text_apply_standard'] = $this->language->get('text_apply_standard'); 
		$this->data['text_custom_name'] = $this->language->get('text_custom_name'); 
		$this->data['text_use_theme'] = $this->language->get('text_use_theme'); 
		$this->data['text_ebay_display'] = $this->language->get('text_ebay_display'); 
		$this->data['text_tag_cloud'] = $this->language->get('text_tag_cloud'); 
		// Module Extreme
		$this->data['text_custom_menu'] = $this->language->get('text_custom_menu'); 
		$this->data['text_news_module'] = $this->language->get('text_news_module'); 
		$this->data['text_faqs_module'] = $this->language->get('text_faqs_module'); 
		$this->data['text_html_module'] = $this->language->get('text_html_module'); 
		$this->data['text_gallery_module'] = $this->language->get('text_gallery_module'); 
		$this->data['text_popular_module'] = $this->language->get('text_popular_module'); 

		$this->data['token'] = $this->session->data['token']; 

		if (isset($this->error['warning'])) { 
			$this->data['error_warning'] = $this->error['warning']; 
		} else { 
			$this->data['error_warning'] = ''; 
		} 

		$this->template = 'tool/' . $this->_name . '.tpl'; 
		$this->children = array(
			'common/header',
			'common/footer'
		); 

		$this->response->setOutput($this->render()); 
	} 

	private function validate() { 
		if (!$this->user->hasPermission('modify', 'tool/' . $this->_name)) { 
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