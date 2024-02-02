-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 01 fév. 2024 à 14:53
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
-- Structure de la table `accouchements`
--

CREATE TABLE `accouchements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `accouchement_type` varchar(255) NOT NULL,
  `accouchement_nbre_bebe` varchar(255) NOT NULL DEFAULT '1',
  `accouchement_date_heure` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `accouchement_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Structure de la table `consultation_pediatriques`
--

CREATE TABLE `consultation_pediatriques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `poids_bebe` varchar(255) NOT NULL,
  `taille_bebe` varchar(255) NOT NULL,
  `temperature_bebe` varchar(255) NOT NULL,
  `tension_art_bebe` varchar(255) NOT NULL,
  `bebe_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `consult_pediatrique_created_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `labo_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `examen_labo_create_At` timestamp NOT NULL DEFAULT current_timestamp()
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
  `fournisseur_email` varchar(255) NOT NULL,
  `fournisseur_telephone` varchar(255) NOT NULL,
  `fournisseur_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(13, '2023_11_22_201938_create_patient_fiches_table', 1),
(14, '2023_11_23_212342_create_user_roles_table', 1),
(15, '2023_11_30_093357_create_hopitals_table', 1),
(16, '2023_11_30_093504_create_hopital_emplacements_table', 1),
(17, '2023_12_05_064940_create_consultation_symptomes_table', 1),
(18, '2023_12_05_071442_create_pharmacies_table', 1),
(19, '2023_12_07_184532_create_examen_labos_table', 1),
(20, '2023_12_08_111240_create_consultation_examens_table', 1),
(21, '2023_12_18_085639_create_accouchements_table', 1),
(22, '2023_12_18_090219_create_naissances_table', 1),
(23, '2023_12_18_092554_create_suivi_grossesses_table', 1),
(24, '2023_12_18_093033_create_visite_prenatales_table', 1),
(25, '2023_12_18_095002_create_consultation_pediatriques_table', 1),
(26, '2023_12_18_100014_create_suivi_post_natales_table', 1),
(27, '2023_12_18_121104_create_stocks_table', 1),
(28, '2023_12_18_121850_create_mouvement_stocks_table', 1),
(29, '2023_12_18_122644_create_fournisseurs_table', 1),
(30, '2023_12_18_133447_create_laboratoires_table', 1),
(31, '2023_12_18_133822_create_labo_equipements_table', 1),
(32, '2023_12_18_134143_create_examen_echantillons_table', 1),
(33, '2023_12_27_071621_create_produits_table', 1),
(34, '2023_12_27_100429_create_examen_resultats_table', 1),
(35, '2023_12_27_121505_create_produit_categories_table', 1),
(36, '2024_01_08_082932_create_produit_types_table', 1),
(37, '2024_01_08_091811_create_journee_transactions_table', 1),
(38, '2024_01_10_074159_create_hospitalisations_table', 1),
(39, '2024_01_10_080902_create_hospitalisation_lits_table', 1),
(40, '2024_01_10_085611_create_hospitalisation_transferts_table', 1),
(41, '2024_01_10_090100_create_lit_types_table', 1),
(42, '2024_01_12_073312_create_medical_schedules_table', 1),
(43, '2024_01_15_070515_create_parteners_table', 1),
(44, '2024_01_16_000435_create_premier_soins_table', 1),
(45, '2024_01_16_001307_create_premier_soin_traitements_table', 1),
(46, '2024_01_16_121216_create_facturation_configs_table', 1),
(47, '2024_01_23_143111_create_transfert_patients_table', 1),
(48, '2024_01_24_073525_create_facture_paiements_table', 1);

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
-- Structure de la table `naissances`
--

CREATE TABLE `naissances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `naissance_nom` varchar(255) NOT NULL,
  `naissance_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `naissance_poids` varchar(255) NOT NULL,
  `naissance_taille` varchar(255) NOT NULL,
  `naissance_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
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
  `patient_datenais` varchar(10) NOT NULL,
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
-- Structure de la table `patient_fiches`
--

CREATE TABLE `patient_fiches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_fiche_poids` varchar(5) DEFAULT NULL,
  `patient_fiche_poids_unite` varchar(5) NOT NULL DEFAULT 'kg',
  `patient_fiche_taille` varchar(5) DEFAULT NULL,
  `patient_fiche_taille_unite` varchar(5) NOT NULL DEFAULT 'cm',
  `patient_fiche_temperature` varchar(5) DEFAULT NULL,
  `patient_fiche_temperature_unite` varchar(5) NOT NULL DEFAULT '°c',
  `patient_fiche_tension_art` varchar(5) DEFAULT NULL,
  `patient_fiche_tension_art_unite` varchar(5) NOT NULL DEFAULT 'mmHg',
  `patient_fiche_freq_cardio` varchar(5) DEFAULT NULL,
  `patient_fiche_freq_cardio_unite` varchar(5) NOT NULL DEFAULT 'bpm',
  `patient_fiche_saturation` varchar(5) DEFAULT NULL,
  `patient_fiche_saturation_unite` varchar(5) NOT NULL DEFAULT '%',
  `patient_fiche_age` varchar(5) NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `patient_fiche_status` varchar(255) NOT NULL DEFAULT 'en attente',
  `patient_fiche_create_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
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
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `prescription_traitement` varchar(255) NOT NULL,
  `prescription_traitement_type` varchar(255) NOT NULL,
  `prescription_traitement_duree` varchar(255) NOT NULL,
  `prescription_traitement_duree_unite` varchar(255) NOT NULL,
  `prescription_traitement_freq` varchar(255) NOT NULL,
  `prescription_traitement_freq_unite` varchar(255) NOT NULL DEFAULT 'jour',
  `prescription_posologie` varchar(255) NOT NULL,
  `prescription_posologie_unite` varchar(255) NOT NULL,
  `prescription_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `prescription_status` varchar(10) NOT NULL DEFAULT 'actif',
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
  `produit_prix_unitaire` varchar(255) NOT NULL,
  `produit_unite` varchar(255) NOT NULL,
  `produit_unite_qte` varchar(255) NOT NULL,
  `produit_description` text DEFAULT NULL,
  `produit_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `type_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_categories`
--

CREATE TABLE `produit_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categorie_libelle` varchar(255) NOT NULL,
  `categorie_description` text DEFAULT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `categorie_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_types`
--

CREATE TABLE `produit_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produit_type_libelle` varchar(255) NOT NULL,
  `produit_type_description` varchar(255) DEFAULT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `type_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `stock_code` varchar(255) NOT NULL,
  `stock_qte` int(11) NOT NULL,
  `stock_qte_min` int(11) NOT NULL,
  `emplacement` varchar(255) NOT NULL,
  `stock_date_exp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `stock_status` varchar(255) NOT NULL DEFAULT 'actif',
  `fournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `stock_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_grossesses`
--

CREATE TABLE `suivi_grossesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `suivi_date_debut` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `suivi_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivi_post_natales`
--

CREATE TABLE `suivi_post_natales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `suivi_post_natale_etat_sante` varchar(255) NOT NULL,
  `suivi_post_natale_recommandations` varchar(255) NOT NULL,
  `suivi_post_natale_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `phone` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `last_seen` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `menus` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `user_role_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Structure de la table `visite_prenatales`
--

CREATE TABLE `visite_prenatales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `visite_poids` varchar(255) NOT NULL,
  `visite_tension_art` varchar(255) NOT NULL,
  `visite_recommandations` text NOT NULL,
  `suivi_grossesse_id` bigint(20) UNSIGNED NOT NULL,
  `visite_created_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `accouchements`
--
ALTER TABLE `accouchements`
  ADD PRIMARY KEY (`id`);

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
-- Index pour la table `consultation_pediatriques`
--
ALTER TABLE `consultation_pediatriques`
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
-- Index pour la table `naissances`
--
ALTER TABLE `naissances`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parteners`
--
ALTER TABLE `parteners`
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
-- Index pour la table `patient_fiches`
--
ALTER TABLE `patient_fiches`
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
-- Index pour la table `produit_types`
--
ALTER TABLE `produit_types`
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
-- Index pour la table `suivi_grossesses`
--
ALTER TABLE `suivi_grossesses`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `suivi_post_natales`
--
ALTER TABLE `suivi_post_natales`
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
-- Index pour la table `visite_prenatales`
--
ALTER TABLE `visite_prenatales`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `accouchements`
--
ALTER TABLE `accouchements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT pour la table `consultation_pediatriques`
--
ALTER TABLE `consultation_pediatriques`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hopitals`
--
ALTER TABLE `hopitals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `hopital_emplacements`
--
ALTER TABLE `hopital_emplacements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `naissances`
--
ALTER TABLE `naissances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `parteners`
--
ALTER TABLE `parteners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `patient_fiches`
--
ALTER TABLE `patient_fiches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit_categories`
--
ALTER TABLE `produit_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit_types`
--
ALTER TABLE `produit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `suivi_grossesses`
--
ALTER TABLE `suivi_grossesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `suivi_post_natales`
--
ALTER TABLE `suivi_post_natales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transfert_patients`
--
ALTER TABLE `transfert_patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `visite_prenatales`
--
ALTER TABLE `visite_prenatales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
