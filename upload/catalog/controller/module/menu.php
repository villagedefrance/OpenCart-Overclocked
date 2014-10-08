<?php
class ControllerModuleMenu extends Controller {
	private $_name = 'menu';

	protected function index($setting) {
		static $module = 0;

		$this->language->load('module/' . $this->_name);

		// Menu
		$this->load->model('design/menu');

		$menu = $this->model_design_menu->getMenu($setting['menu_id']);

		if ($menu) {
			$menu_id = $setting['menu_id'];

			$this->data['title'] = $this->model_design_menu->getMenuTitle($menu_id);

			$this->load->model('design/menuitems');

			// Cache
			$menu_item_data = $this->cache->get('menu_items.' . (int)$this->config->get('config_language_id') . '.' . (int)$menu_id);

			if (!$menu_item_data) {
				$menu_item_data = $this->model_design_menuitems->getMenuItems(0, $menu_id);

				$this->cache->set('menu_items.' . (int)$this->config->get('config_language_id') . '.' . (int)$menu_id, $menu_item_data);
			}

			$this->data['menu_items'] = $menu_item_data;

			// Generate
			$this->data['custom_menu'] = $this->drawHMenu($menu_item_data);

		} else {
			$this->data['custom_menu'] = false;
		}

		// Template
		$this->data['template'] = $this->config->get('config_template');

    	$this->data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/menu.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/menu.tpl';
		} else {
			$this->template = 'default/template/module/menu.tpl';
		}

		$this->render();
  	}

	public function drawHMenu($menu_items) {
  		$drawmenu='';

  		foreach ($menu_items as $menu_item) {
  			if ($menu_item['menu_external']) {
				$href = html_entity_decode($menu_item['menu_link'], ENT_QUOTES, 'UTF-8');
			} else {
				$href = $this->url->link($menu_item['menu_link']);
			}

			$drawmenu.='<li><a href="' . $href . '">' . $menu_item['menu_name'] . '</a>';

  			if ($menu_item['children']) {
				$drawmenu.='<div><ul>';

				for ($i = 1; $i < count($menu_item['children']); $i++) {
					if ($i = count($menu_item['children'])) {
						$drawmenu.='<li>' . $this->drawHMenu($menu_item['children']);
					} else {
						$drawmenu.='<li>' . $this->drawHMenu($menu_item['children']) . '</li>';
					}
				}

				$drawmenu.='</ul></div>';
			}

			$drawmenu.='</li>';
  		}

  		return $drawmenu;
  	}
}
?>