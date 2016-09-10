#!/bin/bash
#1.1.создаём папку проекта

#I=$( mkdir /home/poultry 2>/dev/null) #не надо (ошибки)

	#1.2.Все дела с  git
	I=`dpkg -s git 2>/dev/null | grep "Status"`
	#если (установлен) -- вернул статус, а не ошибку 
	if [ -n "$I" ]
		then
			#проверим не существует ли проект?
			I=$( mkdir /home/poultry 2>&1)
			if [ -n "$I" ]
			
			#если вернулась ошибка - обновить
				then
					echo "project is already"
					cd /home/poultry
					git pull https://github.com/egorsmorgunov/poultry.git
					echo "project updated"
					exit 5
				#если вернулась пустота
				else
				
					cd /home/poultry
					git init
					git pull https://github.com/egorsmorgunov/poultry.git
					echo "git installed and pulled"
			fi
		else
			#попытаться установить в тихом режиме
			I=`apt-get -y -qq install git 2>/dev/null`
			#если установилась то запустить гит команды
			if [ -n "$I" ]
				then
					cd /home/poultry
					git init
					git pull https://github.com/egorsmorgunov/poultry.git
					echo "git was installed nice and pulled"
					#если не установилась то выдать ошибку и прекратить скрипт
				else
					echo "git: network down"
					exit 1
			fi	
	fi
	#1.3.Все дела с mysql
	I=`dpkg -s mysql-server 2>/dev/null | grep "Status"`
	#если (установлен) -- вернул статус, а не ошибку 
	if [ -n "$I" ]
		then
			echo "mysql already install"
			#проверить существование пользователя 
			#1.3.1. пробуем зайти под юзером
			I=$( mysql -u poultry -ppoultry -e "" 2>&1)
			#echo "$I"
			Check_bd_name_and_load_dump() 
			{ 
				#1.3.4.пробуем создать базу данных poultry
				I=$( mysql -u poultry -ppoultry -e "create database poultry_farm;" 2>&1)
				
				if [ -n "$I" ]
					then
						#1.3.4.2. бд существует - прекратить выполнение
						echo "mysql database already exists"
						exit 3
					else
						#1.3.4.1. бд не было - пробуем залить
						I=$( mysql -u poultry -ppoultry -e "use poultry_farm;source /home/poultry/poultry_farm.sql;" 2>&1)
						#echo "$I"
						if [ -n "$I" ]
							then
								echo "bd not dumped"
							else
								echo "bd dumped"
						fi
				fi	
			}
			if [ -n "$I" ]
				then
					#если юзера нет - создать 1.3.1.
					echo "mysql-user does not exist"
					I=$( mysql -u root -pfourthage -e "GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES, SHOW DATABASES, CREATE, DROP, FILE, INDEX, ALTER, CREATE TEMPORARY TABLES, EXECUTE, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EVENT, TRIGGER ON *.* TO 'poultry'@'localhost' IDENTIFIED BY 'poultry';" 2>&1)
					
					#echo "$I"
					if [ -n "$I" ]
						then
						#пользователя не удалось создать
							echo "can not create mysql-user poultry"
							exit 4
						else
							#проверить существование базы данных и заливка
							echo "mysql-user poultry created"
							Check_bd_name_and_load_dump
					fi
				else
					#если такой юзер есть
					echo "mysql user already exists"
					#проверить существование базы данных и заливка
					Check_bd_name_and_load_dump
			fi
			
		#если не установлена MySQL
		else
			#попытаться установить в тихом режиме
			I=`apt-get -y -qq install mysql-server 2>/dev/null`
			#если установилась, то установить юзера
			if [ -n "$I" ]
				then
					I=$( mysql -u root -pfourthage -e "GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES, SHOW DATABASES, CREATE, DROP, FILE, INDEX, ALTER, CREATE TEMPORARY TABLES, EXECUTE, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EVENT, TRIGGER ON *.* TO 'poultry'@'localhost' IDENTIFIED BY 'poultry';" 2>&1)
					if [ -n "$I" ]
						then
						#пользователя не удалось создать
							echo "can not create mysql-user poultry"
							exit 4
						else
							#проверить существование базы данных и заливка
							echo "mysql-user poultry created"
							Check_bd_name_and_load_dump
					fi
				else
					#если не установилась то выдать ошибку и прекратить скрипт
					echo "mysql: network down"
					exit 2
			fi	
	fi
exit 255
