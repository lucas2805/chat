drop database if exists chat;

create database chat character set utf8mb4 collate utf8mb4_general_ci;

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

create table salas (
id int unsigned not null primary key auto_increment,
disciplinas_id int unsigned not null,
usuarios_id int unsigned not null,
tema varchar(255) not null,
descricao text not null,
created_at timestamp not null default current_timestamp() on update current_timestamp(),
closed_at timestamp default null,
constraint fk_salas_disciplinas_id foreign key (disciplinas_id) references disciplinas (id),
constraint fk_salas_usuarios_id foreign key (usuarios_id) references usuarios (id),
constraint uq_salas_disciplinas_id__tema unique (disciplinas_id, tema)
);

create table mensagens (
id int unsigned not null primary key auto_increment,
salas_id int unsigned not null,
usuarios_id int unsigned not null,
conteudo text not null,
created_at timestamp not null default current_timestamp(),
constraint fk_mensagens_usuarios_id foreign key (usuarios_id) references usuarios (id),
constraint fk_mensagens_salas_id foreign key (salas_id) references salas (id)
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
('Linguagem de Programação'),
('Língua Portuguesa'),
('Arquitetura de Hardware'),
('Estatística'),
('Lógica de Programação'),
('Banco de Dados');

insert into salas
(disciplinas_id, usuarios_id, tema, descricao)
values
(3, 1, 'Processadores', 'Conceitos sobre ponteiro, registradores e outros recursos.'),
(1, 1, 'Javascript nos dias atuais', 'Abordagem sobre a aplicação, percentual de uso no mercado e boas práticas.'),
(6, 1, 'MySQL', 'Executar a linguagem SQL - Structured Query Language, ou Linguagem de Consulta Estruturada em QUALQUER banco de dados.'),
(5, 1, 'Estruturas de decisão', 'Utilizamos lógica para quase tudo em nossas vidas, nada mais justo que utilizarmos também para a área de TI. Você verá que todos os assuntos relacionados a TI obrigatoriamente utilizam conceitos e práticas que serão lecionados durante este curso.'),
(6, 1, 'Ambiente Transacional', 'Entender todo o ambiente trasacional e optar por continuar seus estudos em ambientes analíticos de Business Intelligence.'),
(1, 1, 'Python', 'Você será capaz de se tornar um especialista em programação web com algum framework Python.'),
(3, 1, 'Novas Tecnologias','Tecnologias avançadas para processadores: processadores RISC e CICS, superescalares, vetoriais e pipelines. Arquiteturas paralelas: taxonomias, computadores SIMD e MIMD, memória compartilhada e distribuída, arquiteturas não convencionais. Avaliação de desempenho de arquiteturas de computadores.');

insert into mensagens
(salas_id, usuarios_id, conteudo)
values
(1, 1, 'Prezados participantes. Alguém possui o conteúdo da matéria discutido na semana passada?'),
(1, 3, 'Bem-vindo ao nosso espaço para discussão do conteúdo acadêmico.'),
(1, 3, 'Em que podemos ajudá-lo?'),
(1, 1, 'Gostaria de revisar a aula desta disciplina ...');