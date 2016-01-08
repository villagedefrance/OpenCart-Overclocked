<?php
class ControllerModuleMenuHorizontal extends Controller {
	private $_name = 'menu_horizontal';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		$this->data['heading_title'] = $this->language->get('heading_title');

		// Options
		$menu_direction = $setting['direction'] ? true : false;
		$menu_theme = $this->config->get($this->_name . '_theme');

		if ($menu_direction && $menu_theme == 'light') {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/menu-light.css');
		} elseif ($menu_direction && $menu_theme == 'dark')  {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/menu-dark.css');
		} elseif (!$menu_direction && $menu_theme == 'light')  {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/menu-light-rtl.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/menu-dark-rtl.css');
		}

		$this->data['column_limit'] = $this->config->get($this->_name . '_column_limit') ? $this->config->get($this->_name . '_column_limit') : 10;
		$this->data['column_number'] = $this->config->get($this->_name . '_column_number') ? $this->config->get($this->_name . '_column_number') : 4;

		$this->data['menu_theme'] = $this->config->get($this->_name . '_theme');
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
					'item_id'	=> $child['menu_item_id'],
					'name'	=> $child['name'],
					'total'		=> $child_total,
					'href'		=> $child_href
				);
			}

			$this->data['menu_horizontal'][] = array(
				'item_id'		=> $menu_item['menu_item_id'],
				'name'		=> $menu_item['menu_item_name'],
				'children'		=> $children_data,
				'href'			=> $href
			);
		}

		$this->data['module'] = $module++;

		// Template
		$this->data['template'] = $this->config->get('config_template');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/' . $this->_name . '.tpl';
		} else {
			$this->template = 'default/template/module/' . $this->_name . '.tpl';
		}

		$this->render();
	}
}
?>