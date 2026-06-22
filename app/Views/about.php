<?php require_once __DIR__ . '/layout/header.php'; ?>

<section class="about-banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h1>Sobre Nós</h1>
        <p><a href="/">Home</a> • <span>Sobre Nós</span></p>
    </div>
</section>

<section class="about-intro-section">
    <div class="about-intro-container">
        <div class="about-image-wrapper">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80" alt="Sobre o ShopFree" class="about-img">
            <div class="about-img-accent"></div>
        </div>
        
        <div class="about-text-content">
            <span class="badge-about">QUEM SOMOS</span>
            <h2>Inovando a forma como você compra online</h2>
            <p>
                O <strong>ShopFree</strong> nasceu com um propósito claro: eliminar as barreiras e complicações do e-commerce tradicional, offering uma experiência de compra fluida, transparente e extremamente prazerosa. 
            </p>
            <p>
                Nosso foco é trazer curadoria de alta qualidade em produtos de decoração, moda e estilo de vida. Acreditamos que a estética do seu lar e do seu dia a dia influenciam diretamente o seu bem-estar, e estamos aqui para aproximar você do design de alto padrão com preços justos.
            </p>
            <div class="about-vision-grid">
                <div class="vision-item">
                    <h4>Nossa Missão</h4>
                    <p>Proporcionar acesso facilitado a produtos incríveis com entregas rápidas e atendimento humanizado.</p>
                </div>
                <div class="vision-item">
                    <h4>Nossa Visão</h4>
                    <p>Ser a plataforma referência em facilidade, confiança e excelência de curadoria na América Latina.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <h3>50k+</h3>
            <p>Clientes Satisfeitos</p>
        </div>
        <div class="stat-card">
            <h3>15k+</h3>
            <p>Avaliações 5 Estrelas</p>
        </div>
        <div class="stat-card">
            <h3>99.8%</h3>
            <p>Entregas no Prazo</p>
        </div>
        <div class="stat-card">
            <h3>24/7</h3>
            <p>Suporte Disponível</p>
        </div>
    </div>
</section>

<section class="values-section">
    <div class="section-title-wrapper">
        <span class="badge-about">NOSSOS VALORES</span>
        <h2>O que nos move diariamente</h2>
    </div>
    
    <div class="values-grid">
        <div class="value-card">
            <div class="value-icon">
                <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
            </div>
            <h3>Qualidade Curada</h3>
            <p>Cada item presente em nosso catálogo passa por uma rigorosa avaliação antes de chegar até você.</p>
        </div>

        <div class="value-card">
            <div class="value-icon">
                <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
            </div>
            <h3>Cliente Primeiro</h3>
            <p>Nosso suporte e políticas de troca são focados na total satisfação e segurança de quem nos escolhe.</p>
        </div>

        <div class="value-card">
            <div class="value-icon">
                <svg viewBox="0 0 24 24" width="26" height="26" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"></path></svg>
            </div>
            <h3>Evolução Ágil</h3>
            <p>Estamos sempre otimizando nossa plataforma e tecnologia para tornar a sua navegação ainda melhor.</p>
        </div>
    </div>
</section>

<style>
    .about-banner {
        position: relative;
        background-image: url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80');
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
        background-color: rgba(76, 29, 149, 0.6);
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

    .about-intro-section {
        padding: 80px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .about-intro-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .about-image-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .about-img {
        width: 100%;
        max-width: 500px;
        border-radius: 20px;
        z-index: 2;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    .about-img-accent {
        position: absolute;
        top: 20px;
        left: 20px;
        width: 100%;
        max-width: 500px;
        height: 100%;
        border: 2px solid var(--accent-purple);
        border-radius: 20px;
        z-index: 1;
    }

    .badge-about {
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
        padding: 6px 12px;
        border-radius: 4px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 1px;
        display: inline-block;
        margin-bottom: 20px;
    }

    .about-text-content h2 {
        font-family: var(--font-outfit);
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.25;
        margin-bottom: 20px;
        color: var(--text-color);
    }

    .about-text-content p {
        color: var(--text-muted);
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .about-vision-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-top: 30px;
        border-top: 1px solid var(--border-color);
        padding-top: 30px;
    }

    .vision-item h4 {
        font-family: var(--font-outfit);
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-color);
    }

    .vision-item p {
        font-size: 0.85rem;
        margin-bottom: 0;
    }

    .stats-section {
        background: linear-gradient(135deg, #4c1d95 0%, #7c3aed 100%);
        color: #ffffff;
        padding: 60px 8%;
        max-width: 1400px;
        margin: 0 auto;
        border-radius: 24px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 40px;
        text-align: center;
    }

    .stat-card h3 {
        font-family: var(--font-outfit);
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .stat-card p {
        font-family: var(--font-inter);
        font-size: 0.95rem;
        opacity: 0.85;
        font-weight: 500;
    }

    .values-section {
        padding: 100px 8% 120px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .section-title-wrapper {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title-wrapper h2 {
        font-family: var(--font-outfit);
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-color);
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .value-card {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 40px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(124, 58, 237, 0.05);
    }

    .value-icon {
        color: var(--accent-purple);
        background-color: var(--accent-purple-light);
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 24px;
    }

    .value-card h3 {
        font-family: var(--font-outfit);
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text-color);
    }

    .value-card p {
        font-family: var(--font-inter);
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    @media (max-width: 992px) {
        .about-intro-container {
            grid-template-columns: 1fr;
            gap: 40px;
        }

        .about-image-wrapper {
            margin-bottom: 20px;
        }

        .about-text-content h2 {
            font-size: 2rem;
        }
    }
</style>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
