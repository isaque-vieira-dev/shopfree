<?php require_once __DIR__ . '/../layout/header.php'; ?>

<section class="success-section">
    <div class="container">
        <div class="success-card">
            <div class="success-icon-wrapper">
                <svg viewBox="0 0 24 24" width="40" height="40" stroke="currentColor" stroke-width="2.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            
            <h1>Pedido Realizado com Sucesso!</h1>
            <p class="success-sub">Seu pagamento foi aprovado e o pedido já está sendo processado.</p>
            
            <div class="order-details-box">
                <div class="details-row">
                    <span>Número do Pedido:</span>
                    <strong>#<?php echo (int)$order['id']; ?></strong>
                </div>
                <div class="details-row">
                    <span>Status do Pagamento:</span>
                    <span class="status-badge paid">Aprovado (Simulador)</span>
                </div>
                <div class="details-row">
                    <span>Total do Pedido:</span>
                    <strong>R$ <?php echo number_format($order['total'], 2, ',', '.'); ?></strong>
                </div>
                <div class="details-row address-row">
                    <span>Endereço de Entrega:</span>
                    <div>
                        <p><?php echo htmlspecialchars($order['street'] . ', ' . $order['number']); ?></p>
                        <p><?php echo htmlspecialchars($order['neighborhood'] . ' - ' . $order['city'] . '/' . $order['state']); ?></p>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="/dashboard/orders" class="btn btn-primary">Meus Pedidos</a>
                <a href="/products" class="btn btn-outline">Continuar Comprando</a>
            </div>
        </div>
    </div>
</section>

<style>
    .success-section {
        padding: 80px 8% 120px 8%;
        max-width: 800px;
        margin: 0 auto;
    }

    .success-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 50px 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .success-icon-wrapper {
        width: 80px;
        height: 80px;
        background-color: #d1fae5;
        color: #059669;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.1);
    }

    .success-card h1 {
        font-family: var(--font-outfit);
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-color);
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .success-sub {
        font-family: var(--font-inter);
        font-size: 1.05rem;
        color: var(--text-muted);
        margin-bottom: 40px;
        max-width: 440px;
        line-height: 1.5;
    }

    .order-details-box {
        width: 100%;
        max-width: 500px;
        background-color: #fcfcfc;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 40px;
        text-align: left;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .details-row {
        display: flex;
        justify-content: space-between;
        font-family: var(--font-inter);
        font-size: 0.95rem;
        color: var(--text-color);
    }

    .details-row span {
        color: var(--text-muted);
    }

    .status-badge.paid {
        background-color: #f0fdf4;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 2px 10px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .address-row {
        flex-direction: column;
        gap: 8px;
        border-top: 1px solid var(--border-color);
        padding-top: 16px;
    }

    .address-row div {
        font-size: 0.9rem;
        color: var(--text-color);
        line-height: 1.4;
    }

    .action-buttons {
        display: flex;
        gap: 16px;
        width: 100%;
        max-width: 500px;
    }

    .btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 14px 24px;
        border-radius: 30px;
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 0.98rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-primary {
        background-color: var(--accent-purple);
        color: #ffffff;
        border: none;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.15);
    }

    .btn-primary:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-1px);
    }

    .btn-outline {
        background-color: #ffffff;
        color: var(--text-color);
        border: 1px solid var(--border-color);
    }

    .btn-outline:hover {
        background-color: #f9f9f9;
        border-color: var(--text-color);
        transform: translateY(-1px);
    }

    @media (max-width: 576px) {
        .action-buttons {
            flex-direction: column;
        }
    }
</style>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
