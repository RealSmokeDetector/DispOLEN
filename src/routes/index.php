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
	url: "/dashboard",
	controller: $controllersPath . "DashboardController",
	title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::ADMINISTRATOR
	]
);
$router->add(
	url: "/dashboard/users",
	controller: $controllersPath . "DashboardUsersController",
	title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_USERS_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::ADMINISTRATOR
	]
);
$router->add(
	url: "/dashboard/user/details",
	controller: $controllersPath . "DashboardUsersDetailsController",
	title: APP_NAME . " - " . Lang::translate(key: "DASHBOARD_USER_DETAILS_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::ADMINISTRATOR
	]
);
$router->add(
	url : "/reservations",
	controller: $controllersPath . "ReservationsController",
	title: APP_NAME . " - " . Lang::translate(key: "RESERVATION_TITLE"),
	needLoginToBe: true,
	accessRoles: [
		Role::TEACHER,
		Role::STUDENT
	]
);

// Sessions
$router->add(
	url: "/login",
	controller: $controllersPath . "LoginController",
	title: APP_NAME . " - " . Lang::translate(key: "LOGIN_TITLE"),
	needLoginToBe: false
);
$router->add(
	url: "/register",
	controller: $controllersPath . "RegisterController",
	title: APP_NAME . " - " . Lang::translate(key: "REGISTER_TITLE"),
	needLoginToBe: false
);
$router->add(
	url: "/disconnect",
	controller: $controllersPath . "DisconnectController",
	needLoginToBe: true
);

// API
$router->add(
	url: "/api",
	controller: $controllersPath . "API\APIController",
	title: APP_NAME . " - API"
);
$router->add(
	url: "/api/users",
	controller: $controllersPath . "API\APIUsersController",
	title: APP_NAME . " - API"
);
