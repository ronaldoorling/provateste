create database teste;
use teste;

CREATE TABLE  tarefas (
  id int(11) NOT NULL AUTO_INCREMENT,
  tarefa varchar(100) NOT NULL,
  descricao text,
  prioridade int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

insert into tarefas VALUES (1, 'Tarefa 1', 'Descrição da Tarefa 1', 1);
insert into tarefas VALUES (2, 'Tarefa 2', 'Descrição da Tarefa 2', 2);
