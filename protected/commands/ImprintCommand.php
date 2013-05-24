<?php


/**
 * Extended yii console command
 *
 * @author: radzserg
 * @date: 11.04.11
 */
class ImprintCommand extends CConsoleCommand {

	/**
	 * Verbose output ?
	 * @var boolean 
	 */
	public $verbose = true;

	/*
	 * @var microtime
	 */
	protected $_timeStart;

	/**
	 * Few constants for logging
	 */

	const VERBOSE_ERROR = 'error';
	const VERBOSE_INFO = 'info';
	const VERBOSE_SYSTEM = 'system';

	/**
	 * 
	 * @param string $message
	 * @param int $level
	 * @param string $type
	 * @return type
	 */
	protected function verbose($message, $level = 0, $type = self::VERBOSE_INFO) {
		if (!$this->verbose) {
			return;
		}

		$level = (int) $level;
		$indent = str_repeat("\t", $level);
		if ($type == self::VERBOSE_ERROR) {
			// message in red
			$message = "\033[31;1m" . $message . "\033[0m\n";
		} elseif ($type == self::VERBOSE_INFO) {
			// message in green
			$message = "\033[32;1m" . $message . "\033[0m\n";
		} elseif ($type == self::VERBOSE_SYSTEM) {
			$message = "\033[33;1m" . $message . "\033[0m\n";
		}

		echo $indent . date('H:i:s ') . $message . "\n";
	}

	/**
	 * 
	 */
	protected function beforeAction($action, $params) {
		$this->verbose("Start execution of " . get_class($this), null, self::VERBOSE_SYSTEM);
		$this->_timeStart = microtime(true);
		return true;
	}

	protected function afterAction($action, $params, $exitCode = 0) {
		$time = round((microtime(true) - $this->_timeStart) * 1000, 3);
		$this->verbose("End (time: {$time} milliseconds)", null, self::VERBOSE_SYSTEM);
	}

	protected function checkPoint($string) {
		$time = round((microtime(true) - $this->_timeStart) * 1000, 3);
		$this->verbose("$string Checkpoint (time: {$time} milliseconds)", null, self::VERBOSE_SYSTEM);
	}

	/**
	 * Just the base
	 * @return int
	 */
	public function actionIndex($init = null, $iterations = null, $target = null, $write = 100, $insert = false) {
		
		require_once dirname(__FILE__).'/../components/ImprintHelper.php';
		require_once dirname(__FILE__).'/../models/Imprint.php';
		
		$imprintHelper = ImprintHelper::newImprintHelper();
		
		$this->checkPoint('Before Init');

		$firstImprint = $imprintHelper->initialize($init);

		$this->verbose("Starting from Imprint $firstImprint", 0, self::VERBOSE_SYSTEM);
		
		$this->checkPoint('Before Setup');

		if ($target === null & $iterations === null) {
			$target = 1;
			$this->verbose("Target automatically set to 1. Add --iterations=N OR --target=M", 0, self::VERBOSE_INFO);
		}
		
		if ($iterations !== null) {
			$imprintHelper->getImprintator()->setMaxIterations($iterations);
		}
		$this->verbose("Max Iterations = {$imprintHelper->getImprintator()->getMaxIterations()}", 0, self::VERBOSE_SYSTEM);

		if ($target !== null) {
			$imprintHelper->getImprintator()->setTarget($target);
		}
		$this->verbose("Target Imprints = {$imprintHelper->getImprintator()->getTarget()}", 0, self::VERBOSE_SYSTEM);
		
		$imprintHelper->getImprintator()->setWrite($write);
		
		$this->checkPoint('Before Iterate');
		
		$this->verbose("THE IMPRINTS :\n         Displaying 1 every $write", 0, self::VERBOSE_INFO);
		
		$imprintHelper->run();

		$this->verbose($imprintHelper->getStats(), 0, self::VERBOSE_INFO);

		if ($insert) {
			$this->checkPoint('Before Insert');
			$rows = $imprintHelper->insert();
			if ($rows > 0) {
				$this->verbose("$rows rows inserted to DB", 0, self::VERBOSE_INFO);
				return 0;
			} else {
				$this->verbose("DB INSERTION FAILED", 0, self::VERBOSE_ERROR);
				return 1;
			}
		} else {
			$this->verbose("Not inserted in DB. Add --insert=true.", 0, self::VERBOSE_ERROR);
			return 1;
		}
	}

}