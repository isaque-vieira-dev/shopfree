SET NAMES utf8mb4;

-- =========================
-- TABELA: role
-- =========================

CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- =========================
-- TABELA: user
-- =========================

CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_role
    FOREIGN KEY (role_id) REFERENCES role(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

-- =========================
-- TABELA: address
-- =========================

CREATE TABLE IF NOT EXISTS address (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    street VARCHAR(255) NOT NULL,
    number VARCHAR(20) NOT NULL,
    complement VARCHAR(100) NULL,
    neighborhood VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(50) NOT NULL,
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL DEFAULT 'Brasil',
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_address_user
    FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =========================
-- TABELA: category
-- =========================

CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    image_path TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- TABELA: product
-- =========================

CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_path TEXT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_product_user
    FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    CONSTRAINT fk_product_category
    FOREIGN KEY (category_id) REFERENCES category(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
);

-- =========================
-- TABELA: cart
-- 0,1 carrinho por usuário
-- =========================
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_user
    FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- =========================
-- TABELA: cart_item
-- =========================

CREATE TABLE IF NOT EXISTS cart_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_cart_item_cart
    FOREIGN KEY (cart_id) REFERENCES cart(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_cart_item_product
    FOREIGN KEY (product_id) REFERENCES product(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    CONSTRAINT chk_cart_item_quantity
    CHECK (quantity > 0),
    CONSTRAINT chk_cart_item_unit_price
    CHECK (unit_price >= 0),
    CONSTRAINT uq_cart_product
    UNIQUE (cart_id, product_id)
);

-- =========================
-- TABELA: orders
-- 1 carrinho gera 1 pedido
-- =========================

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL UNIQUE,
    user_id INT NOT NULL,
    address_id INT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'PENDING',
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_cart
    FOREIGN KEY (cart_id) REFERENCES cart(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES user(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    CONSTRAINT fk_orders_address
    FOREIGN KEY (address_id) REFERENCES address(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
    CONSTRAINT chk_orders_total
    CHECK (total >= 0)
);

-- =========================
-- TABELA: order_item
-- =========================

CREATE TABLE IF NOT EXISTS order_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_order_item_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT fk_order_item_product
    FOREIGN KEY (product_id) REFERENCES product(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
    CONSTRAINT chk_order_item_quantity
    CHECK (quantity > 0),
    CONSTRAINT chk_order_item_unit_price
    CHECK (unit_price >= 0),
    CONSTRAINT chk_order_item_subtotal
    CHECK (subtotal >= 0),
    CONSTRAINT uq_order_product
    UNIQUE (order_id, product_id)
);

-- =========================
-- TABELA: password_resets
-- =========================

CREATE TABLE IF NOT EXISTS password_resets (
    email VARCHAR(150) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL
);

-- =========================
-- POPULAR DADOS INICIAIS
-- =========================

INSERT IGNORE INTO role (name) VALUES ('admin'), ('client'), ('seller');

-- =========================
-- USUÁRIO ADMINISTRADOR PADRÃO
-- =========================

-- Senha: admin123
INSERT IGNORE INTO user (role_id, name, email, password) 
VALUES (
    (SELECT id FROM role WHERE name = 'admin' LIMIT 1), 
    'Administrador', 
    'admin@shopfree.com', 
    '$2y$10$BNaU8LSPYA3vJxeHKVdfxOLgky5dU5gl3goiLa9j1PLdpSLZAh6DW'
);

-- =========================
-- USUÁRIO VENDEDOR PADRÃO
-- =========================

-- Senha: admin123
INSERT IGNORE INTO user (role_id, name, email, password) 
VALUES (
    (SELECT id FROM role WHERE name = 'seller' LIMIT 1), 
    'Vendedor', 
    'vendedor@shopfree.com', 
    '$2y$10$BNaU8LSPYA3vJxeHKVdfxOLgky5dU5gl3goiLa9j1PLdpSLZAh6DW'
);

-- =========================
-- USUÁRIO CLIENTE PADRÃO
-- =========================

-- Senha: admin123
INSERT IGNORE INTO user (role_id, name, email, password) 
VALUES (
    (SELECT id FROM role WHERE name = 'client' LIMIT 1), 
    'Cliente', 
    'cliente@shopfree.com', 
    '$2y$10$BNaU8LSPYA3vJxeHKVdfxOLgky5dU5gl3goiLa9j1PLdpSLZAh6DW'
);

INSERT IGNORE INTO category (name, image_path) VALUES 
('Eletrônicos', 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=150&auto=format&fit=crop'), 
('Roupas & Acessórios', 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=150&auto=format&fit=crop'), 
('Casa & Decoração', 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=150&auto=format&fit=crop');

-- =========================
-- PRODUTOS INICIAIS
-- =========================
INSERT IGNORE INTO product (user_id, category_id, name, description, price, stock, image_path) VALUES
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Eletrônicos' LIMIT 1),
    'Monitor Gamer 24" UltraWide',
    'Monitor gamer de alta performance com painel IPS, 144Hz de taxa de atualização e 1ms de tempo de resposta. Perfeito para jogos competitivos e trabalho multitarefa.',
    1299.90,
    15,
    'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Eletrônicos' LIMIT 1),
    'Teclado Mecânico RGB',
    'Teclado mecânico mec-switch blue com retroiluminação RGB customizável, design ergonômico e teclas anti-ghosting.',
    349.90,
    20,
    'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Eletrônicos' LIMIT 1),
    'Headset Gamer 7.1 Surround',
    'Experimente um som imersivo de cinema com o sistema 7.1 canais virtuais, microfone com cancelamento de ruído e almofadas ultra macias.',
    259.90,
    25,
    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Eletrônicos' LIMIT 1),
    'Mouse Wireless Ergonomic',
    'Mouse sem fio ergonômico de alta precisão com DPI ajustável de até 4000, bateria de longa duração e botões laterais programáveis.',
    189.90,
    30,
    'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Eletrônicos' LIMIT 1),
    'Caixa de Som Bluetooth',
    'Caixa de som portátil resistente à água com som potente de 20W, graves profundos e conexão Bluetooth 5.0 estável.',
    149.90,
    40,
    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Roupas & Acessórios' LIMIT 1),
    'Jaqueta Corta Vento Premium',
    'Jaqueta leve, impermeável e resistente ao vento. Ideal para atividades ao ar livre ou para compor um look urbano moderno.',
    199.90,
    12,
    'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Roupas & Acessórios' LIMIT 1),
    'Tênis Running Confort',
    'Tênis esportivo com tecnologia de amortecimento em gel, cabedal em mesh respirável e solado antiderrapante. Ideal para corrida e caminhadas.',
    299.90,
    18,
    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Roupas & Acessórios' LIMIT 1),
    'Mochila Impermeável Tech',
    'Mochila com compartimento acolchoado para notebook de até 15.6 polegadas, entrada USB integrada e material resistente à água.',
    159.90,
    22,
    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Roupas & Acessórios' LIMIT 1),
    'Relógio Minimalista Quartz',
    'Relógio de pulso minimalista e sofisticado com pulseira em couro legítimo e mecanismo quartz de alta durabilidade.',
    249.90,
    10,
    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Roupas & Acessórios' LIMIT 1),
    'Óculos de Sol Polarizado',
    'Óculos de sol moderno com lentes polarizadas que fornecem 100% de proteção contra raios UVA/UVB, com armação resistente de acetato.',
    119.90,
    15,
    'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Casa & Decoração' LIMIT 1),
    'Luminária de Mesa Articulada',
    'Luminária articulada em metal com base pesada, ideal para escritório, estudos ou leitura, compatível com lâmpadas LED comuns.',
    89.90,
    8,
    'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Casa & Decoração' LIMIT 1),
    'Kit Quadros Decorativos Modernos',
    'Conjunto com 3 quadros de arte abstrata moderna com moldura em madeira preta e vidro de proteção para elevar a estética do seu ambiente.',
    120.00,
    5,
    'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Casa & Decoração' LIMIT 1),
    'Almofada Veludo Conforto',
    'Almofada decorativa revestida em tecido soft veludo com enchimento super macio. Adiciona conforto e charme ao seu sofá.',
    49.90,
    30,
    'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Casa & Decoração' LIMIT 1),
    'Vaso Minimalista de Cerâmica',
    'Vaso de cerâmica artesanal com design geométrico moderno e acabamento fosco. Perfeito para arranjos de flores secas.',
    75.00,
    12,
    'https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=500&auto=format&fit=crop'
),
(
    (SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1),
    (SELECT id FROM category WHERE name = 'Casa & Decoração' LIMIT 1),
    'Difusor de Aromas Ultrassônico',
    'Umidificador e difusor ultrassônico com luz LED RGB simulando chama de fogo, temporizador inteligente e desligamento automático.',
    139.90,
    14,
    'https://images.unsplash.com/photo-1602928321679-560bb453f190?w=500&auto=format&fit=crop'
);