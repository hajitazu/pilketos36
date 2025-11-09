-- Database schema untuk Sistem Pemilihan Ketua OSIS

CREATE TABLE IF NOT EXISTS `admins` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `k` varchar(100) NOT NULL UNIQUE,
  `v` text,
  INDEX(k)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(191) NOT NULL,
  `description` text,
  `photo` varchar(255),
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `token` varchar(50) NOT NULL UNIQUE,
  `class` varchar(10),
  `number` varchar(10),
  `used` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `used_at` datetime
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int AUTO_INCREMENT PRIMARY KEY,
  `candidate_id` int NOT NULL,
  `token` varchar(50) NOT NULL,
  `voted_at` datetime DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`candidate_id`) REFERENCES `candidates`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default settings
INSERT INTO settings (k, v) VALUES
('site_name', 'Pemilihan Ketua OSIS'),
('header_color', '#0d6efd'),
('is_open', '1');
