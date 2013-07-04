<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 * 
 * @property string $layoutTitle The layout title. Defaults to $this->pageTitle.
 */
class Controller extends CController
{
	
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
	
	protected function getAdminNames() {
		return array('clement@seizam.com','yann@seizam.com');
	}
	
	/**
	 * @return string the layout title. Defaults to the controller name and the action name.
	 */
	public function getLayoutTitle() {
		if($this->_layoutTitle!==null)
			return $this->_layoutTitle;
		else
			return $this->pageTitle;
	}

	/**
	 * @param string $value the page title.
	 */
	public function setLayoutTitle($value)
	{
		$this->_layoutTitle=$value;
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
			$items[] = array('label'=>'<i class="icon-signin"></i> Login',
			'url'=>array('user/login')
			);
		} else {
			$items[] = array('label'=>'<i class="icon-signout"></i> Logout',
			'url'=>array('user/logout')
			);
		}
		
		return $items;
	}
	
	/**
	 * @return string the HTML title
	 */
	protected function makePageTitle() {
		return $this->action->id . ' - ' . SHORT_BASE_URL;
	}
	
	protected function makeLayoutTitle() {
		return CHtml::link(SHORT_BASE_URL.'/'.$this->route, Yii::app()->homeUrl);
	}
	
	
	
	
}