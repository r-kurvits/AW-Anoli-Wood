<?php
namespace app\helpers;

use Yii;
use app\models\UserAssociationSettings;

class EmailHelper
{
    public static function SendMail($sendToEmail, $subject, $textBody, $htmlBody = null, $user = null, $settingNameRequired = null) {

        $systemEmail = Yii::$app->params['senderEmail'];

        $sanitizedFrom = self::SantizeEmailAddress($systemEmail);
        $sanitizedTo = self::SantizeEmailAddress($sendToEmail);
        
        if(!self::AreEmailAdressesValid($sanitizedFrom, $sanitizedTo)){
            return;
        }

        if(!$htmlBody) $htmlBody = $textBody;

        Yii::$app->mailer->compose()
            ->setFrom($sanitizedFrom)
            ->setTo($sanitizedTo)
            ->setSubject($subject)
            ->setTextBody($textBody)
            ->setHtmlBody($htmlBody)
            ->send();
    }

    public static function SendMailFrom($senderEmail, $sendToEmail, $subject, $textBody, $htmlBody = null, $user = null, $settingNameRequired = null) {
        if(!$htmlBody) $htmlBody = $textBody;

        $sanitizedFrom = self::SantizeEmailAddress($senderEmail);
        $sanitizedTo = self::SantizeEmailAddress($sendToEmail);
        
        if(!self::AreEmailAdressesValid($sanitizedFrom, $sanitizedTo)){
            return;
        }

        Yii::$app->mailer->compose()
            ->setFrom($sanitizedFrom)
            ->setTo($sanitizedTo)
            ->setSubject($subject)
            ->setTextBody($textBody)
            ->setHtmlBody($htmlBody)
            ->send();
    }

    public static function SantizeEmailAddress($email) {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    public static function AreEmailAdressesValid($email, $secondEmail) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) && filter_var($secondEmail, FILTER_VALIDATE_EMAIL);
    }
}