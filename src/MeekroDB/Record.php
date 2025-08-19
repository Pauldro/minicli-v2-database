<?php namespace Pauldro\Minicli\v2\Database\MeekroDB;
// ProcessWire
use Pauldro\Minicli\v2\Util\Data;

/**
 * Record
 * 
 * Class for DatabaseTable Record
 */
class Record extends Data {
	const PRIMARYKEY = [];
	const RECORDKEY  = [];
	const GLUE = '|';

	/**
	 * Return Keys for this Model
	 * @return array
	 */
	public function primarykey() : array 
	{
		$keys = [];

		foreach (static::PRIMARYKEY as $key) {
			$keys[] = $this->$key;
		}
		return $keys;
	}

	/**
	 * Return Primary Key as a string
	 * @return string
	 */
	public function primarykeyString() : string 
	{
		return implode(static::GLUE, $this->primarykey());
	}
}