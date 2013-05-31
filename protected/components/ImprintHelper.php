<?php

/**
 * ImprintHelper class file.
 *
 * @author Clément Dietschy <clement@seizam.com>
 * @link http://www.seizam.com/
 * @license GPL3
 */

class ImprintHelper {
	/**
	 * The iterator
	 * @var Imprintator 
	 */
	private $imprintator;
	
	/**
	 * The alphabet
	 * @var ImprintAlphabet 
	 */
	private $alphabet;
	
	/**
	 * The collection
	 * @var ImprintCollection 
	 */
	private $collection;
	
	/**
	 * 
	 */
	private function __construct() {
		$this->alphabet = ImprintAlphabet::newAlphabet();
	}
	
	/**
	 * 
	 * @return \ImprintHelper
	 */
	public static function newImprintHelper() {
		return new ImprintHelper();
	}
	
	
	public function initialize($string = null) {
		if ($string === null) $string = $this->getLastImprint ();
		
		$this->imprintator = Imprintator::newFromString($string, $this->alphabet);
		
		return $this->imprintator->toString();
	}
	
	private function getLastImprint() {
		$imprint = Imprint::model()->lastAutomatic()->find();
		return $imprint->imprint;
	}
	
	/**
	 * Runs the whole chabang
	 */
	public function run() {
		$this->collection = $this->imprintator->run();
	}
	
	public function insert() {
		$return = 0;
		foreach ($this->collection->chunk(1000) as $collection) {
			$return += $this->insertCollection($collection);
			echo "$return ";
		}
		echo "\n\n";
		return $return;
	}
	
	/**
	 * Insert in the DB
	 */
	private function insertCollection($collection) {
		$sql = 'INSERT INTO  `1p4l`.`imprint` (`id`,`user_id`,`imprint`,`type`,`state`) VALUES '.$collection->getSQLValues().';';
		$command = Yii::app()->db->createCommand($sql);
		$return = $command->execute();
		return $return;
	}
	
	public function getStats() {
		return "Found {$this->imprintator->getValidated()} imprints\n
         In {$this->imprintator->getIterations()} iterations\n
         From a total space of {$this->imprintator->getSpace()}\n
         Resulting in space usage of {$this->imprintator->getSpaceUsage()}%";
	}
	
	/**
	 * 
	 * @return Imprintator
	 */
	public function getImprintator() {
		return $this->imprintator;
	}
}

/**
 * Rules of Imprint Generation
 * 
 * 1. As short as possible (= as dense as possible)
 * 2. No 2 symbol alike (0Oo IilL1 5Ss 8Bb 2Zz...)
 * 3. No symbol following itself (aa bb 33...)
 * 4. At least 2 letters
 * 5. At least 2 numbers
 * 
 */
class Imprintator {

	/**
	 * The array of $size characters representing the current imprint
	 * @var ImprintCharacter[]
	 */
	private $imprint = array();

	/**
	 * The size of the $imprint array
	 * @var int 
	 */
	private $size = 0;

	/**
	 * @var ImprintAlphabet
	 */
	private $alphabet;

	/**
	 *
	 * @var int 
	 */
	private $iterations = 0;

	/**
	 *
	 * @var int 
	 */
	private $maxIterations = 1000000;

	/**
	 * @var int;
	 */
	private $target = 1000000;

	/**
	 *
	 * @var int 
	 */
	private $validated = 0;
	
	/**
	 *
	 * @var int 
	 */
	private $space = 0;

	/**
	 * The colums to jump next iteration
	 * @var int 
	 */
	private $jump = null;
	
	/**
	 *
	 * @var ImprintCollection 
	 */
	private $collection = null;
	
	/**
	 * @var int;
	 */
	private $write = 100;

	/**
	 * 
	 * @param array $imprint
	 */
	private function __construct($imprint, $alphabet) {
		$this->imprint = $imprint;
		$this->size = count($imprint);
		$this->alphabet = $alphabet;
		$this->collection = ImprintCollection::newImprintCollection();
	}

	/**
	 * 
	 * @param ImprintCharacter[] $imprint
	 * @return \Imprintator
	 */
	public static function newFromArray($imprint, $alphabet) {
		return new Imprintator($imprint, $alphabet);
	}

	/**
	 * 
	 * @param string $imprint
	 * @return \Imprintator
	 */
	public static function newFromString($string, $alphabet) {
		$array = str_split(trim($string));
		$imprint = array();
		foreach ($array as $i => $character) {
			$imprint[$i] = ImprintCharacter::newFromCharacter($alphabet, $character);
		}
		return new Imprintator($imprint, $alphabet);
	}

	public static function newFromZero($alphabet) {
		$imprint = array();
		$imprint[] = ImprintCharacter::newFromCharacter($alphabet);
		return new Imprintator($imprint, $alphabet);
	}

	/**
	 * 
	 * @param int $int
	 */
	public function setMaxIterations($int = 1000000) {
		$this->maxIterations = $int;
	}

	/**
	 * 
	 * @param int $int
	 */
	public function setTarget($int = 1000000) {
		$this->target = $int;
	}
	
	/**
	 * 
	 * @param int $int
	 */
	public function setWrite($int = 100) {
		$this->write = $int;
	}

	/**
	 * DO IT !
	 */
	public function run() {
		$intStart = $this->toInt();
		$this->iterate();
		$this->space = $this->toInt() - $intStart;
		return $this->collection;
	}
	
	public function getSpace() {
		return $this->space;
	}
	
	public function getValidated() {
		return $this->validated;
	}
	
	public function getSpaceUsage() {
		return round($this->validated/$this->space * 100, 2);
	}
	
	public function getIterations() {
		return $this->iterations;
	}
	

	/**
	 * Validate the imprint
	 * @return boolean
	 */
	private function validate() {
		return $this->validateNoFollow() && $this->validateNumbers(1);
	}

	/**
	 * Validate the rule "No symbol following itself (aa bb 33...) "
	 * @return boolean
	 */
	private function validateNoFollow() {
		for ($column = 0; $column <= $this->size - 2; $column++) {
			if (!$this->validateColumn($column)) {
				$this->setJump($column + 1);
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 
	 * @param int $column
	 */
	private function validateColumn($column) {
		if ($this->imprint[$column]->isNumber() && $this->imprint[$column+1]->isNumber()) {
			return false;
		} elseif ($this->imprint[$column]->equals($this->imprint[$column+1])) { //isLetter
			return false;
		}
		return true;
	}

	/**
	 * Validate the rule "At least $min letters"
	 * @return boolean
	 */
	private function validateLetters($min = 0) {
		if ($min == 0) return true;
		
		$count = 0;
		foreach ($this->imprint as $character) {
			if ($character->isLetter()) {
				$count++;
			}
		}
		return $count >= $min;
	}

	/**
	 * Validate the rule "At least $min numbers"
	 * @return boolean
	 */
	private function validateNumbers($min = 0) {
		if ($min == 0) return true;
		
		$count = 0;
		foreach ($this->imprint as $character) {
			if ($character->isNumber()) {
				$count++;
			}
		}
		return $count >= $min;
	}

	/**
	 * Validate the rule "Starts with a letter"
	 * @return type
	 */
	private function validateStartWithLetter() {
		if ($this->imprint[0]->isLetter()) {
			return true;
		} else {
			$this->setJump(0);
			return false;
		}
	}

	/**
	 * 
	 * @param int $jump
	 */
	private function setJump($jump = null) {
		if ($this->jump == null || $jump < $this->jump)
			$this->jump = $jump;
	}

	/**
	 * Set the jump to null
	 */
	private function resetJump() {
		$this->jump = null;
	}

	/**
	 * Iterator bis
	 */
	private function iterate() {
		while ($this->iterations++ < $this->maxIterations && $this->validated < $this->target) {
			$this->jump();
			if ($this->validate()) {
				$this->write();
				$this->validated++;
			}
		}
		echo "\n\n";
	}
	
	private function write() {
		$string = $this->toString();
		$this->collection->addImprint($string);
		if ($this->write != 0 && $this->validated%$this->write == 0) {
			echo "$string ";
		}
	}

	/**
	 * Increments the last column
	 * @param int $i
	 */
	private function increment($column = null) {
		if ($column === null)
			$column = $this->size - 1;

		if ($this->imprint[$column]->increment()) {
			if ($column == 0) {
				$this->size = array_unshift($this->imprint, ImprintCharacter::newFromCharacter($this->alphabet));
				$column = 1;
			}
			$this->increment($column - 1);
		}
	}

	/**
	 * Increments the $this->jump column 
	 * @param int $i
	 */
	private function jump() {
		if ($this->jump === null) {
			$this->increment();
		} else {
			$this->reset($this->jump);
			$this->increment($this->jump);
		}
		$this->resetJump();
	}

	/**
	 * Reset to 0 the columns after $i
	 * @param type $i
	 */
	private function reset($i = -1) {
		for ($j = $i + 1; $j < $this->size; $j++) {
			$this->imprint[$j]->reset();
		}
	}

	/**
	 * Convert imprint to string
	 * @return string
	 */
	public function toString() {
		$string = '';
		foreach ($this->imprint as $character) {
			$string .= $character->getCharacter();
		}
		return $string;
	}
	
	/**
	 * Convert imprint to int
	 */
	public function toInt() {
		$int = 0;
		foreach ($this->imprint as $column => $character) {
			$pow = $this->size - $column - 1;
			$int += $character->getInteger()*pow($this->alphabet->getCount(),$pow);
		}
		return $int;
	}
	
	public function getMaxIterations() {
		return $this->maxIterations;
	}
	
	public function getTarget() {
		return $this->target;
	}

}

class ImprintCollection {
	/**
	 * @var string[] 
	 */
	private $imprints = array();
	
	/**
	 * 
	 */
	private function __construct($imprints = null) {
		if ($imprints === null) $this->imprints = array();
		else $this->imprints = $imprints;
	}
	
	/**
	 * 
	 * @return \ImprintCollection
	 */
	public static function newImprintCollection($imprints = null) {
		return new ImprintCollection($imprints);
	}
	
	public function addImprint($string) {
		$this->imprints[] = $string;
	}
	
	public function setImprints($array) {
		$this->imprints = $array;
	}
	
	public function getSQLValues() {
		$sql = '';
		
		foreach ($this->imprints as $imprint) {
			$sql .= self::getSQLValue($imprint).',';
		}
		
		$sql = rtrim($sql, ',');
		
		return $sql;
	}
	
	/**
	 * 
	 * @param string $imprint
	 * @return string
	 */
	private static function getSQLValue($imprint) {
		$sql = '(';
		
		$fields = array('null','null','"'.$imprint.'"', Imprint::$IMPRINT_TYPE_AUTOMATIC, Imprint::$IMPRINT_STATE_READY);
		foreach ($fields as $field) {
			$sql .= $field.',';
		}
		
		$sql = rtrim($sql, ',').')';
		
		return $sql;
	}
	
	/**
	 * 
	 * @param int $factor
	 */
	public function getString($factor = 500) {
		foreach ($this->imprints as $id => $string) {
			if ($id%$factor==0) {
				echo "$string ";
			}
		}
	}
	
	public function getSize() {
		return count($this->imprints);
	}
	
	public function chunk($size = 1000) {
		$arrays = array_chunk($this->imprints, $size);
		$collections = array();
		foreach ($arrays as $array) {
			$collections[] = self::newImprintCollection($array);
		}
		return $collections;
	}
}

class ImprintAlphabet {

	/**
	 * The N allowed numbers
	 * @var char[] 
	 */
	private $numbers = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

	/**
	 * N
	 * @var int 
	 */
	private $numberCount;

	/**
	 * The M allowed letters
	 * @var char[] 
	 */
	private $letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'j', 'k', 'm', 'n', 'p', 'q', 'r', 't', 'v', 'w', 'x', 'y');

	/**
	 * M
	 * @var int
	 */
	private $letterCount;

	/**
	 * The N+M allowed characters
	 * @var char[] 
	 */
	private $characters = array();

	/**
	 * N+M
	 * @var type 
	 */
	private $characterCount;

	/**
	 * 
	 * @param char[] $numbers
	 * @param char[] $letters
	 */
	private function __construct($numbers = null, $letters = null) {
		if ($numbers !== null)
			$this->numbers = $numbers;
		if ($letters !== null)
			$this->letters = $letters;

		$this->numberCount = count($this->numbers);
		$this->letterCount = count($this->letters);
		$this->characters = array_merge($this->numbers, $this->letters);
		$this->characterCount = count($this->characters);
	}

	/**
	 * 
	 * @param char[] $numbers
	 * @param char[] $letters
	 * @return \ImprintAlphabet
	 */
	public static function newAlphabet($numbers = null, $letters = null) {
		return new ImprintAlphabet($numbers, $letters);
	}

	/**
	 * 
	 * @param char $character
	 * @return int
	 */
	public function getIntegerFromCharacter($character) {
		$integer = array_search(strtolower($character), $this->characters);
		if ($integer === false)
			throw new CException('Character is not in the Alphabet');
		return $integer;
	}

	/**
	 * 
	 * @param int $integer
	 * @return char
	 */
	public function getCharacterFromInteger($integer) {
		return $this->characters[$integer];
	}

	/**
	 * @param int $integer
	 */
	public function isNumber($integer) {
		return $integer < $this->numberCount;
	}

	/**
	 * 
	 * @param int $integer
	 * @return boolean
	 */
	public function isLetter($integer) {
		return !$this->isNumber($integer);
	}

	/**
	 * 
	 * @param int $integer
	 * @return boolean
	 */
	public function validate($integer) {
		return $integer >= 0 && $integer < $this->characterCount;
	}

	/**
	 * 
	 * @return int
	 */
	public function getCount() {
		return $this->characterCount;
	}

}

class ImprintCharacter {

	/**
	 * The alphabet
	 * @var ImprintAlphabet 
	 */
	private $alphabet;

	/**
	 * The character as an integer
	 * @var int 
	 */
	private $integer;

	/**
	 * 
	 * @param ImprintAlphabet $alphabet
	 * @param int $integer
	 */
	private function __construct($alphabet, $integer) {

		$this->alphabet = $alphabet;
		$this->integer = $integer;
	}

	/**
	 * 
	 * @param ImprintAlphabet $alphabet
	 * @param Int $integer
	 * @return \ImprintCharacter
	 */
	public static function newFromInteger($alphabet, $integer = 0) {
		return new ImprintCharacter($alphabet, $integer);
	}

	/**
	 * 
	 * @param ImprintAlphabet $alphabet
	 * @param char $character
	 * @return \ImprintCharacter
	 */
	public static function newFromCharacter($alphabet, $character = null) {
		if ($character === null)
			return self::newFromInteger($alphabet);

		$integer = $alphabet->getIntegerFromCharacter($character);
		return new ImprintCharacter($alphabet, $integer);
	}

	/**
	 * 
	 * @param ImprintAlphabet $alphabet
	 * @param mixed $guess
	 * @return \ImprintCharacter
	 */
	public static function newFromGuess($alphabet, $guess) {
		if (is_int($guess))
			return self::newFromInteger($alphabet, $guess);
		else
			return self::newFromCharacter($alphabet, $guess);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isNumber() {
		return $this->alphabet->isNumber($this->integer);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function isLetter() {
		return $this->alphabet->isLetter($this->integer);
	}

	/**
	 * 
	 * @return boolean
	 */
	public function validate() {
		return $this->alphabet->validate($this->integer);
	}

	/**
	 * 
	 * @param ImprintCharacter $character
	 */
	public function equals($character) {
		return $this->integer === $character->getInteger();
	}

	/**
	 * 
	 * @return int
	 */
	public function getInteger() {
		return $this->integer;
	}

	/**
	 * 
	 * @return char
	 */
	public function getCharacter() {
		return $this->alphabet->getCharacterFromInteger($this->integer);
	}

	/**
	 * @return boolean true if back to 0
	 */
	public function increment() {

		$this->integer++;
		if ($this->integer == $this->alphabet->getCount()) {
			$this->integer = 0;
			return true;
		}
		return false;
	}

	/**
	 * set the value to 0
	 */
	public function reset() {
		$this->integer = 0;
	}

}