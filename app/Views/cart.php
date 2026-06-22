<?php require_once __DIR__ . '/layout/header.php'; ?>

<section class="cart-page-section">
    <div class="container">
        <h1 class="cart-title">Seu Carrinho</h1>

        <div id="cart-content-wrapper" class="<?php echo empty($cartItems) ? 'is-empty' : ''; ?>">
            <div class="cart-empty-state">
                <div class="empty-icon-wrapper">
                    <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                </div>
                <h2>Seu carrinho está vazio</h2>
                <p>Parece que você ainda não adicionou nenhum produto ao seu carrinho.</p>
                <a href="/products" class="btn-continue-shopping">Explorar Produtos</a>
            </div>

            <div class="cart-main-layout">
                <div class="cart-items-column">
                    <div class="cart-table-card">
                        <div class="cart-items-list">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="cart-item-row" id="cart-row-<?php echo $item['id']; ?>">
                                    <div class="cart-item-image">
                                        <?php if (!empty($item['image_path'])): ?>
                                            <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <?php else: ?>
                                            <div class="cart-no-image">Sem Foto</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="cart-item-details">
                                        <a href="/product?id=<?php echo $item['id']; ?>" class="cart-item-name">
                                            <?php echo htmlspecialchars($item['name']); ?>
                                        </a>
                                        <span class="cart-item-unit-price">
                                            Unitário: R$ <?php echo number_format($item['price'], 2, ',', '.'); ?>
                                        </span>
                                    </div>
                                    <div class="cart-item-quantity">
                                        <div class="quantity-controller">
                                            <button type="button" class="qty-btn" onclick="updateRowQty(<?php echo $item['id']; ?>, -1)">-</button>
                                            <input type="number" class="qty-input" id="qty-input-<?php echo $item['id']; ?>" value="<?php echo (int)$item['quantity']; ?>" min="1" max="<?php echo (int)$item['max_stock']; ?>" readonly>
                                            <button type="button" class="qty-btn" onclick="updateRowQty(<?php echo $item['id']; ?>, 1)">+</button>
                                        </div>
                                    </div>
                                    <div class="cart-item-subtotal">
                                        <span class="subtotal-label">Subtotal</span>
                                        <span class="subtotal-value" id="subtotal-val-<?php echo $item['id']; ?>">
                                            R$ <?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?>
                                        </span>
                                    </div>
                                    <div class="cart-item-remove">
                                        <button type="button" class="btn-remove-item" onclick="removeRowItem(<?php echo $item['id']; ?>)" aria-label="Remover item">
                                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="cart-footer-actions">
                        <a href="/products" class="btn-back-catalog">
                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Continuar Comprando
                        </a>
                    </div>
                </div>

                <div class="cart-summary-column">
                    <div class="summary-card">
                        <h2>Resumo do Pedido</h2>
                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Subtotal dos itens</span>
                                <span id="summary-subtotal">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                            </div>
                            <div class="summary-row">
                                <span>Frete</span>
                                <span class="free-shipping">Grátis</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row total-row" style="margin-bottom: 20px;">
                                <span>Total</span>
                                <span id="summary-total">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                            </div>
                        </div>

                        <div class="summary-address-section" style="margin-bottom: 24px; text-align: left;">
                            <h3 style="font-family: var(--font-outfit); font-size: 1rem; font-weight: 700; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; color: var(--text-color);">
                                Endereço de Entrega
                                <a href="/dashboard/addresses/create" style="font-size: 0.8rem; color: var(--accent-purple); text-decoration: none; font-weight: 600;">+ Adicionar</a>
                            </h3>
                            
                            <?php if (empty($userAddresses)): ?>
                                <div style="background-color: #fef2f2; border: 1px dashed #fca5a5; padding: 14px; border-radius: 12px; font-size: 0.82rem; color: #991b1b; text-align: center; line-height: 1.4;">
                                    Nenhum endereço cadastrado.<br>
                                    <a href="/dashboard/addresses/create" style="color: var(--accent-purple); font-weight: 700; text-decoration: underline;">Cadastrar endereço</a> para prosseguir.
                                </div>
                            <?php else: ?>
                                <div class="address-selector-wrapper">
                                    <select id="selected-address-id" style="width: 100%; padding: 12px 14px; border-radius: 12px; border: 1px solid var(--border-color); font-family: var(--font-inter); font-size: 0.85rem; outline: none; background-color: #ffffff; cursor: pointer; transition: border-color 0.2s; color: var(--text-color);">
                                        <?php foreach ($userAddresses as $addr): ?>
                                            <option value="<?php echo $addr['id']; ?>" <?php echo $addr['is_default'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($addr['street'] . ', ' . $addr['number'] . ($addr['complement'] ? ' - ' . $addr['complement'] : '') . ' (' . $addr['city'] . '/' . $addr['state'] . ')'); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>

                        <button type="button" class="btn-checkout" onclick="proceedToCheckout()">
                            Finalizar Compra
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .cart-page-section {
        padding: 50px 8% 100px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .cart-title {
        font-family: var(--font-outfit);
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-color);
        margin-bottom: 40px;
        letter-spacing: -0.5px;
    }

    .cart-main-layout {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 40px;
        align-items: start;
    }

    .cart-items-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .cart-table-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    .cart-items-list {
        display: flex;
        flex-direction: column;
    }

    .cart-item-row {
        display: grid;
        grid-template-columns: 80px 2fr 1.2fr 1.2fr auto;
        align-items: center;
        gap: 24px;
        padding: 24px;
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.2s ease;
    }

    .cart-item-row:last-child {
        border-bottom: none;
    }

    .cart-item-row:hover {
        background-color: rgba(124, 58, 237, 0.01);
    }

    .cart-item-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        background-color: #f5f5f5;
        overflow: hidden;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-no-image {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-family: var(--font-outfit);
        font-weight: 500;
    }

    .cart-item-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .cart-item-name {
        font-family: var(--font-outfit);
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-color);
        text-decoration: none;
        transition: color 0.2s ease;
        line-height: 1.3;
    }

    .cart-item-name:hover {
        color: var(--accent-purple);
    }

    .cart-item-unit-price {
        font-family: var(--font-inter);
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .quantity-controller {
        display: inline-flex;
        align-items: center;
        border: 1px solid var(--border-color);
        border-radius: 30px;
        overflow: hidden;
        background-color: #ffffff;
    }

    .qty-btn {
        background: none;
        border: none;
        width: 32px;
        height: 32px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-color);
        transition: background-color 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qty-btn:hover {
        background-color: #f5f5f5;
    }

    .qty-input {
        width: 40px;
        border: none;
        outline: none;
        text-align: center;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        background: none;
        -moz-appearance: textfield;
    }

    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .cart-item-subtotal {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .subtotal-label {
        display: none;
        font-family: var(--font-inter);
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .subtotal-value {
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--text-color);
    }

    .btn-remove-item {
        background: none;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 8px;
        border-radius: 50%;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-remove-item:hover {
        background-color: #fef2f2;
        transform: scale(1.08);
    }

    .cart-footer-actions {
        display: flex;
        justify-content: space-between;
    }

    .btn-back-catalog {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        text-decoration: none;
        font-family: var(--font-outfit);
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.2s ease;
    }

    .btn-back-catalog:hover {
        color: var(--accent-purple);
    }

    .summary-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        position: sticky;
        top: 100px;
    }

    .summary-card h2 {
        font-family: var(--font-outfit);
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 24px;
        color: var(--text-color);
    }

    .summary-details {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 30px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-family: var(--font-inter);
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .free-shipping {
        color: #166534;
        font-weight: 600;
    }

    .summary-divider {
        height: 1px;
        background-color: var(--border-color);
        margin: 4px 0;
    }

    .total-row {
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--text-color);
    }

    .btn-checkout {
        width: 100%;
        background-color: var(--accent-purple);
        color: #ffffff;
        border: none;
        border-radius: 35px;
        padding: 16px 24px;
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.15);
        transition: all 0.25s ease;
    }

    .btn-checkout:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.25);
    }

    .cart-empty-state {
        display: none;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 80px 40px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    #cart-content-wrapper.is-empty .cart-empty-state {
        display: flex;
    }

    #cart-content-wrapper.is-empty .cart-main-layout {
        display: none;
    }

    .empty-icon-wrapper {
        width: 80px;
        height: 80px;
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .empty-icon-wrapper svg {
        width: 36px;
        height: 36px;
    }

    .cart-empty-state h2 {
        font-family: var(--font-outfit);
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 8px;
    }

    .cart-empty-state p {
        font-family: var(--font-inter);
        font-size: 0.95rem;
        color: var(--text-muted);
        margin-bottom: 30px;
        max-width: 340px;
    }

    .btn-continue-shopping {
        background-color: var(--accent-purple);
        color: #ffffff;
        text-decoration: none;
        border-radius: 30px;
        padding: 14px 28px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.25s ease;
    }

    .btn-continue-shopping:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-1px);
    }

    @media (max-width: 992px) {
        .cart-main-layout {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .summary-card {
            position: relative;
            top: 0;
        }
    }

    @media (max-width: 768px) {
        .cart-item-row {
            grid-template-columns: 60px 1fr;
            gap: 16px;
            padding: 16px;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
        }

        .cart-item-quantity {
            grid-column: 1 / 3;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .cart-item-subtotal {
            grid-column: 1 / 3;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #fcfcfc;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .subtotal-label {
            display: block;
        }

        .cart-item-remove {
            position: absolute;
            right: 16px;
            margin-top: -40px;
        }
    }
</style>

<script>
function formatMoney(value) {
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
}

function updateRowQty(productId, change) {
    const input = document.getElementById('qty-input-' + productId);
    if (!input) return;

    let qty = parseInt(input.value) + change;
    const min = parseInt(input.getAttribute('min') || 1);
    const max = parseInt(input.getAttribute('max') || 9999);

    if (qty < min || qty > max) return;

    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', qty);

    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = qty;
            
            const subtotalText = document.getElementById('subtotal-val-' + productId);
            if (subtotalText) {
                subtotalText.innerText = formatMoney(data.itemSubtotal);
            }

            updateSummaryTotals(data.cartTotal);

            if (window.updateHeaderCart) {
                window.updateHeaderCart(data.cartCount, data.cartTotal, data.cartItems);
            }
        } else {
            alert(data.message || 'Erro ao atualizar quantidade.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Erro de conexão ao atualizar carrinho.');
    });
}

function removeRowItem(productId) {
    if (!confirm('Deseja realmente remover este produto do carrinho?')) return;

    const formData = new FormData();
    formData.append('product_id', productId);

    fetch('/cart/remove', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('cart-row-' + productId);
            if (row) {
                row.remove();
            }

            updateSummaryTotals(data.cartTotal);

            if (window.updateHeaderCart) {
                window.updateHeaderCart(data.cartCount, data.cartTotal, data.cartItems);
            }

            if (data.cartCount === 0) {
                document.getElementById('cart-content-wrapper').classList.add('is-empty');
            }
        } else {
            alert(data.message || 'Erro ao remover item.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Erro de conexão ao remover item.');
    });
}

function updateSummaryTotals(total) {
    const formatted = formatMoney(total);
    const subtotalEl = document.getElementById('summary-subtotal');
    const totalEl = document.getElementById('summary-total');
    if (subtotalEl) subtotalEl.innerText = formatted;
    if (totalEl) totalEl.innerText = formatted;
}

function proceedToCheckout() {
    const addressSelect = document.getElementById('selected-address-id');
    if (!addressSelect) {
        alert('Por favor, cadastre um endereço de entrega antes de finalizar a compra.');
        window.location.href = '/dashboard/addresses/create';
        return;
    }
    const addressId = addressSelect.value;
    window.location.href = '/checkout/payment?address_id=' + addressId;
}
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
