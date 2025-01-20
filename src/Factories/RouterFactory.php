<?php

namespace App\Factories;

use App\Configs\Role;
use App\Router;
use App\Utils\Lang;

class RouterFactory extends Router {
	private	$controllersPath = "App\Controllers\\";

	public function __construct() {
		// Pages
		parent::add(
			url: "",
			controller: $this->controllersPath . "IndexController"
		);
		parent::add(
			url: "/groups",
			controller: $this->controllersPath . "Groups\GroupsController",
			title: APP_NAME . " - " . Lang::translate(key: "GROUPS_TITLE"),
			needLoginToBe: true,
			accessRoles: [
				Role::TEACHER,
				Role::ADMINISTRATOR
			]
		);
		parent::add(
			url: "/dashboard",
			controller: $this->controllersPath . "Dashboard\DashboardController",
			title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_TITLE"),
			needLoginToBe: true,
			accessRoles: [
				Role::ADMINISTRATOR
			]
		);
		parent::add(
			url : "/reservations",
			controller: $this->controllersPath . "Reservations\ReservationsController",
			title: APP_NAME . " - " . Lang::translate(key: "RESERVATION_TITLE"),
			needLoginToBe: true,
			accessRoles: [
				Role::TEACHER,
				Role::STUDENT
			]
		);
		parent::add(
			url: "/reservation/details",
			controller: $this->controllersPath . "Reservations\Details\ReservationDetailsController",
			title: APP_NAME . " - " . Lang::translate(key: "RESERVATIONS_DETAILS_TITLE"),
			needLoginToBe: true,
			accessRoles: [
				Role::TEACHER,
				Role::STUDENT
			]
		);
		parent::add(
			url: "/dashboard/users",
			controller: $this->controllersPath . "Dashboard\Users\DashboardUsersController",
			title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_USERS_TITLE"),
			needLoginToBe: true,
			accessRoles: [
				Role::ADMINISTRATOR
			]
		);
		parent::add(
			url: "/dashboard/user/details",
			controller: $this->controllersPath . "Dashboard\Users\Details\DashboardUsersDetailsController",
			title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_USER_DETAILS_TITLE"),
			needLoginToBe: true,
			accessRoles: [
				Role::ADMINISTRATOR
			]
		);

		// Sessions
		parent::add(
			url: "/login",
			controller: $this->controllersPath . "Accounts\LoginController",
			title: APP_NAME . " - " . Lang::translate(key: "LOGIN_TITLE"),
			needLoginToBe: false
		);
		parent::add(
			url: "/register",
			controller: $this->controllersPath . "Accounts\RegisterController",
			title: APP_NAME . " - " . Lang::translate(key: "REGISTER_TITLE"),
			needLoginToBe: false
		);
		parent::add(
			url: "/account",
			controller: $this->controllersPath . "Accounts\AccountIndexController",
			title: APP_NAME . " - " . Lang::translate(key: "ACCOUNT_TITLE"),
			needLoginToBe: true
		);
		parent::add(
			url: "/disconnect",
			controller: $this->controllersPath . "Accounts\DisconnectController",
			needLoginToBe: true
		);

		// API
		parent::add(
			url: "/api",
			controller: $this->controllersPath . "API\APIController",
			title: APP_NAME . " - API"
		);
		parent::add(
			url: "/api/groups",
			controller: $this->controllersPath . "API\Groups\APIGroupsController",
			title: APP_NAME . " - API"
		);
		parent::add(
			url: "/api/groups/users",
			controller: $this->controllersPath . "API\Groups\Users\APIGroupsUsersController",
			title: APP_NAME . " - API"
		);
	}

	/**
	 * Render route's view
	 *
	 * @param string $url Access URL
	 *
	 * @return void
	 */
	public function render(string $url) : void {
		parent::render(url: $url);
	}
}
