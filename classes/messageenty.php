<?php
/**
 * FuelPHP Messages
 * "MIT License"
 * Copyright 2013 Michiel Hendriks <elmuerte@drunksnipers.com>
 */

namespace Messages;

class MessageEntry {
	/**
	 * Timestamp the entry was created
	 * @var int
	 */
	public $timestamp;

	/**
	 * The type of message
	 * @var string
	 */
	public $type;

	/**
	 * Optional title of a message
	 *
	 * @var string
	 */
	public $title;

	/**
	 * The message itself
	 *
	 * @var string
	 */
	public $message;

	function __construct($type, $message, $title = "") {
		$this->timestamp = time();
		$this->type = $type;
		$this->message = $message;
		$this->title = $title;
	}

	/**
	 * Get the data as an associative array
	 * @return array
	 */
	public function toArray() {
		return get_object_vars($this);
	}
}
