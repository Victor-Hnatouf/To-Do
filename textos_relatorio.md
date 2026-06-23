# Relatório de Estágio - Textos de Suporte (Projetos Biblioteca e Chat)

## Capítulo III - Atividades Desenvolvidas

### 3.1 – PROJETO BIBLIOTECA

**3.1.1 – Introdução ao Projeto**

> O Projeto Biblioteca foi criado com o objetivo de digitalizar e facilitar a gestão de um catálogo de livros. A aplicação não é só informativa — permite que os utilizadores requisitem livros, deixem avaliações e comprem exemplares. Para desenvolvê-la, escolhi o Laravel porque é uma framework PHP bem organizada e segura. Usei também o Livewire, que me permitiu criar páginas que se atualizam automaticamente sem precisar de recarregar o site, tornando tudo mais fluido para o utilizador.

---

**3.1.2 – Configuração Inicial do Projeto**

> O primeiro passo foi preparar o ambiente de trabalho. As configurações importantes, como a ligação à base de dados e as chaves de APIs externas, ficam no ficheiro `.env`. Assim, esses dados não aparecem no código e ficam protegidos. Usei também o `composer.json` para gerir todas as ferramentas e pacotes de terceiros que o projeto precisa.
>
> 📸 **Imagem 1A: Ficheiro de Variáveis de Ambiente (`.env`) [Aprox. Linhas 10 a 15]**
> _Texto de acompanhamento (Imagem 1A):_ Aqui vemos a configuração do ficheiro `.env`, onde defini as credenciais de acesso à base de dados MySQL, como o nome da base de dados, o utilizador e o servidor. _(Nota: ocultar as passwords antes de colocar no relatório.)_
> **Legenda:** Ficheiro `.env` — Variáveis de ambiente com as credenciais da base de dados MySQL
>
> 📸 **Imagem 1B: Dependências do Projeto (`composer.json`) [Aprox. Linhas 10 a 20]**
> _Texto de acompanhamento (Imagem 1B):_ O `composer.json` lista os pacotes instalados no projeto, como o Livewire (para componentes reativos), o Stripe (para pagamentos) e o Laravel Excel (para exportações). Qualquer pessoa que clone o projeto instala tudo com um único comando.
> **Legenda:** `composer.json` — Lista de pacotes e dependências do projeto Laravel

---

**3.1.3 – Sistema de Autenticação**

> Para garantir que só pessoas registadas acedem ao sistema, usei o Laravel Jetstream. Este pacote fornece o registo, o login e a proteção de páginas de forma automática. Depois do login, o sistema verifica se o utilizador é Administrador ou um Cidadão normal e redireciona-o para a página certa.
>
> 📸 **Imagem 2A: Proteção de Rotas (`routes/web.php`) [Linhas 7 a 11]**
> _Texto de acompanhamento (Imagem 2A):_ Neste bloco de código, agrupa todas as páginas protegidas com o `middleware('auth:sanctum')` e `'verified'`. Isto significa que, se alguém tentar aceder a estas páginas sem ter feito login, o sistema bloqueia e redireciona para o ecrã de login.
> **Legenda:** `web.php` — Grupo de rotas protegidas pelo middleware de autenticação
>
> 📸 **Imagem 2B: Redirecionamento após Login (`routes/web.php`) [Linhas 12 a 17]**
> _Texto de acompanhamento (Imagem 2B):_ Na rota `/dashboard`, há uma verificação simples: se o utilizador logado for Administrador (`isAdmin()`), vai para a página de gestão; se for um Cidadão, vai para o catálogo de livros. Assim cada pessoa vai diretamente para a área certa.
> **Legenda:** `web.php` — Lógica de redirecionamento pós-login com base no papel do utilizador

---

**3.1.4 – Autenticação de Dois Fatores (2FA)**

> Para tornar o sistema mais seguro, ativei a opção de login em dois passos (2FA). Mesmo que alguém descubra a password de um utilizador, não consegue entrar sem o código gerado no telemóvel (por exemplo, com o Google Authenticator).
>
> 📸 **Imagem 3A: Ativar o 2FA (`config/fortify.php`) [Aprox. Linhas 65 a 72]**
> _Texto de acompanhamento (Imagem 3A):_ No ficheiro de configuração do Fortify, ativei a linha `Features::twoFactorAuthentication()`. Isto diz ao sistema que deve disponibilizar as páginas de configuração e verificação do segundo fator.
> **Legenda:** `fortify.php` — Ativação da funcionalidade de Autenticação em Dois Fatores
>
> 📸 **Imagem 3B: Interface de Ativação do 2FA [Browser]**
> _Texto de acompanhamento (Imagem 3B):_ Ecrã do perfil do utilizador onde aparece o botão para ativar o 2FA, o QRCode para sincronizar com a aplicação do telemóvel e os códigos de emergência para recuperação.
> **Legenda:** Página de perfil — Ecrã de configuração do segundo fator de autenticação com QRCode

---

**3.1.5 – Personalização da Interface**

> O design visual foi feito com o Tailwind CSS, que me permite escrever as classes de estilo diretamente no HTML dos ficheiros Blade, sem criar muitos ficheiros CSS separados. Para ir além do Tailwind padrão, usei também o tema DaisyUI, que já tem componentes prontos como botões, tabelas e modais. As fontes escolhidas (Cinzel e Cormorant Garamond) são importadas do Google Fonts.
>
> 📸 **Imagem 4A: Configuração de Estilos (`tailwind.config.js`) [Linhas 1 a 15]**
> _Texto de acompanhamento (Imagem 4A):_ O ficheiro `tailwind.config.js` define quais os ficheiros que o Tailwind deve analisar para gerar o CSS final e quais extensões (como o DaisyUI) estão ativas no projeto.
> **Legenda:** `tailwind.config.js` — Configuração do Tailwind CSS com o plugin DaisyUI ativado
>
> 📸 **Imagem 4B: Estrutura HTML Base (`resources/views/layouts/app.blade.php`) [Linhas 14 a 37]**
> _Texto de acompanhamento (Imagem 4B):_ No layout principal do site, as classes do DaisyUI como `bg-base-100` e `bg-base-200` são usadas para definir as cores de fundo. O `head` do ficheiro também inclui a importação das fontes "Cinzel" e "Cormorant Garamond" via Google Fonts, que dão uma identidade visual elegante ao projeto.
> **Legenda:** `app.blade.php` — Layout base do site com classes DaisyUI e fontes Google Fonts

---

**3.1.6 – Estrutura da Base de Dados**

> A base de dados tem várias tabelas que se ligam entre si (base de dados relacional). No Laravel, em vez de escrever o SQL à mão, uso ficheiros chamados Migrations para criar as tabelas. Para cada tabela, existe também um Model (classe PHP) que facilita o acesso e as pesquisas de dados. Para popular a base de dados com dados de teste, criei um Seeder.
>
> 📸 **Imagem 5A: Migration da Tabela de Livros (`database/migrations/2026_04_27_104257_create_livros_table.php`) [Linhas 11 a 20]**
> _Texto de acompanhamento (Imagem 5A):_ Este ficheiro cria a tabela `livros` com colunas como `isbn`, `nome`, `bibliografia`, `preco` e `imagem_capa`. A linha `foreignId('editora_id')` cria uma ligação com a tabela `editoras`, garantindo que cada livro está associado a uma editora.
> **Legenda:** Migration `create_livros_table` — Definição da estrutura e relações da tabela de livros
>
> 📸 **Imagem 5B: Relacionamentos no Modelo do Livro (`app/Models/Livro.php`) [Linhas 41 a 51]**
> _Texto de acompanhamento (Imagem 5B):_ No Model do Livro, defini os relacionamentos com outras tabelas: `editora()` com `belongsTo` (cada livro pertence a uma editora), `autores()` com `belongsToMany` (um livro pode ter vários autores) e `requisicoes()` com `hasMany` (um livro pode ter muitos empréstimos). O Laravel usa estes métodos para fazer as pesquisas relacionais de forma simples.
> **Legenda:** `Livro.php` — Modelo com os relacionamentos definidos para Editora, Autores e Requisições
>
> 📸 **Imagem 5C: Seeder de Dados de Teste (`database/seeders/DatabaseSeeder.php`) [Linhas 19 a 93]**
> _Texto de acompanhamento (Imagem 5C):_ O Seeder cria automaticamente utilizadores (Admin e Cidadão), editoras (Almedina, Porto Editora), autores (Saramago, Pessoa, Camões) e livros de exemplo como "Ensaio sobre a Cegueira". Isto permite ter um sistema funcional logo após a instalação, sem introduzir dados à mão.
> **Legenda:** `DatabaseSeeder.php` — Criação automática de dados de exemplo para testes

---

**3.1.7 – Gestão de Livros**

> O painel de administração tem um módulo completo para adicionar, editar e apagar livros. Como usei Livewire, quando o administrador guarda um livro, a lista da página atualiza imediatamente sem recarregar. O processo passa pelo backend (PHP, validação) e pelo frontend (formulário HTML).
>
> 📸 **Imagem 6A: Função de Guardar Livro (`app/Livewire/LivrosComponent.php`) [Linhas 217 a 246]**
> _Texto de acompanhamento (Imagem 6A):_ A função `store()` começa por verificar se o utilizador é Admin (`abort_unless isAdmin`). Depois valida os campos obrigatórios: o `isbn` e o `nome` são obrigatórios, a `editora_id` tem de existir na base de dados e a imagem tem de ser do tipo imagem. Só depois guarda o livro com `Livro::updateOrCreate`. Quando é um livro novo, também envia notificações a quem estava à espera desse livro.
> **Legenda:** `LivrosComponent.php` — Função `store()` com validação e gravação do livro na base de dados
>
> 📸 **Imagem 6B: Pesquisa e Ordenação no Render (`app/Livewire/LivrosComponent.php`) [Linhas 46 a 66]**
> _Texto de acompanhamento (Imagem 6B):_ A função `render()` carrega todos os livros e, se houver algo escrito na caixa de pesquisa (`$this->search`), filtra os resultados por nome ou ISBN. Depois ordena conforme o campo escolhido e cria paginação de 10 em 10 livros por página.
> **Legenda:** `LivrosComponent.php` — Função `render()` com filtro de pesquisa, ordenação e paginação

---

**3.1.8 – Gestão de Autores**

> Os Autores têm uma área de gestão própria, em vez de serem apenas texto no livro. Isto garante que não há duplicados por erros de escrita. Criei também uma proteção: se o administrador tentar apagar um autor que tem livros registados, o sistema bloqueia a ação.
>
> 📸 **Imagem 7: Lógica de Eliminação de Autor (`app/Livewire/AutoresComponent.php`) [Aprox. Linhas 40 a 55]**
> _Texto de acompanhamento (Imagem 7):_ Antes de apagar um autor, o código verifica se existem livros associados a ele. Se existirem, mostra um aviso e cancela a operação; se não existirem, apaga o autor com segurança.
> **Legenda:** `AutoresComponent.php` — Verificação de livros associados antes de apagar um autor

---

**3.1.9 – Gestão de Editoras**

> A gestão de Editoras funciona da mesma forma que a de Autores, com o mesmo padrão de formulário em modal. As editoras podem ser criadas, editadas e apagadas pelo administrador, desde que não tenham livros associados.
>
> 📸 **Imagem 8: Interface de Gestão de Editoras [Browser]**
> _Texto de acompanhamento (Imagem 8):_ Print do ecrã do painel de gestão a mostrar a lista de editoras e os botões de ação (editar e apagar), desenhados com as classes do TailwindCSS/DaisyUI.
> **Legenda:** Painel de Administração — Ecrã de listagem e gestão de editoras

---

**3.1.10 – Sistema de Pesquisa, Ordenação e Filtros**

> Na página de Catálogo, o leitor pode pesquisar livros enquanto escreve. O Livewire reage a cada letra escrita e atualiza a lista na hora, sem clicar em nenhum botão. Também é possível ordenar os livros por nome ou ISBN, clicando no cabeçalho da coluna.
>
> 📸 **Imagem 9A: Filtro e Ordenação no Servidor (`app/Livewire/LivrosComponent.php`) [Linhas 46 a 66]**
> _Texto de acompanhamento (Imagem 9A):_ O mesmo bloco `render()` que lista os livros faz também o filtro. O método `filter()` com `stripos` procura o texto escrito dentro do nome ou ISBN do livro sem diferenciar maiúsculas de minúsculas. A ordenação é feita com `sortBy` ou `sortByDesc` consoante o campo escolhido.
> **Legenda:** `LivrosComponent.php` — Lógica de filtro por texto e ordenação dinâmica dos resultados
>
> 📸 **Imagem 9B: Caixa de Pesquisa no HTML [`resources/views/livewire/livros-component.blade.php`, Aprox. Linhas 10 a 20]**
> _Texto de acompanhamento (Imagem 9B):_ No HTML do catálogo, a caixa de pesquisa tem a diretiva `wire:model.live="search"`. O `.live` faz com que a cada letra digitada, o Livewire contacta o servidor e devolve a lista filtrada imediatamente.
> **Legenda:** `livros-component.blade.php` — Campo de pesquisa com `wire:model.live` para filtragem em tempo real

---

**3.1.11 – Exportação de Dados para Excel**

> O administrador pode descarregar a lista completa de livros em formato Excel (`.xlsx`) com um clique. Isto facilita a gestão fora do sistema.
>
> 📸 **Imagem 10: Função de Exportação (`app/Livewire/LivrosComponent.php`) [Linhas 285 a 288]**
> _Texto de acompanhamento (Imagem 10):_ A função `exportExcel()` usa o pacote Laravel Excel (`Maatwebsite`) para pegar na classe `LivrosExport` e devolver um ficheiro `.xlsx` para download. É uma função simples mas muito útil para a gestão administrativa.
> **Legenda:** `LivrosComponent.php` — Função `exportExcel()` que gera e descarrega o ficheiro `.xlsx`

---

**3.1.12 – Encriptação dos Dados**

> Para proteger a privacidade, alguns dados sensíveis são encriptados automaticamente na base de dados. O campo `password` do utilizador é sempre transformado num código irreversível. Além disso, o Model do Livro também encripta campos como o `isbn`, `nome`, `bibliografia` e `preco`.
>
> 📸 **Imagem 11A: Encriptação da Password (`app/Models/User.php`) [Linhas 37 a 43]**
> _Texto de acompanhamento (Imagem 11A):_ No método `casts()` do modelo `User`, a propriedade `'password' => 'hashed'` diz ao Laravel para transformar a password automaticamente num hash (código irreversível) antes de a guardar no MySQL.
> **Legenda:** `User.php` — Cast `hashed` que encripta automaticamente a password do utilizador
>
> 📸 **Imagem 11B: Encriptação de Campos Sensíveis (`app/Models/Livro.php`) [Linhas 22 a 28]**
> _Texto de acompanhamento (Imagem 11B):_ No modelo `Livro`, o array `$casts` usa `'encrypted'` em vários campos como `isbn`, `nome` e `preco`. Isto significa que estes dados ficam encriptados na base de dados e só são legíveis dentro da aplicação.
> **Legenda:** `Livro.php` — Array `$casts` com campos `isbn`, `nome` e `preco` encriptados na base de dados

---

**3.1.13 – Sistema de Permissões**

> Criei dois tipos de utilizadores: Admin e Cidadão. As páginas de gestão só podem ser acedidas por Administradores. Esta verificação acontece em dois pontos: no Model do utilizador (para saber quem é Admin) e nas rotas (para bloquear acessos não autorizados).
>
> 📸 **Imagem 12A: Funções de Verificação de Papel (`app/Models/User.php`) [Linhas 44 a 53]**
> _Texto de acompanhamento (Imagem 12A):_ As funções `isAdmin()` e `isCidadao()` verificam o campo `role` do utilizador. Se o role for `'admin'`, a função `isAdmin()` retorna `true`; se for `'cidadao'`, a `isCidadao()` retorna `true`. Estas funções são usadas em todo o projeto para controlar o acesso.
> **Legenda:** `User.php` — Funções `isAdmin()` e `isCidadao()` para verificar o papel do utilizador
>
> 📸 **Imagem 12B: Rotas Exclusivas de Admin (`routes/web.php`) [Linhas 27 a 32]**
> _Texto de acompanhamento (Imagem 12B):_ As páginas de gestão (painel principal, utilizadores, encomendas e logs) estão dentro de um grupo com `middleware(['admin'])`. Se um Cidadão tentar aceder a qualquer um destes URLs diretamente no browser, o sistema bloqueia com um erro 403.
> **Legenda:** `web.php` — Rotas do painel de gestão protegidas pelo middleware exclusivo de Admin

---

**3.1.14 – Sistema de Requisições**

> A funcionalidade principal da Biblioteca é o empréstimo de livros. O utilizador escolhe um livro e clica num botão para o requisitar. O sistema regista então o empréstimo, guardando quem requisitou, quando e qual a data prevista de devolução (5 dias depois). Também envia um email de confirmação.
>
> 📸 **Imagem 13A: Início da Função de Requisição (`app/Livewire/RequisicoesComponent.php`) [Linhas 98 a 111]**
> _Texto de acompanhamento (Imagem 13A):_ A função `criarRequisicao()` começa por pegar no utilizador logado e validar que o `livro_id` existe. Depois, verifica se o utilizador já tem 3 requisições ativas ao mesmo tempo. Se tiver, mostra um erro e para; se não tiver, continua para criar o empréstimo.
> **Legenda:** `RequisicoesComponent.php` — Início de `criarRequisicao()` com validação e verificação de limite
>
> 📸 **Imagem 13B: Criação do Registo de Empréstimo (`app/Livewire/RequisicoesComponent.php`) [Linhas 112 a 142]**
> _Texto de acompanhamento (Imagem 13B):_ Dentro de uma transação (`DB::transaction`), o código verifica se o livro já está emprestado a alguém. Se não estiver, cria o registo da requisição com o ID do livro, o ID do cidadão, o nome, o email, a data de requisição e a data prevista de entrega (calculada automaticamente para 5 dias depois). No final, envia emails de confirmação ao cidadão e aos administradores.
> **Legenda:** `RequisicoesComponent.php` — Transação que cria o registo do empréstimo e envia emails de confirmação

---

**3.1.15 – Validação da Disponibilidade dos Livros**

> Antes de aceitar um empréstimo, o sistema verifica se o livro não está já emprestado a outra pessoa. Esta verificação é feita dentro de uma transação segura para evitar conflitos.
>
> 📸 **Imagem 14: Verificação de Disponibilidade (`app/Livewire/RequisicoesComponent.php`) [Linhas 113 a 121]**
> _Texto de acompanhamento (Imagem 14):_ O código usa `lockForUpdate()` para bloquear o livro enquanto faz a verificação, impedindo que dois utilizadores o requisitem ao mesmo tempo. Se já existir uma requisição ativa (`whereNull('entregue_em')`), lança um erro e cancela a operação.
> **Legenda:** `RequisicoesComponent.php` — Verificação com `lockForUpdate()` para garantir que o livro está disponível

---

**3.1.16 – Limitação de Requisições por Utilizador**

> Para não monopolizar o acervo, cada utilizador só pode ter até 3 livros emprestados ao mesmo tempo.
>
> 📸 **Imagem 15: Limite de Requisições Ativas (`app/Livewire/RequisicoesComponent.php`) [Linhas 104 a 111]**
> _Texto de acompanhamento (Imagem 15):_ O código conta quantas requisições o utilizador tem com `entregue_em` a nulo (ou seja, ainda não devolvidas). Se o resultado for 3 ou mais, o código adiciona um erro com a mensagem "Atingiste o limite de 3 livros requisitados em simultâneo." e cancela a operação.
> **Legenda:** `RequisicoesComponent.php` — Condicional que bloqueia requisições quando o utilizador já tem 3 ativos

---

**3.1.17 – Histórico de Requisições**

> Cada utilizador pode ver o seu próprio historial de requisições. O sistema garante que cada pessoa só vê as suas. Os administradores podem ver todas.
>
> 📸 **Imagem 16: Lógica de Visualização por Papel (`app/Livewire/RequisicoesComponent.php`) [Linhas 34 a 53]**
> _Texto de acompanhamento (Imagem 16):_ Na função `render()`, o código verifica se o utilizador é Admin. Se for, mostra todas as requisições; se não for, adiciona um filtro `where('cidadao_id', $user->id)` para mostrar apenas as suas. Assim a mesma página serve para ambos os papéis.
> **Legenda:** `RequisicoesComponent.php` — Função `render()` com filtragem de requisições por papel do utilizador

---

**3.1.18 – Gestão de Devoluções**

> Quando o cidadão entrega o livro, há um processo em dois passos: o cidadão indica no sistema que já entregou, e depois o Administrador confirma e regista o estado do exemplar. Em vez de apagar o registo, é guardada a data de devolução, mantendo o historial completo.
>
> 📸 **Imagem 17A: O Cidadão Indica a Devolução (`app/Livewire/RequisicoesComponent.php`) [Linhas 145 a 163]**
> _Texto de acompanhamento (Imagem 17A):_ A função `marcarEntregaNaBiblioteca()` é chamada pelo cidadão. Ela guarda a data atual no campo `cidadao_entregou_em` e envia automaticamente um email a todos os Admins a avisar que o livro foi entregue e precisa de ser verificado.
> **Legenda:** `RequisicoesComponent.php` — Função `marcarEntregaNaBiblioteca()` que regista a entrega do cidadão e notifica os Admins
>
> 📸 **Imagem 17B: O Admin Confirma e Regista o Estado (`app/Livewire/RequisicoesComponent.php`) [Linhas 165 a 188]**
> _Texto de acompanhamento (Imagem 17B):_ A função `registarRelatorioDevolucao()` é só para Admins. Ela atualiza a requisição com a data final de entrega (`entregue_em`), o estado do exemplar (`condicao_na_devolucao`) e o ID do Admin que confirmou (`confirmado_por_admin_id`). Também calcula os dias que o livro esteve emprestado.
> **Legenda:** `RequisicoesComponent.php` — Função `registarRelatorioDevolucao()` que fecha o ciclo de empréstimo

---

**3.1.19 – Sistema de Emails Automáticos**

> O sistema envia emails automáticos em várias situações: quando uma requisição é criada, quando um livro é entregue e quando uma review é submetida. Para isso, usei as classes `Mailable` do Laravel.
>
> 📸 **Imagem 18: Email de Confirmação de Requisição (`app/Mail/RequisicaoConfirmacao.php`) [Todo o ficheiro]**
> _Texto de acompanhamento (Imagem 18):_ A classe `RequisicaoConfirmacao` é um exemplo de um email automático. Recebe os dados da requisição no construtor e os injeta num template HTML que é enviado tanto ao cidadão como aos administradores no momento em que o empréstimo é criado.
> **Legenda:** `RequisicaoConfirmacao.php` — Classe Mailable que envia o email de confirmação do empréstimo

---

**3.1.20 – Lembretes Automáticos de Devolução**

> O sistema pode verificar automaticamente, todos os dias, se há requisições com prazo ultrapassado e enviar emails de lembrete. Isto é feito com o sistema de tarefas agendadas do Laravel.
>
> 📸 **Imagem 19: Tarefa Agendada (`routes/console.php`) [Todo o ficheiro]**
> _Texto de acompanhamento (Imagem 19):_ Neste ficheiro defini o agendamento do comando de lembrete. O `->daily()` diz ao Laravel para o executar automaticamente uma vez por dia, sem qualquer intervenção manual.
> **Legenda:** `console.php` — Agendamento diário automático do comando de lembretes de devolução

---

**3.1.22 – Integração com a Google Books API**

> Para facilitar o preenchimento da informação dos livros, criei uma integração com a Google Books. O administrador pesquisa por título ou ISBN no painel e o sistema vai buscar os dados (nome, sinopse, capa) diretamente à Google.
>
> 📸 **Imagem 20A: Abrir o Painel de Importação (`app/Livewire/LivrosComponent.php`) [Linhas 68 a 78]**
> _Texto de acompanhamento (Imagem 20A):_ A função `openGoogleImport()` só funciona para Admins. Ela inicializa o painel lateral de pesquisa da Google Books, limpando os resultados anteriores e verificando se a chave da API está configurada.
> **Legenda:** `Livros` — Função `openGoogleImport()` que inicializa o painel de pesquisa da Google Books
>
> 📸 **Imagem 20B: Pesquisa e Importação da Google Books (`app/Livewire/LivrosComponent.php`) [Linhas 84 a 143]**
> _Texto de acompanhamento (Imagem 20B):_ A função `searchGoogleBooks()` chama o serviço `GoogleBooksService` com o texto pesquisado. Os resultados ficam guardados em `$googleResults` e aparecem numa lista. Quando o admin clica num resultado, a função `importGoogleVolume()` importa automaticamente o livro para a base de dados da Biblioteca.
> **Legenda:** `LivrosComponent.php` — Funções `searchGoogleBooks()` e `importGoogleVolume()` para pesquisar e importar livros

---

**3.1.23 – Sistema de Reviews**

> Os cidadãos podem comentar e dar uma classificação (de 1 a 5 estrelas) aos livros que já requisitaram. Só é possível fazer uma review depois de ter devolvido o livro, e cada utilizador só pode fazer uma review por livro.
>
> 📸 **Imagem 21A: Verificação antes de Abrir o Formulário (`app/Livewire/RequisicoesComponent.php`) [Linhas 218 a 242]**
> _Texto de acompanhamento (Imagem 21A):_ A função `openReviewModal()` verifica dois pontos antes de abrir o formulário: se o utilizador já fez uma review para aquele livro e se o utilizador já devolveu o livro (`whereNotNull('entregue_em')`). Se alguma destas condições falhar, mostra uma mensagem de aviso.
> **Legenda:** `RequisicoesComponent.php` — Função `openReviewModal()` com verificação de elegibilidade para escrever review
>
> 📸 **Imagem 21B: Guardar a Review (`app/Livewire/RequisicoesComponent.php`) [Linhas 251 a 274]**
> _Texto de acompanhamento (Imagem 21B):_ A função `submeterReview()` valida que o comentário tem entre 10 e 1000 caracteres e que a classificação é um número de 1 a 5. Depois guarda a review com o estado `ESTADO_SUSPENSO` (aguarda aprovação do admin) e envia um email a todos os administradores a avisar que há uma nova review para moderar.
> **Legenda:** `RequisicoesComponent.php` — Função `submeterReview()` que guarda a avaliação em estado suspenso e notifica Admins

---

**3.1.24 – Moderação de Reviews**

> Quando um cidadão submete uma review, ela fica em estado "suspenso" até o Administrador a aprovar ou rejeitar. Isto garante que o conteúdo publicado no site é controlado.
>
> 📸 **Imagem 22: Painel de Moderação [Browser]**
> _Texto de acompanhamento (Imagem 22):_ Print do ecrã de moderação, onde o Administrador consegue ver a lista de reviews pendentes e aprovar ou rejeitar cada uma. Ao aprovar, fica visível no catálogo; ao rejeitar, é removida e é enviado um email de notificação ao cidadão.
> **Legenda:** Painel de Administração — Ecrã de moderação de reviews com opções de aprovação e rejeição

---

**3.1.25 – Notificações Associadas às Reviews**

> Quando um cidadão submete uma review, o sistema envia automaticamente um email a todos os administradores a avisar. Quando o admin a aprova ou rejeita, o cidadão também recebe um email.
>
> 📸 **Imagem 23: Email de Review Submetida (`app/Mail/ReviewSubmetida.php`) [Todo o ficheiro]**
> _Texto de acompanhamento (Imagem 23):_ A classe `ReviewSubmetida` é enviada aos admins logo após o cidadão submeter a review. Inclui os dados do livro e do cidadão para que o admin possa moderar rapidamente.
> **Legenda:** `ReviewSubmetida.php` — Classe Mailable de notificação aos Admins quando uma nova review é submetida

---

**3.1.26 – Sistema de Livros Relacionados**

> Para incentivar a leitura, a página de cada livro mostra outros livros semelhantes. Para isto, criei um serviço (`BookSimilarityService`) que compara o texto da sinopse, os autores e a editora de cada livro e calcula quais são mais parecidos.
>
> 📸 **Imagem 24A: Função Principal de Semelhança (`app/Services/BookSimilarityService.php`) [Linhas 34 a 75]**
> _Texto de acompanhamento (Imagem 24A):_ A função `getRelatedBooks()` pega num livro e compara-o com todos os outros do catálogo. Para cada outro livro, calcula uma pontuação baseada na semelhança do texto da sinopse, autores em comum (`authorBoost`) e editora em comum (`editoraBoost`). Os 4 livros com maior pontuação são apresentados como sugestões.
> **Legenda:** `BookSimilarityService.php` — Função `getRelatedBooks()` que calcula e ordena os livros mais semelhantes
>
> 📸 **Imagem 24B: Algoritmo de Tokenização (`app/Services/BookSimilarityService.php`) [Linhas 132 a 144]**
> _Texto de acompanhamento (Imagem 24B):_ A função `tokenize()` transforma o texto da sinopse numa lista de palavras, ignorando palavras muito curtas e palavras comuns (como "o", "de", "que"). Isto é a base para o cálculo da semelhança textual entre dois livros.
> **Legenda:** `BookSimilarityService.php` — Função `tokenize()` que extrai palavras-chave relevantes para comparar livros

---

**3.1.28 – Alerta de Livro Disponível**

> Se um livro estiver emprestado e o utilizador quiser ser avisado quando voltar a estar disponível, pode ativar um alerta. Esse alerta fica guardado na base de dados até o livro ser devolvido.
>
> 📸 **Imagem 25: Envio de Alertas de Disponibilidade (`app/Livewire/LivrosComponent.php`) [Linhas 247 a 261]**
> _Texto de acompanhamento (Imagem 25):_ A função `enviarNotificacoesDisponibilidade()` é chamada automaticamente quando um livro novo é adicionado ao sistema. Ela vai à tabela de alertas pendentes daquele livro e envia um email a cada utilizador que estava à espera, marcando depois o alerta como notificado.
> **Legenda:** `LivrosComponent.php` — Função que notifica por email os utilizadores em lista de espera de um livro

---

**3.1.29 – Envio Automático do Alerta**

> Quando um livro novo é adicionado ou quando uma devolução é confirmada, o sistema verifica automaticamente se há alguém à espera de ser avisado e envia os emails de forma automática.
>
> 📸 **Imagem 26: Disparo Automático ao Guardar (`app/Livewire/LivrosComponent.php`) [Linhas 240 a 242]**
> _Texto de acompanhamento (Imagem 26):_ Dentro da função `store()`, logo após criar um livro novo, há a chamada `$this->enviarNotificacoesDisponibilidade($livro)`. Isto garante que quem estava à espera daquele livro é notificado imediatamente após ele aparecer no sistema.
> **Legenda:** `LivrosComponent.php` — Linha dentro de `store()` que dispara os alertas de disponibilidade ao criar um livro

---

**3.1.30 – Sistema de Carrinho de Compras**

> Além de requisitar, os utilizadores podem comprar livros que tenham preço definido. O carrinho de compras guarda os livros escolhidos antes do pagamento.
>
> 📸 **Imagem 27A: Calcular o Total do Carrinho (`app/Livewire/CarrinhoComponent.php`) [Linhas 15 a 34]**
> _Texto de acompanhamento (Imagem 27A):_ A função `render()` carrega os itens do carrinho do utilizador e calcula o total, multiplicando o preço de cada livro pela quantidade escolhida. Só conta os livros que ainda estão disponíveis no catálogo (`disponivelNoCatalogo`).
> **Legenda:** `CarrinhoComponent.php` — Função `render()` que carrega os itens do carrinho e calcula o total a pagar
>
> 📸 **Imagem 27B: Aumentar e Diminuir Quantidade (`app/Livewire/CarrinhoComponent.php`) [Linhas 36 a 57]**
> _Texto de acompanhamento (Imagem 27B):_ As funções `aumentarQuantidade()` e `diminuirQuantidade()` permitem ajustar a quantidade de cada livro no carrinho. Se a quantidade chegar a 0, o item é apagado. Ao alterar a quantidade, o campo `abandoned_email_sent` é reposto a `false` para o sistema poder enviar lembretes futuros se o utilizador não concluir a compra.
> **Legenda:** `CarrinhoComponent.php` — Funções de gestão de quantidade com `increment` / `decrement` e controlo de lembrete

---

**3.1.31 – Processo de Encomenda**

> Quando o utilizador decide comprar, passa por um processo em 3 passos: confirmar o carrinho, indicar a morada de entrega e pagar. No final, a encomenda fica registada definitivamente na base de dados.
>
> 📸 **Imagem 28: Criar a Encomenda Final (`app/Livewire/CarrinhoComponent.php`) [Linhas 114 a 131]**
> _Texto de acompanhamento (Imagem 28):_ Dentro de uma transação de base de dados (`DB::transaction`), o código cria a encomenda principal (`Encomenda::create`) com o utilizador, a morada e o total. Depois cria um registo de `EncomendaItem` para cada livro do carrinho, guardando o nome, o preço e a quantidade de cada um. Isto garante que o histórico da compra fica sempre intacto mesmo que o livro seja alterado depois.
> **Legenda:** `CarrinhoComponent.php` — Transação `DB::transaction` que converte o carrinho numa `Encomenda` definitiva

---

**3.1.32 – Integração com Stripe**

> Para os pagamentos com cartão, usei a API do Stripe. Em vez de guardar os dados do cartão na nossa base de dados (o que seria perigoso), o sistema cria uma sessão de pagamento no Stripe e redireciona o utilizador para a página segura deles.
>
> 📸 **Imagem 29A: Chaves do Stripe (`config/services.php`) [Linhas 20 a 23]**
> _Texto de acompanhamento (Imagem 29A):_ O ficheiro `services.php` lê as chaves do Stripe a partir do `.env` (`STRIPE_KEY` e `STRIPE_SECRET`). Assim as chaves reais nunca ficam expostas no código.
> **Legenda:** `services.php` — Configuração das chaves públicas e secretas da API do Stripe
>
> 📸 **Imagem 29B: Criar Sessão de Pagamento Stripe (`app/Livewire/CarrinhoComponent.php`) [Linhas 132 a 157]**
> _Texto de acompanhamento (Imagem 29B):_ A função `pagarEncomenda()` cria uma sessão de checkout no Stripe com o valor total, o nome do produto e os URLs de sucesso e cancelamento. O utilizador é depois redirecionado para a página segura do Stripe para inserir os dados do cartão. Quando o pagamento termina, o Stripe redireciona de volta para o nosso site.
> **Legenda:** `CarrinhoComponent.php` — Criação de sessão Stripe Checkout e redirecionamento para pagamento seguro

---

**3.1.33 – Gestão de Encomendas**

> O painel de administrador mostra todas as encomendas e permite atualizar o seu estado ao longo do processo (Pendente → Pago → Enviado).
>
> 📸 **Imagem 30: Painel de Gestão de Encomendas (`app/Livewire/EncomendasAdminComponent.php`) [Aprox. Linhas 30 a 50]**
> _Texto de acompanhamento (Imagem 30):_ Esta área do código trata da alteração do estado das encomendas. O administrador clica num botão que chama a função correspondente, o estado é atualizado na base de dados e o cliente recebe um email de notificação.
> **Legenda:** `EncomendasAdminComponent.php` — Lógica de atualização do estado da encomenda (Pendente → Pago → Enviado)

---

**3.1.34 – Sistema de Recuperação de Carrinho Abandonado**

> Se um utilizador adicionar livros ao carrinho mas não finalizar a compra durante mais de 1 hora, o sistema deteta isso e envia-lhe um email a lembrar que não terminou o pedido.
>
> 📸 **Imagem 31: Comando de Detecção de Carrinhos Abandonados (`app/Console/Commands/NotificarCarrinhoAbandonado.php`) [Linhas 13 a 42]**
> _Texto de acompanhamento (Imagem 31):_ A função `handle()` procura itens de carrinho onde `abandoned_email_sent` é `false` e `updated_at` é há mais de 1 hora. Agrupa por utilizador e envia um email a cada um com os livros que ficaram no carrinho. Depois marca esses itens com `abandoned_email_sent = true` para não enviar o mesmo email duas vezes.
> **Legenda:** `NotificarCarrinhoAbandonado.php` — Comando que deteta carrinhos com mais de 1h sem atividade e envia lembretes

---

**3.1.35 – Sistema de Logs**

> Para ter controlo total sobre o que acontece no sistema, criei um registo de atividade. Sempre que alguém cria, edita ou apaga dados importantes, o sistema guarda silenciosamente quem fez, o quê e quando.
>
> 📸 **Imagem 32: Estrutura da Tabela de Logs (`database/migrations/2026_06_05_000001_create_activity_logs_table.php`) [Linhas 11 a 23]**
> _Texto de acompanhamento (Imagem 32):_ A tabela `activity_logs` guarda: o ID e nome do utilizador que fez a ação, o módulo (ex: "Livros"), o ID do objeto alterado, o tipo de evento (ex: "criado" ou "apagado"), as alterações feitas em formato JSON, o endereço IP e a data. Assim é possível saber exatamente o que aconteceu e quem foi responsável.
> **Legenda:** Migration `create_activity_logs_table` — Estrutura da tabela de auditoria com utilizador, evento, módulo e timestamp

---

**3.1.36 – Importância dos Logs**

> Com este registo, se um administrador apagar algo por engano, é possível ver no painel de logs quem foi, quando foi e o que foi alterado. Isto é essencial para auditorias e para corrigir erros sem perder informação.
> _(Sem necessidade de Print)_

---

**3.1.37 – Testes Automatizados com PEST**

> Para garantir que o código funciona corretamente e que alterações novas não quebram o que já funcionava, usei o PEST para escrever testes automatizados. O PEST permite simular ações no sistema e verificar os resultados automaticamente.
>
> 📸 **Imagem 33: Teste Unitário de Serviço (`tests/Unit/BookSimilarityServiceTest.php`) [Aprox. Linhas 15 a 30]**
> _Texto de acompanhamento (Imagem 33):_ Este teste verifica se o serviço de livros relacionados funciona corretamente. Cria livros de teste e verifica se o serviço devolve sugestões coerentes, usando `expect()` para validar os resultados.
> **Legenda:** `BookSimilarityServiceTest.php` — Teste unitário que valida o funcionamento do serviço de livros relacionados

---

**3.1.38 – Teste de Criação de Requisição**

> Criei um teste mais completo que simula um utilizador a fazer login e a requisitar um livro, verificando se o registo aparece na base de dados no final.
>
> 📸 **Imagem 34: Teste de Funcionalidade (`tests/Feature/RequisicaoTest.php`) [Aprox. Linhas 20 a 40]**
> _Texto de acompanhamento (Imagem 34):_ O teste cria um utilizador de teste, simula o login e chama a ação de requisitar. No final, usa `assertDatabaseHas` para confirmar que o registo foi realmente criado na base de dados com os dados corretos.
> **Legenda:** `RequisicaoTest.php` — Teste de funcionalidade que simula um empréstimo e valida o resultado na base de dados

---

**3.1.39 – Competências Desenvolvidas Durante o Projeto Biblioteca**

> Ao desenvolver este sistema, aprendi a trabalhar de forma aprofundada com o Laravel e o Livewire, desde a criação de bases de dados relacionais com Migrations, até à integração com APIs externas como a Google Books e o Stripe. Também desenvolvi competências em segurança (2FA, encriptação, controlo de acessos), em automação (emails, tarefas agendadas, carrinho abandonado) e em testes automatizados com o PEST.

---

**3.1.40 – Conclusão do Projeto Biblioteca**

> O Projeto Biblioteca é um sistema completo, com funcionalidades que vão desde a simples consulta do catálogo até ao pagamento online. Todas as partes comunicam entre si de forma organizada e segura, com processos automáticos que poupam trabalho ao administrador. Sinto que este projeto me preparou muito bem para trabalhar em projetos reais de software.
> _(Sem necessidade de Print)_

---

### 3.2 – SISTEMA DE CHAT EMPRESARIAL

**3.2.1 – Introdução ao Projeto**

> Para facilitar a comunicação interna sem sair da plataforma, criei um sistema de chat em tempo real integrado diretamente na Biblioteca. Os utilizadores podem falar em canais de grupo, criar conversas privadas (DM) ou grupos, tudo dentro do mesmo site.

---

**3.2.2 – Planeamento e Estrutura da Aplicação**

> Para o chat funcionar, precisei de criar novas tabelas na base de dados para as Salas (Rooms) e as Mensagens (Messages), e uma tabela de ligação entre Salas e Utilizadores.
>
> 📸 **Imagem 35: Migration das Tabelas do Chat (`database/migrations/2026_06_22_160000_create_chat_tables.php`) [Linhas 11 a 37]**
> _Texto de acompanhamento (Imagem 35):_ Este ficheiro cria três tabelas: `rooms` (guarda o nome e o tipo de sala), `room_user` (liga utilizadores a salas com chave composta) e `messages` (guarda o conteúdo, o ID da sala e o ID do utilizador que enviou). A tabela de mensagens também suporta anexos de ficheiros.
> **Legenda:** Migration `create_chat_tables` — Criação das tabelas `rooms`, `room_user` e `messages` para o sistema de chat

---

**3.2.3 – Gestão de Utilizadores**

> Na interface do chat, aparece uma lista lateral com todos os utilizadores registados no sistema. O utilizador pode ver quem está disponível e clicar para iniciar uma conversa direta.
>
> 📸 **Imagem 36: Interface do Chat [Browser]**
> _Texto de acompanhamento (Imagem 36):_ Print do ecrã principal do chat, mostrando a lista de canais e membros do lado esquerdo e o painel de mensagens do lado direito. _(Print ao browser)._
> **Legenda:** Interface do Chat — Vista geral com lista de canais, membros e painel de conversação

---

**3.2.4 – Criação de Salas e Grupos**

> O Administrador pode criar canais públicos ou privados (só para Admins). Qualquer utilizador pode criar grupos e adicionar membros. As conversas privadas (DM) são criadas automaticamente quando um utilizador clica em "Falar" com outra pessoa.
>
> 📸 **Imagem 37A: Modelo da Sala (`app/Models/Room.php`) [Linhas 8 a 51]**
> _Texto de acompanhamento (Imagem 37A):_ O modelo `Room` tem os campos `is_dm` (para identificar conversas privadas), `is_group` (para grupos) e `is_admin_only` (para salas exclusivas de admins). Tem também os métodos `isChannel()` e `isGroup()` para verificar o tipo de sala, e os relacionamentos `users()` (Many-to-Many) e `messages()` (HasMany).
> **Legenda:** `Room.php` — Modelo da sala com tipos (`is_dm`, `is_group`, `is_admin_only`) e relacionamentos
>
> 📸 **Imagem 37B: Criar Sala de Canal (`app/Livewire/ChatComponent.php`) [Linhas 147 a 165]**
> _Texto de acompanhamento (Imagem 37B):_ A função `createRoom()` valida que o nome é único, cria a sala com o tipo correto e adiciona automaticamente o criador à sala com `attach(Auth::id())`. Apenas Admins podem criar canais.
> **Legenda:** `ChatComponent.php` — Função `createRoom()` que cria um novo canal e adiciona o criador como membro

---

**3.2.5 – Convite de Participantes**

> Quando uma sala ou grupo é criado, os membros são adicionados através de uma tabela de ligação (`room_user`). Para os canais gerais, os utilizadores são adicionados automaticamente na primeira visita.
>
> 📸 **Imagem 38: Ligação Utilizador-Sala (`app/Livewire/ChatComponent.php`) [Linhas 80 a 86]**
> _Texto de acompanhamento (Imagem 38):_ A função `ensureUserInRoom()` verifica se o utilizador já está na sala. Se não estiver, usa o método `attach(Auth::id())` da relação Many-to-Many para o adicionar automaticamente. Isto é chamado sempre que um utilizador acede a um canal.
> **Legenda:** `ChatComponent.php` — Função `ensureUserInRoom()` que adiciona automaticamente o utilizador à sala

---

**3.2.6 – Mensagens Privadas (Diretas)**

> Quando um utilizador clica em outro utilizador para falar diretamente, o sistema verifica se já existe uma sala DM entre os dois. Se existir, abre-a; se não existir, cria uma nova automaticamente.
>
> 📸 **Imagem 39A: Criar ou Abrir Conversa Direta (`app/Livewire/ChatComponent.php`) [Linhas 87 a 112]**
> _Texto de acompanhamento (Imagem 39A):_ A função `startDM()` procura se já existe uma sala com `is_dm = true` que tenha os dois utilizadores. Se encontrar, redireciona para ela; se não encontrar, cria uma nova sala DM com o nome de ambos e adiciona-os com `attach`.
> **Legenda:** `ChatComponent.php` — Função `startDM()` que abre ou cria uma conversa privada entre dois utilizadores
>
> 📸 **Imagem 39B: Enviar Mensagem (`app/Livewire/ChatComponent.php`) [Linhas 113 a 135]**
> _Texto de acompanhamento (Imagem 39B):_ A função `sendMessage()` guarda a mensagem na tabela `messages` com o ID da sala, o ID do utilizador e o conteúdo escrito. Se houver um ficheiro anexo, é guardado no servidor e o caminho é registado. No final, emite o evento `message-sent` para o Livewire atualizar o painel de mensagens automaticamente.
> **Legenda:** `ChatComponent.php` — Função `sendMessage()` que guarda a mensagem e atualiza o painel em tempo real

---

**3.2.8 – Competências Desenvolvidas**

> Com o sistema de chat, aprendi a gerir relações Many-to-Many entre utilizadores e salas, a trabalhar com uploads de ficheiros dentro do Livewire, e a criar interfaces em tempo real com atualização automática sem recarregar a página.

---

**3.2.9 – Conclusão do Projeto Chat**

> O sistema de chat ficou completo e funcional. Suporta canais de grupo, conversas privadas, grupos criados pelos utilizadores e até partilha de ficheiros. Tudo isto integrado diretamente na plataforma da Biblioteca, sem precisar de ferramentas externas.

---

### 3.3 – APLICAÇÃO TO-DO

**3.3.1 – Introdução ao Projeto**

> A Aplicação To-Do foi desenhada para oferecer aos utilizadores uma ferramenta rápida, simples e intuitiva de gestão de tarefas diárias. Desenvolvida no ecossistema do Laravel 12 e Tailwind CSS, a aplicação permite que cada utilizador crie, edite, conclua e elimine tarefas individuais (operações CRUD), organizando o seu fluxo de trabalho através de datas de vencimento, níveis de prioridade (Alta, Média, Baixa) e filtros avançados. Para além de potenciar a produtividade individual, o projeto serviu para consolidar a integração de requisições assíncronas no frontend com o Alpine.js e a escrita de testes de funcionalidade robustos.

---

**3.3.2 – Criação de Tarefas**

> A criação de novas tarefas é feita através de um formulário interativo aberto num modal. O processo de criação de tarefas dispõe de duas camadas de validação: uma do lado do cliente (client-side) utilizando JavaScript com Alpine.js que impede que datas de vencimento passadas sejam selecionadas, e outra do lado do servidor (server-side) gerida pela classe `StoreTaskRequest`, que valida a obrigatoriedade do título, a integridade da data e os valores do nível de prioridade antes de persistir os dados na base de dados.
>
> 📸 **Imagem 40A: Validação do Pedido de Criação (`app/Http/Requests/StoreTaskRequest.php`) [Linhas 14 a 30]**
> _Texto de acompanhamento (Imagem 40A):_ A classe `StoreTaskRequest` garante a validação rigorosa dos dados introduzidos: o título é obrigatório, a data de vencimento deve estar no presente ou futuro e a prioridade deve corresponder aos valores permitidos (high, medium, low).
> **Legenda:** `StoreTaskRequest.php` — Lógica de validação do formulário de criação de tarefas
>
> 📸 **Imagem 40B: Interface de Criação de Tarefa [Browser]**
> _Texto de acompanhamento (Imagem 40B):_ Print da interface do modal de criação de tarefa, apresentando campos polidos para o título, descrição, prazo de vencimento e prioridade, estruturados com Tailwind CSS.
> **Legenda:** Painel To-Do — Formulário em modal para registo de uma nova tarefa

---

**3.3.3 – Edição de Tarefas**

> A edição de tarefas existentes permite ao utilizador modificar o título, descrição, prazo, prioridade e o estado da tarefa. Ao clicar no botão de edição, os detalhes da tarefa correspondente são obtidos do servidor de forma assíncrona através de uma chamada AJAX (`Fetch API`) em formato JSON, preenchendo dinamicamente os campos do modal antes de enviar a atualização através do método HTTP `PUT` gerenciado pelo `UpdateTaskRequest`.
>
> 📸 **Imagem 41A: Atualização da Tarefa no Servidor (`app/Http/Controllers/TaskController.php`) [Linhas 85 a 105]**
> _Texto de acompanhamento (Imagem 41A):_ A função `update()` processa o pedido validado e ajusta dinamicamente o valor do campo `completed_at` (definindo a data atual se a tarefa foi concluída ou limpando-a caso regresse ao estado pendente).
> **Legenda:** `TaskController.php` — Lógica de atualização e controlo do registo temporal de conclusão
>
> 📸 **Imagem 41B: Modal de Edição com Dados Carregados [Browser]**
> _Texto de acompanhamento (Imagem 41B):_ Print do formulário de edição de tarefa com os dados previamente introduzidos recuperados via JSON do servidor e prontos a serem modificados.
> **Legenda:** Painel To-Do — Modal de edição de tarefas preenchido dinamicamente

---

**3.3.4 – Marcação de Tarefas como concluídas**

> Para dinamizar a experiência do utilizador, a alteração do estado de uma tarefa (entre pendente e concluída) pode ser efetuada diretamente através da caixa de seleção (checkbox) na listagem principal. Ao clicar na checkbox, o Alpine.js aplica de imediato um estilo visual de transição (*line-through* no título e redução da opacidade da linha da tabela) enquanto efetua um pedido assíncrono em background (via método PATCH para a rota de alternação de estado), recarregando o painel de forma suave para atualizar as estatísticas de progresso.
>
> 📸 **Imagem 42A: Endpoint de Alternar Estado (`app/Http/Controllers/TaskController.php`) [Linhas 121 a 138]**
> _Texto de acompanhamento (Imagem 42A):_ O método `toggle()` atua como um interruptor seguro. Ele verifica a propriedade do utilizador sobre a tarefa, inverte o seu estado atual e regista/limpa o campo `completed_at` em conformidade, devolvendo uma resposta de sucesso em JSON.
> **Legenda:** `TaskController.php` — Método `toggle()` para alternar rapidamente o estado das tarefas via AJAX
>
> 📸 **Imagem 42B: Lógica de Interação Client-side (`resources/views/dashboard.blade.php`) [Linhas 543 a 585]**
> _Texto de acompanhamento (Imagem 42B):_ Código em Alpine.js (`toggleTask`) que intercepta o clique do utilizador, manipula os elementos do DOM para feedback visual instantâneo e faz a chamada assíncrona com envio seguro do cabeçalho de proteção CSRF.
> **Legenda:** `dashboard.blade.php` — Função Javascript no frontend para gestão do feedback da checkbox

---

**3.3.5 – Eliminação de Tarefas**

> A exclusão de uma tarefa liberta o utilizador de registos que já não necessita. Para prevenir eliminações acidentais, a ação de exclusão exige uma confirmação interativa nativa do browser através do evento `onsubmit` no formulário associado. Após a confirmação, um pedido HTTP `DELETE` é enviado ao controlador, que remove a linha de forma definitiva do banco de dados e atualiza a view.
>
> 📸 **Imagem 43: Remoção Física de Registo (`app/Http/Controllers/TaskController.php`) [Linhas 107 a 119]**
> _Texto de acompanhamento (Imagem 43):_ O método `destroy()` certifica-se de que o utilizador autenticado é o legítimo proprietário da tarefa solicitada e, se a verificação for positiva, invoca o método `delete()` no modelo Eloquent.
> **Legenda:** `TaskController.php` — Função `destroy()` responsável pela remoção segura de uma tarefa

---

**3.3.6– Sistema de Filtros e Prioridades**

> A facilidade de visualização e foco nas prioridades é auxiliada por um painel de filtros robusto no topo do dashboard. O utilizador pode filtrar dinamicamente por estado (Todos, Pendentes, Concluídas ou Atrasadas), filtrar por prioridade (Baixa, Média, Alta), ordenar por datas de vencimento ou ordem alfabética de título, e realizar procuras parciais por palavra-chave na barra de pesquisa. No backend, a pesquisa e a paginação mantêm os parâmetros ativos no URL para melhor usabilidade.
>
> 📸 **Imagem 44A: Escopos e Filtros no Modelo (`app/Models/Task.php`) [Linhas 79 a 121]**
> _Texto de acompanhamento (Imagem 44A):_ O modelo `Task` encapsula a lógica de filtragem utilizando escopos locais e condicionais `when()` no Eloquent. Isto simplifica a estrutura das consultas SQL no controlador, mantendo o código modular.
> **Legenda:** `Task.php` — Escopo dinâmico `scopeFilter()` que processa os termos de pesquisa, prioridade e datas
>
> 📸 **Imagem 44B: Lógica de Ordenação Personalizada (`app/Http/Controllers/TaskController.php`) [Linhas 40 a 54]**
> _Texto de acompanhamento (Imagem 44B):_ No `TaskController`, a ordenação padrão por data de vencimento aplica a regra de ordenar valores nulos no fim da lista (utilizando `CASE WHEN due_date IS NULL THEN 1 ELSE 0 END`), garantindo consistência técnica em diferentes bases de dados.
> **Legenda:** `TaskController.php` — Implementação da ordenação por prioridades e datas de vencimento

---

**3.3.7 – Responsividade da Aplicação**

> O design da interface To-Do foi criado sob o conceito *mobile-first*. Utilizando as grelhas flexíveis (*grid layout*), flexbox e classes utilitárias adaptativas do Tailwind CSS (como `sm:`, `md:` e `lg:`), a interface adapta-se automaticamente. No telemóvel, os botões e estatísticas passam a ocupar uma coluna de ecrã inteiro e os botões de ação ganham espaçamento otimizado para toques rápidos, enquanto no computador o layout expande-se horizontalmente para melhor leitura espacial.
>
> 📸 **Imagem 45: Layout Responsivo em Mobile e Desktop [Browser]**
> _Texto de acompanhamento (Imagem 45):_ Print comparativo mostrando o alinhamento das estatísticas da aplicação e da tabela de listagem de tarefas no telemóvel comparado com o ecrã largo do computador, demonstrando uma transição visual fluida.
> **Legenda:** Painel To-Do — Vista responsiva e adaptável do painel em múltiplos tamanhos de ecrã

---

**3.3.8 – Estrutura da Base de Dados**

> A persistência dos dados assenta na tabela `tasks`, interligada à tabela `users` através de uma chave estrangeira com eliminação em cascata automática. A estrutura foi criada através de um ficheiro de migração do Laravel, que define os campos, índices e tipos de dados correspondentes.
>
> 📸 **Imagem 46: Criação da Tabela tasks (`database/migrations/2026_06_24_112246_create_tasks_table.php`) [Linhas 12 a 25]**
> _Texto de acompanhamento (Imagem 46):_ A migração define a estrutura da tabela `tasks` com chaves estrangeiras indexadas, o título da tarefa indexado, data de vencimento indexável, um campo enumerado (`enum`) para prioridades e estados, e o registo temporal `completed_at`.
> **Legenda:** Ficheiro de Migration — Criação da estrutura de dados da tabela `tasks` e seus índices de pesquisa

---

**3.3.9 – Testes e Validações**

> Para garantir a estabilidade e a qualidade da aplicação à medida que novos recursos são integrados, foi criada uma suite dedicada de testes de integração automatizados em PHPUnit. Estes testes simulam cenários reais de navegação de utilizadores autenticados e testam limites críticos de segurança, regras de validação e o correto funcionamento dos filtros e da ordenação da base de dados.
>
> 📸 **Imagem 47A: Execução dos Testes Automatizados [Terminal]**
> _Texto de acompanhamento (Imagem 47A):_ Print do resultado da consola ao correr o comando `php artisan test`. Vemos o resultado de sucesso na suite de testes, indicando que todos os 41 testes e 104 asserções passaram sem erros.
> **Legenda:** Terminal Artisan — Suite completa de testes PHPUnit com sucesso na validação
>
> 📸 **Imagem 47B: Testes de Filtros e Ordenação (`tests/Feature/TaskControllerTest.php`) [Linhas 254 a 320]**
> _Texto de acompanhamento (Imagem 47B):_ Exemplo de testes em PHPUnit que validam a segurança do dashboard, a capacidade de filtragem de estado, a filtragem de prioridade alta/baixa, a pesquisa por palavras-chave e a correta ordenação por datas de vencimento no backend.
> **Legenda:** `TaskControllerTest.php` — Escrita de asserções em Feature Tests para verificar a lógica de controlo de tarefas

---

**3.3.10 – Conclusão do Projeto To-Do**

> A implementação do Projeto To-Do cumpriu com êxito todos os objetivos traçados. A combinação entre as capacidades do Laravel no backend e o dinamismo do Tailwind CSS e Alpine.js no frontend resultou numa aplicação altamente ágil, intuitiva, acessível e segura. A automatização do processo de testes valida de forma fiável que a aplicação responde corretamente perante qualquer alteração no código. Conclui-se que o desenvolvimento deste módulo proporcionou uma consolidação fundamental em conceitos como segurança de rotas, requisições AJAX dinâmicas, tratamento e exibição de validações de formulário, e testes de cobertura.

