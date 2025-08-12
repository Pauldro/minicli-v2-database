<?php namespace Pauldro\Minicli\v2\Database\Propel;
// Propel Classes
use Propel\Runtime\ActiveQuery\ModelCriteria as Query;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface as Record;

/**
 * AbstractQueryWrapper
 * Template for querying records from database using PROPEL ORM
 */
abstract class AbstractQueryWrapper {
	const MODEL              = '';
	const MODEL_TABLE        = '';
	const MODEL_KEY          = '';
	const MODEL_KEYS         = [];
	const DESCRIPTION        = '';

	protected static $instance;
	
/* =============================================================
	1. Constructors
============================================================= */
	/** @return static */
	public static function instance() {
		if (empty(static::$instance)) {
			static::$instance = new static();
		}
		return static::$instance;
	}

/* =============================================================
	Query Functions
============================================================= */
	/**
	 * Return Query Class Name
	 * @return string
	 */
	public function queryClassName() {
		return $this::MODEL.'Query';
	}

	/**
	 * Return model Class Name
	 * @return string
	 */
	public function modelClassName() {
		return static::MODEL;
	}

	/**
	 * Return Model
	 * @return Record
	 */
	public function newRecord() {
		$class = $this->modelClassName();
		return new $class();
	}

	/**
	 * Return New Query Class
	 * @return Query
	 */
	public function getQueryClass() {
		$class = static::queryClassName();
		return $class::create();
	}

	/**
	 * Returns the associated CodeQuery class for table code
	 * @return mixed
	 */
	public function query() {
		return $this->getQueryClass();
	}
}