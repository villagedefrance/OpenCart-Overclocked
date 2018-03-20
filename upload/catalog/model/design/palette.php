<?php
class ModelDesignPalette extends Model {

	public function getPalette($palette_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "palette WHERE palette_id = '" . (int)$palette_id . "'");

		return $query->row;
	}

	public function getPalettes($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "palette";

		$sort_data = array('name');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getPaletteIds($data = array()) {
		$palette_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette");

		foreach ($query->rows as $result) {
			$palette_data[] = array('palette_id' => $result['palette_id']);
		}

		return $palette_data;
	}

	public function getPaletteColors() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color pc LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (pc.palette_id = pcd.palette_id) WHERE pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY pc.palette_color_id ORDER BY pc.palette_id, pcd.title ASC");

		return $query->rows;
	}

	public function getProductColors($product_id) {
		$product_color_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_color WHERE product_id = '" . (int)$product_id . "'");

		foreach ($query->rows as $result) {
			$product_color_data[] = $result['palette_color_id'];
		}

		return $product_color_data;
	}

	public function getPaletteColorGroups() {
		$names = array();
		$totals = array();
		$colors = array();

		$colorcloud = false;

		$query = $this->db->query("SELECT pc.skin AS skin FROM " . DB_PREFIX . "palette_color pc LEFT JOIN " . DB_PREFIX . "product_color pdc ON (pc.palette_color_id = pdc.palette_color_id) LEFT JOIN " . DB_PREFIX . "product p ON (pdc.product_id = p.product_id) WHERE pc.palette_id = p.palette_id AND p.status = '1'");

		if (count($query->rows) > 0) {
			foreach ($query->rows as $row) {
				$colorcount = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color WHERE skin = '" . $row['skin'] . "'");

				$names[] = (string)$row['skin'];
				$totals[] = $colorcount->num_rows;
			}

			$colors = array_combine($names, $totals);

			$colorcloud = $this->generateColorCloud($colors);
		}

		return $colorcloud;
	}

	protected function generateColorCloud($colors) {
		$template = $this->config->get('config_template');

		arsort($colors);

		$cloud = array();

		foreach ($colors as $key => $value) {
			$key = trim(str_replace('&', '&amp;', (string)$key));

			$cloud[] = '<a href="' . $this->url->link('product/search', 'search=' . $key . '&color=' . $key, 'SSL') . '" title="' . $key . '"><img src="catalog/view/theme/' . $template . '/image/color/' . strtolower($key) . '.png" alt="' . $key . '" height="32" width="32" /></a> ';
		}

		$colorcloud = '';

		shuffle($cloud);

		for ($x = 0; $x < count($cloud); $x++) {
			$colorcloud .= $cloud[$x];
		}

		return $colorcloud;
	}

	public function getPaletteColorsByPaletteId($palette_id) {
		$colors_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette p LEFT JOIN " . DB_PREFIX . "palette_color pc ON (p.palette_id = pc.palette_id) LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (p.palette_id = pcd.palette_id) WHERE pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pcd.palette_id = '" . (int)$palette_id . "' GROUP BY pcd.palette_color_id ORDER BY p.palette_id, pcd.title ASC");

		foreach ($query->rows as $result) {
			$colors_data[] = array(
				'palette_color_id' => $result['palette_color_id'],
				'color'            => $result['color'],
				'skin'             => $result['skin'],
				'title'            => $result['title']
			);
		}

		return $colors_data;
	}

	public function getPaletteColorsByColorId($palette_color_id) {
		$palette_colors_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "palette_color pc LEFT JOIN " . DB_PREFIX . "palette_color_description pcd ON (pc.palette_color_id = pcd.palette_color_id) WHERE pcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pc.palette_color_id = '" . (int)$palette_color_id . "' GROUP BY pc.palette_color_id ORDER BY pcd.title ASC");

		foreach ($query->rows as $result) {
			$palette_colors_data[] = array(
				'palette_color_id' => $result['palette_color_id'],
				'color'            => $result['color'],
				'skin'             => $result['skin'],
				'title'            => $result['title']
			);
		}

		return $palette_colors_data;
	}

	public function getTotalPalettes() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "palette";

		$cache_id = 'palette.total';

		$total = $this->cache->get($cache_id);

		if (!$total || $total === null) {
			$query = $this->db->query($sql);

			$total = $query->row['total'];

			$this->cache->set($cache_id, $total);
		}

		return $total;
	}

	public function getColors() {
		$skins = array();

		$skins[] = array('skin' => 'white','color' => '#FFFFFF','title' => 'White');
		$skins[] = array('skin' => 'beige','color' => '#F5F5DC','title' => 'Beige');
		$skins[] = array('skin' => 'ash','color' => '#E5E5D0','title' => 'Ash');
		$skins[] = array('skin' => 'silver','color' => '#C2C2C2','title' => 'Silver');
		$skins[] = array('skin' => 'grey','color' => '#808080','title' => 'Grey');
		$skins[] = array('skin' => 'charcoal','color' => '#36454F','title' => 'Charcoal');
		$skins[] = array('skin' => 'black','color' => '#000000','title' => 'Black');
		$skins[] = array('skin' => 'pistachio','color' => '#93C572','title' => 'Pistachio');
		$skins[] = array('skin' => 'lime','color' => '#A4C400','title' => 'Lime');
		$skins[] = array('skin' => 'green','color' => '#60A917','title' => 'Green');
		$skins[] = array('skin' => 'emerald','color' => '#008A00','title' => 'Emerald');
		$skins[] = array('skin' => 'teal','color' => '#00ABA9','title' => 'Teal');
		$skins[] = array('skin' => 'cyan','color' => '#1BA1E2','title' => 'Cyan');
		$skins[] = array('skin' => 'cobalt','color' => '#0000FF','title' => 'Cobalt');
		$skins[] = array('skin' => 'navy','color' => '#000084','title' => 'Navy');
		$skins[] = array('skin' => 'indigo','color' => '#6A00FF','title' => 'Indigo');
		$skins[] = array('skin' => 'violet','color' => '#AA00FF','title' => 'Violet');
		$skins[] = array('skin' => 'pink','color' => '#F472D0','title' => 'Pink');
		$skins[] = array('skin' => 'magenta','color' => '#D80073','title' => 'Magenta');
		$skins[] = array('skin' => 'crimson','color' => '#A20025','title' => 'Crimson');
		$skins[] = array('skin' => 'red','color' => '#E51400','title' => 'Red');
		$skins[] = array('skin' => 'orange','color' => '#FA6800','title' => 'Orange');
		$skins[] = array('skin' => 'amber','color' => '#F0A30A','title' => 'Amber');
		$skins[] = array('skin' => 'citrus','color' => '#FFF033','title' => 'Citrus');
		$skins[] = array('skin' => 'yellow','color' => '#E3C800','title' => 'Yellow');
		$skins[] = array('skin' => 'brown','color' => '#825A2C','title' => 'Brown');
		$skins[] = array('skin' => 'olive','color' => '#6D8759','title' => 'Olive');
		$skins[] = array('skin' => 'steel','color' => '#647687','title' => 'Steel');
		$skins[] = array('skin' => 'mauve','color' => '#76608A','title' => 'Mauve');
		$skins[] = array('skin' => 'sienna','color' => '#B77733','title' => 'Sienna');
		$skins[] = array('skin' => 'mist','color' => '#F2F2F2','title' => 'Mist');
		$skins[] = array('skin' => 'clear','color' => 'transparent','title' => 'Clear');

		return $skins;
	}
}
