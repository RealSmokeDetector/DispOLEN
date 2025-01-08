📅Disp'OLEN

>[!NOTE]
>Disp'OLEN is disigned for education professionals, especially teachers and students

## 📝 Table of contents

- [Features](#-features)
	- Account system
	- Role system
	- Multi-langage
- [Requirements](#-requirements)
- [Account connection](#-account-connection)
- [Installation](#-installation)
	- Database
	- Parameters
- [Administration](#-administration)
	- Modules
	- Error logs
	- Trace logs

## 👾 Features

- 🙂 Account system

Student and teacher can create account with securised datas.

- 👤 Role system

Three roles are available:

1. Student: Default role,
2. Teacher: Role that provide session creation,
3. Admin: A full access role to manage the application

- 🔗 Multi-langage

On account settings, langage can be changed. Default is french.

Available langage:

- French
- English

*To add a new langage, simply create a new file in `lang/` using existing file content with the corresponding translation.*

## 🤔 Requirements

- [Apache2](https://httpd.apache.org/) Latest
- [PHP](https://www.php.net/) >=8.3
- [PostgreSQL](https://postgresql.org/) Latest
- [Composer](https://getcomposer.org/) Latest

## 🔗 Account connection

To connect with an existing account, use their email address and password.

## 🔧 Installation
1. <u>Module</u>

Use `composer install` on any terminal open in project's root folder.

2. <u>Database</u>

	- Execute `sql/database.sql` on your database server

3. <u>Parameters</u>

Rename `.env.example` to `.env` and fill credentials.

## 🚧 Development

Enable DEBUG key to display some usefull logs.


## VirtualHost

### Apache2 minimal configuration

```html
<VirtualHost *:80>
        ServerName dispolen.local
        DocumentRoot /var/www/dispolen/public

        <Directory /var/www/dispolen/public>
                DirectoryIndex /index.php
                FallbackResource /index.php
        </Directory>
</VirtualHost>
```

### Nginx minimal configuration

```nginx
server_name dispolen.local;

root /var/www/dipolen/public;

index /index.php;
```
## 🚧 Administration

- Error logs

Potentials error's logs are store in `log/[current-date].log`
