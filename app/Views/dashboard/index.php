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
            <a href="/dashboard" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: var(--accent-purple); background: var(--accent-purple-light); font-weight: 600; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                Início
            </a>

            <?php if ($_SESSION['role_name'] === 'Administrador' || $_SESSION['role_id'] == 1): ?>
                <a href="/admin/categories" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: var(--text-color); font-weight: 500; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="this.style.color='var(--text-color)'; this.style.background='none'">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    Categorias
                </a>
                <a href="/admin/admins" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: var(--text-color); font-weight: 500; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="this.style.color='var(--text-color)'; this.style.background='none'">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Administradores
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role_name'] === 'Vendedor' || $_SESSION['role_id'] == 3): ?>
                <a href="/seller/products" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: var(--text-color); font-weight: 500; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="this.style.color='var(--text-color)'; this.style.background='none'">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    Meus Produtos
                </a>
            <?php endif; ?>

            <?php if ($_SESSION['role_name'] === 'Vendedor' || $_SESSION['role_name'] === 'Usuário' || $_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3): ?>
                <a href="/dashboard/addresses" style="display: flex; align-items: center; gap: 12px; padding: 12px 16px; border-radius: 12px; text-decoration: none; color: var(--text-color); font-weight: 500; font-size: 0.95rem; font-family: var(--font-outfit); transition: all 0.2s ease;" onmouseover="this.style.color='var(--accent-purple)'; this.style.background='var(--accent-purple-light)'" onmouseout="this.style.color='var(--text-color)'; this.style.background='none'">
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
        <?php if (isset($_SESSION['dashboard_error'])): ?>
            <div style="background: #fef2f2; border: 1px solid #fee2e2; color: #ef4444; padding: 16px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 500;">
                <?php echo htmlspecialchars($_SESSION['dashboard_error']); unset($_SESSION['dashboard_error']); ?>
            </div>
        <?php endif; ?>

        <div style="background: #ffffff; border-radius: 20px; padding: 40px; border: 1px solid var(--border-color); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02); height: 100%;">
            <h1 style="font-family: var(--font-outfit); font-weight: 800; font-size: 2.2rem; color: var(--text-color); margin-bottom: 12px;">Olá, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 35px; line-height: 1.6;">Bem-vindo ao seu painel. Selecione uma opção no menu lateral para gerenciar suas informações e atividades.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 24px;">
                <?php if ($_SESSION['role_name'] === 'Administrador' || $_SESSION['role_id'] == 1): ?>
                    <a href="/admin/categories" style="background: var(--bg-base); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-purple)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='none'">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                        <h4 style="font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; margin-bottom: 6px;">Categorias</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Gerencie as categorias de produtos disponíveis no e-commerce.</p>
                    </a>
                    <a href="/admin/admins" style="background: var(--bg-base); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-purple)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='none'">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <h4 style="font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; margin-bottom: 6px;">Administradores</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Cadastre, edite ou exclua outros administradores do sistema.</p>
                    </a>
                <?php endif; ?>

                <?php if ($_SESSION['role_name'] === 'Vendedor' || $_SESSION['role_id'] == 3): ?>
                    <a href="/seller/products" style="background: var(--bg-base); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-purple)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='none'">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        </div>
                        <h4 style="font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; margin-bottom: 6px;">Meus Produtos</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Cadastre e gerencie os anúncios de produtos que você está vendendo.</p>
                    </a>
                    <a href="/seller/orders" style="background: var(--bg-base); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-purple)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='none'">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                        <h4 style="font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; margin-bottom: 6px;">Pedidos Recebidos</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Gerencie e altere o status dos pedidos recebidos para os seus produtos.</p>
                    </a>
                <?php endif; ?>

                <?php if ($_SESSION['role_name'] === 'Usuário' || $_SESSION['role_id'] == 2): ?>
                    <a href="/dashboard/orders" style="background: var(--bg-base); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-purple)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='none'">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                        <h4 style="font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; margin-bottom: 6px;">Meus Pedidos</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Acompanhe o status e histórico de todas as suas compras.</p>
                    </a>
                <?php endif; ?>

                <?php if ($_SESSION['role_name'] === 'Vendedor' || $_SESSION['role_name'] === 'Usuário' || $_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3): ?>
                    <a href="/dashboard/addresses" style="background: var(--bg-base); border: 1px solid var(--border-color); padding: 24px; border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.25s ease;" onmouseover="this.style.borderColor='var(--accent-purple)'; this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='var(--border-color)'; this.style.transform='none'">
                        <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-purple-light); color: var(--accent-purple); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <h4 style="font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; margin-bottom: 6px;">Meus Endereços</h4>
                        <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.4;">Cadastre e gerencie seus endereços para compras ou envios.</p>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
