<?php
/**
 * Created by PhpStorm.
 * User: eihwan
 * Date: 6/30/16
 * Time: 23:22
 */

namespace App\Util;

use Goutte\Client;
use Cake\ORM\TableRegistry;

class WatchSuumoSellUtil {

    //ターゲットページURL
    var $record;
    var $floor;
    const SLEEP_SECONDS = 2;

    public function exec() {

        $this->autoRender = false;
        $pageUrl = "http://suumo.jp/jj/bukken/ichiran/JJ010FJ001/?ar=030&bs=011&ra=030008&jspIdFlg=patternEki&rn=0760&rnek=076076150&kb=1&kt=9999999&mb=0&mt=9999999&ekTjCd=&ekTjNm=&tj=0&et=3&cnb=0&cn=9999999&srch_navi=1";

        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);

        //property_unit-content クラスリストを取得
        $crawler->filter('.property_unit-content')->each(function ($node) {

            //各要素を取得し $record へ格納
            $this->record = array();
            $this->record['title'] = trim($node->filter('h2')->text());
            $this->record['url']  = trim($node->filter('h2 a')->attr('href'));
            $node->filter('.dottable-line')->each(function($subNode) {

                $etc = preg_replace('/\s+/', '|', trim($subNode->text()));
                $this->record['etc'] = $etc;

                $key_value_array = explode('|', $etc);
                for ($i = 0 ; $i < count($key_value_array) ; $i++) {
                    //debug($key_value_array[$i]);
                    switch ($key_value_array[$i]) {
                        case '販売価格':
                            $this->record['price'] = str_replace('万円', '', $key_value_array[$i + 1]);
                            break;
                        case '所在地':
                            $this->record['place'] = $key_value_array[$i + 1];
                            break;
                        case '沿線・駅':
                            $this->record['access'] = $key_value_array[$i + 1];
                            break;
                        case '専有面積':
                            $this->record['width'] = $key_value_array[$i + 1];
                            break;
                        case '間取り':
                            $this->record['room_type'] = $key_value_array[$i + 1];
                            break;
                        case '築年月':
                            $this->record['build_date'] =  $key_value_array[$i + 1];
                            break;
                        default :
                            break;
                    }
                }
            });

            //TODO $record　のデータをDBへ格納
            $sellsTable = TableRegistry::get('Sells');
            $sell = $sellsTable->newEntity();
            $sell->title = $this->record['title'] ;
            $sell->url = $this->record['url'] ;
            $sell->price = $this->record['price'] ;
            $sell->place = $this->record['place'] ;
            $sell->access = $this->record['access'] ;
            $sell->width = $this->record['width'] ;
            $sell->room_type = $this->record['room_type'] ;
            $sell->build_date = $this->record['build_date'] ;
            $sell->etc = $this->record['etc'] ;
            $this->getFloor($this->record['url']);
            $sell->floor = $this->floor;
            $sell->created = date('Y-m-d H:i:s');

            $sellsTable->save($sell);

        });

    }

    private function getFloor($pageUrl) {

        if (!$pageUrl) {
            return;
        }

        sleep (self::SLEEP_SECONDS);

        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);

        $crawler->filter('table tr')->each(function ($node) {

            $etc = preg_replace('/\s+/', '|', trim($node->text()));
//            debug($etc);

            $key_value_array = explode('|', $etc);
            for ($i = 0 ; $i < count ($key_value_array) ; $i++) {
                if ($key_value_array[$i] == '所在階/構造・階建') {
                    $this->floor = $key_value_array[$i + 2];
                    return;
                }
            }
        });
    }

    public function info () {
        $this->autoRender = false;
        phpinfo();
    }

}
