<?php

namespace App\Factories;

use App\Configs\Role;
use App\Utils\Lang;
use App\Utils\Navbar;

class NavbarFactory extends Navbar {
	public function __construct() {
		parent::add(
			title: Lang::translate(key: "NAVBAR_LOGIN"),
			icon: "ri-lock-2-line",
			url:"/login",
			class: "button",
			needLoginToBe: false,
		);
		parent::add(
			title: Lang::translate(key: "NAVBAR_REGISTER"),
			icon: "ri-user-line",
			url:"/register",
			class: "button",
			needLoginToBe: false,
		);

		parent::add(
			title: Lang::translate(key: "NAVBAR_HOME"),
			icon: "ri-home-2-line",
			url: "/",
			class: "button button_secondary",
			needLoginToBe: true,
		);
		parent::add(
			title: Lang::translate(key: "NAVBAR_CALENDAR"),
			icon: "ri-calendar-check-line",
			url: "/calendar",
			class: "button button_secondary",
			needLoginToBe: true
		);
		parent::add(
			title: Lang::translate(key: "NAVBAR_GROUPS"),
			icon: "ri-team-line",
			url: "/groups",
			class: "button button_secondary",
			needLoginToBe: true,
			accessRoles: [Role::TEACHER, Role::ADMINISTRATOR]
		);
		parent::add(
			title: Lang::translate(key: "NAVBAR_RESERVATION"),
			icon: "ri-calendar-2-line",
			url: "/reservations",
			class: "button button_secondary",
			needLoginToBe: true,
			accessRoles: [Role::STUDENT, Role::TEACHER]
		);
		parent::add(
			title: Lang::translate(key: "NAVBAR_DASHBOARD_USERS"),
			icon: "ri-group-line",
			url: "/dashboard/users",
			class: "button button_secondary",
			needLoginToBe: true,
			accessRoles: [Role::ADMINISTRATOR]
		);

		parent::add(
			title: Lang::translate(key: "NAVBAR_DISCONNECT"),
			icon: "ri-logout-box-r-line",
			url: "/disconnect",
			class: "button",
			needLoginToBe: true
		);

		parent::render();
	}
}
