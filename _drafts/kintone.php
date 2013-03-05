<?php

/**
 * 
 * @author atomita
 * @uses CURL
 * @uses fileinfo
 * @uses mb_string
 */
class Kintone {

	private $base_url;
	private $auth_token;
	private $basic_auth_token;
	public $last_body = array('body'		 => '', 'code'		 => 0, 'message'	 => '', 'header'	 => array());

	function __construct(array $params = array()) {
		static $def_params =
		array(
			'fqdn'		 => 'xxx.cybozu.com',
			'user'		 => 'xxx',
			'password'	 => '',
			'app'		 => 1,
			'basic'		 => array(
				'user'		 => '',
				'passwprd'	 => ''
			),
		);

		$this->params = new ArrayObject(array_merge($def_params, $params), ArrayObject::ARRAY_AS_PROPS);

		if (!isset($this->params->basic['user'])) {
			$this->params->basic['user'] = '';
		}
		if (!isset($this->params->basic['passwprd'])) {
			$this->params->basic['passwprd'] = '';
		}

		$this->base_url			 = "https://{$this->params->fqdn}/k/v1/";
		$this->auth_token		 = base64_encode("{$this->params->user}:{$this->params->password}");
		$this->basic_auth_token	 = base64_encode("{$this->params->basic['user']}:{$this->params->basic['passwprd']}");
	}

	/**
	 * 
	 * @param array $params key is Kintone Application's Column name
	 * @param boolean $throw_on_error
	 * @return array
	 * @throws KintoneException
	 */
	function post(array $params, $throw_on_error = true) {
		$record = array();

		foreach ($params as $key => $value) {
			$record[$key] = array('value'	 => $value);
		}
		$data	 = array(
			'app'	 => $this->params->app,
			'record' => $record,
		);

		return $this->request('record.json', $data, $throw_on_error, true, array('Content-Type' => 'application/json'));
	}

	/**
	 * 添付ファイル フィールドがある場合、registメソッドの前にファイルをUPし、fileKeyを取得し、添付ファイル フィールドの値とする
	 * @param string $filepath
	 * @param boolean $throw_on_error
	 * @return array
	 * @throws KintoneException
	 */
	function upload($filepath, $throw_on_error = true) {
		$file_name = mb_convert_encoding(mb_substr($filepath, mb_strrpos($filepath, DIRECTORY_SEPARATOR) + 1), "UTF-8", "auto");

		$finfo		 = finfo_open(FILEINFO_MIME_TYPE);
		$mime_type	 = finfo_file($finfo, $filepath);
		finfo_close($finfo);

		$data = array('file' => "@{$filepath};filename=$file_name;type=$mime_type");

		return $this->request('file.json', $data, $throw_on_error);
	}

	/**
	 * 
	 * @param int|sting $id 
	 * @param boolean $throw_on_error
	 * @return array
	 * @throws KintoneException
	 */
	function get($id, $throw_on_error = true) {
		return $this->request('record.json'
						, array('app'	 => $this->params->app, 'id'	 => $id)
						, $throw_on_error, true
						, array('Content-Type' => 'application/json'), array(CURLOPT_CUSTOMREQUEST => 'GET'));
	}

	/**
	 * 
	 * @staticvar array $fixed_values
	 * @staticvar array $query_options
	 * @staticvar null $echo
	 * @param array $params key is 'query'(string or array), 'fields'(json string or array), 'order_by', 'limit', 'offset'
	 * @param boolean $throw_on_error
	 * @return array
	 * @throws KintoneException
	 */
	function find(array $params, $throw_on_error = true) {
		static $fixed_values = array('LOGINUSER()', 'TODAY()', 'THIS_MONTH()', 'THIS_YEAR()');
		static $query_options = array('order by'	 => 'order_by', 'limit'		 => 'limit', 'offset'	 => 'offset');
		static $echo		 = null;
		is_null($echo) and $echo		 = create_function('$v', 'return $v;');

		$data = array_merge($params, array('app' => $this->params->app));

		if (!empty($data['fields']) && !is_array($data['fields'])) {
			$data['fields'] = array($data['fields']);
		}

		foreach ($query_options as $query_option_var_name) {
			if (array_key_exists($query_option_var_name, $data)) {
				$$query_option_var_name = $data[$query_option_var_name];
				unset($data[$query_option_var_name]);
			}
			else {
				$$query_option_var_name = '';
			}
		}

		if (!empty($data['query']) && !is_array($data['query'])) {
			$querys = $data['query'];
			if (array_key_exists('data', $data['query']) and is_array($data['query']) and array_keys($data['query']) == array('data')) {
				$querys = $data['query']['data'];
			}

			$query = '';
			foreach ($querys as $key => $value) {
				if (is_int($key)) {
					$query .= ' and ' . $value;
				}
				else {
					preg_match('/^(.*?)(?:\\s+([><!]?=|[><]|(?:not\s+)?in|(?:not\s+)?like)\\s*)?$/u', $key, $m);
					$column		 = $m[1];
					$operator	 = array_key_exists(2, $m) ? $m[2] : '=';
					!in_array($value, $fixed_values) and $value		 = '"' . str_replace('"', '\\"', $value) . '"';
					$query .= " and {$column} {$operator} {$value}";
				}
			}

			$data['query'] = substr($query, 5);
		}

		foreach ($query_options as $query_option => $query_option_var_name) {
			!empty($$query_option_var_name) and $data['query'] .= " {$query_option} {$$query_option_var_name}";
		}

		return $this->request('records.json', $data, $throw_on_error, true
						, array('Content-Type' => 'application/json'), array(CURLOPT_CUSTOMREQUEST => 'GET'));

//	function find(array $params, $throw_on_error = true) {
//		$query_string = "app={$this->params->app}";
//
//		if (!empty($params['query'])) {
//			$query_string .= "&query=" . urlencode(mb_convert_encoding($params['query'], "UTF-8", "auto"));
//		}
//		if (!empty($params['fields'])) {
//			$fileds = is_array($params['fields']) ? $params['fields'] : array($params['fields']);
//			$i = 0;
//			foreach ($fileds as $value) {
//				$query_string .= "&" . urlencode("fields[{$i}]") . "=" . urlencode(mb_convert_encoding($value, "UTF-8", "auto"));
//				$i++;
//			}
//		}
//		return $this->request("records.json?{$query_string}", false, $throw_on_error);
//	}
	}

	/**
	 * 
	 * @param type $file
	 * @param boolean $throw_on_error
	 * @return array
	 */
	function download($file, $throw_on_error = true) {
		return $this->request($this->downloadUrl($file, true), false, $throw_on_error);
	}

	/**
	 * 
	 * @param mixed $file
	 * @param boolean $is_uri
	 * @return string
	 */
	function downloadUrl($file, $is_uri = false) {
		$file_key = @$file['fileKey'] or @$file->fileKey or $file;
		return ($is_uri ? '' : $this->base_url) . "file.json?fileKey=$file_key";
	}

	/**
	 * 
	 * @param int|string $id
	 * @param array $param
	 * @param boolean $throw_on_error
	 * @return array
	 */
	function patch($id, array $param, $throw_on_error = true) {
		$record = array();
		foreach ($param as $key => $value) {
			$record[$key] = (is_array($value) and array_key_exists('value', $value)) ? $value : array('value' => $value);
		}

		$data = array(
			'app'		 => $this->params->app,
			'id'		 => $id,
			'record'	 => $record,
		);
		$response	 = $this->request('record.json', $data, $throw_on_error, false
				, array('Content-Type' => 'application/json'), array(CURLOPT_CUSTOMREQUEST => 'PUT'));

		$response['body'] = 0 < preg_match('/^\\s*{\\s*}\\s*$/', $response['body']);
		return $response;
	}

	/**
	 * 
	 * @param int|string|array $id
	 * @param array $param
	 * @param boolean $throw_on_error
	 * @return array
	 */
	function delete($id, $throw_on_error = true) {
		$response = $this->request('records.json', array(
			'app'	 => $this->params->app,
			'ids'	 => is_array($id) ? $id : array($id),
				), $throw_on_error, false
				, array('Content-Type' => 'application/json'), array(CURLOPT_CUSTOMREQUEST => 'DELETE'));

		$response['body'] = 0 < preg_match('/^\\s*{\\s*}\\s*$/', $response['body']);
		return $response;
	}

	/**
	 * 
	 * @param string $uri
	 * @param mixed $data
	 * @param boolean $throw_on_error
	 * @param boolean $is_jsondecode
	 * @param array $request_headers
	 * @param array $curl_options
	 * @return array
	 * @throws KintoneException
	 */
	private function request($uri, $data, $throw_on_error, $is_jsondecode = true, array $request_headers = array(), array $curl_options = array()) {
		static $def_curl_options =
		array(
			CURLOPT_SSL_VERIFYPEER	 => false,
			CURLOPT_SSL_VERIFYHOST	 => false,
			CURLOPT_SSLVERSION		 => 3,
			CURLOPT_HEADER			 => false,
			CURLOPT_RETURNTRANSFER	 => true,
			CURLOPT_FAILONERROR		 => true,
		);
		$url					 = $this->base_url . $uri;

		$body	 = '';
		$code	 = 500;
		$message = '';
		$header	 = array();
		$heads = '';
		try {
			$curl_options	 = $curl_options + $def_curl_options; // merge
			$request_headers = array_merge(array(
				'X-Cybozu-Authorization' => $this->auth_token,
				'Authorization'			 => "basic $this->basic_auth_token",
					), $request_headers);

			if (is_array($data) && !empty($request_headers['Content-Type']) && $request_headers['Content-Type'] === 'application/json') {
				$data	 = json_encode($data);
			}
			$ch		 = curl_init($url);

			if (!empty($data)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  // HTTPリクエストボディ
			}

			// set curl options
			foreach ($curl_options as $key => $value) {
				curl_setopt($ch, $key, $value);
			}

			curl_setopt($ch, CURLOPT_HTTPHEADER, self::_coron_join($request_headers));  // 認証トークン、コンテントタイプを付与


			$response = curl_exec($ch); // request
			if ($curl_options[CURLOPT_HEADER]) {
				if (false !== strpos($response, "\r\n\r\n")) {
					list($heads, $body) = explode("\r\n\r\n", curl_exec($ch), 2);
				}
				else {
					$heads = $response;
				}
			}
			else {
				$body = $response;
			}

			$code	 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$message = curl_error($ch);
			curl_close($ch);

			// header
			if ($curl_options[CURLOPT_HEADER]) {
				if (false !== strpos($heads, "\r\n")) {
					$heads = explode("\r\n", $heads);
				}
				else {
					$heads = empty($heads) ? array() : array($heads);
				}
				foreach ($heads as $head) {
					if (0 < strpos($head, ':')) {
						list($k, $v) = explode(':', $head, 2);
						if (isset($header[$k])) {
							if (!is_array($header[$k])) {
								$header[$k] = array($header[$k]);
							}
							$header[$k][] = ltrim($v);
						}
						else {
							$header[$k] = ltrim($v);
						}
					}
					else {
						$header[] = $head;
					}
				}
			}

			$this->last_response = compact('body', 'code', 'message', 'header');

			if (200 === $code) {
				if ($is_jsondecode) {
					$body = json_decode($body, true);
				}
			}
			else if ($throw_on_error) {
				throw new KintoneException($message, $code);
			}
		}
		catch (KintoneException $exc) {
			throw $exc;
		}
		catch (Exception $exc) {
			if ($throw_on_error) {
				throw new KintoneException($exc->getMessage(), 1000, $exc);
			}
			else {
				$message = $exc->getMessage();
			}
		}
		return compact('body', 'code', 'message', 'header');
	}

	static private function _coron_join($array) {
		$r = array();
		foreach ($array as $k => $v) {
			$r[] = "{$k}: {$v}";
		}
		return $r;
	}

}

class KintoneException extends Exception {
	
}

