<?php require_once __DIR__ . '/layout/header.php'; ?>

<!-- Seção Hero -->
<section class="hero-section">
    <div class="hero-content">
        <span class="badge-new">Bem vindo ao ShopFree</span>
        <h1 class="hero-title">Tudo que voce precisa<br>em um só lugar</h1>
        <p class="hero-description">
            Bem-vindo ao ShopFree, o seu destino definitivo para moda e estilo online. Descubra as últimas tendências, selecione seus itens favoritos e receba tudo no conforto da sua casa.
        </p>
        <div class="hero-buttons">
            <a href="/products" class="btn btn-solid">COMPRE AGORA &gt;</a>
        </div>
    </div>
    
    <div class="hero-image-container">
        <!-- Círculo abstrato em degradê roxo ao fundo -->
        <div class="blob-bg"></div>
        
        <!-- Ilustração SVG premium de uma Cadeira Moderna -->
        <svg class="chair-svg" viewBox="0 0 500 500" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Sombra projetada -->
            <ellipse cx="250" cy="430" rx="140" ry="20" fill="rgba(0, 0, 0, 0.08)" />
            
            <!-- Pernas da Cadeira -->
            <path d="M190 310 L150 430" stroke="#7c2d12" stroke-width="14" stroke-linecap="round" />
            <path d="M310 310 L350 430" stroke="#7c2d12" stroke-width="14" stroke-linecap="round" />
            <path d="M210 310 L230 420" stroke="#9a3412" stroke-width="10" stroke-linecap="round" />
            <path d="M290 310 L270 420" stroke="#9a3412" stroke-width="10" stroke-linecap="round" />
            
            <!-- Assento/Encosto da Cadeira Estofada (Teal/Turquesa como na foto, contrastando perfeitamente com o roxo) -->
            <path d="M140 280 C140 230, 160 160, 200 120 C230 90, 270 90, 300 120 C340 160, 360 230, 360 280 C360 320, 340 340, 250 340 C160 340, 140 320, 140 280 Z" fill="#2dd4bf" />
            <path d="M140 280 C140 310, 170 330, 250 330 C330 330, 360 310, 360 280 C360 250, 330 240, 250 240 C170 240, 140 250, 140 280 Z" fill="#0d9488" />
            
            <!-- Detalhes das costuras capitonê -->
            <circle cx="210" cy="180" r="6" fill="#115e59" />
            <circle cx="250" cy="180" r="6" fill="#115e59" />
            <circle cx="290" cy="180" r="6" fill="#115e59" />
            
            <circle cx="190" cy="220" r="6" fill="#115e59" />
            <circle cx="250" cy="220" r="6" fill="#115e59" />
            <circle cx="310" cy="220" r="6" fill="#115e59" />
            
            <circle cx="210" cy="260" r="6" fill="#115e59" />
            <circle cx="250" cy="260" r="6" fill="#115e59" />
            <circle cx="290" cy="260" r="6" fill="#115e59" />
        </svg>
    </div>
</section>

<!-- Seção de Proposta de Valor -->
<section class="features-section">
    <div class="feature-item">
        <div class="feature-icon">
            <!-- Caminhão de Entrega -->
            <svg viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
        </div>
        <div class="feature-info">
            <h3>Frete Gratis</h3>
            <p>Entrega gratis em todos os pedidos</p>
        </div>
    </div>
    
    <div class="feature-item">
        <div class="feature-icon">
            <!-- Reembolso/Dinheiro -->
            <svg viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
        </div>
        <div class="feature-info">
            <h3>Money Return</h3>
            <p>Back guarantee under 7 day</p>
        </div>
    </div>

    <div class="feature-item">
        <div class="feature-icon">
            <!-- Suporte 24/7 -->
            <svg viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <div class="feature-info">
            <h3>Suporte 24/7</h3>
            <p>Suporte online 24 horas por dia</p>
        </div>
    </div>

    <div class="feature-item">
        <div class="feature-icon">
            <!-- Confiável/Selo -->
            <svg viewBox="0 0 24 24" width="28" height="28" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
        </div>
        <div class="feature-info">
            <h3>Confiável</h3>
            <p>Confiável por mais de 1000 marcas</p>
        </div>
    </div>
</section>

<!-- Seção de Carrossel de Categorias -->
<?php if (!empty($allCategories)): ?>
    <section class="categories-showcase-section">
        <div class="carousel-header">
            <h2 class="category-title">Navegue por Categoria</h2>
            <div class="carousel-nav-buttons">
                <button class="nav-btn prev-btn" onclick="slideCategoriesCarousel(-1)">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="nav-btn next-btn" onclick="slideCategoriesCarousel(1)">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </div>
        
        <div class="categories-carousel-container">
            <div class="categories-carousel-track" id="categories-carousel-track">
                <?php foreach ($allCategories as $cat): ?>
                    <a href="/products?category_id=<?php echo $cat['id']; ?>" class="category-card-pill">
                        <div class="category-icon-wrapper">
                            <?php if (!empty($cat['image_path'])): ?>
                                <img src="<?php echo htmlspecialchars($cat['image_path']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>" style="width: 100%; height: 100%; object-fit: cover;">
                            <?php else: ?>
                                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                            <?php endif; ?>
                        </div>
                        <span class="category-pill-name"><?php echo htmlspecialchars($cat['name']); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Seções de Carrosséis de Produtos por Categoria -->
<?php if (!empty($carousels)): ?>
    <section class="storefront-section" id="shop">
        <?php foreach ($carousels as $index => $carousel): ?>
            <div class="category-carousel-block">
                <div class="carousel-header">
                    <h2 class="category-title"><?php echo htmlspecialchars($carousel['category']['name']); ?></h2>
                    <div class="carousel-nav-buttons">
                        <button class="nav-btn prev-btn" onclick="slideCarousel(<?php echo $index; ?>, -1)">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button class="nav-btn next-btn" onclick="slideCarousel(<?php echo $index; ?>, 1)">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
                
                <div class="carousel-track-container">
                    <div class="carousel-track" id="carousel-track-<?php echo $index; ?>">
                        <?php foreach ($carousel['products'] as $product): ?>
                            <div class="product-card">
                                <div class="product-image-wrapper">
                                    <?php if (!empty($product['image_path'])): ?>
                                        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                                    <?php else: ?>
                                        <div class="no-image-placeholder">Sem Imagem</div>
                                    <?php endif; ?>
                                    <span class="product-badge"><?php echo htmlspecialchars($carousel['category']['name']); ?></span>
                                </div>
                                <div class="product-details">
                                    <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                                    <p class="product-description"><?php echo htmlspecialchars(mb_strimwidth($product['description'], 0, 80, "...")); ?></p>
                                    <div class="product-footer">
                                        <span class="product-price">R$ <?php echo number_format($product['price'], 2, ',', '.'); ?></span>
                                        <button class="add-to-cart-btn" aria-label="Comprar">
                                            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
<?php endif; ?>

<script>
function slideCarousel(index, direction) {
    const track = document.getElementById('carousel-track-' + index);
    if (track) {
        const scrollAmount = 304 * 2; // Scroll 2 cards
        track.parentElement.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
}

function slideCategoriesCarousel(direction) {
    const track = document.getElementById('categories-carousel-track');
    if (track) {
        const scrollAmount = 240 * 2; // Scroll 2 items
        track.parentElement.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }
}
</script>

<style>
    /* Estilos da Seção Hero */
    .hero-section {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        align-items: center;
        padding: 60px 8% 100px 8%;
        gap: 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .hero-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .badge-new {
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
        padding: 6px 12px;
        border-radius: 4px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.85rem;
        letter-spacing: 1px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-family: var(--font-outfit);
        font-size: 3.8rem;
        line-height: 1.15;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 24px;
        letter-spacing: -1px;
    }

    .hero-description {
        font-family: var(--font-inter);
        font-size: 1rem;
        color: var(--text-muted);
        max-width: 480px;
        margin-bottom: 40px;
        line-height: 1.7;
    }

    .hero-buttons {
        display: flex;
        gap: 16px;
    }

    .btn {
        display: inline-block;
        padding: 16px 36px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        letter-spacing: 0.5px;
    }

    .btn-solid {
        background-color: var(--accent-purple);
        color: #ffffff;
        border: 1px solid var(--accent-purple);
    }

    .btn-solid:hover {
        background-color: var(--accent-purple-hover);
        border-color: var(--accent-purple-hover);
        transform: translateY(-2px);
    }

    .btn-outline {
        background-color: transparent;
        color: var(--text-color);
        border: 1px solid rgba(0, 0, 0, 0.15);
    }

    .btn-outline:hover {
        border-color: var(--accent-purple);
        color: var(--accent-purple);
        transform: translateY(-2px);
    }

    /* Imagem do Hero / Blob */
    .hero-image-container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 480px;
    }

    .blob-bg {
        position: absolute;
        width: 320px;
        height: 320px;
        background: linear-gradient(135deg, var(--accent-purple) 0%, #a78bfa 100%);
        border-radius: 50%;
        z-index: 1;
        opacity: 0.85;
        box-shadow: 0 20px 40px rgba(124, 58, 237, 0.25);
    }

    .chair-svg {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 440px;
        filter: drop-shadow(0 20px 30px rgba(0, 0, 0, 0.15));
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* Seção de Características / Propostas de Valor */
    .features-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 30px;
        padding: 50px 8%;
        background-color: #ffffff;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        max-width: 1400px;
        margin: 0 auto 80px auto;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .feature-icon {
        color: var(--accent-purple);
        background-color: var(--accent-purple-light);
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .feature-info h3 {
        font-family: var(--font-outfit);
        font-size: 1.05rem;
        font-weight: 600;
        margin-bottom: 4px;
        color: var(--text-color);
    }

    .feature-info p {
        font-family: var(--font-inter);
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    /* Responsividade */
    @media (max-width: 992px) {
        .hero-section {
            grid-template-columns: 1fr;
            text-align: center;
            padding-bottom: 60px;
        }

        .hero-content {
            align-items: center;
        }

        .hero-title {
            font-size: 2.8rem;
        }

        .hero-image-container {
            height: 380px;
        }

        .blob-bg {
            width: 260px;
            height: 260px;
        }

        .chair-svg {
            max-width: 340px;
        }
    }

    /* Estilos dos Carrosséis de Produtos */
    .storefront-section {
        padding: 40px 8% 80px 8%;
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 60px;
    }

    .category-carousel-block {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .carousel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 12px;
    }

    .category-title {
        font-family: var(--font-outfit);
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-color);
        position: relative;
    }

    .category-title::after {
        content: '';
        position: absolute;
        bottom: -14px;
        left: 0;
        width: 60px;
        height: 3px;
        background-color: var(--accent-purple);
        border-radius: 2px;
    }

    .carousel-nav-buttons {
        display: flex;
        gap: 8px;
    }

    .nav-btn {
        background: #ffffff;
        border: 1px solid var(--border-color);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--text-color);
        transition: all 0.25s ease;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .nav-btn:hover {
        background-color: var(--accent-purple);
        color: #ffffff;
        border-color: var(--accent-purple);
        transform: scale(1.05);
    }

    .carousel-track-container {
        overflow-x: auto;
        scrollbar-width: none; /* Firefox */
        scroll-behavior: smooth;
        padding: 10px 0;
    }

    .carousel-track-container::-webkit-scrollbar {
        display: none; /* Safari/Chrome */
    }

    .carousel-track {
        display: flex;
        gap: 24px;
    }

    .product-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        width: 280px;
        flex-shrink: 0;
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
        height: 220px;
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
        background-color: rgba(255, 255, 255, 0.9);
        color: var(--text-color);
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 0.75rem;
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
        font-size: 1.1rem;
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
        font-size: 0.82rem;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 38px;
    }

    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 12px;
    }

    .product-price {
        font-family: var(--font-outfit);
        font-size: 1.25rem;
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

    /* Estilos do Carrossel de Categorias */
    .categories-showcase-section {
        padding: 60px 8% 0 8%;
        max-width: 1400px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .categories-carousel-container {
        overflow-x: auto;
        scrollbar-width: none;
        scroll-behavior: smooth;
        padding: 10px 0;
    }

    .categories-carousel-container::-webkit-scrollbar {
        display: none;
    }

    .categories-carousel-track {
        display: flex;
        gap: 16px;
    }

    .category-card-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #ffffff;
        border: 1px solid var(--border-color);
        padding: 12px 22px;
        border-radius: 40px;
        text-decoration: none;
        color: var(--text-color);
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.92rem;
        flex-shrink: 0;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.01);
    }

    .category-card-pill:hover {
        border-color: var(--accent-purple);
        color: var(--accent-purple);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(124, 58, 237, 0.08);
    }

    .category-icon-wrapper {
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
        overflow: hidden;
    }

    .category-card-pill:hover .category-icon-wrapper {
        background-color: var(--accent-purple);
        color: #ffffff;
    }
</style>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
