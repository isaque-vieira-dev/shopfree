<?php require_once __DIR__ . '/../../layout_header.php'; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <h1 style="font-family: var(--font-outfit); font-weight: 800; font-size: 2rem; color: var(--text-color); margin-bottom: 4px;">Meus Endereços</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">Gerencie seus endereços para entrega ou faturamento.</p>
    </div>
    <a href="/dashboard/addresses/create" style="display: inline-flex; align-items: center; gap: 8px; background-color: var(--accent-purple); color: #ffffff; text-decoration: none; padding: 12px 24px; border-radius: 30px; font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; transition: background-color 0.25s ease; border: none; cursor: pointer;" onmouseover="this.style.backgroundColor='var(--accent-purple-hover)'" onmouseout="this.style.backgroundColor='var(--accent-purple)'">
        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Novo Endereço
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

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
    <?php if (empty($addresses)): ?>
        <div style="grid-column: 1 / -1; background: #ffffff; border-radius: 16px; border: 1px solid var(--border-color); padding: 40px; text-align: center; color: var(--text-muted);">
            Nenhum endereço cadastrado ainda.
        </div>
    <?php else: ?>
        <?php foreach ($addresses as $addr): ?>
            <div style="background: #ffffff; border-radius: 16px; border: 1px solid <?php echo $addr['is_default'] ? 'var(--accent-purple)' : 'var(--border-color)'; ?>; padding: 24px; position: relative; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.01); display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <span style="font-family: var(--font-outfit); font-weight: 700; color: var(--text-color); font-size: 1.05rem;">
                            <?php echo htmlspecialchars($addr['street']) . ', ' . htmlspecialchars($addr['number']); ?>
                        </span>
                        <?php if ($addr['is_default']): ?>
                            <span style="font-size: 0.7rem; background: var(--accent-purple-light); color: var(--accent-purple); padding: 2px 8px; border-radius: 12px; font-weight: 600; text-transform: uppercase;">Padrão</span>
                        <?php endif; ?>
                    </div>
                    
                    <p style="color: var(--text-muted); font-size: 0.85rem; line-height: 1.6; margin-bottom: 20px;">
                        <?php if (!empty($addr['complement'])): ?>
                            <strong>Comp:</strong> <?php echo htmlspecialchars($addr['complement']); ?><br>
                        <?php endif; ?>
                        <strong>Bairro:</strong> <?php echo htmlspecialchars($addr['neighborhood']); ?><br>
                        <strong>Cidade:</strong> <?php echo htmlspecialchars($addr['city']) . ' - ' . htmlspecialchars($addr['state']); ?><br>
                        <strong>CEP:</strong> <?php echo htmlspecialchars($addr['postal_code']); ?><br>
                        <strong>País:</strong> <?php echo htmlspecialchars($addr['country']); ?>
                    </p>
                </div>

                <div style="display: flex; gap: 16px; border-top: 1px solid var(--border-color); padding-top: 16px; justify-content: flex-end;">
                    <a href="/dashboard/addresses/edit?id=<?php echo $addr['id']; ?>" style="color: var(--accent-purple); text-decoration: none; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 4px;" onmouseover="this.style.color='var(--accent-purple-hover)'" onmouseout="this.style.color='var(--accent-purple)'">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        Editar
                    </a>
                    <a href="/dashboard/addresses/delete?id=<?php echo $addr['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este endereço?');" style="color: #ef4444; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: flex; align-items: center; gap: 4px;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#ef4444'">
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        Excluir
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../../layout_footer.php'; ?>
