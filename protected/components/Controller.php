<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * Sends an email from <code>Yii::app()->params['emailFrom']</code>
	 * @param string $to The To address(es).
	 * @param string $view The view to use for rendering the body.
	 * @param mixed $body The body of the message.  If this is a string, this is
	 * passed to the view as $body. If this is an array, the array values are 
	 * passed to the view like in the controller render() method.
	 * <br /><b>Note:</b> an extra variable $mail will be passed to the view 
	 * which you may use to set e.g. the email subject from within the view
	 * @return int The return value is the number of recipients who were
	 * accepted for delivery.
	 * <br /><b>Simple error test for 1 recipient :</b>
	 * <code>if (!sendEmail(...)) { ERROR } else { OK }</code>
	 */
	protected function sendEmail($to, $view, $body = '') {

		$message = new YiiMailMessage;

		$message->view = $view;
		$message->setBody($body, 'text/html');

		$message->from = Yii::app()->params['emailFrom'];
		$message->addTo($to);

		return Yii::app()->mail->send($message);
	}
}