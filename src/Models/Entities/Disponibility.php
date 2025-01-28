<?php

namespace App\Models\Entities;

class Disponibility {
	private ?string $uid;
	private ?string $date_start;
	private ?string $date_end;
	private ?User $user;

	public function __construct(string $uid = null, string $date_start = null, string $date_end = null, User $user = null) {
		$this->uid = $uid;
		$this->date_start = $date_start;
		$this->date_end = $date_end;
		$this->user = $user;
	}

	public function __set($name, $value) : void {
		$this->$name = $value;
	}

	public function __get($var) : mixed {
		return $this->$var;
	}
}
