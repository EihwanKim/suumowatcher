<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * Class WatchSuumoController
 * @package App\Controller
 */
class TestController extends AppController
{
    public function index() {

        $query = TableRegistry::get('Sells');
        $sells = $query->find()->select('width')->toArray();

        foreach($sells as $sell) {
            debug($sell->width);
            debug($this->getWidthNum($sell->width));
            $sell->width = $this->getWidthNum($sell->width);
            $query->updateAll($sell, ['Sells.id' => $sell->id]);
        }
    }

    private function getWidthNum($str) {

        return substr($str, 0, strpos($str, '（'));
    }


}
