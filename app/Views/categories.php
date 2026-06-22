<?php require_once __DIR__ . '/layout/header.php'; ?>

<!-- Banner Superior -->
<section class="categories-banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h1>Nossas Categorias</h1>
        <p><a href="/">Home</a> • <span>Categorias</span></p>
    </div>
</section>

<!-- Catálogo de Categorias -->
<section class="categories-catalog-section">
    <div class="section-header">
        <span class="badge-accent">Curadoria Especial</span>
        <h2>Explore Nossas Coleções</h2>
        <p class="section-subtitle">
            Selecionamos as melhores tendências de produtos para trazer inspiração e design refinado para o seu dia a dia.
        </p>
    </div>

    <div class="categories-grid">
        <?php foreach ($allCategories as $cat): ?>
            <div class="category-catalog-card">
                <div class="category-image-container">
                    <?php if (!empty($cat['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($cat['image_path']); ?>" alt="<?php echo htmlspecialchars($cat['name']); ?>" class="category-card-img" loading="lazy">
                    <?php else: ?>
                        <div class="category-no-img">
                            <svg viewBox="0 0 24 24" width="40" height="40" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                    <?php endif; ?>
                    <div class="card-overlay"></div>
                </div>
                
                <div class="category-card-info">
                    <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
                    <a href="/products?category_id=<?php echo $cat['id']; ?>" class="explore-category-btn">
                        Ver Coleção
                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<style>
    /* Banner Superior */
    .categories-banner {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80');
        background-size: cover;
        background-position: center;
        height: 250px;
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
        background-color: rgba(124, 58, 237, 0.45); /* Overlay Roxo Premium */
        backdrop-filter: blur(1px);
        z-index: 1;
    }

    .banner-content {
        position: relative;
        z-index: 2;
    }

    .banner-content h1 {
        font-family: var(--font-outfit);
        font-size: 2.8rem;
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

    /* Seção de Catálogo */
    .categories-catalog-section {
        padding: 80px 8% 120px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .badge-accent {
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
        padding: 6px 12px;
        border-radius: 4px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 1px;
        display: inline-block;
        margin-bottom: 16px;
        text-transform: uppercase;
    }

    .section-header h2 {
        font-family: var(--font-outfit);
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 16px;
    }

    .section-subtitle {
        font-family: var(--font-inter);
        font-size: 1rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Grid de Categorias */
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 30px;
    }

    .category-catalog-card {
        background-color: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    .category-catalog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px rgba(124, 58, 237, 0.08);
        border-color: rgba(124, 58, 237, 0.15);
    }

    .category-image-container {
        position: relative;
        height: 240px;
        width: 100%;
        background-color: #f5f5f5;
        overflow: hidden;
    }

    .category-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .category-catalog-card:hover .category-card-img {
        transform: scale(1.06);
    }

    .category-no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        background-color: #eaeaea;
    }

    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0) 50%, rgba(0,0,0,0.15) 100%);
        pointer-events: none;
    }

    .category-card-info {
        padding: 30px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        background-color: #ffffff;
    }

    .category-card-info h3 {
        font-family: var(--font-outfit);
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-color);
        margin: 0;
    }

    .explore-category-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--accent-purple);
        text-decoration: none;
        transition: gap 0.25s ease, color 0.25s ease;
        align-self: flex-start;
    }

    .explore-category-btn:hover {
        color: var(--accent-purple-hover);
        gap: 12px;
    }

    @media (max-width: 768px) {
        .categories-grid {
            grid-template-columns: 1fr;
        }

        .section-header h2 {
            font-size: 2rem;
        }
    }
</style>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
