# SiRe - Sistema de Reserva de Salas e Equipamentos

<p align="center">
  <img src="overview.gif" alt="Imagens do sistemas" />
</p>

O [Sistema de Reserva de Salas e Equipamentos (SiRe)](http://200.239.152.5/reserva/public)
é o sistema usado pelos corpos acadêmico e administrativo presentes no
[Instituto de Ciências Exatas e Aplicadas (campus João Monlevade)](http://www.icea.ufop.br)
da [Universidade Federal de Ouro Preto](http://ufop.br). Essa é a segunda versão
do sistema, que foi ao ar no dia 09/06/2016. A primeira versão foi ao ar em
meados de fevereiro de 2012.

Dentre as motivações para tal atualização, estão:
* Atualização da lógica de processamento para a última versão do PHP (7.0);
* Atualização da interface com usuário, usando os conceitos de responsividade,
onde a mesma se adapta de acordo com o espaço de tela disponível;
* Correção de bugs da versão anterior;
* Uso da arquitetura MVC para desenvolvimento, com o objetivo de facilitar a
manutenção e atualização;
* Utilização do padrão mais recente do HTML (HTML5) de acordo com o W3C;

O sistema foi desenvolvido usando a versão 5.2 do *framework* [Laravel](https://laravel.com/)
para aplicações web, um dos mais usados no mercado durante o período de
desenvolvimento. Uma restrição do desenvolvimento foi a necessidade de usar o
banco de dados original da primeira versão, o que limitou alguns pontos no
desenvolvimento da interface com o usuário.

## Funcionamento
O sistema é baseado na funcionalidade CRUD de banco de dados para a inserção,
leitura, atualização e remoção de informações de salas, equipamentos e
alocações feitas.

Para autenticação foi usado a mesma base de dados LDAP utilizada pelo sistema
[Minha UFOP](http://www.minha.ufop.br), facilitando o uso para o usuário fazendo
com que ele não precise de um *login* e senha específicos para utilizar o sistema.

Para o layout, foi usado como base o design [AdminLTE](https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html)
desenvolvido por [Abdullah Almsaeed](mailto:abdullah@almsaeedstudio.com),
alterando-se basicamente só a palheta de cores do tema.

## Instalação
Para a instalação é necessário ter previamente instalados o gerenciador de dependências [Composer](https://getcomposer.org/)
e a o [Node.js](https://nodejs.org/) entre as versões 0.12 e 6.9.4 e também o
[Gulp.js](http://gulpjs.com/) instalado globalmente através do NPM do Node.js. Com todas essas três dependências instaladas,
executam-se os seguintes comandos:

```bash
$ composer install
$ npm install
$ gulp --prod
```

Para usuários de sistemas UNIX, será necessário conceder permissão de leitura,
gravação e execução da pasta em que se encontra o sistema para o grupo
*www-data* que pode ser dado pelo seguinte comando usando a permissão de
administrador:

```bash
$ chown -R USUARIO:www-data PASTA
```

Basta usar o comando ```sudo``` ou ```su``` dependendo da distribuição *Linux*
juntamente com este comando.

É necessário configurar as variáveis de ambiente do Laravel a partir do arquivo na raiz do
projeto sem nome mas de extensão ENV. Existe um arquivo de exemplo
[aqui](./.env.example) que pode ser editado e depois renomeado apropriadamente
apenas para .env onde nele deve-se encontrar todas as configurações do banco de dados e da
[LDAPI](https://github.com/jpmoura/ldapi).

## Changelog

### Versão 2.3

* Refatoração de modelos e controllers; 
* Adição de validação de formulários no back-end;
* Otimização da estrutura do banco de dados;
* Atualização da biblioteca [Chart.js](https://github.com/chartjs/Chart.js) para geração de gráficos;
* Adicionada obrigatoriedade do uso de HTTPS;
* Atualização da LDAPI para comunicação em HTTPS com certificados auto-assindados;
* Correção de bugs.

### Versão 2.2

* Refatoração massiva de toda a estrutura do back-end;
* Mudança no sistema de autenticação, usando a autenticação nativa do framework aliada com a API de autenticação
[LDAPI](https://github.com/jpmoura/ldapi). Agora também é possível o usuários optar por ser lembrado e assim o login é
renovado automaticamente;
* Melhoria no sistema de Log, agora registrando informações mais estruturadas e sendo feito através de eventos;
* Alteração em todo sistema de rotas, usando grupos e middlewares;
* Migração para o uso de modelos ao invés de execução de queries, atingindo assim o padrão MVC;
* Mudança na organização dos arquivos das Views para um padrão semelhante de outros frameworks.

### Versão 2.1.1

* Adicionada restrição de alocações para usuários ordinários. Agora somente
administradores podem alocar mais de um recurso no mesmo horário e dia;
* Alterada o local onde o sistema é servido;
* Correção dos caminhos dos arquivos CSS e Javascript;
* Correção de erro de usuário tentar executar qualquer ação com *token* de
sessão expirado.

### Versão 2.1

* Adicionado método de *login* usando dados do [Minha UFOP](http://www.minha.ufop.br/);
* Adicionado suporte para *login* via
[Meu ICEA](http://200.239.152.5/meuicea/public) automaticamente, usando a mesma
sessão;
* Criptografia dos arquivos de sessões e alterado o tempo de vida para 30
minutos (eram 120);
* Adicionado mais um tipo de usuário: Usuário Especial. Necessário caso o novo
usuário não pertença a nenhum grupo do campus;
* Adicionado persistência local de dados do usuário após o primeiro *login*;
* Correção de bugs;
* Adicionada opção para reportar de bugs para usuários comuns e visualizar os
reportes para administradores;
* Retirada de arquivos desnecessários;
* Adicionada opção ao administradores para visualizar as reservas de um recurso
em um determinado dia;
* Adicionado uma pré-visualização dos dados no momento do cadastro para
confirmação.

### Versão 2.0.1

* Possibilidade de mundaça de senha do usuário;
* Horários agora estão definidos e não são mais uma referência genérica de ordem;
* Página de visualização do quadro de alocação agora possui um botão de voltar;
* Os quadros de turnos agora podem ser expandidos e minizados clicando também
sobre o nome do turno.

## Erros conhecidos

* ~~Uso do sistema em navegadores Safari para iOS em modo privativo pode
ocasionar problemas no momento de alocação;~~
* Tabela de usuários não é mostrada apropriadamente em navegadores Safari;
* Erros de disponibilidade do banco de dados não estão devidamente tratados;
* Horários podem se sobrepor entre turnos (*overlapping*).

## TODO

* ~~Autenticação LDAP via [Minha UFOP](http://www.minha.ufop.br/);~~
* ~~Adicionar configurações do servidor LDAP em uma tabela do banco de dados
para evitar expor os dados no código-fonte;~~
* ~~Adicionar uma tabela de horários com a finalidade de fixar os <em>slots</em>
de cada horário;~~
* ~~Capturar exceções de erro de conexão com o banco de dados;~~
* ~~Utilizar a ferramenta *eloquent* do [Laravel](http://laravel.com) para
reforçar o padrão MVC;~~
* ~~Otimização do carregamento dos elementos CSS e Javascript usando Gulp
juntamente com SASS ou LESS;~~
* ~~Otimização da estrutura do banco de dados;~~
* ~~Criar atalho para reservas "favoritas" (Laboratório, dia da semana e horários);~~
* Criar testes automatizados;
* Tratar erro de mesclagem de arquivos CSS do Bootstrap e Font Awesome;
* Tratar para que caso altere o horário de início de cada turno para que o
último horário do turno não sobreponha o início do próximo turno (*overlapping*).
