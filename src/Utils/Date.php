<?php

namespace App\Utils;

class Date {
	private ?string $date;
	private ?int $year;
	private ?int $month;
	private ?int $day;
	private ?int $hour;
	private ?int $minute;
	private ?int $second;

	public function __construct(string $date = null) {
		$this->date = $date ?? date(format: "Y-m-d H:i:s");
		$this->year = (int) date(format: "Y", timestamp: strtotime(datetime: $this->date));
		$this->month = (int) date(format: "m", timestamp: strtotime(datetime: $this->date));
		$this->day = (int) date(format: "d", timestamp: strtotime(datetime: $this->date));
		$this->hour = (int) date(format: "H", timestamp: strtotime(datetime: $this->date));
		$this->minute = (int) date(format: "i", timestamp: strtotime(datetime: $this->date));
		$this->second = (int) date(format: "s", timestamp: strtotime(datetime: $this->date));
	}

	public function __get($name) : mixed {
		return $this->$name;
	}

	public function __set($name, $value) : void {
		$this->$name = $value;
	}

	/**
	 * Convert date format in user selected language
	 *
	 * @return string
	 */
	public function convertDate() : string {
		$lang = $_COOKIE["LANG"];

		switch ($lang) {
			case "en_GB":
			case "fr_FR":
				$result = $this->day . "/" . $this->month . "/" . $this->year;
				break;
			default:
				$result = $this->month . "-" . $this->day . "-" . $this->year;
				break;
		}

		return $result;
	}

	/**
	 * Convert time format in user selected language
	 *
	 * @return string
	 */
	public function convertTime() : string {
		$lang = $_COOKIE["LANG"];
		$date = $this->date;

		switch ($lang) {
			case "en_GB":
			case "fr_FR":
				$result = $this->hour . ":" . $this->minute . ":" . $this->second;
				break;
			default:
				$result = $this->hour . ":" . $this->minute . ":" . $this->second . date(format: "A", timestamp: strtotime(datetime: $date));
				break;
		}

		return $result;
	}

	/**
	 * Get First date in month
	 *
	 * @return string
	 */
	public function getFirstDateMonth() : string {
		$lang = $_COOKIE["LANG"];
		$date = $this->date;

		switch ($lang) {
			case "en_GB":
			case "fr_FR":
				$result = date(format: "d/m/Y", timestamp: strtotime(datetime: "first day of", baseTimestamp: strtotime(datetime: $date)));
				break;
			default:
				$result = date(format: "m-d-Y", timestamp: strtotime(datetime: "first day of", baseTimestamp: strtotime(datetime: $date)));
				break;
		}

		return $result;
	}

	/**
	 * Get Numeric representation of the day of the week
	 * 0 (for Sunday) through 6 (for Saturday)
	 *
	 * @return int
	 */
	public function getOffsetWeek() : int {
		return (int) date (format: "w", timestamp: strtotime(datetime: $this->year . "-" . $this->month . "-01"));
	}

	/**
	 * Get number of days in month
	 *
	 * @return int
	 */
	public function getNbDayMonth() : int {
		return (int) date (format: "t", timestamp: strtotime(datetime: $this->year . "-" . $this->month . "-01"));
	}
}
