<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
	<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php } ?>
	</div>
	<div class="box">
	<div class="heading">
		<h1><img src="view/image/information.png" alt="" /> <?php echo $heading_title; ?></h1>
	</div>
	<div class="content">
		<table class="form">
			<tr>
				<td colspan="4" style="font-size:14px;"><?php echo $text_introduction; ?></td>
			</tr>
		</table>
		<h2><?php echo $text_general; ?></h2>
		<div style="background:#FAFAFA; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
		<table width="100%">
			<tr>
				<th width="40%" style="text-align:left; height:30px;"><u><?php echo $column_general; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_opencart; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_overclocked; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_extreme; ?></u></th>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_license; ?></td>
				<td style="text-align:center;"><b>FREE</b></td>
				<td style="text-align:center;"><b>FREE</b></td>
				<td style="text-align:center;"><b>$50</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_jquery; ?></td>
				<td style="text-align:center;"><b>1.7.1 min</b></td>
				<td style="text-align:center;"><b>1.11.1 min</b></td>
				<td style="text-align:center;"><b>1.11.1 min</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_jquery_ui; ?></td>
				<td style="text-align:center;"><b>1.8.16 min</b></td>
				<td style="text-align:center;"><b>1.10.4 min</b></td>
				<td style="text-align:center;"><b>1.10.4 min</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_jquery_ui_theme; ?></td>
				<td style="text-align:center;"><b>ui-lightness</b></td>
				<td style="text-align:center;"><b>start</b></td>
				<td style="text-align:center;"><b>start</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_rss_feed; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_tag_table; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_time_format; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_clean_code; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_robots; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_cache_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_menu_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_tab_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_news_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_faqs_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_gallery_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_news_layout; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_faqs_layout; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_gallery_layout; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_special_layout; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_content_header; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_html_email; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_cookie_consent; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px;"><?php echo $text_fraudlabspro; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
		</table>
		</div>
		<h2><?php echo $text_admin; ?></h2>
		<div style="background:#FAFAFA; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
		<table width="100%">
			<tr>
				<th width="40%" style="text-align:left; height:30px;"><u><?php echo $column_admin; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_opencart; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_overclocked; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_extreme; ?></u></th>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_ckeditor; ?></td>
				<td style="text-align:center;"><b>4.0.0 Basic</b></td>
				<td style="text-align:center;"><b>4.2.1 Full</b></td>
				<td style="text-align:center;"><b>4.2.1 Full</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_save_continue; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_dash_month; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_dash_review; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_country_mod; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_image_manager; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_jstree_theme; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_config_page; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_database_page; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_features_page; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_addthis_pub; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_admin_menu; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_button_form; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_image_limit; ?></td>
				<td style="text-align:center;"><b>300 kb</b></td>
				<td style="text-align:center;"><b>1024 kb</b></td>
				<td style="text-align:center;"><b>2048 kb</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_jquery_flot; ?></td>
				<td style="text-align:center;"><b>0.7.0 min</b></td>
				<td style="text-align:center;"><b>0.8.2 min</b></td>
				<td style="text-align:center;"><b>0.8.2 min</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_php_upload; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_dash_layout; ?></td>
				<td style="text-align:center;"><b>50/50</b></td>
				<td style="text-align:center;"><b>40/60</b></td>
				<td style="text-align:center;"><b>40/60</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_dash_tabs; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_sitemap_tool; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_tooltips; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_invoice_logo; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_delivery_note; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_page_load; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_preference; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_login_home; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_ajax_cart; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_autocomplete; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_backtotop; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_menu_off; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px;"><?php echo $text_tooltips_off; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
		</table>
		</div>
		<h2><?php echo $text_catalog; ?></h2>
		<div style="background:#FAFAFA; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
		<table width="100%">
			<tr>
				<th width="40%" style="text-align:left; height:30px;"><u><?php echo $column_catalog; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_opencart; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_overclocked; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_extreme; ?></u></th>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_module_style; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_magnific_zoom; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_template_variable; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_meta_names; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_grid_list; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_search_box; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_addthis_script; ?></td>
				<td style="text-align:center;"><b>250</b></td>
				<td style="text-align:center;"><b>300</b></td>
				<td style="text-align:center;"><b>300</b></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_sitemap_page; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_new_captcha; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_brand_list; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_category_list; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_product_list; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_review_list; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_news_list; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px;"><?php echo $text_addtocart; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
		</table>
		</div>
		<h2><?php echo $text_module; ?></h2>
		<div style="background:#FAFAFA; border:1px solid #DDD; padding:10px; margin-bottom:15px;">
		<table width="100%">
			<tr>
				<th width="40%" style="text-align:left; height:30px;"><u><?php echo $column_module; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_opencart; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_overclocked; ?></u></th>
				<th width="20%" style="text-align:center;"><u><?php echo $column_extreme; ?></u></th>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_apply_standard; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_custom_name; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_use_theme; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_ebay_display; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_tag_cloud; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_custom_menu; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_news_module; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_faqs_module; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_gallery_module; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px; border-bottom:1px dotted #DDD;"><?php echo $text_html_module; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
			<tr>
				<td style="height:35px;"><?php echo $text_popular_module; ?></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/warning.png" alt="" /></td>
				<td style="text-align:center;"><img src="view/image/success.png" alt="" /></td>
			</tr>
		</table>
		</div>
		<div>
			<a onclick="window.open('http://villagedefrance.net/index.php');" title="Villagedefrance"><img src="view/image/villagedefrance/villagedefrance.png" alt="" /></a>
		</div>
	</div>
</div>
<?php echo $footer; ?>