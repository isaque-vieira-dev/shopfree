<?php require_once __DIR__ . '/layout/header.php'; ?>

<section class="products-banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h1>Nossos Produtos</h1>
        <p><a href="/">Home</a> • <span>Produtos</span></p>
    </div>
</section>

<section class="products-catalog-section">
    <div class="catalog-container">
        <aside class="filters-sidebar">
            <h2 class="filters-title">Filtros</h2>
            <form action="/products" method="GET" class="filters-form">
                <div class="filter-group">
                    <label for="search">Pesquisar por Nome</label>
                    <div class="search-input-wrapper">
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Digite o nome do produto...">
                    </div>
                </div>

                <div class="filter-group">
                    <label for="category_id">Categoria</label>
                    <select id="category_id" name="category_id">
                        <option value="">Todas as Categorias</option>
                        <?php foreach ($allCategories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($categoryId == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-filter-submit">Filtrar Resultados</button>
                    <?php if ($categoryId !== null || $search !== null): ?>
                        <a href="/products" class="btn-filter-clear">Limpar Filtros</a>
                    <?php endif; ?>
                </div>
            </form>
        </aside>

        <main class="products-display-area">
            <div class="results-header">
                <p class="results-count">
                    Mostrando <strong><?php echo count($products); ?></strong> produto(s) encontrado(s).
                </p>
            </div>

            <?php if (empty($products)): ?>
                <div class="empty-products-state">
                    <svg viewBox="0 0 24 24" width="60" height="60" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    <h3>Nenhum produto encontrado</h3>
                    <p>Tente ajustar os termos de pesquisa ou remover os filtros aplicados.</p>
                    <a href="/products" class="btn-reset-catalog">Ver Todos os Produtos</a>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <a href="/product?id=<?php echo $product['id']; ?>" class="product-card-link-wrapper" style="text-decoration: none; color: inherit; display: block;">
                                <div class="product-image-wrapper">
                                    <?php if (!empty($product['image_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="no-image-placeholder">Sem Imagem</div>
                                    <?php endif; ?>
                                    <span class="product-badge"><?php echo htmlspecialchars($product['category_name'] ?? 'Produto'); ?></span>
                                </div>
                            </a>
                            <div class="product-details">
                                <a href="/product?id=<?php echo $product['id']; ?>" style="text-decoration: none; color: inherit;">
                                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                </a>
                                <p class="product-description"><?php echo htmlspecialchars(mb_strimwidth($product['description'] ?? '', 0, 80, "...")); ?></p>
                                <div class="product-footer">
                                    <span class="product-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></span>
                                    <a href="/product?id=<?php echo $product['id']; ?>" class="add-to-cart-btn" aria-label="Ver Detalhes">
                                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                            <polyline points="12 5 19 12 12 19"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</section>

<style>
    .products-banner {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        text-align: center;
    }

    .banner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(124, 58, 237, 0.45);
        z-index: 1;
    }

    .banner-content {
        position: relative;
        z-index: 2;
    }

    .banner-content h1 {
        font-family: var(--font-outfit);
        font-size: 2.6rem;
        font-weight: 700;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .banner-content p {
        font-family: var(--font-outfit);
        font-size: 0.95rem;
    }

    .banner-content a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .banner-content a:hover {
        color: #ffffff;
    }

    .banner-content span {
        color: #ddd6fe;
    }

    .products-catalog-section {
        padding: 60px 8% 100px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .catalog-container {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 40px;
        align-items: start;
    }

    .filters-sidebar {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 30px;
        position: sticky;
        top: 100px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    .filters-title {
        font-family: var(--font-outfit);
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 24px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 12px;
    }

    .filters-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-color);
    }

    .filter-group input[type="text"],
    .filter-group select {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        font-family: var(--font-inter);
        font-size: 0.9rem;
        outline: none;
        background-color: #ffffff;
        transition: border-color 0.25s ease;
    }

    .filter-group input[type="text"]:focus,
    .filter-group select:focus {
        border-color: var(--accent-purple);
    }

    .filter-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 10px;
    }

    .btn-filter-submit {
        background-color: var(--accent-purple);
        color: #ffffff;
        border: none;
        border-radius: 30px;
        padding: 14px 20px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.25s ease, transform 0.2s ease;
        text-align: center;
    }

    .btn-filter-submit:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-1px);
    }

    .btn-filter-clear {
        color: #ef4444;
        background-color: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 30px;
        padding: 12px 20px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.25s ease;
    }

    .btn-filter-clear:hover {
        background-color: #ef4444;
        color: #ffffff;
        border-color: #ef4444;
    }

    .products-display-area {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .results-header {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 16px;
    }

    .results-count {
        font-family: var(--font-inter);
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 24px;
    }

    .product-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 24px rgba(124, 58, 237, 0.08);
        border-color: rgba(124, 58, 237, 0.15);
    }

    .product-image-wrapper {
        position: relative;
        height: 200px;
        width: 100%;
        background-color: #f5f5f5;
        overflow: hidden;
    }

    .product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image-wrapper img {
        transform: scale(1.05);
    }

    .no-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-outfit);
        font-weight: 500;
        color: var(--text-muted);
        background-color: #eaeaea;
    }

    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background-color: rgba(255, 255, 255, 0.95);
        color: var(--text-color);
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 0.72rem;
        font-family: var(--font-outfit);
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        backdrop-filter: blur(4px);
    }

    .product-details {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-grow: 1;
    }

    .product-name {
        font-family: var(--font-outfit);
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-description {
        font-family: var(--font-inter);
        font-size: 0.8rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 36px;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid rgba(0,0,0,0.02);
    }

    .product-price {
        font-family: var(--font-outfit);
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--accent-purple);
    }

    .add-to-cart-btn {
        background-color: var(--accent-purple-light);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--accent-purple);
        transition: all 0.25s ease;
    }

    .add-to-cart-btn:hover {
        background-color: var(--accent-purple);
        color: #ffffff;
        transform: scale(1.08);
    }

    .empty-products-state {
        text-align: center;
        padding: 80px 40px;
        background-color: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .empty-products-state h3 {
        font-family: var(--font-outfit);
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-color);
    }

    .empty-products-state p {
        font-family: var(--font-inter);
        font-size: 0.95rem;
        max-width: 380px;
        line-height: 1.5;
    }

    .btn-reset-catalog {
        background-color: var(--accent-purple);
        color: #ffffff;
        text-decoration: none;
        border-radius: 30px;
        padding: 12px 24px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.25s ease;
        margin-top: 10px;
    }

    .btn-reset-catalog:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-1px);
    }

    @media (max-width: 992px) {
        .catalog-container {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .filters-sidebar {
            position: relative;
            top: 0;
        }
    }
</style>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
