CREATE DATABASE trem_facil;
USE trem_facil;

CREATE TABLE `estacao` (
  `id_estacao` int NOT NULL,
  `nome` varchar(120) NOT NULL,
  `id_trem` int NOT NULL
);

CREATE TABLE `estacao_horario` (
  `id_estacao_horario` int NOT NULL,
  `id_linha` int NOT NULL,
  `nome_estacao` varchar(255) NOT NULL
);

INSERT INTO `estacao_horario` (`id_estacao_horario`, `id_linha`, `nome_estacao`) VALUES
(1, 1, 'Estação Príncipe'),
(2, 1, 'Estação Ruy Barbosa'),
(4, 3, 'Arno W. Dohler'),
(3, 3, 'Dona Francisca'),
(6, 4, 'Pirabeiraba'),
(5, 4, 'Vila Nova'),
(7, 5, 'Parque Douat'),
(8, 5, 'Rui Barbosa');

CREATE TABLE `estacoes` (
  `estacao_id` int NOT NULL,
  `nome_estacao` varchar(120) NOT NULL
);

INSERT INTO `estacoes` (`estacao_id`, `nome_estacao`) VALUES
(8, 'Estação Guanabara'),
(3, 'Estação Iririú'),
(4, 'Estação Itaum'),
(9, 'Estação Pirabeiraba'),
(5, 'Estação Vila Nova'),
(10, 'Outras Linhas'),
(1, 'Terminal Central'),
(2, 'Terminal Norte'),
(6, 'Terminal Sul'),
(7, 'Terminal Tupy');

CREATE TABLE `horario` (
  `id_horario` int NOT NULL,
  `id_estacao_horario` int NOT NULL,
  `hora` time NOT NULL
);

INSERT INTO `horario` (`id_horario`, `id_estacao_horario`, `hora`) VALUES
(1, 1, '05:30:00'),
(2, 1, '06:15:00'),
(3, 1, '07:00:00'),
(4, 1, '07:45:00'),
(5, 1, '08:30:00'),
(6, 1, '11:00:00'),
(7, 1, '13:00:00'),
(8, 1, '15:30:00'),
(9, 1, '17:30:00'),
(10, 1, '19:30:00'),
(11, 2, '06:00:00'),
(12, 2, '06:45:00'),
(13, 2, '07:30:00'),
(14, 2, '08:15:00'),
(15, 2, '09:00:00'),
(16, 2, '11:30:00'),
(17, 2, '13:30:00'),
(18, 2, '16:00:00'),
(19, 2, '18:00:00'),
(20, 2, '20:00:00'),
(21, 3, '06:00:00'),
(22, 3, '07:30:00'),
(23, 3, '09:00:00');

CREATE TABLE `linha` (
  `id_linha` int NOT NULL,
  `id_exibicao` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `status_color` varchar(10) NOT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `linha` (`id_linha`, `id_exibicao`, `nome`, `status`, `status_color`, `data_criacao`) VALUES
(1, 101, 'Costa e Silva Centro', 'Ativo', '#00c853', '2025-11-14 11:34:37'),
(2, 102, 'Pirabeiraba Centro', 'Inativo', '#d50000', '2025-11-14 11:34:37'),
(3, 103, 'Tupy / Norte via Centro', 'Ativo', '#00c853', '2025-11-14 11:34:37'),
(4, 104, 'Norte / Vila Nova via Walmor Harger', 'Ativo', '#00c853', '2025-11-14 11:34:37'),
(5, 105, 'Circulares Rui Barbosa', 'Ativo', '#00c853', '2025-11-14 11:34:37');

CREATE TABLE `linhas_trens` (
  `linha_id` int NOT NULL,
  `nome_linha` varchar(255) NOT NULL,
  `estacao_id` int NOT NULL
);

INSERT INTO `linhas_trens` (`linha_id`, `nome_linha`, `estacao_id`) VALUES
(1, 'Tupy / Norte via Centro', 1),
(2, 'Norte / Centro', 1),
(3, 'Tupy / Centro via Goes Monteiro', 1),
(4, 'Tupy / Centro', 1),
(5, 'Madrugadão Centro / Jardim Paraíso', 1),
(6, 'Espinheiros/Centro', 1),
(7, 'Norte / Centro via Dona Francisca', 1),
(8, 'Costa e Silva via IFSC / Centro', 1),
(9, 'Centro / Campus', 1),
(10, 'Costa e Silva / Centro', 1),
(11, 'Benjamin Constant / Centro', 1),
(12, 'Costa e Silva / Centro via Elza Meinert', 1),
(13, 'Anhanguera / Centro', 1),
(14, 'Jardim Diana / Centro', 1),
(15, 'IFSC via Benjamin Constant / Centro', 1),
(16, 'IFSC via Elza Meinert / Centro', 1),
(17, 'Itaum / Centro', 1),
(18, 'Itaum / Centro via Anitápolis', 1),
(19, 'Itaum / Centro via Procópio Gomes', 1),
(20, 'Vila Nova / Centro', 1),
(21, 'Madrugadão Centro / Vila Nova', 1),
(22, 'Guanabara/Centro', 1),
(23, 'Sul / Centro', 1),
(24, 'Escolinha / Centro', 1),
(25, 'Iririú / Centro', 1),
(26, 'Iririú / Centro via Castro Alves', 1),
(27, 'Madrugadão Espinheiros / Aventureiro', 1),
(28, 'Petrópolis', 1),
(29, 'Madrugadão Estevão de Matos', 1),
(30, 'Circular Noturno Itinga', 1),
(31, 'Morro do Meio/Centro', 1),
(32, 'Jativoca/Centro', 1),
(33, 'Jativoca/Centro via Olaria', 1),
(34, 'Morro do Meio / Centro via Ottokar Doerffel', 1),
(35, 'Morro do Meio/Centro via Cohab', 1),
(36, 'Rodoviária', 1),
(37, 'São Marcos', 1),
(38, 'Willy Tilp via São Marcos', 1),
(39, 'Willy Tilp', 1),
(40, 'Rodoviária via Centrinho', 1),
(41, 'Rodoviária via Sociesc', 1),
(42, 'Rodoviária via Otto Boehm', 1),
(43, 'Circular Ottokar Doerffel', 1),
(44, 'Circular Anita Garibaldi', 1),
(45, 'Colégio Celso Ramos / Centro', 1),
(46, 'Escola do Moinho/Centro', 1),
(47, 'Guanabara/Centro Escola do Moinho', 1),
(48, 'Circular Centro', 1),
(49, 'Mirante', 1),
(50, 'Costa e Silva / Centro via Rui Barbosa', 1),
(51, 'Pirabeiraba/Centro', 1),
(52, 'Sul/Centro via Nilo Peçanha', 1),
(53, 'Copacabana', 1),
(54, 'Tupy / Norte via Centro', 2),
(55, 'Norte / Centro', 2),
(56, 'Sul / Norte via Rodoviária', 2),
(57, 'Sul / Norte via Campus', 2),
(58, 'Dona Francisca via Morro Cortado', 2),
(59, 'Arno W. Dohler / Norte', 2),
(60, 'Norte / Iririú / Tupy', 2),
(61, 'Norte / Iririú via Saguaçú', 2),
(62, 'Norte / Centro via Dona Francisca', 2),
(63, 'Norte / Iririú', 2),
(64, 'Norte / Vila Nova via Walmor Harger', 2),
(65, 'Norte / Vila Nova via IFSC', 2),
(66, 'Norte / Vila Nova via João Miers', 2),
(67, 'Norte / Pirabeiraba', 2),
(68, 'Norte / Pirabeiraba via Ver. Guilherme Z.', 2),
(69, 'Norte/Pirabeiraba via Estrada da Ilha', 2),
(70, 'Norte / Sul', 2),
(71, 'Circular Parque Douat', 2),
(72, 'Circular Rui Barbosa', 2),
(73, 'Dona Francisca', 2),
(74, 'Bom Retiro via Campus', 2),
(75, 'Paraíso', 2),
(76, 'Canto do Rio Circular', 2),
(77, 'Norte / Campus', 2),
(78, 'Jardim Sofia', 2),
(79, 'Rui Barbosa via IFSC', 2),
(80, 'Eixo Industrial', 2),
(81, 'Bom Retiro via Barão de Teffé', 2),
(82, 'Paraíso via Canto do Rio', 2),
(83, 'Paraíso via Arno W. Dohler', 2),
(84, 'Canto do Rio via Arno W. Dohler', 2),
(85, 'Eixo Industrial via Bororós', 2),
(86, 'Norte / Clodoaldo Gomes', 2),
(87, 'Circular Norte', 2),
(88, 'Iririú / Pirabeiraba', 2),
(89, 'Itaum / Pirabeiraba', 2),
(90, 'Norte / Cubatão Raabe', 2),
(91, 'Norte / Rio Bonito', 2),
(92, 'Norte / Av. Edmundo Doubrawa', 2),
(93, 'Norte / Tia Marta', 2),
(94, 'Norte / Rio Bonito via Canela', 2),
(95, 'Norte / Perini', 2),
(96, 'Perini / Iririú / Tupy', 2),
(97, 'Itinga / Norte', 2),
(98, 'Ribeirão do Cubatão', 2),
(99, 'Pirabeiraba/Centro', 2),
(100, 'Norte / Quiriri', 2),
(101, 'Norte / Quiriri via Serra', 2),
(102, 'Norte / Quiriri via Serra', 2),
(103, 'Norte / Iririú / Tupy', 3),
(104, 'Campus / Iririú / Tupy', 3),
(105, 'Iririú / Campus', 3),
(106, 'Norte / Iririú via Saguaçú', 3),
(107, 'Norte / Iririú', 3),
(108, 'Tupy / Iririú', 3),
(109, 'Novos Horizontes via João Reinhold', 3),
(110, 'Comasa Iririú', 3),
(111, 'Jardim Iririú', 3),
(112, 'Iririú via Jardim Iririú', 3),
(113, 'Circular Cubatão', 3),
(114, 'Iririú via Novos Horizontes', 3),
(115, 'Cohab via Parque Joinville', 3),
(116, 'Circular Tuiuti', 3),
(117, 'Emílio Landmann', 3),
(118, 'Cohab', 3),
(119, 'Aventureiro Circular', 3),
(120, 'Vigorelli', 3),
(121, 'Cubatão', 3),
(122, 'Paraíso / Iririú', 3),
(123, 'Parque Joinville', 3),
(124, 'Aventureiro Cohab via Emílio Landmann', 3),
(125, 'Aeroporto via Emilio Landmann', 3),
(126, 'Costa e Silva / Tupy via Iririú', 3),
(127, 'Iririú / Pirabeiraba', 3),
(128, 'Perini / Iririú / Tupy', 3),
(129, 'Iririú / Sul', 3),
(130, 'Iririú / Centro', 3),
(131, 'Iririú / Centro via Castro Alves', 3),
(132, 'Sul / Guanabara via Itaum', 4),
(133, 'Itaum / Sul via João Ramalho', 4),
(134, 'Sul / Itaum', 4),
(135, 'Itaum / Guanabara via Agulhas Negras', 4),
(136, 'Itaum / Centro', 4),
(137, 'Itaum / Centro via Anitápolis', 4),
(138, 'Itaum / Centro via Procópio Gomes', 4),
(139, 'Itaum / Campus via Guanabara', 4),
(140, 'Itaum / Pirabeiraba', 4),
(141, 'Jarivatuba', 4),
(142, 'Morro do Amaral', 4),
(143, 'Padre Roma', 4),
(144, 'Estevão de Matos', 4),
(145, 'Jardim Edilene', 4),
(146, 'Rua Colombo', 4),
(147, 'Paranaguamirim', 4),
(148, 'Circular Guarani', 4),
(149, 'Morro do Amaral via Jardim Edilene', 4),
(150, 'Jarivatuba via Padre Roma', 4),
(151, 'Paranaguamirim via Monsenhor Gercino', 4),
(152, 'Madrugadão Estevão de Matos', 4),
(153, 'Colégio Celso Ramos / Guanabara / Itaum', 4),
(154, 'Itaum / Lepper via Guanabara', 4),
(155, 'Norte/Itaum', 4),
(156, 'Norte / Vila Nova via Walmor Harger', 5),
(157, 'Norte / Vila Nova via IFSC', 5),
(158, 'Norte / Vila Nova via João Miers', 5),
(159, 'Vila Nova', 5),
(160, 'Bento T. da Rocha', 5),
(161, 'Paulo Schneider', 5),
(162, 'João Miers', 5),
(163, 'Paulo Schneider via Vila Nova', 5),
(164, 'Bento T. da Rocha via Parque XV', 5),
(165, 'Estrada Anaburgo', 5),
(166, 'Estrada Anaburgo via Bororós', 5),
(167, 'Circular Bororós', 5),
(168, 'Bento T. da Rocha via Vila Nova', 5),
(169, 'Vila Nova via Estrada do Sul', 5),
(170, 'Vila Nova via Cristo Rei', 5),
(171, 'Estrada Blumenau via SaltoII', 5),
(172, 'Circular Oeste', 5),
(173, 'Salão Jacob', 5),
(174, 'Circular Oeste via Estrada Blumenau', 5),
(175, 'Vila Nova / Centro', 5),
(176, 'Sul / Campus', 6),
(177, 'Sul / Norte via Rodoviária', 6),
(178, 'Sul / Norte via Campus', 6),
(179, 'Sul / Guanabara via Itaum', 6),
(180, 'Itaum / Sul via João Ramalho', 6),
(181, 'Sul / Itaum', 6),
(182, 'Norte / Sul', 6),
(183, 'Sul / Centro', 6),
(184, 'Itinga / Norte', 6),
(185, 'Escolinha / Centro', 6),
(186, 'Circular Noturno Itinga', 6),
(187, 'Colégio Celso Ramos / Sul', 6),
(188, 'Viqua / Sul', 6),
(189, 'Plasbohn / Sul', 6),
(190, 'Colégio Rudolfo Meyer / Sul', 6),
(191, 'Colégio Dom Pio / Sul', 6),
(192, 'Iririú/Sul', 6),
(193, 'Escolinha via Boehmerwaldt', 6),
(194, 'Itinga', 6),
(195, 'Profipo', 6),
(196, 'Km 11', 6),
(197, 'Escolinha via Santa Helena', 6),
(198, 'Estrada Parati via Othon Mader', 6),
(199, 'Rua Portugal', 6),
(200, 'Ronco D\' Água', 6),
(201, 'Porto Rico', 6),
(202, 'Sul/Centro via Nilo Peçanha', 6),
(203, 'Copacabana', 6),
(204, 'Eixo Sul', 6),
(205, 'Ronco D\' Água via Thaiti', 6),
(206, 'Itinga via Profipo', 6),
(207, 'Eixo Sul via BR 101', 6),
(208, 'Sul / Rodoviária', 6),
(209, 'Km 11 via Cidade de Luziana', 6),
(210, 'Circular Santa Catarina', 6),
(211, 'Circular Rua São Paulo', 6),
(212, 'Tupy / Norte via Centro', 7),
(213, 'Tupy / Centro via Goes Monteiro', 7),
(214, 'Tupy / Centro', 7),
(215, 'Espinheiros/Centro', 7),
(216, 'Norte / Iririú / Tupy', 7),
(217, 'Campus / Iririú / Tupy', 7),
(218, 'Tupy / Iririú', 7),
(219, 'Tupy / Guanabara', 7),
(220, 'Aventureiro / Tupy', 7),
(221, 'Costa e Silva / Tupy via Iririú', 7),
(222, 'Espinheiros', 7),
(223, 'Circular Ponte Serrada', 7),
(224, 'Goes Monteiro Circular', 7),
(225, 'Praia Grande via Baltazar Buschle', 7),
(226, 'Dom Gregório Warmeling', 7),
(227, 'Perini / Iririú / Tupy', 7),
(228, 'Espinheiros via Baltazar Buschle', 7),
(229, 'Sul / Guanabara via Itaum', 8),
(230, 'Itaum / Guanabara via Agulhas Negras', 8),
(231, 'Tupy / Guanabara', 8),
(232, 'Itaum / Campus via Guanabara', 8),
(233, 'Guanabara/Centro', 8),
(234, 'Circular Adhemar Garcia', 8),
(235, 'Ulysses Guimarães', 8),
(236, 'Teresópolis', 8),
(237, 'José Loureiro', 8),
(238, 'Ulysses via José Loureiro', 8),
(239, 'José Loureiro via Jarivatuba', 8),
(240, 'Colégio Celso Ramos / Guanabara / Itaum', 8),
(241, 'Itaum / Lepper via Guanabara', 8),
(242, 'Guanabara/Centro Escola do Moinho', 8),
(243, 'Norte / Pirabeiraba', 9),
(244, 'Norte / Pirabeiraba via Ver. Guilherme Z.', 9),
(245, 'Norte/Pirabeiraba via Estrada da Ilha', 9),
(246, 'Itaum / Pirabeiraba', 9),
(247, 'Norte / Rio Bonito', 9),
(248, 'Norte / Tia Marta', 9),
(249, 'Norte / Rio Bonito via Canela', 9),
(250, 'Pirabeiraba / Rio da Prata Final', 9),
(251, 'Pirabeiraba / Rio da Prata', 9),
(252, 'Pirabeiraba / Estrada Milderau', 9),
(253, 'Pirabeiraba / Estrada Pirabeiraba', 9),
(254, 'Pirabeiraba / Escola Agrícola', 9),
(255, 'Pirabeiraba / Rio Bonito', 9),
(256, 'Pirabeiraba / Bairro', 9),
(257, 'Pirabeiraba / Cubatão Raabe', 9),
(258, 'Pirabeiraba / Estrada do Oeste via Canela', 9),
(259, 'Pirabeiraba / Tia Marta', 9),
(260, 'Pirabeiraba / Rio Bonito via Canela', 9),
(261, 'Pirabeiraba / Estrada Fazenda', 9),
(262, 'Pirabeiraba / Estrada do Oeste', 9),
(263, 'Pirabeiraba / Rio Bonito via Estrada do Oeste', 9),
(264, 'Pirabeiraba / Quiriri', 9),
(265, 'Pirabeiraba / Quiriri via Serra', 9),
(266, 'Pirabeiraba / Quiriri Final', 9),
(267, 'Pirabeiraba / Quiriri Final via Serra', 9),
(268, 'Norte / Quiriri', 9),
(269, 'Norte / Quiriri via Serra', 9),
(270, 'Avelino Marcante / Estrada da Ilha', 10),
(271, 'Avelino Marcante /Jardim Kelly', 10),
(272, 'Avelino Marcante / Estrada da Ilha / Jardim Kelly', 10),
(273, 'Estevão de Matos / Nilson Bender', 10);

CREATE TABLE `parada` (
  `id_parada` int NOT NULL,
  `id_linha` int NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tempo` varchar(50) NOT NULL
);

INSERT INTO `parada` (`id_parada`, `id_linha`, `nome`, `tempo`) VALUES
(1, 1, 'Estação do Príncipe - Centro', 'Agora'),
(2, 1, 'Estação Ruy Barbosa - Costa e Silva', '15 min'),
(3, 3, 'Dona Francisca via Morro Cortado', 'Agora'),
(4, 3, 'Arno W. Dohler / Norte', '10 min'),
(5, 4, 'Vila Nova via João Miers', 'Agora'),
(6, 4, 'Pirabeiraba', '20 min'),
(7, 5, 'Circular Parque Douat', 'Agora'),
(8, 5, 'Circular Rui Barbosa', '5 min');

CREATE TABLE `rota` (
  `id_rota` int NOT NULL,
  `nome` varchar(120) NOT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_sensor` int NOT NULL
);

CREATE TABLE `rotas` (
  `id_rotas` int NOT NULL,
  `nome_rotas` varchar(120) NOT NULL,
  `data_rotas` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `FKid_sensores` int DEFAULT NULL,
  `FKid_trens` int DEFAULT NULL,
  `parada_prevista` datetime DEFAULT NULL
);

CREATE TABLE `sensor` (
  `id_sensor` int NOT NULL,
  `nome` varchar(120) NOT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'ATIVO',
  `localizacao` varchar(120) DEFAULT 'DESCONHECIDA',
  `ultima_atualizacao_texto` varchar(50) DEFAULT 'AGORA',
  `ultima_atualizacao_valor` varchar(20) DEFAULT '0',
  `ultima_atualizacao_unidade` varchar(10) DEFAULT 'KM/H'
);

INSERT INTO `sensor` (`id_sensor`, `nome`, `data_criacao`, `status`, `localizacao`, `ultima_atualizacao_texto`, `ultima_atualizacao_valor`, `ultima_atualizacao_unidade`) VALUES
(1, 'SENSOR 1', '2025-11-14 11:21:31', 'ATIVO', 'X', '5 MIN', '120', 'KM/H'),
(2, 'SENSOR 2', '2025-11-14 11:21:31', 'INATIVO', 'Y', '1 H', '80', 'KM/H'),
(3, 'SENSOR 3', '2025-11-14 11:21:31', 'ATIVO', 'Z', '1 MIN', '150', 'KM/H');

CREATE TABLE `sensores` (
  `id_sensores` int NOT NULL,
  `nome_sensor` varchar(120) NOT NULL,
  `data_sensor` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `trem` (
  `id_trem` int NOT NULL,
  `nome` varchar(120) NOT NULL,
  `horario` time NOT NULL,
  `parada` varchar(120) NOT NULL
);

CREATE TABLE `trens` (
  `id_trens` int NOT NULL,
  `nome_tren` varchar(120) NOT NULL,
  `horario` varchar(255) DEFAULT NULL,
  `parada_tren` varchar(120) NOT NULL,
  `status_trens` tinyint NOT NULL DEFAULT '1'
);

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nome_completo` varchar(120) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuario` int NOT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `usuario` (`id_usuario`, `nome_completo`, `email`, `telefone`, `cep`, `cpf`, `senha`, `tipo_usuario`, `data_criacao`) VALUES
(1, 'Rafael Almeida', 'rafael_almeida@gmail.com', '11987654321', '01234567', '12345678901', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, '2025-11-14 11:21:31'),
(2, 'Andriel', 'andriel@gmail.com', '11987654322', '01234568', '12345678902', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '2025-11-14 11:21:31'),
(3, 'Arthur', 'arthur@gmail.com', '11987654323', '01234569', '12345678903', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '2025-11-14 11:21:31'),
(4, 'Caio', 'caio@gmail.com', '11987654324', '01234570', '12345678904', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 2, '2025-11-14 11:21:31');

CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nome_completo` varchar(120) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `CEP` varchar(8) NOT NULL,
  `CPF` varchar(11) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo_usuarios` varchar(20) NOT NULL,
  `data_cadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

ALTER TABLE `estacao`
  ADD PRIMARY KEY (`id_estacao`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `id_trem` (`id_trem`);

ALTER TABLE `estacao_horario`
  ADD PRIMARY KEY (`id_estacao_horario`),
  ADD UNIQUE KEY `id_linha` (`id_linha`,`nome_estacao`);

ALTER TABLE `estacoes`
  ADD PRIMARY KEY (`estacao_id`),
  ADD UNIQUE KEY `nome_estacao` (`nome_estacao`);

ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_estacao_horario` (`id_estacao_horario`);

ALTER TABLE `linha`
  ADD PRIMARY KEY (`id_linha`),
  ADD UNIQUE KEY `id_exibicao` (`id_exibicao`);

ALTER TABLE `linhas_trens`
  ADD PRIMARY KEY (`linha_id`),
  ADD KEY `estacao_id` (`estacao_id`);

ALTER TABLE `parada`
  ADD PRIMARY KEY (`id_parada`),
  ADD KEY `id_linha` (`id_linha`);

ALTER TABLE `rota`
  ADD PRIMARY KEY (`id_rota`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD KEY `id_sensor` (`id_sensor`);

ALTER TABLE `rotas`
  ADD PRIMARY KEY (`id_rotas`),
  ADD UNIQUE KEY `nome_rotas` (`nome_rotas`),
  ADD KEY `FKid_sensores` (`FKid_sensores`),
  ADD KEY `FKid_trens` (`FKid_trens`);

ALTER TABLE `sensor`
  ADD PRIMARY KEY (`id_sensor`),
  ADD UNIQUE KEY `nome` (`nome`);

ALTER TABLE `sensores`
  ADD PRIMARY KEY (`id_sensores`),
  ADD UNIQUE KEY `nome_sensor` (`nome_sensor`);

ALTER TABLE `trem`
  ADD PRIMARY KEY (`id_trem`),
  ADD UNIQUE KEY `nome` (`nome`),
  ADD UNIQUE KEY `horario` (`horario`),
  ADD UNIQUE KEY `parada` (`parada`);

ALTER TABLE `trens`
  ADD PRIMARY KEY (`id_trens`),
  ADD UNIQUE KEY `nome_tren` (`nome_tren`),
  ADD UNIQUE KEY `parada_tren` (`parada_tren`),
  ADD UNIQUE KEY `horario` (`horario`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `cep` (`cep`),
  ADD UNIQUE KEY `cpf` (`cpf`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nome_completo` (`nome_completo`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `telefone` (`telefone`),
  ADD UNIQUE KEY `CEP` (`CEP`),
  ADD UNIQUE KEY `CPF` (`CPF`),
  ADD UNIQUE KEY `senha` (`senha`);

ALTER TABLE `estacao`
  MODIFY `id_estacao` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `estacao_horario`
  MODIFY `id_estacao_horario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `estacoes`
  MODIFY `estacao_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `horario`
  MODIFY `id_horario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

ALTER TABLE `linha`
  MODIFY `id_linha` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `linhas_trens`
  MODIFY `linha_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

ALTER TABLE `parada`
  MODIFY `id_parada` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `rota`
  MODIFY `id_rota` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `rotas`
  MODIFY `id_rotas` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `sensor`
  MODIFY `id_sensor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=830;

ALTER TABLE `sensores`
  MODIFY `id_sensores` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `trem`
  MODIFY `id_trem` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `trens`
  MODIFY `id_trens` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1106;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `estacao`
  ADD CONSTRAINT `estacao_ibfk_1` FOREIGN KEY (`id_trem`) REFERENCES `trem` (`id_trem`);

ALTER TABLE `estacao_horario`
  ADD CONSTRAINT `estacao_horario_ibfk_1` FOREIGN KEY (`id_linha`) REFERENCES `linha` (`id_linha`) ON DELETE CASCADE;

ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_estacao_horario`) REFERENCES `estacao_horario` (`id_estacao_horario`) ON DELETE CASCADE;

ALTER TABLE `linhas_trens`
  ADD CONSTRAINT `linhas_trens_ibfk_1` FOREIGN KEY (`estacao_id`) REFERENCES `estacoes` (`estacao_id`);

ALTER TABLE `parada`
  ADD CONSTRAINT `parada_ibfk_1` FOREIGN KEY (`id_linha`) REFERENCES `linha` (`id_linha`) ON DELETE CASCADE;

ALTER TABLE `rota`
  ADD CONSTRAINT `rota_ibfk_1` FOREIGN KEY (`id_sensor`) REFERENCES `sensor` (`id_sensor`);

ALTER TABLE `rotas`
  ADD CONSTRAINT `rotas_ibfk_1` FOREIGN KEY (`FKid_sensores`) REFERENCES `sensores` (`id_sensores`),
  ADD CONSTRAINT `rotas_ibfk_2` FOREIGN KEY (`FKid_trens`) REFERENCES `trens` (`id_trens`);
COMMIT;

INSERT INTO horario (id_estacao_horario, hora) VALUES
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Dona Francisca' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 103)), '06:00:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Dona Francisca' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 103)), '07:30:00'),
((SELECT id_estacao_horario FROM estacao_horario WHERE nome_estacao = 'Dona Francisca' AND id_linha = (SELECT id_linha FROM linha WHERE id_exibicao = 103)), '09:00:00');

USE trem_facil;

-- 1. Desativa verificações de segurança temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Usa DELETE em vez de TRUNCATE (Isso corrige o erro #1701)
DELETE FROM `linha`;

-- 3. Reseta o contador de IDs para começar do 1 (opcional, mas bom para organização)
ALTER TABLE `linha` AUTO_INCREMENT = 1;

-- 4. INSERE AS LINHAS DE JOINVILLE
-- Cores: #00c853 (Verde), #ffeb3b (Amarelo), #d50000 (Vermelho)

INSERT INTO `linha` (`id_exibicao`, `nome`, `status`, `status_color`) VALUES
(0040, 'Norte / Centro', 'Ativo', '#00c853'),
(0041, 'Norte / Centro via Dona Francisca', 'Ativo', '#00c853'),
(0130, 'Norte / Iririú / Tupy', 'Ativo', '#00c853'),
(0200, 'Norte / Visconde de Taunay', 'Ativo', '#00c853'),
(0242, 'Costa e Silva / Centro via Benjamin Constant', 'Manutenção', '#ffeb3b'),
(0247, 'Costa e Silva / Centro via Elza Meinert', 'Ativo', '#00c853'),
(0290, 'Costa e Silva / Tupy via Iririú', 'Inativo', '#d50000'),
(0300, 'Itaum / Centro', 'Ativo', '#00c853'),
(0302, 'Itaum / Centro via Anitápolis', 'Ativo', '#00c853'),
(0304, 'Itaum / Centro via Procópio Gomes', 'Ativo', '#00c853'),
(0306, 'Itaum / Campus via Guanabara', 'Manutenção', '#ffeb3b'),
(0401, 'Praia Grande via Baltazar Buschle', 'Ativo', '#00c853'),
(0403, 'Espinheiros', 'Ativo', '#00c853'),
(0500, 'Vila Nova / Centro', 'Ativo', '#00c853'),
(0501, 'Vila Nova / Centro via Lajeado', 'Ativo', '#00c853'),
(0600, 'Guanabara/Centro', 'Ativo', '#00c853'),
(0601, 'Guanabara/Centro Escola do Moinho', 'Inativo', '#d50000'),
(0650, 'Nova Brasília / Centro', 'Ativo', '#00c853'),
(0700, 'Sul / Centro', 'Ativo', '#00c853'),
(0702, 'Sul / Centro via Nilo Peçanha', 'Ativo', '#00c853'),
(0800, 'Iririú / Centro', 'Ativo', '#00c853'),
(0801, 'Iririú / Centro via Saguaçu', 'Ativo', '#00c853'),
(0802, 'Iririú / Centro via Castro Alves', 'Ativo', '#00c853'),
(0900, 'Rodoviária', 'Manutenção', '#ffeb3b'),
(1201, 'Getúlio Vargas', 'Ativo', '#00c853'),
(1206, 'Estevão de Matos', 'Ativo', '#00c853'),
(1209, 'Jardim Edilene', 'Inativo', '#d50000'),
(1401, 'Petrópolis', 'Ativo', '#00c853'),
(1411, 'Circular Noturno Itinga', 'Ativo', '#00c853'),
(1512, 'Morro do Meio/Centro', 'Ativo', '#00c853'),
(1513, 'Jativoca/Centro', 'Manutenção', '#ffeb3b'),
(1514, 'Jativoca/Centro via Olaria', 'Ativo', '#00c853'),
(1601, 'Rodoviária via Centrinho', 'Ativo', '#00c853'),
(1602, 'Rodoviária via Sociesc', 'Ativo', '#00c853'),
(1603, 'Rodoviária via Otto Boehm', 'Ativo', '#00c853'),
(1605, 'Rodoviária via Paula Ramos', 'Ativo', '#00c853'),
(1704, 'Itaum / Doutor João Colin', 'Ativo', '#00c853'),
(1706, 'Sul / Doutor João Colin', 'Ativo', '#00c853'),
(1720, 'Colégio Celso Ramos / Centro', 'Inativo', '#d50000'),
(1725, 'Escola do Moinho/Centro', 'Inativo', '#d50000'),
(2010, 'Circular Centro', 'Ativo', '#00c853'),
(2015, 'Mirante', 'Manutenção', '#ffeb3b'),
(3001, 'Tupy / Norte via Centro', 'Ativo', '#00c853'),
(3002, 'Tupy / Centro via Goes Monteiro', 'Ativo', '#00c853'),
(3003, 'Tupy / Centro', 'Ativo', '#00c853'),
(3004, 'Espinheiros/Centro', 'Ativo', '#00c853'),
(4016, 'Pirabeiraba/Centro', 'Ativo', '#00c853'),
(4017, 'Pirabeiraba / Rio Bonito', 'Ativo', '#00c853'),
(4020, 'Pirabeiraba / Quiriri', 'Ativo', '#00c853'),
(4030, 'Pirabeiraba / Estrada do Oeste', 'Manutenção', '#ffeb3b'),
(4033, 'Pirabeiraba / Rio da Prata', 'Ativo', '#00c853'),
(4100, 'Norte / Quiriri', 'Ativo', '#00c853'),
(4103, 'Norte / Rio Bonito', 'Ativo', '#00c853'),
(7001, 'Escolinha / Centro', 'Ativo', '#00c853'),
(7002, 'Escolinha via Boehmerwaldt', 'Ativo', '#00c853'),
(7003, 'Escolinha via Santa Helena', 'Ativo', '#00c853');

-- 5. Reativa verificações de segurança
SET FOREIGN_KEY_CHECKS = 1;