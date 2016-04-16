#!/bin/bash
#1.1.создаЄм папку проекта
I=$( mkdir /home/poultry 2>&1)
#если папки нет она создастс€
if [ -n "$I" ]
	then
		echo "detected user dir"
		exit 0
	else
		#1.2.¬се дела с  git
		I=`dpkg -s git 2>/dev/null | grep "Status"`
		#если (установлен) -- вернул статус, а не ошибку 
		if [ -n "$I" ]
			then
				#пулим репозиторий 
				cd /home/poultry
				git init
				git pull https://github.com/Guap5231/Poultry.git
				echo "git already install and pulled"
			else
				#попытатьс€ установить в тихом режиме
				I=`apt-get -y -qq install git 2>/dev/null`
				#если установилась то запустить гит команды
				if [ -n "$I" ]
					then
						cd /home/poultry
						git init
						git pull https://github.com/Guap5231/Poultry.git
					echo "git was install nice and pulled"
					#если не установилась то выдать ошибку и прекратить скрипт
					else
						echo "network down"
						exit 1
				fi	
		fi
		#1.3.¬се дела с mysql
		I=`dpkg -s mysql-server 2>/dev/null | grep "Status"`
		#если (установлен) -- вернул статус, а не ошибку 
		if [ -n "$I" ]
			then
				#проверить существование пользовател€ 
				#1.3.1. пробуем зайти под юзером
				I=$( mysql -u poultry -ppoultry -e "" 2>&1)
				#echo "$I"
				Check_bd_name_and_load_dump() 
				{ 
					#1.3.4.пробуем создать базу данных poultry
					I=$( mysql -u poultry -ppoultry -e "create database poultry;" 2>&1)
					
					if [ -n "$I" ]
						then
							#1.3.4.2. бд существует - прекратить выполнение
							echo "mysql database already exists"
							exit 3
						else
							#1.3.4.1. бд не было - пробуем залить
							I=$( mysql -u poultry -ppoultry -e "use poultry;source /home/poultry/poultry_farm.sql;" 2>&1)
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
							#пользовател€ не удалось создать
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

				echo "mysql already install"
			else
				#попытатьс€ установить в тихом режиме
				I=`apt-get -y -qq install mysql-server 2>/dev/null`
				#если установилась, то запустить и проверить юзера
				if [ -n "$I" ]
					then
						#проверить существование пользовател€ 
						echo "mysql was install nice"
						#если не установилась то выдать ошибку и прекратить скрипт
					else
						echo "network down"
						exit 2
				fi	
		fi
fi
exit 255