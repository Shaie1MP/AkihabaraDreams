CREATE DATABASE akihabaraDreams;
USE akihabaraDreams;

CREATE TABLE Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) not null,
    username VARCHAR(100) unique not null,
    password TEXT not null,
    email VARCHAR(100) not null unique,
    phone VARCHAR(15),
    address TEXT,
    profilePic TEXT default 'default.jpg',
    role ENUM('usuario', 'admin') default 'usuario'
);

CREATE TABLE Products (
    id_product INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) not null,
    description TEXT not null,
    price DECIMAL(10, 2) not null,
    stock INT not null default 0,
    category VARCHAR(20) not null,
    photo TEXT not null
);

CREATE TABLE Product_photos (
    id_product INT,
    photo VARCHAR(255),
    PRIMARY KEY (id_product, photo),
    FOREIGN KEY (id_product) REFERENCES Products(id_product) ON DELETE CASCADE
);

CREATE TABLE Promotion (
    id_promotion INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(15) unique not null,
    discount INT not null,
    description VARCHAR(50),
    start_date DATE not null,
    end_date DATE not null
);

CREATE TABLE Product_promotions (
    id_product INT,
    id_promotion INT,
    PRIMARY KEY (id_product, id_promotion),
    FOREIGN KEY (id_product) REFERENCES Products(id_product) ON DELETE CASCADE,
    FOREIGN KEY (id_promotion) REFERENCES Promotion(id_promotion) ON DELETE CASCADE
);

CREATE TABLE Cart (
    id_user INT,
    id_product INT,
    quantity INT DEFAULT 1,
    PRIMARY KEY (id_user, id_product),
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_product) REFERENCES Products(id_product) ON DELETE CASCADE
);

CREATE TABLE Orders (
    id_order INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    order_date DATE DEFAULT CURRENT_DATE,
    arrive_date DATE DEFAULT (CURRENT_DATE + INTERVAL 14 DAY),
    address TEXT,
    billing TEXT,
    state ENUM('pendiente', 'enviado', 'procesando', 'cancelado', 'entregado') DEFAULT 'pendiente',
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE
);


CREATE TABLE Order_details (
    id_order INT,
    id_product INT,
    quantity INT not null default 1,
    subtotal DECIMAL(10, 2),
    PRIMARY KEY (id_order, id_product),
    FOREIGN KEY (id_order) REFERENCES Orders(id_order) ON DELETE CASCADE,
    FOREIGN KEY (id_product) REFERENCES Products(id_product) ON DELETE CASCADE
);

CREATE VIEW Best_Selling_Products AS
SELECT 
    p.id_product,
    p.name,
    p.description,
    p.photo,
    SUM(dp.quantity) AS selled_quantity
FROM 
    Order_details dp
inner join 
    Products p ON dp.id_product = p.id_product
GROUP BY 
    p.id_product
ORDER BY 
    selled_quantity DESC
LIMIT 3;

CREATE VIEW View_Order_Details AS
SELECT 
    dp.id_order,
    dp.id_product,
    p.name AS product_name,
    dp.quantity,
    dp.subtotal
FROM 
    Order_details dp
INNER JOIN 
    Products p
ON 
    dp.id_product = p.id_product;

-- Users table
INSERT INTO Users (name, username, password, email, phone, address, profilePic, role) VALUES
('Carlos Pérez', 'carlos123', 'hashed_password_4', 'carlos@email.com', '34-91-123-4567', 'Calle Mayor 12, Madrid', 'carlos123.jpg', 'usuario'),
('María López', 'maria_lopez', 'hashed_password_5', 'maria@email.com', '34-91-234-5678', 'Avenida Diagonal 45, Barcelona', 'maria_lopez.jpg', 'usuario'),
('Juan García', 'juan_garcia', 'hashed_password_6', 'juan@email.com', '34-91-345-6789', 'Calle de la Paz 23, Valencia', 'juan_garcia.jpg', 'usuario'),
('Ana Martínez', 'ana_martinez', 'hashed_password_7', 'ana@email.com', '34-91-456-7890', 'Calle San Fernando 5, Sevilla', 'ana_martinez.jpg', 'usuario'),
('Luis Fernández', 'luis_fernandez', 'hashed_password_8', 'luis@email.com', '34-91-567-8901', 'Calle de la Libertad 78, Bilbao', 'luis_fernandez.jpg', 'usuario'),
('Laura Sánchez', 'laura_sanchez', 'hashed_password_9', 'laura@email.com', '34-91-678-9012', 'Calle del Cid 34, Zaragoza', 'laura_sanchez.jpg', 'usuario'),
('Irene Gil', 'irenegs', 'hashed_password_10', 'irene@email.com', '34-91-789-0123', 'Calle de la Constitución 56, Málaga', 'irenegs.jpg', 'usuario'),
('Patricia Gómez', 'patricia_gomez', 'hashed_password_11', 'patricia@email.com', '34-91-890-1234', 'Calle de la Reina 90, Murcia', 'patricia_gomez.jpg', 'usuario'),
('Fernando Ruiz', 'fernando_ruiz', 'hashed_password_12', 'fernando@email.com', '34-91-901-2345', 'Calle de la Cruz 12, Alicante', 'fernando_ruiz.jpg', 'usuario'),
('Isabel Torres', 'isabel_torres', 'hashed_password_13', 'isabel@email.com', '34-91-012-3456', 'Calle de la Esperanza 45, Granada', 'isabel_torres.jpg', 'usuario'),
('Diego Jiménez', 'diego_jimenez', 'hashed_password_14', 'diego@email.com', '34-91-123-4568', 'Calle del Sol 23, Córdoba', 'diego_jimenez.jpg', 'usuario'),
('Sofía Morales', 'sofia_morales', 'hashed_password_15', 'sofia@email.com', '34-91-234-5679', 'Calle de la Luz 67, Salamanca', 'sofia_morales.jpg', 'usuario'),
('Andrés Castro', 'andres_castro', 'hashed_password_16', 'andres@email.com', '34-91-345-6780', 'Calle de la Paz 89, Toledo', 'andres_castro.jpg', 'usuario'),
('Clara Ortega', 'clara_ortega', 'hashed_password_17', 'clara@email.com', '34-91-456-7891', 'Calle de la Libertad 34, Burgos', 'clara_ortega.jpg', 'usuario'),
('Pablo Herrera', 'pablo_herrera', 'hashed_password_18', 'pablo@email.com', '34-91-567-8902', 'Calle de la Historia 12, León', 'pablo_herrera.jpg', 'usuario'),
('Valentina Romero', 'valentina_romero', 'hashed_password_19', 'valentina@email.com', '34-91-678-9013', 'Calle de la Cultura 45, Soria', 'valentina_romero.jpg', 'usuario'),
('Ricardo Medina', 'ricardo_medina', 'hashed_password_20', 'ricardo@email.com', '34-91-789-0124', 'Calle de la Amistad 78, Almería', 'ricardo_medina.jpg', 'usuario'),
('Gabriela Silva', 'gabriela_silva', 'hashed_password_21', 'gabriela@email.com', '34-91-890-1235', 'Calle de la Esperanza 90, Huelva', 'gabriela_silva.jpg', 'usuario'),
('Samuel Vargas', 'samuel_vargas', 'hashed_password_22', 'samuel@email.com', '34-91-901-2346', 'Calle de la Libertad 12, Cádiz', 'samuel_vargas.jpg', 'usuario'),
('Natalia Peña', 'natalia_pena', 'hashed_password_23', 'natalia@email.com', '34-91-012-3457', 'Calle de la Paz 34, Tarragona', 'natalia_pena.jpg', 'usuario');


-- Products table
INSERT INTO Products (name, description, price, stock, category, photo) VALUES
('Figura de Goku', 'Figura de acción de Goku de Dragon Ball', 45.99, 150, 'figuras', 'goku.jpg'),
('manga naruto', 'Tomo 41 del manga de naruto', 12.50, 20, 'mangas', 'manga naruto.jpg'),
('Figura de Gojo Satoru', 'Figura Edición Especial de Satoru Gojo', 289.99, 5, 'figuras', 'Figura de Gojo Satoru.jpg'),
('Figura Luffy Gear 5', 'Figura Edición Coleccionista de Luffy Gear V', 149.99, 8, 'figuras', 'Figura Luffy Gear 5.jpg'),
('Camiseta de One Piece', 'Camiseta oficial de One Piece', 29.99, 120, 'merchandising', 'onepiece.jpg'),
('Manga de Death Note', 'Manga completo de Death Note', 39.99, 80, 'mangas', 'deathnote.jpg'),
('Póster de Demon Slayer', 'Póster de alta calidad de Demon Slayer', 15.99, 200, 'merchandising', 'demonslayer.jpg'),
('Sudadera de Attack on Titan', 'Sudadera oficial de Attack on Titan', 49.99, 60, 'merchandising', 'AOTsudadera.jpg'),
('Figura de Luffy', 'Figura de acción de Monkey D. Luffy', 239.99, 90, 'figuras', 'luffy.jpg'),
('Manga de My Hero Academia', 'Manga completo de My Hero Academia', 34.99, 70, 'mangas', 'MHA.jpg'),
('Taza de Naruto', 'Taza con diseño de Naruto', 12.99, 150, 'merchandising', 'narutotaza.jpg'),
('Almohada de Pikachu', 'Almohada suave de Pikachu', 25.99, 100, 'merchandising', 'pikachu.jpg'),
('Figura de Sasuke', 'Figura de acción de Sasuke Uchiha', 45.99, 110, 'figuras', 'sasuke.jpg'),
('Camiseta de Dragon Ball', 'Camiseta oficial de Dragon Ball', 29.99, 130, 'merchandising', 'dragonball.jpg'),
('Manga de Fairy Tail', 'Manga completo de Fairy Tail', 39.99, 75, 'mangas', 'fairytail.jpg'),
('Póster de My Hero Academia', 'Póster de alta calidad de My Hero Academia', 15.99, 180, 'merchandising', 'MHApóster.jpg'),
('Sudadera de Naruto', 'Sudadera oficial de Naruto', 49.99, 65, 'merchandising', 'narutosudadera.jpg'),
('Figura de Vegeta', 'Figura de acción de Vegeta', 55.99, 95, 'figuras', 'vegeta.jpg'),
('Manga de One Punch Man', 'Manga completo de One Punch Man', 34.99, 85, 'mangas', 'onepunchman.jpg'),
('Taza de One Piece', 'Taza con diseño de One Piece', 12.99, 140, 'merchandising', 'onepiecetaza.jpg'),
('Almohada de Totoro', 'Almohada suave de Totoro', 25.99, 110, 'merchandising', 'totoro.jpg'),
('Figura de Kakashi', 'Figura de acción de Kakashi Hatake', 45.99, 100, 'figuras', 'kakashi.jpg'),
('Camiseta de Demon Slayer', 'Camiseta oficial de Demon Slayer', 29.99, 125, 'merchandising', 'demonslayercamiseta.jpg'),
('Manga de Tokyo Ghoul', 'Manga completo de Tokyo Ghoul', 39.99, 70, 'mangas', 'tokyoghoul.jpg'),
('Póster de Dragon Ball', 'Póster de alta calidad de Dragon Ball', 15.99, 160, 'merchandising', 'dragonballpóster.jpg'),
('Sudadera de My Hero Academia', 'Sudadera oficial de My Hero Academia', 49.99, 60, 'merchandising', 'MHAsudadera.jpg'),
('Figura de All Might', 'Figura de acción de All Might', 55.99, 90, 'figuras', 'allmight.jpg'),
('Manga de Black Clover', 'Manga completo de Black Clover', 34.99, 80, 'mangas', 'blackclover.jpg'),
('Taza de Fairy Tail', 'Taza con diseño de Fairy Tail', 12.99, 150, 'merchandising', 'fairytailtaza.jpg'),
('Figura de Natsu', 'Figura de acción de Natsu Dragneel', 45.99, 95, 'figuras', 'natsu.jpg'),
('Manga de Assassination Classroom', 'Manga completo de Assassination Classroom', 39.99, 70, 'mangas', 'assassinationclassroom.jpg'),
('Póster de One Punch Man', 'Póster de alta calidad de One Punch Man', 15.99, 160, 'merchandising', 'onepunchmanpóster.jpg'),
('Figura de Erza', 'Figura de acción de Erza Scarlet', 165.99, 90, 'figuras', 'erza.jpg'),
('Manga de Sword Art Online', 'Manga completo de Sword Art Online', 34.99, 80, 'mangas', 'swordartonline.jpg'),
('Taza de Attack on Titan', 'Taza con diseño de Attack on Titan', 12.99, 140, 'merchandising', 'AOTtaza.jpg'),
('Figura de Shoto', 'Figura de acción de Shoto Todoroki', 45.99, 100, 'figuras', 'shoto.jpg'),
('Manga de One Piece', 'Manga completo de One Piece', 39.99, 70, 'mangas', 'onepiece2.jpg'),
('Póster de Naruto', 'Póster de alta calidad de Naruto', 15.99, 160, 'merchandising', 'narutopóster.jpg'),
('Manga de Boku no Hero Academia', 'Manga completo de Boku no Hero Academia', 34.99, 80, 'mangas', 'bokunohero.jpg'),
('Taza de Black Clover', 'Taza con diseño de Black Clover', 12.99, 150, 'merchandising', 'blackclovertaza.jpg'),
('Figura de Gintoki', 'Figura de acción de Gintoki Sakata', 45.99, 95, 'figuras', 'gintoki.jpg'),
('Manga de Re:Zero', 'Manga completo de Re:Zero', 39.99, 70, 'mangas', 'rezero.jpg'),
('Póster de Gintama', 'Póster de alta calidad de Gintama', 15.99, 160, 'merchandising', 'gintamapóster.jpg'),
('Sudadera de Re:Zero', 'Sudadera oficial de Re:Zero', 49.99, 65, 'merchandising', 'rezorosudadera.jpg'),
('Figura de Rem', 'Figura de acción de Rem', 55.99, 90, 'figuras', 'rem.jpg'),
('Manga de Mob Psycho 100', 'Manga completo de Mob Psycho 100', 34.99, 80, 'mangas', 'mobpsycho.jpg'),
('Taza de Demon Slayer', 'Taza con diseño de Demon Slayer', 12.99, 140, 'merchandising', 'tazaslayer.jpg');

-- Product_photos table
INSERT INTO Product_photos (id_product, photo) VALUES
(1, 'gokuAd1.jpg'),
(3, 'gojoAd1.jpg'),
(3, 'gojoAd2.jpg'),
(4, 'luffyAd10.jpg'),
(4, 'luffyAd11.jpg'),
(4, 'luffyAd12.jpg'),
(4, 'luffyAd13.jpg'),
(9, 'luffyAd1.jpg'),
(9, 'luffyAd2.jpg'),
(11, 'narutotazaAd1.jpg'),
(11, 'narutotazaAd2.jpg'),
(22, 'kakashiAd1.jpg'),
(22, 'kakashiAd2.jpg'),
(27, 'allmightAd1.jpg'),
(27, 'allmightAd2.jpg'),
(30, 'natsuAd1.jpg'),
(30, 'natsuAd2.jpg'),
(33, 'erzaAd1.jpg'),
(33, 'erzaAd2.jpg'),
(41, 'gintokiAd1.jpg'),
(41, 'gintokiAd2.jpg');

-- Promotion table
INSERT INTO Promotion (code, discount, description, start_date, end_date) VALUES
('SUMMER2023', 15, 'Summer Sale 2023', '2023-06-01', '2023-08-31'),
('NEWUSER10', 10, 'New User Discount', '2023-01-01', '2023-12-31'),
('ANIME5OFF', 5, 'Anime Lovers Discount', '2023-05-01', '2023-07-31');

-- Product_promotions table
INSERT INTO Product_promotions (id_product, id_promotion) VALUES
(1, 1),
(2, 1),
(3, 2),
(43, 3),
(6, 3),
(13, 1),
(23, 1),
(7, 1),
(40, 3),
(34, 2),
(27, 1),
(18, 1),
(9, 3);

-- Cart table
INSERT INTO Cart (id_user, id_product, quantity) VALUES
(2, 1, 2),
(2, 3, 1),
(3, 2, 1);

-- Orders table
INSERT INTO Orders (id_user, order_date, arrive_date, address, billing, state) VALUES
(1, '2023-05-01', '2023-05-15', 'Calle Mayor 12, Madrid', 'Tarjeta de crédito terminada en 5678', 'enviado'),
(1, '2023-06-01', '2023-06-15', 'Calle Mayor 12, Madrid', 'PayPal', 'procesando'),
(2, '2023-05-15', '2023-05-29', 'Avenida Diagonal 45, Barcelona', 'Tarjeta de crédito terminada en 1234', 'enviado'),
(3, '2023-05-20', '2023-06-03', 'Calle de la Paz 23, Valencia', 'PayPal', 'procesando'),
(4, '2023-05-10', '2023-05-24', 'Calle San Fernando 5, Sevilla', 'Tarjeta de crédito terminada en 4321', 'enviado'),
(5, '2023-05-12', '2023-05-26', 'Calle de la Libertad 78, Bilbao', 'Tarjeta de crédito terminada en 8765', 'enviado'),
(6, '2023-05-15', '2023-05-29', 'Calle del Cid 34, Zaragoza', 'PayPal', 'procesando'),
(7, '2023-05-18', '2023-06-01', 'Calle de la Constitución 56, Málaga', 'Tarjeta de crédito terminada en 3456', 'enviado'),
(8, '2023-05-22', '2023-06-05', 'Calle de la Reina 90, Murcia', 'Tarjeta de crédito terminada en 6543', 'procesando'),
(9, '2023-05-25', '2023-06-08', 'Calle de la Cruz 12, Alicante', 'PayPal', 'enviado'),
(10, '2023-05-30', '2023-06-12', 'Calle de la Esperanza 45, Granada', 'Tarjeta de crédito terminada en 7890', 'enviado'),
(11, '2023-06-01', '2023-06-15', 'Calle del Sol 23, Córdoba', 'PayPal', 'procesando'),
(12, '2023-06-05', '2023-06-19', 'Calle de la Luz 67, Salamanca', 'Tarjeta de crédito terminada en 1234', 'enviado'),
(13, '2023-06-10', '2023-06-24', 'Calle de la Paz 89, Toledo', 'Tarjeta de crédito terminada en 5678', 'enviado'),
(14, '2023-06-12', '2023-06-26', 'Calle de la Libertad 34, Burgos', 'PayPal', 'procesando'),
(15, '2023-06-15', '2023-06-29', 'Calle de la Historia 12, León', 'Tarjeta de crédito terminada en 4321', 'enviado'),
(16, '2023-06-18', '2023-07-02', 'Calle de la Cultura 45, Soria', 'Tarjeta de crédito terminada en 8765', 'enviado'),
(17, '2023-06-20', '2023-07-04', 'Calle de la Amistad 78, Almería', 'PayPal', 'procesando'),
(18, '2023-06-22', '2023-07-06', 'Calle de la Esperanza 90, Huelva', 'Tarjeta de crédito terminada en 3456', 'enviado'),
(19, '2023-06-25', '2023-07-09', 'Calle de la Libertad 12, Cádiz', 'Tarjeta de crédito terminada en 6543', 'enviado'),
(20, '2023-06-28', '2023-07-12', 'Calle de la Paz 34, Tarragona', 'PayPal', 'procesando');

INSERT INTO Order_details (id_order, id_product, quantity, subtotal) VALUES
(1, 1, 1, 45.99),
(1, 2, 1, 12.50),
(2, 3, 1, 289.99),
(2, 4, 1, 149.99),
(3, 5, 2, 59.98),
(4, 6, 1, 39.99),
(5, 7, 1, 15.99),
(6, 8, 1, 49.99),
(7, 9, 1, 239.99),
(8, 10, 1, 34.99),
(9, 11, 1, 12.99),
(10, 12, 1, 25.99),
(11, 13, 1, 45.99),
(12, 14, 1, 29.99),
(13, 15, 1, 39.99),
(14, 16, 1, 15.99),
(15, 17, 1, 49.99),
(16, 18, 1, 55.99),
(17, 19, 1, 34.99),
(18, 20, 1, 12.99),
(19, 21, 1, 25.99),
(20, 22, 1, 45.99),
(21, 23, 29.99);