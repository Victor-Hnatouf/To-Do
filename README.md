# 📋 To-Do — Aplicação de Gestão de Tarefas

Aplicação web para gestão de tarefas pessoais, desenvolvida com **Laravel** e **Tailwind CSS**.

---

## 🛠️ Tecnologias Utilizadas

| Tecnologia      | Versão     | Descrição                        |
|-----------------|------------|----------------------------------|
| **Laravel**     | ^13.x      | Framework PHP (Backend)          |
| **Tailwind CSS**| ^3.x       | Framework CSS utilitário         |
| **Alpine.js**   | ^3.x       | Framework JS para interatividade |
| **SQLite**      | —          | Base de dados (dev local)        |
| **Vite**        | ^8.x       | Bundler de assets                |
| **Laravel Breeze** | *       | Autenticação                     |
| **PHPUnit**     | ^12.x      | Testes automatizados             |

---

## 📦 Requisitos do Sistema

- **PHP** >= 8.3
- **Composer** >= 2.x
- **Node.js** >= 18.x
- **NPM** >= 9.x
- **Laravel Herd** (recomendado para dev local) ou outro servidor PHP

---

## 🚀 Instalação e Setup

### 1. Clonar o Repositório

```bash
git clone <url-do-repositorio>
cd To-Do
```

### 2. Instalar Dependências

```bash
composer install
npm install
```

### 3. Configurar o Ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Base de Dados

O projeto utiliza **SQLite** por defeito. O ficheiro `database/database.sqlite` já está incluído.

```bash
php artisan migrate
```

Para popular com dados de teste:
```bash
php artisan db:seed
```

**Utilizador de teste:**
- Email: `test@example.com`
- Password: `password`

### 5. Compilar Assets

```bash
# Desenvolvimento (com hot reload)
npm run dev

# Produção
npm run build
```

### 6. Iniciar o Servidor

Com **Laravel Herd**, o projeto é automaticamente servido em `http://to-do.test`.

Sem Herd:
```bash
php artisan serve
```

---

## 📁 Estrutura do Projeto

```
To-Do/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TaskController.php      # CRUD de tarefas
│   │   │   └── ProfileController.php   # Gestão de perfil
│   │   └── Requests/
│   │       ├── StoreTaskRequest.php     # Validação de criação
│   │       └── UpdateTaskRequest.php    # Validação de edição
│   └── Models/
│       ├── Task.php                     # Model de tarefa
│       └── User.php                     # Model de utilizador
├── database/
│   ├── factories/
│   │   └── TaskFactory.php             # Factory para testes
│   ├── migrations/
│   │   └── create_tasks_table.php      # Schema da tabela tasks
│   └── seeders/
│       └── DatabaseSeeder.php          # Seeder com dados de teste
├── resources/views/
│   ├── dashboard.blade.php             # Dashboard principal
│   ├── welcome.blade.php               # Landing page
│   ├── layouts/                        # Layouts (app, nav, guest)
│   └── components/                     # Componentes Blade
├── routes/
│   └── web.php                         # Rotas da aplicação
└── tests/Feature/
    └── TaskControllerTest.php          # Testes do TaskController
```

---

## ✨ Funcionalidades

### Gestão de Tarefas
- ✅ **Criar** tarefas com título, descrição, prazo e prioridade
- ✅ **Editar** tarefas existentes (todos os campos)
- ✅ **Excluir** tarefas individualmente
- ✅ **Marcar** tarefas como concluídas/pendentes (toggle)
- ✅ **Ver detalhes** de cada tarefa num modal

### Filtros e Ordenação
- ✅ Filtrar por **estado** (pendentes, concluídas, atrasadas, todas)
- ✅ Filtrar por **prioridade** (baixa, média, alta)
- ✅ **Pesquisar** por título ou descrição
- ✅ **Ordenar** por prazo, prioridade, título ou data de criação

### Dashboard
- ✅ **Estatísticas** (total, pendentes, concluídas, atrasadas)
- ✅ **Paginação** da lista de tarefas

### Autenticação
- ✅ Registo, login e logout
- ✅ Gestão de perfil
- ✅ Tarefas isoladas por utilizador

### Interface
- ✅ Design responsivo (mobile, tablet, desktop)
- ✅ Suporte a **dark mode**
- ✅ Landing page personalizada
- ✅ Validação client-side e server-side

---

## 🧪 Testes

Executar todos os testes:

```bash
php artisan test
```

Os testes cobrem:
- Acesso não autenticado (redirect para login)
- CRUD de tarefas (criar, ler, atualizar, excluir)
- Isolamento por utilizador (não aceder a tarefas de outros)
- Toggle de estado (pendente ↔ concluída)
- Validação de dados (campos obrigatórios, formatos)
- Filtros e ordenação

---

## 📝 Licença

Este projeto é desenvolvido no âmbito de um estágio académico.
