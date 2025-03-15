<?php

namespace App\Models\Entities;

class Date {
	private int $timestamp;
	private int $year;
	private int $month;
	private int $day;
	private int $hour;
	private int $minute;
	private int $second;

	public function __construct(int $timestamp = null) {
		$this->timestamp = $timestamp ?? date(format: "U");

		$this->year = (int)date(format: "Y", timestamp: $this->timestamp);
		$this->month = (int)date(format: "m", timestamp: $this->timestamp);
		$this->day = (int)date(format: "d", timestamp: $this->timestamp);

		$this->hour = (int)date(format: "H", timestamp: $this->timestamp);
		$this->minute = (int)date(format: "i", timestamp: $this->timestamp);
		$this->second = (int)date(format: "s", timestamp: $this->timestamp);
	}

	public function __set($name, $value) : void {
		$this->$name = $value;
	}

	public function __get($var) : mixed {
		return $this->$var;
	}
}
