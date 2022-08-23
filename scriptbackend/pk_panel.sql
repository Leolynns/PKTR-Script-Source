-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 30 Tem 2019, 22:53:04
-- Sunucu sürümü: 10.3.16-MariaDB
-- PHP Sürümü: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `pk_panel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `activations`
--

CREATE TABLE `activations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `activations`
--

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'zp6Rt7zGOiITt6TVieZioaEZxUltv3UI', 1, '2019-07-28 15:38:41', '2019-07-28 15:38:41', '2019-07-28 15:38:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `log` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ban_list`
--

CREATE TABLE `ban_list` (
  `id` int(10) UNSIGNED NOT NULL,
  `unique_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `banned` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `evler`
--

CREATE TABLE `evler` (
  `id` int(11) NOT NULL,
  `ev_id` int(11) DEFAULT NULL,
  `guid` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `factions`
--

CREATE TABLE `factions` (
  `id` int(11) NOT NULL,
  `fac_id` int(11) NOT NULL,
  `fac_name` varchar(64) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `fac_banner` int(11) NOT NULL,
  `lord_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `factions`
--

INSERT INTO `factions` (`id`, `fac_id`, `fac_name`, `fac_banner`, `lord_uid`) VALUES
(1, 2, 'Kattegat', 187, -1),
(2, 3, 'Normandiya', 52, -2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faction_players`
--

CREATE TABLE `faction_players` (
  `id` int(11) NOT NULL,
  `fac_id` int(11) NOT NULL,
  `p_guid` int(11) NOT NULL,
  `is_marshall` tinyint(1) NOT NULL DEFAULT 0,
  `has_doorkey` tinyint(1) NOT NULL DEFAULT 0,
  `has_moneykey` tinyint(1) NOT NULL DEFAULT 0,
  `has_chestkey` tinyint(1) NOT NULL DEFAULT 0,
  `can_announce` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `faction_players`
--

INSERT INTO `faction_players` (`id`, `fac_id`, `p_guid`, `is_marshall`, `has_doorkey`, `has_moneykey`, `has_chestkey`, `can_announce`) VALUES
(1, 2, -1, 0, 1, 1, 1, 1),
(2, 3, -2, 0, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `houses`
--

CREATE TABLE `houses` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_07_02_230147_migration_cartalyst_sentinel', 1),
(2, '2018_01_15_141101_create_players_table', 1),
(3, '2018_01_15_151308_create_player_bans_table', 1),
(4, '2018_01_15_160438_create_houses_table', 1),
(5, '2018_01_15_203937_create_refund_logs_table', 1),
(6, '2018_01_15_212115_create_admin_logs_table', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `persistences`
--

CREATE TABLE `persistences` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pw_admin_permler`
--

CREATE TABLE `pw_admin_permler` (
  `id` int(11) NOT NULL,
  `guid` int(11) NOT NULL,
  `gold` int(11) NOT NULL DEFAULT 0,
  `kick` int(11) NOT NULL DEFAULT 0,
  `temp_ban` int(11) NOT NULL DEFAULT 0,
  `perm_ban` int(11) NOT NULL DEFAULT 0,
  `kill_fade` int(11) NOT NULL DEFAULT 0,
  `freeze` int(11) NOT NULL DEFAULT 0,
  `teleport_self` int(11) NOT NULL DEFAULT 0,
  `admin_items` int(11) NOT NULL DEFAULT 0,
  `heal_self` int(11) NOT NULL DEFAULT 0,
  `godlike_troop` int(11) DEFAULT 0,
  `ships` int(11) NOT NULL DEFAULT 0,
  `announce` int(11) NOT NULL DEFAULT 0,
  `override_poll` int(11) NOT NULL DEFAULT 0,
  `all_items` int(11) NOT NULL DEFAULT 0,
  `mute` int(11) NOT NULL DEFAULT 0,
  `animals` int(11) NOT NULL,
  `factions` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `pw_admin_permler`
--

INSERT INTO `pw_admin_permler` (`id`, `guid`, `gold`, `kick`, `temp_ban`, `perm_ban`, `kill_fade`, `freeze`, `teleport_self`, `admin_items`, `heal_self`, `godlike_troop`, `ships`, `announce`, `override_poll`, `all_items`, `mute`, `animals`, `factions`) VALUES
(1, 1719000, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 4214615, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 4272020, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(4, 1781574, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pw_oyuncular`
--

CREATE TABLE `pw_oyuncular` (
  `id` int(10) UNSIGNED NOT NULL,
  `unique_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_scene` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banka` int(11) NOT NULL DEFAULT 0,
  `at_can` int(11) NOT NULL DEFAULT -1,
  `can` int(11) NOT NULL DEFAULT 0,
  `pos_x` int(11) NOT NULL DEFAULT 0,
  `pos_y` int(11) NOT NULL DEFAULT 0,
  `pos_z` int(11) NOT NULL DEFAULT 0,
  `ustundeki_gold` int(11) NOT NULL DEFAULT 0,
  `meslek` int(11) NOT NULL DEFAULT 0,
  `faction` int(11) NOT NULL DEFAULT 0,
  `item_0` int(11) NOT NULL DEFAULT -1,
  `item_1` int(11) NOT NULL DEFAULT -1,
  `item_2` int(11) NOT NULL DEFAULT -1,
  `item_3` int(11) NOT NULL DEFAULT -1,
  `govde_zirhi` int(11) NOT NULL DEFAULT -1,
  `kask` int(11) NOT NULL DEFAULT -1,
  `ayak_zirhi` int(11) NOT NULL DEFAULT -1,
  `eldiven` int(11) NOT NULL DEFAULT -1,
  `entry_point` int(11) NOT NULL DEFAULT 0,
  `at` int(11) NOT NULL DEFAULT -1,
  `aclik` int(11) NOT NULL DEFAULT 0,
  `oynama_suresi` int(11) DEFAULT NULL,
  `olme` int(11) NOT NULL DEFAULT 0,
  `oldurme` int(11) NOT NULL DEFAULT 0,
  `exited` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `pw_oyuncular`
--

INSERT INTO `pw_oyuncular` (`id`, `unique_id`, `name`, `last_scene`, `banka`, `at_can`, `can`, `pos_x`, `pos_y`, `pos_z`, `ustundeki_gold`, `meslek`, `faction`, `item_0`, `item_1`, `item_2`, `item_3`, `govde_zirhi`, `kask`, `ayak_zirhi`, `eldiven`, `entry_point`, `at`, `aclik`, `oynama_suresi`, `olme`, `oldurme`, `exited`) VALUES
(15, '3234934', 'leolynn', NULL, 1000, 91, 17, 34123, 26570, 347, 999994999, 27, 2, 647, 1002, 803, 439, 157, 19, 343, -1, -1, 997, 0, NULL, 0, 5, NULL),
(37, '0000000', 'xxx', NULL, 0, 100, 77, 34805, 30090, 299, 1000, 4, 0, -1, -1, -1, -1, -1, -1, -1, -1, -1, 0, 0, NULL, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `refund_logs`
--

CREATE TABLE `refund_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `refunder` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int(11) NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `unique_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reminders`
--

CREATE TABLE `reminders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', NULL, '2019-07-28 15:38:41', '2019-07-28 15:38:41'),
(2, 'moderator', 'moderator', NULL, '2019-07-28 15:38:41', '2019-07-28 15:38:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `role_users`
--

CREATE TABLE `role_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-07-28 15:38:41', '2019-07-28 15:38:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `throttle`
--

INSERT INTO `throttle` (`id`, `user_id`, `type`, `ip`, `created_at`, `updated_at`) VALUES
(1, NULL, 'global', NULL, '2019-07-28 17:02:52', '2019-07-28 17:02:52'),
(2, NULL, 'ip', '176.43.203.30', '2019-07-28 17:02:52', '2019-07-28 17:02:52'),
(3, 2, 'user', NULL, '2019-07-28 17:02:52', '2019-07-28 17:02:52'),
(4, NULL, 'global', NULL, '2019-07-28 17:08:53', '2019-07-28 17:08:53'),
(5, NULL, 'ip', '::1', '2019-07-28 17:08:53', '2019-07-28 17:08:53'),
(6, 1, 'user', NULL, '2019-07-28 17:08:53', '2019-07-28 17:08:53'),
(7, NULL, 'global', NULL, '2019-07-28 17:09:08', '2019-07-28 17:09:08'),
(8, NULL, 'ip', '::1', '2019-07-28 17:09:08', '2019-07-28 17:09:08'),
(9, 1, 'user', NULL, '2019-07-28 17:09:08', '2019-07-28 17:09:08'),
(10, NULL, 'global', NULL, '2019-07-28 17:09:58', '2019-07-28 17:09:58'),
(11, NULL, 'ip', '::1', '2019-07-28 17:09:58', '2019-07-28 17:09:58'),
(12, NULL, 'global', NULL, '2019-07-28 17:11:14', '2019-07-28 17:11:14'),
(13, NULL, 'ip', '::1', '2019-07-28 17:11:14', '2019-07-28 17:11:14'),
(14, NULL, 'global', NULL, '2019-07-28 17:12:39', '2019-07-28 17:12:39'),
(15, NULL, 'ip', '::1', '2019-07-28 17:12:39', '2019-07-28 17:12:39'),
(16, 2, 'user', NULL, '2019-07-28 17:12:39', '2019-07-28 17:12:39'),
(17, NULL, 'global', NULL, '2019-07-28 17:12:50', '2019-07-28 17:12:50'),
(18, NULL, 'ip', '::1', '2019-07-28 17:12:50', '2019-07-28 17:12:50'),
(19, 2, 'user', NULL, '2019-07-28 17:12:50', '2019-07-28 17:12:50');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ingame_nick` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `ingame_nick`, `permissions`, `last_login`, `first_name`, `last_name`, `created_at`, `updated_at`) VALUES
(1, 'protectmypass@outlook.com', '$2y$10$vxaekwRlfCuXrswfkPndmePcqtCBxrH6OqXP4ncl0B8H74Bqf4.KC', 'Antepli_Beyfendi', NULL, NULL, NULL, NULL, '2019-07-28 15:38:41', '2019-07-28 15:38:41');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `whitelist`
--

CREATE TABLE `whitelist` (
  `id` int(11) NOT NULL,
  `guid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `whitelist`
--

INSERT INTO `whitelist` (`id`, `guid`) VALUES
(1, 1322103),
(2, 700891),
(3, 3457077),
(4, 2841091),
(5, 4339579),
(6, 2107645),
(7, 3535867),
(8, 3881157),
(9, 4107112),
(10, 4005668),
(11, 1322450),
(12, 4143498),
(13, 4495391),
(14, 4385648),
(15, 4394927),
(16, 3818386),
(17, 3732402),
(18, 3818386),
(19, 3613535),
(20, 4132412),
(21, 2109610),
(22, 3412575),
(23, 2915278),
(24, 4176933),
(25, 2127482),
(26, 3679729),
(27, 4306864),
(28, 4290545),
(0, 1781574),
(25, 1781574),
(26, 4259402);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `ban_list`
--
ALTER TABLE `ban_list`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `evler`
--
ALTER TABLE `evler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `factions`
--
ALTER TABLE `factions`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `faction_players`
--
ALTER TABLE `faction_players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `p_guid` (`p_guid`);

--
-- Tablo için indeksler `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `persistences`
--
ALTER TABLE `persistences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `persistences_code_unique` (`code`);

--
-- Tablo için indeksler `pw_admin_permler`
--
ALTER TABLE `pw_admin_permler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pw_oyuncular`
--
ALTER TABLE `pw_oyuncular`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pw_oyuncular_unique_id_unique` (`unique_id`);

--
-- Tablo için indeksler `refund_logs`
--
ALTER TABLE `refund_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Tablo için indeksler `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`);

--
-- Tablo için indeksler `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `throttle_user_id_index` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `activations`
--
ALTER TABLE `activations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ban_list`
--
ALTER TABLE `ban_list`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `factions`
--
ALTER TABLE `factions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `faction_players`
--
ALTER TABLE `faction_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `houses`
--
ALTER TABLE `houses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `persistences`
--
ALTER TABLE `persistences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `pw_admin_permler`
--
ALTER TABLE `pw_admin_permler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `pw_oyuncular`
--
ALTER TABLE `pw_oyuncular`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `refund_logs`
--
ALTER TABLE `refund_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `reminders`
--
ALTER TABLE `reminders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
