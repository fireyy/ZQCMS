<?php

class Messages {

	private static function get() {
		return isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
	}

	private static function set($messages) {
		$_SESSION['messages'] = $messages;
	}

	public static function add($message) {
		$messages = self::get();

		if(is_array($message)) {
			$messages = array_merge($messages, $message);
		} else {
			$messages[] = $message;
		}

		self::set($messages);
	}

	public static function read() {
		$messages = self::get();

		if(empty($messages)) {
			return '';
		}

		$html = '<p class="message">' . implode('<br>', $messages) . '</p>';

		unset($_SESSION['messages']);

		return $html;
	}

}