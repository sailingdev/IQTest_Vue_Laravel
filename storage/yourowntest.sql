-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-05-2019 a las 17:38:22
-- Versión del servidor: 5.5.60-MariaDB
-- Versión de PHP: 5.6.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `yourowntest`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answers`
--

CREATE TABLE `answers` (
  `id` int(10) UNSIGNED NOT NULL,
  `img_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `score` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `answers`
--

INSERT INTO `answers` (`id`, `img_url`, `score`, `question_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 13, '2019-05-10 07:44:34', '2019-05-10 07:44:34'),
(2, '/uploads/images/answer/1557504469.png', 5, 19, '2019-05-10 08:07:49', '2019-05-10 08:07:49'),
(3, '/uploads/images/answer/1557504481.png', 0, 19, '2019-05-10 08:08:01', '2019-05-10 08:08:01'),
(4, '/uploads/images/answer/1557504491.png', 0, 19, '2019-05-10 08:08:11', '2019-05-10 08:08:11'),
(5, NULL, 2, 20, '2019-05-10 08:11:16', '2019-05-10 08:11:16'),
(6, NULL, 1, 21, '2019-05-10 08:14:02', '2019-05-10 08:14:02'),
(7, NULL, 1, 21, '2019-05-10 08:14:10', '2019-05-10 08:14:10'),
(8, NULL, 1, 22, '2019-05-10 08:15:04', '2019-05-10 08:15:04'),
(9, '/uploads/images/answer/1557504935.png', 0, 23, '2019-05-10 08:15:35', '2019-05-10 08:15:35'),
(10, '/uploads/images/answer/1557504944.png', 0, 23, '2019-05-10 08:15:44', '2019-05-10 08:15:44'),
(11, '/uploads/images/answer/1557504957.png', 5, 23, '2019-05-10 08:15:58', '2019-05-10 08:15:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `answer_translations`
--

CREATE TABLE `answer_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `answer_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `txt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `answer_translations`
--

INSERT INTO `answer_translations` (`id`, `answer_id`, `locale`, `txt`, `result_text`, `created_at`, `updated_at`) VALUES
(1, 1, 'en', 'Male', 'You are male!', '2019-05-10 07:44:34', '2019-05-10 07:44:34'),
(2, 1, 'es', 'Spanish Male', 'Spanis Result rtext', '2019-05-10 07:46:40', '2019-05-10 07:46:56'),
(3, 2, 'en', NULL, 'Correct!', '2019-05-10 08:07:49', '2019-05-10 08:07:49'),
(4, 3, 'en', NULL, 'Wrong!', '2019-05-10 08:08:01', '2019-05-10 08:08:01'),
(5, 4, 'en', NULL, 'Wrong!', '2019-05-10 08:08:11', '2019-05-10 08:08:11'),
(6, 5, 'en', 'your weight is middle?', NULL, '2019-05-10 08:11:16', '2019-05-10 08:11:16'),
(7, 6, 'en', 'Male', 'You are male!', '2019-05-10 08:14:02', '2019-05-10 08:14:02'),
(8, 7, 'en', 'Female!', 'You are female!', '2019-05-10 08:14:10', '2019-05-10 08:14:10'),
(9, 8, 'en', 'Middle School', 'Middle School!', '2019-05-10 08:15:04', '2019-05-10 08:15:04'),
(10, 9, 'en', NULL, 'Wrong!', '2019-05-10 08:15:36', '2019-05-10 08:15:36'),
(11, 10, 'en', NULL, 'Wrong!', '2019-05-10 08:15:44', '2019-05-10 08:15:44'),
(12, 11, 'en', NULL, 'Right!', '2019-05-10 08:15:58', '2019-05-10 08:15:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `created_at`, `updated_at`) VALUES
(4, '2019-05-09 12:41:24', '2019-05-09 12:41:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category_translations`
--

CREATE TABLE `category_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `category_translations`
--

INSERT INTO `category_translations` (`id`, `category_id`, `locale`, `title`, `description`, `created_at`, `updated_at`) VALUES
(5, 4, 'en', 'Category1', 'Category1', '2019-05-09 12:41:24', '2019-05-09 12:41:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `language` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `languages`
--

INSERT INTO `languages` (`id`, `language`, `locale`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', '2019-05-09 12:26:45', '2019-05-09 12:26:45'),
(2, 'Spanish', 'es', '2019-05-09 12:29:22', '2019-05-09 12:29:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_05_03_185149_create_1556898709_permissions_table', 1),
(9, '2019_05_03_185150_create_1556898710_roles_table', 1),
(10, '2019_05_03_185152_create_1556898712_users_table', 1),
(11, '2019_05_03_185154_create_5ccc6398209e4_permission_role_table', 1),
(12, '2019_05_03_185156_create_5ccc639a4106f_role_user_table', 1),
(13, '2019_05_03_185812_create_1556899092_categories_table', 1),
(14, '2019_05_03_195654_create_tests_table', 1),
(17, '2019_05_06_141804_create_results_table', 1),
(18, '2019_05_06_162441_create_topics_table', 1),
(19, '2019_05_07_171810_create_languages_table', 1),
(20, '2019_05_08_105818_create_category_translations_table', 1),
(21, '2019_05_08_140236_create_test_translations_table', 1),
(24, '2019_05_08_154914_create_result_translations_table', 1),
(25, '2019_05_08_170957_create_topic_questions_table', 1),
(26, '2019_05_08_171234_create_topic_question_translations', 1),
(29, '2019_05_04_154757_create_questions_table', 2),
(30, '2019_05_08_150001_create_question_translations_table', 2),
(31, '2019_05_04_181408_create_answers_table', 3),
(32, '2019_05_08_154851_create_answer_translations_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'user_management_access', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(2, 'permission_access', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(3, 'permission_create', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(4, 'permission_edit', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(5, 'permission_view', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(6, 'permission_delete', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(7, 'role_access', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(8, 'role_create', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(9, 'role_edit', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(10, 'role_view', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(11, 'role_delete', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(12, 'user_access', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(13, 'user_create', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(14, 'user_edit', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(15, 'user_view', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(16, 'user_delete', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(18, 'category_access', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(19, 'category_create', '2019-05-09 12:26:41', '2019-05-09 12:26:41'),
(20, 'category_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(21, 'category_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(22, 'category_delete', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(24, 'option_2_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(25, 'test_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(26, 'setting_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(27, 'option_1_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(28, 'test_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(29, 'test_create', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(30, 'test_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(31, 'test_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(32, 'test_delete', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(33, 'question_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(34, 'question_create', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(35, 'question_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(36, 'question_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(37, 'question_delete', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(38, 'answer_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(39, 'answer_create', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(40, 'answer_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(41, 'answer_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(42, 'answer_delete', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(43, 'result_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(44, 'result_create', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(45, 'result_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(46, 'result_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(47, 'result_delete', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(48, 'topic_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(49, 'topic_create', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(50, 'topic_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(51, 'topic_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(52, 'topic_delete', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(53, 'language_access', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(54, 'language_create', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(55, 'language_edit', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(56, 'language_view', '2019-05-09 12:26:42', '2019-05-09 12:26:42'),
(57, 'language_delete', '2019-05-09 12:26:43', '2019-05-09 12:26:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED DEFAULT NULL,
  `role_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `questions`
--

CREATE TABLE `questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `img_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_id` int(11) NOT NULL,
  `page` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `topic_id` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `questions`
--

INSERT INTO `questions` (`id`, `img_url`, `test_id`, `page`, `topic_id`, `created_at`, `updated_at`) VALUES
(9, NULL, 9, 'pre', 1, '2019-05-10 07:19:34', '2019-05-10 07:19:34'),
(10, '/uploads/images/question/1557501859.png', 9, 'normal', 0, '2019-05-10 07:24:19', '2019-05-10 07:24:19'),
(11, NULL, 9, 'post', 2, '2019-05-10 07:24:41', '2019-05-10 07:36:46'),
(12, NULL, 9, 'pre', 3, '2019-05-10 07:26:03', '2019-05-10 07:36:36'),
(13, NULL, 9, 'normal', 0, '2019-05-10 07:27:09', '2019-05-10 07:27:09'),
(14, NULL, 8, 'pre', 1, '2019-05-10 07:28:04', '2019-05-10 07:28:04'),
(15, '/uploads/images/question/1557503316.png', 9, 'normal', 0, '2019-05-10 07:48:36', '2019-05-10 07:48:36'),
(16, '/uploads/images/question/1557503359.png', 9, 'normal', 0, '2019-05-10 07:49:19', '2019-05-10 07:49:19'),
(17, '/uploads/images/question/1557503371.png', 9, 'normal', 0, '2019-05-10 07:49:31', '2019-05-10 07:49:31'),
(18, NULL, 9, 'post', 4, '2019-05-10 08:07:09', '2019-05-10 08:07:09'),
(19, '/uploads/images/question/1557504456.png', 9, 'normal', 0, '2019-05-10 08:07:36', '2019-05-10 08:07:36'),
(20, NULL, 8, 'pre', 4, '2019-05-10 08:10:59', '2019-05-10 08:10:59'),
(21, NULL, 7, 'pre', 1, '2019-05-10 08:13:37', '2019-05-10 08:13:37'),
(22, NULL, 7, 'post', 3, '2019-05-10 08:14:45', '2019-05-10 08:14:45'),
(23, '/uploads/images/question/1557504919.png', 7, 'normal', 0, '2019-05-10 08:15:19', '2019-05-10 08:15:19'),
(24, NULL, 7, 'pre', 5, '2019-05-10 08:17:22', '2019-05-10 08:17:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `question_translations`
--

CREATE TABLE `question_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `question_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `txt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_ans_exp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `question_translations`
--

INSERT INTO `question_translations` (`id`, `question_id`, `locale`, `txt`, `correct_ans_exp`, `created_at`, `updated_at`) VALUES
(9, 9, 'en', 'what is your gender?', NULL, '2019-05-10 07:19:34', '2019-05-10 07:19:34'),
(10, 10, 'en', NULL, NULL, '2019-05-10 07:24:19', '2019-05-10 07:24:19'),
(11, 11, 'en', 'what is your age?', NULL, '2019-05-10 07:24:41', '2019-05-10 07:24:41'),
(12, 12, 'en', 'What is your study?', NULL, '2019-05-10 07:26:03', '2019-05-10 07:26:03'),
(13, 13, 'en', 'What\'s your age?', NULL, '2019-05-10 07:27:09', '2019-05-10 07:27:09'),
(14, 14, 'en', 'what is your gender?', NULL, '2019-05-10 07:28:04', '2019-05-10 07:28:04'),
(15, 15, 'en', NULL, NULL, '2019-05-10 07:48:36', '2019-05-10 07:48:36'),
(16, 16, 'en', NULL, NULL, '2019-05-10 07:49:19', '2019-05-10 07:49:19'),
(17, 17, 'en', NULL, NULL, '2019-05-10 07:49:31', '2019-05-10 07:49:31'),
(18, 18, 'en', 'what is your weight?', NULL, '2019-05-10 08:07:09', '2019-05-10 08:07:09'),
(19, 19, 'en', NULL, NULL, '2019-05-10 08:07:36', '2019-05-10 08:07:36'),
(20, 20, 'en', 'what is your weight?', NULL, '2019-05-10 08:10:59', '2019-05-10 08:10:59'),
(21, 21, 'en', 'What is your gender?', NULL, '2019-05-10 08:13:37', '2019-05-10 08:13:37'),
(22, 22, 'en', 'What is your study?', NULL, '2019-05-10 08:14:45', '2019-05-10 08:14:45'),
(23, 23, 'en', NULL, NULL, '2019-05-10 08:15:19', '2019-05-10 08:15:19'),
(24, 24, 'en', 'Other question!', NULL, '2019-05-10 08:17:22', '2019-05-10 08:17:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `results`
--

CREATE TABLE `results` (
  `id` int(10) UNSIGNED NOT NULL,
  `min_score` int(11) NOT NULL,
  `max_score` int(11) NOT NULL,
  `img_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `results`
--

INSERT INTO `results` (`id`, `min_score`, `max_score`, `img_url`, `file_url`, `test_id`, `created_at`, `updated_at`) VALUES
(1, 0, 10, NULL, NULL, 9, '2019-05-10 08:08:36', '2019-05-10 08:08:36'),
(2, 10, 20, NULL, NULL, 9, '2019-05-10 08:08:44', '2019-05-10 08:08:44'),
(3, 0, 10, NULL, NULL, 7, '2019-05-10 08:16:19', '2019-05-10 08:16:19'),
(4, 10, 20, NULL, NULL, 7, '2019-05-10 08:16:25', '2019-05-10 08:16:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `result_translations`
--

CREATE TABLE `result_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `result_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `result_translations`
--

INSERT INTO `result_translations` (`id`, `result_id`, `locale`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'en', 'Your IQ is so low!!!!', '2019-05-10 08:08:36', '2019-05-10 08:08:36'),
(2, 2, 'en', 'Middle!', '2019-05-10 08:08:45', '2019-05-10 08:08:45'),
(3, 3, 'en', 'Your IQ is low!', '2019-05-10 08:16:19', '2019-05-10 08:16:19'),
(4, 4, 'en', 'Middle!', '2019-05-10 08:16:25', '2019-05-10 08:16:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Administrator (can create other users)', '2019-05-09 12:26:43', '2019-05-09 12:26:43'),
(2, 'Simple user', '2019-05-09 12:26:43', '2019-05-09 12:26:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tests`
--

CREATE TABLE `tests` (
  `id` int(10) UNSIGNED NOT NULL,
  `time` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tests`
--

INSERT INTO `tests` (`id`, `time`, `category_id`, `created_at`, `updated_at`) VALUES
(5, 10, 4, '2019-05-10 07:13:28', '2019-05-10 07:13:28'),
(6, 20, 4, '2019-05-10 07:14:14', '2019-05-10 07:14:14'),
(7, 10, 4, '2019-05-10 07:14:50', '2019-05-10 07:14:50'),
(8, 10, 4, '2019-05-10 07:15:38', '2019-05-10 07:15:38'),
(9, 10, 4, '2019-05-10 07:16:55', '2019-05-10 07:16:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test_translations`
--

CREATE TABLE `test_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `test_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `instruction` text COLLATE utf8mb4_unicode_ci,
  `pre_page_title` text COLLATE utf8mb4_unicode_ci,
  `pre_page_desc` text COLLATE utf8mb4_unicode_ci,
  `post_page_title` text COLLATE utf8mb4_unicode_ci,
  `post_page_desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `test_translations`
--

INSERT INTO `test_translations` (`id`, `test_id`, `locale`, `title`, `description`, `instruction`, `pre_page_title`, `pre_page_desc`, `post_page_title`, `post_page_desc`, `created_at`, `updated_at`) VALUES
(6, 5, 'en', 'Logical reasoning test', 'A logical reasoning test is a fundamental part of any assessment. Logical reasoning generally does not require verbal or numerical reasoning although variations exist that do. Especially tests that measure sector-specific abilities can have verbal and numerical test questions. Examples are mechanical reasoning or financial and managerial job specific tasks. This free logical reasoning test will help you better understand how such aptitudes are measured.', 'Instructions logical reasoning test\nThis test consists of ten questions that all need to be answered. There is no time limit. Which figure do you think logically belongs on the spot of the question mark?', NULL, NULL, NULL, NULL, '2019-05-10 07:13:28', '2019-05-10 07:13:28'),
(7, 6, 'en', 'Numerical reasoning test', 'The numerical reasoning test is one of the most frequently used ability tests for psychometric testing. If you want to prepare for an assessment of do job test preparation make sure you practice numerical reasoning tests. Numerical tests often involve straightforward calculations but can also consist of estimations and more global judgments. In this test you need to solve number series. Can you find the numerical logic in the serie?', 'Instructions numerical reasoning test\nYou need to answer all ten questions, there is no time limit. Answer these questions by figuring out what number belongs on the spot of the question mark.', NULL, NULL, NULL, NULL, '2019-05-10 07:14:14', '2019-05-10 07:14:14'),
(8, 7, 'en', 'Abstract reasoning test', 'An abstract reasoning test measures your ability or aptitude to reason logically. Generally, abstract reasoning tests measure non-verbal abilities. You must, through logical and abstract reasoning, extract rules, analogies and structures which you subsequently use to find a correct answer among a set of possible options.', 'Instructions abstract reasoning test\nThe test consists of ten questions. You must answer all of them but there is no time limit. Which figure logically belongs on the spot of the question mark?', 'This is Pre Page!', 'We want to ask some questions for you!', 'Post Page!', NULL, '2019-05-10 07:14:50', '2019-05-10 08:14:25'),
(9, 8, 'en', 'Inductive reasoning test', 'An inductive reasoning test most often presents sets or series of figures where the objective is to predict the next or missing figure. In selection assessments for jobs you will often find inductive reasoning tests. The general aim is to measure your ability to reason logically as one of the possible measures for intelligence.\n\nGenerally, the term abstract reasoning test and inductive reasoning test are used for the same kind of ability tests. So if you want to prepare for selections tests, use this free inductive reasoning test online right now to be well prepared.', 'Instructions inductive reasoning test\nEach question presents a series of figures with one of the figures replaced by a question mark. It\'s your job to figure out which of the four options is the logical replacement of the question mark.', 'Pre page', 'This is pre page for asking some questions for a use!', 'This is post page!', NULL, '2019-05-10 07:15:38', '2019-05-10 08:11:40'),
(10, 9, 'en', 'Verbal reasoning test with analogies', 'Analogies as used in this test are inferences of similarity between two relations. In this tests words are used between which specific logical relations exist. Sometimes object, pictures or even numbers are used. In this verbal reasoning test analogies are presented verbally.\n\nAnalogies are often used in assessments and intelligence measurements. If you like taking IQ tests or want to do job test prep you should take this free test online right now. This test is part of an extensive free IQ test training.', 'Instructions verbal reasoning test\nThis test measures your ability to select a word based on other words and their relationships or analogies. Each question presents three words and four options. It\'s your job to figure out which of the options is the logical fourth word.', 'We want to ask some question to get better result for you', 'Here we can ask some questions for a user!', 'Post Page', NULL, '2019-05-10 07:16:55', '2019-05-10 08:05:35'),
(11, 9, 'es', 'Spanish Verbal reasoning test with analogies', NULL, NULL, 'Spanish we are going to ask some questions for you!', NULL, 'Spanish Title', NULL, '2019-05-10 07:17:38', '2019-05-10 07:50:39'),
(12, 7, 'es', NULL, NULL, NULL, 'Spanish Pre Page!', NULL, NULL, NULL, '2019-05-10 08:16:47', '2019-05-10 08:16:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topics`
--

CREATE TABLE `topics` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `topics`
--

INSERT INTO `topics` (`id`, `name`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'gender', NULL, NULL, '2019-05-10 07:18:43', '2019-05-10 07:18:43'),
(2, 'age', NULL, NULL, '2019-05-10 07:18:48', '2019-05-10 07:18:48'),
(3, 'studies', NULL, NULL, '2019-05-10 07:18:53', '2019-05-10 07:18:53'),
(4, 'weight', NULL, 'What\'s your weight?', '2019-05-10 08:06:35', '2019-05-10 08:06:35'),
(5, 'other', NULL, 'other', '2019-05-10 08:17:07', '2019-05-10 08:17:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topic_questions`
--

CREATE TABLE `topic_questions` (
  `id` int(10) UNSIGNED NOT NULL,
  `img_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `topic_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `topic_question_translations`
--

CREATE TABLE `topic_question_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `topic_question_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `txt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_ans_exp` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', NULL, '$2y$10$RDlgu6gkD9k85RBkVpGtq.cr6SYj/QvjRp.8tn5FGL9mjIuxXvKUW', '1D7GfaL9iTXsWuLnTvOvNAG1JlpTIC4CpNoZ6gf2E7DqFx80vteIt6Fck4sU', '2019-05-09 12:26:43', '2019-05-09 12:26:43');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `answer_translations`
--
ALTER TABLE `answer_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `answer_translations_answer_id_locale_unique` (`answer_id`,`locale`),
  ADD KEY `answer_translations_locale_index` (`locale`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `category_translations`
--
ALTER TABLE `category_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  ADD KEY `category_translations_locale_index` (`locale`);

--
-- Indices de la tabla `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indices de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indices de la tabla `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD KEY `fk_p_35046_35047_role_per_5ccc639820a9a` (`permission_id`),
  ADD KEY `fk_p_35047_35046_permissi_5ccc639820ae0` (`role_id`);

--
-- Indices de la tabla `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `question_translations`
--
ALTER TABLE `question_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `question_translations_question_id_locale_unique` (`question_id`,`locale`),
  ADD KEY `question_translations_locale_index` (`locale`);

--
-- Indices de la tabla `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `result_translations`
--
ALTER TABLE `result_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `result_translations_result_id_locale_unique` (`result_id`,`locale`),
  ADD KEY `result_translations_locale_index` (`locale`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD KEY `fk_p_35047_35048_user_rol_5ccc639a4111d` (`role_id`),
  ADD KEY `fk_p_35048_35047_role_use_5ccc639a41160` (`user_id`);

--
-- Indices de la tabla `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `test_translations`
--
ALTER TABLE `test_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_translations_test_id_locale_unique` (`test_id`,`locale`),
  ADD KEY `test_translations_locale_index` (`locale`);

--
-- Indices de la tabla `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `topic_questions`
--
ALTER TABLE `topic_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `topic_question_translations`
--
ALTER TABLE `topic_question_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `topic_question_translations_topic_question_id_locale_unique` (`topic_question_id`,`locale`),
  ADD KEY `topic_question_translations_locale_index` (`locale`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `answer_translations`
--
ALTER TABLE `answer_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `category_translations`
--
ALTER TABLE `category_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `question_translations`
--
ALTER TABLE `question_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `results`
--
ALTER TABLE `results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `result_translations`
--
ALTER TABLE `result_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tests`
--
ALTER TABLE `tests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `test_translations`
--
ALTER TABLE `test_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `topic_questions`
--
ALTER TABLE `topic_questions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `topic_question_translations`
--
ALTER TABLE `topic_question_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `fk_p_35046_35047_role_per_5ccc639820a9a` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_p_35047_35046_permissi_5ccc639820ae0` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_p_35047_35048_user_rol_5ccc639a4111d` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_p_35048_35047_role_use_5ccc639a41160` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
