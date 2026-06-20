<?php require_once __DIR__ . '/../../layout_header.php'; ?>

<div style="margin-bottom: 30px;">
    <a href="/admin/categories" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; margin-bottom: 16px; transition: color 0.2s;" onmouseover="this.style.color='var(--accent-purple)'" onmouseout="this.style.color='var(--text-muted)'">
        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        Voltar para a listagem
    </a>
    <h1 style="font-family: var(--font-outfit); font-weight: 800; font-size: 2rem; color: var(--text-color);"><?php echo $pageTitle; ?></h1>
</div>

<?php if (isset($error)): ?>
    <div style="background: #fef2f2; border: 1px solid #fee2e2; color: #ef4444; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-size: 0.9rem; font-weight: 500;">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form action="<?php echo $action; ?>" method="POST" style="max-width: 500px; display: flex; flex-direction: column; gap: 20px;">
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <label for="name" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Nome da Categoria *</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>" placeholder="Ex: Eletrônicos, Roupas, Calçados" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
    </div>

    <button type="submit" style="align-self: flex-start; padding: 14px 32px; background-color: var(--accent-purple); color: #ffffff; border: none; border-radius: 30px; font-family: var(--font-outfit); font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background-color 0.25s ease;" onmouseover="this.style.backgroundColor='var(--accent-purple-hover)'" onmouseout="this.style.backgroundColor='var(--accent-purple)'">
        Salvar Categoria
    </button>
</form>

<?php require_once __DIR__ . '/../../layout_footer.php'; ?>
