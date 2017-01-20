<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class NotificationController
{
    /**
     * @Route("/notification", name="notification_process")
     */
    public function notificationAction($type = 'email', $data = '')
    {
		if( $data == '' || empty($data) )
		{
			$data = array(  'to' => 'abc@gmail.com',
							'from' => 'xyz@gmail.com',
							'title' => 'Notification!!!',
							'message' => 'This is notification message...',
							'recipient' => 'Mr. ABC' );
		}
		$notify = new Notification();
		$out = $notify->sendNotification($type, $data);

		return new Response(
            '<html><body><B>Notification Service</B><br>'.nl2br($out).'</body></html>'
        );
    }
}

class Notification
{
	public function sendNotification($type = '', $data)
	{
		$type = strtolower($type);
		switch($type)
		{
			case "email": 
				$notification = new EmailService($data);
				$ret = $notification->sendEmail();
				break;
			case "twitter":
				$notification = new TwitterService($data);
				$ret = $notification->sendTweet();
				break;
			case "sms":
				$notification = new SmsService($data);
				$ret = $notification->sendText();
				break;
			default:
				break;
		}

		return $ret;
	}
}

class EmailService
{
	var $_data;

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function sendEmail()
	{
		// Send email process here...
		$ret = '<B>Send Email to:</B> '.$this->_data['to']."\n";
		$ret .= '<B>Send from:</B> '.$this->_data['from']."\n";
		$ret .= '<B>Subject:</B> '.$this->_data['title']."\n";
		$ret .= '<B>Email body:</B> '.$this->_data['message']."\n";

		return $ret;
	}
}

class TwitterService
{
	var $_data;

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function sendTweet()
	{
		// Send Twitter process here...
		$ret = '<B>Send Twitter message:</B> '.$this->_data['message']."\n";

		return $ret;
	}
}

class SmsService
{
	var $_data;

	public function __construct($data)
	{
		$this->_data = $data;
	}

	public function sendText()
	{
		// Send SMS process here...
		$ret = '<B>Send SMS to:</B> '.$this->_data['recipient']."\n";
		$ret .= '<B>SMS message:</B> '.$this->_data['message']."\n";

		return $ret;
	}
}
