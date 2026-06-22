<?php

// Habilitar exibição de erros
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Carregar configurações
require_once __DIR__ . '/../config.php';

echo "Iniciando o seeding do banco de dados...\n";

// Tentar conectar ao banco de dados (tenta 'db' do docker e depois 'localhost' como fallback)
$host = DB_HOST;
$dbName = DB_NAME;
$user = DB_USER;
$pass = DB_PASS;

try {
    $dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
    ]);
    echo "Conectado ao banco usando host: $host\n";
} catch (PDOException $e) {
    try {
        $fallbackHost = "127.0.0.1";
        $dsn = "mysql:host=$fallbackHost;dbname=$dbName;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);
        echo "Conectado ao banco usando host: $fallbackHost\n";
    } catch (PDOException $e2) {
        die("Erro ao conectar ao banco de dados: " . $e2->getMessage() . "\n");
    }
}

// 1. Obter o id do vendedor
$stmt = $pdo->query("SELECT id FROM user WHERE email = 'vendedor@shopfree.com' LIMIT 1");
$sellerId = $stmt->fetchColumn();
if (!$sellerId) {
    $sellerId = 2; // Fallback padrão
}
echo "ID do Vendedor: $sellerId\n";

// 2. Definir as categorias
$categories = [
    'Eletrônicos' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=150&auto=format&fit=crop',
    'Roupas & Acessórios' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?w=150&auto=format&fit=crop',
    'Casa & Decoração' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=150&auto=format&fit=crop'
];

$categoryIds = [];

foreach ($categories as $catName => $catImg) {
    // Inserir categoria se não existir
    $stmt = $pdo->prepare("SELECT id FROM category WHERE name = :name LIMIT 1");
    $stmt->execute(['name' => $catName]);
    $catId = $stmt->fetchColumn();

    if (!$catId) {
        $stmtInsert = $pdo->prepare("INSERT INTO category (name, image_path) VALUES (:name, :image_path)");
        $stmtInsert->execute(['name' => $catName, 'image_path' => $catImg]);
        $catId = $pdo->lastInsertId();
        echo "Categoria '$catName' inserida com sucesso (ID $catId).\n";
    } else {
        // Se já existe, atualiza a imagem apenas para garantir
        $stmtUpdate = $pdo->prepare("UPDATE category SET image_path = :image_path WHERE id = :id");
        $stmtUpdate->execute(['image_path' => $catImg, 'id' => $catId]);
        echo "Categoria '$catName' já existe (ID $catId). Imagem atualizada.\n";
    }
    $categoryIds[$catName] = $catId;
}

// 3. Definir os produtos
$products = [
    // Eletrônicos
    [
        'category' => 'Eletrônicos',
        'name' => 'Monitor Gamer 24" UltraWide',
        'description' => 'Monitor gamer de alta performance com painel IPS, 144Hz de taxa de atualização e 1ms de tempo de resposta. Perfeito para jogos competitivos e trabalho multitarefa.',
        'price' => 1299.90,
        'stock' => 15,
        'image_path' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Eletrônicos',
        'name' => 'Teclado Mecânico RGB',
        'description' => 'Teclado mecânico mec-switch blue com retroiluminação RGB customizável, design ergonômico e teclas anti-ghosting.',
        'price' => 349.90,
        'stock' => 20,
        'image_path' => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Eletrônicos',
        'name' => 'Headset Gamer 7.1 Surround',
        'description' => 'Experimente um som imersivo de cinema com o sistema 7.1 canais virtuais, microfone com cancelamento de ruído e almofadas ultra macias.',
        'price' => 259.90,
        'stock' => 25,
        'image_path' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Eletrônicos',
        'name' => 'Mouse Wireless Ergonomic',
        'description' => 'Mouse sem fio ergonômico de alta precisão com DPI ajustável de até 4000, bateria de longa duração e botões laterais programáveis.',
        'price' => 189.90,
        'stock' => 30,
        'image_path' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Eletrônicos',
        'name' => 'Caixa de Som Bluetooth',
        'description' => 'Caixa de som portátil resistente à água com som potente de 20W, graves profundos e conexão Bluetooth 5.0 estável.',
        'price' => 149.90,
        'stock' => 40,
        'image_path' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=500&auto=format&fit=crop'
    ],

    // Roupas & Acessórios
    [
        'category' => 'Roupas & Acessórios',
        'name' => 'Jaqueta Corta Vento Premium',
        'description' => 'Jaqueta leve, impermeável e resistente ao vento. Ideal para atividades ao ar livre ou para compor um look urbano moderno.',
        'price' => 199.90,
        'stock' => 12,
        'image_path' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Roupas & Acessórios',
        'name' => 'Tênis Running Confort',
        'description' => 'Tênis esportivo com tecnologia de amortecimento em gel, cabedal em mesh respirável e solado antiderrapante. Ideal para corrida e caminhadas.',
        'price' => 299.90,
        'stock' => 18,
        'image_path' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Roupas & Acessórios',
        'name' => 'Mochila Impermeável Tech',
        'description' => 'Mochila com compartimento acolchoado para notebook de até 15.6 polegadas, entrada USB integrada e material resistente à água.',
        'price' => 159.90,
        'stock' => 22,
        'image_path' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Roupas & Acessórios',
        'name' => 'Relógio Minimalista Quartz',
        'description' => 'Relógio de pulso minimalista e sofisticado com pulseira em couro legítimo e mecanismo quartz de alta durabilidade.',
        'price' => 249.90,
        'stock' => 10,
        'image_path' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Roupas & Acessórios',
        'name' => 'Óculos de Sol Polarizado',
        'description' => 'Óculos de sol moderno com lentes polarizadas que fornecem 100% de proteção contra raios UVA/UVB, com armação resistente de acetato.',
        'price' => 119.90,
        'stock' => 15,
        'image_path' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?w=500&auto=format&fit=crop'
    ],

    // Casa & Decoração
    [
        'category' => 'Casa & Decoração',
        'name' => 'Luminária de Mesa Articulada',
        'description' => 'Luminária articulada em metal com base pesada, ideal para escritório, estudos ou leitura, compatível com lâmpadas LED comuns.',
        'price' => 89.90,
        'stock' => 8,
        'image_path' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Casa & Decoração',
        'name' => 'Kit Quadros Decorativos Modernos',
        'description' => 'Conjunto com 3 quadros de arte abstrata moderna com moldura em madeira preta e vidro de proteção para elevar a estética do seu ambiente.',
        'price' => 120.00,
        'stock' => 5,
        'image_path' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Casa & Decoração',
        'name' => 'Almofada Veludo Conforto',
        'description' => 'Almofada decorativa revestida em tecido soft veludo com enchimento super macio. Adiciona conforto e charme ao seu sofá.',
        'price' => 49.90,
        'stock' => 30,
        'image_path' => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Casa & Decoração',
        'name' => 'Vaso Minimalista de Cerâmica',
        'description' => 'Vaso de cerâmica artesanal com design geométrico moderno e acabamento fosco. Perfeito para arranjos de flores secas.',
        'price' => 75.00,
        'stock' => 12,
        'image_path' => 'https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=500&auto=format&fit=crop'
    ],
    [
        'category' => 'Casa & Decoração',
        'name' => 'Difusor de Aromas Ultrassônico',
        'description' => 'Umidificador e difusor ultrassônico com luz LED RGB simulando chama de fogo, temporizador inteligente e desligamento automático.',
        'price' => 139.90,
        'stock' => 14,
        'image_path' => 'https://images.unsplash.com/photo-1602928321679-560bb453f190?w=500&auto=format&fit=crop'
    ]
];

$stmtInsertProd = $pdo->prepare("
    INSERT INTO product (user_id, category_id, name, description, price, stock, image_path)
    VALUES (:user_id, :category_id, :name, :description, :price, :stock, :image_path)
");

foreach ($products as $p) {
    $catId = $categoryIds[$p['category']];
    
    // Verificar se o produto já existe pelo nome para evitar duplicados
    $stmtCheck = $pdo->prepare("SELECT id FROM product WHERE name = :name LIMIT 1");
    $stmtCheck->execute(['name' => $p['name']]);
    $prodExists = $stmtCheck->fetchColumn();
    
    if (!$prodExists) {
        $stmtInsertProd->execute([
            'user_id' => $sellerId,
            'category_id' => $catId,
            'name' => $p['name'],
            'description' => $p['description'],
            'price' => $p['price'],
            'stock' => $p['stock'],
            'image_path' => $p['image_path']
        ]);
        echo "Produto '{$p['name']}' cadastrado com sucesso.\n";
    } else {
        echo "Produto '{$p['name']}' já existe, ignorado.\n";
    }
}

echo "Seeding concluído com sucesso!\n";
