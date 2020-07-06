create user 'user'@'localhost' IDENTIFIED BY '123456';
grant select, update, insert, delete on chat.* to 'user'@'localhost';
flush privileges;