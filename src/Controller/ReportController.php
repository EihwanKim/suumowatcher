<?php
/**
 * Created by PhpStorm.
 * User: eihwan
 * Date: 7/3/16
 * Time: 11:54
 */

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ReportController extends AppController
{
    public function rent() {

        $rents = TableRegistry::get('Rents');
        $query = $rents->find()->orderAsc('url')->orderAsc('created');

        if ($this->request->is('post')) {

            if ($this->request->data['from']) {
                $query->where(['created >=' => $this->request->data['from']]);
            }

            if ($this->request->data['to']) {
                $query->where(['created >=' => $this->request->data['from']]);
            }
        }

        $records = $query->toArray();

        $graphData = [];
        $data = [];
        foreach($records as $key => $value) {

            array_push($data, [$value->created->getTimestamp() * 1000, floatval($value->price)]);

            if ($value->url != $records[$key + 1]['url']) {
                array_push($graphData, [
                    'name' => $records[$key]['width'] . ' | ' .
                            $records[$key]['room_type']  . ' | ' .
                            $records[$key]['floor'],
                    'data' =>$data
                ]);

                $data = [];
            }

        }

        $graphJson = json_encode($graphData);
        $this->set(compact('graphJson'));

    }

    public function sell() {

        $rents = TableRegistry::get('Sells');
        $query = $rents->find()->orderAsc('url')->orderAsc('created');

        if ($this->request->is('post')) {

            if ($this->request->data['from']) {
                $query->where(['created >=' => $this->request->data['from']]);
            }

            if ($this->request->data['to']) {
                $query->where(['created >=' => $this->request->data['from']]);
            }
        }

        $records = $query->toArray();

        $graphData = [];
        $data = [];
        foreach($records as $key => $value) {

            array_push($data, [$value->created->getTimestamp() * 1000, floatval($value->price)]);

            if ($value->url != $records[$key + 1]['url']) {
                array_push($graphData, [
                    'name' =>
                        $records[$key]['title'] . ' | ' .
                        $records[$key]['width'] . ' | ' .
                        $records[$key]['room_type']  . ' | ' .
                        $records[$key]['floor'],
                    'data' =>$data
                ]);

                $data = [];
            }

        }

        $graphJson = json_encode($graphData);
        $this->set(compact('graphJson'));

    }

}