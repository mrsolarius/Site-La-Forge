-- -----------------------------------------------------------------------------
--             Génération d'une base de données pour
--                           PostgreSQL
--                        (5/5/2019 10:10:26)
-- -----------------------------------------------------------------------------
--      Nom de la base : MLR2
--      Projet : 
--      Auteur : VOLAT
--      Date de dernière modification : 5/5/2019 10:10:10
-- -----------------------------------------------------------------------------

drop database MLR2;
-- -----------------------------------------------------------------------------
--       CREATION DE LA BASE 
-- -----------------------------------------------------------------------------

CREATE DATABASE MLR2;

-- -----------------------------------------------------------------------------
--       TABLE : CATEGORIE
-- -----------------------------------------------------------------------------

CREATE TABLE CATEGORIE
   (
    ID_CAT serial NOT NULL  ,
    ID_PHOTO int4 NOT NULL  ,
    LABEL_CAT varchar(50) NULL  ,
    DESCRIPTION_CAT varchar(280) NULL  
,   CONSTRAINT PK_CATEGORIE PRIMARY KEY (ID_CAT)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE CATEGORIE
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_CATEGORIE_PHOTO
     ON CATEGORIE (ID_PHOTO)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : COMMENTAIRE
-- -----------------------------------------------------------------------------

CREATE TABLE COMMENTAIRE
   (
    ID_COM serial NOT NULL  ,
    ID_ARTICLE int4 NOT NULL  ,
    ID_CLIENT int4 NOT NULL  ,
    TITRE_COM varchar(35) NULL  ,
    DESCRIPTION_COM text NULL  ,
    NOTE_COM int4 NULL  
,   CONSTRAINT PK_COMMENTAIRE PRIMARY KEY (ID_COM)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE COMMENTAIRE
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_COMMENTAIRE_ARTICLE
     ON COMMENTAIRE (ID_ARTICLE)
    ;

CREATE  INDEX I_FK_COMMENTAIRE_CLIENT
     ON COMMENTAIRE (ID_CLIENT)
    ;
-- -----------------------------------------------------------------------------
--       TABLE : COMMANDE
-- -----------------------------------------------------------------------------

CREATE TABLE COMMANDE
   (
    ID_COMENDE serial NOT NULL  ,
    ID_CLIENT int4 NOT NULL  ,
    DATE_COMANDE date NULL  ,
    DATE_LIVRAISON date NULL  
,   CONSTRAINT PK_COMMANDE PRIMARY KEY (ID_COMENDE)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE COMMANDE
-- -----------------------------------------------------------------------------


CREATE  INDEX I_FK_COMMANDE_CLIENT
     ON COMMANDE (ID_CLIENT)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : PHOTO
-- -----------------------------------------------------------------------------

CREATE TABLE PHOTO
   (
    ID_PHOTO serial NOT NULL  ,
    CHEMIN_PHOTO varchar(200) NULL  ,
    EXT_PHOTO varchar(10) NULL  ,
    TITRE_PHOTO varchar(50) NULL  ,
    ALT_PHOTO varchar(100) NULL  
,   CONSTRAINT PK_PHOTO PRIMARY KEY (ID_PHOTO)
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : CLIENT
-- -----------------------------------------------------------------------------

CREATE TABLE CLIENT
   (
    ID_CLIENT serial NOT NULL  ,
    ID_PHOTO int4 NULL  ,
    NOM_CLIENT varchar(50) NULL  ,
    PRENOM_CLIENT varchar(20) NULL  ,
    MAIL_CLIENT varchar(100) UNIQUE NOT NULL ,
    MDP_CLIENT char(32) NOT NULL  ,
    RUE_CLIENT varchar(100) NULL  ,
    TEL_CLIENT char(14) NULL  ,
    VILLE_CLIENT varchar(100) NULL  ,
    CP_CLIENT char(32) NULL  ,
    ADMINISTRATEUR bool NULL  
,   CONSTRAINT PK_CLIENT PRIMARY KEY (ID_CLIENT)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE CLIENT
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_CLIENT_PHOTO
     ON CLIENT (ID_PHOTO)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : ARTICLE
-- -----------------------------------------------------------------------------

CREATE TABLE ARTICLE
   (
    ID_ARTICLE serial NOT NULL  ,
    ID_CAT int4 NOT NULL  ,
    LABEL_ARTICLE varchar(100) NULL  ,
    PRIX_ARTICLE money NULL  ,
    DESC_ARTICLE text NULL  ,
    STOCK_ARTICLE int4 NULL  
,   CONSTRAINT PK_ARTICLE PRIMARY KEY (ID_ARTICLE)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE ARTICLE
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_ARTICLE_CATEGORIE
     ON ARTICLE (ID_CAT)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : IMAGER
-- -----------------------------------------------------------------------------

CREATE TABLE IMAGER
   (
    ID_COM int4 NOT NULL  ,
    ID_PHOTO int4 NOT NULL  
,   CONSTRAINT PK_IMAGER PRIMARY KEY (ID_COM, ID_PHOTO)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE IMAGER
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_IMAGER_COMMENTAIRE
     ON IMAGER (ID_COM)
    ;

CREATE  INDEX I_FK_IMAGER_PHOTO
     ON IMAGER (ID_PHOTO)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : COMPOSER
-- -----------------------------------------------------------------------------

CREATE TABLE COMPOSER
   (
    ID_ARTICLE int4 NOT NULL  ,
    ID_COMENDE int4 NOT NULL  ,
    QTE_ARTICLE_FACTURE int4 NULL ,
    prix_unite money NOT NULL
,   CONSTRAINT PK_COMPOSER PRIMARY KEY (ID_ARTICLE, ID_COMENDE)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE COMPOSER
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_COMPOSER_ARTICLE
     ON COMPOSER (ID_ARTICLE)
    ;

CREATE  INDEX I_FK_COMPOSER_COMMANDE
     ON COMPOSER (ID_COMENDE)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : MONTRER
-- -----------------------------------------------------------------------------

CREATE TABLE MONTRER
   (
    ID_PHOTO int4 NOT NULL  ,
    ID_ARTICLE int4 NOT NULL  
,   CONSTRAINT PK_MONTRER PRIMARY KEY (ID_PHOTO, ID_ARTICLE)
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE MONTRER
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_MONTRER_PHOTO
     ON MONTRER (ID_PHOTO)
    ;

CREATE  INDEX I_FK_MONTRER_ARTICLE
     ON MONTRER (ID_ARTICLE) ON DELETE CASCADE
    ;


-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------


ALTER TABLE CATEGORIE ADD 
     CONSTRAINT FK_CATEGORIE_PHOTO
          FOREIGN KEY (ID_PHOTO)
               REFERENCES PHOTO (ID_PHOTO);

ALTER TABLE COMMENTAIRE ADD 
     CONSTRAINT FK_COMMENTAIRE_ARTICLE
          FOREIGN KEY (ID_ARTICLE)
               REFERENCES ARTICLE (ID_ARTICLE);

ALTER TABLE COMMENTAIRE ADD 
     CONSTRAINT FK_COMMENTAIRE_CLIENT
          FOREIGN KEY (ID_CLIENT)
               REFERENCES CLIENT (ID_CLIENT);

ALTER TABLE COMMANDE ADD 
     CONSTRAINT FK_COMMANDE_CLIENT
          FOREIGN KEY (ID_CLIENT)
               REFERENCES CLIENT (ID_CLIENT);

ALTER TABLE CLIENT ADD 
     CONSTRAINT FK_CLIENT_PHOTO
          FOREIGN KEY (ID_PHOTO)
               REFERENCES PHOTO (ID_PHOTO);

ALTER TABLE ARTICLE ADD 
     CONSTRAINT FK_ARTICLE_CATEGORIE
          FOREIGN KEY (ID_CAT)
               REFERENCES CATEGORIE (ID_CAT);

ALTER TABLE IMAGER ADD 
     CONSTRAINT FK_IMAGER_COMMENTAIRE
          FOREIGN KEY (ID_COM)
               REFERENCES COMMENTAIRE (ID_COM);

ALTER TABLE IMAGER ADD 
     CONSTRAINT FK_IMAGER_PHOTO
          FOREIGN KEY (ID_PHOTO)
               REFERENCES PHOTO (ID_PHOTO);

ALTER TABLE COMPOSER ADD 
     CONSTRAINT FK_COMPOSER_ARTICLE
          FOREIGN KEY (ID_ARTICLE)
               REFERENCES ARTICLE (ID_ARTICLE);

ALTER TABLE COMPOSER ADD 
     CONSTRAINT FK_COMPOSER_COMMANDE
          FOREIGN KEY (ID_COMENDE)
               REFERENCES COMMANDE (ID_COMENDE);

ALTER TABLE MONTRER ADD 
     CONSTRAINT FK_MONTRER_PHOTO
          FOREIGN KEY (ID_PHOTO)
               REFERENCES PHOTO (ID_PHOTO);

ALTER TABLE MONTRER ADD 
     CONSTRAINT FK_MONTRER_ARTICLE
          FOREIGN KEY (ID_ARTICLE)
               REFERENCES ARTICLE (ID_ARTICLE);


Create table Panier(
	id_article integer,
	id_client integer,
	qte integer,
	CONSTRAINT fk_article
	foreign key(id_article) REFERENCES article(id_article),
	CONSTRAINT fk_client
	foreign key(id_client) REFERENCES client(id_client),
	CONSTRAINT pk_client_article primary key (id_article,id_client)
)
-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------