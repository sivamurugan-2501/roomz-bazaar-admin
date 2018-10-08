-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 08, 2018 at 04:30 AM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online-property`
--

-- --------------------------------------------------------

--
-- Table structure for table `backend_permissions`
--

DROP TABLE IF EXISTS `backend_permissions`;
CREATE TABLE IF NOT EXISTS `backend_permissions` (
  `permission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial Permission ID',
  `module_id` int(11) DEFAULT NULL COMMENT 'Permission Module ID',
  `permission_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Permission Key, using this only admin panel users rights are getting decided',
  `permission_label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Permission Label just shown to admin panel users, to identify permission at ease',
  `permission_parent` int(11) DEFAULT '0' COMMENT 'Parent ID for this permission entry, means here we can add menu list like a tree hierarchy',
  `permission_status` tinyint(4) DEFAULT '1' COMMENT 'Permission Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this permission entry',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this permission entry',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this permission entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `idx_permission_key` (`permission_key`),
  KEY `idx_module_id` (`module_id`),
  KEY `idx_permission_status` (`permission_status`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backend_permissions`
--

INSERT INTO `backend_permissions` (`permission_id`, `module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 'country-master', 'Country Master', 0, 1, NULL, '2017-11-04 12:47:04', NULL, NULL, NULL, NULL),
(2, 1, 'add-country-master', 'Add Country Master', 1, 1, NULL, '2017-11-04 12:47:04', NULL, NULL, NULL, NULL),
(3, 1, 'edit-country-master', 'Edit Country Master', 1, 1, NULL, '2017-11-04 12:47:04', NULL, NULL, NULL, NULL),
(4, 1, 'delete-country-master', 'Delete Country Master', 1, 1, NULL, '2017-11-04 12:47:04', NULL, NULL, NULL, NULL),
(5, 2, 'state-master', 'State Master', 0, 1, NULL, '2017-11-04 12:47:23', NULL, '2017-11-04 12:49:23', NULL, NULL),
(6, 2, 'add-state-master', 'Add State Master', 5, 1, NULL, '2017-11-04 12:47:23', NULL, '2017-11-04 12:49:23', NULL, NULL),
(7, 2, 'edit-state-master', 'Edit State Master', 5, 1, NULL, '2017-11-04 12:47:23', NULL, '2017-11-04 12:49:23', NULL, NULL),
(8, 2, 'delete-state-master', 'Delete State Master', 5, 1, NULL, '2017-11-04 12:47:23', NULL, '2017-11-04 12:49:23', NULL, NULL),
(9, 3, 'city-master', 'City Master', 0, 1, NULL, '2017-11-04 12:47:42', NULL, NULL, NULL, NULL),
(10, 3, 'add-city-master', 'Add City Master', 9, 1, NULL, '2017-11-04 12:47:42', NULL, NULL, NULL, NULL),
(11, 3, 'edit-city-master', 'Edit City Master', 9, 1, NULL, '2017-11-04 12:47:42', NULL, NULL, NULL, NULL),
(12, 3, 'delete-city-master', 'Delete City Master', 9, 1, NULL, '2017-11-04 12:47:42', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `backend_permission_module`
--

DROP TABLE IF EXISTS `backend_permission_module`;
CREATE TABLE IF NOT EXISTS `backend_permission_module` (
  `module_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial Permission Module ID',
  `module_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Permission Module Name, Basically it’s nothing but a admin panel, menu name. E.g. User Management, Roles Management etc.',
  `module_status` tinyint(4) DEFAULT '1' COMMENT 'Permission Module Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this permission module entry',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this permission module entry',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this permission module entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `idx_module_name` (`module_name`),
  KEY `idx_module_status` (`module_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backend_permission_module`
--

INSERT INTO `backend_permission_module` (`module_id`, `module_name`, `module_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Country Master', 1, NULL, '2017-11-04 12:47:04', NULL, NULL, NULL, NULL),
(2, 'State Master', 1, NULL, '2017-11-04 12:47:23', NULL, NULL, NULL, NULL),
(3, 'City Master', 1, NULL, '2017-11-04 12:47:42', NULL, NULL, NULL, NULL);

--
-- Triggers `backend_permission_module`
--
DROP TRIGGER IF EXISTS `delete_backend_permisions`;
DELIMITER $$
CREATE TRIGGER `delete_backend_permisions` AFTER DELETE ON `backend_permission_module` FOR EACH ROW BEGIN
DECLARE last_id INT;
SET last_id = OLD.module_id;
DELETE FROM `backend_permissions` WHERE `backend_permissions`.`module_id` = last_id;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `insert_backend_permissions`;
DELIMITER $$
CREATE TRIGGER `insert_backend_permissions` AFTER INSERT ON `backend_permission_module` FOR EACH ROW BEGIN
                                    # Creating variable last_id to store autoincremental id from first insert statement did over backend_permissions table
                                    DECLARE last_id INT;
                                    # Creating variable perm_slug to store permission name from backend_permission_module table, where all spaces are replaced with - and characters are of lower case
                                    DECLARE perm_slug VARCHAR(191);
                                    SET perm_slug = REPLACE(LOWER(NEW.module_name), ' ', '-');
                                    # Adding module entry in backend_permission table, which will work as base record entry for other permissions like add, edit, delete etc.
                                    INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, perm_slug, NEW.module_name, 0, NEW.module_status);
                                    # last_id variable value gets assigned by below statement
                                    SELECT LAST_INSERT_ID() INTO last_id;
                                    # Adding a entry to have add permission to module
                                    INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, CONCAT('add-', perm_slug), CONCAT('Add ', NEW.module_name), last_id, NEW.module_status);
                                    # Editing a entry to have add permission to module
                                    INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, CONCAT('edit-', perm_slug), CONCAT('Edit ', NEW.module_name), last_id, NEW.module_status);
                                    # Deleting a entry to have add permission to module
                                    INSERT INTO `backend_permissions`(`module_id`, `permission_key`, `permission_label`, `permission_parent`, `permission_status`) VALUES (NEW.module_id, CONCAT('delete-', perm_slug), CONCAT('Delete ', NEW.module_name), last_id, NEW.module_status);
                            END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `update_backend_permissions`;
DELIMITER $$
CREATE TRIGGER `update_backend_permissions` AFTER UPDATE ON `backend_permission_module` FOR EACH ROW BEGIN
# Creating variable last_id to store autoincremental id from first insert statement did over backend_permissions table
DECLARE last_id INT;
# Creating variable new_perm_slug to store permission name from backend_permission_module table, where all spaces are replaced with - and characters are of lower case
DECLARE new_perm_slug VARCHAR(191);
# Creating variable old_perm_slug to store permission name from backend_permission_module table, where all spaces are relaced with - and characters are of lower case
DECLARE old_perm_slug VARCHAR(191);
SET last_id = OLD.module_id;
SET new_perm_slug = REPLACE(LOWER(NEW.module_name), ' ', '-');
SET old_perm_slug = REPLACE(LOWER(OLD.module_name), ' ', '-');
# Updating permission_key & permission_label from backend_permissions table based on field module_id
UPDATE `backend_permissions` SET `permission_key` = REPLACE(`permission_key`, old_perm_slug, new_perm_slug), `permission_label` = REPLACE(`permission_label`, OLD.module_name, NEW.module_name), `permission_status` = NEW.`module_status` WHERE `module_id` = last_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `backend_roles`
--

DROP TABLE IF EXISTS `backend_roles`;
CREATE TABLE IF NOT EXISTS `backend_roles` (
  `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial Role ID',
  `role_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Role Name',
  `role_status` tinyint(4) DEFAULT '1' COMMENT 'Role Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this role entry',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this role entry',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this role entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`role_id`),
  KEY `idx_role_status` (`role_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backend_roles`
--

INSERT INTO `backend_roles` (`role_id`, `role_name`, `role_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Admin', 1, NULL, '2017-11-05 01:01:50', NULL, '2017-11-05 01:01:50', NULL, NULL),
(2, 'Staff', 0, NULL, '2017-11-05 06:41:51', NULL, '2017-11-11 20:57:32', NULL, '2017-11-11 15:27:32'),
(3, 'General Staff', 1, NULL, '2017-11-05 06:43:11', NULL, '2017-11-05 06:52:50', NULL, NULL),
(4, 'TEST REST', 1, NULL, '2017-11-06 10:03:00', NULL, '2017-11-06 10:03:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `backend_role_permission`
--

DROP TABLE IF EXISTS `backend_role_permission`;
CREATE TABLE IF NOT EXISTS `backend_role_permission` (
  `role_permission_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Role Permission ID',
  `role_id` int(11) DEFAULT NULL COMMENT 'Role ID',
  `permission_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Permission Key',
  `role_permission_status` tinyint(4) DEFAULT '1' COMMENT 'Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this permission entry against role',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this permission entry against role',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this permission module entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`role_permission_id`),
  UNIQUE KEY `idx_role_id_permission_key` (`role_id`,`permission_key`),
  KEY `idx_role_permission_status` (`role_permission_status`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backend_role_permission`
--

INSERT INTO `backend_role_permission` (`role_permission_id`, `role_id`, `permission_key`, `role_permission_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 'country-master', 1, NULL, '2017-11-05 12:09:26', NULL, NULL, NULL, NULL),
(2, 1, 'add-country-master', 0, NULL, '2017-11-05 12:09:26', NULL, '2017-11-05 12:09:56', NULL, NULL),
(3, 1, 'state-master', 1, NULL, '2017-11-05 12:09:26', NULL, NULL, NULL, NULL),
(4, 1, 'add-state-master', 1, NULL, '2017-11-05 12:09:26', NULL, NULL, NULL, NULL),
(5, 1, 'city-master', 1, NULL, '2017-11-05 12:09:26', NULL, NULL, NULL, NULL),
(6, 1, 'add-city-master', 1, NULL, '2017-11-05 12:09:26', NULL, NULL, NULL, NULL),
(7, 1, 'edit-country-master', 0, NULL, '2017-11-05 12:09:56', NULL, '2017-11-05 12:11:19', NULL, NULL),
(8, 1, 'delete-country-master', 0, NULL, '2017-11-05 12:09:56', NULL, '2017-11-05 12:11:19', NULL, NULL),
(9, 3, 'country-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(10, 3, 'add-country-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(11, 3, 'edit-country-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(12, 3, 'delete-country-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(13, 3, 'city-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(14, 3, 'add-city-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(15, 3, 'edit-city-master', 1, NULL, '2017-11-05 12:13:59', NULL, NULL, NULL, NULL),
(16, 3, 'state-master', 1, NULL, '2017-11-05 12:15:36', NULL, NULL, NULL, NULL),
(17, 3, 'edit-state-master', 1, NULL, '2017-11-05 12:15:36', NULL, NULL, NULL, NULL),
(18, 4, 'country-master', 1, NULL, '2017-11-06 15:33:00', NULL, NULL, NULL, NULL),
(19, 4, 'edit-country-master', 1, NULL, '2017-11-06 15:33:00', NULL, NULL, NULL, NULL),
(20, 4, 'delete-country-master', 1, NULL, '2017-11-06 15:33:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `backend_users`
--

DROP TABLE IF EXISTS `backend_users`;
CREATE TABLE IF NOT EXISTS `backend_users` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial User ID',
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User Full Name',
  `user_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'User Email ID',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'After, user registration this key is used for validating proper user.',
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'User Password',
  `user_password_reset_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Password reset key, used for Forgot Password Functionality',
  `require_password_change` tinyint(4) DEFAULT '0' COMMENT 'Required for user to change his/her passsword after doing a login/before login.',
  `user_status` tinyint(4) DEFAULT '0' COMMENT 'User Account Status: 0=Inactive, 1=Active, 2=suspended. User Status will get auto changed to 1, when user_activation_key is matched by the user',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have created this user entry',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this user entry',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this user entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `idx_user_email` (`user_email`),
  KEY `idx_require_password_change` (`require_password_change`),
  KEY `idx_user_status` (`user_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `backend_users`
--

INSERT INTO `backend_users` (`user_id`, `user_name`, `user_email`, `user_activation_key`, `user_password`, `user_password_reset_key`, `require_password_change`, `user_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Prasad Wargad', 'prasad.wargad@mailcatch.com', NULL, '$2y$12$1olcbCEVPGge0/jQO5cPvuAot1C1L.y0DYBuRgijdw7TSmRy97uyi\r\n', NULL, 1, 1, NULL, '2017-11-05 07:44:06', NULL, '2018-08-24 19:19:39', NULL, NULL),
(2, 'Makrand Wargad\'s', 'makrand.wargad@mailcatch.com', NULL, '$2y$12$EroMpskD2ihuM0rh6W7/q.jgPBbsvzrP/kl1dVGv3/T0h4a.QMlxi\r\n', NULL, 0, 1, NULL, '2017-11-05 07:44:06', NULL, '2018-08-24 19:21:35', NULL, '2017-11-11 14:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `city_master`
--

DROP TABLE IF EXISTS `city_master`;
CREATE TABLE IF NOT EXISTS `city_master` (
  `city_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial City ID',
  `city_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'City Name',
  `state_id` int(11) NOT NULL COMMENT 'State ID',
  `city_status` tinyint(4) DEFAULT '1' COMMENT 'Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this city details',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this city details',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this city details',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`city_id`),
  KEY `idx_state_id` (`state_id`),
  KEY `idx_city_status` (`city_status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city_master`
--

INSERT INTO `city_master` (`city_id`, `city_name`, `state_id`, `city_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Mumbai', 4, 0, NULL, '2017-10-21 16:06:28', NULL, '2017-11-12 19:11:51', NULL, '2017-11-12 13:41:51'),
(2, 'Pune', 4, 1, NULL, '2017-10-21 16:09:03', NULL, '2017-10-22 03:57:32', NULL, '2017-10-21 16:13:02'),
(3, 'Bangalore', 3, 1, NULL, '2017-10-21 16:09:38', NULL, '2017-10-21 16:12:15', NULL, NULL),
(4, 'Lords', 6, 0, NULL, '2017-10-21 16:15:54', NULL, '2017-10-21 21:46:36', NULL, '2017-10-21 16:16:36'),
(5, 'Melbourne', 7, 1, NULL, '2017-10-22 00:02:19', NULL, '2017-10-22 00:02:19', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `country_master`
--

DROP TABLE IF EXISTS `country_master`;
CREATE TABLE IF NOT EXISTS `country_master` (
  `country_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial Country ID',
  `country_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Country Name',
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Country Code',
  `country_status` tinyint(4) DEFAULT '1' COMMENT 'Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this country details',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this country details',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this country details',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`country_id`),
  UNIQUE KEY `idx_country_name` (`country_name`),
  UNIQUE KEY `idx_country_code` (`country_code`),
  KEY `idx_country_status` (`country_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_master`
--

INSERT INTO `country_master` (`country_id`, `country_name`, `country_code`, `country_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'India', 'IN', 1, 1, '2017-10-21 10:30:01', NULL, NULL, NULL, NULL),
(2, 'Srilanka', 'SK', 1, NULL, '2017-10-21 08:49:13', NULL, '2017-10-21 12:26:22', NULL, '2017-10-21 12:25:20'),
(3, 'Australia', 'AU', 1, NULL, '2017-10-21 09:17:59', NULL, '2017-10-21 12:04:41', NULL, '2017-10-21 11:07:00'),
(4, 'Japan', 'JP', 0, NULL, '2017-10-21 12:07:04', NULL, '2017-10-21 17:50:59', NULL, '2017-10-21 12:20:59'),
(5, 'America', 'US', 1, NULL, '2017-10-21 14:30:04', NULL, '2017-10-21 14:30:04', NULL, NULL),
(6, 'England', 'ENG', 0, NULL, '2017-10-21 16:14:17', NULL, '2017-10-21 21:47:37', NULL, '2017-10-21 16:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `master_amenities`
--

DROP TABLE IF EXISTS `master_amenities`;
CREATE TABLE IF NOT EXISTS `master_amenities` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon_path` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_amenities`
--

INSERT INTO `master_amenities` (`id`, `name`, `icon_path`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Sports Club', 'sasa', 1, 1, 0, '2017-11-04 17:54:59', '2017-11-04 18:14:47'),
(2, 'Gym', 'sd', 1, 1, 0, '2017-11-04 17:58:57', '2017-11-04 17:58:57'),
(3, 'Gardern', 'C:\\wamp64_n\\tmp\\php33BA.tmp', 1, 1, 0, '2017-11-05 06:46:32', '2017-11-05 06:46:32'),
(4, 'Swimming Pool', 'Swimming Pool.image/png', 1, 1, 0, '2017-11-05 06:53:54', '2017-11-05 06:53:54'),
(5, 'test', 'public/portal/uploads/amenities/test.png', 1, 1, 0, '2017-11-05 06:57:06', '2017-11-05 06:57:06'),
(6, 'test1', 'uploads/test1.png', 1, 1, 0, '2017-11-05 07:01:05', '2017-11-05 07:01:05'),
(7, 'new 21', 'uploads/new 21.png', 1, 1, 0, '2017-11-05 07:03:27', '2017-11-05 07:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `master_property_type`
--

DROP TABLE IF EXISTS `master_property_type`;
CREATE TABLE IF NOT EXISTS `master_property_type` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_parent` tinyint(1) NOT NULL DEFAULT '0',
  `parent` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `furnishes` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `master_property_type_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_property_type`
--

INSERT INTO `master_property_type` (`id`, `created_at`, `updated_at`, `is_parent`, `parent`, `status`, `created_by`, `updated_by`, `name`, `furnishes`) VALUES
(1, '2017-10-08 09:21:45', '2017-10-11 13:24:18', 1, 0, 1, 1, 1, 'Residential', 0),
(2, '2017-10-11 12:27:26', '2017-10-11 12:27:26', 1, 0, 1, 1, 0, 'Commercial', 0),
(9, '2017-10-20 09:33:05', '2017-10-20 09:33:05', 0, 2, 1, 1, 0, 'Test Comm', 0),
(6, '2017-10-20 06:46:46', '2017-10-20 06:46:46', 0, 1, 1, 1, 0, 'Residentail Apartment', 0),
(7, '2017-10-20 06:47:25', '2017-10-20 06:47:25', 0, 1, 1, 1, 0, 'Residential Land', 0),
(8, '2017-10-20 06:47:41', '2017-10-20 06:47:41', 0, 1, 1, 1, 0, 'Studio Apartment', 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_08_09_181226_create_masterPropType', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2017_07_07_022637_create_general_info_table', 1),
(5, '2017_10_20_105200_create_backend_users_table', 2),
(6, '2017_10_20_135334_create_backend_roles_table', 2),
(7, '2017_10_20_165927_create_backend_permission_module', 2),
(8, '2017_10_20_170712_create_backend_permissions', 2),
(10, '2017_10_20_172239_create_country_master', 2),
(11, '2017_10_20_173613_create_state_master', 2),
(13, '2017_10_20_174141_create_city_master', 3),
(15, '2017_10_22_135013_alter_backend_users', 4),
(17, '2017_10_30_192949_trigger_on_permission_module', 5),
(18, '2017_11_04_124142_update_trigger_on_permission_module', 6),
(19, '2017_11_04_124214_delete_trigger_on_permission_module', 6),
(22, '2017_10_20_171806_create_backend_role_permission', 7),
(24, '2017_11_12_134007_alter_users_table', 8),
(26, '2018_07_08_130648_create_property_type_master', 9),
(56, '2018_07_21_135327_rename_table_general_info_to_property_master', 10),
(57, '2018_07_21_141054_alter_table_property_master', 11),
(58, '2018_07_21_181111_alter_table_add_column_property_master', 11),
(60, '2018_07_22_041431_alter_table_add_column_status_property_master', 12),
(61, '2018_07_22_044139_alter_table_modify_column_tota_square_feet_property_master', 13),
(62, '2018_07_22_044255_alter_table_modify_column_tota_square_feet1_property_master', 13),
(64, '2018_07_22_174525_alter_table_add_column_rera_number_property_master', 14),
(65, '2017_10_08_064910_create_master_propety_type_table', 15),
(66, '2017_11_04_171760_master_amenities', 15),
(67, '2017_11_27_221900_create_general_info_table', 15),
(68, '2018_09_29_172002_old_property_schema', 16),
(69, '2018_09_29_172003_old_property_schema', 17),
(70, '2018_09_29_172004_old_property_schema', 18),
(71, '2018_09_29_172005_old_property_schema', 19),
(72, '2018_09_29_172006_old_property_schema', 20),
(73, '2018_09_29_172007_old_property_schema', 21),
(74, '2018_09_29_172008_old_property_schema', 22);

-- --------------------------------------------------------

--
-- Table structure for table `old_property_prs`
--

DROP TABLE IF EXISTS `old_property_prs`;
CREATE TABLE IF NOT EXISTS `old_property_prs` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_type_id` int(11) DEFAULT '0' COMMENT 'Foreign key refeameces property_type_master > type_id',
  `show_as` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(11) DEFAULT '0' COMMENT 'City ID',
  `state_id` int(11) DEFAULT '0' COMMENT 'State ID',
  `country_id` int(11) DEFAULT '0' COMMENT 'Country ID',
  `landmark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_age` int(11) DEFAULT '0' COMMENT 'Property Age',
  `total_floors` int(11) NOT NULL,
  `floor_no` int(11) NOT NULL,
  `per_square_feet` int(11) NOT NULL,
  `total_square_feet` int(11) NOT NULL,
  `carpet_area` int(11) NOT NULL,
  `usable_area` int(11) NOT NULL,
  `total_rate` int(11) NOT NULL,
  `negotiable` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Negotiable',
  `advance_deposite` double(8,2) NOT NULL,
  `rent_per_month` double(8,2) NOT NULL,
  `maintenance_include` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Maintenance included or not',
  `parking` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Parking available or not',
  `gym` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Gym available or not',
  `water_supply` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Water supply available or not',
  `garden` enum('yes','no') COLLATE utf8mb4_unicode_ci DEFAULT 'no' COMMENT 'Garden space available or not',
  `others` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rera_number` varchar(55) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RERA Number',
  `property_status` tinyint(4) DEFAULT '1' COMMENT 'Status: 0=Inactive, 1=Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `maintenance_charge` decimal(15,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `idx_property_type_id` (`property_type_id`),
  KEY `idx_property_status` (`property_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `old_property_prs`
--

INSERT INTO `old_property_prs` (`id`, `name`, `property_type_id`, `show_as`, `address`, `city_id`, `state_id`, `country_id`, `landmark`, `property_age`, `total_floors`, `floor_no`, `per_square_feet`, `total_square_feet`, `carpet_area`, `usable_area`, `total_rate`, `negotiable`, `advance_deposite`, `rent_per_month`, `maintenance_include`, `parking`, `gym`, `water_supply`, `garden`, `others`, `rera_number`, `property_status`, `created_at`, `updated_at`, `maintenance_charge`) VALUES
(1, 'TEST', 1, 'sale', 'TEST', 3, 3, 1, 'test', 22222, 222, 222, 53, 123, 123, 123, 234, 'yes', 1212.00, 1212.00, 'no', 'yes', 'yes', 'yes', 'no', 'test', 'TEST', 1, '2018-07-22 08:20:30', '2018-07-22 12:35:10', '0.00'),
(2, 'TEST rest', 1, 'sale', 'tettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettettet', 2, 4, 1, '53W5', 535, 535, 535, 12, 121, 121, 121, 1212, 'yes', 1212.00, 121.00, 'no', 'no', 'no', 'no', 'no', 'TEST', NULL, 1, '2018-07-22 08:25:24', '2018-07-22 09:45:30', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
CREATE TABLE IF NOT EXISTS `property` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `property_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_as` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `state` int(11) NOT NULL DEFAULT '0',
  `city` int(11) NOT NULL DEFAULT '0',
  `landmark` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-',
  `age` int(11) NOT NULL DEFAULT '0',
  `total_floors` int(11) NOT NULL,
  `floor_no` int(11) NOT NULL,
  `per_square_feet` int(11) NOT NULL,
  `tota_square_feet` int(11) NOT NULL,
  `carpet_area` int(11) NOT NULL DEFAULT '0',
  `usable_area` int(11) NOT NULL DEFAULT '0',
  `total_rate` decimal(15,2) NOT NULL DEFAULT '0.00',
  `negotiable` int(11) NOT NULL DEFAULT '0',
  `advance_deposit` bigint(20) NOT NULL DEFAULT '0',
  `rent` bigint(20) NOT NULL DEFAULT '0',
  `maintenance_include` smallint(6) NOT NULL DEFAULT '0',
  `parking` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gym` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `water_supply` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `garden` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `others` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `transaction_type` int(11) NOT NULL DEFAULT '0',
  `possession_type` int(11) NOT NULL DEFAULT '0',
  `possession_year` int(11) NOT NULL DEFAULT '0',
  `no_of_bedroom` int(11) NOT NULL DEFAULT '0',
  `no_of_bathroom` int(11) NOT NULL DEFAULT '0',
  `amenities` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
  `no_of_balcony` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `for_gender` int(11) NOT NULL DEFAULT '0',
  `maintenance_charge` decimal(15,2) NOT NULL DEFAULT '0.00',
  `furnishes` tinyint(1) NOT NULL DEFAULT '0',
  `includes_stamp_paper_charge` smallint(6) NOT NULL DEFAULT '0',
  `other_charges` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `name`, `property_type`, `show_as`, `address`, `state`, `city`, `landmark`, `age`, `total_floors`, `floor_no`, `per_square_feet`, `tota_square_feet`, `carpet_area`, `usable_area`, `total_rate`, `negotiable`, `advance_deposit`, `rent`, `maintenance_include`, `parking`, `gym`, `water_supply`, `garden`, `others`, `created_at`, `updated_at`, `transaction_type`, `possession_type`, `possession_year`, `no_of_bedroom`, `no_of_bathroom`, `amenities`, `no_of_balcony`, `status`, `for_gender`, `maintenance_charge`, `furnishes`, `includes_stamp_paper_charge`, `other_charges`) VALUES
(1, 'KAlpataru residency', '6', 'Sales', 'mukund nagar ,ganaga building,room no3', 4, 1, 'MAHARASTRA', 0, 10, 4, 0, 0, 0, 0, '0.00', 0, 0, 0, 0, '0', '0', 'null', '0', 'null', '2018-09-29 12:26:21', '2018-09-29 12:26:49', 1, 0, 0, 2, 1, '[]', 0, 1, 0, '0.00', 0, 0, 0),
(2, 'My  NEW test', '9', 'Sales', 'MUKUND NAGAR HSG,GANGA BLDG,FLAT NO 3\r\nSION BANDRA LINK ROAD', 4, 1, 'MAHARASTRA', 0, 10, 3, 0, 0, 900, 1000, '200000.00', 1, 0, 0, 0, '0', '0', 'null', '0', 'null', '2018-10-07 01:16:20', '2018-10-07 01:27:57', 1, 0, 0, 0, 0, '[\"1\",\"2\",\"3\",\"4\"]', 0, 1, 0, '0.00', 0, 1, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `property_type_master`
--

DROP TABLE IF EXISTS `property_type_master`;
CREATE TABLE IF NOT EXISTS `property_type_master` (
  `type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial Property Type ID',
  `type_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Property Type Name',
  `type_status` tinyint(4) DEFAULT '1' COMMENT 'Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have created this user entry',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this user entry',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this user entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `idx_type_name` (`type_name`),
  KEY `idx_type_status` (`type_status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `property_type_master`
--

INSERT INTO `property_type_master` (`type_id`, `type_name`, `type_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, '1RK', 1, 1, '2018-07-22 14:18:35', NULL, '2018-07-22 13:14:26', NULL, '2018-07-22 13:14:05'),
(2, '1 BHK', 1, NULL, '2018-07-22 13:13:43', NULL, '2018-07-22 13:14:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `state_master`
--

DROP TABLE IF EXISTS `state_master`;
CREATE TABLE IF NOT EXISTS `state_master` (
  `state_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Serial State ID',
  `state_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'State Name',
  `country_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Country Code',
  `state_code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'State Code',
  `state_status` tinyint(4) DEFAULT '1' COMMENT 'Status: 0=Inactive, 1=Active',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have added this state details',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Created At',
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this state details',
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Updated At',
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this state details',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`state_id`),
  KEY `idx_state_status` (`state_status`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `state_master`
--

INSERT INTO `state_master` (`state_id`, `state_name`, `country_code`, `state_code`, `state_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Colombo', 'SK', 'CLB', 0, NULL, '2017-10-21 14:09:51', NULL, '2017-10-22 03:42:33', NULL, NULL),
(2, 'Colombo\'s', 'SK', 'CLB\'s', 1, NULL, '2017-10-21 14:11:26', NULL, '2017-10-21 14:11:26', NULL, NULL),
(3, 'Karnataka', 'IN', 'KA', 1, NULL, '2017-10-21 14:13:48', NULL, '2017-11-12 13:18:32', NULL, '2017-11-12 13:15:54'),
(4, 'Maharashtra', 'IN', 'MH', 1, NULL, '2017-10-21 14:20:18', NULL, '2017-10-22 03:52:11', NULL, '2017-10-21 14:25:26'),
(5, 'New York', 'US', 'NY', 1, NULL, '2017-10-21 14:30:56', NULL, '2017-10-21 14:30:56', NULL, NULL),
(6, 'London', 'ENG', 'LDN', 0, NULL, '2017-10-21 16:15:28', NULL, '2017-10-21 21:46:52', NULL, '2017-10-21 16:16:52'),
(7, 'Sydney', 'AU', 'SYD', 1, NULL, '2017-10-22 00:01:45', NULL, '2017-10-22 00:01:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'After, user registration this key is used for validating proper user.',
  `user_password_reset_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Password reset key, used for Forgot Password Functionality',
  `require_password_change` tinyint(4) DEFAULT '0' COMMENT 'Required for user to change his/her passsword after doing a login/before login.',
  `role_id` int(11) DEFAULT NULL COMMENT 'Role ID Foreign Key Referring To backend_roles table',
  `user_status` tinyint(4) DEFAULT '0' COMMENT 'User Account Status: 0=Inactive, 1=Active, 2=suspended. User Status will get auto changed to 1, when user_activation_key is matched by the user',
  `created_by` int(11) DEFAULT NULL COMMENT 'User ID, who have created this user entry',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL COMMENT 'User ID, who have updated this user entry',
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL COMMENT 'User ID, who have deleted this user entry',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT 'Deleted At',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `idx_require_password_change` (`require_password_change`),
  KEY `idx_role_id` (`role_id`),
  KEY `idx_user_status` (`user_status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `user_activation_key`, `user_password_reset_key`, `require_password_change`, `role_id`, `user_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'Prasad Wargad', 'pwargad@gmail.com', '$2y$12$Fejdky3aYsfSPE08EoS0zOZQX7lt3GfvVAR0ejzAVTFSEkvjpyp0O\r\n', NULL, NULL, NULL, 0, 1, 1, NULL, '2017-10-05 12:06:38', NULL, '2017-11-12 08:46:16', NULL, '2017-11-12 08:45:51'),
(2, 'TEST REST', 'test@mailcatch.co', '$2y$12$UW1BkOdr0bfsPbGyOLBmRObJTUIGFAlkOQCXgEIJzQjjoEfJsT8lS', NULL, NULL, NULL, 0, 4, 1, NULL, '2017-10-21 00:04:15', NULL, '2017-11-12 08:46:59', NULL, NULL),
(3, 'Makrand Wargad', 'makrand@mailcatch.com', '$2y$10$.FA53ndiVuPpU5zHNNES8uVWBgFWCBUtkBELj2BSw.HW7b0FVQSGa', NULL, NULL, NULL, 0, 4, 1, NULL, '2017-11-12 08:58:05', NULL, '2017-11-12 08:58:05', NULL, NULL),
(4, 'TEST BEST', 'prasadwargad@gmail.co.in', '$2y$10$dRUMxv0C6cJ1cn8nCq3R7ex5jtbR5N/uazrYTzInxr9oOf4qEvuEu', NULL, NULL, NULL, 1, 1, 1, NULL, '2017-11-12 12:19:12', NULL, '2017-11-12 12:19:12', NULL, NULL),
(5, 'BEST REST', 'prasadwargad@gmail.com', '$2y$10$mC4BqdHNVw.C7a7CQxjpFOFILnCtKzIiwZI8.Pjp2NWgB6quHR/VW', NULL, NULL, NULL, 0, 1, 1, NULL, '2017-11-12 12:24:18', NULL, '2017-11-12 12:24:18', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
