<?php
class ModelToolExportImportRaw extends Model {

	// Export SQL
	public function csvExportRaw($table) {
		$csv_delimiter = ";";
		$csv_enclosure = '"';
		$csv_terminated = "\n";

		$platform = $this->browser->getPlatform();

		if ($platform == 'Linux' || $platform == 'Debian' || $platform == 'GNU/Linux') {
			$csv_escaped = "\\";
		} else {
			$csv_escaped = '"';
		}

		$query = "SELECT * FROM `" . $table . "`";

		$result = $this->db->query($query);

		$columns = array_keys($result->row);

		$output = '';

		// Header
	 	$output .= '"' . $table . '.' . stripslashes(implode('"' . $csv_delimiter . '"' . $table . '.', $columns)) . "\"\n";

		// Data
		foreach ($result->rows as $row) {
			$schema_insert = '';

			$fields_cnt = count($row);

			foreach ($row as $k => $v) {
				if ($row[$k] == '0' || $row[$k] != '') {
					if ($csv_enclosure == '') {
						$schema_insert .= $row[$k];
					} else {
						$row[$k] = str_replace(array("\r","\n","\t"), "", $row[$k]);
						$row[$k] = html_entity_decode($row[$k], ENT_COMPAT, 'UTF-8');

						$schema_insert .= $csv_enclosure . str_replace($csv_enclosure, $csv_escaped . $csv_enclosure, $row[$k]) . $csv_enclosure;
					}
				} else {
					$schema_insert .= '';
				}

				if ($k < $fields_cnt - 1) {
					$schema_insert .= $csv_delimiter;
				}
			}

			$output .= $schema_insert;
			$output .= $csv_terminated;
		}

		return $output;
	}

	// Import SQL
	public function csvImportRaw($file) {
		ini_set('max_execution_time', 3600);

		$handle = fopen($file, 'r');

		if (!$handle) {
			die('Cannot open uploaded CSV file.');
		}

		// Get Table name and Columns from header row
		$columns = array();

		$data = fgetcsv($handle, 1000, ";");

		// If the first line is blank, try the next line
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
			exit('Cannot find SQL table.');
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

			foreach ($data as $key => $value) {
				$matches = '';

				$test = preg_match_all($pattern, $value, $matches);
				$test2 = preg_match_all($pattern2, $value, $matches);

				if ($test || $test2) {
					if ($value == date('Y-m-d H:i:s', strtotime($value))) {
						$new_value = date('Y-m-d H:i:s', strtotime($value));
						$data[$key] = "DATETIME('" . $this->db->escape($new_value) . "')";
					} elseif ($value == date('Y-m-d', strtotime($value))) {
						$new_value = date('Y-m-d', strtotime($value));
						$data[$key] = "DATE('" . $this->db->escape($new_value) . "')";
					} else {
						$value = date("Y-m-d", strtotime($value));
						$data[$key] = "DATE('" . $this->db->escape($value) . "')";
					}

				} else {
					$data[$key] = "'" . $this->db->escape($value) . "'";
				}
			}

			// Try to prevent last missing columns sql error
			if (count($data) < count($columns)) {
				while (count($data) < count($columns)) {
					$key++;
					$data[$key] = "''";
				}
			}

			$columns = $this->checkReserved($columns);

			// Handle line in one by one query
			$sql_query_array[] = "INSERT INTO `" . $table . "` (" . implode(',', $columns) . ") VALUES (" . htmlentities(implode(",", $data)) . ")";
		}

		fclose($handle);

		if (count($sql_query_array)) {
			$this->db->query("TRUNCATE TABLE `" . $table . "`");

			foreach ($sql_query_array as $sql_query) {
				$this->db->query($sql_query);
			}
		}

		return $row_count;
	}

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

	// Check SQL reserved keywords
	public function checkReserved($columns = array()) {
		$checked_columns = array();

		$reserved = array (
			'ACCESSIBLE', 'ACTION', 'ADD', 'AFTER', 'AGAINST', 'AGGREGATE', 'ALGORITHM', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'ANY', 'AS', 'ASC',	'ASCII', 'ASENSITIVE', 'AT', 'AUTHORS',
			'AUTOEXTEND_SIZE', 'AUTO_INCREMENT', 'AVG', 'AVG_ROW_LENGTH', 'BACKUP', 'BEFORE', 'BEGIN', 'BETWEEN', 'BIGINT', 'BINARY', 'BINLOG', 'BIT', 'BLOB', 'BLOCK', 'BOOL',
			'BOOLEAN', 'BOTH', 'BTREE', 'BY', 'BYTE', 'CACHE', 'CALL', 'CASCADE', 'CASCADED', 'CASE', 'CATALOG_NAME', 'CHAIN', 'CHANGE', 'CHANGED', 'CHAR', 'CHARACTER', 'CHARSET',
			'CHECK', 'CHECKSUM', 'CIPHER', 'CLASS_ORIGIN', 'CLIENT', 'CLOSE', 'COALESCE', 'CODE', 'COLLATE', 'COLLATION', 'COLUMN', 'COLUMNS', 'COLUMN_NAME', 'COMMENT',
			'COMMIT', 'COMMITTED', 'COMPACT', 'COMPLETION', 'COMPRESSED', 'CONCURRENT', 'CONDITION', 'CONNECTION', 'CONSISTENT', 'CONSTRAINT', 'CONSTRAINT_CATALOG',
			'CONSTRAINT_NAME', 'CONSTRAINT_SCHEMA', 'CONTAINS', 'CONTEXT', 'CONTINUE', 'CONTRIBUTORS', 'CONVERT', 'CPU', 'CREATE', 'CROSS', 'CUBE', 'CURRENT_DATE',
			'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'CURSOR_NAME', 'DATA', 'DATABASE', 'DATABASES', 'DATAFILE', 'DATE', 'DATETIME', 'DAY', 'DAY_HOUR',
			'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEALLOCATE', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DEFINER', 'DELAYED', 'DELAY_KEY_WRITE', 'DELETE', 'DESC',
			'DESCRIBE', 'DES_KEY_FILE', 'DETERMINISTIC', 'DIRECTORY', 'DISABLE', 'DISCARD', 'DISK', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DO', 'DOUBLE', 'DROP', 'DUAL', 'DUMPFILE',
			'DUPLICATE', 'DYNAMIC', 'EACH', 'ELSE', 'ELSEIF', 'ENABLE', 'ENCLOSED', 'END', 'ENDS', 'ENGINE', 'ENGINES', 'ENUM', 'ERROR', 'ERRORS', 'ESCAPE', 'ESCAPED', 'EVENT', 'EVENTS',
			'EVERY', 'EXECUTE', 'EXISTS', 'EXIT', 'EXPANSION', 'EXPLAIN', 'EXTENDED', 'EXTENT_SIZE', 'FALSE', 'FAST', 'FAULTS', 'FETCH', 'FIELDS', 'FILE', 'FIRST', 'FIXED', 'FLOAT',
			'FLOAT4', 'FLOAT8', 'FLUSH', 'FOR', 'FORCE', 'FOREIGN', 'FOUND', 'FRAC_SECOND', 'FROM', 'FULL', 'FULLTEXT', 'FUNCTION 	GENERAL', 'GEOMETRY', 'GEOMETRYCOLLECTION',
			'GET_FORMAT', 'GLOBAL', 'GRANT', 'GRANTS', 'GROUP', 'HANDLER', 'HASH', 'HAVING', 'HELP', 'HIGH_PRIORITY', 'HOST', 'HOSTS', 'HOUR', 'HOUR_MICROSECOND',
			'HOUR_MINUTE', 'HOUR_SECOND', 'IDENTIFIED', 'IF', 'IGNORE', 'IGNORE_SERVER_IDS', 'IMPORT', 'IN', 'INDEX', 'INDEXES', 'INFILE', 'INITIAL_SIZE', 'INNER', 'INNOBASE', 'INNODB',
			'INOUT', 'INSENSITIVE', 'INSERT', 'INSERT_METHOD', 'INSTALL', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'INVOKER', 'IO', 'IO_THREAD', 'IPC',
			'IS', 'ISOLATION', 'ISSUER', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KEY_BLOCK_SIZE', 'KILL', 'LANGUAGE', 'LAST', 'LEADING', 'LEAVE', 'LEAVES', 'LEFT', 'LESS', 'LEVEL', 'LIKE', 'LIMIT',
			'LINEAR', 'LINES', 'LINESTRING', 'LIST', 'LOAD', 'LOCAL', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LOCKS', 'LOGFILE', 'LOGS', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP',
			'LOW_PRIORITY', 'MASTER', 'MASTER_CONNECT_RETRY', 'MASTER_HEARTBEAT_PERIOD', 'MASTER_HOST', 'MASTER_LOG_FILE', 'MASTER_LOG_POS', 'MASTER_PASSWORD',
			'MASTER_PORT', 'MASTER_SERVER_ID', 'MASTER_SSL', 'MASTER_SSL_CA', 'MASTER_SSL_CAPATH', 'MASTER_SSL_CERT', 'MASTER_SSL_CIPHER', 'MASTER_SSL_KEY',
			'MASTER_SSL_VERIFY_SERVER_CERT', 'MASTER_USER', 'MATCH', 'MAXVALUE', 'MAX_CONNECTIONS_PER_HOUR', 'MAX_QUERIES_PER_HOUR', 'MAX_ROWS', 'MAX_SIZE',
			'MAX_UPDATES_PER_HOUR', 'MAX_USER_CONNECTIONS', 'MEDIUM', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MEMORY', 'MERGE', 'MESSAGE_TEXT', 'MICROSECOND',
			'MIDDLEINT', 'MIGRATE', 'MINUTE', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MIN_ROWS', 'MOD', 'MODE', 'MODIFIES', 'MODIFY', 'MONTH', 'MULTILINESTRING',
			'MULTIPOINT', 'MULTIPOLYGON', 'MUTEX', 'MYSQL_ERRNO', 'NAME', 'NAMES', 'NATIONAL', 'NATURAL', 'NCHAR', 'NDB', 'NDBCLUSTER', 'NEW', 'NEXT', 'NO', 'NODEGROUP',
			'NONE', 'NOT', 'NO_WAIT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'NVARCHAR', 'OFFSET', 'OLD_PASSWORD', 'ON', 'ONE', 'ONE_SHOT', 'OPEN', 'OPTIMIZE', 'OPTION',
			'OPTIONALLY', 'OPTIONS', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'OWNER', 'PACK_KEYS', 'PAGE', 'PARSER', 'PARTIAL', 'PARTITION', 'PARTITIONING', 'PARTITIONS',
			'PASSWORD', 'PHASE', 'PLUGIN', 'PLUGINS', 'POINT', 'POLYGON', 'PORT', 'PRECISION', 'PREPARE', 'PRESERVE', 'PREV', 'PRIMARY', 'PRIVILEGES', 'PROCEDURE', 'PROCESSLIST',
			'PROFILE', 'PROFILES', 'PROXY', 'PURGE', 'QUARTER', 'QUERY', 'QUICK', 'RANGE', 'READ', 'READS', 'READ_ONLY', 'READ_WRITE', 'REAL', 'REBUILD', 'RECOVER', 'REDOFILE',
			'REDO_BUFFER_SIZE', 'REDUNDANT', 'REFERENCES', 'REGEXP', 'RELAY', 'RELAYLOG', 'RELAY_LOG_FILE', 'RELAY_LOG_POS', 'RELAY_THREAD', 'RELEASE', 'RELOAD', 'REMOVE',
			'RENAME', 'REORGANIZE', 'REPAIR', 'REPEAT', 'REPEATABLE', 'REPLACE', 'REPLICATION', 'REQUIRE', 'RESET', 'RESIGNAL', 'RESTORE', 'RESTRICT', 'RESUME', 'RETURN', 'RETURNS',
			'REVOKE', 'RIGHT', 'RLIKE', 'ROLLBACK', 'ROLLUP', 'ROUTINE', 'ROW 	ROWS', 'ROW_FORMAT', 'RTREE', 'SAVEPOINT', 'SCHEDULE', 'SCHEMA', 'SCHEMAS', 'SCHEMA_NAME',
			'SECOND', 'SECOND_MICROSECOND', 'SECURITY', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SERIAL', 'SERIALIZABLE', 'SERVER', 'SESSION', 'SET', 'SHARE', 'SHOW', 'SHUTDOWN',
			'SIGNAL', 'SIGNED', 'SIMPLE', 'SLAVE', 'SLOW', 'SMALLINT', 'SNAPSHOT', 'SOCKET', 'SOME', 'SONAME', 'SOUNDS', 'SOURCE', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION',
			'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_BUFFER_RESULT', 'SQL_CACHE', 'SQL_CALC_FOUND_ROWS', 'SQL_NO_CACHE', 'SQL_SMALL_RESULT', 'SQL_THREAD',
			'SQL_TSI_DAY', 'SQL_TSI_FRAC_SECOND', 'SQL_TSI_HOUR', 'SQL_TSI_MINUTE', 'SQL_TSI_MONTH', 'SQL_TSI_QUARTER', 'SQL_TSI_SECOND', 'SQL_TSI_WEEK', 'SQL_TSI_YEAR',
			'SSL', 'START', 'STARTING', 'STARTS', 'STATUS', 'STOP', 'STORAGE', 'STRAIGHT_JOIN', 'STRING', 'SUBCLASS_ORIGIN', 'SUBJECT', 'SUBPARTITION', 'SUBPARTITIONS', 'SUPER',
			'SUSPEND', 'SWAPS', 'SWITCHES', 'TABLE', 'TABLES', 'TABLESPACE', 'TABLE_CHECKSUM', 'TABLE_NAME', 'TEMPORARY', 'TEMPTABLE', 'TERMINATED', 'TEXT', 'THAN', 'THEN', 'TIME',
			'TIMESTAMP', 'TIMESTAMPADD', 'TIMESTAMPDIFF', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRANSACTION', 'TRIGGER', 'TRIGGERS', 'TRUE', 'TRUNCATE', 'TYPE',
			'TYPES', 'UNCOMMITTED', 'UNDEFINED', 'UNDO', 'UNDOFILE', 'UNDO_BUFFER_SIZE', 'UNICODE', 'UNINSTALL', 'UNION', 'UNIQUE', 'UNKNOWN', 'UNLOCK', 'UNSIGNED', 'UNTIL',
			'UPDATE', 'UPGRADE', 'USAGE', 'USE', 'USER', 'USER_RESOURCES', 'USE_FRM', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUE', 'VALUES', 'VARBINARY', 'VARCHAR',
			'VARCHARACTER', 'VARIABLES', 'VARYING', 'VIEW', 'WAIT', 'WARNINGS', 'WEEK', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WORK', 'WRAPPER', 'WRITE', 'X509', 'XA', 'XML', 'XOR', 'YEAR',
			'YEAR_MONTH', 'ZEROFILL'
		);

		foreach ($columns as $column) {
			$upcase_column = strtoupper($column);

			if (in_array($upcase_column, $reserved)) {
				$checked_columns[] = '`' . $column . '`';
			} else {
				$checked_columns[] = $column;
			}
		}

		return $checked_columns;
	}
}
