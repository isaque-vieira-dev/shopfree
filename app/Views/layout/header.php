<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . " - " . APP_NAME : APP_NAME; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #f9f8f4;
            --text-color: #1a1a1a;
            --text-muted: #666666;
            --accent-purple: #7c3aed;
            --accent-purple-hover: #6d28d9;
            --accent-purple-light: #f5f3ff;
            --border-color: rgba(0, 0, 0, 0.06);
            --font-outfit: 'Outfit', sans-serif;
            --font-inter: 'Inter', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: var(--bg-base);
            color: var(--text-color);
            font-family: var(--font-inter);
            line-height: 1.6;
        }

        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 24px 8%;
            background-color: var(--bg-base);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-family: var(--font-outfit);
            font-size: 1.6rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-color);
            text-decoration: none;
        }

        .logo span {
            color: var(--accent-purple);
        }

        .nav-links {
            display: flex;
            list-style: none;
            gap: 32px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-family: var(--font-outfit);
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.25s ease;
            position: relative;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--accent-purple);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
            position: relative;
            background: #ffffff;
            border-radius: 30px;
            padding: 2px 2px 2px 16px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: border-color 0.25s ease;
        }

        .search-container:focus-within {
            border-color: var(--accent-purple);
        }

        .search-input {
            border: none;
            outline: none;
            font-size: 0.85rem;
            font-family: var(--font-inter);
            color: var(--text-color);
            width: 160px;
            transition: width 0.3s ease;
        }

        .search-input:focus {
            width: 200px;
        }

        .search-button {
            background-color: var(--accent-purple);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ffffff;
            transition: background-color 0.25s ease;
        }

        .search-button:hover {
            background-color: var(--accent-purple-hover);
        }

        .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            transition: color 0.25s ease;
        }

        .icon-btn:hover {
            color: var(--accent-purple);
        }

        .icon-btn svg {
            width: 22px;
            height: 22px;
        }

        .icon-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent-purple);
            color: #ffffff;
            font-size: 0.7rem;
            font-weight: 600;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid var(--bg-base);
        }

        .menu-toggle {
            display: none;
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }
            .menu-toggle {
                display: flex;
            }
        }

        .header-cart-wrapper {
            position: relative;
        }
        .header-cart-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 320px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-top: 15px;
            padding: 20px;
            display: none;
            flex-direction: column;
            z-index: 1010;
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.25s ease, transform 0.25s ease;
        }
        .header-cart-wrapper:hover .header-cart-dropdown,
        .header-cart-wrapper:focus-within .header-cart-dropdown {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }
        
        .dropdown-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 12px;
            margin-bottom: 12px;
        }
        
        .dropdown-header h3 {
            font-family: var(--font-outfit);
            font-size: 1.05rem;
            font-weight: 700;
        }
        
        .dropdown-count {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .dropdown-body {
            max-height: 240px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 16px;
        }
        
        .dropdown-empty-state {
            padding: 20px 0;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .dropdown-item {
            display: flex;
            gap: 12px;
            align-items: center;
            text-align: left;
        }
        
        .dropdown-item-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background-color: #f5f5f5;
            overflow: hidden;
            border: 1px solid var(--border-color);
            flex-shrink: 0;
        }
        
        .dropdown-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .dropdown-item-no-img {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            color: var(--text-muted);
        }
        
        .dropdown-item-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }
        
        .dropdown-item-title {
            font-family: var(--font-outfit);
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-color);
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        
        .dropdown-item-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
        }
        
        .dropdown-footer {
            border-top: 1px solid var(--border-color);
            padding-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        
        .dropdown-total-row {
            display: flex;
            justify-content: space-between;
            font-family: var(--font-outfit);
            font-weight: 700;
            font-size: 1rem;
        }
        
        .btn-dropdown-go-cart {
            background-color: var(--accent-purple);
            color: #ffffff;
            text-decoration: none;
            text-align: center;
            padding: 10px;
            border-radius: 30px;
            font-family: var(--font-outfit);
            font-weight: 600;
            font-size: 0.85rem;
            transition: background-color 0.2s ease;
        }
        
        .btn-dropdown-go-cart:hover {
            background-color: var(--accent-purple-hover);
        }
    </style>
    <script>
    window.updateHeaderCart = function(count, total, items) {
        const badge = document.getElementById('header-cart-badge');
        const dropdownCount = document.getElementById('dropdown-count-val');
        const dropdownTotal = document.getElementById('dropdown-total-val');
        const itemsList = document.getElementById('header-cart-items-list');
        
        if (badge) {
            badge.innerText = count;
            badge.style.display = count === 0 ? 'none' : '';
        }
        
        if (dropdownCount) {
            dropdownCount.innerText = count;
        }
        
        if (dropdownTotal) {
            dropdownTotal.innerText = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total);
        }
        
        if (itemsList) {
            if (items.length === 0) {
                itemsList.innerHTML = '<div class="dropdown-empty-state"><p>Seu carrinho está vazio.</p></div>';
            } else {
                let html = '';
                items.forEach(item => {
                    const imgHtml = item.image_path 
                        ? `<img src="${item.image_path}" alt="${item.name}">` 
                        : '<div class="dropdown-item-no-img">N/A</div>';
                    
                    const formattedPrice = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(item.price);
                    
                    html += `
                        <div class="dropdown-item" id="dropdown-item-${item.id}">
                            <div class="dropdown-item-img">
                                ${imgHtml}
                            </div>
                            <div class="dropdown-item-info">
                                <a href="/product?id=${item.id}" class="dropdown-item-title">${item.name}</a>
                                <span class="dropdown-item-meta">${item.quantity}x ${formattedPrice}</span>
                            </div>
                        </div>
                    `;
                });
                itemsList.innerHTML = html;
            }
        }
    };
    </script>
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="/" class="logo">ShopFree<span>.</span></a>
            
            <?php
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $isContact = (strpos($uri, 'contact') !== false || strpos($uri, 'contato') !== false);
            $isAbout = (strpos($uri, 'about') !== false || strpos($uri, 'sobre') !== false);
            $isCategories = (strpos($uri, 'categories') !== false || strpos($uri, 'categorias') !== false);
            $isProducts = (strpos($uri, 'products') !== false || strpos($uri, 'produtos') !== false);
            $isHome = (!$isContact && !$isAbout && !$isCategories && !$isProducts);
            ?>
            <ul class="nav-links">
                <li><a href="/" class="<?php echo $isHome ? 'active' : ''; ?>">Home</a></li>
                <li><a href="/about" class="<?php echo $isAbout ? 'active' : ''; ?>">Sobre nos</a></li>
                <li><a href="/products" class="<?php echo $isProducts ? 'active' : ''; ?>">Produtos</a></li>
                <li><a href="/categories" class="<?php echo $isCategories ? 'active' : ''; ?>">Categorias</a></li>
                <li><a href="/contact" class="<?php echo $isContact ? 'active' : ''; ?>">Contato</a></li>
                <li><a href="/seller" class="<?php echo ($uri === '/seller') ? 'active' : ''; ?>">Anuncie seus produtos</a></li>
            </ul>

            <div class="nav-actions">
                <form action="/products" method="GET" class="search-container" style="margin: 0;">
                    <input type="text" name="search" class="search-input" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" placeholder="Ex:vaso">
                    <button type="submit" class="search-button">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </form>

                <?php 
                $isClientUser = isset($_SESSION['user_id']) && (($_SESSION['role_id'] ?? null) == 2 || ($_SESSION['role_name'] ?? null) === 'Usuário');
                if ($isClientUser): 
                    $headerCart = $_SESSION['cart'] ?? [];
                    $headerCartCount = count($headerCart);
                    $headerCartTotal = 0;
                    foreach ($headerCart as $item) {
                        $headerCartTotal += $item['price'] * $item['quantity'];
                    }
                ?>
                    <div class="header-cart-wrapper">
                        <button class="icon-btn" id="header-cart-trigger" aria-label="Cart">
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            <span class="icon-badge" id="header-cart-badge" style="<?php echo $headerCartCount === 0 ? 'display: none;' : ''; ?>"><?php echo $headerCartCount; ?></span>
                        </button>
                        
                        <div class="header-cart-dropdown" id="header-cart-dropdown">
                            <div class="dropdown-header">
                                <h3>Seu Carrinho</h3>
                                <span class="dropdown-count"><span id="dropdown-count-val"><?php echo $headerCartCount; ?></span> item(ns)</span>
                            </div>
                            <div class="dropdown-body" id="header-cart-items-list">
                                <?php if (empty($headerCart)): ?>
                                    <div class="dropdown-empty-state">
                                        <p>Seu carrinho está vazio.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($headerCart as $item): ?>
                                        <div class="dropdown-item" id="dropdown-item-<?php echo $item['id']; ?>">
                                            <div class="dropdown-item-img">
                                                <?php if (!empty($item['image_path'])): ?>
                                                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                                <?php else: ?>
                                                    <div class="dropdown-item-no-img">N/A</div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="dropdown-item-info">
                                                <a href="/product?id=<?php echo $item['id']; ?>" class="dropdown-item-title"><?php echo htmlspecialchars($item['name']); ?></a>
                                                <span class="dropdown-item-meta"><?php echo $item['quantity']; ?>x R$ <?php echo number_format($item['price'], 2, ',', '.'); ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="dropdown-footer">
                                <div class="dropdown-total-row">
                                    <span>Total:</span>
                                    <span id="dropdown-total-val">R$ <?php echo number_format($headerCartTotal, 2, ',', '.'); ?></span>
                                </div>
                                <a href="/cart" class="btn-dropdown-go-cart">Ir para o Carrinho</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-menu" style="display: flex; align-items: center; gap: 12px; font-family: var(--font-outfit); font-size: 0.9rem; font-weight: 500;">
                        <a href="/dashboard" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: flex-start; line-height: 1.2; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            <span class="user-name" style="color: var(--text-muted); font-weight: 600; margin-bottom: 2px;">Olá, <?php echo htmlspecialchars(explode(' ', $_SESSION['user_name'])[0]); ?></span>
                            <span class="user-role" style="font-size: 0.75rem; color: var(--accent-purple); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;"><?php echo htmlspecialchars($_SESSION['role_name'] ?? 'Usuário'); ?></span>
                        </a>
                        <a href="/logout" class="icon-btn" aria-label="Logout" title="Sair" style="color: #ef4444;">
                            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="/login" class="icon-btn" aria-label="Login" title="Entrar">
                        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </a>
                <?php endif; ?>

                <button class="icon-btn menu-toggle" aria-label="Menu">
                    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </button>
            </div>
        </nav>
    </header>
