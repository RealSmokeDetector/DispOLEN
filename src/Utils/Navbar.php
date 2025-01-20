<?php

namespace App\Utils;

use App\Configs\Path;
use App\Models\Repositories\UserRepository;

class Navbar {
	private $navbar = [];

	/**
	 * Add navbar element
	 *
	 * @param string $title
	 * @param string $icon
	 * @param string $url
	 * @return void
	 */
	public function add(string $title, string $icon, string $url, string $class, bool $needLoginToBe = null, array $accessRoles = []) : void {
		array_push(
			$this->navbar,
			[
				"title" => $title,
				"icon" => $icon,
				"url" => $url,
				"class" => $class,
				"needLoginToBe" => $needLoginToBe,
				"accessRoles" => $accessRoles
			]
		);
	}

	/**
	 * Render navbar
	 *
	 * @return void
	 */
	public function render() : void {
		echo "<nav>";

		include Path::COMPONENTS . "/elements/navbar_logo.php";

		foreach ($this->navbar as $element) {
			if ($element["needLoginToBe"] === null) {
				include Path::COMPONENTS . "/actions/navbar_item.php";
			} else {
				if ($element["needLoginToBe"] === true and isset($_SESSION["user"])) {
					if (
						$element["accessRoles"] === []
						|| Roles::check(userRoles: UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), allowRoles: $element["accessRoles"])
					) {
						include Path::COMPONENTS . "/actions/navbar_item.php";
					}
				}
				if ($element["needLoginToBe"] === false and !isset($_SESSION["user"])) {
					include Path::COMPONENTS . "/actions/navbar_item.php";
				}
			}
		}

		include Path::COMPONENTS . "/actions/profile_button.php";
		include Path::COMPONENTS . "/actions/theme_button.php";
		include Path::COMPONENTS . "/actions/lang_selection.php";

		echo "</nav>";
	}
}
