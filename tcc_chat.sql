drop database if exists chat;

create database chat;

use chat;

create table usuarios (
id int unsigned not null primary key auto_increment,
login varchar(255) not null unique,
nome varchar(255) not null,
senha varchar(255) not null,
email varchar(255) not null unique,
created_at timestamp not null default current_timestamp() on update current_timestamp(),
updated_at timestamp default null on update current_timestamp()
);

create table disciplinas (
id int unsigned not null primary key auto_increment,
nome varchar(255) not null unique,
created_at timestamp not null default current_timestamp() on update current_timestamp(),
updated_at timestamp default null on update current_timestamp()
);

insert into usuarios 
(login, nome, senha, email) 
values
('genildom', 'Genildo Martins', '$2y$10$9BXd.3lL0R8YelrzJkWCZOEBFXDxaPlhEBTUqzZzdV.xNpj5Hq5iG','genildovsm@gmail.com'),
('guest', 'Guest', '$2y$10$mFjPoG8aUlw6OsabJ7qEKOpo31M4n3eacbUPI4zPBp9iVwniKFSNa','guest@gmail.com'),
('admin', 'Administrador', '$2y$10$ow1odZWxP25PmBsJOJKieuLB2HVMMqaNaHipZjiYgfbS5JXhqJXTC','admin@gmail.com'),
('fulano', 'Fulano', '$2y$10$s/XdSqObwOw1kAXPLwqa2Or2Ey9ZUwPgf4x.gCfLaBJCcksWDcmgK','fulano@gmail.com'),
('ciclano', 'Ciclano', '$2y$10$oWr0B2WqD73IbRfzVHPCMuVlVhxss6PwcHvguXKVdMVjhNulKnoHi','ciclano@gmail.com'),
('beltrano', 'Beltrano da Silva Pinheiro', '$2y$10$3YzgrFyGg.VgqHRHu0upVeI3gsdZ5PCLF7H79rHz3T3.xFoGrAjdm', 'beltrano@gmail.com');

insert into disciplinas 
(nome) 
values 
('Cálculo Diferencial'),
('Lingua Portuguesa'),
('Matemática'),
('Estatística'),
('Lógica de Programação'),
('Banco de Dados');

