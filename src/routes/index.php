<?php

use App\Configs\Role;
use App\Router;
use App\Utils\Lang;

$router = new Router;

$controllersPath = "App\Controllers\\";

// Pages
$router->add(
	url: "",
	controller: $controllersPath . "IndexController"
);
$router->add(
	url: "/groups",
	controller: $controllersPath . "Groups\GroupsController",
	title: APP_NAME . " - " . Lang::translate(key: "GROUPS_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::TEACHER,
		Role::ADMINISTRATOR
	]
);
$router->add(
	url: "/dashboard",
	controller: $controllersPath . "Dashboard\DashboardController",
	title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::ADMINISTRATOR
	]
);
$router->add(
	url : "/reservations",
	controller: $controllersPath . "Reservations\ReservationsController",
	title: APP_NAME . " - " . Lang::translate(key: "RESERVATION_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::TEACHER,
		Role::STUDENT
	]
);
$router->add(
	url: "/reservation/details",
	controller: $controllersPath . "Reservations\Details\ReservationDetailsController",
	title: APP_NAME . " - " . Lang::translate(key: "RESERVATIONS_DETAILS_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::TEACHER,
		Role::STUDENT
	]
);
$router->add(
	url: "/dashboard/users",
	controller: $controllersPath . "Dashboard\Users\DashboardUsersController",
	title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_USERS_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::ADMINISTRATOR
	]
);
$router->add(
	url: "/dashboard/user/details",
	controller: $controllersPath . "Dashboard\Users\Details\DashboardUsersDetailsController",
	title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_USER_DETAILS_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::ADMINISTRATOR
	]
);

// Sessions
$router->add(
	url: "/login",
	controller: $controllersPath . "Accounts\LoginController",
	title: APP_NAME . " - " . Lang::translate(key: "LOGIN_TITLE"),
	needLoginToBe: false
);
$router->add(
	url: "/register",
	controller: $controllersPath . "Accounts\RegisterController",
	title: APP_NAME . " - " . Lang::translate(key: "REGISTER_TITLE"),
	needLoginToBe: false
);
$router->add(
	url: "/disconnect",
	controller: $controllersPath . "Accounts\DisconnectController",
	needLoginToBe: true
);

// API
$router->add(
	url: "/api",
	controller: $controllersPath . "API\APIController",
	title: APP_NAME . " - API"
);
$router->add(
	url: "/api/groups",
	controller: $controllersPath . "API\Groups\APIGroupsController",
	title: APP_NAME . " - API"
);
$router->add(
	url: "/api/groups/users",
	controller: $controllersPath . "API\Groups\Users\APIGroupsUsersController",
	title: APP_NAME . " - API"
);
