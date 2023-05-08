create table usuario (
    id_usuario int primary key auto_increment,
    nome varchar(255) not null,
    email varchar(255) not null,
    foto longblob,
    senha varchar(255) not null
);

create table grupo (
    id_grupo int primary key auto_increment,
    nome varchar(255) not null,
    descricao varchar(255)
);

create table usuario_grupo (
    id_usuario_grupo int primary key auto_increment,
    id_usuario int not null,
    id_grupo int not null,
    foreign key (id_usuario) references usuario(id_usuario),
    foreign key (id_grupo) references grupo(id_grupo)
);


create table grupo_filme (
    id_grupo_filme int primary key auto_increment,
    id_grupo int not null,
    id_filme_api int not null,
    foreign key (id_grupo) references grupo(id_grupo)
);

create table nota (
    id_nota int primary key auto_increment,
    nota int,
    id_usuario int not null,
    id_filme_api int not null,
    data_avaliacao timestamp default current_timestamp ON UPDATE current_timestamp,
    foreign key (id_usuario) references usuario(id_usuario)
);

create table convite (
    id_convite int primary key auto_increment,
    id_grupo int not null,
    id_usuario int not null,
    foreign key (id_usuario) references usuario(id_usuario),
    foreign key (id_grupo) references grupo(id_grupo)
)