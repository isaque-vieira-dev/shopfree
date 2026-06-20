<?php require_once __DIR__ . '/../../layout_header.php'; ?>

<div style="margin-bottom: 30px;">
    <a href="/seller/products" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; margin-bottom: 16px; transition: color 0.2s;" onmouseover="this.style.color='var(--accent-purple)'" onmouseout="this.style.color='var(--text-muted)'">
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

<form action="<?php echo $action; ?>" method="POST" style="max-width: 600px; display: flex; flex-direction: column; gap: 20px;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="name" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Nome do Produto *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" placeholder="Ex: Monitor Gamer 24" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="category_id" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Categoria *</label>
            <select id="category_id" name="category_id" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); background: #ffffff; font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo (isset($product) && $product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="price" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Preço (R$) *</label>
            <input type="number" id="price" name="price" step="0.01" min="0.01" value="<?php echo htmlspecialchars($product['price'] ?? ''); ?>" placeholder="99.90" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="stock" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Quantidade em Estoque *</label>
            <input type="number" id="stock" name="stock" min="0" value="<?php echo htmlspecialchars($product['stock'] ?? '0'); ?>" placeholder="10" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 8px;">
        <label for="image_path" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">URL da Imagem</label>
        <input type="text" id="image_path" name="image_path" value="<?php echo htmlspecialchars($product['image_path'] ?? ''); ?>" placeholder="https://exemplo.com/imagem.jpg" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
    </div>

    <div style="display: flex; flex-direction: column; gap: 8px;">
        <label for="description" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Descrição do Produto</label>
        <textarea id="description" name="description" rows="5" placeholder="Detalhes técnicos, estado do produto, cores..." style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
    </div>

    <button type="submit" style="align-self: flex-start; padding: 14px 32px; background-color: var(--accent-purple); color: #ffffff; border: none; border-radius: 30px; font-family: var(--font-outfit); font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background-color 0.25s ease;" onmouseover="this.style.backgroundColor='var(--accent-purple-hover)'" onmouseout="this.style.backgroundColor='var(--accent-purple)'">
        Salvar Produto
    </button>
</form>

<?php require_once __DIR__ . '/../../layout_footer.php'; ?>
