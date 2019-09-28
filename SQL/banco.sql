CREATE DATABASE Fair;
USE Fair;

CREATE TABLE IF NOT EXISTS usuarios(
id int auto_increment not null primary key,
email varchar(100) not null,
nome varchar(50) not null,
sobrenome varchar(50) not null,
senha varchar(50) not null
);

select * from produto;

DELETE FROM produto WHERE id > 20;

CREATE TABLE IF NOT EXISTS evento(
id int auto_increment not null primary key,
nome varchar(50),
usuario_id int,
foreign key(usuario_id) references usuarios(id)
);

CREATE TABLE IF NOT EXISTS produto(
id int not null auto_increment primary key,
nome varchar(50),
evento_id int,
foreign key(evento_id) references evento(id)
);

CREATE TABLE IF NOT EXISTS pessoa(
id int not null auto_increment primary key,
nome varchar(50),
produto_id int,
foreign key(produto_id) references produto(id)
);
