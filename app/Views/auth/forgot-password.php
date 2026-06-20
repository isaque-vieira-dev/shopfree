<?php require_once __DIR__ . '/../layout/header.php'; ?>

<main class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2 class="auth-title">Recuperar Senha</h2>
            <p class="auth-subtitle">Informe seu e-mail para receber as instruções de recuperação</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                <span><?php echo htmlspecialchars($success); ?></span>
            </div>
        <?php endif; ?>

        <?php if (!empty($resetLink)): ?>
            <div class="alert alert-info">
                <div class="info-content">
                    <h4 style="font-family: var(--font-outfit); font-weight: 700; margin-bottom: 6px; color: var(--accent-purple);">[Simulador de E-mail]</h4>
                    <p style="margin-bottom: 12px; font-size: 0.85rem; color: var(--text-color);">Como você está em um ambiente de desenvolvimento local, clique no botão abaixo para simular a abertura do e-mail de redefinição de senha:</p>
                    <a href="<?php echo htmlspecialchars($resetLink); ?>" class="btn btn-solid" style="padding: 10px 20px; font-size: 0.8rem; border-radius: 6px; text-decoration: none;">REDEFINIR MINHA SENHA</a>
                </div>
            </div>
        <?php endif; ?>

        <form action="/forgot-password" method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">E-mail Cadastrado</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required autocomplete="email">
                </div>
            </div>

            <button type="submit" class="btn btn-solid btn-block">ENVIAR INSTRUÇÕES</button>
        </form>

        <div class="auth-footer">
            <p>Voltar para o <a href="/login">Login</a></p>
        </div>
    </div>
</main>

<style>
    .auth-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 200px);
        padding: 40px 24px;
        background-color: var(--bg-base);
    }

    .auth-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 40px;
        width: 100%;
        max-width: 450px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
        animation: fadeIn 0.5s ease-out;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .auth-title {
        font-family: var(--font-outfit);
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 8px;
    }

    .auth-subtitle {
        font-family: var(--font-inter);
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .auth-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    label {
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        width: 18px;
        height: 18px;
        color: var(--text-muted);
        pointer-events: none;
        transition: color 0.25s ease;
    }

    .input-wrapper input {
        width: 100%;
        padding: 14px 14px 14px 44px;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        font-family: var(--font-inter);
        font-size: 0.9rem;
        outline: none;
        background-color: #fafafa;
        color: var(--text-color);
        transition: all 0.25s ease;
    }

    .input-wrapper input:focus {
        border-color: var(--accent-purple);
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.08);
    }

    .input-wrapper input:focus + .input-icon,
    .input-wrapper:focus-within .input-icon {
        color: var(--accent-purple);
    }

    .btn-block {
        width: 100%;
        text-align: center;
        padding: 16px;
        margin-top: 10px;
        cursor: pointer;
    }

    .auth-footer {
        text-align: center;
        margin-top: 24px;
        font-family: var(--font-inter);
        font-size: 0.9rem;
        color: var(--text-muted);
    }

    .auth-footer a {
        color: var(--accent-purple);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .auth-footer a:hover {
        color: var(--accent-purple-hover);
        text-decoration: underline;
    }

    /* Alerts */
    .alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 8px;
        font-family: var(--font-inter);
        font-size: 0.85rem;
        margin-bottom: 20px;
        line-height: 1.4;
    }

    .alert-error {
        background-color: #fef2f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
    }

    .alert-success {
        background-color: #f0fdf4;
        color: #22c55e;
        border: 1px solid #dcfce7;
    }

    .alert-info {
        background-color: var(--accent-purple-light);
        color: var(--text-color);
        border: 1px solid rgba(124, 58, 237, 0.15);
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 30px 20px;
        }
    }
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
