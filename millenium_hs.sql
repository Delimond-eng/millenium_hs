-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 29 avr. 2024 à 17:07
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `millenium_hs`
--

-- --------------------------------------------------------

--
-- Structure de la table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_matricule` varchar(255) NOT NULL,
  `agent_nom` varchar(255) NOT NULL,
  `agent_prenom` varchar(255) NOT NULL,
  `agent_sexe` char(255) NOT NULL,
  `agent_telephone` varchar(255) NOT NULL,
  `agent_adresse` text DEFAULT NULL,
  `agent_datenais` varchar(255) DEFAULT NULL,
  `agent_specialite` varchar(255) DEFAULT NULL,
  `agent_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `agent_status` varchar(255) NOT NULL DEFAULT 'actif',
  `grade_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fonction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consult_libelle` varchar(255) NOT NULL,
  `consult_diagnostic` text NOT NULL,
  `consult_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `consult_status` varchar(255) NOT NULL DEFAULT 'actif',
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `consultation_details`
--

CREATE TABLE `consultation_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consult_detail_libelle` varchar(255) NOT NULL,
  `consult_detail_valeur` varchar(255) NOT NULL,
  `consult_detail_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `consult_detail_status` varchar(10) NOT NULL DEFAULT 'actif',
  `consult_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `consultation_examens`
--

CREATE TABLE `consultation_examens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examen_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `consult_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `consult_examen_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `consult_examen_status` varchar(255) NOT NULL DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `consultation_symptomes`
--

CREATE TABLE `consultation_symptomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consult_symptome_libelle` varchar(255) NOT NULL,
  `consult_id` bigint(20) UNSIGNED NOT NULL,
  `consult_symptome_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `examen_echantillons`
--

CREATE TABLE `examen_echantillons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examen_echantillon_code` varchar(255) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `examen_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `labo_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `examen_echantillon_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `examen_labos`
--

CREATE TABLE `examen_labos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examen_labo_libelle` varchar(255) NOT NULL,
  `examen_labo_description` varchar(255) DEFAULT '...',
  `examen_labo_prix` varchar(255) NOT NULL,
  `examen_resultat_type` varchar(255) NOT NULL DEFAULT 'text',
  `examen_labo_prix_devise` varchar(255) NOT NULL DEFAULT 'CDF',
  `labo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hopital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `examen_labo_create_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `examen_labo_categories`
--

CREATE TABLE `examen_labo_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categorie_libelle` varchar(255) NOT NULL,
  `categorie_description` varchar(255) DEFAULT NULL,
  `labo_id` bigint(20) UNSIGNED DEFAULT NULL,
  `categorie_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `examen_labo_types`
--

CREATE TABLE `examen_labo_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_libelle` varchar(255) NOT NULL,
  `type_libelle_medical` varchar(255) DEFAULT NULL,
  `type_description` varchar(255) DEFAULT NULL,
  `examen_categorie_id` bigint(20) UNSIGNED NOT NULL,
  `type_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `examen_resultats`
--

CREATE TABLE `examen_resultats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `examen_resultat_libelle` varchar(255) NOT NULL,
  `examen_resultat_description` text DEFAULT NULL,
  `examen_resultat_media` varchar(255) DEFAULT NULL,
  `examen_id` bigint(20) UNSIGNED NOT NULL,
  `echantillon_id` bigint(20) UNSIGNED NOT NULL,
  `labo_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `suivi_id` bigint(20) UNSIGNED DEFAULT 0,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `examen_resultat_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facturation_configs`
--

CREATE TABLE `facturation_configs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facturation_config_libelle` varchar(255) NOT NULL,
  `facturation_config_montant` decimal(8,2) NOT NULL,
  `facturation_config_montant_devise` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `facturation_config_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `facture_paiements`
--

CREATE TABLE `facture_paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paiement_montant` decimal(8,2) NOT NULL,
  `paiement_montant_devise` varchar(255) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `facturation_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `paiement_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonctions`
--

CREATE TABLE `fonctions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fonction_libelle` varchar(255) NOT NULL,
  `fonction_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `fonction_status` varchar(255) NOT NULL DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_nom` varchar(255) NOT NULL,
  `fournisseur_adresse` varchar(255) NOT NULL,
  `fournisseur_email` varchar(255) DEFAULT NULL,
  `fournisseur_telephone` varchar(255) DEFAULT NULL,
  `fournisseur_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `fournisseur_nom`, `fournisseur_adresse`, `fournisseur_email`, `fournisseur_telephone`, `fournisseur_created_At`, `hopital_id`, `created_by`) VALUES
(1, 'KIM Pharma', '039, Kinshasa Gombe', 'kimpharma@gmail.com', '0827378833', '2024-04-16 23:30:14', 1, 1),
(2, 'ElitePharma', '039, Kinshasa Gombe', 'elpharma@gmail.com', '0894949900', '2024-04-16 23:31:14', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_libelle` varchar(255) NOT NULL,
  `grade_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `grade_status` varchar(255) NOT NULL DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hopitals`
--

CREATE TABLE `hopitals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hopital_nom` varchar(255) NOT NULL,
  `hopital_adresse` varchar(255) NOT NULL,
  `hopital_logo` varchar(255) DEFAULT NULL,
  `hopital_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hopitals`
--

INSERT INTO `hopitals` (`id`, `hopital_nom`, `hopital_adresse`, `hopital_logo`, `hopital_create_At`) VALUES
(1, 'HS Hospital', '0238,Roi baudouin, C. Gombe kinshasa', 'http://127.0.0.1:8000/uploads/1713309876.png', '2024-04-16 23:24:36');

-- --------------------------------------------------------

--
-- Structure de la table `hopital_emplacements`
--

CREATE TABLE `hopital_emplacements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_libelle` varchar(255) NOT NULL,
  `hopital_emplacement_adresse` varchar(255) NOT NULL,
  `hopital_emplacement_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hopital_emplacements`
--

INSERT INTO `hopital_emplacements` (`id`, `hopital_emplacement_libelle`, `hopital_emplacement_adresse`, `hopital_emplacement_create_At`, `hopital_id`, `created_by`) VALUES
(1, 'Siège social', '0238,Roi baudouin, C. Gombe kinshasa', '2024-04-16 23:24:36', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisations`
--

CREATE TABLE `hospitalisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hospitalisation_start_At` timestamp NULL DEFAULT NULL,
  `hospitalisation_end_At` timestamp NULL DEFAULT NULL,
  `hospitalisation_raison_admission` text NOT NULL,
  `lit_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `service_responsable_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hospitalisation_status` varchar(255) NOT NULL DEFAULT 'actif',
  `hospitalisation_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation_lits`
--

CREATE TABLE `hospitalisation_lits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lit_numero` varchar(255) NOT NULL,
  `lit_status` varchar(255) NOT NULL DEFAULT 'disponible',
  `lit_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hospitalisation_transferts`
--

CREATE TABLE `hospitalisation_transferts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfert_date_heure` timestamp NULL DEFAULT NULL,
  `transfert_raison` text DEFAULT NULL,
  `transfert_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hospitalisation_id` bigint(20) UNSIGNED NOT NULL,
  `lit_origine_id` bigint(20) UNSIGNED NOT NULL,
  `lit_destination_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `journee_transactions`
--

CREATE TABLE `journee_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `journee_opening_montant` decimal(8,2) NOT NULL,
  `journee_closing_montant` decimal(8,2) DEFAULT NULL,
  `journee_opening_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `journee_closed_At` timestamp NULL DEFAULT NULL,
  `journee_sell_count` int(11) NOT NULL DEFAULT 0,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `laboratoires`
--

CREATE TABLE `laboratoires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labo_nom` varchar(255) NOT NULL,
  `labo_telephone` varchar(255) DEFAULT NULL,
  `labo_adresse` varchar(255) DEFAULT NULL,
  `labo_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `labo_equipements`
--

CREATE TABLE `labo_equipements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `labo_equipement_nom` varchar(255) NOT NULL,
  `labo_equipement_description` text DEFAULT NULL,
  `labo_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `labo_equipement_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `lit_types`
--

CREATE TABLE `lit_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_libelle` varchar(255) NOT NULL,
  `type_description` text DEFAULT NULL,
  `type_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `medical_schedules`
--

CREATE TABLE `medical_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_date_heure` timestamp NULL DEFAULT NULL,
  `schedule_duree` varchar(255) DEFAULT NULL,
  `schedule_note` text DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `schedule_status` varchar(255) NOT NULL DEFAULT 'actif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_15_145015_create_agents_table', 1),
(6, '2023_11_15_145015_create_consultation_details_table', 1),
(7, '2023_11_15_145015_create_consultations_table', 1),
(8, '2023_11_15_145015_create_fonctions_table', 1),
(9, '2023_11_15_145015_create_grades_table', 1),
(10, '2023_11_15_145015_create_patients_table', 1),
(11, '2023_11_15_145015_create_prescriptions_table', 1),
(12, '2023_11_15_145015_create_services_table', 1),
(13, '2023_11_22_201938_create_patient_signes_vitaux_table', 1),
(14, '2023_11_23_212342_create_user_roles_table', 1),
(15, '2023_11_30_093357_create_hopitals_table', 1),
(16, '2023_11_30_093504_create_hopital_emplacements_table', 1),
(17, '2023_12_05_064940_create_consultation_symptomes_table', 1),
(18, '2023_12_05_071442_create_pharmacies_table', 1),
(19, '2023_12_07_184532_create_examen_labos_table', 1),
(20, '2023_12_08_111240_create_consultation_examens_table', 1),
(21, '2023_12_18_121104_create_stocks_table', 1),
(22, '2023_12_18_121850_create_mouvement_stocks_table', 1),
(23, '2023_12_18_122644_create_fournisseurs_table', 1),
(24, '2023_12_18_133447_create_laboratoires_table', 1),
(25, '2023_12_18_133822_create_labo_equipements_table', 1),
(26, '2023_12_18_134143_create_examen_echantillons_table', 1),
(27, '2023_12_27_071621_create_produits_table', 1),
(28, '2023_12_27_100429_create_examen_resultats_table', 1),
(29, '2023_12_27_121505_create_produit_categories_table', 1),
(30, '2024_01_08_082932_create_produit_types_table', 1),
(31, '2024_01_08_091811_create_journee_transactions_table', 1),
(32, '2024_01_10_074159_create_hospitalisations_table', 1),
(33, '2024_01_10_080902_create_hospitalisation_lits_table', 1),
(34, '2024_01_10_085611_create_hospitalisation_transferts_table', 1),
(35, '2024_01_10_090100_create_lit_types_table', 1),
(36, '2024_01_12_073312_create_medical_schedules_table', 1),
(37, '2024_01_15_070515_create_parteners_table', 1),
(38, '2024_01_16_000435_create_premier_soins_table', 1),
(39, '2024_01_16_001307_create_premier_soin_traitements_table', 1),
(40, '2024_01_16_121216_create_facturation_configs_table', 1),
(41, '2024_01_23_143111_create_transfert_patients_table', 1),
(42, '2024_01_24_073525_create_facture_paiements_table', 1),
(43, '2024_02_06_075638_create_paiements_table', 1),
(44, '2024_02_06_081120_create_partener_agents_table', 1),
(45, '2024_02_19_124623_create_examen_labo_types_table', 1),
(46, '2024_02_19_125139_create_examen_labo_categories_table', 1),
(47, '2024_03_19_102103_produit_unites_table', 1),
(48, '2024_03_24_112358_create_produit_prices_table', 1),
(49, '2024_03_27_091047_create_pharmacie_operations_table', 1),
(50, '2024_04_22_091704_create_pharmacie_clients_table', 2);

-- --------------------------------------------------------

--
-- Structure de la table `mouvement_stocks`
--

CREATE TABLE `mouvement_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mouvement_stock_type` varchar(255) NOT NULL,
  `mouvement_stock_qte` int(11) NOT NULL,
  `mouvement_stock_bon_code` varchar(255) DEFAULT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_facture_code` bigint(20) UNSIGNED DEFAULT NULL,
  `pharmacie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mouvement_stock_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paiement_libelle` varchar(255) NOT NULL,
  `paiement_montant` decimal(8,2) NOT NULL,
  `paiement_montant_devise` varchar(255) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `paiement_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `parteners`
--

CREATE TABLE `parteners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `partener_nom` varchar(255) NOT NULL,
  `partener_adresse` varchar(255) NOT NULL,
  `partener_contact` varchar(255) NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `partener_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `partener_agents`
--

CREATE TABLE `partener_agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_matricule` varchar(255) NOT NULL,
  `agent_num_convention` varchar(255) NOT NULL,
  `agent_nom` varchar(255) NOT NULL,
  `agent_prenom` varchar(255) NOT NULL,
  `agent_sexe` varchar(255) NOT NULL,
  `agent_etat_civil` varchar(255) NOT NULL,
  `agent_nbre_efts` int(11) NOT NULL,
  `partener_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `agent_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_code` varchar(255) NOT NULL,
  `patient_code_appel` varchar(255) DEFAULT NULL,
  `patient_nom` varchar(255) NOT NULL,
  `patient_prenom` varchar(255) NOT NULL,
  `patient_sexe` char(1) NOT NULL,
  `patient_datenais` varchar(255) NOT NULL,
  `patient_etat_civil` varchar(255) DEFAULT NULL,
  `patient_adresse` text NOT NULL,
  `patient_telephone` varchar(255) NOT NULL,
  `patient_contact_urgence` varchar(255) NOT NULL,
  `patient_num_assurance` varchar(255) DEFAULT NULL,
  `patient_gs` varchar(255) DEFAULT NULL,
  `patient_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `patient_status` varchar(10) NOT NULL DEFAULT 'actif',
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `patient_signes_vitaux`
--

CREATE TABLE `patient_signes_vitaux` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_sv_poids` varchar(5) DEFAULT NULL,
  `patient_sv_poids_unite` varchar(5) NOT NULL DEFAULT 'kg',
  `patient_sv_taille` varchar(5) DEFAULT NULL,
  `patient_sv_taille_unite` varchar(5) NOT NULL DEFAULT 'cm',
  `patient_sv_temperature` varchar(5) DEFAULT NULL,
  `patient_sv_temperature_unite` varchar(5) NOT NULL DEFAULT '°c',
  `patient_sv_tension_art` varchar(5) DEFAULT NULL,
  `patient_sv_tension_art_unite` varchar(5) NOT NULL DEFAULT 'mmHg',
  `patient_sv_freq_cardio` varchar(5) DEFAULT NULL,
  `patient_sv_freq_cardio_unite` varchar(5) NOT NULL DEFAULT 'bpm',
  `patient_sv_saturation` varchar(5) DEFAULT NULL,
  `patient_sv_saturation_unite` varchar(5) NOT NULL DEFAULT '%',
  `patient_sv_age` varchar(5) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `patient_sv_status` varchar(255) NOT NULL DEFAULT 'en attente',
  `patient_sv_created_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'user-token', '168782907d4adabf49b2656902d00b51695015abff7c3f5fd7c87dfc07a474b7', '[\"*\"]', NULL, NULL, '2024-04-16 21:28:22', '2024-04-16 21:28:22'),
(2, 'App\\Models\\User', 1, 'user-token', 'b83767ac97554f107935f5b8edf33a89d09aee1c181833924ad650cfc2b654e6', '[\"*\"]', NULL, NULL, '2024-04-17 08:11:01', '2024-04-17 08:11:01'),
(3, 'App\\Models\\User', 1, 'user-token', 'e61a3151a269c3d80c7dd0a43ea1eb6eeac61ee2de682c2fe66dd4fa924d1407', '[\"*\"]', NULL, NULL, '2024-04-17 08:24:11', '2024-04-17 08:24:11'),
(4, 'App\\Models\\User', 1, 'user-token', '8cd919cfbc9937a723abaff09c67190042e2935aebcd5403dcf96f01d4d6967f', '[\"*\"]', NULL, NULL, '2024-04-17 13:00:31', '2024-04-17 13:00:31'),
(5, 'App\\Models\\User', 1, 'user-token', '7c42db09d49d92020530e9fbaa5189fe9446dc8c88297b3ea517800f6de1d650', '[\"*\"]', NULL, NULL, '2024-04-18 14:55:38', '2024-04-18 14:55:38'),
(6, 'App\\Models\\User', 1, 'user-token', 'e5aaa5e410e4cb6dedc6fb4a8c43b7a1dab5ff2049f6acb4e5d4a64641903c60', '[\"*\"]', NULL, NULL, '2024-04-18 14:59:34', '2024-04-18 14:59:34'),
(7, 'App\\Models\\User', 1, 'user-token', '0a206b117ae83070b0415a93fd9a087fd32202437ada2333594b393818b02f60', '[\"*\"]', NULL, NULL, '2024-04-18 15:11:01', '2024-04-18 15:11:01'),
(8, 'App\\Models\\User', 1, 'user-token', 'dc464f0580922e19e65be5743c1a6ab8ada3aa3164643a1ad0102d74251bc5b7', '[\"*\"]', NULL, NULL, '2024-04-18 15:19:40', '2024-04-18 15:19:40'),
(9, 'App\\Models\\User', 1, 'user-token', 'db2a4483d2fb444bf6abb38f18e2e7439a69e1a8035af9a78a45fac924d52be8', '[\"*\"]', NULL, NULL, '2024-04-18 15:26:18', '2024-04-18 15:26:18'),
(10, 'App\\Models\\User', 3, 'user-token', '7769d2438a3b10cb5a0e1eb613302d1aa476dde57275dbdac6dc5882960500a0', '[\"*\"]', NULL, NULL, '2024-04-18 19:40:36', '2024-04-18 19:40:36'),
(11, 'App\\Models\\User', 1, 'user-token', 'c0ef9cc670ce77efebca88b94f1fdf9c36e106ac9f33faa76220fecfceff149b', '[\"*\"]', NULL, NULL, '2024-04-18 19:49:29', '2024-04-18 19:49:29'),
(12, 'App\\Models\\User', 4, 'user-token', '8cd19324f153dcd56000d9b6b4aad47a133177c63f7c108bb4dacc4fc2a7a90e', '[\"*\"]', NULL, NULL, '2024-04-18 19:51:20', '2024-04-18 19:51:20'),
(13, 'App\\Models\\User', 1, 'user-token', '6df0402b6154e0a4f4d08a3ea6ca1120207422189b20761bd3b3038140e15665', '[\"*\"]', NULL, NULL, '2024-04-18 19:54:40', '2024-04-18 19:54:40'),
(14, 'App\\Models\\User', 5, 'user-token', '06a1e3e9badbf4e06f43ea9c4aa4aed3f89362b4c383d1528505e5547d446065', '[\"*\"]', NULL, NULL, '2024-04-18 19:55:43', '2024-04-18 19:55:43'),
(15, 'App\\Models\\User', 1, 'user-token', 'f0996ab12aea51be59cdb51ae661fa1c23112e5f1133d320409efa2a10140e03', '[\"*\"]', NULL, NULL, '2024-04-18 20:19:52', '2024-04-18 20:19:52'),
(16, 'App\\Models\\User', 6, 'user-token', 'bbd6cd9adf296e56a1b4628ebcdfe91f88cc13785e2af89c19bbdf1ced5204e8', '[\"*\"]', NULL, NULL, '2024-04-18 20:21:29', '2024-04-18 20:21:29'),
(17, 'App\\Models\\User', 6, 'user-token', 'ef64d0e9e7a0f44ce13ec3e85be8214f94da2e052dd3e3ba5a01c362c706a7c3', '[\"*\"]', NULL, NULL, '2024-04-18 20:48:42', '2024-04-18 20:48:42'),
(18, 'App\\Models\\User', 5, 'user-token', '2544016aaeddc04398103cbd81d16cbd3e58bc6f115d3df8d46ef83ef400c061', '[\"*\"]', NULL, NULL, '2024-04-18 20:50:12', '2024-04-18 20:50:12'),
(19, 'App\\Models\\User', 5, 'user-token', '23889ea041025f0377cec4742f0a2960fad1fbd677b71b5901dd2d104321c01a', '[\"*\"]', NULL, NULL, '2024-04-18 20:56:07', '2024-04-18 20:56:07'),
(20, 'App\\Models\\User', 6, 'user-token', '403433d83f738fc2a1f72ece88d9902a908fdedae6e2ac70285ff637e1a2cb46', '[\"*\"]', NULL, NULL, '2024-04-18 20:57:07', '2024-04-18 20:57:07'),
(21, 'App\\Models\\User', 5, 'user-token', '2242358ee67734b68979d676c89c271aaedd9a26f3b59666d84558f158468c0c', '[\"*\"]', NULL, NULL, '2024-04-18 21:52:46', '2024-04-18 21:52:46'),
(22, 'App\\Models\\User', 6, 'user-token', '36ce760dc79e256645c33a5d34c52fbd25179882e8cc814cfa1dbb9b965dc947', '[\"*\"]', NULL, NULL, '2024-04-18 22:26:00', '2024-04-18 22:26:00'),
(23, 'App\\Models\\User', 5, 'user-token', '63086cfd895e70f63ba30970bd8d786a1a9b001def708d6779e0f8f4c5c6037e', '[\"*\"]', NULL, NULL, '2024-04-19 07:46:41', '2024-04-19 07:46:41'),
(24, 'App\\Models\\User', 1, 'user-token', '433678c0e36c988c33b05a6ad421b2dba7142840f9876bb4c44504b2195ecf3b', '[\"*\"]', '2024-04-22 08:19:06', NULL, '2024-04-22 08:18:34', '2024-04-22 08:19:06');

-- --------------------------------------------------------

--
-- Structure de la table `pharmacies`
--

CREATE TABLE `pharmacies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_nom` varchar(255) NOT NULL,
  `pharmacie_adresse` varchar(255) NOT NULL,
  `pharmacie_telephone` varchar(255) NOT NULL,
  `pharmacie_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pharmacies`
--

INSERT INTO `pharmacies` (`id`, `pharmacie_nom`, `pharmacie_adresse`, `pharmacie_telephone`, `pharmacie_create_At`, `hopital_id`, `hopital_emplacement_id`, `created_by`) VALUES
(1, 'PHARMA 01', '039, Kinshasa Luano', '0849393344', '2024-04-16 23:25:31', 1, 1, 1),
(2, 'PHARMA 02', '034, Mushi, Lingwala', '0849393021', '2024-04-16 23:27:04', 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pharmacie_clients`
--

CREATE TABLE `pharmacie_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_nom` varchar(255) DEFAULT NULL,
  `client_phone` varchar(255) NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `client_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pharmacie_clients`
--

INSERT INTO `pharmacie_clients` (`id`, `client_nom`, `client_phone`, `pharmacie_id`, `created_by`, `client_created_At`) VALUES
(1, 'Parker', '09948448844', 2, 1, '2024-04-22 11:53:38');

-- --------------------------------------------------------

--
-- Structure de la table `pharmacie_operations`
--

CREATE TABLE `pharmacie_operations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `operation_qte` int(11) NOT NULL,
  `operation_libelle` varchar(255) NOT NULL,
  `operation_obs` varchar(255) DEFAULT NULL,
  `operation_status` varchar(255) NOT NULL DEFAULT 'actif',
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_dest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `operation_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pharmacie_operations`
--

INSERT INTO `pharmacie_operations` (`id`, `operation_qte`, `operation_libelle`, `operation_obs`, `operation_status`, `produit_id`, `pharmacie_id`, `pharmacie_dest_id`, `fournisseur_id`, `client_id`, `created_by`, `operation_created_At`) VALUES
(1, 300, 'transfert', 'lorem ipsum doloret', 'actif', 1, 1, 2, NULL, NULL, 1, '2024-04-17 00:55:26'),
(2, 20, 'transfert', 'Lorem ipsum doleret', 'actif', 2, 1, 2, NULL, NULL, 1, '2024-04-17 00:58:02'),
(3, 30, 'transfert', NULL, 'actif', 3, 1, 2, NULL, NULL, 1, '2024-04-17 01:15:29'),
(4, 10, 'classement', 'Produit défectueux', 'actif', 3, 1, NULL, NULL, NULL, 1, '2024-04-17 11:51:45'),
(5, 10, 'classement', 'Lorem ipsum doleret', 'actif', 2, 1, NULL, NULL, NULL, 1, '2024-04-17 14:20:59'),
(6, 20, 'retour', 'Lorem Ipsum doloret', 'actif', 3, 1, NULL, 2, NULL, 1, '2024-04-17 14:39:15'),
(7, 100, 'classement', 'Lorem ipsum doloret', 'actif', 1, 1, NULL, NULL, NULL, 6, '2024-04-19 00:27:19'),
(8, 30, 'transfert', 'Lorem ipusll', 'actif', 1, 2, 1, NULL, NULL, 6, '2024-04-19 00:40:14'),
(9, 4, 'vente', NULL, 'actif', 1, 2, NULL, NULL, 1, 1, '2024-04-22 12:10:35'),
(10, 4, 'vente', NULL, 'actif', 1, 2, NULL, NULL, 1, 1, '2024-04-24 12:17:58');

-- --------------------------------------------------------

--
-- Structure de la table `premier_soins`
--

CREATE TABLE `premier_soins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `premier_soin_date_heure` timestamp NULL DEFAULT NULL,
  `premier_soin_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `premier_soin_motif` text NOT NULL,
  `premier_soin_obs` text DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `premier_soin_traitements`
--

CREATE TABLE `premier_soin_traitements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ps_traitement_libelle` varchar(255) NOT NULL,
  `ps_traitement_type` varchar(255) NOT NULL,
  `ps_traitement_dosage` varchar(255) NOT NULL,
  `ps_traitement_unite` varchar(255) NOT NULL,
  `premier_soin_id` varchar(255) NOT NULL,
  `ps_traitement_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_traitement_freq` varchar(255) NOT NULL,
  `prescription_traitement_posologie` varchar(255) NOT NULL,
  `prescription_traitement_duree` varchar(255) NOT NULL,
  `prescription_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `prescription_status` varchar(10) NOT NULL DEFAULT 'actif',
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `consult_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produit_libelle` varchar(255) NOT NULL,
  `produit_code` varchar(255) NOT NULL,
  `produit_stock_min` int(11) DEFAULT 10,
  `produit_description` text DEFAULT NULL,
  `produit_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `unite_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `produit_libelle`, `produit_code`, `produit_stock_min`, `produit_description`, `produit_created_At`, `categorie_id`, `unite_id`, `type_id`, `hopital_id`, `created_by`) VALUES
(1, 'Paracetamol', '0943002030', 500, NULL, '2024-04-16 23:34:20', 2, 3, 1, 1, 1),
(2, 'Amoxy', '949440400430', 400, NULL, '2024-04-16 23:34:50', 2, 3, 1, 1, 1),
(3, 'Ibuprofene', '02939339', 400, 'lorem ipsum', '2024-04-17 01:13:22', 1, 3, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit_categories`
--

CREATE TABLE `produit_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categorie_libelle` varchar(255) NOT NULL,
  `categorie_description` text DEFAULT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `categorie_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_categories`
--

INSERT INTO `produit_categories` (`id`, `categorie_libelle`, `categorie_description`, `hopital_id`, `created_by`, `categorie_created_At`) VALUES
(1, 'Anti-analgesique', NULL, 1, 1, '2024-04-16 23:32:05'),
(2, 'Antibiotique', NULL, 1, 1, '2024-04-16 23:32:10');

-- --------------------------------------------------------

--
-- Structure de la table `produit_prices`
--

CREATE TABLE `produit_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produit_prix` decimal(8,2) NOT NULL,
  `produit_prix_devise` varchar(255) NOT NULL DEFAULT 'CDF',
  `produit_prix_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_prices`
--

INSERT INTO `produit_prices` (`id`, `produit_prix`, `produit_prix_devise`, `produit_prix_create_At`, `pharmacie_id`, `produit_id`, `hopital_id`, `created_by`) VALUES
(1, 240.00, 'CDF', '2024-04-16 23:43:14', 1, 1, 1, 5),
(2, 700.00, 'CDF', '2024-04-16 23:43:25', 2, 2, 1, 6),
(3, 700.00, 'CDF', '2024-04-17 01:14:30', 2, 3, 1, 6),
(4, 600.00, 'CDF', '2024-04-18 22:56:36', 1, 2, 1, 5),
(5, 300.00, 'CDF', '2024-04-18 22:57:57', 2, 1, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `produit_types`
--

CREATE TABLE `produit_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type_libelle` varchar(255) NOT NULL,
  `type_description` varchar(255) DEFAULT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `type_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_types`
--

INSERT INTO `produit_types` (`id`, `type_libelle`, `type_description`, `hopital_id`, `created_by`, `type_created_At`) VALUES
(1, 'Co', NULL, 1, 1, '2024-04-16 23:32:32'),
(2, 'Patch', NULL, 1, 1, '2024-04-16 23:32:43'),
(3, 'Injectable', NULL, 1, 1, '2024-04-16 23:32:50'),
(4, 'Cirop', NULL, 1, 1, '2024-04-16 23:32:54');

-- --------------------------------------------------------

--
-- Structure de la table `produit_unites`
--

CREATE TABLE `produit_unites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unite_libelle` varchar(255) NOT NULL,
  `unite_description` varchar(255) DEFAULT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `type_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit_unites`
--

INSERT INTO `produit_unites` (`id`, `unite_libelle`, `unite_description`, `hopital_id`, `created_by`, `type_created_At`) VALUES
(1, 'M', NULL, 1, 1, '2024-04-16 23:33:07'),
(2, 'mcg', NULL, 1, 1, '2024-04-16 23:33:15'),
(3, 'mg', NULL, 1, 1, '2024-04-16 23:33:20'),
(4, 'ml', NULL, 1, 1, '2024-04-16 23:33:25');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_libelle` varchar(255) NOT NULL,
  `service_description` varchar(255) DEFAULT NULL,
  `service_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `service_status` varchar(255) NOT NULL DEFAULT 'actif',
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `stock_qte` int(11) NOT NULL,
  `stock_pa` varchar(255) DEFAULT NULL,
  `stock_pa_devise` varchar(255) DEFAULT 'CDF',
  `stock_date_exp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock_obs` text DEFAULT NULL,
  `stock_status` varchar(255) NOT NULL DEFAULT 'actif',
  `fournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `stock_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id`, `stock_qte`, `stock_pa`, `stock_pa_devise`, `stock_date_exp`, `stock_obs`, `stock_status`, `fournisseur_id`, `produit_id`, `pharmacie_id`, `created_by`, `stock_created_At`) VALUES
(1, 400, '200', 'CDF', '2025-01-10 22:00:00', 'lorem ipsum', 'actif', 1, 1, 1, 1, '2024-04-16 23:40:38'),
(2, 500, '500', 'CDF', '2026-03-01 22:00:00', NULL, 'actif', 1, 2, 1, 1, '2024-04-16 23:42:25'),
(3, 300, '200', 'CDF', '2025-01-10 22:00:00', 'lorem ipsum doloret', 'actif', 1, 1, 2, 1, '2024-04-17 00:55:27'),
(4, 20, '500', 'CDF', '2026-03-01 22:00:00', 'Lorem ipsum doleret', 'actif', 1, 2, 2, 1, '2024-04-17 00:58:02'),
(5, 200, '500', 'CDF', '2027-11-03 22:00:00', NULL, 'actif', 2, 3, 1, 1, '2024-04-17 01:14:15'),
(6, 30, '500', 'CDF', '2027-11-03 22:00:00', NULL, 'actif', 2, 3, 2, 1, '2024-04-17 01:15:29'),
(7, 89, '500', 'CDF', '2026-12-02 22:00:00', 'Lorem ipsum', 'actif', 2, 1, 2, 6, '2024-04-19 00:39:03'),
(8, 30, '500', 'CDF', '2026-12-02 22:00:00', 'Lorem ipusll', 'actif', 2, 1, 1, 6, '2024-04-19 00:40:15'),
(9, 40, '500', 'USD', '2027-03-01 22:00:00', 'lorem ipsum doloret', 'actif', 2, 1, 1, 5, '2024-04-19 09:52:32');

-- --------------------------------------------------------

--
-- Structure de la table `transfert_patients`
--

CREATE TABLE `transfert_patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transfert_hopital` varchar(255) NOT NULL,
  `transfert_motif` text NOT NULL,
  `transfert_date` timestamp NULL DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `transfert_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `menus` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hopital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pharmacie_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pharmacie_role` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `last_seen`, `password`, `menus`, `remember_token`, `created_at`, `updated_at`, `agent_id`, `user_role_id`, `hopital_emplacement_id`, `hopital_id`, `pharmacie_id`, `pharmacie_role`, `created_by`) VALUES
(1, 'Gaston delimond', 'gastondelimond@gmail.com', '0813719977', NULL, '2024-04-22 08:18:34', '$2y$10$IOeycAXwUDzw7TrYhzUf0uYmjVWhE5LiEbaDWdeB8X.1ioLo7UFae', 'Tableau de bord,Configurations,Agents,Services,Laboratoires,Partenaires,Pharmacies', NULL, '2024-04-16 21:24:36', '2024-04-22 08:18:34', 0, 1, 1, 1, 1, NULL, 0),
(5, 'Johanna', 'johanna@gmail.com', NULL, NULL, '2024-04-19 07:46:41', '$2y$10$8a8mPqA.OuCUR9nH3EVutuIzm1XEKo1qlwZppFP5MnWXeTiEVndrO', 'Tableau de bord,Pharmacies', NULL, '2024-04-18 19:55:15', '2024-04-19 07:46:41', NULL, 7, 1, 1, 1, 'Gérant', 1),
(6, 'Benjamine', 'benjamine@gmail.com', NULL, NULL, '2024-04-18 22:26:00', '$2y$10$3Gxz2SSqE5ysVN1xXbNuGueoPc89RKjif7V7Dv7Bfw0DVOrkh5cZi', 'Tableau de bord,Pharmacies', NULL, '2024-04-18 20:20:28', '2024-04-18 22:26:00', NULL, 7, 1, 1, 2, 'Gérant', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `hopital_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role`, `hopital_id`, `role_create_At`, `created_by`) VALUES
(1, 'Super admin', NULL, '2024-04-16 23:20:06', NULL),
(2, 'Admin', NULL, '2024-04-16 23:20:06', NULL),
(3, 'Docteur', NULL, '2024-04-16 23:20:06', NULL),
(4, 'Infirmier', NULL, '2024-04-16 23:20:06', NULL),
(5, 'Réceptionniste', NULL, '2024-04-16 23:20:06', NULL),
(6, 'Laborantin', NULL, '2024-04-16 23:20:06', NULL),
(7, 'Pharmacien', NULL, '2024-04-16 23:20:06', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agents_agent_matricule_unique` (`agent_matricule`);

--
-- Index pour la table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consultation_details`
--
ALTER TABLE `consultation_details`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consultation_examens`
--
ALTER TABLE `consultation_examens`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `consultation_symptomes`
--
ALTER TABLE `consultation_symptomes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examen_echantillons`
--
ALTER TABLE `examen_echantillons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examen_labos`
--
ALTER TABLE `examen_labos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examen_labo_categories`
--
ALTER TABLE `examen_labo_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examen_labo_types`
--
ALTER TABLE `examen_labo_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `examen_resultats`
--
ALTER TABLE `examen_resultats`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facturation_configs`
--
ALTER TABLE `facturation_configs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facture_paiements`
--
ALTER TABLE `facture_paiements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fonctions`
--
ALTER TABLE `fonctions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hopitals`
--
ALTER TABLE `hopitals`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hopital_emplacements`
--
ALTER TABLE `hopital_emplacements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hospitalisations`
--
ALTER TABLE `hospitalisations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hospitalisation_lits`
--
ALTER TABLE `hospitalisation_lits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hospitalisation_transferts`
--
ALTER TABLE `hospitalisation_transferts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `journee_transactions`
--
ALTER TABLE `journee_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `laboratoires`
--
ALTER TABLE `laboratoires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `labo_equipements`
--
ALTER TABLE `labo_equipements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lit_types`
--
ALTER TABLE `lit_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `medical_schedules`
--
ALTER TABLE `medical_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parteners`
--
ALTER TABLE `parteners`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `partener_agents`
--
ALTER TABLE `partener_agents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_code` (`patient_code`);

--
-- Index pour la table `patient_signes_vitaux`
--
ALTER TABLE `patient_signes_vitaux`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `pharmacies`
--
ALTER TABLE `pharmacies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pharmacie_clients`
--
ALTER TABLE `pharmacie_clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pharmacie_operations`
--
ALTER TABLE `pharmacie_operations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `premier_soins`
--
ALTER TABLE `premier_soins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `premier_soin_traitements`
--
ALTER TABLE `premier_soin_traitements`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produits_produit_libelle_unique` (`produit_libelle`),
  ADD UNIQUE KEY `produits_produit_code_unique` (`produit_code`);

--
-- Index pour la table `produit_categories`
--
ALTER TABLE `produit_categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit_prices`
--
ALTER TABLE `produit_prices`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit_types`
--
ALTER TABLE `produit_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit_unites`
--
ALTER TABLE `produit_unites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transfert_patients`
--
ALTER TABLE `transfert_patients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`);

--
-- Index pour la table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_roles_role_unique` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consultation_details`
--
ALTER TABLE `consultation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consultation_examens`
--
ALTER TABLE `consultation_examens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consultation_symptomes`
--
ALTER TABLE `consultation_symptomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `examen_echantillons`
--
ALTER TABLE `examen_echantillons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `examen_labos`
--
ALTER TABLE `examen_labos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `examen_labo_categories`
--
ALTER TABLE `examen_labo_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `examen_labo_types`
--
ALTER TABLE `examen_labo_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `examen_resultats`
--
ALTER TABLE `examen_resultats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facturation_configs`
--
ALTER TABLE `facturation_configs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `facture_paiements`
--
ALTER TABLE `facture_paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fonctions`
--
ALTER TABLE `fonctions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hopitals`
--
ALTER TABLE `hopitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `hopital_emplacements`
--
ALTER TABLE `hopital_emplacements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `hospitalisations`
--
ALTER TABLE `hospitalisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hospitalisation_lits`
--
ALTER TABLE `hospitalisation_lits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hospitalisation_transferts`
--
ALTER TABLE `hospitalisation_transferts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `journee_transactions`
--
ALTER TABLE `journee_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `laboratoires`
--
ALTER TABLE `laboratoires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `labo_equipements`
--
ALTER TABLE `labo_equipements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `lit_types`
--
ALTER TABLE `lit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `medical_schedules`
--
ALTER TABLE `medical_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parteners`
--
ALTER TABLE `parteners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `partener_agents`
--
ALTER TABLE `partener_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patient_signes_vitaux`
--
ALTER TABLE `patient_signes_vitaux`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pharmacie_clients`
--
ALTER TABLE `pharmacie_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `pharmacie_operations`
--
ALTER TABLE `pharmacie_operations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `premier_soins`
--
ALTER TABLE `premier_soins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `premier_soin_traitements`
--
ALTER TABLE `premier_soin_traitements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `produit_categories`
--
ALTER TABLE `produit_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit_prices`
--
ALTER TABLE `produit_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `produit_types`
--
ALTER TABLE `produit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit_unites`
--
ALTER TABLE `produit_unites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `transfert_patients`
--
ALTER TABLE `transfert_patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
