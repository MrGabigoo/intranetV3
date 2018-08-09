<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180612161112 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('CREATE TABLE annee (id INT AUTO_INCREMENT NOT NULL, diplome_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, ordre INT NOT NULL, couleurCM VARCHAR(7) DEFAULT NULL, couleurTD VARCHAR(7) DEFAULT NULL, couleurTP VARCHAR(7) DEFAULT NULL, couleurtexte VARCHAR(7) DEFAULT NULL, libelle_long VARCHAR(150) DEFAULT NULL, code_apogee VARCHAR(20) NOT NULL, code_version VARCHAR(10) NOT NULL, code_departement VARCHAR(10) NOT NULL, opt_alternance TINYINT(1) NOT NULL, INDEX IDX_DE92C5CF26F859E2 (diplome_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, roles LONGTEXT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, statut VARCHAR(10) NOT NULL, poste_interne VARCHAR(10) DEFAULT NULL, tel_bureau VARCHAR(20) DEFAULT NULL, responsabilites LONGTEXT DEFAULT NULL, domaines LONGTEXT DEFAULT NULL, entreprise VARCHAR(255) DEFAULT NULL, bureau1 VARCHAR(20) DEFAULT NULL, bureau2 VARCHAR(20) DEFAULT NULL, numero_harpege INT DEFAULT NULL, initiales VARCHAR(10) DEFAULT NULL, cv VARCHAR(50) DEFAULT NULL, cv_name VARCHAR(50) NOT NULL, nb_heures_service DOUBLE PRECISION NOT NULL, username VARCHAR(75) NOT NULL, password VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, type_user VARCHAR(75) NOT NULL, nom VARCHAR(75) NOT NULL, prenom VARCHAR(75) NOT NULL, mail_univ VARCHAR(255) NOT NULL, site_univ VARCHAR(255) DEFAULT NULL, mail_perso VARCHAR(255) DEFAULT NULL, site_perso VARCHAR(255) DEFAULT NULL, sexe VARCHAR(1) DEFAULT \'M\' NOT NULL, date_naissance DATE DEFAULT NULL, tel1 VARCHAR(20) DEFAULT NULL, tel2 VARCHAR(20) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, signature LONGTEXT DEFAULT NULL, visible TINYINT(1) NOT NULL, photo VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_A6BCF3DE4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(75) NOT NULL, INDEX IDX_1596AD8A5200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, type_document_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, taille DOUBLE PRECISION NOT NULL, type_fichier VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, libelle VARCHAR(100) NOT NULL, document_name VARCHAR(50) NOT NULL, INDEX IDX_D8698A768826AFA6 (type_document_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_semestre (document_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_FEA97EE5C33F7837 (document_id), INDEX IDX_FEA97EE55577AFDB (semestre_id), PRIMARY KEY(document_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diplome (id INT AUTO_INCREMENT NOT NULL, responsable_diplome_id INT DEFAULT NULL, assistant_diplome_id INT DEFAULT NULL, type_diplome_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, code_apogee VARCHAR(20) NOT NULL, code_version VARCHAR(10) NOT NULL, code_departement VARCHAR(10) NOT NULL, opt_nb_jours_saisie INT NOT NULL, opt_dilpome_decale TINYINT(1) NOT NULL, opt_suppr_absence TINYINT(1) NOT NULL, opt_methode_calcul VARCHAR(10) NOT NULL, opt_anonymat TINYINT(1) NOT NULL, opt_commentaires_releve TINYINT(1) NOT NULL, opt_espace_perso_visible TINYINT(1) NOT NULL, volume_horaire INT NOT NULL, code_celcat_departement INT NOT NULL, INDEX IDX_EB4C4D4ED2D1AAE2 (responsable_diplome_id), INDEX IDX_EB4C4D4E39A24FD8 (assistant_diplome_id), INDEX IDX_EB4C4D4E3BFB8FC7 (type_diplome_id), INDEX IDX_EB4C4D4E5200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parcour (id INT AUTO_INCREMENT NOT NULL, semestre_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_B7E529565577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, adresse1 VARCHAR(255) NOT NULL, adresse2 VARCHAR(255) DEFAULT NULL, adresse3 VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(10) NOT NULL, ville VARCHAR(100) NOT NULL, pays VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courrier (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, texte LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, evaluation_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, note DOUBLE PRECISION NOT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_CFBDFA14456C5646 (evaluation_id), INDEX IDX_CFBDFA14DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, personnel_auteur_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, date_evaluation DATE NOT NULL, anneeuniversitaire INT NOT NULL, visible TINYINT(1) NOT NULL, modifiable TINYINT(1) NOT NULL, coefficient DOUBLE PRECISION NOT NULL, commentaire VARCHAR(255) NOT NULL, INDEX IDX_1323A575F46CD258 (matiere_id), INDEX IDX_1323A57566A6ABE2 (personnel_auteur_id), INDEX IDX_1323A575727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_personnel (evaluation_id INT NOT NULL, personnel_id INT NOT NULL, INDEX IDX_74BC385A456C5646 (evaluation_id), INDEX IDX_74BC385A1C109075 (personnel_id), PRIMARY KEY(evaluation_id, personnel_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ue (id INT AUTO_INCREMENT NOT NULL, semestre_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, numero_ue INT NOT NULL, coefficient DOUBLE PRECISION NOT NULL, nb_ects DOUBLE PRECISION NOT NULL, code_apogee VARCHAR(20) NOT NULL, code_version VARCHAR(10) NOT NULL, code_departement VARCHAR(10) NOT NULL, INDEX IDX_2E490A9B5577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE previsionnel (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, personnel_id INT DEFAULT NULL, annee INT NOT NULL, referent TINYINT(1) NOT NULL, nb_hcm DOUBLE PRECISION NOT NULL, nb_htd DOUBLE PRECISION NOT NULL, nb_htp DOUBLE PRECISION NOT NULL, nb_gr_cm INT NOT NULL, nb_gr_td INT NOT NULL, nb_gr_tp INT NOT NULL, INDEX IDX_AE25C261F46CD258 (matiere_id), INDEX IDX_AE25C2611C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ppn (id INT AUTO_INCREMENT NOT NULL, diplome_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, annee INT NOT NULL, INDEX IDX_2E8584EB26F859E2 (diplome_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cahier_texte (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, semestre_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(150) NOT NULL, description LONGTEXT NOT NULL, date_retour DATETIME NOT NULL, INDEX IDX_B554C6181C109075 (personnel_id), INDEX IDX_B554C6185577AFDB (semestre_id), INDEX IDX_B554C618F46CD258 (matiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cahier_texte_fichier (cahier_texte_id INT NOT NULL, fichier_id INT NOT NULL, INDEX IDX_A095F9C885D2D268 (cahier_texte_id), INDEX IDX_A095F9C8F915CFE (fichier_id), PRIMARY KEY(cahier_texte_id, fichier_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modification_note (id INT AUTO_INCREMENT NOT NULL, note_id INT DEFAULT NULL, personnel_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, ancienne_note DOUBLE PRECISION NOT NULL, nouvelle_note DOUBLE PRECISION NOT NULL, INDEX IDX_607975E526ED0855 (note_id), INDEX IDX_607975E51C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rattrapage (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, personnel_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, date_eval DATE NOT NULL, heure_eval TIME NOT NULL, duree VARCHAR(20) NOT NULL, date_rattrapage DATE DEFAULT NULL, heure_rattrapage TIME DEFAULT NULL, salle VARCHAR(10) DEFAULT NULL, etat_demande VARCHAR(1) NOT NULL, anneeuniversitaire INT NOT NULL, INDEX IDX_BDE5586DDDEAB1A3 (etudiant_id), INDEX IDX_BDE5586DF46CD258 (matiere_id), INDEX IDX_BDE5586D1C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hrs (id INT AUTO_INCREMENT NOT NULL, semestre_id INT DEFAULT NULL, diplome_id INT DEFAULT NULL, personnel_id INT DEFAULT NULL, type_hrs_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, nb_heures_td DOUBLE PRECISION NOT NULL, libelle VARCHAR(150) NOT NULL, annee INT NOT NULL, INDEX IDX_6D8078785577AFDB (semestre_id), INDEX IDX_6D80787826F859E2 (diplome_id), INDEX IDX_6D8078781C109075 (personnel_id), INDEX IDX_6D807878152AE753 (type_hrs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuration (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, cle VARCHAR(50) NOT NULL, valeur VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ufr (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ufr_site (ufr_id INT NOT NULL, site_id INT NOT NULL, INDEX IDX_DD5A1B6AA469CB09 (ufr_id), INDEX IDX_DD5A1B6AF6BD1646 (site_id), PRIMARY KEY(ufr_id, site_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, semestre_id INT DEFAULT NULL, adresse_parentale_id INT DEFAULT NULL, roles LONGTEXT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, num_etudiant VARCHAR(20) NOT NULL, num_ine VARCHAR(20) NOT NULL, bac VARCHAR(30) DEFAULT NULL, annee_bac INT DEFAULT NULL, username VARCHAR(75) NOT NULL, password VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, type_user VARCHAR(75) NOT NULL, nom VARCHAR(75) NOT NULL, prenom VARCHAR(75) NOT NULL, mail_univ VARCHAR(255) NOT NULL, site_univ VARCHAR(255) DEFAULT NULL, mail_perso VARCHAR(255) DEFAULT NULL, site_perso VARCHAR(255) DEFAULT NULL, sexe VARCHAR(1) DEFAULT \'M\' NOT NULL, date_naissance DATE DEFAULT NULL, tel1 VARCHAR(20) DEFAULT NULL, tel2 VARCHAR(20) DEFAULT NULL, remarque LONGTEXT DEFAULT NULL, signature LONGTEXT DEFAULT NULL, visible TINYINT(1) NOT NULL, photo VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_717E22E34DE7DC5C (adresse_id), INDEX IDX_717E22E35577AFDB (semestre_id), UNIQUE INDEX UNIQ_717E22E3CD22752C (adresse_parentale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE favori (id INT AUTO_INCREMENT NOT NULL, etudiant_demandeur_id INT DEFAULT NULL, etudiant_demande_id INT DEFAULT NULL, date_ajout DATETIME NOT NULL, INDEX IDX_EF85A2CC9D7BCD43 (etudiant_demandeur_id), INDEX IDX_EF85A2CC4E463162 (etudiant_demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_groupe (id INT AUTO_INCREMENT NOT NULL, semestre_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(100) NOT NULL, code_apogee VARCHAR(50) NOT NULL, type VARCHAR(5) NOT NULL, INDEX IDX_276EE7195577AFDB (semestre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnel_formation (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, annee INT NOT NULL, INDEX IDX_465DE5BB1C109075 (personnel_id), INDEX IDX_465DE5BB5200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, texte LONGTEXT DEFAULT NULL, date_debut DATE NOT NULL, heure_debut TIME DEFAULT NULL, date_fin DATE NOT NULL, heure_fin TIME DEFAULT NULL, lieu VARCHAR(150) NOT NULL, allday TINYINT(1) NOT NULL, qui VARCHAR(1) NOT NULL, type VARCHAR(30) NOT NULL, INDEX IDX_AA9E377A5200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date_semestre (date_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_B25DE61AB897366B (date_id), INDEX IDX_B25DE61A5577AFDB (semestre_id), PRIMARY KEY(date_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE help (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, titre VARCHAR(255) NOT NULL, texte LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(30) NOT NULL, capacite INT NOT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_4E977E5CF6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scolarite (id INT AUTO_INCREMENT NOT NULL, semestre_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, ordre INT NOT NULL, decision VARCHAR(10) NOT NULL, proposition VARCHAR(10) DEFAULT NULL, moyenne DOUBLE PRECISION NOT NULL, nb_absences INT NOT NULL, commentaire LONGTEXT DEFAULT NULL, INDEX IDX_276250AB5577AFDB (semestre_id), INDEX IDX_276250ABDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matiere (id INT AUTO_INCREMENT NOT NULL, ue_id INT DEFAULT NULL, ppn_id INT DEFAULT NULL, parcours_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, code_apogee VARCHAR(20) NOT NULL, code_version VARCHAR(10) NOT NULL, code_departement VARCHAR(10) NOT NULL, code_matiere VARCHAR(20) NOT NULL, cm_ppn DOUBLE PRECISION NOT NULL, td_ppn DOUBLE PRECISION NOT NULL, tp_ppn DOUBLE PRECISION NOT NULL, cm_formation DOUBLE PRECISION NOT NULL, td_formation DOUBLE PRECISION NOT NULL, tp_formation DOUBLE PRECISION NOT NULL, commentaire LONGTEXT DEFAULT NULL, nb_notes INT NOT NULL, coefficient DOUBLE PRECISION NOT NULL, pac TINYINT(1) NOT NULL, nb_ects DOUBLE PRECISION NOT NULL, objectifs_module LONGTEXT DEFAULT NULL, competences_visees LONGTEXT DEFAULT NULL, contenu LONGTEXT DEFAULT NULL, pre_requis LONGTEXT DEFAULT NULL, modalites LONGTEXT DEFAULT NULL, prolongements LONGTEXT DEFAULT NULL, mots_cles LONGTEXT DEFAULT NULL, suspendu TINYINT(1) NOT NULL, INDEX IDX_9014574A62E883B1 (ue_id), INDEX IDX_9014574A1CBD0BF (ppn_id), INDEX IDX_9014574A6E38C0DB (parcours_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borne (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, icone VARCHAR(20) NOT NULL, couleur VARCHAR(20) NOT NULL, message LONGTEXT NOT NULL, url VARCHAR(255) DEFAULT NULL, date_debut_publication DATETIME NOT NULL, date_fin_publication DATETIME NOT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE borne_semestre (borne_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_D1378E3B7F023A56 (borne_id), INDEX IDX_D1378E3B5577AFDB (semestre_id), PRIMARY KEY(borne_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_hrs (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(100) NOT NULL, type VARCHAR(20) NOT NULL, inclu_service TINYINT(1) NOT NULL, maximum DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE absence (id INT AUTO_INCREMENT NOT NULL, personnel_id INT DEFAULT NULL, matiere_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, date DATE NOT NULL, heure TIME NOT NULL, duree TIME NOT NULL, justifie TINYINT(1) NOT NULL, anneeuniversitaire INT NOT NULL, INDEX IDX_765AE0C91C109075 (personnel_id), INDEX IDX_765AE0C9F46CD258 (matiere_id), INDEX IDX_765AE0C9DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE semestre (id INT AUTO_INCREMENT NOT NULL, annee_id INT DEFAULT NULL, precedent_id INT DEFAULT NULL, suivant_id INT DEFAULT NULL, decale_id INT DEFAULT NULL, opt_dest_mail_releve_id INT DEFAULT NULL, opt_dest_mail_modif_note_id INT DEFAULT NULL, opt_dest_mail_absence_resp_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, code_apogee VARCHAR(20) NOT NULL, code_version VARCHAR(10) NOT NULL, code_departement VARCHAR(10) NOT NULL, couleur VARCHAR(20) DEFAULT NULL, ordre_annee INT NOT NULL, ordre_lmd INT NOT NULL, actif TINYINT(1) NOT NULL, nb_groupes_td INT NOT NULL, nb_groupes_tp INT NOT NULL, opt_mail_releve TINYINT(1) NOT NULL, opt_mail_modification_note TINYINT(1) NOT NULL, opt_evaluation_visible TINYINT(1) NOT NULL, opt_evaluation_modifiable TINYINT(1) NOT NULL, opt_penalite_absence TINYINT(1) NOT NULL, opt_mail_absence_resp TINYINT(1) NOT NULL, opt_mail_absence_etudiant TINYINT(1) NOT NULL, opt_point_penalite_absence DOUBLE PRECISION NOT NULL, mois_debut INT NOT NULL, INDEX IDX_71688FBC543EC5F0 (annee_id), INDEX IDX_71688FBC4F6564F9 (precedent_id), INDEX IDX_71688FBC9C2BB0CC (suivant_id), INDEX IDX_71688FBCCF416101 (decale_id), INDEX IDX_71688FBCE2F2E760 (opt_dest_mail_releve_id), INDEX IDX_71688FBC9266B8BA (opt_dest_mail_modif_note_id), INDEX IDX_71688FBCF782170E (opt_dest_mail_absence_resp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_diplome (id INT AUTO_INCREMENT NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, sigle VARCHAR(20) NOT NULL, nb_semestres INT NOT NULL, niveau_entree INT NOT NULL, niveau_sortie INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, respri_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, logo_name VARCHAR(50) NOT NULL, annee_courante INT NOT NULL, tel_contact VARCHAR(16) DEFAULT NULL, fax VARCHAR(16) DEFAULT NULL, couleur VARCHAR(16) DEFAULT NULL, site_web VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, opt_update_celcat TINYINT(1) NOT NULL, opt_agence TINYINT(1) NOT NULL, opt_materiel TINYINT(1) NOT NULL, opt_edt TINYINT(1) NOT NULL, opt_stage TINYINT(1) NOT NULL, opt_synthese TINYINT(1) NOT NULL, opt_messagerie TINYINT(1) NOT NULL, opt_infos TINYINT(1) NOT NULL, opt_annee_previsionnel INT NOT NULL, INDEX IDX_404021BFF6BD1646 (site_id), INDEX IDX_404021BF2AC98151 (respri_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, type_groupe_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(50) NOT NULL, code_apogee VARCHAR(50) NOT NULL, INDEX IDX_4B98C21CE83749C (type_groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, personnel_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, type VARCHAR(100) NOT NULL, url VARCHAR(255) NOT NULL, lu TINYINT(1) NOT NULL, type_user VARCHAR(1) NOT NULL, INDEX IDX_BF5476CADDEAB1A3 (etudiant_id), INDEX IDX_BF5476CA1C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, personnel_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, titre VARCHAR(255) NOT NULL, nb_like INT NOT NULL, texte LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, type VARCHAR(20) NOT NULL, INDEX IDX_23A0E665200282E (formation_id), INDEX IDX_23A0E661C109075 (personnel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_semestre (article_id INT NOT NULL, semestre_id INT NOT NULL, INDEX IDX_24807BD77294869C (article_id), INDEX IDX_24807BD75577AFDB (semestre_id), PRIMARY KEY(article_id, semestre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, titre VARCHAR(150) NOT NULL, texte LONGTEXT NOT NULL, INDEX IDX_549281975200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, taille DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, adresse_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_694309E44DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_tache (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, deadline DATETIME NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_2589CEE05200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trello_tache_personnel (trello_tache_id INT NOT NULL, personnel_id INT NOT NULL, INDEX IDX_7D360FA2EBED4F1 (trello_tache_id), INDEX IDX_7D360FA21C109075 (personnel_id), PRIMARY KEY(trello_tache_id, personnel_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, diplome_id INT DEFAULT NULL, parent_id INT DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, code VARCHAR(20) NOT NULL, INDEX IDX_94D4687F26F859E2 (diplome_id), INDEX IDX_94D4687F727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annee ADD CONSTRAINT FK_DE92C5CF26F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE personnel ADD CONSTRAINT FK_A6BCF3DE4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE type_document ADD CONSTRAINT FK_1596AD8A5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A768826AFA6 FOREIGN KEY (type_document_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE document_semestre ADD CONSTRAINT FK_FEA97EE5C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_semestre ADD CONSTRAINT FK_FEA97EE55577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4ED2D1AAE2 FOREIGN KEY (responsable_diplome_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4E39A24FD8 FOREIGN KEY (assistant_diplome_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4E3BFB8FC7 FOREIGN KEY (type_diplome_id) REFERENCES type_diplome (id)');
        $this->addSql('ALTER TABLE diplome ADD CONSTRAINT FK_EB4C4D4E5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE parcour ADD CONSTRAINT FK_B7E529565577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57566A6ABE2 FOREIGN KEY (personnel_auteur_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575727ACA70 FOREIGN KEY (parent_id) REFERENCES evaluation (id)');
        $this->addSql('ALTER TABLE evaluation_personnel ADD CONSTRAINT FK_74BC385A456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_personnel ADD CONSTRAINT FK_74BC385A1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ue ADD CONSTRAINT FK_2E490A9B5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE previsionnel ADD CONSTRAINT FK_AE25C261F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE previsionnel ADD CONSTRAINT FK_AE25C2611C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE ppn ADD CONSTRAINT FK_2E8584EB26F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE cahier_texte ADD CONSTRAINT FK_B554C6181C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE cahier_texte ADD CONSTRAINT FK_B554C6185577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE cahier_texte ADD CONSTRAINT FK_B554C618F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE cahier_texte_fichier ADD CONSTRAINT FK_A095F9C885D2D268 FOREIGN KEY (cahier_texte_id) REFERENCES cahier_texte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cahier_texte_fichier ADD CONSTRAINT FK_A095F9C8F915CFE FOREIGN KEY (fichier_id) REFERENCES fichier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modification_note ADD CONSTRAINT FK_607975E526ED0855 FOREIGN KEY (note_id) REFERENCES note (id)');
        $this->addSql('ALTER TABLE modification_note ADD CONSTRAINT FK_607975E51C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE rattrapage ADD CONSTRAINT FK_BDE5586DDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE rattrapage ADD CONSTRAINT FK_BDE5586DF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE rattrapage ADD CONSTRAINT FK_BDE5586D1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE hrs ADD CONSTRAINT FK_6D8078785577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE hrs ADD CONSTRAINT FK_6D80787826F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE hrs ADD CONSTRAINT FK_6D8078781C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE hrs ADD CONSTRAINT FK_6D807878152AE753 FOREIGN KEY (type_hrs_id) REFERENCES type_hrs (id)');
        $this->addSql('ALTER TABLE ufr_site ADD CONSTRAINT FK_DD5A1B6AA469CB09 FOREIGN KEY (ufr_id) REFERENCES ufr (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ufr_site ADD CONSTRAINT FK_DD5A1B6AF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E35577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3CD22752C FOREIGN KEY (adresse_parentale_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC9D7BCD43 FOREIGN KEY (etudiant_demandeur_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE favori ADD CONSTRAINT FK_EF85A2CC4E463162 FOREIGN KEY (etudiant_demande_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE type_groupe ADD CONSTRAINT FK_276EE7195577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE personnel_formation ADD CONSTRAINT FK_465DE5BB1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE personnel_formation ADD CONSTRAINT FK_465DE5BB5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE date ADD CONSTRAINT FK_AA9E377A5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE date_semestre ADD CONSTRAINT FK_B25DE61AB897366B FOREIGN KEY (date_id) REFERENCES date (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE date_semestre ADD CONSTRAINT FK_B25DE61A5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle ADD CONSTRAINT FK_4E977E5CF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250AB5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE scolarite ADD CONSTRAINT FK_276250ABDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A62E883B1 FOREIGN KEY (ue_id) REFERENCES ue (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A1CBD0BF FOREIGN KEY (ppn_id) REFERENCES ppn (id)');
        $this->addSql('ALTER TABLE matiere ADD CONSTRAINT FK_9014574A6E38C0DB FOREIGN KEY (parcours_id) REFERENCES parcour (id)');
        $this->addSql('ALTER TABLE borne_semestre ADD CONSTRAINT FK_D1378E3B7F023A56 FOREIGN KEY (borne_id) REFERENCES borne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE borne_semestre ADD CONSTRAINT FK_D1378E3B5577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C91C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9F46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE absence ADD CONSTRAINT FK_765AE0C9DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBC543EC5F0 FOREIGN KEY (annee_id) REFERENCES annee (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBC4F6564F9 FOREIGN KEY (precedent_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBC9C2BB0CC FOREIGN KEY (suivant_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBCCF416101 FOREIGN KEY (decale_id) REFERENCES semestre (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBCE2F2E760 FOREIGN KEY (opt_dest_mail_releve_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBC9266B8BA FOREIGN KEY (opt_dest_mail_modif_note_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE semestre ADD CONSTRAINT FK_71688FBCF782170E FOREIGN KEY (opt_dest_mail_absence_resp_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF2AC98151 FOREIGN KEY (respri_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21CE83749C FOREIGN KEY (type_groupe_id) REFERENCES type_groupe (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA1C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id)');
        $this->addSql('ALTER TABLE article_semestre ADD CONSTRAINT FK_24807BD77294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_semestre ADD CONSTRAINT FK_24807BD75577AFDB FOREIGN KEY (semestre_id) REFERENCES semestre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actualite ADD CONSTRAINT FK_549281975200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E44DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE trello_tache ADD CONSTRAINT FK_2589CEE05200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE trello_tache_personnel ADD CONSTRAINT FK_7D360FA2EBED4F1 FOREIGN KEY (trello_tache_id) REFERENCES trello_tache (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trello_tache_personnel ADD CONSTRAINT FK_7D360FA21C109075 FOREIGN KEY (personnel_id) REFERENCES personnel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F26F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id)');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F727ACA70 FOREIGN KEY (parent_id) REFERENCES competence (id)');
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBC543EC5F0');
        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4ED2D1AAE2');
        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4E39A24FD8');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57566A6ABE2');
        $this->addSql('ALTER TABLE evaluation_personnel DROP FOREIGN KEY FK_74BC385A1C109075');
        $this->addSql('ALTER TABLE previsionnel DROP FOREIGN KEY FK_AE25C2611C109075');
        $this->addSql('ALTER TABLE cahier_texte DROP FOREIGN KEY FK_B554C6181C109075');
        $this->addSql('ALTER TABLE modification_note DROP FOREIGN KEY FK_607975E51C109075');
        $this->addSql('ALTER TABLE rattrapage DROP FOREIGN KEY FK_BDE5586D1C109075');
        $this->addSql('ALTER TABLE hrs DROP FOREIGN KEY FK_6D8078781C109075');
        $this->addSql('ALTER TABLE personnel_formation DROP FOREIGN KEY FK_465DE5BB1C109075');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C91C109075');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBCE2F2E760');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBC9266B8BA');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBCF782170E');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF2AC98151');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA1C109075');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661C109075');
        $this->addSql('ALTER TABLE trello_tache_personnel DROP FOREIGN KEY FK_7D360FA21C109075');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A768826AFA6');
        $this->addSql('ALTER TABLE document_semestre DROP FOREIGN KEY FK_FEA97EE5C33F7837');
        $this->addSql('ALTER TABLE annee DROP FOREIGN KEY FK_DE92C5CF26F859E2');
        $this->addSql('ALTER TABLE ppn DROP FOREIGN KEY FK_2E8584EB26F859E2');
        $this->addSql('ALTER TABLE hrs DROP FOREIGN KEY FK_6D80787826F859E2');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F26F859E2');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A6E38C0DB');
        $this->addSql('ALTER TABLE personnel DROP FOREIGN KEY FK_A6BCF3DE4DE7DC5C');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E34DE7DC5C');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3CD22752C');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E44DE7DC5C');
        $this->addSql('ALTER TABLE modification_note DROP FOREIGN KEY FK_607975E526ED0855');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14456C5646');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575727ACA70');
        $this->addSql('ALTER TABLE evaluation_personnel DROP FOREIGN KEY FK_74BC385A456C5646');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A62E883B1');
        $this->addSql('ALTER TABLE matiere DROP FOREIGN KEY FK_9014574A1CBD0BF');
        $this->addSql('ALTER TABLE cahier_texte_fichier DROP FOREIGN KEY FK_A095F9C885D2D268');
        $this->addSql('ALTER TABLE ufr_site DROP FOREIGN KEY FK_DD5A1B6AA469CB09');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE rattrapage DROP FOREIGN KEY FK_BDE5586DDDEAB1A3');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC9D7BCD43');
        $this->addSql('ALTER TABLE favori DROP FOREIGN KEY FK_EF85A2CC4E463162');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250ABDDEAB1A3');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9DDEAB1A3');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CADDEAB1A3');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21CE83749C');
        $this->addSql('ALTER TABLE date_semestre DROP FOREIGN KEY FK_B25DE61AB897366B');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575F46CD258');
        $this->addSql('ALTER TABLE previsionnel DROP FOREIGN KEY FK_AE25C261F46CD258');
        $this->addSql('ALTER TABLE cahier_texte DROP FOREIGN KEY FK_B554C618F46CD258');
        $this->addSql('ALTER TABLE rattrapage DROP FOREIGN KEY FK_BDE5586DF46CD258');
        $this->addSql('ALTER TABLE absence DROP FOREIGN KEY FK_765AE0C9F46CD258');
        $this->addSql('ALTER TABLE borne_semestre DROP FOREIGN KEY FK_D1378E3B7F023A56');
        $this->addSql('ALTER TABLE hrs DROP FOREIGN KEY FK_6D807878152AE753');
        $this->addSql('ALTER TABLE document_semestre DROP FOREIGN KEY FK_FEA97EE55577AFDB');
        $this->addSql('ALTER TABLE parcour DROP FOREIGN KEY FK_B7E529565577AFDB');
        $this->addSql('ALTER TABLE ue DROP FOREIGN KEY FK_2E490A9B5577AFDB');
        $this->addSql('ALTER TABLE cahier_texte DROP FOREIGN KEY FK_B554C6185577AFDB');
        $this->addSql('ALTER TABLE hrs DROP FOREIGN KEY FK_6D8078785577AFDB');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E35577AFDB');
        $this->addSql('ALTER TABLE type_groupe DROP FOREIGN KEY FK_276EE7195577AFDB');
        $this->addSql('ALTER TABLE date_semestre DROP FOREIGN KEY FK_B25DE61A5577AFDB');
        $this->addSql('ALTER TABLE scolarite DROP FOREIGN KEY FK_276250AB5577AFDB');
        $this->addSql('ALTER TABLE borne_semestre DROP FOREIGN KEY FK_D1378E3B5577AFDB');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBC4F6564F9');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBC9C2BB0CC');
        $this->addSql('ALTER TABLE semestre DROP FOREIGN KEY FK_71688FBCCF416101');
        $this->addSql('ALTER TABLE article_semestre DROP FOREIGN KEY FK_24807BD75577AFDB');
        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4E3BFB8FC7');
        $this->addSql('ALTER TABLE type_document DROP FOREIGN KEY FK_1596AD8A5200282E');
        $this->addSql('ALTER TABLE diplome DROP FOREIGN KEY FK_EB4C4D4E5200282E');
        $this->addSql('ALTER TABLE personnel_formation DROP FOREIGN KEY FK_465DE5BB5200282E');
        $this->addSql('ALTER TABLE date DROP FOREIGN KEY FK_AA9E377A5200282E');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E665200282E');
        $this->addSql('ALTER TABLE actualite DROP FOREIGN KEY FK_549281975200282E');
        $this->addSql('ALTER TABLE trello_tache DROP FOREIGN KEY FK_2589CEE05200282E');
        $this->addSql('ALTER TABLE article_semestre DROP FOREIGN KEY FK_24807BD77294869C');
        $this->addSql('ALTER TABLE cahier_texte_fichier DROP FOREIGN KEY FK_A095F9C8F915CFE');
        $this->addSql('ALTER TABLE ufr_site DROP FOREIGN KEY FK_DD5A1B6AF6BD1646');
        $this->addSql('ALTER TABLE salle DROP FOREIGN KEY FK_4E977E5CF6BD1646');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFF6BD1646');
        $this->addSql('ALTER TABLE trello_tache_personnel DROP FOREIGN KEY FK_7D360FA2EBED4F1');
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F727ACA70');
        $this->addSql('DROP TABLE annee');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('DROP TABLE type_document');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_semestre');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE parcour');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE courrier');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_personnel');
        $this->addSql('DROP TABLE ue');
        $this->addSql('DROP TABLE previsionnel');
        $this->addSql('DROP TABLE ppn');
        $this->addSql('DROP TABLE cahier_texte');
        $this->addSql('DROP TABLE cahier_texte_fichier');
        $this->addSql('DROP TABLE modification_note');
        $this->addSql('DROP TABLE rattrapage');
        $this->addSql('DROP TABLE hrs');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE ufr');
        $this->addSql('DROP TABLE ufr_site');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE favori');
        $this->addSql('DROP TABLE type_groupe');
        $this->addSql('DROP TABLE personnel_formation');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE date_semestre');
        $this->addSql('DROP TABLE help');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE scolarite');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE borne');
        $this->addSql('DROP TABLE borne_semestre');
        $this->addSql('DROP TABLE type_hrs');
        $this->addSql('DROP TABLE absence');
        $this->addSql('DROP TABLE semestre');
        $this->addSql('DROP TABLE type_diplome');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_semestre');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE trello_tache');
        $this->addSql('DROP TABLE trello_tache_personnel');
        $this->addSql('DROP TABLE competence');
    }
}
