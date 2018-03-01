<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Controller;


use App\Application;
use App\HttpRequest;
use App\HttpResponse;

class ImageController {

    /**
     * @var Application|null
     */
    private $app = null;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    public function getAllImages(HttpRequest $req, HttpResponse $res) {
        $res->send(200,[
            "hola"=>1
        ]);
    }
}