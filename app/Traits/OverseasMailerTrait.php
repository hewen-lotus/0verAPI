<?php
/**
 * Created by PhpStorm.
 * User: zxp86021
 * Date: 2017/6/28
 * Time: 上午 9:18
 */

namespace App\Traits;

use Swift_SmtpTransport;
use Swift_Mailer;
use Mail;

trait OverseasMailerTrait
{
    public function mailer()
    {
        $transport = Swift_SmtpTransport::newInstance(
            \Config::get('mail.host'),
            \Config::get('mail.port'),
            \Config::get('mail.encryption'))
            ->setUsername(\Config::get('mail.username'))
            ->setPassword(\Config::get('mail.password'))
            ->setStreamOptions(['ssl' => \Config::get('mail.ssloptions')]);

        $mailer = Swift_Mailer::newInstance($transport);

        Mail::setSwiftMailer($mailer);
    }
}