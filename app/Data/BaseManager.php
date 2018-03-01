<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Data;

use App\Application;
use SQLite3;

class BaseManager {
    /**
     * @var Application
     */
    protected $app;
    /**
     * @var SQLite3
     */
    protected $db;

    public function __construct(Application $app) {
        $this->app = $app;
        $this->db = new SQLite3(__DIR__ . '/../../db/database.sqlite3');
    }

}