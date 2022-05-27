## code quality
Code quality has been validated by Codacy. You can access the inspection report by clicking on the badge below.

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/495c5ee03f7540e483ca493c2d4a1dcb)](https://www.codacy.com/gh/Kakahuette400/project_06/dashboard)

## Installation
- PHP 8.0.13
- MySql 5.7.36
- Apache 2.4.51
- Symfony 6


## Requirements
- Localhost 
For this project i used WAMPSERVER avaible here : https://www.wampserver.com/


## Installing the project:

Step 1: Clone the Repository on server from the root via the command: **git clone https://github.com/Kakahuette400/project_06.git**
- Modify the .env document with your Database and e-mail parameters :

EMAIL (Replace [Your***]) -> MAILER_DSN : MAILER_DSN=smtp://[YourEmail]:[YourPassword]@[YourSMTP]:[YourPort]

DATABASE (Example) -> DATABASE_URL=mysql://root:@127.0.0.1:3308/snowtricks


Step 2: Install composer on your project if it's not already the case: https://getcomposer.org/
- Install all dependances avaible on : https://packagist.org/ whit "composer install"
- Read the documentation to customize your installation

Step 3: Create a database on your DBMS and import the snowtricks.sql file avaiable in diagrams folder

Step 4:  Start the server using "php -S localhost:8000 -t public"

Step 5: Your community site is now functional, you can create user or use created user to make and modify tricks.


## Libraries used:
The libraries were installed via composer, please install it:
- For sending emails: **symfony/mailer** https://symfony.com/doc/current/mailer.html

## About bootsrap template

For this project, I used bootsrap and bootstwatch template: https://bootswatch.com/
