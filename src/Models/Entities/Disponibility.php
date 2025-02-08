<?php

namespace App\Models\Entities;

class Disponibility {
	private ?string $uid;
	private ?string $startDate;
	private ?string $endDate;
	private ?User $user;

	public function __construct(string $uid = null, string $startDate = null, string $endDate = null, User $user = null) {
		$this->uid = $uid;
		$this->startDate = $startDate;
		$this->endDate = $endDate;
		$this->user = $user;
	}

	public function __set($name, $value) : void {
		$this->$name = $value;
	}

	public function __get($var) : mixed {
		return $this->$var;
	}
}
