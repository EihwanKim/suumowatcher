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

class WatchSuumoRentUtil {

    const SLEEP_SECONDS = 1;

    public function exec() {

        $this->autoRender = false;
        $pageUrl = "http://suumo.jp/jj/chintai/ichiran/FR301FC001/?ar=030&bs=040&ra=008&cb=0.0&ct=9999999&et=5&cn=9999999&mb=80&mt=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&fw2=&ek=076076150&rn=0760";

        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);

        //property_unit-content クラスリストを取得
        $crawler->filter('.cassetteitem_other a')->each(function ($node) {

            $text = trim($node->text());
            $href = trim($node->attr('href'));

            if ($text == '詳細を見る') {

                $record = $this->detail($href);

                if ($record) {
                    $rentsTable = TableRegistry::get('Rents');
                    $rent = $rentsTable->newEntity();

                    $rent->url = $record['url'];
                    $rent->title = $record['title'];
                    $rent->price = $record['price'];
                    $rent->kanri_charge = $record['kanri_charge'];
                    $rent->sikikin = $record['sikikin'];
                    $rent->reikin = $record['reikin'];
                    $rent->place = $record['place'];
                    $rent->access = $record['access'];
                    $rent->width = str_replace('m2', '', $record['width']);
                    $rent->room_type = $record['room_type'];
                    $rent->floor = $record['floor'];
                    $rent->build_date = $record['build_date'];
                    $rent->etc = $record['etc'];
                    $rent->created = $record['created'];
                    $rentsTable->save($rent);
                }
            }
        });

        $rents = TableRegistry::get('Rents');
        $query = $rents->find();
        $query->where(['created' => date('Y-m-d')])->order(['id' => 'ASC']);
        $records = $query->toArray();

        $email = new EmailUtil();
        $email->send_html_mail('watch_suumo_rent', $records, date('Y-m-d') . 'suumowatcher report RENT');
    }

    private function detail($pageUrl = '') {

        $this->autoRender = false;

        if (!$pageUrl) {
            return null;
        }

        sleep (self::SLEEP_SECONDS);

        $client = new Client();
        $crawler = $client->request('GET', $pageUrl);

        $record = array();
        $record['url'] = $pageUrl;
        $record['title'] = $crawler->filter('h1')->text();
        $detail_str = preg_replace('/\s+/', '|', trim($crawler->filter('.detailinfo')->text()));
        $record['etc'] = $detail_str;
        $detail_array = explode('|', $detail_str);
        $record['price'] = str_replace('万円', '', $detail_array[0]);
        $record['kanri_charge'] = str_replace('円', '', $detail_array[2]) / 10000;
        $record['sikikin'] = str_replace('万円', '', $detail_array[4]);
        $record['reikin'] = str_replace('万円', '', $detail_array[6]);
        $record['place'] = $detail_array[16];
        $access = str_replace('[乗り換え案内]', '', trim($crawler->filter('.detailnote-value-list')->text()));
        $record['access'] = str_replace(array("\r\n", "\r", "\n"), '', $access);
        $record['width'] = $detail_array[12];
        $record['room_type'] = $detail_array[11];
        $gaiyo_str = $crawler->filter('.data_table')->text();
        $gaiyo_str = preg_replace('/\s+/', '|', trim($gaiyo_str));
        $gaiyo_array = explode('|', $gaiyo_str);
        for ($i = 0 ; $i < count($gaiyo_array); $i++) {
            if ($gaiyo_array[$i] == '階建') {
                $record['floor'] = $gaiyo_array[$i + 1];
                continue;
            }
            if ($gaiyo_array[$i] == '築年月') {
                $record['build_date'] = $gaiyo_array[$i + 1];
                continue;
            }

        }
        $record['created'] = date('Y-m-d');
        return $record;
    }

}
