# Assistance

Sistema web em PHP e MySQL para organizar o fluxo de trabalho de técnicos de informática. O projeto reúne autenticação, perfis de administrador e técnico, gestão de clientes, ordens de serviço, chamados, pendências e indicadores operacionais.

## Recursos atuais

- Login e primeiro acesso do administrador.
- Recuperação de senha com aprovação do administrador e link temporário enviado via SMTP.
- Controle de sessão e separação de permissões.
- MFA por e-mail para administradores, bloqueio contra força bruta e expiração por inatividade.
- Trilha de auditoria e acesso de técnicos limitado aos clientes atribuídos.
- Pajezinho IA para análise de chamados, relatórios técnicos e dúvidas de suporte.
- Aviso de privacidade, canal do titular e painel administrativo de solicitações LGPD.
- Dashboard para acompanhamento operacional.
- Cadastro, visualização, edição e exclusão de clientes.
- Telas de ordens de serviço, chamados, pendências, serviços e usuários.
- Layout corporativo responsivo, com foco em computadores.
- Impressão de ordem de serviço.
- Banco de dados com consultas preparadas contra SQL Injection.
- Documentação do projeto em DOCX e PDF na pasta `docs`.
- Avaliação técnica e plano de adequação à LGPD em [`docs/ADEQUACAO_LGPD.md`](docs/ADEQUACAO_LGPD.md).

## Manuais de uso

- [Manual do administrador em PDF](docs/Manual_Administrador_Assistance.pdf).
- [Manual do usuário técnico em PDF](docs/Manual_Usuario_Tecnico_Assistance.pdf).
- [Manual completo em PDF](docs/Manual_do_Usuario_Assistance.pdf).
- Versões editáveis em texto: [Administrador](docs/MANUAL_ADMINISTRADOR.md) e [Técnico](docs/MANUAL_TECNICO.md).

Os guias cobrem acesso, painel, cadastros, ordens de serviço, chamados, pendências, recuperação de senha e uso do Pajezinho. A voz personalizada foi removida; a leitura comum depende do navegador.

## Verificação do código

Os testes abaixo usam transporte simulado de IA e regras isoladas de autorização, sem consumir serviços externos ou dados de produção:

```powershell
C:\xampp\php\php.exe -d zend.assertions=1 -d assert.exception=1 tests/smoke_assistance_ai.php
C:\xampp\php\php.exe tests/smoke_operational_access.php
```

Os demais testes dependem de banco de desenvolvimento. Não os execute no banco de produção.

## Requisitos

- Git.
- XAMPP com Apache, PHP e MySQL.
- Navegador atualizado.

## Instalação no Windows

Abra o PowerShell e execute:

```powershell
git clone -b <branch-do-projeto> https://github.com/patotrembala/assistance.git
cd assistance
Copy-Item config/database.example.php config/database.local.php
Copy-Item config/auth.example.php config/auth.local.php
Copy-Item config/mail.example.php config/mail.local.php
Copy-Item config/security.example.php config/security.local.php
Copy-Item config/ai.example.php config/ai.local.php
```

Os arquivos terminados em `.local.php` são privados e não são enviados ao GitHub. Edite:

- `config/database.local.php`: conexão do MySQL local. No XAMPP padrão, o exemplo já utiliza usuário `root` sem senha.
- `config/auth.local.php`: nome e e-mail autorizados para criar o primeiro administrador.
- `config/mail.local.php`: servidor SMTP utilizado para enviar links de recuperação de senha.
- `config/security.local.php`: chave aleatória privada usada para pseudonimizar origens nos registros de segurança.
- `config/ai.local.php`: chave e modelo usados pelo Pajezinho IA; mantenha a chave apenas no ambiente configurado.

Como alternativa à cobrança separada da API, a demonstração escolar aceita a autorização oficial da conta ChatGPT do administrador. Veja o procedimento e as limitações em [`docs/ASSISTENTE_IA.md`](docs/ASSISTENTE_IA.md). As credenciais ficam em `config/chatgpt.oauth.local.json`, nunca no Git ou no navegador. Administradores e técnicos autenticados podem usar o Assistente de IA, sujeitos ao limite de uso configurado pelo sistema.

Na hospedagem gratuita da InfinityFree, a função `mail()` não está disponível. Configure um SMTP externo. Para Gmail, ative a verificação em duas etapas e utilize uma senha de aplicativo; nunca coloque a senha normal da conta no arquivo.
O remetente oficial do projeto é `Assistance <seu-email@example.com>`; a senha de aplicativo deve existir apenas no `config/mail.local.php` de cada ambiente.

## Criar o banco local

1. Inicie o Apache e o MySQL no painel do XAMPP.
2. Abra `http://localhost/phpmyadmin`.
3. Entre na aba **Importar**.
4. Selecione `database/schema.sql` e confirme a importação.

O script cria o banco configurado em `database/schema.sql`, suas tabelas e o catálogo inicial de serviços.

Em bancos existentes, importe em ordem `database/migrations/20261001_password_reset_tokens.sql`, `database/migrations/20261008_password_reset_approval.sql` e `database/migrations/20261008_security_controls.sql`.

## Executar o sistema

Na pasta do projeto, execute:

```powershell
C:\xampp\php\php.exe -S 127.0.0.1:8125 router.php
```

Depois abra:

- `http://127.0.0.1:8125/primeiro-acesso` para cadastrar o primeiro administrador.
- `http://127.0.0.1:8125/login` para entrar depois do cadastro.

## Trabalhar em mais de um computador

Antes de começar:

```powershell
git switch <branch-do-projeto>
git pull origin <branch-do-projeto>
```

Ao terminar:

```powershell
git add .
git commit -m "Descreva a alteração"
git push origin <branch-do-projeto>
```

Não envie arquivos `config/*.local.php` nem arquivos de sessão. Eles já estão protegidos pelo `.gitignore`.

## Estrutura principal

```text
assets/       estilos e scripts do navegador
config/       conexão, validações e configurações de exemplo
database/     script SQL de criação do banco
docs/         documentação do projeto
src/          classes de acesso aos dados
scripts/      manutenção de retenção e backup criptografado
storage/      diretório legado bloqueado; sessões são gravadas fora da raiz pública
tests/        testes de fumaça
views/        telas organizadas por módulo
index.php     entrada e rotas da aplicação
router.php    roteador usado pelo servidor local do PHP
```

## Hospedagem

O sistema também foi preparado para a InfinityFree. As credenciais de produção ficam somente no servidor e nunca devem ser adicionadas ao repositório.
