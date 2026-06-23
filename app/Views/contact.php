<?php require_once __DIR__ . '/layout/header.php'; ?>

<section class="contact-banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h1>Contato</h1>
        <p><a href="/">Home</a> • <span>Contato</span></p>
    </div>
</section>

<section class="contact-cards-section">
    <div class="contact-card">
        <div class="card-icon">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
        </div>
        <h3>Nosso Endereço</h3>
        <p>Casa 45, Rua 409, Brasília<br>70000-000, Brasil</p>
    </div>

    <div class="contact-card">
        <div class="card-icon">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
        </div>
        <h3>Nossos E-mails</h3>
        <p><a href="mailto:contato@shopfree.com">contato@shopfree.com</a><br><a href="mailto:suporte@shopfree.com">suporte@shopfree.com</a></p>
    </div>

    <div class="contact-card">
        <div class="card-icon">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
        </div>
        <h3>Telefones de Contato</h3>
        <p><a href="tel:+556199999999">+55 (61) 99999-9999</a><br><a href="tel:+556133333333">+55 (61) 3333-3333</a></p>
    </div>
</section>

<section class="contact-form-section">
    <div class="contact-container">
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d122849.03058869153!2d-47.97864452144365!3d-15.794228711425175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935a3d18e1ef6b97%3A0x6b8d78096f272a81!2sBras%C3%ADlia%2C%20DF!5e0!3m2!1spt-BR!2sbr!4v1680000000000!5m2!1spt-BR!2sbr" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="form-container">
            <form action="#" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" placeholder="Nome Completo *" required>
                    </div>
                    <div class="form-group">
                        <input type="email" placeholder="Endereço de E-mail *" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <input type="text" placeholder="Número de Telefone">
                    </div>
                    <div class="form-group">
                        <input type="date" placeholder="dd/mm/aaaa">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <select required>
                            <option value="" disabled selected>Assunto *</option>
                            <option value="duvida">Dúvidas gerais</option>
                            <option value="suporte">Suporte Técnico</option>
                            <option value="comercial">Parcerias e Vendas</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select required>
                            <option value="" disabled selected>Como nos conheceu? *</option>
                            <option value="google">Pesquisa no Google</option>
                            <option value="redes-sociais">Redes Sociais</option>
                            <option value="amigo">Indicação de amigo</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full-width">
                    <textarea placeholder="Sua Mensagem..." rows="6" required></textarea>
                </div>

                <button type="submit" class="submit-btn">ENVIAR MENSAGEM &gt;</button>
            </form>
        </div>
    </div>
</section>

<!-- Seção de Sucesso (Simulação) -->
<section id="contact-success" class="contact-success-section" style="display: none;">
    <div class="success-card">
        <div class="success-icon">
            <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <h2>Contato Enviado!</h2>
        <p>Sua mensagem foi enviada com sucesso. Retornaremos o seu contato em breve!</p>
        <div class="countdown-text">Você será redirecionado para a tela inicial em <span id="countdown">5</span> segundos...</div>
        <a href="/" class="home-btn">Voltar para a Página Inicial</a>
    </div>
</section>

<style>
    /* Estilos da Seção de Sucesso */
    .contact-success-section {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
        padding: 80px 8%;
        background: linear-gradient(135deg, #f5f3ff 0%, #ede9fe 100%);
    }

    .success-card {
        background-color: #ffffff;
        border: 1px solid var(--border-color, #e2e8f0);
        border-radius: 24px;
        padding: 50px 40px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(76, 29, 149, 0.05);
        max-width: 500px;
        width: 100%;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .success-icon {
        color: #10b981;
        background-color: #ecfdf5;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
        animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s both;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }

    .success-card h2 {
        font-family: var(--font-outfit, sans-serif);
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 16px;
        color: #1e1b4b;
    }

    .success-card p {
        font-family: var(--font-inter, sans-serif);
        font-size: 1rem;
        color: var(--text-muted, #64748b);
        line-height: 1.6;
        margin-bottom: 24px;
    }

    .countdown-text {
        font-family: var(--font-inter, sans-serif);
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 30px;
    }

    .countdown-text span {
        font-weight: 600;
        color: #7c3aed;
    }

    .home-btn {
        display: inline-block;
        background-color: #7c3aed;
        color: #ffffff;
        text-decoration: none;
        border-radius: 8px;
        padding: 14px 28px;
        font-family: var(--font-outfit, sans-serif);
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
    }

    .home-btn:hover {
        background-color: #6d28d9;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(124, 58, 237, 0.3);
    }

    .contact-banner {
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

    .contact-cards-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        padding: 80px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .contact-card {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 40px 30px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(124, 58, 237, 0.05);
    }

    .card-icon {
        color: var(--accent-purple);
        background-color: var(--accent-purple-light);
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
    }

    .contact-card h3 {
        font-family: var(--font-outfit);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 12px;
        color: var(--text-color);
    }

    .contact-card p {
        font-family: var(--font-inter);
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
    }

    .contact-card a {
        color: var(--text-muted);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .contact-card a:hover {
        color: var(--accent-purple);
    }

    .contact-form-section {
        padding: 0 8% 100px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .contact-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
    }

    .map-container {
        height: 550px;
        background-color: #eee;
    }

    .form-container {
        background-color: #4c1d95;
        padding: 50px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group input, 
    .form-group select, 
    .form-group textarea {
        background-color: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        padding: 16px 20px;
        color: #ffffff;
        font-family: var(--font-inter);
        font-size: 0.9rem;
        outline: none;
        transition: all 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .form-group input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        cursor: pointer;
    }

    .form-group select option {
        background-color: #4c1d95;
        color: #ffffff;
    }

    .form-group input:focus, 
    .form-group select:focus, 
    .form-group textarea:focus {
        border-color: #ddd6fe;
        background-color: rgba(255, 255, 255, 0.12);
        box-shadow: 0 0 0 3px rgba(221, 214, 254, 0.15);
    }

    .form-group::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-group input::placeholder, 
    .form-group textarea::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .full-width {
        margin-bottom: 24px;
    }

    .submit-btn {
        background-color: #ffffff;
        color: #4c1d95;
        border: none;
        border-radius: 8px;
        padding: 18px 36px;
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        align-self: flex-start;
        letter-spacing: 0.5px;
    }

    .submit-btn:hover {
        background-color: #ddd6fe;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .contact-container {
            grid-template-columns: 1fr;
        }

        .map-container {
            height: 350px;
        }

        .form-container {
            padding: 30px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.form-container form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Ocultar seções da página de contato
            document.querySelector('.contact-banner').style.display = 'none';
            document.querySelector('.contact-cards-section').style.display = 'none';
            document.querySelector('.contact-form-section').style.display = 'none';
            
            // Mostrar tela de sucesso
            const successSection = document.getElementById('contact-success');
            successSection.style.display = 'flex';
            
            // Iniciar contagem regressiva para redirecionamento
            let secondsLeft = 5;
            const countdownEl = document.getElementById('countdown');
            
            const timer = setInterval(function() {
                secondsLeft--;
                countdownEl.textContent = secondsLeft;
                
                if (secondsLeft <= 0) {
                    clearInterval(timer);
                    window.location.href = '/';
                }
            }, 1000);
        });
    }
});
</script>

<?php require_once __DIR__ . '/layout/footer.php'; ?>
