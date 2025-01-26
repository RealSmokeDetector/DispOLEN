<?php

namespace App\Utils;

class Date {
	private string $dateTime;
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
		$this->dateTime = $date ?? date(format: "Y-m-d 08:00:00");

		$this->year = (int)date(format: "Y", timestamp: strtotime(datetime: $this->dateTime));
		$this->month = (int)date(format: "m", timestamp: strtotime(datetime: $this->dateTime));
		$this->day = (int)date(format: "d", timestamp: strtotime(datetime: $this->dateTime));

		$this->hour = (int)date(format: "H", timestamp: strtotime(datetime: $this->dateTime));
		$this->minute = (int)date(format: "i", timestamp: strtotime(datetime: $this->dateTime));
		$this->second = (int)date(format: "s", timestamp: strtotime(datetime: $this->dateTime));

		$this->dateTime = $this->convertUniversalFormat();
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
				$result = str_pad(string: $hour === 0 ? 12 : $hour, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->minute, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->second, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . date(format: "A", timestamp: strtotime(datetime: $this->dateTime));
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

		return date(format: $format, timestamp: strtotime(datetime: "first day of", baseTimestamp: strtotime(datetime: $this->dateTime)));
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
	public function getNbDayMonth(int $day = 1) : int {
		return (int)date (format: "t", timestamp: strtotime(datetime: $this->year . "-" . $this->month . "-".$day));
	}

	/**
	 * converts date in universal format
	 *
	 * @return string
	 */
	public function convertUniversalFormat() : string {
		return date(format: "Y-m-d H:i:s", timestamp: strtotime(datetime: $this->dateTime));
	}

	/**
	 * Get interval whis datetime given in this object
	 *
	 * @param int $hourStart
	 * @param int $hourEnd
	 *
	 * @return array
	 */
	public function GetIntervaleDay(int $hourStart = 0, int $hourEnd = 24) : array {
		$interval = [];
		array_push($interval, [
			"dateStart" => date(format: "Y-m-d ".$hourStart.":00:00", timestamp: strtotime(datetime: $this->dateTime)),
			"dateEnd" => date(format: "Y-m-d ".$hourEnd.":00:00", timestamp: strtotime(datetime: $this->dateTime))
		]);
		return $interval[0];
	}

	/**
	 * Get date of datetime given
	 *
	 * @return string
	 */
	public function getDate() : string {
		return date(format: "Y-m-d", timestamp: strtotime(datetime: $this->dateTime));
	}

	/**
	 * Get Time of datetime given
	 * @return string
	 */
	public function getTime() : string {
		return date(format: "H:i:s", timestamp: strtotime(datetime: $this->dateTime));
	}

	/**
	 * adjuste Time whis minute given
	 *
	 * @param int $minute
	 *
	 * @return void
	 */
	public function adjusteTimeMin(int $minute) : void {
		$this->minute = ($this->minute + $minute) % 60;
		$this->adjusteTimeHour(hour: intdiv(num1: ($this->minute + $minute), num2: 60));
	}

	/**
	 * adjuste Time whis hour given
	 *
	 * @param int $hour
	 *
	 * @return void
	 */
	public function adjusteTimeHour(int $hour) : void {
		$this->hour = ($this->hour + $hour) % 24;
	}

	/**
	 * Get Duration between this date and date given
	 *
	 * @param Date $dateEnd
	 *
	 * @return int
	 */
	public function getDurationDate(Date $dateEnd) : int {
		return strtotime(datetime: $dateEnd->dateTime) - strtotime(datetime: $this->dateTime);
	}

	/**
	 * Get Duration (secound) between this date and available date of reservation
	 *
	 * @return int
	 */
	public function getDurationDateAvailableReservations() : int {
		return strtotime(datetime: $this->dateTime) - strtotime(datetime: date(format: $this->getDate() . " 08:00:00"));
	}

	/**
	 * Function generating timesolts
	 *
	 * @param int $startHour
	 * @param int $endHour
	 *
	 * @return array
	 */
	function generateTimeslots(int $startHour, int $endHour) : array {
		// wtf did you do here?
		while ($this->__construct() < $this->GetIntervaleDay(hourStart: $startHour, hourEnd: $endHour)) {
			$slotStart = $this->GetTime();
			$this->adjusteTimeMin(minute: 30);
			$slotEnd = $this->GetTime();

			$timeslots = [
				"start" => $slotStart,
				"end" => $slotEnd
			];
		}

		return $timeslots;
	}
}
