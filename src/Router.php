<?php

namespace App;

use App\Controllers\ErrorController;
use App\Models\Repositories\UserRepository;
use App\Utils\Lang;
use App\Utils\Roles;

class Router {
	protected array $routes = [];

	/**
	 * Create routeur's routes
	 *
	 * @param mixed $url Access URL
	 * @param mixed $controller View's controller
	 * @param mixed $title View's title
	 * @param mixed $needLoginToBe Does user have to be connected or have to be disconnected, null for no restrictions
	 * @param mixed $accessRoles Roles that can render view
	 *
	 * @return void
	 */
	public function add($url, $controller, $title = APP_NAME, $needLoginToBe = null, $accessRoles = []) : void {
		$this->routes[$url] = [
			"controller" => $controller,
			"title" => $title,
			"needLoginToBe" => $needLoginToBe,
			"accessRoles" => $accessRoles
		];
	}

	/**
	 * Render route's view
	 *
	 * @param mixed $url Access URL
	 *
	 * @return void
	 */
	public function render($url) : void {
		while (mb_substr(string: $url, start: -1) === "/") {
			$url = mb_substr(string: $url, start: 0, length: -1);
		}

		$title = APP_NAME;
		global $title;
		$errorCode = 404;
		$view = $this->routes[$url]["controller"] ?? null;

		if ($view) {
			// Page accessible anytime for everyone
			if ($this->routes[$url]["needLoginToBe"] === null) {
				$GLOBALS["title"] = $this->routes[$url]["title"];
				$controller = new $view;
				$controller->render();
				exit;
			}

			// User is connected and need to be connected
			if ($this->routes[$url]["needLoginToBe"] === true && isset($_SESSION["user"])) {
				// User got necessary permissions
				if (
					$this->routes[$url]["accessRoles"] === []
					|| Roles::check(userRoles: UserRepository::getRoles(uid: $_SESSION["user"]["uid"]), allowRoles: $this->routes[$url]["accessRoles"])
				) {
					$GLOBALS["title"] = $this->routes[$url]["title"];
					$controller = new $view;
					$controller->render();
					exit;
				}

				$errorCode = 403;
			}

			// User is not connected and need to not be connected
			if ($this->routes[$url]["needLoginToBe"] === false && !isset($_SESSION["user"])) {
				$GLOBALS["title"] = $this->routes[$url]["title"];
				$controller = new $view;
				$controller->render();
				exit;
			}
		}

		$controller = new ErrorController();
		$controller->render(errorCode: $errorCode, message: Lang::translate(key: "ERROR_" . $errorCode));
	}
}
