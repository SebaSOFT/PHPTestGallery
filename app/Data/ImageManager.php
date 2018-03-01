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
        $result = $this->db->querySingle(
            'SELECT * FROM images where id = ' .
            filter_var($id, FILTER_SANITIZE_NUMBER_INT),
            true
        );

        if (is_null($result)) {
            return null;
        }
        return $this->buildImageModel($result);
    }

    /**
     * @param $id
     */
    public function deleteImage($id) {
        return $this->db->exec('DELETE FROM images WHERE id = ' . filter_var($id, FILTER_SANITIZE_NUMBER_INT));
    }

    /**
     * @return array
     */
    public function listImages() {
        $res = array();
        $stmnt = $this->db->prepare("SELECT * FROM images");
        $results = $stmnt->execute();
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $res[] = $this->buildImageModel($row);
        }
        return $res;
    }


    private function buildImageModel(array $data) {
        return new Image($data);
    }
}