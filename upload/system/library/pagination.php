<?php
class Pagination {
	public $total = 0;
	public $page = 1;
	public $limit = 20;
	public $num_links = 10;
	public $url = '';
	public $text = 'Showing {start}-{end} of {total} Results ({pages} Pages)';
	public $text_first = '1';
	public $text_last = '{page}';
	public $text_next = '&rsaquo;';
	public $text_prev = '&lsaquo;';
	public $style_links = 'links';
	public $style_results = 'results';

	public function render() {
		$total = $this->total;

		if ($this->page < 1) {
			$page = 1;
		} else {
			$page = $this->page;
		}

		if (!(int)$this->limit) {
			$limit = 10;
		} else {
			$limit = $this->limit;
		}

		$num_links = $this->num_links;
		$num_pages = ceil($total / $limit);

		if ($num_links > $num_pages) {
			$num_links = $num_pages;
		}

		$this->url = str_replace('%7Bpage%7D', '{page}', $this->url);

		$output = '';

		if ($page > 1) {
			$output .= ' <a href="' . str_replace('{page}', $page - 1, $this->url) . '" title="Previous Page">' . $this->text_prev . '</a> ';

			$calc_first = floor(($this->num_links / 2) + 1);

			if (($page > $calc_first) && !($num_pages <= ($num_links + 1))) {
				$output .= '  <a href="' . str_replace('{page}', 1, $this->url) . '">' . $this->text_first . '</a> ';
			}
		}

		if ($num_pages > 1) {
			if ($num_pages <= $num_links) {
				$start = 1;
				$end = $num_pages;
			} else {
				$start = $page - floor($num_links / 2);
				$end = $page + floor($num_links / 2);

				if ($start < 1) {
					$end += abs($start) + 1;
					$start = 1;
				}

				if ($end > $num_pages) {
					$start -= ($end - $num_pages);
					$end = $num_pages;
				}
			}

			if ($start > 2) {
				$output .= ' ... ';
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($page == $i) {
					$output .= ' <b>' . $i . '</b> ';
				} else {
					$output .= ' <a href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
				}
			}

			if ($end < ($num_pages - 1)) {
				$output .= ' ... ';
			}
		}

   		if ($page < $num_pages) {
			$calc_last = $num_pages - floor($this->num_links / 2);

			if (($end < $num_pages) && ($page < $calc_last)) {
				$output .= ' <a href="' . str_replace('{page}', $num_pages, $this->url) . '">' . str_replace('{page}', $num_pages, $this->text_last) . '</a> ';
			}

			$output .= ' <a href="' . str_replace('{page}', $page + 1, $this->url) . '" title="Next Page">' . $this->text_next . '</a> ';
		}

		if ($total <= 1) {
			$this->text = '';
		}

		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);

		$replace = array(
			($total) ? (($page - 1) * $limit) + 1 : 0,
			((($page - 1) * $limit) > ($total - $limit)) ? $total : ((($page - 1) * $limit) + $limit),
			$total,
			$num_pages
		);

		return ($output ? '<div class="' . $this->style_links . '">' . $output . '</div>' : '') . '<div class="' . $this->style_results . '">' . str_replace($find, $replace, $this->text) . '</div>';
	}
}
