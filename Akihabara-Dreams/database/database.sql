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
INSERT INTO Users (name, username, password, email, phone, address, role) VALUES
('Akira Tanaka', 'akira123', 'hashed_password_1', 'akira@email.com', '81-3-1234-5678', 'Tokyo, Japan', 'admin'),
('Yuki Sato', 'yuki_otaku', 'hashed_password_2', 'yuki@email.com', '81-3-2345-6789', 'Osaka, Japan', 'usuario'),
('John Smith', 'john_anime_fan', 'hashed_password_3', 'john@email.com', '1-555-123-4567', 'New York, USA', 'usuario');

-- Products table
INSERT INTO Products (name, description, price, stock, photo) VALUES
('Naruto Figurine', 'High-quality Naruto Uzumaki action figure', 59.99, 100, 'naruto.jpg'),
('Attack on Titan Manga Set', 'Complete set of Attack on Titan manga', 199.99, 50, 'AOTset.jpg'),
('My Hero Academia T-shirt', 'Official My Hero Academia t-shirt', 24.99, 200, 'MHAtshirt.jpg');

-- Product_photos table
INSERT INTO Product_photos (id_product, photo) VALUES
(1, 'naruto_figure_1.jpg'),
(1, 'naruto_figure_2.jpg'),
(2, 'aot_manga_cover.jpg'),
(3, 'mha_tshirt_front.jpg'),
(3, 'mha_tshirt_back.jpg');

-- Promotion table
INSERT INTO Promotion (code, discount, description, start_date, end_date) VALUES
('SUMMER2023', 15, 'Summer Sale 2023', '2023-06-01', '2023-08-31'),
('NEWUSER10', 10, 'New User Discount', '2023-01-01', '2023-12-31'),
('ANIME5OFF', 5, 'Anime Lovers Discount', '2023-05-01', '2023-07-31');

-- Product_promotions table
INSERT INTO Product_promotions (id_product, id_promotion) VALUES
(1, 1),
(2, 1),
(3, 1),
(1, 3),
(2, 3);

-- Cart table
INSERT INTO Cart (id_user, id_product, quantity) VALUES
(2, 1, 2),
(2, 3, 1),
(3, 2, 1);

-- Orders table
INSERT INTO Orders (id_user, order_date, arrive_date, address, billing, state) VALUES
(2, '2023-05-15', '2023-05-29', 'Osaka, Japan', 'Credit Card ending in 1234', 'enviado'),
(3, '2023-05-20', '2023-06-03', 'New York, USA', 'PayPal', 'procesando');

-- Order_details table
INSERT INTO Order_details (id_order, id_product, quantity, subtotal) VALUES
(1, 1, 1, 59.99),
(1, 3, 2, 49.98),
(2, 2, 1, 199.99);