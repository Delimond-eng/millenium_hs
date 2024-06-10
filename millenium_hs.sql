-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 juin 2024 à 21:42
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

--
-- Déchargement des données de la table `agents`
--

INSERT INTO `agents` (`id`, `agent_matricule`, `agent_nom`, `agent_prenom`, `agent_sexe`, `agent_telephone`, `agent_adresse`, `agent_datenais`, `agent_specialite`, `agent_create_At`, `agent_status`, `grade_id`, `service_id`, `fonction_id`, `created_by`, `hopital_emplacement_id`, `hopital_id`) VALUES
(1, '0293932', 'Nawej', 'Lionnel', 'M', '0978328800', NULL, NULL, 'Cardiologie', '2024-05-13 22:04:58', 'actif', NULL, NULL, NULL, 1, 1, 1);

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

--
-- Déchargement des données de la table `consultations`
--

INSERT INTO `consultations` (`id`, `consult_libelle`, `consult_diagnostic`, `consult_create_At`, `consult_status`, `patient_id`, `agent_id`, `hopital_id`, `hopital_emplacement_id`, `created_by`) VALUES
(1, 'Lorem ipsum doloret', 'Lorem ipsum doloret', '2024-05-22 12:15:35', 'actif', 1, 1, 1, 1, 4);

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

--
-- Déchargement des données de la table `consultation_examens`
--

INSERT INTO `consultation_examens` (`id`, `examen_id`, `agent_id`, `consult_id`, `patient_id`, `hopital_id`, `hopital_emplacement_id`, `created_by`, `consult_examen_create_At`, `consult_examen_status`) VALUES
(1, 1, 1, 1, 1, 1, 1, 4, '2024-05-22 12:29:11', 'en attente'),
(2, 2, 1, 1, 1, 1, 1, 4, '2024-05-22 12:29:11', 'en attente');

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

--
-- Déchargement des données de la table `consultation_symptomes`
--

INSERT INTO `consultation_symptomes` (`id`, `consult_symptome_libelle`, `consult_id`, `consult_symptome_create_At`, `created_by`) VALUES
(1, 'Fièvre', 1, '2024-05-22 12:15:35', 4),
(2, 'Fatigue', 1, '2024-05-22 12:15:36', 4),
(3, 'Vomissements', 1, '2024-05-22 12:15:36', 4);

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

--
-- Déchargement des données de la table `examen_labos`
--

INSERT INTO `examen_labos` (`id`, `examen_labo_libelle`, `examen_labo_description`, `examen_labo_prix`, `examen_resultat_type`, `examen_labo_prix_devise`, `labo_id`, `type_id`, `hopital_id`, `hopital_emplacement_id`, `created_by`, `examen_labo_create_At`) VALUES
(1, 'IRM', 'examen de malaria', '45000', 'text', 'CDF', 1, NULL, 1, 1, 1, '2024-05-14 22:55:47'),
(2, 'Echographie', NULL, '120000', 'image', 'CDF', 1, NULL, 1, 1, 1, '2024-05-14 22:57:11');

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

--
-- Déchargement des données de la table `facturation_configs`
--

INSERT INTO `facturation_configs` (`id`, `facturation_config_libelle`, `facturation_config_montant`, `facturation_config_montant_devise`, `created_by`, `hopital_id`, `hopital_emplacement_id`, `facturation_config_created_At`) VALUES
(1, 'Fiche médicale & consultation', 50000.00, 'CDF', 4, 1, 1, '2024-05-17 19:38:31');

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
  `hopital_id` int(11) NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `paiement_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `facture_paiements`
--

INSERT INTO `facture_paiements` (`id`, `paiement_montant`, `paiement_montant_devise`, `patient_id`, `facturation_id`, `created_by`, `hopital_id`, `hopital_emplacement_id`, `paiement_created_At`) VALUES
(1, 50000.00, 'CDF', 1, 1, 4, 1, 1, '2024-05-22 12:13:43');

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
(1, 'KIM Pharma', '03, Limete indistrielle', 'kimpharma@gmail.com', '0938838932', '2024-05-13 21:43:36', 1, 2);

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
(1, 'HJ HOSPITAL', '01, Limete 1ère Rue Indistrielle, Ref. Blvd Lumumba', 'http://127.0.0.1:8000/uploads/1715635933.png', '2024-05-13 21:32:13');

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
(1, 'Siège social', '01, Limete 1ère Rue Indistrielle, Ref. Blvd Lumumba', '2024-05-13 21:32:13', 1, 0);

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

--
-- Déchargement des données de la table `laboratoires`
--

INSERT INTO `laboratoires` (`id`, `labo_nom`, `labo_telephone`, `labo_adresse`, `labo_created_At`, `hopital_id`, `hopital_emplacement_id`, `created_by`) VALUES
(1, 'Labo 01', '09938833344', '04, kinshasa Limete', '2024-05-14 22:54:50', 1, 1, 1);

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
(50, '2024_04_22_091704_create_pharmacie_clients_table', 1),
(51, '2024_05_10_092623_create_pharmacist_sessions_table', 1),
(52, '2024_05_11_053149_create_pharmacie_tickets_table', 1),
(53, '2024_05_18_165246_create_patient_traitements_table', 2),
(54, '2024_05_19_122951_create_patient_suivis_table', 3);

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
  `patient_traitement_status` varchar(50) DEFAULT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patients`
--

INSERT INTO `patients` (`id`, `patient_code`, `patient_code_appel`, `patient_nom`, `patient_prenom`, `patient_sexe`, `patient_datenais`, `patient_etat_civil`, `patient_adresse`, `patient_telephone`, `patient_contact_urgence`, `patient_num_assurance`, `patient_gs`, `patient_create_At`, `patient_status`, `patient_traitement_status`, `hopital_emplacement_id`, `hopital_id`, `created_by`) VALUES
(1, 'U8790', '039492', 'Bukasa', 'Laurent', 'M', '1993-12-20 00:00:00', 'Célibataire', '04, Kinshasa', '0849348844', '0845854499', NULL, 'Rh positif (+)', '2024-05-22 13:43:46', 'actif', NULL, 1, 1, 4);

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
  `consult_id` bigint(20) DEFAULT NULL,
  `patient_sv_status` varchar(255) NOT NULL DEFAULT 'en attente',
  `patient_sv_created_At` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient_signes_vitaux`
--

INSERT INTO `patient_signes_vitaux` (`id`, `patient_sv_poids`, `patient_sv_poids_unite`, `patient_sv_taille`, `patient_sv_taille_unite`, `patient_sv_temperature`, `patient_sv_temperature_unite`, `patient_sv_tension_art`, `patient_sv_tension_art_unite`, `patient_sv_freq_cardio`, `patient_sv_freq_cardio_unite`, `patient_sv_saturation`, `patient_sv_saturation_unite`, `patient_sv_age`, `patient_id`, `consult_id`, `patient_sv_status`, `patient_sv_created_At`, `hopital_emplacement_id`, `hopital_id`, `created_by`) VALUES
(1, '80', 'kg', '170', 'cm', '33', '°c', '88', 'mmHg', '88', 'bpm', '88', '%', '30', 1, 1, 'en attente', '2024-05-22 12:15:35', 1, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `patient_suivis`
--

CREATE TABLE `patient_suivis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `suivi_etat` varchar(255) NOT NULL DEFAULT 'stable',
  `suivi_obs` varchar(255) DEFAULT NULL,
  `suivi_recommandations` varchar(255) DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient_suivis`
--

INSERT INTO `patient_suivis` (`id`, `suivi_etat`, `suivi_obs`, `suivi_recommandations`, `patient_id`, `agent_id`, `created_by`, `hopital_id`, `hopital_emplacement_id`, `created_at`, `updated_at`) VALUES
(1, 'stable', 'Lorem ipsum doloret', 'Lorem ipsum doloret', 1, 1, 4, 1, 1, '2024-05-22 11:52:40', '2024-05-22 11:52:40'),
(2, 'critique', 'Lorem ipsum doloret', 'Lorem ipsum', 1, 1, 4, 1, 1, '2024-05-22 11:56:48', '2024-05-22 11:56:48');

-- --------------------------------------------------------

--
-- Structure de la table `patient_traitements`
--

CREATE TABLE `patient_traitements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `traitement_obs` varchar(255) DEFAULT NULL,
  `traitement_status` varchar(255) NOT NULL DEFAULT 'actif',
  `prescription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `suivi_id` bigint(20) NOT NULL,
  `patient_id` bigint(20) NOT NULL,
  `agent_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `hopital_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `patient_traitements`
--

INSERT INTO `patient_traitements` (`id`, `traitement_obs`, `traitement_status`, `prescription_id`, `suivi_id`, `patient_id`, `agent_id`, `created_by`, `hopital_id`, `hopital_emplacement_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'actif', 1, 1, 1, 1, 4, 1, 1, '2024-05-22 11:52:40', '2024-05-22 11:52:40'),
(2, NULL, 'actif', 2, 1, 1, 1, 4, 1, 1, '2024-05-22 11:52:40', '2024-05-22 11:52:40'),
(3, NULL, 'actif', 3, 1, 1, 1, 4, 1, 1, '2024-05-22 11:52:40', '2024-05-22 11:52:40'),
(4, NULL, 'actif', 1, 2, 1, 1, 4, 1, 1, '2024-05-22 11:56:48', '2024-05-22 11:56:48');

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
(1, 'App\\Models\\User', 2, 'user-token', '975db8ba5c4af4d066f5d9242b9ba2cb66efae4b24dddd08deed48674254a60f', '[\"*\"]', NULL, NULL, '2024-05-13 20:42:58', '2024-05-13 20:42:58'),
(2, 'App\\Models\\User', 1, 'user-token', 'ad9d1a12542c661a69385b572a07ee730ddf7bc94679b83c4a9473428c941e27', '[\"*\"]', NULL, NULL, '2024-05-13 20:52:57', '2024-05-13 20:52:57'),
(3, 'App\\Models\\User', 3, 'user-token', '07c151ffcfc6885d0a64fa2775cbcd6088160d3de9dd30d380b39f927f7a8179', '[\"*\"]', NULL, NULL, '2024-05-13 20:54:10', '2024-05-13 20:54:10'),
(4, 'App\\Models\\User', 1, 'user-token', '5c0f965ec613e3b0986f55b6176325779ed3706a798bbca9a0cbd8326edbb09c', '[\"*\"]', NULL, NULL, '2024-05-13 21:03:28', '2024-05-13 21:03:28'),
(5, 'App\\Models\\User', 4, 'user-token', '02b138c14cf9f8b5c950bcfe4647ebca7c0cad52a5252153a3d14853c59d8e66', '[\"*\"]', NULL, NULL, '2024-05-13 21:06:12', '2024-05-13 21:06:12'),
(6, 'App\\Models\\User', 4, 'user-token', '18d44848c13e15f558d9d26e8b42e8924460a961e5423e2761982968f85e04b7', '[\"*\"]', NULL, NULL, '2024-05-13 23:13:41', '2024-05-13 23:13:41'),
(7, 'App\\Models\\User', 1, 'user-token', '49e9d0779455a4bf89e5a886929ef73585440ae8f97ca7a72ad27e1fb58a65f6', '[\"*\"]', NULL, NULL, '2024-05-14 21:53:31', '2024-05-14 21:53:31'),
(8, 'App\\Models\\User', 3, 'user-token', 'aa83a6df8cf518bfd3f97e6114f539c76f55e8ebbd765b478bcb1ec6b40a9a66', '[\"*\"]', NULL, NULL, '2024-05-14 21:58:55', '2024-05-14 21:58:55'),
(9, 'App\\Models\\User', 4, 'user-token', '3ff2827b0c349f3319d657c865c29edb6c2abb1f1999d7a27bea4cc42a53b9fb', '[\"*\"]', NULL, NULL, '2024-05-14 21:59:49', '2024-05-14 21:59:49'),
(10, 'App\\Models\\User', 4, 'user-token', '76b78ed5a616bef86c34eee8890fda2a7a4bf2f1f658cd7c6042a9c664e25c23', '[\"*\"]', NULL, NULL, '2024-05-15 12:50:55', '2024-05-15 12:50:55'),
(11, 'App\\Models\\User', 4, 'user-token', '4cfd6f50bfdc61001fb4c9f839916556c92487d3efaa50e46d1c34f281e621b7', '[\"*\"]', NULL, NULL, '2024-05-16 11:58:13', '2024-05-16 11:58:13'),
(12, 'App\\Models\\User', 4, 'user-token', '4e6b80b92b60de60fd21233cf3d6bf84989280b098e723c2a99a60d2245e792e', '[\"*\"]', NULL, NULL, '2024-05-16 13:10:30', '2024-05-16 13:10:30'),
(13, 'App\\Models\\User', 4, 'user-token', '321c382aabd95f712bc81bcf1e7c85eee8cb083c31b40a5ebaeb0a5a85aeed88', '[\"*\"]', NULL, NULL, '2024-05-16 13:11:04', '2024-05-16 13:11:04'),
(14, 'App\\Models\\User', 4, 'user-token', '1c0dad0ca63c8f736bed8ad03f519576b12d55e03a7cedc3367410206d5c0074', '[\"*\"]', NULL, NULL, '2024-05-16 19:36:34', '2024-05-16 19:36:34'),
(15, 'App\\Models\\User', 4, 'user-token', 'c98ac4f65c90539c54cbd57404c49f36a51e716d82371456897d89361a67cc8c', '[\"*\"]', NULL, NULL, '2024-05-17 18:34:01', '2024-05-17 18:34:01'),
(16, 'App\\Models\\User', 1, 'user-token', '84536f6e3ae809502885cf88453bb9032d07ca3663c48f818490de0cdcb95e11', '[\"*\"]', NULL, NULL, '2024-05-19 10:49:27', '2024-05-19 10:49:27'),
(17, 'App\\Models\\User', 2, 'user-token', '8f88a1970df7eb34775af7cf04a7dc049d9325a07e31744695390084956f6a94', '[\"*\"]', NULL, NULL, '2024-05-19 10:50:10', '2024-05-19 10:50:10'),
(18, 'App\\Models\\User', 1, 'user-token', 'bd392b3c51d37c453a2dab2db5ffffa7172008824685fb2ce0fada6d90268e96', '[\"*\"]', NULL, NULL, '2024-05-19 11:18:11', '2024-05-19 11:18:11'),
(19, 'App\\Models\\User', 2, 'user-token', '76a453942cf00de2884b535abc788a590842888a2c3a2d48fd5466bee3e9a560', '[\"*\"]', NULL, NULL, '2024-05-19 11:18:29', '2024-05-19 11:18:29'),
(20, 'App\\Models\\User', 2, 'user-token', '7690932900b9a895dc74d770ac9b54c190b5d2d9ea3806cbed50e3e43f7d101b', '[\"*\"]', NULL, NULL, '2024-05-19 11:20:03', '2024-05-19 11:20:03'),
(21, 'App\\Models\\User', 4, 'user-token', '2d682c806116ecfcea7a7a0bf79f4156975b788d6b8b48c899015eb600c690c7', '[\"*\"]', NULL, NULL, '2024-05-19 22:56:18', '2024-05-19 22:56:18'),
(22, 'App\\Models\\User', 4, 'user-token', '9e2bb34dd2c94f983dffec97bf5b7cbaf5258e07690c9130f042a9b87c31dc13', '[\"*\"]', NULL, NULL, '2024-05-19 23:02:57', '2024-05-19 23:02:57'),
(23, 'App\\Models\\User', 4, 'user-token', '8575e17ff2e250ad15180cba482a440cde3bce7c8a784e42f16e459053ca4d2f', '[\"*\"]', NULL, NULL, '2024-05-19 23:40:21', '2024-05-19 23:40:21'),
(24, 'App\\Models\\User', 4, 'user-token', 'afcc05aa4fbe14bac4a263a92f492284e892244e3d0fee9112b6a2bede1bb6db', '[\"*\"]', NULL, NULL, '2024-05-20 09:27:39', '2024-05-20 09:27:39'),
(25, 'App\\Models\\User', 4, 'user-token', 'e42755deff5a11de764a292c8509f4089d561cae288a92a0976764f79bc2a892', '[\"*\"]', NULL, NULL, '2024-05-22 09:35:22', '2024-05-22 09:35:22'),
(26, 'App\\Models\\User', 4, 'user-token', 'b83a96acee182dd83236589fa0be462317dfaa1e245b1717fb24e0607d6b91ad', '[\"*\"]', NULL, NULL, '2024-05-24 00:41:10', '2024-05-24 00:41:10'),
(27, 'App\\Models\\User', 4, 'user-token', '6217a1b6ed87c7072f846314133a78fd1f8d9ae92ab954845cd598bd1385159f', '[\"*\"]', NULL, NULL, '2024-05-24 16:34:35', '2024-05-24 16:34:35'),
(28, 'App\\Models\\User', 4, 'user-token', '6b865b33a7c2035f9f0d2f4986a682c9e603bfeecf09f9edf44ee821963c9265', '[\"*\"]', NULL, NULL, '2024-05-24 19:45:07', '2024-05-24 19:45:07'),
(29, 'App\\Models\\User', 1, 'user-token', 'b883ff43453f053d41cd2f2deccf11f87ea4e38ff6b6fe9596ea6a8a8b945395', '[\"*\"]', NULL, NULL, '2024-05-28 12:05:26', '2024-05-28 12:05:26');

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
(1, 'PHARMA 01', '01, 1ere Rue Blvd Lumumbe', '0839494444', '2024-05-13 21:39:46', 1, 1, 1);

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
(1, 'Balu mukeba', '0813718833', 1, 3, '2024-05-13 21:55:11'),
(2, 'unknown', 'unknown', 1, 3, '2024-05-14 00:11:39');

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
  `produit_prix` decimal(8,2) DEFAULT NULL,
  `produit_prix_devise` varchar(255) NOT NULL DEFAULT 'CDF',
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_dest_id` bigint(20) UNSIGNED DEFAULT NULL,
  `fournisseur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `operation_created_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pharmacie_operations`
--

INSERT INTO `pharmacie_operations` (`id`, `operation_qte`, `operation_libelle`, `operation_obs`, `operation_status`, `produit_id`, `produit_prix`, `produit_prix_devise`, `pharmacie_id`, `pharmacie_dest_id`, `fournisseur_id`, `client_id`, `ticket_id`, `created_by`, `operation_created_At`) VALUES
(1, 3, 'Vente', NULL, 'actif', 1, 280.00, 'CDF', 1, NULL, NULL, 1, 1, 3, '2024-05-13 21:55:16'),
(2, 2, 'Vente', NULL, 'actif', 2, 260.00, 'CDF', 1, NULL, NULL, 1, 1, 3, '2024-05-13 21:55:16'),
(3, 2, 'Vente', NULL, 'actif', 3, 1300.00, 'CDF', 1, NULL, NULL, 1, 1, 3, '2024-05-13 21:55:16'),
(4, 1, 'Vente', NULL, 'actif', 1, 280.00, 'CDF', 1, NULL, NULL, 2, 2, 3, '2024-05-14 00:11:40'),
(5, 1, 'Vente', NULL, 'actif', 2, 260.00, 'CDF', 1, NULL, NULL, 2, 2, 3, '2024-05-14 00:11:40');

-- --------------------------------------------------------

--
-- Structure de la table `pharmacie_tickets`
--

CREATE TABLE `pharmacie_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_code` varchar(255) NOT NULL,
  `ticket_nb_items` int(11) NOT NULL,
  `ticket_paiement` decimal(8,2) NOT NULL,
  `ticket_devise` varchar(255) NOT NULL DEFAULT 'CDF',
  `ticket_status` varchar(255) NOT NULL DEFAULT 'actif',
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pharmacie_tickets`
--

INSERT INTO `pharmacie_tickets` (`id`, `ticket_code`, `ticket_nb_items`, `ticket_paiement`, `ticket_devise`, `ticket_status`, `client_id`, `user_id`, `pharmacie_id`, `created_at`, `updated_at`) VALUES
(1, 'W00180', 3, 3960.00, 'CDF', 'actif', 1, 3, 1, '2024-05-13 20:55:16', '2024-05-13 20:55:16'),
(2, 'A09839', 2, 540.00, 'CDF', 'actif', 2, 3, 1, '2024-05-13 23:11:39', '2024-05-13 23:11:39');

-- --------------------------------------------------------

--
-- Structure de la table `pharmacist_sessions`
--

CREATE TABLE `pharmacist_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `initial_balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `closing_balance` decimal(8,2) NOT NULL DEFAULT 0.00,
  `nbre_ticket` int(11) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pharmacie_id` bigint(20) UNSIGNED NOT NULL,
  `started_at` time DEFAULT NULL,
  `end_at` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pharmacist_sessions`
--

INSERT INTO `pharmacist_sessions` (`id`, `initial_balance`, `closing_balance`, `nbre_ticket`, `user_id`, `pharmacie_id`, `started_at`, `end_at`, `created_at`, `updated_at`) VALUES
(1, 45000.00, 0.00, 0, 3, 1, '22:54:23', NULL, '2024-05-13 20:54:23', '2024-05-13 20:54:23');

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
  `prescription_code` varchar(255) NOT NULL,
  `prescription_traitement_freq` varchar(255) NOT NULL,
  `prescription_traitement_freq_unite` varchar(255) NOT NULL,
  `prescription_traitement_dosage` varchar(255) NOT NULL,
  `prescription_traitement_dosage_unite` varchar(255) NOT NULL,
  `prescription_traitement_duree` varchar(255) NOT NULL,
  `prescription_traitement_duree_unite` varchar(255) NOT NULL,
  `prescription_traitement_qte` int(11) NOT NULL,
  `prescription_traitement_qte_unite` varchar(255) NOT NULL,
  `prescription_create_At` timestamp NOT NULL DEFAULT current_timestamp(),
  `prescription_status` varchar(10) NOT NULL DEFAULT 'actif',
  `produit_id` bigint(20) UNSIGNED NOT NULL,
  `consult_id` bigint(20) UNSIGNED NOT NULL,
  `hopital_emplacement_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `prescription_code`, `prescription_traitement_freq`, `prescription_traitement_freq_unite`, `prescription_traitement_dosage`, `prescription_traitement_dosage_unite`, `prescription_traitement_duree`, `prescription_traitement_duree_unite`, `prescription_traitement_qte`, `prescription_traitement_qte_unite`, `prescription_create_At`, `prescription_status`, `produit_id`, `consult_id`, `hopital_emplacement_id`, `created_by`) VALUES
(1, 'T02892', '3', 'Jour', '1000', 'mg', '3', 'Jours', 1, 'mg', '2024-05-22 12:27:07', 'actif', 1, 1, 1, 4),
(2, 'T02892', '3', 'Jour', '1000', 'mg', '3', 'Jours', 2, 'mg', '2024-05-22 12:27:08', 'actif', 2, 1, 1, 4),
(3, 'T02892', '3', 'Jour', '400', 'mg', '3', 'Jours', 2, 'mg', '2024-05-22 12:27:08', 'actif', 3, 1, 1, 4);

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
(1, 'Paracetamol', '02493000', NULL, NULL, '2024-05-13 21:46:35', 1, 1, 1, 1, 2),
(2, 'Amoxy', '0394232', NULL, NULL, '2024-05-13 21:47:01', 2, 1, 1, 1, 2),
(3, 'Mephtal forte', '03949303', NULL, NULL, '2024-05-13 21:47:25', 1, 1, 1, 1, 2),
(4, 'Anti-touxif', '0394833', NULL, NULL, '2024-05-13 21:47:53', 1, 2, 5, 1, 2);

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
(1, 'Anti-analgesique', NULL, 1, 2, '2024-05-13 21:43:51'),
(2, 'Antibiotique', NULL, 1, 2, '2024-05-13 21:44:04');

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
(1, 420.00, 'CDF', '2024-05-13 21:51:31', 1, 1, 1, 2),
(2, 260.00, 'CDF', '2024-05-13 21:51:39', 1, 2, 1, 2),
(3, 1300.00, 'CDF', '2024-05-13 21:51:49', 1, 3, 1, 2),
(4, 1680.00, 'CDF', '2024-05-13 21:52:01', 1, 4, 1, 2);

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
(1, 'Comprimé', NULL, 1, 2, '2024-05-13 21:44:23'),
(2, 'Ge', NULL, 1, 2, '2024-05-13 21:44:27'),
(3, 'Gellule', NULL, 1, 2, '2024-05-13 21:44:34'),
(4, 'Patch', NULL, 1, 2, '2024-05-13 21:44:42'),
(5, 'Cirop', NULL, 1, 2, '2024-05-13 21:44:47');

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
(1, 'mg', NULL, 1, 2, '2024-05-13 21:44:55'),
(2, 'ml', NULL, 1, 2, '2024-05-13 21:44:57');

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
(1, 400, '200', 'CDF', '2025-12-19 22:00:00', NULL, 'actif', 1, 1, 1, 2, '2024-05-13 21:49:09'),
(2, 201, '200', 'CDF', '2025-02-10 22:00:00', NULL, 'actif', 1, 2, 1, 2, '2024-05-13 21:49:46'),
(3, 60, '1000', 'CDF', '2025-02-10 22:00:00', NULL, 'actif', 1, 3, 1, 2, '2024-05-13 21:50:46'),
(4, 200, '1200', 'CDF', '2025-01-02 22:00:00', NULL, 'actif', 1, 4, 1, 2, '2024-05-13 21:51:18'),
(5, 200, '400', 'CDF', '2025-12-11 22:00:00', 'Lorem ipsum doloret', 'actif', 1, 1, 1, 2, '2024-05-19 12:55:39'),
(6, 30, '450', 'CDF', '2025-12-11 22:00:00', 'Lorem ipsum doloret', 'actif', 1, 1, 1, 2, '2024-05-19 12:57:58');

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
(1, 'Gaston delimond', 'gastondelimond@gmail.com', '0814703300', NULL, '2024-05-28 12:05:26', '$2y$10$gelf9Gob8UM0.C6GgI5.lO5QUcUcz1Fa4i6JjfmLVRxDuB.Kl5ADy', 'Tableau de bord,Configurations,Agents,Services,Laboratoires,Partenaires,Pharmacies', NULL, '2024-05-13 20:32:13', '2024-05-28 12:05:26', 0, 1, 1, 1, NULL, NULL, 0),
(2, 'Miriam TP', 'miriam@gmail.com', NULL, NULL, '2024-05-19 11:20:02', '$2y$10$6ZMiSCQcm/WGrhA0R4s7FeSoCJkiyjc0Mq6AabH3C4QtpZxTRMRWq', 'Tableau de bord,Pharmacies', NULL, '2024-05-13 20:40:56', '2024-05-19 11:20:02', NULL, 7, 1, 1, 1, 'Gérant', 1),
(3, 'Johanna ndaya', 'johanna@gmail.com', NULL, NULL, '2024-05-14 21:58:55', '$2y$10$/pzVzJpmTz71KWto4aD5w.JuNS5NQYNRNHdM7WbBb/MF2Pl8MNEHm', 'Tableau de bord,Pharmacies', NULL, '2024-05-13 20:53:36', '2024-05-14 21:58:55', NULL, 7, 1, 1, 1, 'Vendeur', 1),
(4, 'Lionnel', 'lionnelnawej@gmail.com', '0978328800', NULL, '2024-05-24 19:45:07', '$2y$10$OcR9LqrPb8uXhxUs3J8efuHoImCXY48Kx3PKEPTOt5tEv4eckU9jS', 'Tableau de bord,Patients,Consultations,Suivis,Premiers soins', NULL, '2024-05-13 21:04:58', '2024-05-24 19:45:07', 1, 3, 1, 1, NULL, NULL, 0);

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
(1, 'Super admin', NULL, '2024-05-13 21:27:11', NULL),
(2, 'Admin', NULL, '2024-05-13 21:27:11', NULL),
(3, 'Docteur', NULL, '2024-05-13 21:27:11', NULL),
(4, 'Infirmier', NULL, '2024-05-13 21:27:11', NULL),
(5, 'Réceptionniste', NULL, '2024-05-13 21:27:11', NULL),
(6, 'Laborantin', NULL, '2024-05-13 21:27:11', NULL),
(7, 'Pharmacien', NULL, '2024-05-13 21:27:11', NULL);

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
-- Index pour la table `patient_suivis`
--
ALTER TABLE `patient_suivis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `patient_traitements`
--
ALTER TABLE `patient_traitements`
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
-- Index pour la table `pharmacie_tickets`
--
ALTER TABLE `pharmacie_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pharmacist_sessions`
--
ALTER TABLE `pharmacist_sessions`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `consultation_details`
--
ALTER TABLE `consultation_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `consultation_examens`
--
ALTER TABLE `consultation_examens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `consultation_symptomes`
--
ALTER TABLE `consultation_symptomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `examen_echantillons`
--
ALTER TABLE `examen_echantillons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `examen_labos`
--
ALTER TABLE `examen_labos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `facture_paiements`
--
ALTER TABLE `facture_paiements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `mouvement_stocks`
--
ALTER TABLE `mouvement_stocks`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `patient_signes_vitaux`
--
ALTER TABLE `patient_signes_vitaux`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `patient_suivis`
--
ALTER TABLE `patient_suivis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `patient_traitements`
--
ALTER TABLE `patient_traitements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `pharmacies`
--
ALTER TABLE `pharmacies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `pharmacie_clients`
--
ALTER TABLE `pharmacie_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pharmacie_operations`
--
ALTER TABLE `pharmacie_operations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `pharmacie_tickets`
--
ALTER TABLE `pharmacie_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pharmacist_sessions`
--
ALTER TABLE `pharmacist_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit_categories`
--
ALTER TABLE `produit_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit_prices`
--
ALTER TABLE `produit_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `produit_types`
--
ALTER TABLE `produit_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `produit_unites`
--
ALTER TABLE `produit_unites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `transfert_patients`
--
ALTER TABLE `transfert_patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
