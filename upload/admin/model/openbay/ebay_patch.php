<?php
class ModelOpenbayEbayPatch extends Model {

	public function runPatch($manual = true) {
		$this->load->model('setting/setting');

		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ebay_listing` ADD INDEX(`product_id`)");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ebay_listing_pending` ADD INDEX(`product_id`)");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ebay_transaction` ADD INDEX(`product_id`, `order_id`, `smp_id`)");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ebay_order` ADD INDEX(`order_id`, `smp_id`, `parent_ebay_order_id`)");
		$this->db->query("ALTER TABLE `" . DB_PREFIX . "ebay_stock_reserve` ADD INDEX(`product_id`)");

		$this->openbay->ebay->loadSettings();

		return true;
	}
}
?>
