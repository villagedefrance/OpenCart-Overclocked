<?php
class ModelToolImportExportCustomer extends Model {

	// Get customers
	public function getCustomers($language_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "address a ON (c.customer_id = a.customer_id) LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) WHERE cgd.language_id = '" . (int)$language_id . "' ORDER BY c.lastname, c.firstname ASC");

		if (!empty($query)) {
			return $query->rows;
		} else {
			return 0;
		}
	}

	// Export Customers
	public function download() {
		$file = DIR_LOGS . 'customer.xlsx';

		clearstatcache();

		if (file_exists($file) && is_file($file)) {
			if (!headers_sent()) {
				$filename = 'customer_' . date('Y-m-d', time()) . '.xlsx';

				if (filesize($file) > 0) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename=' . $filename);
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));

					readfile($file, 'rb');
					exit();
				}

			} else {
				exit('Error: Headers already sent out!');
			}

		} else {
			$this->redirect($this->url->link('tool/import_export_customer', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}

	// Mime Types
	public function mime_type($file) {
		$mime_type = array(
			'csv'	=> 'text/csv',
			'ods'	=> 'application/vnd.oasis.opendocument.spreadsheet',
			'xls'	=> 'application/vnd.ms-excel',
			'xlsx'	=> 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
		);

		$extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

		if (isset($extension)) {
			return $extension;
		} else {
			exit('Error: Unknown file type!');
		}
	}
}
?>