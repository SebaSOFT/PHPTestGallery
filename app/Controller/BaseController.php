<?php
/**
 * User: SebaSOFT
 * Date: 1/3/2018
 */

namespace App\Controller;


use App\Application;

class BaseController {
    /**
     * @var Application|null
     */
    protected $app = null;

    public function __construct(Application $app) {
        $this->app = $app;
    }
}