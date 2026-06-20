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