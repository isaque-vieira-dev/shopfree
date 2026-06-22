# ShopFree - E-commerce Platform

Plataforma de e-commerce moderna com arquitetura limpa em MVC desenvolvida em PHP e hospedada localmente via Docker.

---

## 🚀 Tecnologias Utilizadas

Este projeto foi construído utilizando as seguintes tecnologias e conceitos:

- **Backend**: PHP 8.2 (com suporte nativo ao **Composer**).
- **Banco de Dados**: MySQL 8.0 (com script de migração automática idempotente e transações).
- **Arquitetura**: Padrão **MVC (Model-View-Controller)** simples, com *Front Controller* e *Autoloader* nativo (PSR-4).
- **Ambiente de Desenvolvimento**: Docker & Docker Compose.
- **Frontend**: HTML5, Vanilla CSS3 (com design premium, responsivo, paleta de cores roxa/purple e animações suaves), tipografia estilizada com as fontes *Outfit* e *Inter* do Google Fonts, além de ilustrações dinâmicas em formato SVG vetorial.
- **Interações**: JavaScript moderno (Fetch API para requisições assíncronas AJAX, animações e atualizações em tempo real).

---

## ✨ Novas Funcionalidades Implementadas

A plataforma foi expandida com recursos completos de um e-commerce moderno:

1. **Catálogo Geral & Filtros Avançados (`/products`)**:
   * Visualização de todos os produtos com suporte a busca dinâmica por texto e filtros por categorias interativas.
2. **Página de Detalhes do Produto (`/product`)**:
   * Exibição de imagem, preço, descrição, controle de estoque dinâmico e botões de ação contextuais (se cliente, adicionar ao carrinho; se vendedor dono do produto, atalho de edição rápida).
3. **Carrinho de Compras (`/cart`)**:
   * Dropdown interativo de visualização rápida no header.
   * Controle de quantidade com verificação de estoque e remoção ágil de itens.
4. **Gestão de Endereços (`/dashboard/addresses`)**:
   * Cadastro, edição, exclusão e definição de endereço de entrega padrão.
   * Seleção facilitada do endereço na tela do carrinho.
5. **Simulador de Checkout & Pagamentos (`/checkout/payment`)**:
   * Tela de fechamento com suporte simulado para Cartão de Crédito, Pix (com QR Code fictício) e Boleto.
   * Transação segura no banco de dados com abatimento de estoque automático e tela de sucesso (`/checkout/success`).
6. **Histórico de Pedidos e Alteração de Status (`/dashboard/orders`)**:
   * Visualização de compras e status atualizado em tempo real para clientes.
   * Painel de gerenciamento de vendas com alteração de status via AJAX para vendedores.

---

## 🛠️ Como Executar o Projeto

### Pré-requisitos
Você precisará ter instalado em sua máquina:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### Passo a Passo

1. **Subir os Containers**:
   Abra o seu terminal na raiz do projeto e execute o comando abaixo para construir as imagens e iniciar os serviços:
   ```bash
   docker compose up -d --build
   ```

2. **Acessar a Aplicação**:
   Abra seu navegador e acesse:
   👉 **[http://localhost:8080](http://localhost:8080)**

3. **Popular o Banco de Dados (Seeder)**:
   Para carregar categorias de teste, produtos e as imagens correspondentes nos carrosséis, execute:
   ```bash
   docker compose exec web php database/productsSeeder.php
   ```

4. **Para parar o ambiente**:
   ```bash
   docker compose down
   ```

---

## 🔐 Contas e Credenciais de Teste

Para navegar pelos diferentes perfis do sistema, utilize os seguintes usuários de teste:

* **Administrador**:
  * **E-mail**: `admin@shopfree.com` | **Senha**: `admin123`
* **Vendedor (Fornecedor)**:
  * **E-mail**: `vendedor@shopfree.com` | **Senha**: `vendedor123`
* **Cliente**:
  * **E-mail**: `cliente@shopfree.com` | **Senha**: `cliente123` *(ou crie um novo cadastro na hora)*

---

## 📂 Estrutura de Diretórios Atualizada

```
shopfree/
├── app/
│   ├── Controllers/    # Controladores (Home, Auth, Product, Cart, Address, Dashboard)
│   ├── Core/           # Roteador básico e infraestrutura
│   ├── Models/         # Modelos de negócios (Database, User, Product, Category, Address, Order)
│   └── Views/          # Telas estruturadas (Home, Product, Cart, Checkout, Auth, Dashboard, Layouts)
├── database/           # Scripts SQL de estrutura e seeder de produtos
├── config.php          # Configurações de ambiente e credenciais
├── INSTRUCOES.md       # Manual detalhado de funcionamento do sistema
├── docker-compose.yml  # Configuração dos containers do Docker
└── index.php           # Front Controller e autoloader nativo
```