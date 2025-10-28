# TODO: Refazer Arquivos PHP do PAGTREM

## Etapas de Refatoração

### 1. Arquivos de Cadastro (cadastro1.php, cadastro2.php, cadastro3.php, cadastro4.php)
- [x] cadastro1.php: Refazer com validação aprimorada, sessão limpa.
- [x] cadastro2.php: Corrigir validação de data, melhorar UI.
- [x] cadastro3.php: Integrar localização corretamente, redirecionar após salvar.
- [x] cadastro4.php: Melhorar upload de foto, inserir dados no banco.

### 2. Arquivos de Autenticação (login.php, logout.php, recuperaçãodesenha.php)
- [x] login.php: Refazer com prepared statements consistentes.
- [x] logout.php: Simples, manter como está.
- [x] recuperaçãodesenha.php: Corrigir typo "ususarios" para "usuarios", melhorar lógica.

### 3. Páginas Principais (dashboard.php, menu.php, telainicial.php)
- [x] dashboard.php: Melhorar exibição de stats, incluir menu.
- [x] menu.php: Garantir links corretos, sessão check.
- [x] telainicial.php: Corrigir link para login.php.

### 4. Funcionalidades (chat.php, contatos.php, notificacoes.php, relatorios.php, monitoramento.php, gestaoderotas.php, lista_usuarios.php)
- [x] chat.php: Melhorar inserção de mensagens, exibição.
- [x] contatos.php: Corrigir link para chat.php.
- [ ] notificacoes.php: Exibir notificações corretamente.
- [ ] relatorios.php: Melhorar layout, incluir dados dinâmicos se possível.
- [ ] monitoramento.php: Exibir tabela de sensores.
- [ ] gestaoderotas.php: Melhorar CRUD de rotas.
- [ ] lista_usuarios.php: Exibir lista de usuários.

### 5. Páginas de Email (email.php, e-mailNãoencontrado.php)
- [ ] email.php: Melhorar logging, UI.
- [ ] e-mailNãoencontrado.php: Refazer com PHP mais limpo.

### 6. Testes e Validação
- [ ] Testar fluxo completo: cadastro -> login -> dashboard.
- [ ] Verificar links e redirecionamentos.
- [ ] Corrigir erros de banco de dados.

### 7. Melhorias Gerais
- [ ] Padronizar includes (db.php, session_start).
- [ ] Melhorar segurança: escapar outputs, validar inputs.
- [ ] Atualizar CSS/JS links se necessário.
