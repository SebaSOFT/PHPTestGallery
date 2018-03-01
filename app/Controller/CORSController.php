<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Controller;


use App\Application;
use App\HttpRequest;
use App\HttpResponse;

class CORSController extends BaseController {

    public function __construct(Application $app) {
        parent::__construct($app);
        $this->decorateResponse();
    }

    public function handle(HttpRequest $req, HttpResponse $res) {
        $res->send(200, []);
    }

    private function decorateResponse() {
        /**
         * @var HttpRequest
         */
        $req = $this->app->getRequest();
        /**
         * @var HttpResponse
         */
        $res = $this->app->getRessponse();


        $res->setHeader('Access-Control-Allow-Origin','*');
        $res->setHeader('Access-Control-Allow-Methods','OPTIONS,GET,POST,PUT,DELETE');

        $reqHeader = $req->getHeader('Access-Control-Request-Headers');
        if(!is_null($reqHeader)){
            $res->setHeader('Access-Control-Allow-Headers',$reqHeader);
        }

    }
}