-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-03-2026 a las 02:41:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `asistenciasdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `attendances`
--

CREATE TABLE `attendances` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `clock_in` time DEFAULT NULL,
  `clock_out` time DEFAULT NULL,
  `status` enum('present','late','absent') DEFAULT 'present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `attendances`
--

INSERT INTO `attendances` (`id`, `user_id`, `date`, `clock_in`, `clock_out`, `status`, `created_at`, `updated_at`) VALUES
(3, 3, '2026-03-24', '02:05:56', '02:06:01', 'present', '2026-03-24 01:05:56', '2026-03-24 01:06:01'),
(4, 4, '2026-03-24', '02:12:42', '02:12:44', 'present', '2026-03-24 01:12:42', '2026-03-24 01:12:44'),
(5, 18, '2026-03-24', '02:13:33', '02:13:37', 'present', '2026-03-24 01:13:33', '2026-03-24 01:13:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`) VALUES
(1, 'Administrador', 'Administrator with full access'),
(2, 'Trabajador', 'Regular worker who can log attendances');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role_id`, `dni`, `first_name`, `last_name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, '00000000', 'Super', 'Admin', 'admin@example.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 00:43:09', '2026-03-24 00:46:10'),
(2, 2, '11111111', 'Juan', 'Perez', 'worker@example.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 00:43:09', '2026-03-24 00:46:10'),
(3, 2, '47753898', 'Jose', 'Becerra', 'jolubere.92@gmail.com', '$2y$10$Phpgo/lQffmBjZz4XUSTCOGFWMcYRnsmgXj6Y4RnzKOcOapt7PCUu', '2026-03-24 00:52:34', '2026-03-24 00:54:57'),
(4, 2, '45000001', 'Carlos', 'Gomez', 'carlos.g1@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(5, 2, '45000002', 'Lucia', 'Fernandez', 'lucia.f2@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(6, 2, '45000003', 'Miguel', 'Lopez', 'miguel.l3@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(7, 2, '45000004', 'Sofia', 'Martinez', 'sofia.m4@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(8, 2, '45000005', 'Jorge', 'Garcia', 'jorge.g5@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(9, 2, '45000006', 'Ana', 'Rodriguez', 'ana.r6@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(10, 2, '45000007', 'Luis', 'Perez', 'luis.p7@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(11, 2, '45000008', 'Maria', 'Sanchez', 'maria.s8@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(12, 2, '45000009', 'Pedro', 'Romero', 'pedro.r9@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(13, 2, '45000010', 'Elena', 'Sosa', 'elena.s10@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(14, 2, '45000011', 'Raul', 'Torres', 'raul.t11@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(15, 2, '45000012', 'Carmen', 'Ruiz', 'carmen.r12@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(16, 2, '45000013', 'Diego', 'Diaz', 'diego.d13@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(17, 2, '45000014', 'Laura', 'Vargas', 'laura.v14@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(18, 2, '45000015', 'Andres', 'Castro', 'andres.c15@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(19, 2, '45000016', 'Paula', 'Ortiz', 'paula.o16@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(20, 2, '45000017', 'Javier', 'Ramos', 'javier.r17@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(21, 2, '45000018', 'Isabel', 'Marin', 'isabel.m18@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(22, 2, '45000019', 'Fernando', 'Suarez', 'fernando.s19@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(23, 2, '45000020', 'Silvia', 'Blanco', 'silvia.b20@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(24, 2, '45000021', 'Hugo', 'Molina', 'hugo.m21@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(25, 2, '45000022', 'Marta', 'Delgado', 'marta.d22@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(26, 2, '45000023', 'Roberto', 'Navarro', 'roberto.n23@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(27, 2, '45000024', 'Patricia', 'Iglesias', 'patricia.i24@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(28, 2, '45000025', 'Alberto', 'Vidal', 'alberto.v25@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(29, 2, '45000026', 'Teresa', 'Garrido', 'teresa.g26@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(30, 2, '45000027', 'Mario', 'Cruz', 'mario.c27@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(31, 2, '45000028', 'Clara', 'Reyes', 'clara.r28@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(32, 2, '45000029', 'Enrique', 'Arias', 'enrique.a29@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50'),
(33, 2, '45000030', 'Beatriz', 'Pena', 'beatriz.p30@ejemplo.com', '$2y$10$upATEsTo708W4vFwLVXV/uxfss5KeNxe4csrg6kZdlHBWYn8mPB3u', '2026-03-24 01:10:50', '2026-03-24 01:10:50');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
