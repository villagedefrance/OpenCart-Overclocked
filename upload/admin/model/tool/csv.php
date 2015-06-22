<?php
class ModelToolCSV extends Model {

	public function getTables() {
		$table_data = array();

		$query = $this->db->query("SHOW TABLES FROM `" . DB_DATABASE . "`");

		foreach ($query->rows as $result) {
			if (utf8_substr($result['Tables_in_' . DB_DATABASE], 0, strlen(DB_PREFIX)) == DB_PREFIX) {
				if (isset($result['Tables_in_' . DB_DATABASE])) {
					$table_data[] = $result['Tables_in_' . DB_DATABASE];
				}
			}
		}

		return $table_data;
	}

	public function csvExport($table) {
		$output = '';

		$query = "SELECT * FROM `" . $table . "`";

	    $result = $this->db->query($query);

	    $columns = array_keys($result->row);

		$csv_terminated = "\n";
	    $csv_separator = ";";
	    $csv_enclosed = '"';
	    $csv_escaped = "\\"; // Linux
		$csv_escaped = '"';

		// Header Row
	 	$output .= '"' . $table . '.' . stripslashes(implode('"' . $csv_separator . '"' . $table . '.', $columns)) . "\"\n"; 

	 	// Data Rows
	    foreach ($result->rows as $row) {
			$schema_insert = '';

			$fields_cnt = count($row);

			foreach ($row as $k => $v) {
		        if ($row[$k] == '0' || $row[$k] != '') {
		            if ($csv_enclosed == '') {
		                $schema_insert .= $row[$k];
		            } else {
		            	$row[$k] = str_replace(array("\r","\n","\t"), "", $row[$k]);
		            	$row[$k] = html_entity_decode($row[$k], ENT_COMPAT, "utf-8");

		                $schema_insert .= $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$k]) . $csv_enclosed;
		            }
		        } else {
		            $schema_insert .= '';
		        }

		        if ($k < $fields_cnt - 1) {
		            $schema_insert .= $csv_separator;
		        }
		    }

		    $output .= $schema_insert;
		    $output .= $csv_terminated;
	    }

	    return $output;
	}

	public function csvImport($file) {
		ini_set('max_execution_time', 3600);

	    $handle = fopen($file, 'r');

	    if (!$handle) {
			die('Cannot open uploaded file.');
		}

		// Get Table name and Columns from header row
		$columns = array();

		$data = fgetcsv($handle, 1000, ";");

		// If the first line is blank, try second line
		if (!$data[0]) {
			$data = fgetcsv($handle, 1000, ";");
		}

		foreach ($data as $d) {
			if (strpos($d, '.') !== false) {
				$tmp = explode('.', $d);
				$table = $tmp[0];
				$columns[] = $tmp[1];
			} else {
				$columns[] = $d;
			}
		}

		if (!$table) {
			exit('Could not retrieve table.');
		}

	    $row_count = 0;

        $sql_query_array = array();

	    // Read the file as csv
	    while (($data = fgetcsv($handle, 10000, ";")) !== false) {
			if (count($data) > count($columns)) {
				$data = array_slice($data, 0, count($columns));
			}

	        $row_count++;

	        $pattern = '/\A\d{1,2}\/\d{1,2}\/\d{4}/';
	        $pattern2 = '/\A\d{1,2}\-\d{1,2}\-\d{4}/';

	        foreach ($data as $key=>$value) {
	        	$matches = '';

	        	$test = preg_match_all($pattern, $value, $matches);
	        	$test2 = preg_match_all($pattern2, $value, $matches);

	        	if ($test || $test2) {
					$value = date('Y-m-d', strtotime($value));

					$data[$key] = "DATE('" . $this->db->escape($value) . "')";
	        	} else {
	            	$data[$key] = "'" . $this->db->escape($value) . "'";
				}
	        }

            // Try to assure that last missing columns dont give sql error
            if (count($data) < count($columns)) {
                while (count($data) < count($columns)) {
                    $key++;
                    $data[$key] = "''";
                }
            }

            // Handle line in one by one query
            $sql_query_array[] = "INSERT INTO " . $table . " (" . implode(',', $columns) . ") VALUES (" . htmlentities(implode(",", $data)) . ")";
	    }

	    fclose($handle);

        if (count($sql_query_array)) {
			$this->db->query("TRUNCATE TABLE " . $table);

            foreach($sql_query_array as $sql_query) {
                $this->db->query($sql_query);
            }
		}

	    return $row_count;
	}

	function validDate($date) {
		$date = strtr($date, '/', '-');

		$datearr = explode('-', $date);

		if (count($datearr) == 3) {
			list ($d, $m, $y) = $datearr;

			if (checkdate($m, $d, $y) && strtotime("$y-$m-$d") && preg_match('#\b\d{2}[/-]\d{2}[/-]\d{4}\b#', "$d-$m-$y")) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}

		return false;
	}
}
?>