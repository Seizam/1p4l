<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * 
 * @property string $layoutTitle The layout title. Defaults to $this->pageTitle.
 */
class Controller extends CController {

	/**
	 * @var string the title displayed within the layout (can be html)
	 */
	private $_layoutTitle;

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/main';

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();

	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();

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

		$message->from = Yii::app()->params['emailFrom'];
		$message->addTo($to);

		$message->view = $view;
		$message->setBody($body, 'text/html');

		return Yii::app()->mail->send($message);
	}

	/**
	 * @return string the layout title. Defaults to the controller name and the action name.
	 */
	public function getLayoutTitle() {
		if ($this->_layoutTitle !== null)
			return $this->_layoutTitle;
		else
			return $this->pageTitle;
	}

	/**
	 * @param string $value the page title.
	 */
	public function setLayoutTitle($value) {
		$this->_layoutTitle = $value;
	}

	/**
	 * Sets titles and Adds items to the menu
	 * 
	 * @param string $view the view to be rendered
	 * @return boolean whether the view should be rendered.
	 */
	public function beforeRender($view) {

		//TITLE
		$this->pageTitle = $this->makePageTitle();

		//LAYOUT TITLE
		$this->layoutTitle = $this->makeLayoutTitle();

		//MENU
		$this->menu = array_merge($this->menu, $this->makeMenuItems());

		return parent::beforeRender($view);
	}

	/**
	 * 
	 * @return array the menu items
	 */
	protected function makeMenuItems() {
		$items = array();
		if (Yii::app()->user->getIsGuest()) {
			$items['login'] = array('label' => '<i class="icon-signin"></i> LogIn',
				'url' => array('user/login')
			);
			$items['signup'] = array('label' => '<i class="icon-bolt"></i> SignUp',
				'url' => array('user/create'),
				'linkOptions' => array('class' => 'front'));
		} else {
			$items['signout'] = array('label' => '<i class="icon-signout"></i> LogOut',
				'url' => array('user/logout')
			);
			$items['mypage'] = array('label' => '<i class="icon-file"></i> My Page',
				'url' => array('page/index','imprint'=> $this->getUserImprint() ),
				'linkOptions' => array('class' => 'front'));
		}

		return $items;
	}

	/**
	 * @return string the HTML title
	 */
	protected function makePageTitle() {
		return $this->action->id . ' - ' . SHORT_BASE_URL;
	}

	/**
	 * 
	 * @return type
	 */
	protected function makeLayoutTitle() {
		return CHtml::link(SHORT_BASE_URL, Yii::app()->homeUrl);
	}
	
	/**
	 * @param null|int $id
	 * @return string The first imprint of a user
	 */
	public function getUserImprint($user_id = null) {
		if ($user_id == null) {
			$user_id = Yii::app()->user->id;
		}
		return User::model()->findByPk($user_id)->imprints[0]->imprint;
	}
	
	/**
	 * Get the QRCode image url and create it if necessary
	 * @param string $imprint The imprint as a STRING
	 * @param boolean $check Check if file exist (Default TRUE)
	 * @param boolean $force Force the creation (Default FALSE)
	 * @return string The QRCode url
	 * @todo Put somewhere better (dedicated controller ?)
	 * @todo Do not check if file exist all the time
	 */
	protected function getQRCodeUrl($imprint, $check = true, $force = false) {
		
		$containerFolder = realpath(Yii::app()->getBasePath().'/../qrcode');
		$fileName = $imprint . '.png';
		$filePath = realpath($containerFolder.'/'.$fileName);
		
		if (($check && !file_exists($filePath)) || $force) {
			$data = $this->createAbsoluteUrl('page/index', array('imprint' => $imprint));
			QRCodeGenerator::save(
					$data, // data
					realpath($containerFolder), // container folder
					$fileName ); // filename
		}
		
		$fileUrl = Yii::app()->baseUrl . '/qrcode/' . $imprint . '.png';
		
		return $fileUrl;
	}

}