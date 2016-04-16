#!/bin/bash
#1.1.������ ����� �������
I=$( mkdir /home/poultry 2>&1)
#���� ����� ��� ��� ���������
if [ -n "$I" ]
	then
		echo "detected user dir"
		exit 0
	else
		#1.2.��� ���� �  git
		I=`dpkg -s git 2>/dev/null | grep "Status"`
		#���� (����������) -- ������ ������, � �� ������ 
		if [ -n "$I" ]
			then
				#����� ����������� 
				cd /home/poultry
				git init
				git pull https://github.com/Guap5231/Poultry.git
				echo "git already install and pulled"
			else
				#���������� ���������� � ����� ������
				I=`apt-get -y -qq install git 2>/dev/null`
				#���� ������������ �� ��������� ��� �������
				if [ -n "$I" ]
					then
						cd /home/poultry
						git init
						git pull https://github.com/Guap5231/Poultry.git
					echo "git was install nice and pulled"
					#���� �� ������������ �� ������ ������ � ���������� ������
					else
						echo "network down"
						exit 1
				fi	
		fi
		#1.3.��� ���� � mysql
		I=`dpkg -s mysql-server 2>/dev/null | grep "Status"`
		#���� (����������) -- ������ ������, � �� ������ 
		if [ -n "$I" ]
			then
				#��������� ������������� ������������ 
				#1.3.1. ������� ����� ��� ������
				I=$( mysql -u poultry -ppoultry -e "" 2>&1)
				#echo "$I"
				Check_bd_name_and_load_dump() 
				{ 
					#1.3.4.������� ������� ���� ������ poultry
					I=$( mysql -u poultry -ppoultry -e "create database poultry;" 2>&1)
					
					if [ -n "$I" ]
						then
							#1.3.4.2. �� ���������� - ���������� ����������
							echo "mysql database already exists"
							exit 3
						else
							#1.3.4.1. �� �� ���� - ������� ������
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
						#���� ����� ��� - ������� 1.3.1.
						echo "mysql-user does not exist"
						I=$( mysql -u root -pfourthage -e "GRANT SELECT, INSERT, UPDATE, DELETE, LOCK TABLES, SHOW DATABASES, CREATE, DROP, FILE, INDEX, ALTER, CREATE TEMPORARY TABLES, EXECUTE, CREATE VIEW, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, EVENT, TRIGGER ON *.* TO 'poultry'@'localhost' IDENTIFIED BY 'poultry';" 2>&1)
						
						#echo "$I"
						if [ -n "$I" ]
							then
							#������������ �� ������� �������
								echo "can not create mysql-user poultry"
								exit 4
							else
								#��������� ������������� ���� ������ � �������
								echo "mysql-user poultry created"
								Check_bd_name_and_load_dump
						fi
					else
						#���� ����� ���� ����
						echo "mysql user already exists"
						#��������� ������������� ���� ������ � �������
						Check_bd_name_and_load_dump
				fi

				echo "mysql already install"
			else
				#���������� ���������� � ����� ������
				I=`apt-get -y -qq install mysql-server 2>/dev/null`
				#���� ������������, �� ��������� � ��������� �����
				if [ -n "$I" ]
					then
						#��������� ������������� ������������ 
						echo "mysql was install nice"
						#���� �� ������������ �� ������ ������ � ���������� ������
					else
						echo "network down"
						exit 2
				fi	
		fi
fi
exit 255