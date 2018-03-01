<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Data;


use App\Application;
use App\Data\Model\Image;

class ImageManager extends BaseManager {

    /**
     * @param Image $img
     */
    public function addImage(Image $img) {

    }

    /**
     * @param $id
     * @return Image|null
     */
    public function getImage($id) {
        return new Image(array(
            'id' => $id,
            'file' => 'non-existan.jpg',
            'size' => 321,
            'filename' => 'bs-file.jpg',
            'description' => 'This is not going to be seen'
        ));
    }

    /**
     * @param $id
     */
    public function deleteImage($id) {

    }

    /**
     * @return array
     */
    public function listImages() {
        return array();
    }
}