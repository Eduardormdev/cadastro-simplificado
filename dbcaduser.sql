-- Aula prática: Programação para Internet em Back-End
-- Importe este arquivo pelo phpMyAdmin (aba "Importar"), após iniciar o MySQL no XAMPP.
-- Banco DBCadUser; tabela usuario com exatamente os três campos exigidos.
-- A senha é protegida em PHP por password_hash() antes de ser gravada.

CREATE DATABASE IF NOT EXISTS `DBCadUser`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `DBCadUser`;

CREATE TABLE IF NOT EXISTS `usuario` (
  `nome` VARCHAR(120) NOT NULL,
  `email` VARCHAR(190) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
