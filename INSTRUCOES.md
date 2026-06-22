# Instruções de Uso e Funcionamento do Sistema - SHOPFREE

Esta documentação descreve de forma detalhada o funcionamento da plataforma ShopFree, seus papéis de usuário, fluxos de compra, painéis e detalhes técnicos de arquitetura.

---

## 👥 1. Papéis de Usuário (Roles)

O sistema possui controle de acesso baseado em papéis (RBAC). Ao fazer login, a barra superior exibe o nome do usuário e o seu papel correspondente:

### A. Cliente (Usuário)
* **Objetivo**: Navegar, gerenciar endereços, adicionar produtos ao carrinho, realizar compras fictícias e acompanhar seus pedidos.
* **Cadastro**: Pode se cadastrar diretamente na tela de registro padrão (`/register`).
* **Credencial de Teste**: `cliente@shopfree.com` / `cliente123` (se semeado) ou pode criar uma conta nova.

### B. Vendedor (Fornecedor)
* **Objetivo**: Gerenciar seus próprios produtos (adicionar, editar, excluir) e processar os pedidos recebidos.
* **Cadastro**: Pode se cadastrar na tela de cadastro de vendedor (`/seller`).
* **Credencial de Teste**: `vendedor@shopfree.com` / `vendedor123` (cadastrado por padrão).

### C. Administrador (Admin)
* **Objetivo**: Controlar o cadastro de categorias globais e gerenciar contas administrativas.
* **Credencial Padrão**: `admin@shopfree.com` / `admin123`.

---

## 🛒 2. Fluxos Principais e Como o Sistema Funciona

### A. Navegação de Produtos e Filtros
* **Caminho**: Página Inicial (`/`) ou Todos os Produtos (`/products`).
* **Como Funciona**: 
  * O catálogo exibe todos os produtos ativos cadastrados.
  * O usuário pode filtrar os produtos digitando no campo de busca (pesquisa por nome/descrição) ou clicando nas categorias.
  * O filtro de categoria atualiza dinamicamente a URL e recarrega os itens correspondentes.

### B. Página de Detalhes do Produto
* **Caminho**: `/product?id={ID}`
* **Como Funciona**:
  * Mostra a imagem, título, preço, descrição detalhada e estoque do produto.
  * **Se for Cliente**: É exibida uma seção para selecionar a quantidade desejada (limitada ao estoque disponível) e o botão **"Adicionar ao Carrinho"**.
  * **Se for Vendedor Proprietário**: É exibido um botão especial **"Editar Produto"**, que redireciona o vendedor diretamente para a tela de edição do seu produto no painel de controle.

### C. Sistema de Carrinho de Compras
* **Caminho**: `/cart`
* **Como Funciona**:
  * O carrinho é salvo na sessão do usuário (`$_SESSION['cart']`).
  * O ícone de carrinho no cabeçalho exibe um indicador com o número de itens e, ao passar o mouse ou clicar, abre um dropdown visual mostrando os itens e um botão de atalho rápido para ir ao carrinho.
  * Na página do carrinho, o cliente pode aumentar ou diminuir as quantidades de cada item (validando com o estoque restante), remover itens e ver o resumo financeiro (subtotal e total).

### D. Cadastro e Seleção de Endereço
* **Caminho**: `/dashboard/addresses`
* **Como Funciona**:
  * Antes de prosseguir para o pagamento, na tela do carrinho, o cliente precisa selecionar o endereço de entrega.
  * Se não houver nenhum endereço cadastrado, o sistema exibe um aviso claro com um link para o cadastro.
  * O cliente pode gerenciar seus endereços (cadastrar novos, editar existentes, excluir ou definir um como "Padrão").
  * O endereço marcado como "Padrão" vem selecionado de forma automática no carrinho.

### E. Simulador de Pagamento & Geração de Pedido
* **Caminho**: `/checkout/payment`
* **Como Funciona**:
  * Após escolher o endereço no carrinho e clicar em **"Finalizar Compra"**, o cliente é levado ao Simulador de Pagamento.
  * A tela mostra o resumo do pedido (produtos, quantidades e total) e o endereço selecionado.
  * O cliente escolhe entre três formas de pagamento simuladas:
    1. **Cartão de Crédito** (com campos visuais de simulação de cartão).
    2. **Pix** (com QR Code fictício e chave copia-e-cola).
    3. **Boleto Bancário**.
  * Ao clicar em **"Confirmar Pagamento Simulado"**, o sistema executa a criação do pedido (`orders` e `order_item`), decrementa as quantidades correspondentes do estoque dos produtos e limpa o carrinho da sessão. Em seguida, redireciona o cliente para a tela de sucesso (`/checkout/success`).

### F. Gestão de Pedidos e Alteração de Status
* **Caminho**: `/dashboard/orders` (Cliente) ou `/seller/orders` (Vendedor).
* **Como Funciona**:
  * **Painel do Cliente**: Permite ao cliente visualizar o histórico de compras, a data do pedido, os produtos comprados, o endereço de entrega utilizado e o status atualizado do pedido.
  * **Painel do Vendedor**: Lista os pedidos que contêm produtos pertencentes àquele vendedor específico. O vendedor possui um menu dropdown dinâmico em cada pedido para alterar o status entre: **Pendente**, **Pago**, **Enviado**, **Entregue** e **Cancelado**. Ao alterar, a atualização ocorre de forma assíncrona (via AJAX/Fetch API) sem precisar recarregar a tela.

---

## 🏗️ 3. Detalhes de Arquitetura e Banco de Dados

* **Conexão PDO**: A classe `App\Models\Database` implementa a conexão única via PDO utilizando as variáveis do `config.php`.
* **Migrações Automáticas**: Os construtores dos modelos verificam e criam/alteram as tabelas dinamicamente caso necessário (ex: remoção da unicidade de `cart_id` na tabela `orders` para suportar múltiplas compras).
* **Estrutura de Tabelas Principais**:
  * `user` / `role`: Armazena dados de autenticação e papéis.
  * `product` / `category`: Contém as informações dos produtos e categorias associadas.
  * `orders` / `order_item`: Registra os cabeçalhos dos pedidos (dados do comprador, total, status, endereço) e a listagem detalhada de produtos vendidos.
