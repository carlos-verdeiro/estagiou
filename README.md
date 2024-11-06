# Estagiou

Um sistema para facilitar a gestão de vagas e candidatos para estágios, voltado para empresas e candidatos. O objetivo do **Estagiou** é proporcionar uma plataforma eficiente para publicação de vagas e gestão de candidaturas.

## Funcionalidades

- **Cadastro e login de usuários**: Empresas e candidatos podem se cadastrar e fazer login.
- **Publicação de vagas**: Empresas podem criar, editar e excluir vagas de estágio.
- **Candidatura de estagiários**: Candidatos podem visualizar vagas e se candidatar diretamente na plataforma.
- **Gestão de candidaturas**: Empresas podem acessar uma lista dos candidatos aplicados a cada vaga.

## Tecnologias Utilizadas

- **Backend**: PHP com integração ao banco de dados via `mysqli`.
- **Frontend**: Bootstrap para estilização responsiva e jQuery com AJAX para comunicação com o servidor.
- **Banco de Dados**: MySQL
- **Envio de e-mails**: PHPMailer para redefinição de senha.

## Estrutura de Arquivos

estagiou/  
├── assets/                   
├── dashboard/             
├── public/                   
├── server/                    
│   ├── api/                   
│   ├── curriculos/            
│   ├── conexao.php           
│   └── estagiou.sql           
├── .htaccess                   
├── Normas.docx                
├── esqueci_senha.php          
├── index.php                  
├── LICENSE                    
└── README.md                  

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/carlos-verdeiro/estagiou.git
   ```
2. Configure o banco de dados MySQL e atualize as credenciais em `conexao.php`.
3. Execute o servidor e acesse a aplicação em seu navegador.

## Contribuição

Sinta-se à vontade para contribuir com sugestões, melhorias ou correções. Para isso:

1. Faça um fork do projeto.
2. Crie uma nova branch para sua feature ou correção.
3. Envie um pull request.
