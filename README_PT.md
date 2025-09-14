# Bot Telegram para Reconhecimento Musical

Este bot Telegram pode identificar música dos Reels do Instagram. Os usuários podem enviar links dos Reels do Instagram e o bot identificará o nome da música e o artista.

## Características

- 🎵 Reconhecimento musical dos Reels do Instagram
- 🎤 Mostrar nome do artista e da música
- 💿 Mostrar informações do álbum (se disponível)
- 📅 Mostrar ano de lançamento
- 🎯 Mostrar percentual de confiança
- 💾 Salvar histórico no banco de dados
- 🔒 Alta segurança e proteção de dados

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- FFmpeg (para extrair áudio do vídeo)
- Extensões PHP: curl, json, pdo, pdo_mysql
- Certificado SSL (para webhook)

## Instalação

### 1. Fazer Upload dos Arquivos

Faça upload de todos os arquivos do projeto para seu host cPanel.

### 2. Executar Instalação

Execute `install.php` em seu navegador para verificar os requisitos.

### 3. Configurar Banco de Dados

1. Criar banco de dados MySQL
2. Editar `config.php` e inserir informações do banco de dados

### 4. Criar Bot Telegram

1. Conversar com [@BotFather](https://t.me/botfather) no Telegram
2. Enviar comando `/newbot`
3. Escolher nome do bot e username
4. Copiar token do bot
5. Inserir token em `config.php`

### 5. Configurar APIs

#### Instagram Basic Display API
1. Ir para [Facebook Developers](https://developers.facebook.com/)
2. Criar nova aplicação
3. Adicionar Instagram Basic Display
4. Obter chave API

#### ACRCloud API (Reconhecimento Musical)
1. Ir para [ACRCloud](https://www.acrcloud.com/)
2. Criar conta
3. Obter chave API

### 6. Configurar Webhook

Executar `setup.php`:

```
https://yourdomain.com/setup.php?password=your_admin_password
```

### 7. Testar Bot

Executar `test.php`:

```
https://yourdomain.com/test.php?password=your_admin_password
```

## Uso

1. Encontrar o bot no Telegram
2. Enviar comando `/start`
3. Enviar link dos Reels do Instagram
4. Aguardar identificação musical

## Estrutura de Arquivos

```
/
├── config.php              # Configuração principal
├── database.php            # Classe do banco de dados
├── instagram_handler.php   # Processamento do Instagram
├── music_recognizer.php    # Reconhecimento musical
├── telegram_bot.php        # Classe do bot Telegram
├── webhook.php            # Manipulador webhook
├── setup.php              # Configuração
├── test.php               # Testes do bot
├── install.php            # Instalação
├── index.php              # Página principal
└── README.md              # Documentação
```

## APIs Suportadas

### Reconhecimento Musical
- **ACRCloud**: Serviço principal de reconhecimento musical
- **Shazam**: Alternativa ao ACRCloud

### Instagram
- **Instagram Basic Display API**: Acesso ao conteúdo do Instagram

## Configurações Avançadas

### Limites de Arquivos
No arquivo `.htaccess`:
```apache
php_value upload_max_filesize 50M
php_value post_max_size 50M
php_value max_execution_time 300
php_value memory_limit 256M
```

### Segurança
- Proteger `config.php` do acesso público
- Usar certificado SSL válido
- Escolher senhas fortes

## Solução de Problemas

### Problemas Comuns

1. **Erro de Conexão com Banco de Dados**
   - Verificar informações do banco de dados
   - Garantir que o banco de dados foi criado

2. **Erro FFmpeg**
   - Instalar FFmpeg
   - Definir caminho do FFmpeg no código

3. **Erro de API**
   - Verificar chaves API
   - Considerar limites da API

4. **Erro de Webhook**
   - Verificar certificado SSL
   - Definir URL do webhook correta

## Suporte

Para suporte e relatórios de bugs, entre em contato com o desenvolvedor.

## Licença

Este projeto está licenciado sob a Licença MIT.