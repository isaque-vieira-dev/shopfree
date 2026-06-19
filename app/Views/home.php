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
            <a href="#shop" class="btn btn-solid">COMPRE AGORA &gt;</a>
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
</style>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
