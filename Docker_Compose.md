
MySQL

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


CONTAINER ID        IMAGE                  COMMAND                  CREATED             STATUS                     PORTS                              NAMES
12947c62d05b        dockercompose_nginx    "nginx -g 'daemon ..."   5 minutes ago       Up 5 minutes               80/tcp, 0.0.0.0:81->81/tcp         dockercompose_nginx_1
5ce2b9c04992        dockercompose_phpfpm   "docker-php-entryp..."   5 minutes ago       Up 5 minutes               9000/tcp, 0.0.0.0:9001->9001/tcp   dockercompose_phpfpm_1
37107b7be7f9        dockercompose_mysql    "docker-entrypoint..."   5 minutes ago       Exited (1) 4 minutes ago                                      dockercompose_mysql_1
c4f1fd40eeab        nginx                  "nginx -g 'daemon ..."   42 hours ago        Up 42 hours                0.0.0.0:80->80/tcp                 nginx-php
69457451e81f        php-fpm5.6/v2          "docker-php-entryp..."   42 hours ago        Up 42 hours                0.0.0.0:9000->9000/tcp             php-with-mysql
f91b190e2921        mysql:5.6              "docker-entrypoint..."   42 hours ago        Up 42 hours                0.0.0.0:3306->3306/tcp             test_mysql
yue:DockerCompose yueli$ 


