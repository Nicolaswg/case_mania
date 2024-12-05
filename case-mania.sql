-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-12-2024 a las 13:27:47
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

--
-- Volcado de datos para la tabla `almacens`
--

INSERT INTO `almacens` (`id`, `sucursal_id`, `producto_id`, `cantidad`, `cantidad_acumulada`, `created_at`, `updated_at`) VALUES
(2, 2, 6, 2, 2, '2024-11-30 05:50:09', '2024-11-30 05:50:09');

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
(1, 'forros', 1, '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(3, 'Audífonos', 1, '2024-11-08 01:34:02', '2024-11-29 04:56:12'),
(4, 'Cornetas', 1, '2024-11-30 04:19:47', '2024-11-30 04:19:47');

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
(1, 'Humberto Lesch', '760 Jovany Island\nSchummtown, CT 16537', 'J', '4516999', '53932', 'susie21@example.net', 'inactive', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(2, 'Yasmeen Rowe Sr.', '381 Charley Lakes\nSerenamouth, AK 62764', 'E', '7354550', '53336', 'jheller@example.com', 'inactive', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(3, 'Prof. Carolina Streich', '854 Kaleigh Knolls\nEast Triston, MN 01149-2755', 'J', '9459567', '99154', 'shaina73@example.net', 'active', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(4, 'Kelley Satterfield', '4319 Bailey Fork Apt. 337\nNorth Jeromyhaven, NC 31658', 'E', '4984125', '919', 'arjun20@example.com', 'active', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(5, 'Ardella Kemmer', '884 VonRueden Summit Apt. 796\nWest Lerabury, TN 94426-1435', 'V', '2801622', '85734', 'vkoss@example.net', 'active', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(6, 'Jeffrey Hegmann', '95949 Kane Burg Apt. 645\nWest Corine, NY 22825-3461', 'J', '1675908', '16179', 'alford.blick@example.org', 'active', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(7, 'Ms. Onie Roberts', '128 Gusikowski Road Apt. 789\nNorth Ninaville, AR 88576', 'V', '1059402', '54482', 'ncorwin@example.org', 'inactive', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(8, 'Keeley Reynolds', '345 Kuvalis Valley Suite 985\nSporerstad, IN 76319-2251', 'E', '3573406', '59624', 'kevin55@example.net', 'active', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(9, 'Prof. Terrence Heller', '274 O\'Keefe Track\nShaynaside, MI 36525-0029', 'J', '7645208', '36328', 'brisa.will@example.net', 'inactive', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(10, 'Erich Ryan IV', '698 Kautzer Ford\nWeissnatmouth, HI 50370', 'J', '6292166', '73500', 'matt81@example.com', 'active', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(11, 'Rolando Duran', 'AV. Principal La Pedrera Quinta Liliana #170', 'V', '26491343', '0424-3822518', 'rolandofiestero@hotmail.com', 'active', '2024-11-30 04:12:51', '2024-11-30 04:12:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` bigint UNSIGNED NOT NULL,
  `proveedor_id` bigint UNSIGNED NOT NULL,
  `sucursal_id` bigint UNSIGNED NOT NULL,
  `tasa_bcv` double(8,2) NOT NULL,
  `status_carga` tinyint DEFAULT NULL,
  `fecha_compra` date NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `iva` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `proveedor_id`, `sucursal_id`, `tasa_bcv`, `status_carga`, `fecha_compra`, `subtotal`, `iva`, `total`, `created_at`, `updated_at`) VALUES
(3, 6, 1, 47.31, 1, '2024-11-29', 6.44, 1.03, 7.47, '2024-11-29 05:32:09', '2024-11-29 05:39:44'),
(4, 6, 1, 47.31, 1, '2024-11-29', 8.88, 1.42, 10.30, '2024-11-29 07:24:59', '2024-11-29 07:25:58'),
(6, 7, 1, 47.61, 1, '2024-11-30', 12.50, 2.00, 14.50, '2024-11-30 05:07:50', '2024-11-30 05:08:28'),
(7, 7, 1, 47.61, 1, '2024-11-30', 12.50, 2.00, 14.50, '2024-11-30 05:14:52', '2024-11-30 05:15:05'),
(8, 7, 1, 47.61, 1, '2024-11-30', 12.00, 1.92, 13.92, '2024-11-30 05:33:41', '2024-11-30 05:33:56');

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
(2, 'La Soledad', 'Panadería New York', 3, NULL, 'pendiente', 2.00, NULL, NULL, '2024-11-29 06:35:25', '2024-11-29 06:35:25');

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
(3, 3, 'Forro Sefora Lite Spark Go 2024', 'Forros', '5', '2', '3.22', '6.44', 'forro-sefora-lite-spark-go-2024.jpg', '2024-11-29 05:32:09', '2024-11-29 05:32:09'),
(4, 4, 'Forro Sefora Lite Spark Go 2024', 'Forros', '5', '4', '2.22', '8.88', 'forro-sefora-lite-spark-go-2024.jpg', '2024-11-29 07:24:59', '2024-11-29 07:24:59'),
(6, 6, 'Audífono Samsumg Galaxy Buds', 'Audífonos', '6', '5', '2.5', '12.5', 'audifono-samsumg-galaxy-buds.jpg', '2024-11-30 05:07:50', '2024-11-30 05:07:50'),
(7, 7, 'Audífono Samsumg Galaxy Buds', 'Audífonos', '6', '5', '2.5', '12.5', 'audifono-samsumg-galaxy-buds.jpg', '2024-11-30 05:14:52', '2024-11-30 05:14:52'),
(8, 8, 'Audífono Samsumg Galaxy Buds', 'Audífonos', '6', '4', '3', '12', 'audifono-samsumg-galaxy-buds.jpg', '2024-11-30 05:33:41', '2024-11-30 05:33:41');

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
(3, 3, 'Forro Sefora Lite Spark Go 2024', 'Forros', '5', '1', '6.44', '6.44', 'forro-sefora-lite-spark-go-2024.jpg', '2024-11-29 06:35:25', '2024-11-29 06:35:25'),
(4, 4, 'Audífono Samsumg Galaxy Buds', 'Audífonos', '6', '3', '12.5', '37.5', 'audifono-samsumg-galaxy-buds.jpg', '2024-11-30 05:27:05', '2024-11-30 05:27:05');

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
(20, '2024_11_07_204408_create_seguridads_table', 1);

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
(5, 1, 1, 5, NULL, 'Forro Sefora Lite Spark Go 2024', 'forro-sefora-lite-spark-go-2024.jpg', 'Forro Sefora Lite Spark Go 2024 - Transparente', 'activo', 8.88, NULL, 8.88, 0.00, '2024-11-29 05:29:06', '2024-11-29 07:26:02'),
(6, 3, 1, 4, NULL, 'Audífono Samsumg Galaxy Buds', 'audifono-samsumg-galaxy-buds.jpg', 'Audífono Samsumg Galaxy Buds - Blanco', 'activo', 12.00, NULL, 12.00, 0.00, '2024-11-30 04:38:51', '2024-11-30 05:50:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedors`
--

CREATE TABLE `proveedors` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_cel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedors`
--

INSERT INTO `proveedors` (`id`, `nombre`, `rif`, `tipo`, `status`, `num_cel`, `created_at`, `updated_at`) VALUES
(1, 'Reilly, Luettgen and Kertzmann', '5564949467781121', 'v', 'inactive', '1-912-656-7540', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(2, 'Kilback, Senger and Borer', '2395350813222484', 'v', 'active', '231-847-0152', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(3, 'Schamberger PLC', '6011885404820365', 'v', 'inactive', '229-352-6516', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(4, 'Kirlin and Sons', '6011883776895552', 'j', 'active', '831.854.6280', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(5, 'Miller, Kling and Johnston', '5164809387409233', 'j', 'inactive', '501.582.2620', '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(6, 'Minimal Import', '40619570-7', 'J', 'active', '0412-6061005', '2024-11-29 05:30:46', '2024-11-29 06:23:25'),
(7, 'Videojuegos Rolan98', '50298755-1', 'J', 'active', '0424-3839000', '2024-11-30 04:25:01', '2024-11-30 04:25:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguridads`
--

CREATE TABLE `seguridads` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pregunta_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pregunta_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `respuesta_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `respuesta_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `seguridads`
--

INSERT INTO `seguridads` (`id`, `user_id`, `pregunta_1`, `pregunta_2`, `respuesta_1`, `respuesta_2`, `created_at`, `updated_at`) VALUES
(1, 1, 'nombre primera mascota', 'comida favorita', 'perro', 'arepa', '2024-11-08 01:34:02', '2024-11-25 17:27:54'),
(2, 12, 'nombre de la madre', 'nombre primera mascota', 'adela', 'lazi', '2024-11-08 01:50:22', '2024-11-30 02:21:52'),
(3, 13, 'deporte favorito', 'nombre primera mascota', 'futbol', 'lucero', '2024-11-29 04:24:01', '2024-11-29 04:32:52'),
(4, 14, 'comida favorita', 'deporte favorito', 'Cachapa', 'beisbol', '2024-11-30 02:32:48', '2024-11-30 02:32:48');

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
(1, '2024-11-25 09:17:41', 'hfhfg', 'jkhjk', '1', 'Henry Espinoza', 'jkk', 10, 'entregado', 5.00, 0.00, '2024-11-25 13:17:41', '2024-11-25 16:58:46'),
(2, '2024-11-29 03:31:40', 'Daño de la las teclas', 'Redmi 12 Pro', '1', 'Rolando Duran', '574567657', 8, 'entregado', 10.00, 0.00, '2024-11-29 07:31:40', '2024-11-29 07:33:06'),
(3, '2024-11-30 02:01:30', 'Daño en el pin de carga', 'Samsung J2 Prime', '1', 'Rolando Duran', 'R58KC46S41P', 11, 'recibido', 15.00, 0.00, '2024-11-30 06:01:30', '2024-11-30 06:01:50');

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
(1, 'PRIN-1', 'Principal', 'tachira', 'san cristobal', 1, '2024-11-08 01:34:02', '2024-11-08 01:34:02'),
(2, 'SEC-1', 'Secundaria', 'aragua', 'maracay', 1, '2024-11-08 01:34:02', '2024-11-29 07:10:46');

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
(1, 'Henry Espinoza', 'henry@gmail.com', NULL, '$2y$10$/ASOptROVcWaL8rkKFkbUOI9JztybxSOaaHTBBft5xEswVu8/qBcK', 'admin', '2024-11-29', NULL, '2024-11-08 01:34:02', '2024-11-29 04:18:31', NULL, 1),
(2, 'Ottmar Araujo', 'ottmara90@hotmail.com', '2024-11-08 01:34:02', '$2y$10$8hFvV6kjJKpCh1Gb0l6dOu503328g5LIvjqbY25ghFDXspZTuAW2C', 'delivery', '2024-11-29', NULL, '2024-09-26 01:34:02', '2024-11-30 02:43:34', NULL, 1),
(3, 'Luis Carmona', 'rice.name@example.com', '2024-11-08 01:34:02', '$2y$10$ju2ZJS0g869Kz4cLBSdyt.CAyfnXepnv9mqnajwSkXaKtWcbQPdhm', 'vendedor', NULL, NULL, '2024-11-07 01:34:02', '2024-11-30 04:00:04', NULL, 1),
(4, 'Marietta Flatley III', 'zrutherford@example.org', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'servicio', NULL, NULL, '2024-11-03 01:34:02', '2024-11-08 01:34:02', NULL, 1),
(5, 'Jarod Wolf', 'uschulist@example.org', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'delivery', NULL, NULL, '2024-09-19 01:34:02', '2024-11-08 01:34:02', NULL, 1),
(6, 'Kurt Abshire', 'gusikowski.shaun@example.net', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NULL, '2024-10-22 01:34:02', '2024-11-08 01:34:02', NULL, 1),
(7, 'Dedrick D\'Amore', 'myra.stanton@example.org', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendedor', NULL, NULL, '2024-09-21 01:34:02', '2024-11-08 01:34:02', NULL, 0),
(8, 'Ms. Josiane Ledner IV', 'cydney.wuckert@example.com', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vendedor', NULL, NULL, '2024-10-26 01:34:02', '2024-11-08 01:34:02', NULL, 1),
(9, 'Caitlyn Tillman III', 'ghegmann@example.org', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'delivery', NULL, NULL, '2024-08-31 01:34:02', '2024-11-08 01:34:02', NULL, 0),
(10, 'Mrs. Clotilde Runte DDS', 'fokon@example.com', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'servicio', NULL, NULL, '2024-09-06 01:34:02', '2024-11-08 01:34:02', NULL, 1),
(11, 'Prof. Hayden McDermott DVM', 'shana.veum@example.net', '2024-11-08 01:34:02', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NULL, '2024-09-15 01:34:02', '2024-11-08 01:34:02', NULL, 1),
(12, 'Pedro Perez', 'pedro@gmail.com', NULL, '$2y$10$oZhQrIpaDOkg6fNaybaAHOwd4Y9zNIQ02zFCYgR1CHQ2GMUzsNF5i', 'vendedor', '2024-11-29', NULL, '2024-11-08 01:50:22', '2024-11-30 02:23:12', NULL, 1),
(13, 'Rolando Duran', 'duran7511@gmail.com', NULL, '$2y$10$.0geHacCQNq73wQRSbXG2u47iTkqofaDB9GvpaYy96AQRxKib12lu', 'admin', '2024-12-02', NULL, '2024-11-29 04:24:00', '2024-12-02 13:16:45', NULL, 1),
(14, 'Nicolás González', 'nicogonza@hotmail.com', NULL, '$2y$10$0sP1xjxCF0tYH7UYU9XL/.mcBLNiDHi9WPK2rLm.iTXmD4xg5vCkW', 'servicio', '2024-11-29', NULL, '2024-11-30 02:32:48', '2024-11-30 02:34:57', NULL, 1);

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
(1, 'San Cristobal', '0424-7324441', 'V', '23897456', 1, 1, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(2, 'Barrio La Libertad', '0424-3724792', 'V', '20900456', 2, 1, '2024-11-08 01:34:02', '2024-11-30 02:42:21', NULL),
(3, 'Tremblaystad', '0426-8987654', 'E', '82758424', 3, 1, '2024-11-08 01:34:02', '2024-11-30 04:00:04', NULL),
(4, 'South Nicolettestad', '43297', 'J', '64174040', 4, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(5, 'Gladyceland', '44976', 'V', '26650876', 5, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(6, 'Marvinland', '94175', 'E', '48023383', 6, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(7, 'Olsonshire', '17795', 'J', '67639849', 7, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(8, 'Port Abbie', '80846', 'V', '38846870', 8, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(9, 'Bernadinebury', '21108', 'J', '90372722', 9, 1, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(10, 'West Dwight', '486', 'J', '90770758', 10, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(11, 'East Jimmieport', '8493', 'J', '6706425', 11, 2, '2024-11-08 01:34:02', '2024-11-08 01:34:02', NULL),
(12, 'Turmero', '0414-7258954', 'V', '25897466', 12, 1, '2024-11-08 01:50:22', '2024-11-30 02:21:52', NULL),
(13, 'Maracay', '0424-3822518', 'V', '26491343', 13, 1, '2024-11-29 04:24:01', '2024-11-29 04:24:01', NULL),
(14, 'Barrio La Pedrera', '0414-0329952', 'V', '21667943', 14, 2, '2024-11-30 02:32:48', '2024-11-30 02:32:48', NULL);

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
(3, 10, 1, '2024-11-29', 47.31, 6.44, 1.03, 7.47, NULL, '2024-11-29 06:35:25', '2024-11-29 06:35:25'),
(4, 11, 1, '2024-11-30', 47.61, 37.50, 6.00, 43.50, NULL, '2024-11-30 05:27:04', '2024-11-30 05:27:04');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proveedors`
--
ALTER TABLE `proveedors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `seguridads`
--
ALTER TABLE `seguridads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicio_tecnicos`
--
ALTER TABLE `servicio_tecnicos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sucursals`
--
ALTER TABLE `sucursals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
