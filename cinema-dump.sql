create schema if not exists cinema collate utf8_unicode_ci;
use cinema;
create table if not exists genres
(
    id   int auto_increment primary key,
    name varchar(255) null,
    constraint genres_name_uindex unique (name)
);
create table if not exists movies
(
    id       int auto_increment primary key,
    title    varchar(255)  null,
    duration int default 0 null
);
create table if not exists movies_genres
(
    movie_id int null,
    genre_id int not null,
    constraint movies_genres_genres_id_fk foreign key (genre_id) references genres (id) on update cascade on delete cascade,
    constraint movies_genres_movies_id_fk foreign key (movie_id) references movies (id) on update cascade on delete cascade
);
insert into movies(id, title, duration)
values (1, 'Люди в чёрном', 120),
       (2, 'Матрица', 160),
       (3, 'Проект: Альф', 95),
       (4, 'Кошмар на улице Вязов', 130);
insert into genres (id, name)
values (1, 'Комедия'),
       (2, 'Боевик'),
       (3, 'Фантастика'),
       (4, 'Ужасы');
insert into movies_genres (movie_id, genre_id)
values (1, 1),
       (1, 2),
       (1, 3),
       (2, 2),
       (2, 3),
       (3, 1),
       (3, 3),
       (4, 4);