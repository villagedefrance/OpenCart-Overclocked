<?php
class ControllerModuleMenuHorizontal extends Controller {
	private $_name = 'menu_horizontal';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$template = $this->config->get('config_template');

		// Options
		$menu_theme = $this->config->get($this->_name . '_theme');

		$header_color = $this->config->get($this->_name . '_header_color');
		$header_shape = $this->config->get($this->_name . '_header_shape');

		$mod_color = ($header_color) ? $header_color . '-skin' : 'white-skin';
		$mod_shape = ($header_shape) ? $header_shape : 'rounded-0';

		$menu_direction = $setting['direction'] ? 'ltr' : 'rtl';

		if ($menu_theme == 'custom') {
			$this->document->addStyle('catalog/view/theme/' . $template . '/stylesheet/menu-' . $menu_direction . '.css');

			if ($mod_color == 'white-skin' || $mod_color == 'beige-skin' || $mod_color == 'ash-skin' || $mod_color == 'silver-skin' || $mod_color == 'citrus-skin' || $mod_color == 'yellow-skin' || $mod_color == 'mist-skin') {
				$this->document->addStyle('catalog/view/theme/' . $template . '/stylesheet/menu-dark.css');
				$menu_theme = 'light';
			} else {
				$this->document->addStyle('catalog/view/theme/' . $template . '/stylesheet/menu-light.css');
				$menu_theme = 'dark';
			}

			$menu_class = 'menu-' . $menu_direction;

		} else {
			$this->document->addStyle('catalog/view/theme/' . $template . '/stylesheet/menu-' . $menu_theme . '-' . $menu_direction . '.css');

			$menu_class = 'menu-' . $menu_theme;
		}

		$this->data['mod_color'] = $mod_color;
		$this->data['mod_shape'] = $mod_shape;

		$this->data['menu_class'] = $menu_class;
		$this->data['menu_theme'] = $menu_theme;
		$this->data['menu_direction'] = $menu_direction;

		$this->data['column_limit'] = $this->config->get($this->_name . '_column_limit') ? $this->config->get($this->_name . '_column_limit') : 10;
		$this->data['column_number'] = $this->config->get($this->_name . '_column_number') ? $this->config->get($this->_name . '_column_number') : 4;

		$this->data['menu_home'] = isset($setting['home']) ? true : false;

		$this->data['home'] = $this->url->link('common/home');

		// Menu Horizontal
		$this->load->model('design/menu');

		$this->data['menu_horizontal'] = array();

		$menu_id = $setting['menu_id'];

		$menu = $this->model_design_menu->getMenu($menu_id);

		$menu_items = $this->model_design_menu->getMenuItems(0, $menu_id);

		foreach ($menu_items as $menu_item) {
			if (!empty($menu_item['menu_item_link'])) {
				if ($menu_item['external_link']) {
					$href = html_entity_decode($menu_item['menu_item_link'], ENT_QUOTES, 'UTF-8');
				} else {
					$href = $this->url->link($menu_item['menu_item_link']);
				}
			} else {
				$href = '';
			}

			$children_data = array();

			$children = $this->model_design_menu->getMenuItems($menu_item['menu_item_id'], $menu_id);

			foreach ($children as $child) {
				if (!empty($child['menu_item_link'])) {
					if ($child['external_link']) {
						$child_href = html_entity_decode($child['menu_item_link'], ENT_QUOTES, 'UTF-8');
					} else {
						$child_href = $this->url->link($child['menu_item_link']);
					}
				} else {
					$child_href = '';
				}

				$child_total = $this->model_design_menu->getTotalMenuItemsByParentId($menu_id, $menu_item['parent_id']);

				$children_data[] = array(
					'item_id' => $child['menu_item_id'],
					'name'    => $child['name'],
					'total'   => $child_total,
					'href'    => $child_href
				);
			}

			$this->data['menu_horizontal'][] = array(
				'item_id'  => $menu_item['menu_item_id'],
				'name'     => $menu_item['menu_item_name'],
				'children' => $children_data,
				'href'     => $href
			);
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $template;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
			$this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
?>