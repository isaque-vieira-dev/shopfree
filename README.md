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

3. **Verificar Banco de Dados**:
   Ao iniciar o container do banco pela primeira vez, o Docker executará automaticamente as instruções contidas no arquivo `database/initial-database.sql`, que cria as tabelas necessárias (`role`, `user`, `address`, `category`, `product`, `cart`, `cart_item`, `orders` e `order_item`) e insere os níveis de acesso padrão (`admin`, `client`, `seller`).

4. **Para parar o ambiente**:
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
│   ├── Controllers/    # Controladores (Home, Contato, Sobre Nós)
│   ├── Core/           # Núcleo do sistema (Roteador simples)
│   ├── Models/         # Modelos e Conexão (Database via PDO)
│   └── Views/          # Telas (Home, Contato, Sobre Nós e layouts compartilhados)
├── database/           # Scripts SQL de inicialização do banco
├── .htaccess           # Regras de reescrita para suporte a URLs amigáveis
├── config.php          # Configurações globais e credenciais do banco
├── Dockerfile          # Configuração da imagem PHP 8.2 + Apache + Composer
├── docker-compose.yml  # Definição e integração dos containers Docker
└── index.php           # Front Controller (Entrada de rotas e Autoloader)
```