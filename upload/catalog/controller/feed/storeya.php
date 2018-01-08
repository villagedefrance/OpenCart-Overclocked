<?php
class ControllerFeedStoreya extends Controller {

	public function index() {
		$output = '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
		$output .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">' . "\n";
		$output .= '<channel>'. "\n";
		$output .= '<title>' . $this->config->get('config_name') . '</title>' . "\n";
		$output .= '<description>' . $this->config->get('config_meta_description') . '</description>' . "\n";
		$output .= '<link>' . HTTP_SERVER . '</link>' . "\n";
		$output .= '<storeya_plugin_version> 2.2 </storeya_plugin_version>' . "\n";
		$output .= '<img src="http://www.storeya.com/Widgets/Admin?p=OpenCartFeed"/>'. "\n";

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$data = array();

		if ($this->config->get('fromcount')) {
			$data['start']=$this->config->get('fromcount');
		}

		 $this->config->get('tocount');

		if ($this->config->get('tocount')) {
			$data['limit']=$this->config->get('tocount');
		}

		if (isset($this->request->get['currency'])) {
			$currency=$this->request->get['currency'];
		} elseif ($this->config->get('currency')) {
			$currency= $this->config->get('currency');
		}

		if (isset($this->request->get['language']) && ($this->request->get['language'] != $this->session->data['language'])) {
			$this->session->data['language'] = $this->request->get['language'];
			$this->redirect($_SERVER['REQUEST_URI']);
		} elseif (($this->config->get('language') != $this->session->data['language']) && !isset($this->request->get['language'])) {
			$this->session->data['language']=$this->config->get('language');
			$this->redirect($_SERVER['REQUEST_URI']);
		}

		$products = $this->model_catalog_product->getProducts($data);

		foreach ($products as $product) {
			if ($product['description']) {
				$output .= '<item>'. "\n";
				$output .= '<title>' . $this->stripHtmlTags($this->replaceProblemCharacters($this->encodeIfNeeded($product['name']))) . '</title>' . "\n";
				$output .= '<link>' . $this->url->link('product/product', 'product_id=' . $product['product_id'], 'SSL') . '</link>' . "\n";
				$output .= '<description>' . $this->stripHtmlTags($this->replaceProblemCharacters($this->encodeIfNeeded(html_entity_decode($product['description'])))) . '</description>' . "\n";
				$output .= '<g:brand>' . html_entity_decode($product['manufacturer'], ENT_QUOTES, 'UTF-8') . '</g:brand>' . "\n";
				$output .= '<g:condition>new</g:condition>' . "\n";
				$output .= '<g:id>' . $product['product_id'] . '</g:id>'. "\n";

				if ($product['image']) {
					$output .= '<g:image_link>' . $this->model_tool_image->resize($product['image'], 500, 500) . '</g:image_link>' . "\n";
				} else {
					$output .= '<g:image_link>' . $this->model_tool_image->resize('no_image.jpg', 500, 500) . '</g:image_link>' . "\n";
				}

				$additional_images = $this->model_catalog_product->getProductImages($product['product_id']);

				if ($additional_images) {
					foreach ($additional_images as $additional_image) {
						$output .= '<g:additional_image_link>' . $this->model_tool_image->resize($additional_image['image'], 500, 500) . '</g:additional_image_link>' . "\n";
					}
				}

				$output .= '<g:mpn>' . $product['model'] . '</g:mpn>'. "\n";

				if ((float)$product['special']) {
					$output .= '<g:sale_price>' . $this->currency->format($product['special'], $currency, false, false) . ' ' . $currency . '</g:sale_price>' . "\n";
					$output .= '<g:tax_calc_for_sale_price>' . $this->currency->format($this->tax->getTax($product['special'], $product['tax_class_id']), $currency, false, false) . '</g:tax_calc_for_sale_price>' . "\n";
					$output .= '<g:taxed_sale_price>' . $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency, false, false) . '</g:taxed_sale_price>' . "\n";
				}

				$output .= '<g:price>' . $this->currency->format($product['price'], $currency, false, false) . ' ' . $currency . '</g:price>' . "\n";
				$output .= '<g:tax_calc_for_price>' . $this->currency->format($this->tax->getTax($product['price'], $product['tax_class_id']), $currency, false, false) . '</g:tax_calc_for_price>' . "\n";
				$output .= '<g:taxed_price>' . $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency, false, false) . '</g:taxed_price>' . "\n";

				$categories = $this->model_catalog_product->getCategories($product['product_id']);

				foreach ($categories as $category) {
					$path = $this->getPath($category['category_id']);

					if ($path) {
						$string = '';

						foreach (explode('_', $path) as $path_id) {
							$category_info = $this->model_catalog_category->getCategory($path_id);

							if ($category_info) {
								if (!$string) {
									$string = $category_info['name'];
								} else {
									$string .= ' &gt; ' . $category_info['name'];
								}
							}
						}

						$output .= '<g:product_type>' . $string . '</g:product_type>' . "\n";
					}
				}

				$output .= '<g:quantity>' . $product['quantity'] . '</g:quantity>' . "\n";
				$output .= '<g:upc>' . $product['upc'] . '</g:upc>'. "\n";
				$output .= '<g:weight>' . $this->weight->format($product['weight'], $product['weight_class_id']) . '</g:weight>' . "\n";
				$output .= '<g:availability>' . ($product['quantity'] ? 'in stock' : 'out of stock') . '</g:availability>' . "\n";
				$output .= '</item>' . "\n";
			}
		}

		$output .= '</channel>' . "\n";
		$output .= '</rss>' . "\n";

		$this->response->addHeader('Content-Type: application/rss+xml; charset=UTF-8');
		$this->response->setOutput($output);
	}

	protected function getPath($parent_id, $current_path = '') {
		$category_info = $this->model_catalog_category->getCategory($parent_id);

		if ($category_info) {
			if (!$current_path) {
				$new_path = $category_info['category_id'];
			} else {
				$new_path = $category_info['category_id'] . '_' . $current_path;
			}

			$path = $this->getPath($category_info['parent_id'], $new_path);

			if ($path) {
				return $path;
			} else {
				return $new_path;
			}
		}
	}

	protected function encodeIfNeeded($text) {
		$text = iconv(mb_detect_encoding($text, mb_detect_order(), true), "UTF-8", $text);
		return $text;
	}

	protected function replaceProblemCharacters($text) {
		$formattags = array("&");
		$replacevals = array("&#38;");

		$text = str_replace($formattags, $replacevals, $text);

		$in[] = '@&(amp|#038);@i'; $out[] = '&';
		$in[] = '@&(#036);@i'; $out[] = '$';
		$in[] = '@&(quot);@i'; $out[] = '"';
		$in[] = '@&(#039);@i'; $out[] = '\'';
		$in[] = '@&(nbsp|#160);@i'; $out[] = ' ';
		$in[] = '@&(hellip|#8230);@i'; $out[] = '...';
		$in[] = '@&(copy|#169);@i'; $out[] = '(c)';
		$in[] = '@&(trade|#129);@i'; $out[] = '(tm)';
		$in[] = '@&(lt|#60);@i'; $out[] = '<';
		$in[] = '@&(gt|#62);@i'; $out[] = '>';
		$in[] = '@&(laquo);@i'; $out[] = '«';
		$in[] = '@&(raquo);@i'; $out[] = '»';
		$in[] = '@&(deg);@i'; $out[] = '°';
		$in[] = '@&(mdash);@i'; $out[] = '—';
		$in[] = '@&(reg);@i'; $out[] = '®';
		$in[] = '@&(–);@i'; $out[] = '-';

		$text = preg_replace($in, $out, $text);

		return $text;
	}

	protected function stripHtmlTags($str) {
		// $document should contain an HTML document.
		// This will remove HTML tags, javascript sections and white spaces.
		// It will also convert some common HTML entities to their text equivalent.

		$search = array ("'<script[^>]*?>.*?</script>'si",
			 "'<[/!]*?[^<>]*?>'si",
			 "'&(quot|#34);'i",
			 "'&(lt|#60);'i",
			 "'&(gt|#62);'i",
			 "'&(nbsp|#160);'i",
			 "'&(iexcl|#161);'i",
			 "'&(cent|#162);'i",
			 "'&(pound|#163);'i",
			 "'&(copy|#169);'i",
			 "'&#(d+);'e"
		);

		$replace = array ("", "", "\"", "&", "<", ">", " ", chr(160), chr(161), chr(162), chr(163), chr(169), "chr(\1)");

		return preg_replace($search, $replace, $str);
	}
}
