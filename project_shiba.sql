-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 30/10/2025 às 15:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `project_shiba`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `bathrooms`
--

CREATE TABLE `bathrooms` (
  `bathroomId` int(11) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `isPaid` tinyint(1) NOT NULL DEFAULT 0,
  `price` bigint(20) DEFAULT NULL,
  `lat` decimal(9,6) NOT NULL,
  `lon` decimal(9,6) NOT NULL,
  `ownerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `bathrooms`
--

INSERT INTO `bathrooms` (`bathroomId`, `description`, `isPaid`, `price`, `lat`, `lon`, `ownerId`) VALUES
(6, 'Pacheco&#039;s Bathroom', 1, 12, -29.366682, -51.108250, 1),
(7, 'Edelweiss Haus Hotel&#039;s Bathroom', 0, 0, -29.458908, -51.305565, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `bathrooms_images`
--

CREATE TABLE `bathrooms_images` (
  `id` int(11) NOT NULL,
  `image` text NOT NULL,
  `bathroomId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `bathrooms_images`
--

INSERT INTO `bathrooms_images` (`id`, `image`, `bathroomId`) VALUES
(4, 'img_69036821997283.73059984.jpg', 6),
(5, 'img_6903682199f418.72451653.jpg', 6),
(6, 'img_69036c493abfd8.70030249.jpg', 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `reviews`
--

CREATE TABLE `reviews` (
  `reviewId` int(11) NOT NULL,
  `comment` text NOT NULL,
  `bathroomId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reviews`
--

INSERT INTO `reviews` (`reviewId`, `comment`, `bathroomId`, `userId`) VALUES
(1, 'Muito bom este banheiro', 6, 1),
(2, 'Muito massa o banheiro', 6, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profilePicture` text DEFAULT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`userId`, `username`, `email`, `profilePicture`, `password`) VALUES
(1, 'paulo', 'paulo@gmail.com', 'img_69036c9855d9f0.36381957.png', '$2y$10$BjMbogbZEzGUW1g70sVZj.WeCMbf7ZseI4HAKyH00WEoMYlMu9pTq'),
(2, 'luiz', 'luiz@gmail.com', 'img_69036cb51d3a24.60574312.jpg', '$2y$10$4s3pAYa2lnj.jaNHM80peudD/UR4LKhjMxozgh/i2OFQaadQG8W..');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `bathrooms`
--
ALTER TABLE `bathrooms`
  ADD PRIMARY KEY (`bathroomId`),
  ADD KEY `ownerId` (`ownerId`);

--
-- Índices de tabela `bathrooms_images`
--
ALTER TABLE `bathrooms_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bathroomId` (`bathroomId`);

--
-- Índices de tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `bathroomId` (`bathroomId`),
  ADD KEY `userId` (`userId`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `bathrooms`
--
ALTER TABLE `bathrooms`
  MODIFY `bathroomId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `bathrooms_images`
--
ALTER TABLE `bathrooms_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `bathrooms`
--
ALTER TABLE `bathrooms`
  ADD CONSTRAINT `bathrooms_ibfk_1` FOREIGN KEY (`ownerId`) REFERENCES `users` (`userId`);

--
-- Restrições para tabelas `bathrooms_images`
--
ALTER TABLE `bathrooms_images`
  ADD CONSTRAINT `bathrooms_images_ibfk_1` FOREIGN KEY (`bathroomId`) REFERENCES `bathrooms` (`bathroomId`) ON DELETE CASCADE;

--
-- Restrições para tabelas `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`bathroomId`) REFERENCES `bathrooms` (`bathroomId`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
