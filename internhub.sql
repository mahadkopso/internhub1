-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: internhub
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `internhub`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `internhub` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `internhub`;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employers`
--

DROP TABLE IF EXISTS `employers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `industry` varchar(255) DEFAULT NULL,
  `company_description` text DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `company_address` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employers_user_id_foreign` (`user_id`),
  CONSTRAINT `employers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employers`
--

LOCK TABLES `employers` WRITE;
/*!40000 ALTER TABLE `employers` DISABLE KEYS */;
INSERT INTO `employers` VALUES (1,3,'BrightPath Technologies','Information Technology','A software company building tools for education and workforce development.','https://brightpath.example.com','123 Innovation Way, Tech City',NULL,NULL,1,'2026-07-11 05:30:06','2026-07-11 05:30:06');
/*!40000 ALTER TABLE `employers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internship_applications`
--

DROP TABLE IF EXISTS `internship_applications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `internship_applications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `internship_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `cover_letter` text DEFAULT NULL,
  `resume_path` varchar(255) DEFAULT NULL,
  `employer_status` enum('pending','shortlisted','accepted','rejected') NOT NULL DEFAULT 'pending',
  `employer_feedback` text DEFAULT NULL,
  `coordinator_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `coordinator_remarks` text DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','under_review','approved','rejected','withdrawn','completed') NOT NULL DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `internship_applications_internship_id_student_id_unique` (`internship_id`,`student_id`),
  KEY `internship_applications_student_id_foreign` (`student_id`),
  KEY `internship_applications_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `internship_applications_internship_id_foreign` FOREIGN KEY (`internship_id`) REFERENCES `internships` (`id`) ON DELETE CASCADE,
  CONSTRAINT `internship_applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `internship_applications_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internship_applications`
--

LOCK TABLES `internship_applications` WRITE;
/*!40000 ALTER TABLE `internship_applications` DISABLE KEYS */;
INSERT INTO `internship_applications` VALUES (2,6,1,'magacaygu waa mahad ibraahim mohamed waxaan rajaynyaah inaad shaqadaan igu siisaan dadaalkayga insha allah waxan rajaynayaah inaan sida ugu fiican aan uga soo bixi doono shaqadaan','resumes/9ala4EmlXoEhhWHn63ZQSpnGRGB8hAd9PHPD3wGW.pdf','rejected',NULL,'approved',NULL,2,'2026-09-23 11:51:53','rejected','2026-09-23 11:50:41','2026-09-23 11:50:41','2026-09-23 11:56:17'),(3,7,1,'waxaan ahay nin shaqadaan ka shaqaynayey inkabadan 10sano','resumes/zreJ0M1KrYIKtjoYGMzh3xAovjpimFeBwStRvxE8.docx','rejected',NULL,'approved',NULL,2,'2026-09-23 15:20:06','rejected','2026-09-23 15:19:33','2026-09-23 15:19:33','2026-09-23 15:21:43');
/*!40000 ALTER TABLE `internship_applications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internships`
--

DROP TABLE IF EXISTS `internships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `internships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employer_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `work_mode` enum('onsite','remote','hybrid') NOT NULL DEFAULT 'onsite',
  `duration` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `slots_available` int(10) unsigned NOT NULL DEFAULT 1,
  `is_paid` tinyint(1) NOT NULL DEFAULT 0,
  `stipend` decimal(10,2) DEFAULT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `approval_status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `coordinator_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `internships_employer_id_foreign` (`employer_id`),
  KEY `internships_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `internships_employer_id_foreign` FOREIGN KEY (`employer_id`) REFERENCES `employers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `internships_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internships`
--

LOCK TABLES `internships` WRITE;
/*!40000 ALTER TABLE `internships` DISABLE KEYS */;
INSERT INTO `internships` VALUES (1,1,'Software Engineering Intern','Work with our engineering team to build and maintain internal web applications using Laravel and Bootstrap.','Currently enrolled in a Computer Science or related program. Basic knowledge of PHP and databases.','Tech City','hybrid','3 months','2026-08-20','2026-09-30',2,1,300.00,'open','approved',2,NULL,'2026-07-11 05:30:07','2026-09-15 05:32:38'),(6,1,'HR of EAU','shaqadan kaliya waxaa looga baahanyahay qof takhasus uleh waxa uu ku shaqaynayo','high school certificate \r\n in unigersity or finished','Galkiyo','onsite','3 months','2026-09-23','2026-09-30',1,1,150.00,'open','approved',2,NULL,'2026-09-23 11:45:10','2026-09-23 11:46:53'),(7,1,'indhovic','waa shaqo qashin guris','inuu buumo cagaare wato','garoowe','hybrid','2','2026-09-23','2026-09-30',1,1,100.00,'open','approved',2,NULL,'2026-09-23 15:17:12','2026-09-23 15:17:56');
/*!40000 ALTER TABLE `internships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000001_create_students_table',1),(4,'0001_01_01_000002_create_employers_table',1),(5,'0001_01_01_000002_create_jobs_table',1),(6,'0001_01_01_000003_create_internships_table',1),(7,'0001_01_01_000004_create_internship_applications_table',1),(8,'0001_01_01_000005_create_reports_table',1),(9,'0001_01_01_000006_create_notifications_table',1),(10,'0001_01_01_000007_create_settings_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'general',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,'New Internship Posting Pending Review','\"mycash\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',1,'2026-07-11 05:52:40','2026-07-11 06:41:20'),(2,2,'New Internship Posting Pending Review','\"mycash\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-07-11 06:09:57','2026-07-11 06:09:57'),(3,2,'New Internship Posting Pending Review','\"mycash\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-07-11 06:26:00','2026-07-11 06:26:00'),(5,2,'New Internship Posting Pending Review','\"golis\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-07-11 06:45:19','2026-07-11 06:45:19'),(8,4,'Application Decision','Your placement for \"golis\" was approved by the coordinator.','application',NULL,1,'2026-07-14 05:26:54','2026-07-14 06:14:42'),(9,4,'Application Update','Your application for \"golis\" was marked as accepted by the employer.','application',NULL,1,'2026-07-14 05:36:35','2026-07-14 06:14:34'),(10,2,'Application Awaiting Coordinator Approval','Sara Ahmed was accepted by an employer for \"golis\" and needs final approval.','application','http://127.0.0.1:8000/coordinator/applications/pending',0,'2026-07-14 05:36:35','2026-07-14 05:36:35'),(11,2,'New Report Submitted','Sara Ahmed submitted a monthly report for review.','report',NULL,0,'2026-07-14 05:58:04','2026-07-14 05:58:04'),(12,4,'Report Reviewed','Your \"month one progress report\" report was marked as approved.','report',NULL,1,'2026-07-14 06:02:49','2026-07-14 06:14:31'),(13,2,'New Internship Posting Pending Review','\"HR of EAU\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-09-23 11:45:10','2026-09-23 11:45:10'),(14,3,'Internship Posting Reviewed','Your posting \"HR of EAU\" was approved by the university coordinator.','internship',NULL,1,'2026-09-23 11:46:53','2026-09-23 11:47:22'),(15,3,'New Applicant','mahad ibrahim applied for \"HR of EAU\".','application',NULL,1,'2026-09-23 11:50:41','2026-09-23 11:54:02'),(16,4,'Application Decision','Your placement for \"HR of EAU\" was approved by the coordinator.','application',NULL,1,'2026-09-23 11:51:53','2026-09-23 11:52:25'),(17,4,'Application Update','Your application for \"HR of EAU\" was marked as rejected by the employer.','application',NULL,1,'2026-09-23 11:56:17','2026-09-23 12:03:23'),(18,2,'New Internship Posting Pending Review','\"indhovic\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-09-23 15:17:12','2026-09-23 15:17:12'),(19,3,'Internship Posting Reviewed','Your posting \"indhovic\" was approved by the university coordinator.','internship',NULL,1,'2026-09-23 15:17:56','2026-09-23 15:18:22'),(20,3,'New Applicant','mahad ibrahim applied for \"indhovic\".','application',NULL,0,'2026-09-23 15:19:33','2026-09-23 15:19:33'),(21,4,'Application Decision','Your placement for \"indhovic\" was approved by the coordinator.','application',NULL,0,'2026-09-23 15:20:06','2026-09-23 15:20:06'),(22,4,'Application Update','Your application for \"indhovic\" was marked as rejected by the employer.','application',NULL,0,'2026-09-23 15:21:43','2026-09-23 15:21:43'),(23,2,'New Internship Posting Pending Review','\"deeshwosher\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-10-03 04:51:47','2026-10-03 04:51:47'),(25,2,'New Internship Posting Pending Review','\"Taller\" was submitted and needs your approval.','internship','http://127.0.0.1:8000/coordinator/internships/pending',0,'2026-10-03 05:21:34','2026-10-03 05:21:34'),(30,2,'Application Awaiting Coordinator Approval','hassan was accepted by an employer for \"Taller\" and needs final approval.','application','http://127.0.0.1:8000/coordinator/applications/pending',0,'2026-10-03 05:28:18','2026-10-03 05:28:18'),(31,2,'New Report Submitted','hassan submitted a weekly report for review.','report',NULL,0,'2026-10-03 05:36:05','2026-10-03 05:36:05');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `application_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `report_type` enum('weekly','monthly','midterm','final') NOT NULL DEFAULT 'weekly',
  `week_number` int(10) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `submission_date` date NOT NULL DEFAULT curdate(),
  `status` enum('pending','approved','rejected','needs_revision') NOT NULL DEFAULT 'pending',
  `coordinator_feedback` text DEFAULT NULL,
  `reviewed_by` bigint(20) unsigned DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_application_id_foreign` (`application_id`),
  KEY `reports_student_id_foreign` (`student_id`),
  KEY `reports_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `reports_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `internship_applications` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reports_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reports`
--

LOCK TABLES `reports` WRITE;
/*!40000 ALTER TABLE `reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('21iTi8WeRUpbnkx4pr5xao8T8M1tBMhJzwu7p4E8',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjRBeVl0VHFiZkpidVlDS2xXclkxQlJWU3F6eUpVUUJBaWpBcGN1TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1791107959),('aImRldWPvA50xK0UihAwVBJGG8bR7Ivcmzg9kgPu',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjVhNFJWWk1oV1V6anRiZFZtOHFsZDJVRVdXWjJsU1I4dDRDa3NQUyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1791108005),('f3W8Gf4XHbA0eWftTFEyb9KkGDKuvP7oRngrOyXb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.140.0 Chrome/150.0.7871.250 Electron/43.7.3 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiOERocFA5VmdFQWhSTU5uSzM1OUs4bVhBNGx1OXlBSnNXSDJjN1RBTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1791108871),('f65kIdR5w9oCp4UfI7ecCRLz2WSYAItChNyhGJjT',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Avast/133.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTFJDZ3lJczI5ZGs5OVZ5NFdlSUJOZlIydzdXUGNTMVRlN0FabkhmZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=',1791060546),('gOfMZgd3quveCelDUS2dJbHxC7CqGAXSjU1gPy2R',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmVHcnoyTFRJSDR1dExvaVpxNE1RYzNQTVp5bXVNZmYyQUIzV3F5RCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1791107971),('jMRyPs2ImIRmGUFRPr7oYbvbffIBwAL8fnQK0cBT',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTozOntzOjY6Il90b2tlbiI7czo0MDoia3Z1aU5GMFNXeXAxaTl3QlZqRUV6VXdkMEhocFRJV0VEeTNjSjdmNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1791108674),('MYOIYsTEStB4yY0ypvb0nIonFiLDGiGzshyUGAYh',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Avast/133.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMjNSV2RzN0FlNWNDWmppbGd5eG1ZTVpiTVQ3TlZRaEQ3ZlJ0UjVWeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==',1791108876),('nLc9rD5IrVbOALRR7Tee03OLkGyIRz9soauvUxvg',4,'127.0.0.1','curl/8.9.1','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTG9vNHV2WFY4d044OTZCbjNJM0V4N3ZqcnFvUjFXWlVtejZQOEZHMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=',1791108050),('OC9cnUAZZcXEIER0TjnNKzOzxJTeYvwJRnPJHizG',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 Avast/133.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibHJReUI5SXJScnJlV3daV2tLM1lJdWJMRDEwWG5XdkhlbVlrZHBhWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9',1791041523),('ohe8GAkADzWoy7oTNyKOyq8BTn5lpvXrPTPHsXn3',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUUJnamR0Vm53ZldDaFpnT0tEOVJaQjVPczVYSnNqUnZmcERhN3dsMiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1791108016),('sXnFydModhCKkADOASZt2l5vPQFeF4IqkDzGvCJL',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.138.0 Chrome/148.0.7778.280 Electron/42.10.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlJMMjIyNzRPejBFQVdiUkU2SDhFQkx0ck10RzBRMEZhajVJOXhIVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1791059070),('vh89xf5awP2NdACC7oaFjqApqsLY9QGbk00s5z6q',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWHhrNkhuUmE4Z2pLdTZrSzdFVkhxZnNpUUVFQU16SHVGM3NFYkxSVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1791107972),('xLghpfbDDbormoihdugOdapp84k64Zg3lwoYF7HD',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.138.0 Chrome/148.0.7778.280 Electron/42.10.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiWnNTaXlGMXpGODZLZG9UNGlWaDJoajJOSFF2eXBaYUV5S3hwWkxKUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1791040429),('yMoOvmWyqVHzcuwAKESVHxcj9WQmaSRdfn2kGqK3',4,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.22621.4249','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiME9GRnl2MXlrWmtFc0NZemU5YWZjb3lWY3RqODc5WTdDejE2ZkxmbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==',1791107990);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'app_name','InternHub','2026-07-11 05:30:04','2026-07-11 05:30:04'),(2,'university_name','EAU Garoowe','2026-07-11 05:30:04','2026-08-09 00:04:52'),(3,'application_deadline_reminder_days','3','2026-07-11 05:30:04','2026-07-11 05:30:04'),(4,'require_coordinator_internship_approval','0','2026-07-11 05:30:04','2026-07-11 06:21:50'),(5,'require_coordinator_application_approval','0','2026-07-11 05:30:04','2026-07-11 06:21:50'),(6,'max_report_file_size_mb','25','2026-07-11 05:30:04','2026-08-09 00:04:52');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `student_id_number` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL DEFAULT 'University',
  `faculty` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `year_of_study` tinyint(3) unsigned DEFAULT NULL,
  `gpa` decimal(3,2) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `skills` varchar(255) DEFAULT NULL,
  `cv_path` varchar(255) DEFAULT NULL,
  `profile_photo_path` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `assigned_coordinator_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_student_id_number_unique` (`student_id_number`),
  KEY `students_user_id_foreign` (`user_id`),
  KEY `students_assigned_coordinator_id_foreign` (`assigned_coordinator_id`),
  CONSTRAINT `students_assigned_coordinator_id_foreign` FOREIGN KEY (`assigned_coordinator_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,4,'STU-000001','EAU university','IT','Computer Science','General it',4,3.60,'Aspiring software engineer passionate about web development.','PHP, Laravel, JavaScript, MySQL','cvs/jVXqpdgk5krPpnXcpxg6V0dCwEhspBvsRqxmXKkJ.pdf','profile-photos/F4F1Gvvl9ZqBuhhrmYCeYxtUOUjyAQOu9YKdIDDS.jpg',NULL,2,'2026-07-11 05:30:07','2026-07-14 06:22:19');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','employer','coordinator','admin') NOT NULL DEFAULT 'student',
  `phone` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'mahad ibrahim','admin@internhub.test',NULL,'$2y$12$cmH/kZs/OaxXjXvVwOHRZOXL0B7Qg0vV2U87usxqnKgSLMnX1zYcK','admin',NULL,1,'Cn1MDVtRakauJe2x4T6XZXLVrV4zIKhhUdUFWz5pxlqKOCrSEswpnEEwmtDD','2026-07-11 05:30:05','2026-07-11 05:30:05'),(2,'saed habeeb','coordinator@internhub.test',NULL,'$2y$12$otYUNk6oTWTsHS/e6TaXke6Yf9VBlajbEgWjC.ogdno4UhJJIMLeW','coordinator',NULL,1,NULL,'2026-07-11 05:30:05','2026-07-11 05:30:05'),(3,'fardawso jamac','employer@internhub.test',NULL,'$2y$12$6/Yc2BK5tbNGFwyv0eOLRu.5A/Qxs0Upqw8zpdwixTVKwR4017d3a','employer',NULL,1,NULL,'2026-07-11 05:30:06','2026-07-11 05:30:06'),(4,'mahad ibrahim','student@internhub.test',NULL,'$2y$12$NSnHSx3/9b4RMv3hLIze3OjWGtKoSR1WW1/aErdBpbVsFKeiH5x6W','student',NULL,1,'QzVyIj2P0AgOvhCFmGBE7mmZiG0KJDIaVKYtK6YR5py34SDURvv029Oll41C','2026-07-11 05:30:07','2026-09-15 05:27:33');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-04 13:37:09
