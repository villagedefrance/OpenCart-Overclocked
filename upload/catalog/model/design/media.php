<?php
class ModelDesignMedia extends Model {

	public function getMedia($media_id) {
		$query = $this->db->query("SELECT DISTINCT media FROM " . DB_PREFIX . "media WHERE media_id = '" . (int)$media_id . "' AND status = '1'");

		return $query->row['media'];
	}

	public function getCredit($media_id) {
		$query = $this->db->query("SELECT DISTINCT credit FROM " . DB_PREFIX . "media WHERE media_id = '" . (int)$media_id . "' AND status = '1'");

		if ($query->row['credit']) {
			return $query->row['credit'];
		} else {
			return false;
		}
	}

	public function getMediaType($media_id) {
		$type = 'video';

		$filename = $this->getFilename($media_id);

		$ext = utf8_substr(strrchr($filename, '.'), 1);

		$video = array('mp4','ogv','ogg','webm','m4v','wmv','flv');

		if (!in_array(strtolower($ext), $video)) {
			$type = 'audio';
		} else {
			$type = 'video';
		}

		return $type;
	}

	public function getMediaMimeType($media_id) {
		$mime_type = '';

		$filename = $this->getFilename($media_id);

		$ext = utf8_substr(strrchr($filename, '.'), 1);

		if (strtolower($ext) == 'mp3') {
			$mime_type = 'audio/mp3';
		}

		if (strtolower($ext) == 'mp4') {
			$mime_type = 'video/mp4';
		}

		if (strtolower($ext) == 'oga') {
			$mime_type = 'audio/ogg';
		}

		if (strtolower($ext) == 'ogv') {
			$mime_type = 'video/ogg';
		}

		if (strtolower($ext) == 'ogg') {
			$mime_type = 'video/ogg';
		}

		if (strtolower($ext) == 'webm') {
			$mime_type = 'video/webm';
		}

		if (strtolower($ext) == 'm4a') {
			$mime_type = 'audio/m4a';
		}

		if (strtolower($ext) == 'm4v') {
			$mime_type = 'video/m4v';
		}

		if (strtolower($ext) == 'wav') {
			$mime_type = 'audio/wav';
		}

		if (strtolower($ext) == 'wmv') {
			$mime_type = 'video/x-ms-wmv';
		}

		if (strtolower($ext) == 'wma') {
			$mime_type = 'audio/x-ms-wma';
		}

		if (strtolower($ext) == 'flv') {
			$mime_type = 'application/x-shockwave-flash';
		}

		return $mime_type;
	}

	protected function getFilename($media_id) {
		$query = $this->db->query("SELECT DISTINCT media AS filename FROM " . DB_PREFIX . "media WHERE media_id = '" . (int)$media_id . "'");

		return $query->row['filename'];
	}
}
