<?php
/**
 * Created by PhpStorm.
 * User: eihwan
 * Date: 7/3/16
 * Time: 11:55
 */

namespace App\Model\Table;


use Cake\ORM\Table;

class RentsTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }
}