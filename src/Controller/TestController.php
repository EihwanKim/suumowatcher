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

        $rents = $this->loadModel('Rents');
        $query = $rents->find('all');
        $query->where(['id <= ' => 5]);
        $records = $query->toArray();

        $targetTime = strtotime('2016-01-01 00:00:00');

        for ($i = 0 ; $i < 365; $i++) {
            $created = date('Y-m-d', strtotime($i . ' day', $targetTime));
            foreach($records as $idx => $val) {

                $rent = $rents->newEntity();

                $rent->url = $val->url;
                $rent->title = $val->title;
                $rent->price = $val->price;
                $rent->kanri_charge = $val->kanri_charge;
                $rent->sikikin = $val->sikikin;
                $rent->reikin = $val->reikin;
                $rent->place = $val->place;
                $rent->access = $val->address;
                $rent->width = $val->width;
                $rent->room_type = $val->room_type;
                $rent->floor = $val->floor;
                $rent->build_date = $val->build_date;
                $rent->etc = $val->etc;
                $rent->created = $created;

                $rents->save($rent);
            }
        }

    }

    public function datetest() {

        $targetTime = strtotime('2016-01-01 00:00:00');

        $this->render('index');
    }
}
