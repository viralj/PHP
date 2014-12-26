b89.in URL Shortner
===================

This is an open source project now and developed by VIRAL JOSHI, available for eveyone.
You can download it and host it on any server. This project is developed in purely 
PHP with help of BOOTSTRAP templates and other css, javascript, jquery etc.

The SQL tables and details are also included in this project. This project uses 
MYSQLI adapter to connect with mysql database. This is also open source so you can
edit this project's master branch or can download it and edit as you want to use.

CHANGES TO CONNECT WITH MYSQL
=============================

The db connection file is stored in "CORE" directory with name of 'db_config_inc.php'
and you will need to edit below line given in file to connect with database.

--> $db = new mysqli ('localhost', 'root', '', 'b89');

where you will need to edit 

  $db = new mysqli ('DB_HOST_ADDRESS', 'DB_USER_NAME', 'DB_USER_PASS', 'DB_TABLE_NAME');
  and this code line is to explain what you will need to edit.
  
Enjoy your own URL Shortner. And this is also built with features like bug report, ad service
etc. 


BUILT WITH AD SERVICE
=====================

To show ads on redirect page, you will need add your advertisement codes on 'redirect.php'
page which is ocated in "CORE/PAGES" directories.
Look into codes and find div blocks which says which size of ad block goes where.


If you need any information/help contact me on github, facebook, google+, twitter or linkedin.

Enjoy!!!
