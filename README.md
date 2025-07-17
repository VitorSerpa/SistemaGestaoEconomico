# 📊 Sistema de Gestão Econômico

Um sistema completo de gestão com hierarquia entre **Grupos Econômicos**, **Bandeiras**, **Unidades** e **Colaboradores**, com autenticação e relatórios de movimentações.

---

## 🚀 Tecnologias utilizadas

- PHP (Laravel 12)
- MySQL
- Laravel Sail (Docker)
- HTML/CSS
- JavaScript
- Blade
---
## ✅ Funcionalidades
- CRUD completo de Grupos Econômicos
- CRUD completo de Bandeiras
- CRUD completo de Unidades
- CRUD completo de Colaboradores
- Registro de movimentações no sistema
- Filtro de pesquisa nos campos
- Frontend moderno e intuitivo
  
## 🖥️ Pré-requisitos

Certifique-se de que os seguintes softwares estão instalados:

### ✅ Linux

- [Docker](https://docs.docker.com/engine/install/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/download/)

### ✅ Windows

- [WSL 2 + Ubuntu](https://learn.microsoft.com/pt-br/windows/wsl/install)
- [Docker Desktop (com WSL2 backend)](https://www.docker.com/products/docker-desktop/)
- [Git for Windows](https://git-scm.com/)
- [Composer](https://getcomposer.org/download/)

---

## ⚙️ Passo a passo de instalação

### 1. Clone o repositório

```bash
# Clonar o repositório e entrar na pasta
git clone https://github.com/VitorSerpa/SistemaGestaoEconomico.git
cd SistemaGestaoEconomico
cd SistemaGestaoEconomico
```

### 2. Copiar o arquivo de ambiente
```bash
cp .env.example .env
```

### 3. Instalar dependências PHP via Composer
```bash
composer install
```

### 4. Subir os containers do Docker em background
```bash
./vendor/bin/sail up -d
```

### 5. Instalar o Sail e escolher o MySQL (durante o processo, selecione MySQL e confirme)
```bash
./vendor/bin/sail artisan sail:install
```

### 6. Gerar a chave da aplicação Laravel
```bash
./vendor/bin/sail artisan key:generate
```

### 7. Executar as migrations para criar tabelas no banco
```bash
./vendor/bin/sail artisan migrate
```

### 8. Acesse:
```bash
http://localhost:8080/view/grupoEconomico
```

