<?php require_once __DIR__ . '/../../layout_header.php'; ?>

<div style="margin-bottom: 30px;">
    <a href="/dashboard/addresses" style="display: inline-flex; align-items: center; gap: 8px; color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; margin-bottom: 16px; transition: color 0.2s;" onmouseover="this.style.color='var(--accent-purple)'" onmouseout="this.style.color='var(--text-muted)'">
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
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="street" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Rua/Logradouro *</label>
            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($address['street'] ?? ''); ?>" placeholder="Ex: Av. Paulista" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="number" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Número *</label>
            <input type="text" id="number" name="number" value="<?php echo htmlspecialchars($address['number'] ?? ''); ?>" placeholder="Ex: 1000" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="complement" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Complemento</label>
            <input type="text" id="complement" name="complement" value="<?php echo htmlspecialchars($address['complement'] ?? ''); ?>" placeholder="Ex: Apto 42, Bloco B" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="neighborhood" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Bairro *</label>
            <input type="text" id="neighborhood" name="neighborhood" value="<?php echo htmlspecialchars($address['neighborhood'] ?? ''); ?>" placeholder="Ex: Bela Vista" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr 2fr; gap: 20px;">
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="city" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Cidade *</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($address['city'] ?? ''); ?>" placeholder="Ex: São Paulo" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="state" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">Estado *</label>
            <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($address['state'] ?? ''); ?>" placeholder="Ex: SP" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="postal_code" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">CEP *</label>
            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($address['postal_code'] ?? ''); ?>" placeholder="Ex: 01310-100" required style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 8px;">
        <label for="country" style="font-family: var(--font-outfit); font-weight: 600; font-size: 0.9rem; color: var(--text-color);">País</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($address['country'] ?? 'Brasil'); ?>" placeholder="Ex: Brasil" style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.95rem; outline: none; transition: border-color 0.25s ease;" onfocus="this.style.borderColor='var(--accent-purple)'" onblur="this.style.borderColor='var(--border-color)'">
    </div>

    <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
        <input type="checkbox" id="is_default" name="is_default" value="1" <?php echo (!empty($address['is_default'])) ? 'checked' : ''; ?> style="width: 18px; height: 18px; accent-color: var(--accent-purple); cursor: pointer;">
        <label for="is_default" style="font-family: var(--font-inter); font-size: 0.9rem; color: var(--text-color); cursor: pointer; user-select: none;">Definir como endereço padrão de entrega</label>
    </div>

    <button type="submit" style="align-self: flex-start; padding: 14px 32px; background-color: var(--accent-purple); color: #ffffff; border: none; border-radius: 30px; font-family: var(--font-outfit); font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: background-color 0.25s ease; margin-top: 10px;" onmouseover="this.style.backgroundColor='var(--accent-purple-hover)'" onmouseout="this.style.backgroundColor='var(--accent-purple)'">
        Salvar Endereço
    </button>
</form>

<?php require_once __DIR__ . '/../../layout_footer.php'; ?>
