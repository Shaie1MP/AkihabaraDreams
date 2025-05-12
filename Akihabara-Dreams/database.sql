CREATE DATABASE akihabaraDreams;
USE akihabaraDreams;

CREATE TABLE Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) not null,
    username VARCHAR(100) unique not null,
    password TEXT not null,
    email VARCHAR(100) not null unique,
    phone VARCHAR(15),
    address_1 TEXT,
    address_2 TEXT,
    address_3 TEXT,
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

CREATE TABLE Wishlist (
    id_wishlist INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_product INT NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_product) REFERENCES Products(id_product) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist_item (id_user, id_product)
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
    arrival_date DATE DEFAULT (CURRENT_DATE + INTERVAL 14 DAY),
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

CREATE VIEW View_Cart AS
SELECT 
    c.id_user,
    c.id_product,
    p.name AS product_name,
    c.quantity,
    (p.price * c.quantity) AS total,
    p.photo,
    p.price
FROM 
    Cart c
inner join 
    Products p
ON 
    c.id_product = p.id_product;

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
LIMIT 6;

CREATE VIEW Products_With_Promotions AS
SELECT 
    p.*,
    pr.discount,
    pr.id_promotion,
    ROUND(p.price * (1 - (pr.discount / 100)), 2) AS discounted_price
    FROM 
        Products p
    INNER JOIN 
        Product_promotions pp ON p.id_product = pp.id_product
    INNER JOIN 
        Promotion pr ON pp.id_promotion = pr.id_promotion
    ORDER BY 
        p.id_product;

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

CREATE VIEW View_Product_Stock AS
SELECT 
    p.id_product,
    p.name,
    p.stock,
    p.category,
CASE 
    WHEN p.stock > 10 THEN 'Disponible'
    WHEN p.stock > 0 THEN 'Bajo stock'
ELSE 'Agotado'
    END AS stock_status
FROM 
    Products p
ORDER BY 
     p.stock DESC;

CREATE VIEW View_Wishlist AS
SELECT 
    w.id_wishlist,
    w.id_user,
    w.id_product,
    w.date_added,
    p.name AS product_name,
    p.price,
    p.photo,
    p.description,
    p.stock,
    p.category
FROM 
    Wishlist w
JOIN 
    Products p ON w.id_product = p.id_product;

DELIMITER $$
CREATE PROCEDURE SaveCart(IN userId INT, IN products JSON)
BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE quantity INT;
    DECLARE id_product INT;
    DECLARE num_products INT;
    SET num_products = JSON_LENGTH(products);
    DELETE FROM Cart WHERE id_user = userId;
    WHILE i < num_products DO
        SET id_product = JSON_UNQUOTE(JSON_EXTRACT(products, CONCAT('$[', i, '].id_product')));
        SET quantity = JSON_UNQUOTE(JSON_EXTRACT(products, CONCAT('$[', i, '].quantity')));
        IF id_product IS NOT NULL AND quantity IS NOT NULL THEN
            INSERT INTO Cart (id_user, id_product, quantity)
            VALUES (userId, id_product, quantity);
        END IF;
        SET i = i + 1;
    END WHILE;
END $$
DELIMITER ;

INSERT INTO Users (name, username, password, email, phone, address_1, address_2, address_3, profilePic, role) VALUES
('Sergio Martín', 'sergio_mu', '$2y$10$r9FN3AE1L35nOAxEaCR.suZPihS7.cEOgI3MtLVxO5Aogwm9fmyzm', 'sergio_mu@gmail.com', '34-65-467-4563', 'Calle Doña Perfecta, 22', null, null, 'sergio_mu.png', 'admin'),
('Carlos Pérez', 'carlos123', 'hashed_password_4', 'carlos@gmail.com', '34-91-123-4567', 'Calle Mayor 12, Madrid', null, null, 'carlos123.jpg', 'usuario'),
('María López', 'maria_lopez', 'hashed_password_5', 'maria@gmail.com', '34-91-234-5678', 'Avenida Diagonal 45, Barcelona', null, null, 'maria_lopez.jpg', 'usuario'),
('Juan García', 'juan_garcia', 'hashed_password_6', 'juan@gmail.com', '34-91-345-6789', 'Calle de la Paz 23, Valencia', null, null, 'juan_garcia.jpg', 'usuario'),
('Ana Martínez', 'ana_martinez', 'hashed_password_7', 'ana@gmail.com', '34-91-456-7890', 'Calle San Fernando 5, Sevilla', null, null, 'ana_martinez.jpg', 'usuario'),
('Luis Fernández', 'luis_fernandez', 'hashed_password_8', 'luis@gmail.com', '34-91-567-8901', 'Calle de la Libertad 78, Bilbao', null, null, 'luis_fernandez.jpg', 'usuario'),
('Laura Sánchez', 'laura_sanchez', 'hashed_password_9', 'laura@gmail.com', '34-91-678-9012', 'Calle del Cid 34, Zaragoza', null, null, 'laura_sanchez.jpg', 'usuario'),
('Irene Gil', 'irenegs', 'hashed_password_10', 'irene@gmail.com', '34-91-789-0123', 'Calle de la Constitución 56, Málaga', null, null, 'irenegs.jpg', 'usuario'),
('Patricia Gómez', 'patricia_gomez', 'hashed_password_11', 'patricia@gmail.com', '34-91-890-1234', 'Calle de la Reina 90, Murcia', null, null, 'patricia_gomez.jpg', 'usuario'),
('Fernando Ruiz', 'fernando_ruiz', 'hashed_password_12', 'fernando@gmail.com', '34-91-901-2345', 'Calle de la Cruz 12, Alicante', null, null, 'fernando_ruiz.jpg', 'usuario'),
('Isabel Torres', 'isabel_torres', 'hashed_password_13', 'isabel@gmail.com', '34-91-012-3456', 'Calle de la Esperanza 45, Granada', null, null, 'isabel_torres.jpg', 'usuario'),
('Diego Jiménez', 'diego_jimenez', 'hashed_password_14', 'diego@gmail.com', '34-91-123-4568', 'Calle del Sol 23, Córdoba', null, null, 'diego_jimenez.jpg', 'usuario'),
('Sofía Morales', 'sofia_morales', 'hashed_password_15', 'sofia@gmail.com', '34-91-234-5679', 'Calle de la Luz 67, Salamanca', null, null, 'sofia_morales.jpg', 'usuario'),
('Andrés Castro', 'andres_castro', 'hashed_password_16', 'andres@gmail.com', '34-91-345-6780', 'Calle de la Paz 89, Toledo', null, null, 'andres_castro.jpg', 'usuario'),
('Clara Ortega', 'clara_ortega', 'hashed_password_17', 'clara@gmail.com', '34-91-456-7891', 'Calle de la Libertad 34, Burgos', null, null, 'clara_ortega.jpg', 'usuario'),
('Pablo Herrera', 'pablo_herrera', 'hashed_password_18', 'pablo@email.com', '34-91-567-8902', 'Calle de la Historia 12, León', null, null, 'pablo_herrera.jpg', 'usuario'),
('Valentina Romero', 'valentina_romero', 'hashed_password_19', 'valentina@gmail.com', '34-91-678-9013', 'Calle de la Cultura 45, Soria', null, null, 'valentina_romero.jpg', 'usuario'),
('Ricardo Medina', 'ricardo_medina', 'hashed_password_20', 'ricardo@gmail.com', '34-91-789-0124', 'Calle de la Amistad 78, Almería', null, null, 'ricardo_medina.jpg', 'usuario'),
('Gabriela Silva', 'gabriela_silva', 'hashed_password_21', 'gabriela@gmail.com', '34-91-890-1235', 'Calle de la Esperanza 90, Huelva', null, null, 'gabriela_silva.jpg', 'usuario'),
('Samuel Vargas', 'samuel_vargas', 'hashed_password_22', 'samuel@gmail.com', '34-91-901-2346', 'Calle de la Libertad 12, Cádiz', null, null, 'samuel_vargas.jpg', 'usuario'),
('Natalia Peña', 'natalia_pena', 'hashed_password_23', 'natalia@gmail.com', '34-91-012-3457', 'Calle de la Paz 34, Tarragona', null, null, 'natalia_pena.jpg', 'usuario');

INSERT INTO Products (name, description, price, stock, category, photo) VALUES
('Figura de Goku', 'Figura de acción de Goku de Dragon Ball', 45.99, 150, 'figuras', 'goku.jpg'),
('manga naruto', 'Tomo 41 del manga de naruto', 12.50, 20, 'mangas', 'manga_naruto.jpg'),
('Figura de Gojo Satoru', 'Figura Edición Especial de Satoru Gojo', 289.99, 5, 'figuras', 'gojo.jpg'),
('Figura Luffy Gear 5', 'Figura Edición Coleccionista de Luffy Gear V', 149.99, 8, 'figuras', 'Figura_Luffy_5.jpg'),
('Camiseta de One Piece', 'Camiseta oficial de One Piece', 29.99, 120, 'merchandising', 'onepiece.jpg'),
('Manga de Death Note', 'Manga completo de Death Note', 39.99, 80, 'mangas', 'deathnote.jpg'),
('Poster de Demon Slayer', 'Poster de alta calidad de Demon Slayer', 15.99, 200, 'merchandising', 'demonslayer.jpg'),
('Sudadera de Attack on Titan', 'Sudadera oficial de Attack on Titan', 49.99, 60, 'merchandising', 'AOTsudadera.jpg'),
('Figura de Luffy', 'Figura de acción de Monkey D. Luffy', 239.99, 90, 'figuras', 'luffy.jpg'),
('Manga de My Hero Academia', 'Manga completo de My Hero Academia', 34.99, 70, 'mangas', 'MHA.jpg'),
('Taza de Naruto', 'Taza con diseño de Naruto', 12.99, 150, 'merchandising', 'narutotaza.jpg'),
('Almohada de Pikachu', 'Almohada suave de Pikachu', 25.99, 100, 'merchandising', 'pikachu.jpg'),
('Figura de Sasuke', 'Figura de acción de Sasuke Uchiha', 45.99, 110, 'figuras', 'sasuke.jpg'),
('Camiseta de Dragon Ball', 'Camiseta oficial de Dragon Ball', 29.99, 130, 'merchandising', 'dragonball.jpg'),
('Manga de Fairy Tail', 'Manga completo de Fairy Tail', 39.99, 75, 'mangas', 'fairytail.jpg'),
('Poster de My Hero Academia', 'Poster de alta calidad de My Hero Academia', 15.99, 180, 'merchandising', 'MHApóster.jpg'),
('Sudadera de Naruto', 'Sudadera oficial de Naruto', 49.99, 65, 'merchandising', 'narutosudadera.jpg'),
('Figura de Vegeta', 'Figura de acción de Vegeta', 55.99, 95, 'figuras', 'vegeta.jpg'),
('Manga de One Punch Man', 'Manga completo de One Punch Man', 34.99, 85, 'mangas', 'onepunchman.jpg'),
('Taza de One Piece', 'Taza con diseño de One Piece', 12.99, 140, 'merchandising', 'onepiecetaza.jpg'),
('Almohada de Totoro', 'Almohada suave de Totoro', 25.99, 110, 'merchandising', 'totoro.jpg'),
('Figura de Kakashi', 'Figura de acción de Kakashi Hatake', 45.99, 100, 'figuras', 'kakashi.jpg'),
('Camiseta de Demon Slayer', 'Camiseta oficial de Demon Slayer', 29.99, 125, 'merchandising', 'demonslayercamiseta.jpg'),
('Manga de Tokyo Ghoul', 'Manga completo de Tokyo Ghoul', 39.99, 70, 'mangas', 'tokyoghoul.jpg'),
('Poster de Dragon Ball', 'Poster de alta calidad de Dragon Ball', 15.99, 160, 'merchandising', 'dragonballpóster.jpg'),
('Sudadera de My Hero Academia', 'Sudadera oficial de My Hero Academia', 49.99, 60, 'merchandising', 'MHAsudadera.jpg'),
('Figura de All Might', 'Figura de acción de All Might', 55.99, 90, 'figuras', 'allmight.jpg'),
('Manga de Black Clover', 'Manga completo de Black Clover', 34.99, 80, 'mangas', 'blackclover.jpg'),
('Taza de Fairy Tail', 'Taza con diseño de Fairy Tail', 12.99, 150, 'merchandising', 'fairytailtaza.jpg'),
('Figura de Natsu', 'Figura de acción de Natsu Dragneel', 45.99, 95, 'figuras', 'natsu.jpg'),
('Manga de Assassination Classroom', 'Manga completo de Assassination Classroom', 39.99, 70, 'mangas', 'assassinationclassroom.jpg'),
('Poster de One Punch Man', 'Poster de alta calidad de One Punch Man', 15.99, 160, 'merchandising', 'onepunchmanpóster.jpg'),
('Figura de Erza', 'Figura de acción de Erza Scarlet', 165.99, 90, 'figuras', 'erza.jpg'),
('Manga de Sword Art Online', 'Manga completo de Sword Art Online', 34.99, 80, 'mangas', 'swordartonline.jpg'),
('Taza de Attack on Titan', 'Taza con diseño de Attack on Titan', 12.99, 140, 'merchandising', 'AOTtaza.jpg'),
('Figura de Shoto', 'Figura de acción de Shoto Todoroki', 45.99, 100, 'figuras', 'shoto.jpg'),
('Manga de One Piece', 'Manga completo de One Piece', 39.99, 70, 'mangas', 'onepiece2.jpg'),
('Poster de Naruto', 'Poster de alta calidad de Naruto', 15.99, 160, 'merchandising', 'narutopóster.jpg'),
('Manga de Boku no Hero Academia', 'Manga completo de Boku no Hero Academia', 34.99, 80, 'mangas', 'bokunohero.jpg'),
('Taza de Black Clover', 'Taza con diseño de Black Clover', 12.99, 150, 'merchandising', 'blackclovertaza.jpg'),
('Figura de Gintoki', 'Figura de acción de Gintoki Sakata', 45.99, 95, 'figuras', 'gintoki.jpg'),
('Manga de Re:Zero', 'Manga completo de Re:Zero', 39.99, 70, 'mangas', 'rezero.jpg'),
('Poster de Gintama', 'Poster de alta calidad de Gintama', 15.99, 160, 'merchandising', 'gintamapóster.jpg'),
('Sudadera de Re:Zero', 'Sudadera oficial de Re:Zero', 49.99, 65, 'merchandising', 'rezorosudadera.jpg'),
('Figura de Rem', 'Figura de acción de Rem', 55.99, 90, 'figuras', 'rem.jpg'),
('Manga de Mob Psycho 100', 'Manga completo de Mob Psycho 100', 34.99, 80, 'mangas', 'mobpsycho.jpg'),
('Taza de Demon Slayer', 'Taza con diseño de Demon Slayer', 12.99, 140, 'merchandising', 'tazaslayer.jpg'),
('Figura de Tanjiro', 'Figura de acción de Tanjiro Kamado', 49.99, 80, 'figuras', 'tanjiro.jpg'),
('Manga de Bleach', 'Manga completo de Bleach', 39.99, 75, 'mangas', 'bleach.jpg'),
('Llavero de Bleach', 'Llavero metálico de Bleach', 9.99, 200, 'merchandising', 'bleachllavero.jpg'),
('Poster de One Piece', 'Poster de alta calidad de One Piece', 15.99, 180, 'merchandising', 'onepieceposter.jpg'),
('Figura de Zenitsu', 'Figura de acción de Zenitsu Agatsuma', 45.99, 95, 'figuras', 'zenitsu.jpg'),
('Manga de Noragami', 'Manga completo de Noragami', 34.99, 85, 'mangas', 'noragami.jpg'),
('Taza de Bleach', 'Taza con diseño de Bleach', 12.99, 140, 'merchandising', 'bleachtaza.jpg'),
('Figura de Killua', 'Figura de acción de Killua Zoldyck', 55.99, 90, 'figuras', 'killua.jpg'),
('Manga de Hunter x Hunter', 'Manga completo de Hunter x Hunter', 39.99, 70, 'mangas', 'hunterxhunter.jpg'),
('Poster de Jujutsu Kaisen', 'Poster de alta calidad de Jujutsu Kaisen', 15.99, 160, 'merchandising', 'jujutsuposter.jpg'),
('Llavero de Jujutsu Kaisen', 'Llavero metálico de Jujutsu Kaisen', 9.99, 190, 'merchandising', 'jujutsullavero.jpg'),
('Figura de Nezuko', 'Figura de acción de Nezuko Kamado', 49.99, 85, 'figuras', 'nezuko.jpg'),
('Manga de Fullmetal Alchemist', 'Manga completo de Fullmetal Alchemist', 39.99, 80, 'mangas', 'fullmetal.jpg'),
('Llavero de Fullmetal Alchemist', 'Llavero con diseño de Fullmetal Alchemist', 9.99, 195, 'merchandising', 'fullmetalllavero.jpg'),
('Figura de Rengoku', 'Figura de acción de Kyojuro Rengoku', 59.99, 70, 'figuras', 'rengoku.jpg'),
('Manga de Vinland Saga', 'Manga completo de Vinland Saga', 39.99, 75, 'mangas', 'vinlandsaga.jpg'),
('Poster de Black Clover', 'Poster de alta calidad de Black Clover', 15.99, 175, 'merchandising', 'blackcloverposter.jpg'),
('Figura de Escanor', 'Figura de acción de Escanor', 69.99, 60, 'figuras', 'escanor.jpg'),
('Manga de The Seven Deadly Sins', 'Manga completo de The Seven Deadly Sins', 39.99, 80, 'mangas', '7sins.jpg'),
('Llavero de The Seven Deadly Sins', 'Llavero con diseño de The Seven Deadly Sins', 9.99, 180, 'merchandising', '7sinsllavero.jpg'),
('Figura de Itachi', 'Figura de acción de Itachi Uchiha', 55.99, 85, 'figuras', 'itachi.jpg'),
('Manga de Hellsing', 'Manga completo de Hellsing', 34.99, 75, 'mangas', 'hellsing.jpg'),
('Llavero de Hellsing', 'Llavero con diseño de Hellsing', 9.99, 170, 'merchandising', 'hellsingllavero.jpg'),
('Figura de Mikasa', 'Figura de acción de Mikasa Ackerman', 59.99, 80, 'figuras', 'mikasa.jpg'),
('Manga de Trigun', 'Manga completo de Trigun', 34.99, 85, 'mangas', 'trigun.jpg'),
('Poster de Tokyo Revengers', 'Poster de alta calidad de Tokyo Revengers', 15.99, 190, 'merchandising', 'tokyorevposter.jpg'),
('Figura de Mickey', 'Figura de acción de Mickey de Tokyo Revengers', 49.99, 70, 'figuras', 'mickey.jpg'),
('Manga de Tokyo Revengers', 'Manga completo de Tokyo Revengers', 39.99, 75, 'mangas', 'tokyorev.jpg'),
('Figura de Ryuk', 'Figura de acción de Ryuk de Death Note', 55.99, 75, 'figuras', 'ryuk.jpg'),
('Manga de JoJo’s Bizarre Adventure', 'Manga completo de JoJo’s Bizarre Adventure', 39.99, 80, 'mangas', 'jojo.jpg'),
('Llavero de JoJo’s Bizarre Adventure', 'Llavero con diseño de JoJo’s Bizarre Adventure', 9.99, 175, 'merchandising', 'jojollavero.jpg'),
('Figura de Edward Elric', 'Figura de acción de Edward Elric', 59.99, 70, 'figuras', 'edward.jpg'),
('Manga de Blue Lock', 'Manga completo de Blue Lock', 39.99, 75, 'mangas', 'bluelock.jpg'),
('Figura de Nagi', 'Figura de acción de Nagi Seishiro', 245.99, 90, 'figuras', 'nagi.jpg'),
('Manga de Fire Force', 'Manga completo de Fire Force', 34.99, 85, 'mangas', 'fireforce.jpg'),
('Manga de Chainsaw Man', 'Manga completo de Chainsaw Man', 39.99, 75, 'mangas', 'chainsawman.jpg'),
('Llavero de Chainsaw Man', 'Llavero con diseño de Chainsaw Man', 9.99, 190, 'merchandising', 'chainsawllavero.jpg'),
('Figura de Power', 'Figura de acción de Power de Chainsaw Man', 49.99, 85, 'figuras', 'power.jpg');;

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
(41, 'gintokiAd2.jpg'),
(48, 'bleachllaveroAd1.jpg'),
(54, 'killuaAd1.jpg'),
(54, 'killuaAd2.jpg'),
(57, 'jujutsullaveroAd1.jpg'),
(58, 'nezukoAd1.jpg'),
(58, 'nezukoAd2.jpg'),
(61, 'rengokuAd1.jpg'),
(61, 'rengokuAd2.jpg'),
(65, 'escanorAd1.jpg'),
(65, 'escanorAd2.jpg'),
(68, 'itachiAd1.jpg'),
(68, 'itachiAd2.jpg'),
(71, 'mikasaAd1.jpg'),
(74, 'mickeyAd1.jpg'),
(74, 'mickeyAd2.jpg'),
(76, 'ryukAd1.jpg'),
(76, 'ryukAd2.jpg'),
(79, 'edwardAd1.jpg'),
(79, 'edwardAd2.jpg'),
(81, 'nagiAd1.jpg'),
(85, 'powerAd1.jpg'),
(85, 'powerAd2.jpg');

INSERT INTO Promotion (code, discount, description, start_date, end_date) VALUES
('SUMMER2025', 15, 'Summer Sale 2025', '2025-06-01', '2025-08-31'),
('NEWUSER10', 10, 'New User Discount', '2025-01-01', '2025-12-31'),
('ANIME5OFF', 5, 'Anime Lovers Discount', '2025-05-01', '2025-07-31'),
('ERASMUS25', 25, 'Eramus Sale 2025', '2025-03-12', '2025-05-17');

INSERT INTO Product_promotions (id_product, id_promotion) VALUES
(1, 1),
(2, 1),
(3, 2),
(15, 2),
(16, 2),
(73, 2),
(53, 2),
(24, 2),
(8, 2),
(54, 2),
(32, 2),
(33, 2),
(80, 2),
(22, 4),
(12, 4),
(55, 4),
(41, 4),
(20, 4),
(48, 4),
(14, 4),
(56, 4),
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

INSERT INTO Cart (id_user, id_product, quantity) VALUES
(2, 1, 2),
(2, 3, 1),
(3, 2, 1);

INSERT INTO Orders (id_user, order_date, arrival_date, address, billing, state) VALUES
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
(21, 23, 1, 29.99);