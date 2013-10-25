<?php
/**
 * FuelPHP Messages
 * "MIT License"
 * Copyright 2013 Michiel Hendriks <elmuerte@drunksnipers.com>
 */

namespace Messages;

class Messages {

	/**
	 * Supported message types
	 */
	protected static $messageTypes = array(
			'warning',
			'error',
			'info',
			'success',
			'danger',
	);

	/**
	 *
	 * @var MessageEntry[]
	*/
	protected static $entries = array();

	/**
	 * If true, clear the messages when calling the get methods.
	 * @var bool
	*/
	protected static $clearOnGet = true;

	/**
	 * The format string for date time value
	 * @var string
	 */
	protected static $dateTimeFormat = "%H:%M:%s";

	/**
	 * Add a message entry
	 * @param MessageEntry $entry
	 */
	public static function addEntry(MessageEntry $entry) {
		static::$entries[] = $entry;
	}

	/**
	 * Get the current message entries as object
	 * @param string $type
	 * @return MessageEntry[]
	 */
	public static function getEntries($type="") {
		if ($type == "") {
			return static::$entries;
		}
		$res = array();
		foreach (static::$entries as $entry) {
			if ($entry->type == $type) {
				$res[] = $entry;
			}
		}
		return $res;
	}

	/**
	 * Get the messages
	 * @param string $type
	 * The type of message to get, if empty it returns all messages.
	 * @param string $clear
	 * If set to true it will remove the read messages. If false it will not remove the message, overriding the cleanOnGet configuration.
	 * @return \View[]
	 */
	public static function get($type="",$clear=null) {
		return static::getViews('html', $type, $clear);
	}

	/**
	 * Get the messages in json format
	 * @param string $type
	 * The type of message to get, if empty it returns all messages.
	 * @param string $clear
	 * If set to true it will remove the read messages. If false it will not remove the message, overriding the cleanOnGet configuration.
	 * @return \View[]
	 */
	public static function get_json($type="",$clear=null) {
		return static::getViews('json', $type, $clear);
	}

	/**
	 * Get the messages in XML format
	 * @param string $type
	 * The type of message to get, if empty it returns all messages.
	 * @param string $clear
	 * If set to true it will remove the read messages. If false it will not remove the message, overriding the cleanOnGet configuration.
	 * @return \View[]
	 */
	public static function get_xml($type="",$clear=null) {
		return static::getViews('xml', $type, $clear);
	}

	/**
	 * Clear the current entries
	 */
	public static function clear() {
		static::$entries = array();
	}

	public static function _init() {
		\Config::load('messages', 'messages');

		static::$clearOnGet = \Config::get("messages.clearOnGet", static::$clearOnGet);
		static::$dateTimeFormat = \Config::get("messages.dateTimeFormat", static::$dateTimeFormat);
	}

	/**
	 * Magic function called when adding messages via Messagess::info(...)
	 * @param string $name
	 * @param array $args
	 */
	public static function __callStatic($name, $args) {
		if (in_array($name, static::$messageTypes)) {
			$msgText = $args[0];
			$msgTitle = "";
			if (count($args) == 2) {
				$msgText = $args[1];
				$msgTitle = $args[0];
			}
			$entry = new MessageEntry($name, $msgText, $msgTitle);
			static::addEntry($entry);
		}
	}

	/**
	 * Constructs the views
	 * @param unknown $template
	 * @param string $type
	 * @param string $clear
	 * @return \View[]
	 */
	protected static function getViews($template, $type="", $clear=null) {
		if ($clear == null) {
			$clear = static::$clearOnGet;
		}
		$res = array();
		foreach (static::$entries as $key => $entry) {
			if ($type != "") {
				if ($entry->type != $type) {
					continue;
				}
			}
			if ($clear) {
				unset(static::$entries[$key]);
			}
			$view = \View::forge($template, $entry->toArray(), false);
			$view->entry = $entry;
			$view->set('dateTime', strftime(static::$dateTimeFormat, $entry->timestamp), true);
			$res[] = $view;
		}
		return $res;
	}
}
