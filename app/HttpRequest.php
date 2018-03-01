<?php
/**
 * User: SebaSOFT
 * Date: 28/2/2018
 */

namespace App;


class HttpRequest {

    private $headers = [];
    private $app = null;

    /**
     * HttpRequest constructor.
     * @param Application $app
     */
    public function __construct(Application $app) {
        $this->app = $app;

        foreach (filter_input_array(INPUT_SERVER, FILTER_SANITIZE_SPECIAL_CHARS, true) as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = StringUtils::slugify(substr($key, 5));
            $this->headers[$header] = $value;
        }
    }

    /**
     * @return array
     */
    public function getHeaders(): array {
        return $this->headers;
    }

    /**
     * @param string|null $name
     * @return string|null
     */
    public function getHeader($name = null) {
        if (is_null($name)) {
            return null;
        }
        $slug = StringUtils::slugify($name);
        return $this->headers[$slug];
    }

    public function getRequestParams() {
        return filter_input_array(INPUT_GET, FILTER_SANITIZE_URL, true);
    }

    public function getRequestParam($name) {
        return filter_input(INPUT_GET, $name, FILTER_SANITIZE_URL);
    }

    public function describeRequest() {
        $method = strtoupper(filter_input(INPUT_SERVER, 'REQUEST_METHOD', FILTER_SANITIZE_URL));
        $p = ucfirst(trim($this->getRequestParam('p')));
        if(empty($p)){
            $p='Index';
        }
        return $method . '-' . $p;
    }
}