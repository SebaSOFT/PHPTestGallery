<?php
/**
 * User: SebaSOFT
 * Date: 28/2/2018
 */

namespace App;


class HttpResponse {

    private $headers = [];
    private $app = null;

    /**
     * HttpResponse constructor.
     * @param Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;

        foreach (headers_list() as $header) {
            $arrHeader = explode(': ', $header);
            $slug = StringUtils::slugify($arrHeader[0]);
            $this->headers[$slug] = [
                'name' => $arrHeader[0],
                'value' => $arrHeader[1],
            ];
        }
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return $this->headers;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getHeader($name) {
        if (!isset($this->headers[mb_strtoupper($name)])) {
            return null;
        }
        $slug = StringUtils::slugify($name);
        return $this->headers[$slug];
    }

    /**
     * @param $name
     * @param $value
     */
    public function setHeader($name, $value) {
        $slug = StringUtils::slugify($name);
        $this->headers[$slug] = [
            'name' => $name,
            'value' => $value
        ];
    }

    public function send($status = 200, $content = null) {
        $res = "";
        if ($status !== http_response_code()) {
            http_response_code($status);
        }
        $this->_sendHeaders();
        if (!is_null($content)) {
            if (is_array($content) || is_object($content)) {
                $res = json_encode($content);
            } else {
                $res = $content . "";
            }
        }
        echo $res;
        exit;
    }

    private function _sendHeaders() {
        if (headers_sent($file, $line)) {
            echo "Headers already sent in $file on line $line";
            exit;
        }
        foreach ($this->headers as $header) {
            header($header['name'] . " : " . $header['value'], true);
        }
    }


}