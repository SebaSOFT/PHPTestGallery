<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Controller;


use App\Application;
use App\Data\ImageManager;
use App\HttpRequest;
use App\HttpResponse;

class ImageController extends BaseController {

    const PHOTO_DIR = __DIR__ . '/../../public/photo/';
    const IMG_PLACE_HOLDER = __DIR__ . '/../../public/img/placeholder.jpg';

    public function __construct(Application $app) {
        parent::__construct($app);
    }

    public function getAllImages(HttpRequest $req, HttpResponse $res) {
        /**
         * @var ImageManager $db
         */
        $db = $this->app->getManager('image');
        $rows = $db->listImages();
        if (!is_array($rows)) {
            $rows = array();
        }
        $res->send(200, $rows);
    }

    public function deleteImage(HttpRequest $req, HttpResponse $res) {
        $imgId = $req->getRequestParam('id');
        /**
         * @var ImageManager $db
         */
        $db = $this->app->getManager('image');
        $img = $db->getImage($imgId);
        if (!is_null($img)) {
            if ($db->deleteImage($imgId)) {
                $res->send(200, "OK!");
            } else {
                $res->send(500, "Could not delete Photo!");
            }
        } else {
            $res->send(404, "Image not Found!");
        }
    }

    public function showImage(HttpRequest $req, HttpResponse $res) {
        $imgId = $req->getRequestParam('id');
        /**
         * @var ImageManager $db
         */
        $db = $this->app->getManager('image');

        $img = $db->getImage($imgId);
        if (!is_null($img)) {
            $filename = self::PHOTO_DIR . $img->getFile();
            if (!file_exists($filename)) {
                $filename = self::IMG_PLACE_HOLDER;
            }
            //die(var_export($filename,true));
            $res->setHeader('Content-Type', mime_content_type($filename));
            $res->setHeader('Content-Length', filesize($filename));
            $res->setHeader('Last-Modified', date(DATE_RFC2822, filemtime($filename)));
            $res->setHeader('Etag', md5_file($filename));
            $res->setHeader('Content-Disposition', 'inline; filename="' . $img->getFilename() . '"');
            $res->setHeader('Cache-Control', 'public');
            $res->setHeader('Expires', '0');
            $res->sendFile($filename);
        } else {
            $res->send(404, "Image not Found!");
        }
    }
}