<?php require_once __DIR__ . '/layout/header.php'; ?>

<section class="product-detail-section">
    <div class="container">
        <div class="back-navigation">
            <a href="/products" class="btn-back">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Voltar para Produtos
            </a>
        </div>

        <div class="product-detail-grid">
            <div class="product-media-column">
                <div class="product-image-card">
                    <?php if (!empty($product['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php else: ?>
                        <div class="detail-no-image-placeholder">
                            <svg viewBox="0 0 24 24" width="64" height="64" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span>Sem Imagem Disponível</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="product-info-column">
                <div class="product-meta-header">
                    <?php if ($category): ?>
                        <a href="/products?category_id=<?php echo $category['id']; ?>" class="detail-category-badge">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (($product['stock'] ?? 0) > 0): ?>
                        <span class="stock-badge in-stock">
                            <span class="pulse-dot"></span>
                            Em Estoque (<?php echo (int)$product['stock']; ?>)
                        </span>
                    <?php else: ?>
                        <span class="stock-badge out-of-stock">
                            Fora de Estoque
                        </span>
                    <?php endif; ?>
                </div>

                <h1 class="detail-product-name"><?php echo htmlspecialchars($product['name']); ?></h1>

                <div class="detail-price-box">
                    <span class="price-label">Preço à vista</span>
                    <span class="detail-product-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></span>
                </div>

                <div class="detail-description-box">
                    <h2>Descrição do Produto</h2>
                    <p><?php echo nl2br(htmlspecialchars($product['description'] ?? 'Sem descrição disponível para este produto.')); ?></p>
                </div>

                <div class="product-actions-panel">
                    <?php 
                    $isLoggedIn = isset($_SESSION['user_id']);
                    $roleId = $_SESSION['role_id'] ?? null;
                    $roleName = $_SESSION['role_name'] ?? null;
                    
                    $isClient = $isLoggedIn && ($roleId == 2 || $roleName === 'Usuário');
                    $isSeller = $isLoggedIn && ($roleId == 3 || $roleName === 'Vendedor');
                    $isOwner = $isSeller && ((int)$product['user_id'] === (int)$_SESSION['user_id']);
                    ?>

                    <?php if ($isClient): ?>
                        <div class="action-wrapper" style="display: flex; gap: 16px; align-items: center;">
                            <?php if (($product['stock'] ?? 0) > 0): ?>
                                <div class="quantity-controller" style="display: inline-flex; align-items: center; border: 1px solid var(--border-color); border-radius: 30px; overflow: hidden; background-color: #ffffff; height: 56px; padding: 0 8px; flex-shrink: 0;">
                                    <button type="button" class="qty-btn" id="qty-minus" style="background: none; border: none; width: 36px; height: 36px; cursor: pointer; font-size: 1.2rem; font-weight: 600; color: var(--text-color); display: flex; align-items: center; justify-content: center;">-</button>
                                    <input type="number" id="detail-qty-input" value="1" min="1" max="<?php echo (int)$product['stock']; ?>" readonly style="width: 44px; border: none; outline: none; text-align: center; font-family: var(--font-outfit); font-weight: 700; font-size: 1.1rem; background: none; -moz-appearance: textfield;">
                                    <button type="button" class="qty-btn" id="qty-plus" style="background: none; border: none; width: 36px; height: 36px; cursor: pointer; font-size: 1.2rem; font-weight: 600; color: var(--text-color); display: flex; align-items: center; justify-content: center;">+</button>
                                </div>
                                <button class="btn-action btn-add-cart" id="btn-add-to-cart" data-product-id="<?php echo $product['id']; ?>">
                                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Adicionar ao Carrinho
                                </button>
                            <?php else: ?>
                                <button class="btn-action btn-disabled" disabled>
                                    Produto Indisponível
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($isOwner): ?>
                        <div class="action-wrapper">
                            <a href="/seller/products/edit?id=<?php echo $product['id']; ?>" class="btn-action btn-edit-product">
                                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Editar Produto
                            </a>
                        </div>
                    <?php elseif (!$isLoggedIn): ?>
                        <div class="guest-info-box">
                            <p>Faça login como cliente para adicionar este produto ao carrinho.</p>
                            <a href="/login" class="btn-action btn-login-redirect">Entrar na minha conta</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="cart-toast" id="cart-toast">
    <div class="toast-content">
        <svg class="toast-icon" viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <div class="toast-text-wrapper">
            <span class="toast-message">Produto adicionado ao carrinho!</span>
            <a href="/cart" class="toast-link">Visualizar Carrinho</a>
        </div>
    </div>
</div>

<style>
    .product-detail-section {
        padding: 50px 8% 100px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .container {
        width: 100%;
    }

    .back-navigation {
        margin-bottom: 30px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-muted);
        text-decoration: none;
        font-family: var(--font-outfit);
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.25s ease;
    }

    .btn-back:hover {
        color: var(--accent-purple);
    }

    .product-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
    }

    .product-media-column {
        position: sticky;
        top: 100px;
    }

    .product-image-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        aspect-ratio: 1 / 1;
    }

    .product-image-card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 16px;
        transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .product-image-card:hover img {
        transform: scale(1.03);
    }

    .detail-no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        background-color: #f5f5f5;
        border-radius: 16px;
        gap: 16px;
    }

    .detail-no-image-placeholder span {
        font-family: var(--font-outfit);
        font-weight: 500;
        font-size: 1.1rem;
    }

    .product-info-column {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .product-meta-header {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .detail-category-badge {
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
        padding: 6px 16px;
        border-radius: 30px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.25s ease;
        border: 1px solid rgba(124, 58, 237, 0.1);
    }

    .detail-category-badge:hover {
        background-color: var(--accent-purple);
        color: #ffffff;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 30px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.85rem;
    }

    .stock-badge.in-stock {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .stock-badge.out-of-stock {
        background-color: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #15803d;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 1.8s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.9);
            opacity: 1;
        }
        50% {
            transform: scale(1.3);
            opacity: 0.5;
        }
        100% {
            transform: scale(0.9);
            opacity: 1;
        }
    }

    .detail-product-name {
        font-family: var(--font-outfit);
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--text-color);
        line-height: 1.15;
        letter-spacing: -0.8px;
    }

    .detail-price-box {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    .price-label {
        font-family: var(--font-inter);
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-product-price {
        font-family: var(--font-outfit);
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--accent-purple);
    }

    .detail-description-box h2 {
        font-family: var(--font-outfit);
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 12px;
    }

    .detail-description-box p {
        font-family: var(--font-inter);
        font-size: 0.98rem;
        line-height: 1.7;
        color: #4a4a4a;
    }

    .product-actions-panel {
        margin-top: 10px;
        border-top: 1px solid var(--border-color);
        padding-top: 30px;
    }

    .action-wrapper {
        display: flex;
        gap: 16px;
    }

    .btn-action {
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 18px 30px;
        border-radius: 35px;
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 1.05rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
    }

    .btn-add-cart {
        background-color: var(--accent-purple);
        color: #ffffff;
        box-shadow: 0 8px 20px rgba(124, 58, 237, 0.2);
    }

    .btn-add-cart:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.3);
    }

    .btn-edit-product {
        background-color: #ffffff;
        color: var(--text-color);
        border: 2px solid var(--text-color);
    }

    .btn-edit-product:hover {
        background-color: var(--text-color);
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .btn-disabled {
        background-color: #eaeaea;
        color: #999999;
        cursor: not-allowed;
    }

    .guest-info-box {
        background-color: #f3f4f6;
        border: 1px dashed var(--border-color);
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .guest-info-box p {
        font-family: var(--font-inter);
        font-size: 0.95rem;
        color: var(--text-muted);
        max-width: 320px;
    }

    .btn-login-redirect {
        background-color: var(--text-color);
        color: #ffffff;
        padding: 12px 24px;
        font-size: 0.95rem;
    }

    .btn-login-redirect:hover {
        background-color: #333333;
        transform: translateY(-1px);
    }

    .cart-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background-color: #1e1b4b;
        color: #ffffff;
        padding: 16px 24px;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        z-index: 2000;
        display: none;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .cart-toast.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toast-icon {
        color: #10b981;
        flex-shrink: 0;
    }

    .toast-text-wrapper {
        display: flex;
        flex-direction: column;
        gap: 2px;
        text-align: left;
    }

    .toast-message {
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .toast-link {
        font-family: var(--font-inter);
        font-size: 0.82rem;
        color: #a5b4fc;
        text-decoration: underline;
        font-weight: 500;
    }

    .toast-link:hover {
        color: #c7d2fe;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnAddCart = document.getElementById('btn-add-to-cart');
    const toast = document.getElementById('cart-toast');
    const qtyInput = document.getElementById('detail-qty-input');
    const qtyMinus = document.getElementById('qty-minus');
    const qtyPlus = document.getElementById('qty-plus');
    
    if (qtyMinus && qtyPlus && qtyInput) {
        qtyMinus.addEventListener('click', function() {
            let val = parseInt(qtyInput.value) || 1;
            if (val > 1) {
                qtyInput.value = val - 1;
            }
        });
        qtyPlus.addEventListener('click', function() {
            let val = parseInt(qtyInput.value) || 1;
            const max = parseInt(qtyInput.getAttribute('max')) || 9999;
            if (val < max) {
                qtyInput.value = val + 1;
            }
        });
    }
    
    if (btnAddCart) {
        btnAddCart.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const formData = new FormData();
            formData.append('product_id', productId);
            
            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
            formData.append('quantity', quantity);

            btnAddCart.disabled = true;
            const originalHTML = btnAddCart.innerHTML;
            btnAddCart.innerText = 'Adicionando...';

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                btnAddCart.disabled = false;
                btnAddCart.innerHTML = originalHTML;

                if (data.success) {
                    toast.classList.add('show');
                    
                    if (window.updateHeaderCart) {
                        window.updateHeaderCart(data.cartCount, data.cartTotal, data.cartItems);
                    }

                    setTimeout(() => {
                        toast.classList.remove('show');
                    }, 5000);
                } else {
                    alert(data.message || 'Erro ao adicionar ao carrinho.');
                }
            })
            .catch(err => {
                btnAddCart.disabled = false;
                btnAddCart.innerHTML = originalHTML;
                console.error(err);
                alert('Erro de conexão ao adicionar produto.');
            });
        });
    }
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
