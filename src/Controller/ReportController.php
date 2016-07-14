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

            if ($this->request->data['createdFrom']) {
                $query->where(['created >=' => $this->request->data['createdFrom']]);
            }

            if ($this->request->data['createdTo']) {
                $query->where(['created <=' => $this->request->data['createdTo']]);
            }

            if ($this->request->data['widthFrom']) {
                $query->where(['width >=' => floatval($this->request->data['widthFrom'])]);
            }

            if ($this->request->data['widthTo']) {
                $query->where(['width <=' => floatval($this->request->data['widthTo'])]);
            }

        }

        $records = $query->toArray();

        $graphData = [];
        $data = [];
        $min = 9999999999.0;

        foreach($records as $key => $value) {

            if ($min > $value->price) {
                $min = $value->price;
            }
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

        $min = floor($min/10) * 10;
        $graphJson = json_encode($graphData);
        $this->set(compact('graphJson'));
        $this->set(compact('min'));

    }

    public function sell() {

        $rents = TableRegistry::get('Sells');
        $query = $rents->find()->orderAsc('url')->orderAsc('created');

        if ($this->request->is('post')) {

            if ($this->request->data['createdFrom']) {
                $query->where(['created >=' => $this->request->data['createdFrom']]);
            }

            if ($this->request->data['createdTo']) {
                $query->where(['created <=' => $this->request->data['createdTo']]);
            }

            if ($this->request->data['widthFrom']) {
                $query->where(['width >=' => $this->request->data['widthFrom']]);
            }

            if ($this->request->data['widthTo']) {
                $query->where(['width <=' => $this->request->data['widthTo']]);
            }
        }

        $records = $query->toArray();

        $graphData = [];
        $data = [];
        $min = 9999999999.0;
        foreach($records as $key => $value) {

            array_push($data, [$value->created->getTimestamp() * 1000, floatval($value->price)]);

            if ($min > $value->price) {
                $min = $value->price;
            }
            if ($value->url != $records[$key + 1]['url']) {
                array_push($graphData, [
                    'tooltip' =>$records[$key]['url'],
                    'name' =>
                        $records[$key]['title'] . ' | ' .
                        $records[$key]['width'] . 'm2 | ' .
                        $records[$key]['room_type']  . ' | ' .
                        $records[$key]['floor'],
                    'data' =>$data
                ]);

                $data = [];
            }

        }

        $min = floor($min/1000) * 1000;

        $graphJson = json_encode($graphData);
        $this->set(compact('graphJson'));
        $this->set(compact('min'));

    }
}