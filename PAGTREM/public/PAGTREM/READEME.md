# Documentação Avançada do Sistema PAGTREM

## Visão Geral
PAGTREM é uma aplicação web desenvolvida para administrar usuários, trens, sensores e estações de uma rede ferroviária. Utiliza PHP como backend, MySQL/MariaDB como banco de dados e HTML/CSS/JavaScript para o frontend. O sistema fornece operações CRUD, login seguro, gerenciamento administrativo, envio de alertas e controle de sessão.

## Estrutura de Pastas
- assets/ → Imagens, ícones e elementos gráficos.
- private/ → Scripts PHP internos (CRUD, administração, validações).
- public/ → Páginas acessíveis ao usuário (login, dashboards, trens, estações, perfil etc.).
- style/ → Arquivos CSS.
- uploads/ → Fotos de perfil enviadas pelo usuário.
- db.sql / db.php → Scripts para criação e inicialização do banco de dados.

## Banco de Dados
Tabelas principais:
- usuario(id_usuario, nome_completo, email, telefone, cep, cpf, senha_hash, tipo_usuario, data_criacao)
- sensor(id_sensor, nome, status, localizacao, ultima_atualizacao_texto, ultima_atualizacao_valor, ultima_atualizacao_unidade)
- rota(id_rota, nome, id_sensor)
- trem(id_trem, nome, horario, parada)
- estacao(id_estacao, nome, id_trem)

## Segurança
- Hash seguro de senhas com password_hash().
- Sessions + redirecionamento por tipo de usuário.
- Prepared statements para evitar SQL injection.
- Sanitização de uploads.
- Validação completa no backend e frontend.

## Melhorias Sugeridas
- Preview de imagem no perfil.
- Campos do suporte preenchidos dinamicamente.
- Persistência dos alertas no banco.
- Melhor feedback visual para erros.
- Centralizar configurações de banco e constantes.

# EXPLICAÇÃO DETALHADA DE CADA TELA DO SISTEMA PAGTREM

## 1. index.php (Tela de Entrada)
Função:
Tela inicial do PAGTREM. Exibe boas-vindas e botão de acesso ao login. Permite simular tipo de usuário via URL (?tipo=1 / ?tipo=2).

Como funciona:
- Inclui db.php para inicializar o banco.
- Verifica se foi definido um tipo de usuário pela URL.
- Salva o tipo na sessão e redireciona para o dashboard apropriado.
- HTML responsivo com logotipo, mensagem e botão de login.

Sugestões:
Adicionar descrição curta do serviço e link de suporte.

## 2. login.php (Autenticação)
Função:
Gerencia o login do usuário.

Funcionamento:
- Recebe email/senha.
- Busca usuário usando prepared statements.
- Verifica senha com password_verify().
- Define $_SESSION['user'] e $_SESSION['tipo_usuario'].
- Redireciona para dashboard conforme tipo.

Erros:
- Email ou senha incorretos → mensagens claras.

Sugestões:
Adicionar 2FA e captcha.

## 3. cadastro1.php (Cadastro Etapa 1)
Função:
Primeira etapa do cadastro (dados pessoais).

Validações:
- Nome com mínimo 3 caracteres.
- CPF com 11 dígitos e verificação lógica.
- CEP com 8 dígitos.
- Email válido.

Fluxo:
- Se tudo OK → salva em $_SESSION['cadastro1'] → redireciona para cadastro2.php.
- Se erro → mensagem específica.
- ViaCEP preenche endereço automaticamente via JS.

Sugestões:
Máscaras para CPF/CEP.

## 4. cadastro2.php (Cadastro Etapa 2)
Função:
Finaliza o cadastro (senha, telefone e tipo).

Validações:
- Senha = confirmação.
- Senha mínima de 6 caracteres.
- Telefone válido.
- Checagem de duplicidade: email, CPF e telefone.

Fluxo:
- Se dados válidos → cria conta no banco com password_hash().
- Redireciona para login.

Sugestões:
Indicador de força da senha.

## 5. perfil.php (Perfil do Usuário)
Função:
Exibe e permite editar informações do usuário.

Recursos:
- Foto de perfil → validação de imagem → salva em uploads/.
- Exibe nome, email, telefone, cargo.
- Botões para navegar (sensores, trens, estações, suporte).
- Logout.

Sugestões:
Editar todos os dados, não só foto.

## 6. trens.php (Listagem de Trens)
Função:
Exibe lista de linhas/trens com horários e paradas.

Funcionamento:
- Consulta PDO agrupa horários e paradas.
- Campo de busca filtra por nome via JS.
- Botão de notificação (em desenvolvimento).

Sugestões:
Filtrar por status, horário, parada; exportar PDF.

## 7. estacoes.php (Listagem de Estações)
Função:
Lista estações e suas linhas.

Recursos:
- Busca por nome.
- Botão para expandir e ver linhas vinculadas.
- Cores de status: ATIVO, INATIVO, MANUTENÇÃO.

Sugestões:
Mapa interativo das estações.

## 8. suporte_alerta.php (Suporte e Alertas)
Função:
Permite envio de alerta para equipe de suporte.

Campos:
- Local.
- Linha.
- Tipo de problema.
- Emergência.

Fluxo:
- Usuário envia → mensagem de sucesso.
- Selects devem futuramente vir do banco.

Sugestões:
Armazenar alertas no banco.

## 9. pagina_inicial.php / pagina_inicial_adm.php (Dashboards)
Função:
Página inicial de cada tipo de usuário.

Recursos:
- Links para Perfil, Trens, Estações, Sensores e Lista de Usuários.
- Controle rígido de acesso baseado em tipo_usuario.

Sugestões:
Widgets com estatísticas em tempo real.

## 10. Administração de Usuários (CRUD)
Arquivos:
- private/cadastrar_user.php
- private/lista_usuarios.php
- private/update_usuarios.php
- private/delete_usuarios.php

Função:
Administradores podem criar, listar, editar e excluir contas.

Recursos:
- Validação completa.
- Prepared statements.
- Hash de senha.
- Listagem com filtros.
- Confirmação antes de excluir.

Sugestões:
Registrar logs de auditoria.

# Conclusão
Este documento reúne a documentação completa do sistema PAGTREM em um único bloco, com todas as telas, funcionalidades, validações e melhorias sugeridas. Ele serve como referência completa para manutenção, entrega ou avaliação do projeto.

