# Documentação Avançada do Sistema Trem Fácil

## Visão Geral
Trem Fácil é uma solução web para administração de usuários, trens, estações e sensores em uma rede ferroviária. O sistema foi desenvolvido em PHP (backend), MySQL/MariaDB (banco de dados), HTML, CSS e JavaScript (frontend), com foco em operações CRUD, segurança e experiência do usuário.

## Estrutura de Pastas
- **assets/**: Ícones, imagens e recursos visuais.
- **private/**: Scripts PHP restritos para administração, lógica interna e CRUD de usuários.
- **public/**: Telas acessíveis ao usuário (login, cadastro, dashboards, perfil, suporte, trens, estações, etc.).
- **style/**: Arquivos CSS para estilização das páginas.
- **uploads/**: Armazena fotos de perfil e arquivos enviados.
- **db.sql / db.php**: Scripts para criação e inicialização do banco de dados.

## Banco de Dados
- **usuario**: id_usuario, nome_completo, email, telefone, cep, cpf, senha (hash), tipo_usuario, data_criacao.
- **sensor**: id_sensor, nome, status, localizacao, ultima_atualizacao_texto, ultima_atualizacao_valor, ultima_atualizacao_unidade.
- **rota**: id_rota, nome, id_sensor.
- **trem**: id_trem, nome, horario, parada.
- **estacao**: id_estacao, nome, id_trem.

## Segurança
- Senhas com hash seguro (`password_hash`).
- Prepared statements para evitar SQL injection.
- Validação de uploads e permissões de acesso.
- Controle de sessão e redirecionamento conforme tipo de usuário.
- Validação rigorosa de dados no backend e frontend.

## Melhorias Sugeridas
- Completar formulários e validações do cadastro.
- Implementar preview de imagem no perfil.
- Popular selects do suporte com dados reais.
- Centralizar configuração do banco de dados.
- Implementar persistência dos alertas de suporte.
- Melhorar feedback visual e mensagens de erro.
- Documentar endpoints e fluxos de API (se aplicável).



## Explicação Detalhada do Código de Cada Página

### index.php (Tela de Entrada)
- **Propósito:** Página inicial que apresenta o sistema e direciona para o login. Permite simular o tipo de usuário via parâmetro (?tipo=1 ou ?tipo=2), redirecionando para dashboards específicos.
- **Principais pontos do código:**
  - Inclui `public/db.php` para garantir que o banco está criado.
  - Usa `$_SESSION['tipo_usuario']` para controlar o fluxo de acesso.
  - Redireciona para `cliente_dashboard.php` ou `admin_dashboard.php` conforme o tipo.
  - HTML responsivo, exibe imagem e botão de login.

### login.php (Autenticação)
- **Propósito:** Autentica o usuário, inicia sessão e define o tipo de usuário.
- **Principais pontos do código:**
  - Recebe email e senha via POST.
  - Busca usuário no banco e valida senha com `password_verify`.
  - Define `$_SESSION['user']` e `$_SESSION['tipo_usuario']`.
  - Redireciona para o dashboard apropriado.
  - Exibe mensagens de erro em caso de falha.
  - Permite acesso à recuperação de senha.

### cadastro1.php (Cadastro - Parte 1)
- **Propósito:** Primeira etapa do cadastro de usuário, coleta dados pessoais.
- **Principais pontos do código:**
  - Recebe nome, CPF, CEP e email via POST.
  - Validações: nome (letras e espaços, min 3), CPF (11 dígitos, função `validateCPF`), CEP (8 dígitos), email (formato válido).
  - Se aprovado, salva dados na sessão (`$_SESSION['cadastro1']`) e redireciona para `cadastro2.php`.
  - Integração com API ViaCEP via JS para preenchimento automático do endereço.
  - Exibe mensagens de erro em caso de validação falha.

### cadastro2.php (Cadastro - Parte 2)
- **Propósito:** Segunda etapa do cadastro, coleta credenciais e dados complementares.
- **Principais pontos do código:**
  - Recebe senha, confirmação, telefone e tipo de usuário.
  - Valida duplicidade de email, CPF e telefone no banco.
  - Salva senha com hash seguro (`password_hash`).
  - Finaliza cadastro e redireciona para login ou dashboard.
  - Exibe mensagens de erro em caso de duplicidade ou validação falha.

### perfil.php (Perfil do Usuário)
- **Propósito:** Exibe e permite editar dados do perfil do usuário.
- **Principais pontos do código:**
  - Exibe nome, cargo, permissões e foto de perfil.
  - Permite upload de foto (jpg, jpeg, png, gif), salva em `uploads/`.
  - Permite navegação para outras áreas do sistema via formulário.
  - Permite logout.
  - Preview de imagem via JS (em desenvolvimento).
  - Exibe dados do usuário logado.
  - Permite redirecionamento para sensores, trens, estações e suporte.

### trens.php (Listagem de Trens)
- **Propósito:** Lista linhas/trens, paradas e horários.
- **Principais pontos do código:**
  - Conexão PDO, busca linhas, paradas e horários agrupados.
  - Exibe status, paradas e horários de cada linha.
  - Permite pesquisa por nome do trem (JS).
  - Botão de notificação para cada trem (em desenvolvimento).
  - Design responsivo e moderno.

### estacoes.php (Listagem de Estações)
- **Propósito:** Lista estações e as linhas associadas.
- **Principais pontos do código:**
  - Consulta banco, agrupa linhas por estação.
  - Exibe legenda de status (ATIVO, MANUTENÇÃO, INATIVO).
  - Permite expandir para visualizar linhas de cada estação.
  - Permite pesquisa por nome da estação (JS).
  - Design responsivo e intuitivo.

### suporte_alerta.php (Suporte e Alertas)
- **Propósito:** Formulário para envio de alertas de suporte.
- **Principais pontos do código:**
  - Campos: local, linha, tipo de problema, emergência.
  - Ao enviar, exibe mensagem de sucesso.
  - Permite navegação para outras telas via formulário.
  - Selects para local, linha e problema devem ser populados dinamicamente.
  - Implementar persistência dos alertas no banco de dados.

### pagina_inicial.php / pagina_inicial_adm.php (Dashboards)
- **Propósito:** Tela inicial do usuário e do administrador.
- **Principais pontos do código:**
  - Exibe navegação para Perfil, Trens, Sensores, Estações e Lista de Usuários.
  - O tipo de usuário controla o acesso às funções administrativas.
  - Design adaptado para diferentes perfis de usuário.

### private/cadastrar_user.php, lista_usuarios.php, update_usuarios.php, delete_usuarios.php (Administração de Usuários)
- **Propósito:** CRUD completo de usuários para administradores.
- **Principais pontos do código:**
  - Cadastro multi-etapas com validações rigorosas.
  - Prevenção de duplicidade de email, CPF e telefone.
  - Senhas armazenadas com hash seguro.
  - Listagem, edição e exclusão de usuários.
  - Uso de prepared statements para segurança.
  - Exibe mensagens de erro e sucesso.



Para dúvidas, consulte os arquivos PHP nas pastas `public/` e `private/` ou o script de banco em `db.sql`/`db.php`. Recomenda-se revisar cada página para garantir que as validações e fluxos estejam de acordo com as necessidades do projeto.
Explicação Detalhada de Cada Tela do Projeto Trem Fácil

1. index.php (Tela de Entrada)
Propósito
A tela inicial do sistema Trem Fácil serve como ponto de partida para todos os usuários. Ela apresenta a identidade visual do sistema, oferece acesso ao login e permite simular o tipo de usuário (cliente ou administrador) via parâmetro na URL.

Estrutura Visual
Exibe o logotipo do sistema e uma breve mensagem de boas-vindas.
Botão de login destacado, com design responsivo para diferentes dispositivos.
Possui estilos adaptativos para desktop, tablet e mobile.
Fluxo de Funcionamento
Ao acessar a página, o sistema verifica se existe o parâmetro ?tipo na URL.
Se o parâmetro estiver presente:
O valor é atribuído à variável de sessão $_SESSION['tipo_usuario'].
O usuário é redirecionado para o dashboard correspondente:
cliente_dashboard.php para tipo 1 (cliente).
admin_dashboard.php para tipo 2 (administrador).
Caso contrário, o usuário pode clicar no botão de login para acessar a tela de autenticação.
Código Principal
Inclui o arquivo db.php para garantir que o banco de dados está criado e inicializado.
Utiliza sessões para controlar o fluxo de acesso.
O HTML é estruturado para ser acessível e responsivo.
Validações e Segurança
O controle de tipo de usuário é feito via sessão, evitando manipulação indevida de acesso.
O redirecionamento é imediato após a definição do tipo.
Sugestões de Melhoria
Adicionar uma breve descrição do sistema na tela inicial.
Incluir links para documentação ou suporte.
Implementar animações leves para melhorar a experiência do usuário.

2. login.php (Tela de Autenticação)
Propósito
A tela de login permite que usuários autenticados acessem o sistema, protegendo áreas restritas e personalizando a experiência conforme o perfil (cliente ou administrador).

Estrutura Visual
Formulário de login com campos para email e senha.
Mensagens de erro exibidas em destaque.
Link para recuperação de senha.
Fluxo de Funcionamento
O usuário informa email e senha.
O sistema busca o usuário no banco de dados.
A senha é validada usando password_verify.
Se as credenciais forem válidas:
A sessão é iniciada com $_SESSION['user'] e $_SESSION['tipo_usuario'].
O usuário é redirecionado para o dashboard apropriado.
Se inválidas:
Uma mensagem de erro é exibida.
O usuário pode tentar novamente ou acessar a recuperação de senha.
Código Principal
Utiliza prepared statements para buscar o usuário no banco, evitando SQL injection.
A senha é comparada de forma segura.
O tipo de usuário é definido na sessão para controle de acesso.
Validações e Segurança
Email obrigatório e formato válido.
Senha obrigatória.
Proteção contra ataques de força bruta (sugestão: implementar limite de tentativas).
Sessão regenerada após login para evitar fixação de sessão.
Sugestões de Melhoria
Implementar autenticação em dois fatores.
Adicionar captcha para evitar bots.
Melhorar feedback visual das mensagens de erro.

3. cadastro1.php (Cadastro - Parte 1)
Propósito
Primeira etapa do cadastro de novos usuários, focada na coleta de dados pessoais essenciais para identificação e validação.

Estrutura Visual
Formulário com campos para nome completo, CPF, CEP e email.
Mensagens de erro exibidas em destaque.
Integração com API ViaCEP para preenchimento automático do endereço.
Fluxo de Funcionamento
O usuário preenche os campos obrigatórios.
O sistema valida cada campo:
Nome: apenas letras e espaços, mínimo de 3 caracteres.
CPF: 11 dígitos, validação dos dígitos verificadores.
CEP: 8 dígitos.
Email: formato válido.
Se todos os campos forem válidos:
Os dados são salvos na sessão ($_SESSION['cadastro1']).
O usuário é redirecionado para a segunda etapa do cadastro (cadastro2.php).
Se houver erros:
Mensagens específicas são exibidas para cada campo inválido.
Código Principal
Função validateCPF implementa a lógica de validação dos dígitos verificadores do CPF.
Integração com a API ViaCEP via JavaScript para buscar endereço pelo CEP.
Utiliza sessões para armazenar dados temporários do cadastro.
Validações e Segurança
Validação rigorosa dos campos no backend.
Sanitização dos dados antes de salvar na sessão.
Prevenção de duplicidade de email, CPF e telefone (sugestão: implementar verificação no banco nesta etapa).
Sugestões de Melhoria
Adicionar validação em tempo real no frontend.
Exibir sugestões de endereço após consulta ao ViaCEP.
Implementar máscara de entrada para CPF e CEP.

4. cadastro2.php (Cadastro - Parte 2)
Propósito
Segunda etapa do cadastro, responsável pela coleta de credenciais e dados complementares do usuário.

Estrutura Visual
Formulário com campos para senha, confirmação de senha, telefone e tipo de usuário.
Mensagens de erro exibidas em destaque.
Fluxo de Funcionamento
O usuário informa a senha e a confirmação.
O sistema valida:
Senha: mínimo de 6 caracteres, deve coincidir com a confirmação.
Telefone: formato válido.
Tipo de usuário: seleção entre cliente e administrador.
Antes de finalizar o cadastro:
O sistema verifica se email, CPF ou telefone já existem no banco.
Se houver duplicidade, exibe mensagem de erro.
Se tudo estiver correto:
A senha é salva com hash seguro (password_hash).
Os dados são inseridos no banco de dados.
O usuário é redirecionado para o login ou dashboard.
Código Principal
Utiliza prepared statements para inserção segura no banco.
Validação de duplicidade antes do cadastro.
Armazenamento seguro da senha.
Validações e Segurança
Senha nunca é armazenada em texto plano.
Verificação de duplicidade para evitar contas repetidas.
Sanitização dos dados antes da inserção.
Sugestões de Melhoria
Implementar força de senha (exigir caracteres especiais, números, etc.).
Adicionar confirmação visual de cadastro realizado com sucesso.
Permitir cadastro via redes sociais (OAuth).

5. perfil.php (Perfil do Usuário)
Propósito
Exibe e permite a edição dos dados do perfil do usuário, incluindo foto, nome, cargo e permissões.

Estrutura Visual
Exibe foto de perfil, nome, cargo e permissões.
Botão para upload de nova foto.
Links para navegação entre áreas do sistema.
Botão de logout.
Fluxo de Funcionamento
O usuário pode visualizar seus dados.
Para alterar a foto:
Seleciona um arquivo de imagem (jpg, jpeg, png, gif).
O sistema valida o tipo e salva em uploads.
A foto é atualizada na sessão e exibida imediatamente.
O usuário pode navegar para outras áreas (sensores, trens, estações, suporte).
O botão de logout encerra a sessão e redireciona para o login.
Código Principal
Manipulação de arquivos para upload de foto.
Atualização dos dados na sessão após alteração.
Redirecionamento via formulário para outras páginas.
Validações e Segurança
Validação do tipo de arquivo no upload.
Limite de tamanho para imagens (sugestão: implementar).
Proteção contra upload de arquivos maliciosos.
Sugestões de Melhoria
Implementar preview de imagem antes do upload.
Permitir edição de outros dados do perfil (nome, telefone, etc.).
Adicionar histórico de alterações no perfil.

6. trens.php (Listagem de Trens)
Propósito
Lista todas as linhas de trens, suas paradas e horários, permitindo pesquisa e visualização detalhada.

Estrutura Visual
Lista de trens com nome, status, paradas e horários.
Campo de pesquisa para filtrar trens por nome.
Botão de notificação para cada trem (em desenvolvimento).
Fluxo de Funcionamento
O sistema consulta o banco via PDO, buscando todas as linhas, paradas e horários.
Para cada linha:
Exibe nome, status, cor do status, paradas e horários agrupados por estação.
O usuário pode pesquisar trens pelo nome, filtrando a lista em tempo real.
Botão de notificação permite configurar alertas para trens específicos (em desenvolvimento).
Código Principal
Consultas SQL otimizadas para buscar dados relacionados.
Uso de arrays para agrupar horários por estação.
JavaScript para pesquisa dinâmica na lista de trens.
Validações e Segurança
Sanitização dos dados exibidos para evitar XSS.
Controle de acesso para funcionalidades administrativas.
Sugestões de Melhoria
Implementar filtros avançados (por status, horário, parada).
Adicionar gráficos ou mapas para visualização das rotas.
Permitir exportação dos dados em PDF ou Excel.

7. estacoes.php (Listagem de Estações)
Propósito
Lista todas as estações, exibindo as linhas associadas e permitindo pesquisa e visualização detalhada.

Estrutura Visual
Lista de estações com nome e linhas associadas.
Legenda de status (ATIVO, MANUTENÇÃO, INATIVO).
Campo de pesquisa para filtrar estações por nome.
Botão para expandir e visualizar linhas de cada estação.
Fluxo de Funcionamento
O sistema consulta o banco, agrupando linhas por estação.
Para cada estação:
Exibe nome, linhas associadas e status.
O usuário pode pesquisar estações pelo nome, filtrando a lista em tempo real.
Botão de expansão permite visualizar detalhes das linhas.
Código Principal
Consulta SQL com GROUP_CONCAT para agrupar linhas.
JavaScript para pesquisa e expansão dinâmica.
Exibição de cores e status conforme dados do banco.
Validações e Segurança
Sanitização dos dados exibidos.
Controle de acesso para funcionalidades administrativas.
Sugestões de Melhoria
Adicionar mapa interativo das estações.
Permitir edição e exclusão de estações (admin).
Implementar notificações de status em tempo real.

8. suporte_alerta.php (Suporte e Alertas)
Propósito
Permite o envio de alertas de suporte, informando local, linha, tipo de problema e emergência.

Estrutura Visual
Formulário com campos para local, linha, tipo de problema e emergência.
Mensagem de sucesso após envio.
Links para navegação entre áreas do sistema.
Fluxo de Funcionamento
O usuário preenche os campos do formulário.
Ao enviar, o sistema exibe uma mensagem de sucesso.
O usuário pode navegar para outras áreas via formulário.
Os selects para local, linha e problema devem ser populados dinamicamente (sugestão de melhoria).
Código Principal
Manipulação de POST para receber dados do formulário.
Exibição de mensagem de sucesso após envio.
Redirecionamento via formulário para outras páginas.
Validações e Segurança
Validação dos campos obrigatórios.
Sanitização dos dados recebidos.
Implementar persistência dos alertas no banco de dados (sugestão).
Sugestões de Melhoria
Popular selects com dados reais do banco.
Implementar histórico de alertas enviados.
Adicionar opção de anexar arquivos ou imagens ao alerta.
9. pagina_inicial.php / pagina_inicial_adm.php (Dashboards)
Propósito
Tela inicial do usuário e do administrador, com navegação para todas as áreas do sistema.

Estrutura Visual
Menu com links para Perfil, Trens, Sensores, Estações e Lista de Usuários.
Design adaptado para diferentes perfis de usuário.
Fluxo de Funcionamento
O tipo de usuário ($_SESSION['tipo_usuario']) controla o acesso às funções administrativas.
O usuário pode navegar para qualquer área do sistema a partir do dashboard.
Código Principal
Estrutura de navegação dinâmica conforme o perfil do usuário.
Redirecionamento seguro para páginas restritas.
Validações e Segurança
Controle de acesso rigoroso para áreas administrativas.
Sessão obrigatória para acessar o dashboard.
Sugestões de Melhoria
Adicionar widgets com estatísticas do sistema.
Implementar notificações em tempo real.
Permitir personalização do dashboard pelo usuário.
10. Administração de Usuários (private/cadastrar_user.php, lista_usuarios.php, update_usuarios.php, delete_usuarios.php)
Propósito
CRUD completo de usuários para administradores, incluindo cadastro, listagem, edição e exclusão.

Estrutura Visual
Formulários para cadastro e edição de usuários.
Lista de usuários com opções de editar e excluir.
Mensagens de erro e sucesso exibidas em destaque.
Fluxo de Funcionamento
Cadastro multi-etapas com validações rigorosas.
Prevenção de duplicidade de email, CPF e telefone.
Senhas armazenadas com hash seguro.
Listagem de usuários com filtros e pesquisa.
Edição e exclusão de usuários com confirmação.
Código Principal
Uso de prepared statements para todas as operações no banco.
Validação de dados antes de qualquer alteração.
Exibição dinâmica de mensagens de erro e sucesso.
Validações e Segurança
Controle de acesso restrito a administradores.
Validação rigorosa dos dados em todas as operações.
Proteção contra SQL injection e XSS.
Sugestões de Melhoria
Implementar logs de auditoria para alterações de usuários.
Adicionar filtros avançados na lista de usuários.
Permitir exportação dos dados em diferentes formatos.
Considerações Finais
O sistema Trem Fácil foi projetado para ser seguro, eficiente e fácil de usar. Cada tela possui validações rigorosas, controle de acesso e design responsivo. As sugestões de melhoria apresentadas visam tornar o sistema ainda mais robusto e completo, atendendo às necessidades dos usuários e administradores.

++