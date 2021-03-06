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
    "date_from" date not null, 
    "date_to" date not null,
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
        'Wspani a??e domki u basi. Zapewione s?? wszystkie wymagane opcje, kt??re ka??dy z naszych klient??w wymaga. Du??e ??????ka, wygodne ??azienki. ??wietna lokalizacja na wypad rodzinny.',
        '(1).jpg',
        'Domki u basi', 'Krak??w',
        '2022-06-02 12:10:06',
        2),
    ('Kwatera prywata',
        '2022-06-02 12:10:06',
        'Niesamowity domek nad jeziorem. Super widok z ka??dego balkonu. Do oko??a znajduje si?? wiele szlak??w turystycznych oraz zabytk??w. Pe??ne wyposa??enie.',
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
        'Pok??j dla dziecka, du??o zabawek oraz komputer??w',
        'Pok??j dla dziecka',
        1,
        200,
        '2022-06-02 12:14:29'),
    (2,
        '2022-06-02 12:14:29',
        'Pok??j dla rodzic??w, du??e ????zko oraz prywatna ??aziekna. Blkon z widokiem na miasto.',
        'Pok??j dla rodzic??w',
        1,
        250,
        '2022-06-02 12:14:29'),
    (1,
        '2022-06-02 12:14:29',
        'Pok??j mirabelka to ??wietna propozycja dla ka??dego turysty pragn??cego odpocz???? od pracy. Do oko??a panuje cisza i spok??j.',
        'Mirabelka',
        2,
        400,
        '2022-06-02 12:14:29');

-- reservations

INSERT INTO reservations (
	created_at,
	updated_at,
	date_from,
	date_to,
	room_id,
	user_id )
	values (now(), now(),'2022-06-22 14:00:00', '2022-07-02 14:00:00', 1, 1);

-- Functions

CREATE OR REPLACE FUNCTION getOfferById(offer_id integer)
    RETURNS SETOF offers
AS $$
    SELECT * FROM offers o WHERE o.id = offer_id;
$$ language sql stable;

CREATE OR REPLACE FUNCTION getOfferByUserId(userId integer)
    RETURNS SETOF offers
AS $$
SELECT * FROM offers o WHERE o.user_id = userId;
$$ language sql stable;

CREATE OR REPLACE FUNCTION getFilteredOffers(f_name varchar, f_dateFrom date, f_dateTo date, f_place varchar, f_peopleAmount int, f_accommodationType varchar, f_priceFrom float, f_priceTo float)
    RETURNS SETOF offers
AS $$
    select * from offers where
    (name::text like '%' || f_name || '%' or f_name is null)
    and (exists (select * from rooms where offers.id = rooms.offer_id and not exists
               (select * from reservations where rooms.id = reservations.room_id and f_dateTo is not null and date_from < f_dateTo and f_dateFrom is not null and date_to > f_dateFrom)))
    and (place::text like f_place or f_place is null)
    and ("accommodationType"::text like f_accommodationType or f_accommodationType is null)
    and (exists (select * from rooms where offers.id = rooms.offer_id and price >= f_priceFrom or f_priceFrom is null) and exists
               (select * from rooms where offers.id = rooms.offer_id and price <= f_priceTo or f_priceTo is null) and exists
               (select * from rooms where offers.id = rooms.offer_id and beds_amount >= f_peopleAmount or f_peopleAmount is null))

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

-- DS --
CREATE OR REPLACE FUNCTION getRoomById(room_id integer)
    RETURNS SETOF rooms
	AS $$
		SELECT * FROM rooms r WHERE r.id = room_id;
	$$ language sql stable;

CREATE OR REPLACE FUNCTION getOfferByRoomId(roomId integer)
    RETURNS SETOF offers
    AS $$
        SELECT * FROM offers WHERE id = roomId;
    $$ language sql stable;

CREATE OR REPLACE PROCEDURE DeleteRoomById (room_id int)
 	AS $$
 		BEGIN
 			DELETE FROM rooms WHERE id = room_id;
 		END;
 	$$ language plpgsql;

CREATE OR REPLACE FUNCTION disabledDates (roomId INTEGER)
	RETURNS TABLE (rsrv_date_from DATE, rsrv_date_to DATE)
	AS $$
		BEGIN
			RETURN QUERY
			SELECT date_from, date_to
			FROM reservations
			WHERE reservations.room_id = roomId;
		END;
	$$ language plpgsql;

CREATE OR REPLACE FUNCTION insertRoom (
    ins_name varchar,
    ins_descr varchar,
    ins_price double precision,
    ins_beds integer,
    ins_offer bigint )
    RETURNS integer
    AS $$
DECLARE
    newId integer;
BEGIN
    insert into rooms (id, created_at, updated_at, name, description, price, beds_amount, offer_id)
    values ( (SELECT max(id) AS lastId FROM rooms) + 1,
        now(), now(), ins_name, ins_descr, ins_price, ins_beds, ins_offer)
        RETURNING id into newId;
    RETURN newId;
END;
$$ language plpgsql;

CREATE OR REPLACE PROCEDURE updateRoom (
    up_roomId int,
    up_name varchar,
    up_descr varchar,
    up_price double precision,
    up_beds integer )
AS $$
BEGIN
    UPDATE rooms SET
        updated_at = now(),
        name = up_name,
        description = up_descr,
        price = up_price,
        beds_amount = up_beds
    WHERE id = up_roomId;
END;
$$ language plpgsql;

--

CREATE OR REPLACE FUNCTION insertOffer(
    i_name varchar,
    i_description varchar,
    i_place varchar,
    i_accommodationType varchar,
    i_image varchar,
    i_userId int
) RETURNS integer
AS $$
DECLARE
    newId integer;
BEGIN
    insert into offers (created_at, updated_at, name, description, image, place, "accommodationType", user_id) values
        (now(), now(), i_name, i_description, i_image, i_place, i_accommodationType, i_userId) RETURNING id into newId;

    RETURN newId;
END;
$$ language plpgsql VOLATILE;

CREATE OR REPLACE FUNCTION getReservationById(reservation_Id integer)
    RETURNS SETOF reservations
AS $$
SELECT * FROM reservations r WHERE r.id = reservation_Id;
$$ language sql stable;

CREATE OR REPLACE FUNCTION insertReservation(
    new_date_from date,
    new_date_to date,
    new_room_id int,
    new_user_id int
) RETURNS integer
AS $$
DECLARE
    newId integer;
BEGIN
    insert into reservations (created_at, updated_at, date_from, date_to, room_id, user_id) values
        (now(), now(), new_date_from, new_date_to, new_room_id, new_user_id) RETURNING id into newId;

    RETURN newId;
END;
$$ language plpgsql VOLATILE;

-- Procedures

CREATE OR REPLACE PROCEDURE deleteRoomsByOfferId(offerId int)
    language plpgsql
AS $$
BEGIN
    delete FROM rooms r WHERE r.offer_id = offerId;
END;
$$;


CREATE OR REPLACE PROCEDURE deleteOffer(offerId int)
    language plpgsql
AS $$
BEGIN
    delete FROM offers o WHERE o.id = offerId;
END;
$$;

CREATE OR REPLACE PROCEDURE deleteReservationByID(reservation_Id int)
    language plpgsql
AS $$
BEGIN
    delete FROM reservations r WHERE r.id = reservation_Id;
END;
$$;

CREATE OR REPLACE PROCEDURE updateOffer(
    u_offerId int,
    u_name varchar,
    u_description varchar,
    u_place varchar,
    u_accommodationType varchar
)
    language plpgsql
AS $$
BEGIN
    update offers set
        name = u_name,
        description = u_description,
        place = u_place,
        "accommodationType" = u_accommodationType,
        updated_at = now()
    where id = u_offerId;
END;
$$;

CREATE OR REPLACE PROCEDURE updateReservation(
    new_Id int,
    new_date_from date,
    new_date_to date,
    new_room_id int,
    new_user_id int
)
    language plpgsql
AS $$
BEGIN
    update reservations set
        date_from = new_date_from,
        date_to = new_date_to,
        room_id = new_room_id,
        user_id = new_user_id,
        updated_at = now()
    where id = new_Id;
END;
$$;
