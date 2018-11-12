-- table: customers

/* set the username as unique? and the email? */
alter table customers
add constraint email_uniqueness unique (email);

/* we will store the md5 hash of the passwords, not the plain text */
update customers
set password=md5(password);

/*avoid that annoying null fields*/
ALTER TABLE customers ALTER COLUMN firstname  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN lastname  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN address1  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN city  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN country  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN region  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN creditcardtype  DROP  NOT NULL;
ALTER TABLE customers ALTER COLUMN creditcardexpiration  DROP  NOT NULL;

/*update id sequence*/
select setval( 'customers_customerid_seq', (select max(customerid)+1 from customers));

/* utterly unnecessary attribute: income */


-- table: imdb_movies

/* removes the release year (last 5 digits) from the movietitle (it is already in year) */
update imdb_movies
set movietitle=substring(movietitle from 0 for length(movietitle) - 5);

/* change year from text to integer? or maybe get fucked over by that fucking 1998-1999 film */
update imdb_movies
set year='1998'
where movieid = 636347;

update imdb_movies
set year = '1998'
where movieid = 644338;

/* set year column as integer */
alter table imdb_movies
alter column year type integer using(year::integer);



-- table: orders

/* add foreign keys for costumer_id */
alter table orders
    add constraint orders_costumer_id_fkey2 foreign key (customerid) 
    references customers(customerid);


CREATE TABLE public.aux
(
  orderid integer NOT NULL,
  prod_id integer NOT NULL,
  price numeric, -- price without taxes when the order was paid
  quantity integer NOT NULL,
  CONSTRAINT orderdetail_pkey PRIMARY KEY (orderid, prod_id),
  CONSTRAINT orderdetail_orderid_fkey2 FOREIGN KEY (orderid)
      REFERENCES public.orders (orderid) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT orderdetail_prod_id_fkey2 FOREIGN KEY (prod_id)
      REFERENCES public.products (prod_id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
      
);


insert into aux 
	select orderid,prod_id , price, sum(quantity) from orderdetail group by orderid,price, prod_id;

drop table orderdetail;

alter table aux rename to orderdetail;

-- table: imdb_actormovies

/* add foreign keys for actorid and movieid */
alter table imdb_actormovies
    add constraint imdb_actormovies_actorid_fkey2 foreign key (actorid) 
    references imdb_actors(actorid);

alter table imdb_actormovies
    add constraint imdb_actormovies_movieid_fkey2 foreign key (movieid) 
    references imdb_movies(movieid);


-- table: inventory

/* add foreign key for prod_id */
alter table inventory
    add constraint inventory_prod_id_fkey2 foreign key (prod_id) 
    references products(prod_id);



-- table: countries
/* generates a list of the distinct countries listed in the movies */

--drop table countries;
create table countries
(
	country character varying(32) NOT NULL,
	countryid integer NOT NULL,
    constraint countries_pkey primary key (countryid)
);

--drop sequence countries_countryid_seq;

create sequence countries_countryid_seq
increment 1 start 1 no minvalue no maxvalue cache 1;

alter table only countries
alter column countryid set default nextval('countries_countryid_seq'::regclass);

insert into countries
select distinct country
from imdb_moviecountries;

update imdb_moviecountries
set country = countries.countryid
from countries where countries.country = imdb_moviecountries.country;

alter table imdb_moviecountries
alter column country type integer using(country::integer);

alter table imdb_moviecountries 
    add constraint imdb_moviecountries_movieid_fkey2 foreign key (country) 
    REFERENCES countries(countryid);



-- table: genres
/* generates a list of the distinct genres listed in the movies */

--drop table genres;
create table genres
(
	genre character varying(32) NOT NULL,
	genreid integer NOT NULL,
    constraint genres_pkey primary key (genreid)
);

--drop sequence genres_genreid_seq;

create sequence genres_genreid_seq
increment 1 start 1 no minvalue no maxvalue cache 1;

alter table only genres
alter column genreid set default nextval('genres_genreid_seq'::regclass);

insert into genres
select distinct genre
from imdb_moviegenres;

update imdb_moviegenres
set genre = genres.genreid
from genres where genres.genre = imdb_moviegenres.genre;

alter table imdb_moviegenres
alter column genre type integer using(genre::integer);

alter table imdb_moviegenres
    add constraint imdb_moviegenres_movieid_fkey2 foreign key (genre) 
    references genres(genreid);



-- table: languages
/* generates a list of the distinct languages listed in the movies */

--drop table languages;

create table languages
(
	language character varying(32) NOT NULL,
	languageid integer NOT NULL,
    constraint languages_pkey primary key (languageid)
);

--drop sequence languages_languageid_seq;

create sequence languages_languageid_seq
increment 1 start 1 no minvalue no maxvalue cache 1;

alter table only languages
alter column languageid set default nextval('languages_languageid_seq'::regclass);

insert into languages
select distinct language
from imdb_movielanguages;

update imdb_movielanguages
set language = languages.languageid
from languages where languages.language = imdb_movielanguages.language;

alter table imdb_movielanguages
alter column language type integer using(language::integer);

alter table imdb_movielanguages
    add constraint imdb_movielanguages_movieid_fkey2 foreign key (language) 
    references languages(languageid);
