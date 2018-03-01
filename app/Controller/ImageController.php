<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Controller;


use App\HttpRequest;
use App\HttpResponse;

class ImageController extends BaseController {

    public function getAllImages(HttpRequest $req, HttpResponse $res) {
        $res->send(200,[
            "hola"=>1
        ]);
    }
}