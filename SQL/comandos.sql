use Fair;

/* selects */
select * from usuarios;
select * from evento;
select * from produto;
select * from pessoa;

SELECT * FROM pessoa pe, produto p WHERE p.id = 13 AND pe.nome = 'Mariana';
SELECT * FROM pessoa INNER JOIN produto ON produto.id = pessoa.produto_id AND produto.id = 16 AND pessoa.nome = 'Guilherme';

/* deletes */
DELETE FROM evento WHERE id != 1;
DELETE FROM pessoa where id > 7;

/* drops */
drop table usuarios;
drop table evento;
drop table produto;
drop table pessoa;