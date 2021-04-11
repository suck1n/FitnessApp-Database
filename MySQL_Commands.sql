# Commands can be executed from Top to Bottom
# Default Users for the Website:
#       _______________________
#       | Username | Password |
#       -----------------------
#       | admin    | 123      |
#       | user     | 123      |
#       | user2    | 123      |
#       | user3    | 123      |
#       -----------------------
#
# Default Users for the Database:
#       ____________________________________
#       | Username      | Password         |
#       ------------------------------------
#       | administrator | toor             |
#       | user          | password         |
#       | website_user  | secure_password  |
#       ------------------------------------
#
#
# Database =============================================================================================================

create database fitness_app;
use fitness_app;

# End ==================================================================================================================
# Create Users =========================================================================================================

create user 'user'@'localhost' identified by 'password';
create user 'administrator'@'localhost' identified by 'toor';
create user 'website_user'@localhost identified by 'secure_password';

# End ==================================================================================================================
# Tables ===============================================================================================================

create table Roles (
    id integer NOT NULL auto_increment,
    description varchar(255),
    sql_user varchar(100),
    sql_password varchar(100),
    PRIMARY KEY (id)
);

create table Experience (
    id int auto_increment,
    name varchar(100),
    description varchar(255),
    primary key (id)
);

create table Users (
    username varchar(100),
    name varchar(100),
    surname varchar(100),
    password varchar(255),
    email varchar(255),
    role integer,
    experience integer,
    primary key (username),
    foreign key (role) REFERENCES Roles(id) on update cascade on delete set null,
    foreign key (experience) references Experience(id) on update cascade on delete set null
);

create table Workouts (
    id int auto_increment,
    level int,
    name varchar(100),
    url varchar(100),
    length int,
    description varchar(255),
    sets int,
    repetitions int,
    primary key (id),
    foreign key (level) references Experience(id) on update cascade on delete set null
);

create table UsersWorkouts (
    username varchar(100),
    workoutID int,
    foreign key (username) references Users(username) on update cascade on delete cascade,
    foreign key (workoutID) references Workouts(id) on update cascade on delete cascade
);

create table `group` (
    id int auto_increment,
    owner varchar(100),
    name varchar(100),
    primary key (id),
    foreign key (owner) references Users(username) on update cascade on delete cascade
);

create table Grouprole (
    id int auto_increment,
    name varchar(100) unique,
    description varchar(255),
    primary key (id)
);

create table UsersGroup (
    username varchar(100),
    groupID int,
    roleID int,
    foreign key (username) references Users(username) on update cascade on delete cascade,
    foreign key (groupID) references `group`(id) on update cascade on delete cascade,
    foreign key (roleID) references Grouprole(id) on update cascade on delete cascade
);

create table GroupWorkouts (
    groupID int,
    workoutID int,
    foreign key (groupID) references `group`(id) on update cascade on delete cascade,
    foreign key (workoutID) references Workouts(id) on update cascade on delete cascade
);

create table gadget (
    id int auto_increment,
    difficulty int,
    name varchar(100) unique,
    description varchar(255),
    url varchar(100),
    primary key (id),
    foreign key (difficulty) references Experience(id) on update cascade on delete set null
);

create table WorkoutsGadget (
    workoutID int,
    gadgetID int,
    foreign key (workoutID) references Workouts(id) on update cascade on delete cascade,
    foreign key (gadgetID) references gadget(id) on update cascade on delete cascade
);

create table MuscleGroup (
    id int auto_increment,
    name varchar(100) unique,
    description varchar(255),
    primary key (id)
);

create table MuscleGroupWorkouts (
    muscleGroupID int,
    workoutID int,
    foreign key (muscleGroupID) references MuscleGroup(id) on update cascade on delete cascade,
    foreign key (workoutID) references Workouts(id) on update cascade on delete cascade
);

create table ForgotPassword (
    hash varchar(255),
    user varchar(100),
    primary key (hash),
    foreign key (user) references Users(username) on update cascade on delete cascade
);

# End ==================================================================================================================
# Default Values =======================================================================================================

insert into Roles(description, sql_user, sql_password) values ('Normal User of the Database, can only read!', 'user', 'password');
insert into Roles(description, sql_user, sql_password) values('Administrator Account. Has all privileges', 'administrator', 'toor');

insert into Experience values(null, 'Beginner', 'Noch keine Erfahrung mit Workouts');
insert into Experience values(null, 'Amateur', 'Ein paar Workouts da und dort gemacht, aber noch am Anfang');
insert into Experience values(null, 'Profi', 'Selbst schon über Workouts informiert und Pläne kreiert');

insert into Users values('admin', 'Admini', 'strator', '$2y$10$IgMueMhLToL5diWo2u8RYeVij4J1s0cfI/KRe.L/YjMFTw7sF7HIe', 'admin@domain.com', 2, 2);
insert into Users values('user', 'Test', 'User', '$2y$10$IgMueMhLToL5diWo2u8RYeVij4J1s0cfI/KRe.L/YjMFTw7sF7HIe', 'test@user.com', 1, 3);
insert into Users values('user2', 'user2', 'User', '$2y$10$IgMueMhLToL5diWo2u8RYeVij4J1s0cfI/KRe.L/YjMFTw7sF7HIe', 'test@user2.com', 1, 2);
insert into Users values('user3', 'user3', 'User', '$2y$10$IgMueMhLToL5diWo2u8RYeVij4J1s0cfI/KRe.L/YjMFTw7sF7HIe', 'test@user3.com', 1, 1);

insert into Workouts values(null, 2, 'Beine Training', 'https://my.server.com/image.png', 120, 'Als erstes ...', 0, 0);
insert into Workouts values(null, 1, 'Oberarme Training', 'https://my.server.com/image2.png', 0, 'Man muss ...', 30, 10);
insert into Workouts values(null, 3, 'Brustkorp Training', 'https://my.server.com/image3.png', 0, 'Beschreibung ...', 20, 30);

insert into UsersWorkouts values('user', 1);
insert into UsersWorkouts values('user3', 2);
insert into UsersWorkouts values('user3', 3);

insert into `group` values(null, 'user2', 'User2_Gruppe');
insert into `group` values(null, 'user2', 'User2_Gruppe2');

insert into Grouprole values(null, 'Sportler', 'Normaler Benutzer einer Gruppe. Hat die Standardberechtigung');
insert into Grouprole values(null, 'Trainer', 'Trainer einer Gruppe. Hat alle Rechte');

insert into UsersGroup values('user3', 1, 2);
insert into UsersGroup values('user', 1, 1);
insert into UsersGroup values('user', 2, 1);

insert into GroupWorkouts values(1, 1);
insert into GroupWorkouts values(1, 2);
insert into GroupWorkouts values(2, 2);
insert into GroupWorkouts values(2, 3);

insert into gadget values(null, 2, 'Hantel', 'Gewichte zum Heben', 'https://my.server.com/image4.png');
insert into gadget values(null, 1, 'Matte', 'Normale Matte', 'https://my.server.com/image5.png');

insert into WorkoutsGadget values(2, 1);
insert into WorkoutsGadget values(3, 2);

insert into MuscleGroup values(null, 'Oberschenkel', 'Befindt sich an der oberen Hälfte eines Beines');
insert into MuscleGroup values(null, 'Bizep', 'Befindt sich an der oberen Hälfte eines Armes');
insert into MuscleGroup values(null, 'Bauchmuskeln', 'Befinden sich am Bauch');

insert into MuscleGroupWorkouts values(1, 1);
insert into MuscleGroupWorkouts values(2, 2);
insert into MuscleGroupWorkouts values(3, 3);

# End ==================================================================================================================
# Views ================================================================================================================

create view UserWorkoutCount as
    select Users.username, count(UsersWorkouts.workoutID) as 'count'
    from Users
        left join UsersWorkouts
            on UsersWorkouts.username = Users.username
    group by Users.username;

create view GroupWorkoutCount as
    select `group`.name, count(GroupWorkouts.workoutID) as 'count'
    from `group`
        left join GroupWorkouts
            on GroupWorkouts.groupID = `group`.id
    group by GroupWorkouts.groupID;

# End ==================================================================================================================
# Grant Privileges =====================================================================================================

GRANT ALL PRIVILEGES ON fitness_app.* TO 'administrator'@'localhost';

GRANT SELECT ON fitness_app.Experience TO 'user'@'localhost';
GRANT SELECT ON fitness_app.gadget TO 'user'@'localhost';
GRANT SELECT ON fitness_app.`group` TO 'user'@'localhost';
GRANT SELECT ON fitness_app.Grouprole TO 'user'@'localhost';
GRANT SELECT ON fitness_app.GroupWorkouts TO 'user'@'localhost';
GRANT SELECT ON fitness_app.MuscleGroup TO 'user'@'localhost';
GRANT SELECT ON fitness_app.MuscleGroupWorkouts TO 'user'@'localhost';
GRANT SELECT ON fitness_app.Users TO 'user'@'localhost';
GRANT SELECT ON fitness_app.UsersGroup TO 'user'@'localhost';
GRANT SELECT ON fitness_app.UsersWorkouts TO 'user'@'localhost';
GRANT SELECT ON fitness_app.WorkoutsGadget TO 'user'@'localhost';
GRANT SELECT ON fitness_app.Workouts TO 'user'@'localhost';
GRANT SELECT ON fitness_app.GroupWorkoutCount TO 'user'@'localhost';
GRANT SELECT ON fitness_app.UserWorkoutCount TO 'user'@'localhost';

grant select, update, insert, delete on fitness_app.Users to 'website_user'@'localhost';
grant select on fitness_app.Roles to 'website_user'@'localhost';
grant select on fitness_app.Experience to 'website_user'@'localhost';
grant select, delete, insert on fitness_app.ForgotPassword to 'website_user'@'localhost';

# End ==================================================================================================================