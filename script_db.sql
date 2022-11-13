/*==============================================================*/
/* Table : Typecomptes                                          */
/*==============================================================*/
create table typecomptes 
(
   id                   integer                        not null,
   libelle              varchar(254)                   null,
   constraint PK_TYPECOMPTES primary key (id)
);

/*==============================================================*/
/* Table : Typeservices                                         */
/*==============================================================*/
create table typeservices 
(
   id                   integer                        not null,
   libelle              varchar(254)                   null,
   constraint PK_TYPESERVICES primary key (id)
);

/*==============================================================*/
/* Table : Typearticles                                         */
/*==============================================================*/
create table typearticles 
(
   id                   integer                        not null,
   libelle              varchar(254)                   null,
   constraint PK_TYPEARTICLES primary key (id)
);

/*==============================================================*/
/* Table : Comptes                                              */
/*==============================================================*/
create table comptes 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idTypecompte         integer                        not null,
   username             varchar(254)                   null,
   pasword              varchar(254)                   null,
   valpass              varchar(254)                   null,
   mail                 varchar(254)                   null,
   noms                 varchar(254)                   null,
   addresse             varchar(254)                   null,
   phone                varchar(254)                   null,
   etat                 integer                        null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_COMPTES primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Articles                                             */
/*==============================================================*/
create table articles 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idCompte             integer                        not null,
   idTypearticle        integer                        not null,
   libelle              varchar(254)                   null,
   description          text                           null,
   prix                 float                          null,
   oldPrix              float                          null,
   note                 integer                        null,
   quantite             integer                        null,
   remise               integer                        null,
   lienImg              varchar(254)                   null,
   etat                 integer                        null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_ARTICLES primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Faqs                                                 */
/*==============================================================*/
create table faqs 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idCompte             integer                        not null,
   ennonce              varchar(254)                   null,
   reponse              varchar(254)                   null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_FAQS primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Services                                             */
/*==============================================================*/
create table services 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idCompte             integer                        not null,
   idTypeservice        integer                        not null,
   libelle              varchar(254)                   null,
   description          text                           null,
   prix                 float                          null,
   oldPrix              float                          null,
   note                 integer                        null,
   duree                varchar(254)                   null,
   remise               integer                        null,
   lienImg              varchar(254)                   null,
   etat                 integer                        null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_SERVICES primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Planings                                             */
/*==============================================================*/
create table planings 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idService            integer                        not null,
   datePlaning          date                           null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_PLANINGS primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Horaires                                             */
/*==============================================================*/
create table horaires 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idPlaning            integer                        not null,
   heureDeb             time                           null,
   heureFin             time                           null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_HORAIRES primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Medias                                               */
/*==============================================================*/
create table medias 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idArticle            integer                        null,
   idService            integer                        null,
   lienMedia            varchar(254)                   null,
   tailleMedia          integer                        null,
   typeMedia            varchar(254)                   null,
   categMedia           integer                        null,
   etat                 integer                        null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_MEDIAS primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

/*==============================================================*/
/* Table : Specifications                                       */
/*==============================================================*/
create table specifications 
(
   id                   integer                        not null   AUTO_INCREMENT,
   idService            integer                        not null,
   libelle              varchar(254)                   null,
   updated_at           timestamp                      null,
   created_at           timestamp                      null,
   constraint PK_SPECIFICATIONS primary key (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


alter table articles
   add constraint FK_ARTICLES_ASSOCIATI_COMPTES foreign key (idCompte)
      references comptes (id)
      on update CASCADE
      on delete CASCADE;

alter table comptes
   add constraint FK_COMPTES_ASSOCIATI_TYPECOMP foreign key (idTypecompte)
      references typecomptes (id)
      on update CASCADE
      on delete CASCADE;

alter table faqs
   add constraint FK_FAQS_ASSOCIATI_COMPTES foreign key (idCompte)
      references comptes (id)
      on update CASCADE
      on delete CASCADE;

alter table horaires
   add constraint FK_HORAIRES_ASSOCIATI_PLANINGS foreign key (idPlaning)
      references planings (id)
      on update CASCADE
      on delete CASCADE;

alter table medias
   add constraint FK_MEDIAS_ASSOCIATI_ARTICLES foreign key (idArticle)
      references articles (id)
      on update CASCADE
      on delete CASCADE;

alter table medias
   add constraint FK_MEDIAS_ASSOCIATI_SERVICES foreign key (idService)
      references services (id)
      on update CASCADE
      on delete CASCADE;

alter table planings
   add constraint FK_PLANINGS_ASSOCIATI_SERVICES foreign key (idService)
      references services (id)
      on update CASCADE
      on delete CASCADE;

alter table services
   add constraint FK_SERVICES_ASSOCIATI_COMPTES foreign key (idCompte)
      references comptes (id)
      on update CASCADE
      on delete CASCADE;

alter table services
   add constraint FK_SERVICES_ASSOCIATI_TYPESERV foreign key (idTypeservice)
      references typeservices (id)
      on update CASCADE
      on delete CASCADE;

alter table articles
   add constraint FK_SERVICES_ASSOCIATI_TYPEARTC foreign key (idTypearticle)
      references typearticles (id)
      on update CASCADE
      on delete CASCADE;

alter table specifications
   add constraint FK_SPECIFIC_ASSOCIATI_SERVICES foreign key (idService)
      references services (id)
      on update CASCADE
      on delete CASCADE;


-- insertions


INSERT INTO `typecomptes` (`id`, `libelle`) VALUES
('1', 'Super admin'),
('2', 'Administrateur');

INSERT INTO `typeservices` (`id`, `libelle`) VALUES
('1', 'Coiffure'),
('2', 'Maquillage'),
('3', 'Mariage');

INSERT INTO `typearticles` (`id`, `libelle`) VALUES
('1', 'Perruques'),
('2', 'Mèches'),
('3', 'Produits de beauté');
