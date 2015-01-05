<?php
class ControllerCommonFileManagerFull extends Controller {
	private $error = array();
	private $_name = 'filemanager_full';

	public function index() {
		$this->language->load('common/' . $this->_name);

		$this->document->setTitle($this->language->get('heading_title'));

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('text_home'),
			'href'		=> $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'		=> $this->language->get('heading_title'),
			'href'		=> $this->url->link('common/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_folder'] = $this->language->get('entry_folder');
		$this->data['entry_move'] = $this->language->get('entry_move');
		$this->data['entry_copy'] = $this->language->get('entry_copy');
		$this->data['entry_rename'] = $this->language->get('entry_rename');

		$this->data['button_exit'] = $this->language->get('button_exit');
		$this->data['button_folder'] = $this->language->get('button_folder');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_move'] = $this->language->get('button_move');
		$this->data['button_copy'] = $this->language->get('button_copy');
		$this->data['button_rename'] = $this->language->get('button_rename');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_uploads'] = $this->language->get('button_uploads');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_submit'] = $this->language->get('button_submit');
		$this->data['button_expand'] = $this->language->get('button_expand');
		$this->data['button_collapse'] = $this->language->get('button_collapse');
		$this->data['button_view_text'] = $this->language->get('button_view_text');
		$this->data['button_view_list'] = $this->language->get('button_view_list');
		$this->data['button_view_thumb'] = $this->language->get('button_view_thumb');

		$this->data['text_loading'] = $this->language->get('text_loading');
		$this->data['text_no_file_found'] = $this->language->get('text_no_file_found');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_folder_delete'] = $this->language->get('text_folder_delete');
		$this->data['text_folder_action'] = $this->language->get('text_folder_action');
		$this->data['text_folder_content'] = $this->language->get('text_folder_content');
		$this->data['text_file_delete'] = $this->language->get('text_file_delete');
		$this->data['text_file_action'] = $this->language->get('text_file_action');
		$this->data['text_no_image']	= $this->language->get('text_no_image');
		$this->data['text_select_image'] = $this->language->get('text_select_image');
		$this->data['text_update_image'] = $this->language->get('text_update_image');
		$this->data['text_yes_execute']= $this->language->get('text_yes_execute');
		$this->data['text_yes_delete'] = $this->language->get('text_yes_delete');
		$this->data['text_no_cancel'] = $this->language->get('text_no_cancel');
		$this->data['text_upload_plus'] = $this->language->get('text_upload_plus');
		$this->data['text_no_selection'] = $this->language->get('text_no_selection');
		$this->data['text_allowed'] = $this->language->get('text_allowed');

		$this->data['error_directory'] = $this->language->get('error_directory');

		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];

		$this->data['directory'] = HTTP_CATALOG . 'image/data/';

		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->get['field'])) {
			$this->data['field'] = $this->request->get['field'];
		} else {
			$this->data['field'] = '';
		}

		if (isset($this->request->get['CKEditorFuncNum'])) {
			$this->data['fckeditor'] = $this->request->get['CKEditorFuncNum'];
		} else {
			$this->data['fckeditor'] = false;
		}

		$this->template = 'common/' . $this->_name . '.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function image() {
		$this->load->model('tool/image');

		$this->data['token'] = $this->session->data['token'];

		$ext = utf8_substr(strrchr($this->request->get['image'], '.'), 1);

        if (strtolower($ext) == 'pdf') {
            $this->request->get['image'] = 'pdf.png';
        }

		if (strtolower($ext) == 'flv') {
            $this->request->get['image'] = 'flv.png';
        }

		if (strtolower($ext) == 'swf') {
            $this->request->get['image'] = 'swf.png';
        }

		if (strtolower($ext) == 'zip') {
            $this->request->get['image'] = 'zip.png';
        }

		if (strtolower($ext) == 'rar') {
            $this->request->get['image'] = 'rar.png';
        }

		if (isset($this->request->get['image'])) {
			$this->response->setOutput($this->model_tool_image->resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), 100, 100));
		}
	}

	public function directory() {
		$json = array();

		if (isset($this->request->post['directory'])) {
			$directories = glob(rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']), '/') . '/*', GLOB_ONLYDIR);

			if ($directories) {
				$i = 0;

				foreach ($directories as $directory) {
					$json[$i]['data'] = basename($directory);
					$json[$i]['attributes']['directory'] = utf8_substr($directory, strlen(DIR_IMAGE . 'data/'));

					$children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);

					if ($children) {
						$json[$i]['children'] = ' ';
					}

					$i++;
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function files() {
		$this->data['token'] = $this->session->data['token'];

		$json = array();

		if (!empty($this->request->post['directory'])) {
			$directory = DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']);
		} else {
			$directory = DIR_IMAGE . 'data/';
		}

		$allowed = array(
			'jpg',
			'jpeg',
			'png',
			'gif',
			'zip',
			'rar',
			'pdf',
			'swf',
			'flv'
		);

		$files = glob(rtrim($directory, '/') . '/*');

		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					$ext = utf8_substr(strrchr($file, '.'), 1);
				} else {
					$ext = '';
				}

				if (in_array(strtolower($ext), $allowed)) {
					$size = filesize($file);

					$i = 0;

					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);

					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}

					$json[] = array(
						'filename' 	=> basename($file),
						'file'     		=> utf8_substr($file, utf8_strlen(DIR_IMAGE . 'data/')),
						'size'     		=> round(utf8_substr($size, 0, utf8_strpos($size, '.') + 4), 2) . $suffix[$i]
					);
				}
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function create() {
		$this->language->load('common/' . $this->_name);

		$json = array();

		if (isset($this->request->post['directory'])) {
			if (isset($this->request->post['name']) || $this->request->post['name']) {
				$directory = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');

				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}

				if (file_exists($directory . '/' . str_replace('../', '', $this->request->post['name']))) {
					$json['error'] = $this->language->get('error_exists');
				}

			} else {
				$json['error'] = $this->language->get('error_name');
			}

		} else {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$this->user->hasPermission('modify', 'common/' . $this->_name)) {
      		$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error'])) {
			mkdir($directory . '/' . str_replace('../', '', $this->request->post['name']), 0777);

			$json['success'] = $this->language->get('text_create');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function delete() {
		$this->language->load('common/' . $this->_name);

		$json = array();

		if (isset($this->request->post['path'])) {
			$path = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($path)) {
				$json['error'] = $this->language->get('error_select');
			}

			if ($path == rtrim(DIR_IMAGE . 'data/', '/')) {
				$json['error'] = $this->language->get('error_delete');
			}

		} else {
			$json['error'] = $this->language->get('error_select');
		}

		if (!$this->user->hasPermission('modify', 'common/' . $this->_name)) {
      		$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}

			$json['success'] = $this->language->get('text_delete');
		}

		$this->response->setOutput(json_encode($json));
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}

		if (!$handle) {
			return false;
		}

		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}

		closedir($handle);

		rmdir($directory);

		return true;
	}

	public function move() {
		$this->language->load('common/' . $this->_name);

		$json = array();

		if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
			$from = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['from'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($from)) {
				$json['error'] = $this->language->get('error_missing');
			}

			if ($from == DIR_IMAGE . 'data') {
				$json['error'] = $this->language->get('error_default');
			}

			$to = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['to'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($to)) {
				$json['error'] = $this->language->get('error_move');
			}

			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = $this->language->get('error_exists');
			}

		} else {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$this->user->hasPermission('modify', 'common/' . $this->_name)) {
      		$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));

			$json['success'] = $this->language->get('text_move');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function copy() {
		$this->language->load('common/' . $this->_name);

		$json = array();

		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}

			$old_name = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
				$json['error'] = $this->language->get('error_copy');
			}

			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}

			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);

			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}

		} else {
			$json['error'] = $this->language->get('error_select');
		}

		if (!$this->user->hasPermission('modify', 'common/' . $this->_name)) {
      		$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}

			$json['success'] = $this->language->get('text_copy');
		}

		$this->response->setOutput(json_encode($json));
	}

	protected function recursiveCopy($source, $destination) {
		$directory = opendir($source);

		@mkdir($destination);

		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) {
				if (is_dir($source . '/' . $file)) {
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file);
				} else {
					copy($source . '/' . $file, $destination . '/' . $file);
				}
			}
		}

		closedir($directory);
	}

	public function folders() {
		$this->response->setOutput($this->recursiveFolders(DIR_IMAGE . 'data/'));
	}

	protected function recursiveFolders($directory) {
		$output = '';

		$output .= '<option value="' . utf8_substr($directory, strlen(DIR_IMAGE . 'data/')) . '">' . utf8_substr($directory, strlen(DIR_IMAGE . 'data/')) . '</option>';

		$directories = glob(rtrim(str_replace('../', '', $directory), '/') . '/*', GLOB_ONLYDIR);

		foreach ($directories as $directory) {
			$output .= $this->recursiveFolders($directory);
		}

		return $output;
	}

	public function rename() {
		$this->language->load('common/' . $this->_name);

		$json = array();

		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}

			$old_name = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
				$json['error'] = $this->language->get('error_rename');
			}

			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}

			$new_name = dirname($old_name) . '/' . str_replace('../', '', html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);

			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}
		}

		if (!$this->user->hasPermission('modify', 'common/' . $this->_name)) {
      		$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error'])) {
			rename($old_name, $new_name);

			$json['success'] = $this->language->get('text_rename');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function upload() {
		$this->language->load('common/' . $this->_name);

		$json = array();

		if (isset($this->request->post['directory'])) {
			if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {
				$filename = basename(html_entity_decode($this->request->files['image']['name'], ENT_QUOTES, 'UTF-8'));

				if ((strlen($filename) < 3) || (strlen($filename) > 255)) {
					$json['error'] = $this->language->get('error_filename');
				}

				$directory = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['directory']), '/');

				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}

				$file_max_size = 1024000; // 1mb

				if ($this->request->files['image']['size'] > (int)$file_max_size) {
					$json['error'] = $this->language->get('error_file_size');
				}

				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png',
					'image/gif',
					'multipart/x-zip',
					'application/zip',
					'application/x-compressed',
					'application/x-zip-compressed',
					'application/rar',
					'application/x-rar-compressed',
					'application/pdf',
					'application/x-pdf',
					'application/x-shockwave-flash'
				);

				if (!in_array($this->request->files['image']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
				}

				$allowed = array(
					'.jpg',
					'.jpeg',
					'.png',
					'.gif',
					'.zip',
					'.rar',
					'.pdf',
					'.swf',
					'.flv'
				);

				if (!in_array(strtolower(strrchr($filename, '.')), $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
				}

				// Check to see if any PHP files are trying to be uploaded
				$content = file_get_contents($this->request->files['image']['tmp_name']);

				if (preg_match('/\<\?php/i', $content)) {
					$json['error'] = $this->language->get('error_file_type');
				}

				if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
					$json['error'] = 'error_upload_' . $this->request->files['image']['error'];
				}

			} else {
				$json['error'] = $this->language->get('error_file');
			}

		} else {
			$json['error'] = $this->language->get('error_directory');
		}

		if (!$this->user->hasPermission('modify', 'common/' . $this->_name)) {
      		$json['error'] = $this->language->get('error_permission');
		}

		if (!isset($json['error'])) {
			if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . $filename)) {
				$json['success'] = $this->language->get('text_uploaded');
			} else {
				$json['error'] = $this->language->get('error_uploaded');
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	// ---------------- Multiple Upload -------------------

	public function multi() {
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$targetDir = rtrim(DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->get['directory']), '/');

		$chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
		$chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
		$filename = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

		$fileName = basename(html_entity_decode($filename, ENT_QUOTES, 'UTF-8'));

		if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
			$ext = strrpos($fileName, '.');
			$fileName_a = substr($fileName, 0, $ext);
			$fileName_b = substr($fileName, $ext);

			$count = 1;

			while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
				$count++;

			$fileName = $fileName_a . '_' . $count . $fileName_b;
		}

		if (!file_exists($targetDir)) {
			@mkdir($targetDir);
		}

		if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
			$contentType = $_SERVER["HTTP_CONTENT_TYPE"];
		}

		if (isset($_SERVER["CONTENT_TYPE"])) {
			$contentType = $_SERVER["CONTENT_TYPE"];
		}

		$file_max_size = 25600; // 25Mb

		if (strpos($contentType, "multipart") !== false) {
			if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
				$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");

				if ($out) {
					$in = fopen($_FILES['file']['tmp_name'], "rb");

					if ($in) {
						while ($buff = fread($in, (int)$file_max_size))
							fwrite($out, $buff);
					} else {
						die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
					}

					fclose($in);
					fclose($out);

					@unlink($_FILES['file']['tmp_name']);

				} else {
					die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
				}

			} else {
				die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
			}

		} else {
			$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");

			if ($out) {
				$in = fopen("php://input", "rb");

				if ($in) {
					while ($buff = fread($in, (int)$file_max_size))
						fwrite($out, $buff);
				} else {
					die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
				}

				fclose($in);
				fclose($out);

			} else {
				die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
			}
		}

		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
	}
}
?>