SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `pessoas` (
`id` int(9)
,`nome` varchar(100)
,`data_nascimento` date
,`email` varchar(100)
,`telefone` varchar(15)
,`score` int(3)
,`unidade_id` int(9)
,`regiao` varchar(50)
,`unidade` varchar(50)
);

CREATE TABLE `regioes` (
  `id` int(9) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `unidades` (
  `id` int(9) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `regiao_id` int(9) NOT NULL,
  `pontuacao` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usuarios` (
  `id` int(9) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `score` int(3) NOT NULL,
  `unidade_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `pessoas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pessoas`  AS  select `usuarios`.`id` AS `id`,`usuarios`.`nome` AS `nome`,`usuarios`.`data_nascimento` AS `data_nascimento`,`usuarios`.`email` AS `email`,`usuarios`.`telefone` AS `telefone`,`usuarios`.`score` AS `score`,`usuarios`.`unidade_id` AS `unidade_id`,`regioes`.`nome` AS `regiao`,`unidades`.`nome` AS `unidade` from ((`usuarios` join `unidades` on((`unidades`.`id` = `usuarios`.`unidade_id`))) join `regioes` on((`regioes`.`id` = `unidades`.`regiao_id`))) ;


ALTER TABLE `regioes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regiao_id` (`regiao_id`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unidade_id` (`unidade_id`);


ALTER TABLE `regioes`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `unidades`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE `usuarios`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

ALTER TABLE `unidades`
  ADD CONSTRAINT `unidades_ibfk_1` FOREIGN KEY (`regiao_id`) REFERENCES `regioes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`unidade_id`) REFERENCES `unidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
