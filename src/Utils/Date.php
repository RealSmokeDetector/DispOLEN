<?php

namespace App\Utils;

class Date {
	private string $date;
	private int $year;
	private int $month;
	private int $day;
	private int $hour;
	private int $minute;
	private int $second;

	/**
	 * Date construct
	 *
	 * @param string $date formated as "Y-m-d H:i:s"
	 */
	public function __construct(string $date = null) {
		$this->date = $date ?? date(format: "Y-m-d H:i:s");

		$this->year = (int)date(format: "Y", timestamp: strtotime(datetime: $this->date));
		$this->month = (int)date(format: "m", timestamp: strtotime(datetime: $this->date));
		$this->day = (int)date(format: "d", timestamp: strtotime(datetime: $this->date));

		$this->hour = (int)date(format: "H", timestamp: strtotime(datetime: $this->date));
		$this->minute = (int)date(format: "i", timestamp: strtotime(datetime: $this->date));
		$this->second = (int)date(format: "s", timestamp: strtotime(datetime: $this->date));
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
		$day = str_pad(string: $this->day, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);
		$month = str_pad(string: $this->month, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);

		switch ($_COOKIE["LANG"]) {
			case "fr_FR":
				$result = $day . "/" . $month . "/" . $this->year;
				break;
			default:
				$result = $month . "-" . $day . "-" . $this->year;
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
		switch ($_COOKIE["LANG"]) {
			case "fr_FR":
				$result = str_pad(string: $this->hour, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->minute, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->second, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);
				break;
			default:
				$hour = $this->hour % 12;
				$result = str_pad(string: $hour === 0 ? 12 : $hour, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->minute, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->second, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . date(format: "A", timestamp: strtotime(datetime: $this->date));
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
		switch ($_COOKIE["LANG"]) {
			case "en_GB":
			case "fr_FR":
				$format = "d/m/Y";
				break;
			default:
				$format = "m-d-Y";
				break;
		}

		return date(format: $format, timestamp: strtotime(datetime: "first day of", baseTimestamp: strtotime(datetime: $this->date)));
	}

	/**
	 * Get Numeric representation of the day of the week
	 * 0 (for Sunday) through 6 (for Saturday)
	 *
	 * @return int
	 */
	public function getOffsetWeek() : int {
		return (int)date(format: "w", timestamp: strtotime(datetime: $this->year . "-" . $this->month . "-01"));
	}

	/**
	 * Get number of days in month
	 *
	 * @return int
	 */
	public function getNbDayMonth() : int {
		return (int)date (format: "t", timestamp: strtotime(datetime: $this->year . "-" . $this->month . "-01"));
	}

	/**
	 * converts date in universal format
	 *
	 * @return string
	 */
	public function convertUniversalFormat() : string {
		$day = str_pad(string: $this->day, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);
		$month = str_pad(string: $this->month, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);
		$hour= str_pad(string: $this->hour, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT );
		$minute= str_pad(string: $this->minute, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT );
		$second= str_pad(string: $this->second, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT );

		



	}
}
