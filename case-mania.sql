-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-01-2025 a las 22:14:45
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `case-mania`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacens`
--

CREATE TABLE `almacens` (
  `id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED DEFAULT NULL,
  `producto_id` bigint UNSIGNED NOT NULL,
  `cantidad` int NOT NULL,
  `cantidad_acumulada` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `active`, `created_at`, `updated_at`) VALUES
(4, 'Audífonos de Casco Inalámbrico', 1, '2024-12-23 02:02:54', '2024-12-23 02:29:09'),
(5, 'Cables USB', 1, '2024-12-23 02:06:55', '2024-12-23 02:06:55'),
(6, 'Cornetas Inalámbrica', 1, '2024-12-23 02:07:21', '2024-12-23 02:07:21'),
(7, 'Carros de Juguete', 1, '2024-12-23 02:07:54', '2024-12-23 02:07:54'),
(8, 'Cargador de Teléfono', 1, '2024-12-23 02:09:14', '2024-12-23 02:09:14'),
(9, 'Tiras de Teléfono', 1, '2024-12-23 02:09:48', '2024-12-23 02:09:48'),
(10, 'Forros de Teléfono Samsung', 1, '2024-12-23 02:11:33', '2024-12-23 02:11:33'),
(11, 'Micrófonos de Corbata', 1, '2024-12-23 13:07:21', '2024-12-23 13:07:21'),
(12, 'Micrófonos Inalámbrico', 1, '2024-12-23 13:12:59', '2024-12-23 13:12:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `tipo_documento`, `num_documento`, `telefono`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Drew Hamill', '157 Rhianna Loop\nLake Paxton, WA 10912-4068', 'V', '4502653', '82149', 'brannon13@example.org', 'inactive', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(2, 'Dr. Kayley Bosco Jr.', '795 Candice Viaduct\nSouth Jenniferport, IN 65823', 'E', '2962849', '27608', 'hodkiewicz.hilda@example.org', 'inactive', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(3, 'Nora Rath I', '373 Alene Port Apt. 953\nSchadenfurt, NH 29668-0215', 'J', '4569289', '57705', 'bhintz@example.net', 'active', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(4, 'Darian Cummings', '377 Randy Overpass Apt. 020\nNew Wilbert, HI 73761', 'J', '4121891', '69370', 'fletcher.keeling@example.org', 'inactive', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(5, 'Fermin Kertzmann', '9505 Bednar Courts Suite 572\nKamrenside, OH 30869', 'J', '4593806', '60116', 'gerhold.adelia@example.org', 'active', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(6, 'Dr. Marilou Kovacek', '91959 Wisozk Heights\nWest Aaron, ME 06482', 'V', '2560437', '66959', 'hand.grady@example.org', 'active', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(7, 'Lura Tremblay PhD', '85040 Mateo Divide Apt. 425\nUptonberg, LA 56243-2233', 'E', '1075828', '40267', 'wswift@example.com', 'inactive', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(8, 'Addie Schuppe', '17406 Rocio Well\nWest Jamel, MS 88130-9436', 'E', '7374223', '56664', 'franecki.savannah@example.org', 'inactive', '2024-12-06 19:04:48', '2024-12-06 19:04:48'),
(9, 'Lavon Muller', '7060 Leannon Orchard\nSouth Lourdesshire, TN 77058-8594', 'J', '2787882', '58817', 'tyreek.hoppe@example.net', 'inactive', '2024-12-06 19:04:48', '2024-12-21 00:48:14'),
(10, 'Miss Cecilia Jenkins III', '281 Schoen Ridges Suite 386\nPort Alexzanderhaven, MN 08873', 'E', '2316367', '35366', 'rocky38@example.net', 'inactive', '2024-12-06 19:04:48', '2024-12-06 19:04:48'),
(11, 'Rolando Duran', 'AV. Principal La Pedrera Callejón Los Cocos Quinta Liliana#170', 'V', '4553635', '0412-9279418', NULL, 'active', '2024-12-29 15:46:30', '2024-12-29 15:46:30'),
(12, 'Edwin Velásquez', 'El Limón AV. Principal Callejón Delicias #14', 'V', '15274580', '0424-3498925', 'edwinvelasquezm@hotmail.com', 'active', '2024-12-29 15:51:25', '2024-12-29 15:51:25'),
(13, 'Marlene Martínez', 'Av. Principal La Pedrera Callejón Los Cocos Quinta Liliana #170', 'V', '5262915', '0412-0774397', NULL, 'active', '2024-12-30 16:21:54', '2024-12-30 16:21:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint UNSIGNED NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `tasa_bcv` double(8,2) NOT NULL,
  `fecha_compra` date NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `iva` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `status_carga` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `sucursal_id`, `tasa_bcv`, `fecha_compra`, `subtotal`, `iva`, `total`, `status_carga`, `created_at`, `updated_at`) VALUES
(4, 6, 1, 51.64, '2024-12-26', 17.00, 2.72, 19.72, 1, '2024-12-26 18:15:16', '2024-12-26 19:40:18'),
(5, 2, 1, 51.64, '2024-12-26', 12.00, 1.92, 13.92, 1, '2024-12-26 18:30:39', '2024-12-26 19:41:12'),
(9, 3, 1, 51.93, '2024-12-29', 76.50, 12.24, 88.74, 1, '2024-12-29 16:04:49', '2024-12-29 16:05:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deliveries`
--

CREATE TABLE `deliveries` (
  `id` bigint UNSIGNED NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `referencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_delivery` double(8,2) NOT NULL,
  `detalles_entrega` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_entrega` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `deliveries`
--

INSERT INTO `deliveries` (`id`, `direccion`, `referencia`, `venta_id`, `user_id`, `status`, `costo_delivery`, `detalles_entrega`, `fecha_entrega`, `created_at`, `updated_at`) VALUES
(2, 'Plaza la Soledad', 'Panadería New York', 3, 15, 'proceso', 3.00, NULL, NULL, '2024-12-26 22:29:16', '2024-12-28 06:39:13'),
(3, 'Barrio Sucre', 'Iglesia Nuestra Señora del Socorro', 4, NULL, 'entregado', 2.00, 'Ottmar García', '28-12-2024 01:54 AM', '2024-12-26 23:31:45', '2024-12-28 05:54:13'),
(4, 'Barrio Sucre', 'Iglesia Nuestra Señora del Socorro', 5, NULL, 'pendiente', 3.00, NULL, NULL, '2024-12-29 16:07:43', '2024-12-29 16:07:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id` bigint UNSIGNED NOT NULL,
  `compra_id` bigint UNSIGNED NOT NULL,
  `productos_nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorias_productos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `productos_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_unitario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id`, `compra_id`, `productos_nombres`, `categorias_productos`, `productos_ids`, `cantidad`, `costo_unitario`, `subtotal`, `photos`, `created_at`, `updated_at`) VALUES
(4, 4, 'Forro Samsung A22 5G - Deadpool y Wolverine,Forro Samsung A22 5G - Gokú,Forro Samsung A34', 'Forros De Teléfono Samsung,Forros De Teléfono Samsung,Forros De Teléfono Samsung', '13,14,15', '2,2,1', '3.5,3.5,3', '7,7,3', 'forro-samsung-a22-5g-deadpool-y-wolverine.jpg,forro-samsung-a22-5g-goku.jpg,forro-samsung-a34.jpg', '2024-12-26 18:15:16', '2024-12-26 18:15:16'),
(5, 5, 'Corneta Inalámbrica LM-S376,Corneta Inalámbrica ZQS-1488', 'Cornetas Inalámbrica,Cornetas Inalámbrica', '7,8', '2,1', '4,4', '8,4', 'corneta-inalambrica-lm-s376.jpg,corneta-inalambrica-zqs-1488.jpg', '2024-12-26 18:30:39', '2024-12-26 18:30:39'),
(9, 9, 'Audífono De Casco P9', 'Audífonos De Casco Inalámbrico', '4', '15', '5.1', '76.5', 'audifono-de-casco-p9.jpg', '2024-12-29 16:04:49', '2024-12-29 16:04:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `productos_nombres` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorias_productos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `productos_ids` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_unitario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id`, `venta_id`, `productos_nombres`, `categorias_productos`, `productos_ids`, `cantidad`, `costo_unitario`, `subtotal`, `photos`, `created_at`, `updated_at`) VALUES
(3, 3, 'Forro Samsung A22 5G - Deadpool y Wolverine', 'Forros De Teléfono Samsung', '13', '1', '4.55', '4.55', 'forro-samsung-a22-5g-deadpool-y-wolverine.jpg', '2024-12-26 22:29:16', '2024-12-26 22:29:16'),
(4, 4, 'Forro Samsung A34', 'Forros De Teléfono Samsung', '15', '1', '3.9', '3.9', 'forro-samsung-a34.jpg', '2024-12-26 23:31:45', '2024-12-26 23:31:45'),
(5, 5, 'Audífono De Casco P9', 'Audífonos De Casco Inalámbrico', '4', '2', '6', '12', 'audifono-de-casco-p9.jpg', '2024-12-29 16:07:43', '2024-12-29 16:07:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devolucions`
--

CREATE TABLE `devolucions` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha_devolucion` date NOT NULL,
  `user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `motivo_devolucion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_cel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profesion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_04_29_094145_create_sucursals_table', 1),
(6, '2024_04_30_101453_create_user_profiles_table', 1),
(7, '2024_05_06_111736_create_empleados_table', 1),
(8, '2024_05_07_100510_create_categorias_table', 1),
(9, '2024_05_08_094334_create_productos_table', 1),
(10, '2024_05_20_101556_create_proveedors_table', 1),
(11, '2024_05_20_102846_create_compras_table', 1),
(12, '2024_05_20_105511_create_detalle_compras_table', 1),
(13, '2024_05_28_120311_create_clientes_table', 1),
(14, '2024_05_28_121359_create_ventas_table', 1),
(15, '2024_05_28_121429_create_detalle_ventas_table', 1),
(16, '2024_05_30_165728_create_deliveries_table', 1),
(17, '2024_06_11_085917_create_servicio_tecnicos_table', 1),
(18, '2024_06_11_180547_create_devolucions_table', 1),
(19, '2024_06_12_210536_create_almacens_table', 1),
(20, '2024_12_06_145356_create_seguridads_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` bigint UNSIGNED NOT NULL,
  `categoria_id` bigint UNSIGNED DEFAULT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `cantidad` int DEFAULT NULL,
  `cantidad_devueltos` int DEFAULT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio_compra` double(8,2) DEFAULT NULL,
  `porcentaje_ganancia` int DEFAULT '30',
  `precio_venta` double(8,2) DEFAULT NULL,
  `tasa_bcv` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `categoria_id`, `sucursal_id`, `cantidad`, `cantidad_devueltos`, `nombre`, `photo`, `descripcion`, `status`, `precio_compra`, `porcentaje_ganancia`, `precio_venta`, `tasa_bcv`, `created_at`, `updated_at`) VALUES
(4, 4, 2, 13, NULL, 'Audífono De Casco P9', 'audifono-de-casco-p9.jpg', 'Audífono De Casco P9 Inalámbricos - Blanco', 'activo', 5.10, 30, 6.63, 0.00, '2024-12-23 12:38:36', '2024-12-29 16:11:56'),
(5, 5, 1, NULL, NULL, 'Cable USB CB-01-Micro', 'cable-usb-cb-01-micro.jpg', 'Cable USB CB-01-Micro USB Carga Rápida Blanco', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 12:40:30', '2024-12-29 04:43:53'),
(6, 8, 1, NULL, NULL, 'Cargador Inteligente HCA-01', 'cargador-inteligente-hca-01.jpg', 'Cargador Inteligente HCA-01', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 12:44:36', '2024-12-29 04:38:30'),
(7, 6, 1, NULL, NULL, 'Corneta Inalámbrica LM-S376', 'corneta-inalambrica-lm-s376.jpg', 'Corneta Inalámbrica LM-S376 - Azul', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 12:46:29', '2024-12-29 04:39:59'),
(8, 6, 1, NULL, NULL, 'Corneta Inalámbrica ZQS-1488', 'corneta-inalambrica-zqs-1488.jpg', 'Corneta Inalámbrica ZQS-1488 - Negro', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 13:02:02', '2024-12-29 04:40:28'),
(9, 11, 1, NULL, NULL, 'Micrófono Corbatero M01', 'microfono-corbatero-m01.jpg', 'Micrófono Corbatero M01 - Negro', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 13:10:31', '2024-12-29 04:40:54'),
(10, 7, 2, NULL, NULL, 'Carro De Stitch', 'carro-de-stitch.jpg', 'Carro De Stitch a Control Remoto', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 13:12:02', '2024-12-29 15:20:13'),
(11, 12, 1, NULL, NULL, 'Micrófono Karaoke WS-858', 'microfono-karaoke-ws-858.jpg', 'Micrófono Karaoke WS-858 Inalámbrico', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 13:28:45', '2024-12-29 04:00:46'),
(12, 9, 1, NULL, NULL, 'Tiras de Teléfono', 'tiras-de-telefono.jpg', 'Tiras de Teléfono de varios colores', 'activo', NULL, NULL, NULL, 0.00, '2024-12-23 13:29:49', '2024-12-29 04:42:20'),
(13, 10, 1, 1, NULL, 'Forro Samsung A22 5G - Deadpool y Wolverine', 'forro-samsung-a22-5g-deadpool-y-wolverine.jpg', 'Forro Samsung A22 5G - Deadpool y Wolverine', 'activo', 3.50, 30, 4.55, 0.00, '2024-12-26 17:54:08', '2024-12-26 22:29:16'),
(14, 10, 1, 2, NULL, 'Forro Samsung A22 5G - Gokú', 'forro-samsung-a22-5g-goku.jpg', 'Forro Samsung A22 5G - Gokú', 'activo', 3.50, 30, 4.55, 0.00, '2024-12-26 17:54:47', '2024-12-26 22:14:04'),
(15, 10, 1, 0, NULL, 'Forro Samsung A34', 'forro-samsung-a34.jpg', 'Forro Samsung A34 - Minecraft', 'activo', 3.00, 30, 3.90, 0.00, '2024-12-26 17:57:39', '2024-12-26 23:31:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedors`
--

CREATE TABLE `proveedors` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `categoria_id` bigint UNSIGNED DEFAULT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_cel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedors`
--

INSERT INTO `proveedors` (`id`, `nombre`, `rif`, `categoria_id`, `tipo`, `status`, `num_cel`, `created_at`, `updated_at`) VALUES
(1, 'Halvorson and Sons', '6011220034326759', NULL, 'j', 'inactive', '+18164655208', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(2, 'Torphy PLC', '89745632-1', 6, 'V', 'active', '0414-7896541', '2024-12-06 19:04:47', '2024-12-26 17:00:20'),
(3, 'Kreiger-Stark', '34135414-1', 4, 'J', 'active', '0426-3449875', '2024-12-06 19:04:47', '2024-12-29 15:41:40'),
(4, 'Kirlin-Huels', '4916992954761', NULL, 'j', 'inactive', '(207) 817-8127', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(5, 'Cremin, Beer and Leffler', '5107894698472518', NULL, 'v', 'inactive', '+1.980.207.7140', '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(6, 'Minimal Import', '40619570-7', 10, 'J', 'active', '0412-6061005', '2024-12-26 13:53:37', '2024-12-26 13:53:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridads`
--

CREATE TABLE `seguridads` (
  `id` bigint UNSIGNED NOT NULL,
  `pregunta_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pregunta_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `seguridads`
--

INSERT INTO `seguridads` (`id`, `pregunta_1`, `pregunta_2`, `respuesta_1`, `respuesta_2`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'deporte favorito', 'Lugar Nacimiento', 'futbol', 'San Cristóbal', 1, '2024-12-06 19:04:47', '2024-12-29 15:38:22'),
(2, 'Nombre de la Escuela Secundaria', 'Tradicion Familiar', 'gustavo machado', 'cena de noche buena', 12, '2024-12-06 19:28:05', '2024-12-29 15:32:38'),
(3, 'deporte favorito', 'Nombre de la Primera Mascota', 'Fútbol', 'Lucero', 13, '2024-12-20 17:40:33', '2024-12-29 15:26:47'),
(4, 'sitio turistico', 'lugar nacimiento', 'Colonia Tovar', 'Maracay', 14, '2024-12-23 00:29:00', '2024-12-23 00:29:00'),
(5, 'Nombre del Sitio Turistico Favorito', 'Lugar Nacimiento', 'Colonia Tovar', 'Maracay', 15, '2024-12-26 23:36:48', '2024-12-29 15:25:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio_tecnicos`
--

CREATE TABLE `servicio_tecnicos` (
  `id` bigint UNSIGNED NOT NULL,
  `fecha_recibido` datetime NOT NULL,
  `falla` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `productos` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `costo_dolar` double(8,2) DEFAULT NULL,
  `costo_bolivar` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `servicio_tecnicos`
--

INSERT INTO `servicio_tecnicos` (`id`, `fecha_recibido`, `falla`, `productos`, `cantidad`, `user`, `serial`, `cliente_id`, `status`, `costo_dolar`, `costo_bolivar`, `created_at`, `updated_at`) VALUES
(1, '2024-12-27 09:34:50', 'Daño de la Pantalla', 'Samsung A30', '1', 'Rolando Duran', 'DFIUGH56756YJU', 5, 'recibido', 2.00, 0.00, '2024-12-27 13:34:50', '2024-12-27 15:06:34'),
(2, '2024-12-30 12:23:10', 'Daño en los botones de subir volumen', 'Redmi Note 13', '1', 'Rolando Duran', 'DFHFHFGHFG', 13, 'entregado', 5.00, 0.00, '2024-12-30 16:23:10', '2024-12-30 16:24:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursals`
--

CREATE TABLE `sucursals` (
  `id` bigint UNSIGNED NOT NULL,
  `codigo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ciudad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sucursals`
--

INSERT INTO `sucursals` (`id`, `codigo`, `nombre`, `estado`, `ciudad`, `active`, `created_at`, `updated_at`) VALUES
(1, 'PRIN-1', 'Principal', 'tachira', 'san cristobal', 1, '2024-12-06 19:04:47', '2024-12-06 19:04:47'),
(2, 'SEC-1', 'Secundaria', 'aragua', 'maracay', 1, '2024-12-06 19:04:47', '2024-12-22 01:48:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` date DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `last_login`, `remember_token`, `created_at`, `updated_at`, `deleted_at`, `active`) VALUES
(1, 'Henry Espinoza', 'henry@gmail.com', NULL, '$2y$10$QMm1suB8/IE5EQKoVe.Qbuuh/eaB9j2lbmpapeGRIv7JMm7rHaM4m', 'admin', '2024-12-20', NULL, '2024-12-06 19:04:47', '2024-12-29 15:38:22', NULL, 1),
(12, 'Pedro Pérez', 'pedro@gmail.com', NULL, '$2y$10$uyZu5mweZrsJxD78Y74iNOmIE5jEsYa75atbFGt4P43wbAgBJqO1K', 'vendedor', '2024-12-23', NULL, '2024-12-06 19:28:05', '2024-12-29 15:32:38', NULL, 1),
(13, 'Rolando Duran', 'duran7511@gmail.com', NULL, '$2y$10$3mIh0XpsF6MVnwwI.5QXkOf9EXSAfjGHYNovcsMAqXsDZtLhstPyu', 'admin', '2024-12-30', NULL, '2024-12-20 17:40:33', '2024-12-30 13:41:53', NULL, 1),
(14, 'Nicolás González', 'nicogonza@hotmail.com', NULL, '$2y$10$/X2uzxuT36v3d4MOuqWw0uR7OZIMtDjkxDw7onQ9fh2PRpzv.Pxke', 'servicio', '2024-12-29', NULL, '2024-12-23 00:29:00', '2024-12-29 04:26:04', NULL, 1),
(15, 'Ottmar García', 'ottmara90@hotmail.com', NULL, '$2y$10$d5/LWUJyjW3tDKEluMJPUO4YMZvsBOypekXp1NT0H9AdgjvvaP.xe', 'delivery', '2024-12-28', NULL, '2024-12-26 23:36:48', '2024-12-29 15:25:20', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `ubicacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_cel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_documento` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `ubicacion`, `num_cel`, `tipo_documento`, `num_documento`, `user_id`, `sucursal_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Urbanización San Isidro. Edificio San Isidro Suites II Piso 3', '0424-7324441', 'V', '23897456', 1, 1, '2024-12-06 19:04:47', '2024-12-29 15:38:22', NULL),
(12, 'Caña de Azúcar Sector 2', '0414-4789563', 'V', '20390946', 12, 1, '2024-12-06 19:28:05', '2024-12-29 15:32:38', NULL),
(13, 'Av. Principal La Pedrera Quinta Liliana #170', '0424-3822518', 'V', '26491343', 13, 1, '2024-12-20 17:40:33', '2024-12-29 15:26:47', NULL),
(14, 'Av. Principal La Pedrera Callejón La Grita', '0414-0329952', 'V', '26778009', 14, 1, '2024-12-23 00:29:00', '2024-12-23 00:29:00', NULL),
(15, 'AV. Constitución Residencias Los Mangos', '0424-3724792', 'V', '25889562', 15, 1, '2024-12-26 23:36:48', '2024-12-29 15:25:20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `fecha_venta` date NOT NULL,
  `tasa_bcv` double(8,2) NOT NULL,
  `subtotal_dolar` double(8,2) NOT NULL,
  `iva_dolar` double(8,2) NOT NULL,
  `total_dolar` double(8,2) NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `cliente_id`, `sucursal_id`, `fecha_venta`, `tasa_bcv`, `subtotal_dolar`, `iva_dolar`, `total_dolar`, `status`, `created_at`, `updated_at`) VALUES
(3, 6, 1, '2024-12-26', 51.77, 4.55, 0.73, 5.28, NULL, '2024-12-26 22:29:16', '2024-12-26 22:29:16'),
(4, 5, 1, '2024-12-26', 51.77, 3.90, 0.62, 4.52, NULL, '2024-12-26 23:31:45', '2024-12-26 23:31:45'),
(5, 11, 2, '2024-12-29', 51.93, 12.00, 1.92, 13.92, NULL, '2024-12-29 16:07:43', '2024-12-29 16:07:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `almacens`
--
ALTER TABLE `almacens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `almacens_sucursal_id_foreign` (`sucursal_id`),
  ADD KEY `almacens_producto_id_foreign` (`producto_id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_num_documento_unique` (`num_documento`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `compras_proveedor_id_foreign` (`proveedor_id`),
  ADD KEY `compras_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `deliveries_venta_id_foreign` (`venta_id`),
  ADD KEY `deliveries_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_compras_compra_id_foreign` (`compra_id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalle_ventas_venta_id_foreign` (`venta_id`);

--
-- Indices de la tabla `devolucions`
--
ALTER TABLE `devolucions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devolucions_venta_id_foreign` (`venta_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productos_categoria_id_foreign` (`categoria_id`),
  ADD KEY `productos_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `proveedors`
--
ALTER TABLE `proveedors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `proveedors_categoria_id_foreign` (`categoria_id`);

--
-- Indices de la tabla `seguridads`
--
ALTER TABLE `seguridads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seguridads_user_id_foreign` (`user_id`);

--
-- Indices de la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicio_tecnicos_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sucursals_codigo_unique` (`codigo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indices de la tabla `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_num_documento_unique` (`num_documento`),
  ADD KEY `user_profiles_user_id_foreign` (`user_id`),
  ADD KEY `user_profiles_sucursal_id_foreign` (`sucursal_id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ventas_cliente_id_foreign` (`cliente_id`),
  ADD KEY `ventas_sucursal_id_foreign` (`sucursal_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `almacens`
--
ALTER TABLE `almacens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `devolucions`
--
ALTER TABLE `devolucions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `proveedors`
--
ALTER TABLE `proveedors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `seguridads`
--
ALTER TABLE `seguridads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `almacens`
--
ALTER TABLE `almacens`
  ADD CONSTRAINT `almacens_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `almacens_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_proveedor_id_foreign` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedors` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `compras_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `deliveries_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_compra_id_foreign` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `devolucions`
--
ALTER TABLE `devolucions`
  ADD CONSTRAINT `devolucions_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `proveedors`
--
ALTER TABLE `proveedors`
  ADD CONSTRAINT `proveedors_categoria_id_foreign` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `seguridads`
--
ALTER TABLE `seguridads`
  ADD CONSTRAINT `seguridads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  ADD CONSTRAINT `servicio_tecnicos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`),
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_sucursal_id_foreign` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursals` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
