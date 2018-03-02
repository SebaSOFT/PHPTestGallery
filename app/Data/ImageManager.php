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
     * @return bool
     */
    public function addImage(Image $img) {
        if (is_null($img)) {
            return false;
        }
        $insert = "INSERT INTO images (file, filename, size, description) VALUES (:file, :filename, :size, :desc)";
        $stmt = $this->db->prepare($insert);

        $column1 =  $img->getFile();
        $stmt->bindParam(':file', $column1);
        $column2 =  $img->getFilename();
        $stmt->bindParam(':filename', $column2);
        $column3 =  $img->getSize();
        $stmt->bindParam(':size', $column3);
        $column4 =  $img->getDescription();
        $stmt->bindParam(':desc', $column4);

        $result = $stmt->execute();
        return ($result !== FALSE);
    }

    /**
     * @param $id
     * @return Image|null
     */
    public function getImage($id) {
        $result = $this->db->querySingle(
            'SELECT * FROM images WHERE id = ' .
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
     * @return bool
     */
    public function deleteImage($id) {
        return $this->db->exec(
            'DELETE FROM images WHERE id = ' .
            filter_var($id, FILTER_SANITIZE_NUMBER_INT)
        );
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