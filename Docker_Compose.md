
#MySQL

	$ cd /Users/yueli/DockerCompose 
	$ docker run -p 3305:3305 --name test2_mysql -v$PWD/mysql/data:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456 -d --privileged=true mysql:5.6
	$ docker exec -it test2_mysql bash
	root@c5a919d39a85:/# mysql -u root -p
	Enter password: 
	Welcome to the MySQL monitor.  

mysql> show databases;

| Database           |
--------------------+
| information_schema |
| mysql              |
| performance_schema |

3 rows in set (0.02 sec)


	mysql> create database if not exists test_db;
	mysql> use test_db
	mysql> create table people(name varchar(10), age int);
	mysql> insert into people values('liyue', 23);
	mysql> show tables;

| Tables_in_test_db |
-------------------+
| people            |

	mysql> exit
	Bye
	root@c5a919d39a85:/# 




#PHP with MySQL
###Create a Dockerfile


####进入容器
	$ cd /Users/yueli/DockerCompose/phpfpm 
	$ docker build -t="php-fpm5.6/v2" .
	$ docker run -d -p 9000:9000 -v /Users/yueli/DockerCompose/code/:/var/www/html/ --name php-with-mysql --link test_mysql:mysql  --volumes-from test_mysql --privileged=true php-fpm5.6/v2

	yue:phpfpm yueli$ docker exec -it php-with-mysql bash
	root@69457451e81f:/var/www/html# php mysql.php

	Array(

    [name] => liyue
    
    [0] => liyue
    
    [age] => 23
    
    [1] => 23)



#compose



	ERROR: for mysql  Cannot start service mysql: b'driver failed programming external connectivity on endpoint dockercompose_mysql_1 (7eb8d2d376ec8966ff00e59f2a786501f16a7393071bdf7a5ee643c89a0391fa): Bind for 0.0.0.0:3306 failed: port is already allocated'
	ERROR: Encountered errors while bringing up the project.
	yue:DockerCompose yueli$ docker ps -a
CONTAINER ID        IMAGE                 COMMAND                  CREATED             STATUS              PORTS                    NAMES
7e612f2263c1        dockercompose_mysql   "docker-entrypoint..."   2 minutes ago       Created                                      dockercompose_mysql_1
c4f1fd40eeab        nginx                 "nginx -g 'daemon ..."   16 minutes ago      Up 16 minutes       0.0.0.0:80->80/tcp       nginx-php
69457451e81f        php-fpm5.6/v2         "docker-php-entryp..."   26 minutes ago      Up 26 minutes       0.0.0.0:9000->9000/tcp   php-with-mysql
f91b190e2921        mysql:5.6             "docker-entrypoint..."   39 minutes ago      Up 39 minutes       0.0.0.0:3306->3306/tcp   test_mysql
yue:DockerCompose yueli$ tree DockerCompose

