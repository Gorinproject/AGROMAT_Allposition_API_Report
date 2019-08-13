<?php
namespace allpositions\api;
/**
 * Класс для работы с API AllPositions
 * @link http://allpositions.ru/help/api/
 *
 * @package allpositions\api
 *
 * @author Andrey Ursaev <yrsaev.andrey@gmail.com>
 */
class Client{
    private $_port = 80;
    private $_url = 'allpositions.ru';
    private $_path = 'api';
    private $_api_key;
    /**
     * @param string $api_key
     */
    public function __construct($api_key){
        $this->_api_key = $api_key;
    }
    public function setPath($path){
        $this->_path = $path;
    }
    /**
     * @param string $method
     * @return string
     */
    private function _getApiUrl($method = 'http'){
        return "$method://{$this->_url}/{$this->_path}/";
    }
    /**
     * @param string $method
     * @param array $params
     *
     * @return string
     */
    private function _prepareRequest($method, $params){
        return xmlrpc_encode_request($method, $params);
    }
    /**
     * @param string $response
     * @return array
     */
    private function _parseResponse($response){
        return xmlrpc_decode($response);
    }
    /**
     * Отправка XML-RPC запроса на allpositions
     *
     * @param string $method
     * @param array $params
     *
     * @return array
     */
    private function _send($method, $params = []){
        $request = $this->_prepareRequest($method, $params);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->_getApiUrl(),
            CURLOPT_PORT => $this->_port,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/xml',
                'Accept-Charset: UTF-8',
                'Content-length: ' . strlen($request),
            ],
            CURLOPT_COOKIE => "api_key={$this->_api_key}",
            CURLOPT_POSTFIELDS => $request,
        ]);
        $data = curl_exec($ch);
        $is_error = curl_errno($ch);
        curl_close($ch);
        return $is_error ? [] : $this->_parseResponse($data);
    }
    /**
     * Cписок проектов пользователя
     *
     * @param int $id_project
     * @return array [url, cy, pr, yaca, dmoz, yahoo]
     */
    public function getProject($id_project){
        return $this->_send('get_project', [(int) $id_project]);
    }
    /**
     * @param int|null $id_group
     * @return array[] [id_project, id_group, url, cy, pr]
     */
    public function getProjects($id_group = null){
        return $this->_send('get_projects', [(int) $id_group]);
    }
    /**
     * Список групп проектов
     *
     * @return array[] [id_group, group]
     */
    public function getProjectsGroup(){
        return $this->_send('get_projects_group');
    }
    /**
     * Список запросов, по которым определяется позиция сайта
     *
     * @param int $id_project
     * @param int|null $id_group
     *
     * @return array[] [id_query, id_group, query, freq, url]
     */
    public function getQueries($id_project, $id_group = null){
        return $this->_send('get_queries', [(int) $id_project, (int) $id_group]);
    }
    /**
     * Список групп запросов
     *
     * @param int $id_project
     * @return array[] [id_group, group]
     */
    public function getQueriesGroup($id_project){
        return $this->_send('get_queries_group', [(int) $id_project]);
    }
    /**
     * Отчет по позициям сайта
     *
     * @param int $id_project
     * @param string|null $date
     * @param string|null $prev_date
     * @param int $page
     * @param int $per_page
     *
     * @return array [
        * count, top3, top10, top30, down, up, date, prev_date,
        * sengines[id_se, name_se, name_region][],
        * queries[id_query, query, wordstat][],
        * positions[position, prev_position, change_position, url][]
     * ]
     */
    public function getReport($id_project, $date = null, $prev_date = null, $page = 1, $per_page = 1000){
        return $this->_send('get_report', [(int) $id_project, $date, $prev_date, (int) $page, (int) $per_page]);
    }
    /**
     * Список дат, когда обновлялись позиции сайта
     *
     * @param int $id_project
     * @return array
     */
    public function getReportDates($id_project){
        return $this->_send('get_report_dates', [(int) $id_project]);
    }
    /**
     * Добавление запросов в отчет
     *
     * @param int $id_project
     * @param string $queries
     * @param int|null $id_group
     *
     * @return array|bool
     */
    public function addQueries($id_project, $queries, $id_group = null){
        return $this->_send('add_queries', [(int) $id_project, (string) $queries, (int) $id_group]);
    }
    /**
     * Удаление запросов из отчета
     *
     * @param array $ids массив id_query, которые нужно удалить
     * @return array|bool
     */
    public function deleteQueries($ids){
        return $this->_send('delete_queries', [$ids]);
    }
    /**
     * Список поисковых систем
     *
     * @param int $id_project
     * @return array[] [id_se, name_se, name_region]
     */
    public function getSes($id_project){
        return $this->_send('get_ses', [(int) $id_project]);
    }
    /**
     * Данные о видимости сайта за указанный период
     *
     * @param int $id_project
     * @param string|null $begin_date
     * @param string|null $end_date
     * @param int $id_se
     *
     * @return array [id_project, begin_date, end_date, id_se]
     */
    public function getVisibility($id_project, $begin_date = null, $end_date = null, $id_se = 0){
        return $this->_send('get_visibility', [(int) $id_project, $begin_date, $end_date, (int) $id_se]);
    }
}