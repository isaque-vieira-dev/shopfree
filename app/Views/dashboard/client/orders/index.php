<?php require_once __DIR__ . '/../../layout_header.php'; ?>

<div class="orders-container">
    <h2 class="section-title">Meus Pedidos</h2>
    
    <?php if (empty($orders)): ?>
        <div class="orders-empty-state">
            <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            <h3>Nenhum pedido realizado</h3>
            <p>Você ainda não fez nenhuma compra em nossa loja.</p>
            <a href="/products" class="btn-shop">Ver Produtos</a>
        </div>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div class="order-info-meta">
                            <div>
                                <span class="meta-label">Pedido</span>
                                <strong class="meta-value">#<?php echo $order['id']; ?></strong>
                            </div>
                            <div>
                                <span class="meta-label">Data</span>
                                <span class="meta-value"><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></span>
                            </div>
                            <div>
                                <span class="meta-label">Total</span>
                                <span class="meta-value price">R$ <?php echo number_format($order['total'], 2, ',', '.'); ?></span>
                            </div>
                        </div>
                        <div class="order-status-badge">
                            <?php 
                            $statusMap = [
                                'PENDING'   => ['label' => 'Pendente', 'class' => 'pending'],
                                'PAID'      => ['label' => 'Pago', 'class' => 'paid'],
                                'SHIPPED'   => ['label' => 'Enviado', 'class' => 'shipped'],
                                'DELIVERED' => ['label' => 'Entregue', 'class' => 'delivered'],
                                'CANCELLED' => ['label' => 'Cancelado', 'class' => 'cancelled']
                            ];
                            $statusInfo = $statusMap[$order['status']] ?? ['label' => $order['status'], 'class' => ''];
                            ?>
                            <span class="status-pill <?php echo $statusInfo['class']; ?>">
                                <?php echo $statusInfo['label']; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="order-body">
                        <div class="order-items-title">Itens do Pedido</div>
                        <div class="order-items-grid">
                            <?php foreach ($order['items'] as $item): ?>
                                <div class="order-item-row">
                                    <div class="item-img">
                                        <?php if (!empty($item['image_path'])): ?>
                                            <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <?php else: ?>
                                            <div class="item-no-img">N/A</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="item-info">
                                        <span class="item-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                        <span class="item-qty-price"><?php echo $item['quantity']; ?>x R$ <?php echo number_format($item['unit_price'], 2, ',', '.'); ?></span>
                                    </div>
                                    <div class="item-subtotal">
                                        R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if ($order['street']): ?>
                            <div class="order-address-box">
                                <strong>Endereço de Entrega:</strong>
                                <span><?php echo htmlspecialchars($order['street'] . ', ' . $order['number'] . ' (' . $order['city'] . '/' . $order['state'] . ')'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .orders-container {
        text-align: left;
    }

    .section-title {
        font-family: var(--font-outfit);
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 30px;
        color: var(--text-color);
    }

    .orders-empty-state {
        background-color: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 60px 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        color: var(--text-muted);
    }

    .orders-empty-state h3 {
        font-family: var(--font-outfit);
        font-size: 1.3rem;
        color: var(--text-color);
        font-weight: 700;
    }

    .btn-shop {
        background-color: var(--accent-purple);
        color: #ffffff;
        text-decoration: none;
        border-radius: 30px;
        padding: 12px 24px;
        font-family: var(--font-outfit);
        font-weight: 600;
        font-size: 0.9rem;
        transition: background-color 0.25s ease;
    }

    .btn-shop:hover {
        background-color: var(--accent-purple-hover);
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .order-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.01);
    }

    .order-header {
        background-color: #fafafa;
        border-bottom: 1px solid var(--border-color);
        padding: 20px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .order-info-meta {
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
    }

    .meta-label {
        display: block;
        font-size: 0.72rem;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .meta-value {
        font-family: var(--font-outfit);
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .meta-value.price {
        color: var(--accent-purple);
    }

    .status-pill {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        font-family: var(--font-outfit);
    }

    .status-pill.pending { background-color: #fef3c7; color: #d97706; }
    .status-pill.paid { background-color: #d1fae5; color: #059669; }
    .status-pill.shipped { background-color: #dbeafe; color: #2563eb; }
    .status-pill.delivered { background-color: #f0fdf4; color: #166534; }
    .status-pill.cancelled { background-color: #fee2e2; color: #dc2626; }

    .order-body {
        padding: 24px;
    }

    .order-items-title {
        font-family: var(--font-outfit);
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(0,0,0,0.02);
        padding-bottom: 8px;
    }

    .order-items-grid {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 20px;
    }

    .order-item-row {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .item-img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        background-color: #f5f5f5;
        overflow: hidden;
        border: 1px solid var(--border-color);
        flex-shrink: 0;
    }

    .item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        color: var(--text-muted);
    }

    .item-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .item-name {
        font-family: var(--font-outfit);
        font-size: 0.92rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .item-qty-price {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .item-subtotal {
        font-family: var(--font-outfit);
        font-weight: 700;
        font-size: 0.95rem;
        color: var(--text-color);
    }

    .order-address-box {
        background-color: #fafafa;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.85rem;
        display: flex;
        gap: 8px;
        border: 1px solid var(--border-color);
    }

    .order-address-box strong {
        color: var(--text-color);
    }

    .order-address-box span {
        color: var(--text-muted);
    }
</style>

<?php require_once __DIR__ . '/../../layout_footer.php'; ?>
