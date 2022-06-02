-- Tables

drop table if exists "roles" cascade;
create table "roles"
(
    "id" bigserial primary key not null,
    "name" varchar(10) not null
);
alter table "roles" add constraint "roles_name_unique" unique ("name");

drop table if exists "users" cascade;
create table "users"
(
    "id" bigserial primary key not null,
    "name" varchar(255) not null,
    "email" varchar(255) not null,
    "email_verified_at" timestamp(0) without time zone null,
    "password" varchar (255) not null,
    "remember_token" varchar (100) null,
    "created_at" timestamp (0) without time zone null,
    "updated_at" timestamp (0) without time zone null,
    "role_id" bigint null
);
alter table "users" add constraint "users_role_id_foreign" foreign key ("role_id") references "roles" ("id");
alter table "users" add constraint "users_email_unique" unique ("email");

drop table if exists "password_resets" cascade;
create table "password_resets"
(
    "email" varchar(255) not null,
    "token" varchar(255) not null,
    "created_at" timestamp(0) without time zone null
);
drop index if exists "password_resets_email_index";
create index "password_resets_email_index" on "password_resets" ("email");

drop table if exists "failed_jobs" cascade;
create table "failed_jobs"
(
    "id" bigserial primary key not null,
    "uuid" varchar(255) not null,
    "connection" text not null,
    "queue" text not null,
    "payload" text not null,
    "exception" text not null,
    "failed_at" timestamp(0) without time zone default CURRENT_TIMESTAMP not null
);
alter table "failed_jobs" add constraint "failed_jobs_uuid_unique" unique ("uuid");

drop table if exists "personal_access_tokens" cascade;
create table "personal_access_tokens"
(
    "id" bigserial primary key not null,
    "tokenable_type" varchar(255) not null,
    "tokenable_id" bigint not null,
    "name" varchar(255) not null,
    "token" varchar(64) not null,
    "abilities" text null,
    "last_used_at" timestamp(0) without time zone null,
    "created_at" timestamp (0) without time zone null,
    "updated_at" timestamp (0) without time zone null
);
drop index if exists "personal_access_tokens_tokenable_type_tokenable_id_index";
create index "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens" ("tokenable_type", "tokenable_id");
alter table "personal_access_tokens" add constraint "personal_access_tokens_token_unique" unique ("token");

drop table if exists "offers" cascade;
create table "offers"
(
    "id" bigserial primary key not null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp (0) without time zone null,
    "name" varchar (255) not null,
    "description" varchar (1000) not null,
    "image" varchar (255) not null,
    "place" varchar (255) not null,
    "accommodationType" varchar (255) not null,
    "user_id" bigint not null
);
alter table "offers" add constraint "offers_user_id_foreign" foreign key ("user_id") references "users" ("id");

drop table if exists "rooms" cascade;
create table "rooms"
(
    "id" bigserial primary key not null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp (0) without time zone null,
    "name" varchar (255) not null,
    "description" varchar (1000) not null,
    "price" double precision not null,
    "beds_amount" integer not null,
    "offer_id" bigint not null
);
alter table "rooms" add constraint "rooms_offer_id_foreign" foreign key ("offer_id") references "offers" ("id");

drop table if exists "reservations" cascade;
create table "reservations"
(
    "id" bigserial primary key not null,
    "created_at" timestamp(0) without time zone null,
    "updated_at" timestamp (0) without time zone null,
    "date_from" date not null, "date_to" date not null,
    "room_id" bigint not null,
    "user_id" bigint not null
);
alter table "reservations" add constraint "reservations_room_id_foreign" foreign key ("room_id") references "rooms" ("id");
alter table "reservations" add constraint "reservations_user_id_foreign" foreign key ("user_id") references "users" ("id");

-- data seed

-- roles
INSERT INTO roles
    (name)
VALUES
    ('admin'),
    ('ofr_maker'),
    ('ofr_taker');

-- users
insert into "users"
    ("created_at",
    "email",
    "email_verified_at",
    "name",
    "password",
    "remember_token",
    "role_id",
    "updated_at")
values
    ('2022-05-30 18:23:39',
        'admin@sleepy.com',
        '2022-05-30 18:23:38',
        'Admin',
        '$2y$10$VnF5pvYZ7RM3VY4BmK1Bi.2ZOc5h3u2irJ2E39dhRk6eF.eanEuJK', -- password: 123
        'T0j9r1Gz4A',
        1,
        '2022-05-30 18:23:39'),

    ('2022-05-30 18:23:39',
        'oferty@sleepy.com',
        '2022-05-30 18:23:39',
        'Oferty',
        '$2y$10$G9jhhdt0MHL6dPR7xvNH8eGym1TMFBTi45FxJ/D3uGF1Xdr4oVklm', -- password: 123
        'UR1DEaHWbA',
        2,
        '2022-05-30 18:23:39'),

    ('2022-05-30 18:23:39',
        'rezerwacje@sleepy.com',
        '2022-05-30 18:23:39',
        'Rezerwacje',
        '$2y$10$iblsR48RzWI0xQpzejVQaecNvPZ6VghHrcoaE44199hvdNbRoIBI.', -- password: 123
        'V6uPiSuXiH',
        3,
        '2022-05-30 18:23:39');


-- offers

insert into "offers"
    ("accommodationType",
    "created_at",
    "description",
    "image",
    "name",
    "place",
    "updated_at",
    "user_id")
values
    ('Pensjonat',
        '2022-06-02 12:10:06',
        'Wspani ałe domki u basi. Zapewione są wszystkie wymagane opcje, które każdy z naszych klientów wymaga. Duże łóźka, wygodne łazienki. Świetna lokalizacja na wypad rodzinny.',
        '(1).jpg',
        'Domki u basi', 'Kraków',
        '2022-06-02 12:10:06',
        2),
    ('Kwatera prywata',
        '2022-06-02 12:10:06',
        'Niesamowity domek nad jeziorem. Super widok z każdego balkonu. Do okoła znajduje się wiele szlaków turystycznych oraz zabytków. Pełne wyposażenie.',
        '(2).jpg',
        'Domek nad jeziorem',
        'Zakopane',
        '2022-06-02 12:10:06',
        2);

-- rooms

insert into "rooms"
    ("beds_amount",
    "created_at",
    "description",
    "name",
    "offer_id",
    "price",
    "updated_at")
values
    (1,
        '2022-06-02 12:14:29',
        'Pokój dla dziecka, dużo zabawek oraz komputerów',
        'Pokój dla dziecka',
        1,
        200,
        '2022-06-02 12:14:29'),
    (2,
        '2022-06-02 12:14:29',
        'Pokój dla rodziców, duże łózko oraz prywatna łaziekna. Blkon z widokiem na miasto.',
        'Pokój dla rodziców',
        1,
        250,
        '2022-06-02 12:14:29'),
    (1,
        '2022-06-02 12:14:29',
        'Pokój mirabelka to świetna propozycja dla każdego turysty pragnącego odpocząć od pracy. Do okoła panuje cisza i spokój.',
        'Mirabelka',
        2,
        400,
        '2022-06-02 12:14:29');

-- Functions

--

CREATE OR REPLACE FUNCTION getOfferById(offer_id integer)
    RETURNS SETOF offers
AS $$
    SELECT * FROM offers o WHERE o.id = offer_id;
$$ language sql stable;

CREATE OR REPLACE FUNCTION getUserById(user_id integer)
    RETURNS SETOF users
AS $$
SELECT * FROM users u WHERE u.id = user_id;
$$ language sql stable;

CREATE OR REPLACE FUNCTION getRoomsByOfferId(offerId integer)
    RETURNS SETOF rooms
AS $$
SELECT * FROM rooms r WHERE r.offer_id = offerId;
$$ language sql stable;

-- TODO: implement functions from controllers

-- Procedures

-- TODO: implement procedures from controllers
