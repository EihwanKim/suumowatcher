<?php
/**
 * Created by PhpStorm.
 * User: eihwan
 * Date: 6/26/16
 * Time: 15:54
 */

namespace App\Shell;

use Cake\Console\Shell;
use App\Util\WatchSuumoSellUtil;
class WatchSuumoSellShell extends Shell
{
    public function main() {
        $utilSell = new WatchSuumoSellUtil();
        $utilSell->exec();
    }
}