
-- TABLA DE EVENTOS--
CREATE TABLE eventos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    lugar VARCHAR(100),
    fecha  VARCHAR(100),
    motivo VARCHAR(100),
    descripcion TEXT,
    enlaceArtista  VARCHAR(200),
    nombreArtista  VARCHAR(200),
    instaArtista  VARCHAR(200),
    twArtista  VARCHAR(200),
    publicado  BOOLEAN
);

--ALTER TABLE eventos ADD COLUMN publicado BOOLEAN;

--INSERCIÓN DE TUPLAS--
--INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista) VALUES ();
INSERT INTO eventos (nombre, lugar, fecha, motivo,  descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('La M.O.D.A. en concierto', 'Sala La Riviera de Madrid', '11, 12 y 13 de marzo - 18:00 y 21:00', 'Estreno Ninguna ola', '2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar La M.O.D.A. acrecientan aún más el optimismo. La banda burgalesa ha confirmado que actuará en Madrid en marzo de 2021. La Maravillosa Orquesta del Alcohol ofrecerán un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivirlos ya están a la venta. La M.O.D.A. vuelve a los escenarios a presentar su último lanzamiento “Ninguna Ola”, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que ellos se clasifican.','https://www.lamaravillosaorquestadelalcohol.com/', 'La M.O.D.A.', 'https://www.instagram.com/lamaravillosaorquesta/?hl=es', 'https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Vetusta Morla en concierto','WiZink Center Madrid','1, 2 y 3 de julio - 20:30', 'Gira MSDL' ,'Vetusta Morla regresa a los escenarios españoles con una gira muy especial en la que estarán presentando su próximo álbum MSDL- Canciones dentro de canciones. Ofrecerán un total de 3 conciertos que se desarrollarán los días 1, 2 y 3 de julio. Cada día contará con un pase a las 20:30h, y no hace falta apuntar se cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivirlos ya están a la venta. El mundo del rock alternativo vivió una completa revolución con la aparición de Vetusta Morla, una banda madrileña que se ha convertido en todo un referente y que cuenta en la actualidad con una legión de fans que llena todos y cada uno de sus conciertos. El punto de partida de esta nueva entrega musical es la convicción de que dentro de cada canción existen otras canciones que habitan en ella como dentro de una muñeca rusa. En definitiva, este ejercicio artístico tiene como resultado una nueva obra con auténtica y original entidad.', 'https://www.vetustamorla.com/', 'Vetusta Morla', 'https://www.instagram.com/vetustamorla/?hl=es', 'https://twitter.com/vetustamorla' , true);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Guitarricadelafuente en concierto', 'Sala M100 de Córdoba','7, 8 y 9 de agosto - 18:00 y 21:00', 'Gira 2021 2022' , 'Álvaro Lafuente acaba de presentar ‘Desde las alturas’, un homenaje a sus raíces aragonesas en el sencillo que acompaña el que es el álbum debut del artista. Serán un total de 3 conciertos que se desarrollarán los días 7, 8 y 9 de agosto. Cada día contará con dos pases, uno a las 18:30h y otro a las 21:30, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivirlo ya están a la venta.','https://guitarricadelafuente.com/','Guitarricadelafuente','https://www.instagram.com/guitarricadelafuente/?hl=es','https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo,  descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Extremoduro en concierto', 'Sala La Riviera de Madrid', '11, 12 y 13 de marzo - 18:00 y 21:00', 'Gira de despedida', '2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anuncia Extremoduro acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Extremoduro vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.','https://www.lamaravillosaorquestadelalcohol.com/', 'Extremoduro', 'https://www.instagram.com/lamaravillosaorquesta/?hl=es', 'https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Alba Reche en concierto','WiZink Center Madrid','1, 2 y 3 de julio - 20:30', 'Quimera Tour' ,'2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar Alba Reche acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Alba Reche vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.', 'https://www.vetustamorla.com/', 'Alba Reche', 'https://www.instagram.com/vetustamorla/?hl=es', 'https://twitter.com/vetustamorla' , true);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Estopa en concierto', 'Sala M100 de Córdoba','7, 8 y 9 de agosto - 18:00 y 21:00', 'Gira Fuego' , '2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar Estopa acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Estopa vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.','https://guitarricadelafuente.com/','Estopa','https://www.instagram.com/guitarricadelafuente/?hl=es','https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo,  descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('La La Love You en concierto', 'Sala La Riviera de Madrid', '11, 12 y 13 de marzo - 18:00 y 21:00', 'World Tour', '2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar La La Love You acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. La La Love You vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.','https://www.lamaravillosaorquestadelalcohol.com/', 'La La Love You', 'https://www.instagram.com/lamaravillosaorquesta/?hl=es', 'https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Morgan en concierto','WiZink Center Madrid','1, 2 y 3 de julio - 20:30', 'Nuevas fechas 2022','2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar Morgan acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Morgan vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.', 'https://www.vetustamorla.com/', 'Morgan', 'https://www.instagram.com/vetustamorla/?hl=es', 'https://twitter.com/vetustamorla', true );
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Supersubmarina en concierto', 'Sala M100 de Córdoba','7, 8 y 9 de agosto - 18:00 y 21:00', 'Gira de vuelta', '2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar Supersubmarina acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Supersubmarina vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.','https://guitarricadelafuente.com/','Supersubmarina','https://www.instagram.com/guitarricadelafuente/?hl=es','https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo,  descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('Harry Styles en concierto', 'Sala La Riviera de Madrid', '11, 12 y 13 de marzo - 18:00 y 21:00', 'World Tour', '2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar Harry Styles acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Harry Styles vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.','https://www.lamaravillosaorquestadelalcohol.com/', 'Harry Styles', 'https://www.instagram.com/lamaravillosaorquesta/?hl=es', 'https://twitter.com/estoesLaMODA', true);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista, publicado) VALUES ('The weeknd en concierto','WiZink Center Madrid','1, 2 y 3 de julio - 20:30', 'Gira española','2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar The weeknd acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. The weeknd vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.', 'https://www.vetustamorla.com/', 'The weeknd', 'https://www.instagram.com/vetustamorla/?hl=es', 'https://twitter.com/vetustamorla', false);
INSERT INTO eventos (nombre, lugar, fecha, motivo, descripcion, enlaceArtista, nombreArtista, instaArtista, twArtista,publicado) VALUES ('Coldplay en concierto', 'Sala M100 de Córdoba','7, 8 y 9 de agosto - 18:00 y 21:00', 'Memories tour','2021 ya está aquí, y con su llegada han aumentado las esperanzas de que la música en directo vuelva a sonar como antes (y sin restricciones) en las salas de conciertos de España. Noticias como la que acaba de anunciar Coldplay acrecientan aún más el optimismo. Ha confirmado que actuará en Madrid en marzo de 2021. Se ofrecerá un total de 6 conciertos que se desarrollarán los días 11, 12 y 13 de marzo. Cada día contará con dos pases, uno a las 18h y otro a las 21h, y no hace falta apuntar que todos ellos cumplirán con las medidas de seguridad e higiene necesarias. Las entradas para vivir la experiencia ya están a la venta. Coldplay vuelve a los escenarios a presentar su último lanzamiento, un álbum cargado de nostalgia y que, aunque mantiene su esencia, se posiciona más en el lado del Indie que en el del rock, género con el que este artista se clasifican.','https://guitarricadelafuente.com/','Coldplay','https://www.instagram.com/guitarricadelafuente/?hl=es','https://twitter.com/estoesLaMODA', false);


--TABLA DE ETIQUETAS--
CREATE TABLE etiquetas (
    idEtiqueta INT AUTO_INCREMENT,
    idEvento INT NOT NULL REFERENCES eventos(id),
    etiqueta VARCHAR(200) NOT NULL,
    PRIMARY KEY (idEtiqueta, idEvento)
);

INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('1','rock');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('1','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('1','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('2','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('2','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('3','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('3','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('4','rock');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('4','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('5','pop');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('5','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('6','pop');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('6','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('7','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('7','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('8','rock');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('8','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('8','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('9','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('9','español');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('10','pop');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('10','internacional');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('11','pop');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('11','internacional');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('12','pop');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('12','indie');
INSERT INTO etiquetas (idEvento, etiqueta) VALUES ('12','internacional');


--TABLA DE IMAGENES--
CREATE TABLE imagenes (
    idImagen INT AUTO_INCREMENT,
    idEvento INT NOT NULL REFERENCES eventos(id),
    src VARCHAR(200) NOT NULL,
    tipo SET('portada','galeria'),
    PRIMARY KEY (idImagen, idEvento)
);

INSERT INTO imagenes (idEvento, src, tipo) VALUES ('1','../img/eventos/laModa1.jpg','portada');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('1','../img/eventos/lamoda/lamoda.jpg','galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('1','../img/eventos/lamoda/lamodagrupo.jpg','galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('2','../img/eventos/vetustamorla.jpg', 'portada');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('2','../img/eventos/vetustamorla/MSDL.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('2','../img/eventos/vetustamorla/VetustaMorla.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('3','../img/eventos/guitarricadelafuente.jpg', 'portada');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('3','../img/eventos/guitarrica/album.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('3','../img/eventos/guitarrica/guitarrica.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('4','../img/eventos/extremoduro.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('4','../img/eventos/extremoduro/extremoduro1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('5','../img/eventos/albareche.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('5','../img/eventos/albareche/albareche1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('6','../img/eventos/estopa.png', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('6','../img/eventos/estopa/estopa1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('7','../img/eventos//lalaloveyou.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('7','../img/eventos//lalaloveyou/lalaloveyou1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('8','../img/eventos/morgan.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('8','../img/eventos/morgan/morgan1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('9','../img/eventos/supersubmarina.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('9','../img/eventos/supersubmarina/supersubmarina1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('10','../img/eventos/harrystyles.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('10','../img/eventos/harrystyles/harrystyles1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('11','../img/eventos/theweekend.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('11','../img/eventos/theweeknd/theweeknd1.jpg', 'galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('12','../img/eventos/coldplay.jpg', 'portada,galeria');
INSERT INTO imagenes (idEvento, src, tipo) VALUES ('12','../img/eventos/coldplay/coldplay1.jpg', 'galeria');


-- TABLA DE COMENTARIOS--
CREATE TABLE comentarios(
    idComentario INT AUTO_INCREMENT,
    idEvento INT NOT NULL REFERENCES eventos(id),
    nombre VARCHAR(50),
    email VARCHAR(50),
    comentario TEXT,
    fecha DATETIME,
    modificado BOOLEAN,
    PRIMARY KEY (idComentario, idEvento)
);

INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('1','Celia Ruiz', 'celiaruiz@gmail.com', 'Mi pareja y yo fuimos a un concierto suyo hace un par de años, fue i m p r e s i o n a n t e!!. Animo a todo el que esté dudando a que no se lo piense ni un segundo más. Esperamos que la situación lo permita🙃', '2021-03-03 18:05', true );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('1','T. Azor', 'tazor@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('2','Alvaro González','alvgonza@gmail.com', 'Soy un gran fan de esta banda, no me podía perder su último concierto así que compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-04-26 16:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('3','Lucia Ruiz','lucir@gmail.com', 'Su último concierto fue un desastre pero me gusta mucho este artista creo que le daré una segunda oportunidad!', '2021-04-10 18:09:00', true );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('3','Alvaro García', 'alvg@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('4','Ana García', 'anag@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', true );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('4','Alvaro González','alvgonza@gmail.com', 'Soy un gran fan de esta banda, no me podía perder su último concierto así que compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-04-26 16:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('5','Javier García', 'javierg@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('6','Paula López', 'paulal@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('7','Natalia Sánchez', 'natalias@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', true );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('8','Alvaro García', 'alvg@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('9','Antonio Perez', 'alvg@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', true );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('10','Sara Cuevas', 'sarac@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', false );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('11','Alvaro García', 'alvg@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', true );
INSERT INTO comentarios (idEvento, nombre, email, comentario, fecha, modificado) VALUES ('12','Alvaro García', 'alvg@gmail.com', 'Compré la entrada hace más de un año, pero por culpa de la pandemia se canceló la gira. Espero que ahora no pase lo mismo... 😅😢', '2021-03-26 23:23:00', true );


-- TABLA DE PALABRAS PROHIBIDAS--
CREATE TABLE prohibidas(
    idPalabra INT AUTO_INCREMENT PRIMARY KEY, 
    palabra VARCHAR(50)
);

INSERT INTO prohibidas (palabra) VALUES ('joder');
INSERT INTO prohibidas (palabra) VALUES ('caca');
INSERT INTO prohibidas (palabra) VALUES ('basura');
INSERT INTO prohibidas (palabra) VALUES ('mierda');
INSERT INTO prohibidas (palabra) VALUES ('covid');


-- TABLA DE USUARIOS--
CREATE TABLE usuarios(
    nick VARCHAR(100) PRIMARY KEY,
    passw VARCHAR(100),
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    email VARCHAR(100),
    tipo enum('registrado','moderador','gestor','superusuario')
);
