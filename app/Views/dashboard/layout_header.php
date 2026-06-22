<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="dashboard-container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px; font-family: var(--font-inter); display: grid; grid-template-columns: 280px 1fr; gap: 40px; min-height: 70vh;">
    <aside style="background: #ffffff; border-radius: 20px; padding: 30px 24px; border: 1px solid var(--border-color); align-self: start; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);">
        <div style="margin-bottom: 30px; text-align: center;">
            <div style="width: 70px; height: 70px; border-radius: 50%; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.8rem; font-weight: 800; font-family: var(--font-outfit);">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </div>
            <h3 style="font-family: var(--font-outfit); font-weight: 700; color: var(--text-color); font-size: 1.15rem; margin-bottom: 4px;"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h3>
            <span style="font-size: 0.8rem; color: var(--accent-purple); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;"><?php echo htmlspecialchars($_SESSION['role_name']); ?></span>
        </div>

        <nav style="display: flex; flex-direction: column; gap: 8px;">
            <?php 
                $currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            ?>
            <a href="/dashboard" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo $currentUri === '/dashboard' ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo $currentUri === '/dashboard' ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo $currentUri === '/dashboard' ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo $currentUri; ?>' !== '/dashboard') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                Início
            </a>

            <?php if ($_SESSION['role_name'] === 'Administrador' || $_SESSION['role_id'] == 1): ?>
                <a href="/admin/categories" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo strpos($currentUri, '/admin/categories') === 0 ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo strpos($currentUri, '/admin/categories') === 0 ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo strpos($currentUri, '/admin/categories') === 0 ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo strpos($currentUri, '/admin/categories') === 0; ?>' !== '1') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    Categorias
                </a>
                <a href="/admin/admins" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo strpos($currentUri, '/admin/admins') === 0 ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo strpos($currentUri, '/admin/admins') === 0 ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo strpos($currentUri, '/admin/admins') === 0 ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo strpos($currentUri, '/admin/admins') === 0; ?>' !== '1') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Administradores
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role_name'] === 'Vendedor' || $_SESSION['role_id'] == 3): ?>
                <a href="/seller/products" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo strpos($currentUri, '/seller/products') === 0 ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo strpos($currentUri, '/seller/products') === 0 ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo strpos($currentUri, '/seller/products') === 0 ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo strpos($currentUri, '/seller/products') === 0; ?>' !== '1') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    Meus Produtos
                </a>
                <a href="/seller/orders" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo strpos($currentUri, '/seller/orders') === 0 ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo strpos($currentUri, '/seller/orders') === 0 ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo strpos($currentUri, '/seller/orders') === 0 ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo strpos($currentUri, '/seller/orders') === 0; ?>' !== '1') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    Pedidos Recebidos
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role_name'] === 'Usuário' || $_SESSION['role_id'] == 2): ?>
                <a href="/dashboard/orders" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo strpos($currentUri, '/dashboard/orders') === 0 ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo strpos($currentUri, '/dashboard/orders') === 0 ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo strpos($currentUri, '/dashboard/orders') === 0 ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo strpos($currentUri, '/dashboard/orders') === 0; ?>' !== '1') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    Meus Pedidos
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role_name'] === 'Vendedor' || $_SESSION['role_name'] === 'Usuário' || $_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3): ?>
                <a href="/dashboard/addresses" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: <?php echo strpos($currentUri, '/dashboard/addresses') === 0 ? 'var(--accent-purple)' : 'var(--text-color)'; ?>; background: <?php echo strpos($currentUri, '/dashboard/addresses') === 0 ? 'var(--accent-purple-light)' : 'none'; ?>; font-weight: <?php echo strpos($currentUri, '/dashboard/addresses') === 0 ? '600' : '500'; ?>; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="if('<?php echo strpos($currentUri, '/dashboard/addresses') === 0; ?>' !== '1') { this.style.color='var(--text-color)'; this.style.background='none'; }">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    Meus Endereços
                </a>
            <?php endif; ?>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">

            <a href="/logout" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: #ef4444; font-weight: 500; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='none'">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Sair
            </a>
        </nav>
    </aside>

    <main style="flex: 1;">
        <div style="background: #ffffff; border-radius: 20px; padding: 40px; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02); min-height: 100%;">
