<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Controller;


use App\Application;
use App\Data\ImageManager;
use App\Data\Model\Image;
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
                $filename = self::PHOTO_DIR . $img->getFile();
                if (file_exists($filename)) {
                    unlink($filename);
                }
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

    public function addImage(HttpRequest $req, HttpResponse $res) {
        $formFile = $req->getFile('photofile');
        if (is_null($formFile) || !is_array($formFile)) {
            $res->send(500, "Invalid Photo upload!");
            return;
        }
        if ($formFile['error'] != 0) {
            $uploadErrors = array(
                1 => 'The uploaded file exceeds the upload max filesize allowed.',
                2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                3 => 'The uploaded file was only partially uploaded',
                4 => 'No file was uploaded',
                6 => 'Missing a temporary folder'
            );
            $res->send(500, $uploadErrors[$formFile['error']]);
            return;
        }
        if (!in_array($formFile['type'], array('image/jpeg', 'image/png'))) {
            $res->send(500, "Invalid Photo Format!");
            return;
        }
        if ($formFile['size'] > 2048000) {
            $res->send(500, "Invalid Photo File Size!");
            return;
        }
        $desc = $req->getFormParam('photodesc');
        if ($desc === '') {
            $desc = null;
        }
        $uploadedFilename = basename($formFile["name"]);
        $tmpFile = $formFile['tmp_name'];
        $tmp = explode(".", $uploadedFilename);
        $newfilename = time() . '_' . rand(100, 999) . '.' . mb_strtolower(end($tmp));
        $moveRet = move_uploaded_file($tmpFile, self::PHOTO_DIR . $newfilename);
        if (!$moveRet) {
            $res->send(500, "Could not manipulate file!");
            return;
        }
        $newImage = new Image([
            'id' => null,
            'file' => $newfilename,
            'filename' => $uploadedFilename,
            'size' => $formFile['size'],
            'description' => $desc
        ]);
        /**
         * @var ImageManager $db
         */
        $db = $this->app->getManager('image');
        $insertRet = $db->addImage($newImage);
        if ($insertRet) {
            $res->send(200, "OK!");
        } else {
            @unlink(self::PHOTO_DIR . $newfilename);
            $res->send(500, "Could not insert image into the DB!");
            return;
        }
    }
}