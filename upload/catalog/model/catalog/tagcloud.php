<?php
class ModelCatalogTagCloud extends Model {

	public function getRandomTags($limit, $min_font_size, $max_font_size, $font_weight, $random) {
		$names = array();
		$totals = array();
		$tags = array();

		$tagcloud = false;

		$query = $this->db->query("SELECT DISTINCT ptg.tag AS tag FROM " . DB_PREFIX . "product_tag ptg LEFT JOIN " . DB_PREFIX . "product p ON (ptg.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (ptg.product_id = p2s.product_id) WHERE ptg.language_id=" . (int)$this->config->get('config_language_id') . " AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p.status = '1' LIMIT 0," . (int)$limit);

		if (count($query->rows) > 0) {
			foreach ($query->rows as $row) {
				$tagcount = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_tag WHERE tag= '" . $row['tag'] . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

				$names[] = trim(str_replace(',', ' ', (string)$row['tag']));
				$totals[] = $tagcount->num_rows;
			}

			$tags = array_combine($names, $totals);

			$tagcloud = $this->generateTagCloud($tags, true, $min_font_size, $max_font_size, $font_weight, $random);
		}

		return $tagcloud;
	}

	protected function generateTagCloud($tags, $resize = true, $min_font_size, $max_font_size, $font_weight, $random) {
		if ($resize == true) {
			arsort($tags);

			$max_qty = max(array_values($tags));
			$min_qty = min(array_values($tags));

			$spread = $max_qty - $min_qty;

			if ($spread == 0) {
				$spread = 1;
			}

			$step = ((int)$max_font_size - (int)$min_font_size) / ($spread);

			$cloud = array();

			foreach ($tags as $key => $value) {
				if ($random) {
					$size = mt_rand((int)$min_font_size, (int)$max_font_size);
				} else {
					$size = round((int)$min_font_size + (($value - $min_qty) * $step));
				}

				$key = trim(str_replace('&', '&amp;', (string)$key));

				$cloud[] = '<a href="' . $this->url->link('product/search', 'search=' . $key . '&tag=' . $key, 'SSL') . '" style="text-decoration:none; font-size:' . $size . 'px; font-weight:' . $font_weight . ';" title="">' . $key . '</a> ';
			}
		}

		$tagcloud = '';

		shuffle($cloud);

		for ($x = 0; $x < count($cloud); $x++) {
			$tagcloud .= $cloud[$x];
		}

		return $tagcloud;
	}
}
