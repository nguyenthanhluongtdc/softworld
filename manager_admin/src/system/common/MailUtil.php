<?php
/*
*	メール送信共通
*	swiftmailerライブラリーの実装します
*/
require_once ROOT_PATH_LIBRARY . '/swiftmailer/lib/swift_required.php';

class MailUtil {

	private static $mMailer = null; 
    
    public static function getInstance() {
    	if(MailUtil::$mMailer == null) {
	        Swift::init(function () {
	            Swift_DependencyContainer::getInstance()
	                    ->register(AppConfig::$MAIL_SETTING["MAIL_ITEM_NAME"])
	                    ->asAliasOf(AppConfig::$MAIL_SETTING["MAIL_LOOK_UP"]);
	            Swift_Preferences::getInstance()->setCharset(AppConfig::$MAIL_SETTING["MAIL_CHARSET"]);
	        });
	        
	        // Create the SMTP configuration
	        $transport = Swift_SmtpTransport::newInstance(
	        	AppConfig::$MAIL_SETTING["MAIL_IP"]
	        	, AppConfig::$MAIL_SETTING["MAIL_PORT"]
	        	, AppConfig::$MAIL_SETTING["MAIL_SECURITY"]
	        );
	        $transport->setUsername(AppConfig::$MAIL_SETTING["MAIL_USERNAME"]);
	        $transport->setPassword(AppConfig::$MAIL_SETTING["MAIL_PASSWORD"]);
	        
	        // Create the Mailer using your created Transport
	        MailUtil::$mMailer = Swift_Mailer::newInstance($transport);
    	}
    	return MailUtil::$mMailer;
    }        
            
    public static function sendMail($to, $subject, $body, $params = null) {
        if(isset($params)) {
            $isNotAttach = true;
        	if(array_key_exists("subject", $params) && is_array($params["subject"])) {
                $isNotAttach = false;
        		$subject = MailUtil::putDataToMailTemplate($subject, $params["subject"]);
        	} 
            if(array_key_exists("body", $params) && is_array($params["body"])) {
                $isNotAttach = false;
        		$body = MailUtil::putDataToMailTemplate($body, $params["body"]);
        	} 

            if($isNotAttach && is_array($params)) {
        		$body = MailUtil::putDataToMailTemplate($body, $params);
        	}
        }
        // Create the message
        $message = Swift_Message::newInstance();

        // Give the message a subject
        $message->setSubject($subject);

        // Set the From address with an associative array
        $message->setFrom(
        	array(
        		AppConfig::$MAIL_SETTING["MAIL_FROM"] => AppConfig::$MAIL_SETTING["MAIL_SENDER_NAME"]
        	)
        );

        // Set the To addresses with an associative array
        $message->setTo(array($to));

        // Give it a body
        $message->setBody($body);

        // Send the message!
        $result = MailUtil::getInstance()->send($message);
        
        return $result;
    }
    
    private static function putDataToMailTemplate($template, $data) {
        foreach($data as $key => $value) {
            $template = str_replace($key , $value, $template);
        }
        
        return $template;
    }
}


?>