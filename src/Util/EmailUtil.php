<?php
/**
 * Created by PhpStorm.
 * User: eihwan
 * Date: 7/1/16
 * Time: 08:21
 */

namespace App\Util;

use Cake\Mailer\Email;
use Cake\ORM\Rents;

class EmailUtil
{

    public function send_html_mail($template, $viewVars, $title = 'suumowatcher report', $to = 'cloz2me@gmail.com') {
        
        $email = new Email('default');
        $email->from(['eihwan.kim@gmail.com' => 'suumowatcher'])
            ->to($to)
            ->subject($title)
            ->template($template)
            ->viewVars(array('vars' => $viewVars))
            ->emailFormat('html')
            ->send();
    }
}