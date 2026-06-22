<?php require_once __DIR__ . '/../layout/header.php'; ?>

<section class="checkout-section">
    <div class="container">
        <h1 class="checkout-title">Simulador de Pagamento</h1>
        
        <div class="checkout-grid">
            <div class="payment-options-column">
                <div class="checkout-card">
                    <h2>Selecione a Forma de Pagamento</h2>
                    
                    <div class="payment-tabs">
                        <button type="button" class="tab-btn active" onclick="switchPaymentTab('pix')">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
                            PIX
                        </button>
                        <button type="button" class="tab-btn" onclick="switchPaymentTab('card')">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            Cartão de Crédito
                        </button>
                        <button type="button" class="tab-btn" onclick="switchPaymentTab('boleto')">
                            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            Boleto Bancário
                        </button>
                    </div>

                    <form action="/checkout/place-order" method="POST" id="payment-form">
                        <input type="hidden" name="address_id" value="<?php echo $address['id']; ?>">
                        
                        <div class="payment-tab-content active" id="content-pix">
                            <div class="pix-simulation-box">
                                <div class="qr-code-placeholder">
                                    <div class="qr-pattern"></div>
                                </div>
                                <div class="pix-instructions">
                                    <p>1. Abra o app do seu banco e vá na opção Pix.</p>
                                    <p>2. Aponte a câmera para o QR Code acima ou cole o código Copia e Cola.</p>
                                    <div class="pix-code-wrapper">
                                        <input type="text" value="00020126580014br.gov.bcb.pix0136shopfree-pix-transfer-key-random123" id="pix-code" readonly>
                                        <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('pix-code').value); alert('Código copiado!')">Copiar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-tab-content" id="content-card">
                            <div class="card-form-grid">
                                <div class="form-group full-width">
                                    <label for="card-number">Número do Cartão (Simulado)</label>
                                    <input type="text" id="card-number" placeholder="4444 4444 4444 4444" maxlength="19">
                                </div>
                                <div class="form-group">
                                    <label for="card-expiry">Validade</label>
                                    <input type="text" id="card-expiry" placeholder="MM/AA" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label for="card-cvv">CVV</label>
                                    <input type="text" id="card-cvv" placeholder="123" maxlength="4">
                                </div>
                                <div class="form-group full-width">
                                    <label for="card-name">Nome Impresso no Cartão</label>
                                    <input type="text" id="card-name" placeholder="NOME COMPLETO">
                                </div>
                            </div>
                        </div>

                        <div class="payment-tab-content" id="content-boleto">
                            <div class="boleto-simulation-box">
                                <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                <h3>Boleto Bancário</h3>
                                <p>O boleto será gerado após a confirmação. O pagamento pode levar até 3 dias úteis para compensação.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn-confirm-payment">Confirmar Pagamento</button>
                    </form>
                </div>
            </div>

            <div class="checkout-summary-column">
                <div class="checkout-card">
                    <h2>Resumo do Pedido</h2>
                    <div class="checkout-items-summary">
                        <?php foreach ($cartItems as $item): ?>
                            <div class="summary-item-row">
                                <span class="item-qty-name"><?php echo $item['quantity']; ?>x <?php echo htmlspecialchars($item['name']); ?></span>
                                <span class="item-sub">R$ <?php echo number_format($item['price'] * $item['quantity'], 2, ',', '.'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-address-details">
                        <h3>Entrega em:</h3>
                        <p><?php echo htmlspecialchars($address['street'] . ', ' . $address['number']); ?></p>
                        <p><?php echo htmlspecialchars($address['neighborhood'] . ' - ' . $address['city'] . '/' . $address['state']); ?></p>
                        <p>CEP: <?php echo htmlspecialchars($address['postal_code']); ?></p>
                    </div>

                    <div class="summary-divider"></div>
                    
                    <div class="total-summary-row">
                        <span>Total Geral</span>
                        <span>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .checkout-section {
        padding: 50px 8% 100px 8%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .checkout-title {
        font-family: var(--font-outfit);
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 40px;
        letter-spacing: -0.5px;
        color: var(--text-color);
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 40px;
        align-items: start;
    }

    .checkout-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
    }

    .checkout-card h2 {
        font-family: var(--font-outfit);
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 24px;
        color: var(--text-color);
    }

    .payment-tabs {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
        margin-bottom: 30px;
    }

    .tab-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 14px;
        border: 1px solid var(--border-color);
        background: none;
        border-radius: 12px;
        cursor: pointer;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--text-muted);
        transition: all 0.2s ease;
    }

    .tab-btn svg {
        transition: stroke 0.2s ease;
    }

    .tab-btn.active {
        border-color: var(--accent-purple);
        background-color: var(--accent-purple-light);
        color: var(--accent-purple);
    }

    .payment-tab-content {
        display: none;
        margin-bottom: 30px;
    }

    .payment-tab-content.active {
        display: block;
    }

    .pix-simulation-box {
        display: flex;
        gap: 24px;
        align-items: center;
        background-color: #fcfcfc;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
    }

    .qr-code-placeholder {
        width: 140px;
        height: 140px;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        background-color: #ffffff;
        padding: 10px;
        flex-shrink: 0;
    }

    .qr-pattern {
        width: 100%;
        height: 100%;
        background-image: linear-gradient(45deg, #000 25%, transparent 25%), linear-gradient(-45deg, #000 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #000 75%), linear-gradient(-45deg, transparent 75%, #000 75%);
        background-size: 16px 16px;
        background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
        opacity: 0.85;
    }

    .pix-instructions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: left;
    }

    .pix-instructions p {
        font-family: var(--font-inter);
        font-size: 0.88rem;
        color: var(--text-color);
    }

    .pix-code-wrapper {
        display: flex;
        margin-top: 6px;
        border: 1px solid var(--border-color);
        border-radius: 30px;
        overflow: hidden;
        background-color: #ffffff;
        padding: 2px 2px 2px 14px;
    }

    .pix-code-wrapper input {
        border: none;
        outline: none;
        flex-grow: 1;
        font-family: var(--font-inter);
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .pix-code-wrapper button {
        background-color: var(--accent-purple);
        color: #ffffff;
        border: none;
        border-radius: 30px;
        padding: 8px 16px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.8rem;
        cursor: pointer;
    }

    .card-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        text-align: left;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group.full-width {
        grid-column: 1 / 3;
    }

    .form-group label {
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-color);
    }

    .form-group input {
        padding: 12px 16px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        font-family: var(--font-inter);
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-group input:focus {
        border-color: var(--accent-purple);
    }

    .boleto-simulation-box {
        background-color: #fcfcfc;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        color: var(--text-muted);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .boleto-simulation-box h3 {
        font-family: var(--font-outfit);
        font-size: 1.15rem;
        color: var(--text-color);
        font-weight: 700;
    }

    .boleto-simulation-box p {
        font-family: var(--font-inter);
        font-size: 0.9rem;
        max-width: 280px;
        line-height: 1.5;
    }

    .btn-confirm-payment {
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

    .btn-confirm-payment:hover {
        background-color: var(--accent-purple-hover);
        transform: translateY(-2px);
    }

    .checkout-summary-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .checkout-items-summary {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .summary-item-row {
        display: flex;
        justify-content: space-between;
        font-family: var(--font-inter);
        font-size: 0.9rem;
        color: var(--text-color);
    }

    .item-qty-name {
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 240px;
    }

    .summary-divider {
        height: 1px;
        background-color: var(--border-color);
        margin: 10px 0;
    }

    .summary-address-details {
        text-align: left;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .summary-address-details h3 {
        font-family: var(--font-outfit);
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--text-color);
    }

    .summary-address-details p {
        font-family: var(--font-inter);
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.4;
    }

    .total-summary-row {
        display: flex;
        justify-content: space-between;
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--text-color);
    }

    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
function switchPaymentTab(tabName) {
    document.querySelectorAll('.payment-tab-content').forEach(el => {
        el.classList.remove('active');
    });
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('active');
    });

    document.getElementById('content-' + tabName).classList.add('active');
    event.currentTarget.classList.add('active');
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
