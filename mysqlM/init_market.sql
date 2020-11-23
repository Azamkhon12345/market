INSERT INTO mysql.user (Host, User, Password) VALUES ('%', 'root', password('root'));
GRANT ALL ON *.* TO 'root'@'%' WITH GRANT OPTION;
