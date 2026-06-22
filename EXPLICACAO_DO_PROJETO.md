# Como o ShopFree funciona por trás dos panos? (Guia Completo e Simplificado)

Se você nunca programou na vida, ler código pode parecer como ler outra língua. Este documento foi escrito especialmente para que **qualquer pessoa** consiga entender perfeitamente a estrutura, as decisões técnicas e o fluxo do ShopFree, capacitando-o a explicar o projeto com propriedade para terceiros.

---

## 🏬 A Analogia do Restaurante (Entendendo o padrão MVC)

O ShopFree utiliza uma arquitetura chamada **MVC (Model-View-Controller)**. Para entender o MVC, imagine que o nosso sistema é um **Restaurante de Alto Padrão**:

```
[ Cliente ] ──(Faz o Pedido)──> [ Garçom (Controller) ]
                                      │         ▲
                 (Pede ingrediente)   │         │ (Traz a comida pronta)
                                      ▼         │
[ Banco de Dados ] <──────────> [ Cozinha (Model) ]
```

### 1. O Garçom (Controller - Controlador)
* **Quem é no código**: Arquivos dentro da pasta `app/Controllers/` (ex: `CartController.php`, `ProductController.php`).
* **O que faz**: O Garçom é o único que fala diretamente com o cliente. Quando você clica em um botão na tela (como "Adicionar ao Carrinho"), você está chamando o Garçom. Ele recebe o seu pedido, vai até a cozinha para mandar preparar e depois traz o resultado de volta para você. O Garçom não cozinha (não mexe diretamente no banco de dados) e não fabrica os pratos (não cria o visual). Ele apenas coordena.

### 2. A Cozinha e a Despensa (Model - Modelo)
* **Quem é no código**: Arquivos na pasta `app/Models/` (ex: `Product.php`, `Order.php`, `User.php`).
* **O que faz**: É onde a mágica dos dados acontece. A cozinha sabe onde estão guardados os ingredientes (tabelas do banco de dados), como misturá-los (regras de negócio) e como embalar o pedido. Se o Garçom pergunta: *"Temos esse produto em estoque?"*, o Model vai até a despensa (Banco de Dados MySQL), checa e responde.

### 3. A Apresentação do Prato (View - Visualização)
* **Quem é no código**: Arquivos na pasta `app/Views/` (ex: `home.php`, `cart.php`, `payment.php`).
* **O que faz**: É a comida montada e decorada na mesa do cliente. É o HTML e o CSS que você vê no seu navegador. A View não sabe de onde a comida veio (não sabe como o banco de dados funciona), ela apenas exibe o que o Garçom (Controller) trouxe de forma bonita e organizada.

---

## 🐳 1. O que é o Docker? (A Caixa Organizadora)

Para rodar um site, precisamos de um servidor web, de um banco de dados e do PHP configurado. Se tentássemos instalar tudo isso diretamente no seu computador, daria muito trabalho e poderia falhar por incompatibilidade de sistema.

O **Docker** funciona como um **Container de Navio**. Nós criamos uma "caixa" fechada que contém tudo o que o ShopFree precisa para rodar (PHP, Apache, MySQL). Quando você roda o comando `docker compose up`, essa caixa abre e funciona de forma idêntica em qualquer computador do mundo (Windows, Mac ou Linux).

---

## 📍 2. A Recepção: O Front Controller (`index.php`)

Quando você entra no site do ShopFree, não importa qual página você clique (`/products`, `/cart`, `/dashboard`), todas as suas requisições passam obrigatoriamente por um único arquivo no início do projeto: o **[index.php](file:///c:/Users/isaque/Documents/isabela/shopfree/index.php)**.

Ele atua como a **Recepção do Restaurante**:
1. Você chega e diz: *"Quero ir para o Carrinho"*.
2. A recepção olha a sua solicitação.
3. Ela chama o Garçom correto (neste caso, o `CartController`) e diz: *"Leve este cliente para a mesa do carrinho"*.
4. Isso evita que o usuário acesse arquivos internos diretamente, tornando o sistema muito mais seguro e organizado.

---

## 📝 3. A Fita Adesiva da Memória: As Sessões (`$_SESSION`)

Por padrão, a internet "esquece" quem você é a cada clique. Para que você não precise digitar seu e-mail e senha toda vez que muda de página, ou para que o seu carrinho de compras não suma, o PHP usa as **Sessões** (`$_SESSION`).

Imagine que ao fazer login, o servidor cola um adesivo invisível com um código (ID da Sessão) nas suas costas. Toda vez que você clica em algo, o servidor lê esse adesivo e diz: *"Ah, esse é o Isaque, ele é um Cliente e tem um Monitor Gamer no carrinho dele"*.

---

## ⚙️ 4. O Passo a Passo Técnico de um Fluxo de Compra

Aqui está exatamente o que acontece por baixo dos panos quando um cliente compra na nossa loja:

### Passo 1: O Cliente clica em "Adicionar ao Carrinho"
1. O **`ProductController`** valida se o produto existe e se a quantidade pedida não supera o estoque da cozinha (banco de dados).
2. Se estiver tudo OK, o produto e a quantidade são salvos no "adesivo" da sessão (`$_SESSION['cart']`).
3. O cabeçalho do site (ícone de sacola) é atualizado, mostrando o badge e os produtos no dropdown.

### Passo 2: O Cliente vai para o Carrinho e escolhe o Endereço
1. O sistema carrega os endereços do cliente armazenados na tabela `address` do banco de dados através do modelo **`Address`**.
2. O endereço padrão do cliente já vem marcado automaticamente.

### Passo 3: O Simulador de Pagamento e Criação do Pedido
1. Ao clicar em "Finalizar", o cliente é enviado para o simulador (`/checkout/payment`).
2. Quando o cliente preenche os dados e confirma o pagamento (crédito, Pix ou boleto):
   * O **`CartController`** inicia uma **Transação de Banco de Dados** (isso garante que ou tudo dá certo ou nada é salvo, prevenindo erros se a conexão cair no meio).
   * O sistema insere um registro na tabela `orders` (gravando quem comprou, quanto custou, a forma de pagamento e o endereço de entrega).
   * Para cada item no carrinho, o sistema insere uma linha na tabela `order_item` (vinculando o produto ao pedido) e faz a **baixa de estoque** na tabela de produtos (subtraindo a quantidade comprada do estoque atual).
   * O carrinho da sessão (`$_SESSION['cart']`) é esvaziado.
   * O cliente é redirecionado para a tela de Sucesso.

---

## 💬 5. O Walkie-Talkie do Vendedor: AJAX / Fetch API

Quando o vendedor acessa a tela de "Pedidos Recebidos" (`/seller/orders`) e decide mudar o status de um pedido de **Pendente** para **Pago**, ele clica em uma caixinha de seleção.

Em sistemas antigos, a página inteira piscaria e recarregaria para salvar essa mudança. No ShopFree, usamos **AJAX (via Fetch API do JavaScript)**.
* **Como funciona**: O JavaScript funciona como um **Walkie-Talkie**. No momento em que o vendedor muda a opção, o JavaScript envia uma mensagem silenciosa em segundo plano para o **`DashboardController`**, que atualiza o status do pedido no banco de dados e responde: *"Feito!"*. A tela do vendedor não pisca, tornando a experiência rápida e profissional.
