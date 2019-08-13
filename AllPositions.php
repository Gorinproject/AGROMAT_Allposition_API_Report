<?php
namespace xf3;
/**
 * Class AllPositions
 *
 * Provides simple access to allpositions.ru API
 *
 * For full methods reference, see http://allpositions.ru/help/api/
 */
class AllPositions {
	public $apiKey = '';
	/**
	 * @var string Last occured error message
	 */
	private $_lastError = null;
	/**
	 * @var \xmlrpc_client
	 */
	private $_client = null;
	/**
	 * Creates new allpositions.ru API client
	 *
	 * @param string $apiKey allpositions.ru API key
	 */
	public function __construct($apiKey = '') {
		$this->apiKey = $apiKey;
	}
	/**
	 * Creates API XMLRPC client
	 *
	 * @return \xmlrpc_client
	 */
	private function _getClient() {
		if ($this->_client === null) {
			if (!$this->apiKey) {
				$this->_lastError = 'No API key provided';
				return false;
			}
			$this->_client = new \xmlrpc_client('api', 'allpositions.ru', 80);
			$GLOBALS ['xmlrpc_defencoding'] = "UTF8";
			$GLOBALS ['xmlrpc_internalencoding'] = "UTF-8";
			$this->_client->setcookie('api_key', $this->apiKey, '/', 'allpositions.ru');
		}
		return $this->_client;
	}
	/**
	 * Calls specified API method with optional arguments
	 *
	 * @param string $method API method name
	 * @param array $arguments Method arguments. Each item is an array in format:<pre>
	 * [0] => Argument value
	 * [1] => Argument type ('array', 'int', 'string')
	 * [2] => If not empty - marks argument as optional. In this case, if value is null, argument won't be passed
	 * </pre>
	 *
	 * @return mixed null on error
	 */
	private function _request($method, $arguments = array()) {
		$client = $this->_getClient();
		if (!$client) {
			return null;
		}
		$params = array();
		foreach($arguments as $argument) {
			if (!$argument || !empty($argument[2]) && $argument[0] === null) break;
			$params[]= new \xmlrpcval($argument[0], $argument[1]);
		}
		$msg = new \xmlrpcmsg($method, $params);
		$res = $client->send($msg);
		if ($res->faultCode()) {
			$this->_lastError = $res->faultString();
			return null;
		}
		$this->_lastError = null;
		return php_xmlrpc_decode($res->value());
	}
	/**
	 * @see http://allpositions.ru/help/api/#add_queries
	 *
	 * @param int $projectID Project ID
	 * @param string $queries Queries divided by \n
	 * @param int $groupID [Optional] Group ID
	 *
	 * @return bool
	 */
	public function add_queries($projectID, $queries, $groupID = null) {
		return $this->_request(
			'add_queries',
			array(
				array(
					$projectID, 'int'
				),
				array(
					$queries, 'string'
				),
				array(
					$groupID, 'int', true
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#delete_queries
	 *
	 * @param array $ids Queries IDs
	 *
	 * @return bool
	 */
	public function delete_queries($ids) {
		return $this->_request(
			'delete_queries',
			array(
				array(
					$ids, 'array'
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_project
	 *
	 * @param int $projectID
	 *
	 * @return array
	 */
	public function get_project($projectID) {
		return $this->_request(
			'get_project',
			array(
				array(
					$projectID, 'int',
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_projects
	 *
	 * @param int $groupID [Optional] group ID
	 *
	 * @return array
	 */
	public function get_projects($groupID = null) {
		return $this->_request(
			'get_projects',
			array(
				array(
					$groupID, 'int', true
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_projects_group
	 *
	 * @return array
	 */
	public function get_projects_group() {
		return $this->_request('get_projects_group');
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_queries
	 *
	 * @param int $projectID Project ID
	 * @param int $groupID [Optional] Group ID
	 *
	 * @return array
	 */
	public function get_queries($projectID, $groupID = null) {
		return $this->_request(
			'get_queries',
			array(
				array(
					$projectID, 'int'
				),
				array(
					$groupID, 'int', true
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_queries_group
	 *
	 * @param int $projectID Project ID
	 *
	 * @return array
	 */
	public function get_queries_group($projectID) {
		return $this->_request(
			'get_queries_group',
			array(
				array(
					$projectID, 'int'
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_report
	 *
	 * @param int $projectID Project ID
	 * @param string $date [Optional] Report date (Y-m-d, e.g. '2014-05-20')
	 * @param string $prevDate [Optional] Date to compare results from (Y-m-d, e.g. '2014-05-20')
	 * @param int $page [Optional] Page number
	 * @param int $perPage [Optional] Rows on page
	 *
	 * @return array
	 */
	public function get_report($projectID, $date = null, $prevDate = null, $page = null, $perPage = null) {
		return $this->_request(
			'get_report',
			array(
				array(
					$projectID, 'int'
				),
				array(
					$date, 'string', true
				),
				array(
					$prevDate, 'string', true
				),
				array(
					$page, 'int', true
				),
				array(
					$perPage, 'int', true
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_report_dates
	 *
	 * @param int $projectID Project ID
	 *
	 * @return array
	 */
	public function get_report_dates($projectID) {
		return $this->_request(
			'get_report_dates',
			array(
				array(
					$projectID, 'int'
				),
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_ses
	 *
	 * @param int $projectID Project ID
	 *
	 * @return array
	 */
	public function get_ses($projectID) {
		return $this->_request(
			'get_ses',
			array(
				array(
					$projectID, 'int'
				)
			)
		);
	}
	/**
	 * @see http://allpositions.ru/help/api/#get_visibility
	 *
	 * @param int $projectID Project ID
	 * @param string $beginDate [Optional] Begin date (Y-m-d, e.g. '2014-05-20')
	 * @param string $endDate [Optional] End date (Y-m-d, e.g. '2014-05-20')
	 * @param int $seID [Optional] Search engine ID
	 *
	 * @return array
	 */
	public function get_visibility($projectID, $beginDate = null, $endDate = null, $seID = null) {
		return $this->_request(
			'get_visibility',
			array(
				array(
					$projectID, 'int'
				),
				array(
					$beginDate, 'string', true
				),
				array(
					$endDate, 'string', true
				),
				array(
					$seID, 'int', true
				),
			)
		);
	}
	/**
	 * Returns last occured error message
	 *
	 * @return string
	 */
	public function lastError() {
		return $this->_lastError;
	}
}