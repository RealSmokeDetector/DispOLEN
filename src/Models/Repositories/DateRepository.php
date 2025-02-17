<?php

namespace App\Models\Repositories;

use App\Models\Entities\Date;

class DateRepository {
	private ?Date $date;

	/**
	 * Reservation construct
	 *
	 * @param Date $date
	 */
	public function __construct(Date $date = null) {
		$this->date = $date;
	}

	/**
	 * Get timestamp
	 *
	 * @return int
	 */
	public function getTimestamp() : int {
		return $this->date->timestamp;
	}

	/**
	 * Get year
	 *
	 * @return int
	 */
	public function getYear() : int {
		return $this->date->year;
	}

	/**
	 * Get month
	 *
	 * @return int
	 */
	public function getMonth() : int {
		return $this->date->month;
	}

	/**
	 * Get day
	 *
	 * @return int
	 */
	public function getDay() : int {
		return $this->date->day;
	}

	/**
	 * Get hour
	 *
	 * @return int
	 */
	public function getHour() : int {
		return $this->date->hour;
	}

	/**
	 * Get minute
	 *
	 * @return int
	 */
	public function getMinute() : int {
		return $this->date->minute;
	}

	/**
	 * Get second
	 *
	 * @return int
	 */
	public function getSecond() : int {
		return $this->date->second;
	}

	/**
	 * Convert date format in user selected language
	 *
	 * @return string
	 */
	public function convertDate() : string {
		$day = str_pad(string: $this->date->day, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);
		$month = str_pad(string: $this->date->month, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);

		switch (USER_LANG) {
			case "en_GB":
			case "fr_FR":
				$result = $day . "/" . $month . "/" . $this->date->year;
				break;
			default:
				$result = $month . "-" . $day . "-" . $this->date->year;
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
		switch (USER_LANG) {
			case "fr_FR":
				$result = str_pad(string: $this->date->hour, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->date->minute, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->date->second, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT);
				break;
			default:
				$hour = $this->date->hour % 12;
				$result = str_pad(string: $hour === 0 ? 12 : $hour, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->date->minute, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . ":" . str_pad(string: $this->date->second, length: 2, pad_string: "0", pad_type: STR_PAD_LEFT) . date(format: "A", timestamp: $this->date->timestamp);
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
		switch (USER_LANG) {
			case "en_GB":
			case "fr_FR":
				$format = "d/m/Y";
				break;
			default:
				$format = "m-d-Y";
				break;
		}

		return date(format: $format, timestamp: strtotime(datetime: "first day of", baseTimestamp: $this->date->timestamp));
	}

	/**
	 * Get week offset
	 *
	 * @return int
	 */
	public function getWeekOffset() : int {
		return (int)date(format: "w", timestamp: strtotime(datetime: $this->date->year . "-" . $this->date->month . "-01"));
	}

	/**
	 * Get month's day's number
	 *
	 * @return int
	 */
	public function getDayNumber(int $day = 1) : int {
		return (int)date(format: "t", timestamp: strtotime(datetime: $this->date->year . "-" . $this->date->month . "-" . $day));
	}

	/**
	 * Converts date in universal format
	 *
	 * @return string
	 */
	public function convertUniversalFormat() : string {
		return date(format: "Y-m-d H:i:s", timestamp: $this->date->timestamp);
	}

	/**
	 * Get interval whis datetime given in this object
	 *
	 * @param int $hourStart
	 * @param int $hourEnd
	 *
	 * @return array
	 */
	public function getIntervalDay(int $hourStart = 0, int $hourEnd = 23) : array {
		return [
			"startDate" => date(format: "Y-m-d " . $hourStart . ":00:00", timestamp: $this->date->timestamp),
			"endDate" => date(format: "Y-m-d " . $hourEnd . ":59:59", timestamp: $this->date->timestamp)
		];
	}

	/**
	 * Get date of datetime given
	 *
	 * @param int $timestamp
	 *
	 * @return string
	 */
	public function getDate($timestamp = null) : string {
		return date(format: "Y-m-d", timestamp: $timestamp ?? $this->date->timestamp);
	}

	/**
	 * Get Time of datetime given
	 * @return string
	 */
	public function getTime() : string {
		return date(format: "H:i:s", timestamp: $this->date->timestamp);
	}

	/**
	 * Get off days
	 *
	 * @param int $year
	 *
	 * @return array
	 */
	public static function getOffDays(int $year) : array {
		$offDays = [
			$year . "-1-1",
			$year . "-5-1",
			$year . "-5-8",
			$year . "-7-14",
			$year . "-8-15",
			$year . "-11-1",
			$year . "-11-11",
			$year . "-12-25"
		];

		$easterDate = date(format: "Y-m-d", timestamp: easter_date(year: $year));

		$dates = [
			easter_date(year: $year),
			date(format: "U", timestamp: strtotime(datetime: "$easterDate -2 days")),
			date(format: "U", timestamp: strtotime(datetime: "$easterDate +1 days")),
			date(format: "U", timestamp: strtotime(datetime: "$easterDate +39 days")),
			date(format: "U", timestamp: strtotime(datetime: "$easterDate +50 days"))
		];

		foreach ($dates as $date) {
			array_push($offDays, str_replace(search: "-0", replace: "-", subject: (new DateRepository)->getDate(timestamp: $date)));
		}

		return $offDays;
	}

	/**
	 * adjuste Time whis minute given
	 *
	 * @param int $minute
	 *
	 * @return void
	 */
	public function adjusteTimeMin(int $minute) : void {
		$this->date->minute = ($this->date->minute + $minute) % 60;
		$this->adjusteTimeHour(hour: intdiv(num1: ($this->date->minute + $minute), num2: 60));
	}

	/**
	 * adjuste Time whis hour given
	 *
	 * @param int $hour
	 *
	 * @return void
	 */
	public function adjusteTimeHour(int $hour) : void {
		$this->date->hour = ($this->date->hour + $hour) % 24;
	}

	/**
	 * Get Duration between this date and date given
	 *
	 * @param DateRepository $dateRepo
	 *
	 * @return int
	 */
	public function getDurationDate(DateRepository $dateRepo) : int {
		return $dateRepo->getTimestamp() - $this->date->timestamp;
	}

	/**
	 * Get Duration (secound) between this date and available date of reservation
	 *
	 * @return int
	 */
	public function getIntervalFromBegin() : int {
		return $this->date->timestamp - strtotime(datetime: date(format: $this->getDate() . " 08:00:00"));
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
		while ($this->__construct(date: $this->date) < $this->GetIntervalDay(hourStart: $startHour, hourEnd: $endHour)) {
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
