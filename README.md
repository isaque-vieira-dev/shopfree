# ShopFree - E-commerce Platform

Plataforma de e-commerce moderna com arquitetura limpa em MVC desenvolvida em PHP e hospedada localmente via Docker.

## 🚀 Tecnologias Utilizadas

Este projeto foi construído utilizando as seguintes tecnologias e conceitos:

- **Backend**: PHP 8.2 (com suporte nativo ao **Composer**).
- **Banco de Dados**: MySQL 8.0 (com script de migração automática idempotente).
- **Arquitetura**: Padrão **MVC (Model-View-Controller)** simples, com *Front Controller* e *Autoloader* nativo (PSR-4).
- **Ambiente de Desenvolvimento**: Docker & Docker Compose.
- **Frontend**: HTML5, Vanilla CSS3 (com design premium, responsivo e paleta de cores roxa/purple), tipografia estilizada com as fontes *Outfit* e *Inter* do Google Fonts, além de ilustrações dinâmicas em formato SVG vetorial.

---

## 🛠️ Como Executar o Projeto

### Pré-requisitos
Você precisará ter instalado em sua máquina:
- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### Passo a Passo

1. **Subir os Containers**:
   Abra o seu terminal na raiz do projeto e execute o comando abaixo para construir as imagens e iniciar os serviços em segundo plano:
   ```bash
   docker compose up -d --build
   ```

2. **Acessar a Aplicação**:
   Abra seu navegador e digite a URL:
   👉 **[http://localhost:8080](http://localhost:8080)**

3. **Popular o Banco de Dados (Opcional - Seeder)**:
   Para popular o banco com as categorias (*Eletrônicos*, *Roupas & Acessórios*, *Casa & Decoração*) e os produtos de teste nos carrosséis da tela inicial, execute:
   - **Via Docker (Recomendado)**:
     ```bash
     docker compose exec web php database/productsSeeder.php
     ```
   - **Localmente**:
     ```bash
     php database/productsSeeder.php
     ```

4. **Verificar Banco de Dados**:
   Ao iniciar o container do banco pela primeira vez, o Docker executará automaticamente as instruções contidas no arquivo `database/initial-database.sql`, que cria as tabelas necessárias (`role`, `user`, `address`, `category`, `product`, `cart`, `cart_item`, `orders` e `order_item`) e insere os níveis de acesso padrão (`admin`, `client`, `seller`), além de agora também carregar os registros iniciais configurados no arquivo SQL.

5. **Para parar o ambiente**:
   ```bash
   docker compose down
   ```

---

## 📦 Utilizando o Composer no Docker

O Composer está instalado dentro do container do PHP (`web`). Para rodar comandos do Composer sem precisar instalar a ferramenta localmente, execute:

```bash
docker compose exec web composer <comando>
```

*Exemplos de uso:*
```bash
# Para instalar dependências:
docker compose exec web composer install

# Para adicionar um pacote (ex: vlucas/phpdotenv):
docker compose exec web composer require vlucas/phpdotenv
```

---

## 🔐 Sistema de Autenticação e Níveis de Acesso

O ShopFree possui um sistema completo de autenticação e controle de níveis de acesso (RBAC - Role-Based Access Control). O tipo do usuário conectado (Administrador, Vendedor ou Usuário comum) é exibido diretamente no cabeçalho do site, abaixo de seu nome.

### Níveis de Acesso Disponíveis:
- **Administrador (admin)**: Usuário com permissões de gestão do sistema.
- **Vendedor (seller)**: Usuários que podem anunciar seus próprios produtos na plataforma.
- **Usuário (client)**: Clientes comuns que podem navegar e efetuar compras.

### Funcionalidades do Sistema de Autenticação:
- **Login / Logout**: Autenticação com sessão persistente.
- **Cadastro Geral**: Cadastro de clientes normais (`client`).
- **Cadastro de Vendedores**: Cadastro dedicado a vendedores (`seller`), disponível no link "Anuncie seus produtos".
- **Recuperação de Senha**: Fluxo completo de simulação de alteração de senha ("Esqueci minha senha") via token com tempo de expiração de 1 hora.

---

## 👤 Credenciais do Administrador Padrão

Para testar o painel administrativo ou as funções restritas, você pode fazer login utilizando o usuário administrador inicial criado automaticamente:

- **E-mail**: `admin@shopfree.com`
- **Senha**: `admin123`

---

## 🗄️ Conexão ao Banco de Dados (MySQL)

Se desejar conectar ao banco de dados usando ferramentas externas (como TablePlus, DBeaver ou VS Code Database Extension), utilize as seguintes credenciais:

- **Host**: `localhost` (ou `db` de dentro da rede do Docker)
- **Porta**: `3306`
- **Banco de Dados**: `shopfree`
- **Usuário**: `shopfree_user`
- **Senha**: `shopfree_password`
- **Senha Root**: `root_password`

---

## 📂 Estrutura de Diretórios

```
shopfree/
├── app/
│   ├── Controllers/    # Controladores (Home, Contato, Sobre Nós, Autenticação)
│   ├── Core/           # Núcleo do sistema (Roteador simples)
│   ├── Models/         # Modelos e Conexão (Database via PDO, User)
│   └── Views/          # Telas (Home, Contato, Sobre Nós, Telas de Auth e layouts)
├── database/           # Scripts SQL de inicialização do banco
├── .htaccess           # Regras de reescrita para suporte a URLs amigáveis
├── config.php          # Configurações globais e credenciais do banco
├── Dockerfile          # Configuração da imagem PHP 8.2 + Apache + Composer
├── docker-compose.yml  # Definição e integração dos containers Docker
└── index.php           # Front Controller (Entrada de rotas e Autoloader)
```