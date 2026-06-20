<?php require_once __DIR__ . '/../../layout_header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h1 style="font-family: var(--font-outfit); font-weight: 800; font-size: 2rem; color: var(--text-color); margin-bottom: 4px;">Administradores</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">Gerencie os administradores da plataforma ShopFree.</p>
    </div>
    <a href="/admin/admins/create" style="display: inline-flex; align-items: center; gap: 8px; background-color: var(--accent-purple); color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 30px; font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; transition: background-color 0.25s ease; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='var(--accent-purple-hover)'" onmouseout="this.style.backgroundColor='var(--accent-purple)'">
        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Novo Administrador
    </a>
</div>

<?php if (isset($success)): ?>
    <div style="background: #ecfdf5; border: 1px solid #d1fae5; color: #059669; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 500;">
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div style="background: #fef2f2; border: 1px solid #fee2e2; color: #ef4444; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 500;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<div style="overflow-x: auto; background: #ffffff; border-radius: 16px; border: 1px solid var(--border-color);">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="border-bottom: 1px solid var(--border-color); background: var(--bg-base);">
                <th style="padding: 18px 24px; font-family: var(--font-outfit); font-weight: 700; color: var(--text-color); width: 80px;">ID</th>
                <th style="padding: 18px 24px; font-family: var(--font-outfit); font-weight: 700; color: var(--text-color);">Nome</th>
                <th style="padding: 18px 24px; font-family: var(--font-outfit); font-weight: 700; color: var(--text-color);">E-mail</th>
                <th style="padding: 18px 24px; font-family: var(--font-outfit); font-weight: 700; color: var(--text-color); width: 150px; text-align: right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $adm): ?>
                <tr style="border-bottom: 1px solid var(--border-color); transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='rgba(0, 0, 0, 0.01)'" onmouseout="this.style.backgroundColor='transparent'">
                    <td style="padding: 18px 24px; color: var(--text-muted); font-weight: 600;"><?php echo $adm['id']; ?></td>
                    <td style="padding: 18px 24px; font-weight: 600; color: var(--text-color);">
                        <?php echo htmlspecialchars($adm['name']); ?>
                        <?php if ($adm['id'] == $_SESSION['user_id']): ?>
                            <span style="font-size: 0.75rem; background: var(--accent-purple-light); color: var(--accent-purple); padding: 2px 8px; border-radius: 12px; margin-left: 8px; font-weight: 600;">Você</span>
                        <?php endif; ?>
                    </td>
                    <td style="padding: 18px 24px; color: var(--text-muted);"><?php echo htmlspecialchars($adm['email']); ?></td>
                    <td style="padding: 18px 24px; text-align: right; display: flex; justify-content: flex-end; gap: 12px;">
                        <a href="/admin/admins/edit?id=<?php echo $adm['id']; ?>" style="color: var(--accent-purple); text-decoration: none; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='var(--accent-purple-hover)'" onmouseout="this.style.color='var(--accent-purple)'" title="Editar">
                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <?php if ($adm['id'] != $_SESSION['user_id']): ?>
                            <a href="/admin/admins/delete?id=<?php echo $adm['id']; ?>" onclick="return confirm('Tem certeza que deseja remover este administrador?');" style="color: #ef4444; text-decoration: none; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#ef4444'" title="Excluir">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../../layout_footer.php'; ?>
