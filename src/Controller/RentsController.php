<?php
/**
 * Created by PhpStorm.
 * User: eihwan
 * Date: 7/3/16
 * Time: 11:54
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class RentsController extends AppController
{
    public function period()
    {
        $rents = TableRegistry::get('Rents');
        $query = $rents->find('all');

        $query->select([
            'created',
            'count' => $query->func()->count('*')
        ])->group('created');

        if ($this->request->is('post')) {

            if ($this->request->data['from']) {
                $query->where(['created >=' => $this->request->data['from']]);
            }

            if ($this->request->data['to']) {
                $query->where(['created <=' => $this->request->data['to']]);
            }
        }



        $this->set(compact('query'));
    }
}