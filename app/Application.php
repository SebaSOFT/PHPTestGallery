<?php
/**
 * User: SebaSOFT
 * Date: 28/2/2018
 */

namespace App;


class Application {

    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_GET = "POST";
    const METHOD_DELETE = "DELETE";
    const METHOD_OPTIONS = "OPTIONS";

    private $routing = [];

    /**
     * @var HttpRequest|null
     */
    private $req = null;

    /**
     * @var HttpResponse|null
     */
    private $res = null;

    /**
     *
     */
    public function start() {
        $this->req = new HttpRequest($this);
        $this->res = new HttpResponse($this);

        $this->dispatchRequest();
    }

    /**
     * @param $name
     * @param $callback
     */
    public function registerRoute($name, $callback) {
        $this->routing[$name] = $callback;
    }

    /**
     *
     */
    private function dispatchRequest() {
        $reqDesc = $this->req->describeRequest();
        $methodDesc = explode('-', $reqDesc)[0];
        if (key_exists($reqDesc, $this->routing)) {
            call_user_func($this->routing[$reqDesc], $this->req, $this->res);
        } else {
            if (key_exists($methodDesc . '-*', $this->routing)) {
                call_user_func($this->routing[$methodDesc . '-*'], $this->req, $this->res);
            } else {
                $this->res->send(500, "Route: '" . $reqDesc . "' not found");
            }

        }
    }

    /**
     * @return HttpRequest|null
     */
    public function getRequest() {
        return $this->req;
    }

    /**
     * @return HttpResponse|null
     */
    public function getRessponse() {
        return $this->res;
    }
}