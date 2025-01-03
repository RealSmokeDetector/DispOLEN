<?php

namespace App\Models\Entities;

class Reservation {
	private ?string $uid_teacher;
	private ?string $uid_student;
	private ?string $uid_disponibilities;

	public function __construct(string $uid_teacher, string $uid_student, string $uid_disponibilities) {
		$this->uid_teacher = $uid_teacher;
		$this->uid_student = $uid_student;
		$this->uid_disponibilities = $uid_disponibilities;
	}

	public function __set($name, $value): void {
		$this->$name = $value;
	}

	public function __get($var): mixed {
		return $this->$var;
	}
}
