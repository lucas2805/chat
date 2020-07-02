drop database if exists chat;

create database chat;

use chat;

create table usuarios (
id int unsigned not null primary key auto_increment,
login varchar(255) not null,
nome varchar(255) not null,
senha varchar(60) not null,
created_at timestamp not null default current_timestamp() on update current_timestamp()
);

create table dados_pessoais (
id int unsigned not null primary key auto_increment,
usuarios_id int unsigned not null unique,
cep varchar(10) default null,
residencia_numero int unsigned default null,
residencia_complemento varchar(255) default null,
email varchar(255) not null unique,
facebook varchar(255) default null,
github varchar(255) default null,
whatsapp_dd char(2) default null, 
whatsapp char(8) default null,
constraint fk_usuarios_id foreign key (usuarios_id) references usuarios (id)
);

create table disciplinas (
id int unsigned not null primary key auto_increment,
nome varchar(255) not null
);

insert into usuarios 
(login, nome, senha) 
values
('genildo', 'Genildo Martins', '123456'),
('guest', 'Guest', '123456'),
('admin', 'Administrador', '123456'),
('fulano', 'Fulano', '123456'),
('ciclano', 'Ciclano', '123456');

insert into disciplinas 
(nome) 
values 
('Cálculo Diferencial'),
('Lingua Portuguesa'),
('Matemática Aplicada'),
('Matemática Financeira'),
('Lógica de Programação'),
('Logística');

