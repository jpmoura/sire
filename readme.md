# SiRe - Sistema de Reserva de Salas e Equipamentos

<p align="center">
  <img src="overview.gif" alt="Imagens do sistema" />
</p>

O [Sistema de Reserva de Salas e Equipamentos (SiRe)](http://200.239.152.5/reserva/public) é o sistema usado pelos
corpos acadêmico e administrativo presentes no
[Instituto de Ciências Exatas e Aplicadas (campus João Monlevade)](http://www.icea.ufop.br) da
[Universidade Federal de Ouro Preto](http://ufop.br). Essa é a segunda versão do sistema, que foi ao ar no dia
09/06/2016. A primeira versão foi ao ar em meados de fevereiro de 2012.

Dentre as motivações para tal atualização, estão:

* Atualização da lógica de processamento para a última versão do PHP (7.0);
* Atualização da interface com usuário, usando os conceitos de responsividade,
onde a mesma se adapta de acordo com o espaço de tela disponível;
* Correção de bugs da versão anterior;
* Uso da arquitetura MVC para desenvolvimento, com o objetivo de facilitar a
manutenção e atualização;
* Utilização do padrão mais recente do HTML (HTML5) de acordo com o W3C;

O sistema foi desenvolvido usando a versão 5.2 do *framework* [Laravel](https://laravel.com/docs/5.2) para aplicações
web, um dos mais usados no mercado durante o período de desenvolvimento. Uma restrição do desenvolvimento foi a
necessidade de usar o banco de dados original da primeira versão, o que limitou alguns pontos no desenvolvimento da
interface com o usuário.

## Índice

1. [Versão de Uso Geral](#versão-de-uso-geral)
2. [Funcionamento](#funcionamento)
3. [Versões de Teste](#versões-de-teste)
4. [Instalação](#instalação)
5. [Changelog](#changelog)
6. [TODO](#todo)

## Versão de Uso Geral

Existe uma versão de uso geral, que não está limitada pelos requisitos da [UFOP](http://ufop.br/), que é adaptável para
qualquer instituição que assim deseje utilizar o sistema.

Para utilizar a versão de uso geral, certifique-se de utilizar
a versão do *branch* [generico](https://github.com/jpmoura/sire/tree/generico), que é o *branch* que contém o sistema de
autenticação tradicional, baseado em dados existentes no banco de dados da aplicação.

## Funcionamento

O sistema é baseado na funcionalidade CRUD de banco de dados para a inserção, leitura, atualização e remoção de
informações de salas, equipamentos e alocações feitas.

Para o layout, foi usado como base o design
[AdminLTE](https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html) desenvolvido por
[Abdullah Almsaeed](mailto:abdullah@almsaeedstudio.com), alterando-se basicamente só a palheta de cores do tema.

O sistema é focado para uso de instituições do ramo educacional, logo, limita-se a ter somente três tipos de usuários,
sendo eles:

* Administrador;
* Professor / Técnico administrativo;
* Usuário especial.

Atualmente não está implantado uma forma de se alterar estes tipos de usuários dentro do sistema. O administrador é
responsável por fazer todo e qualquer tipo de cadastro no sistema, desde outros usuários até os recursos passíveis de
serem reservados bem como seus tipos. Essa abordagem foi escolhida devido aos requisitos da [UFOP](http://ufop.br/) para
centralização do gerenciamento e foi mantida para o sistema de uso geral.

A versão de uso geral conta com alguns dados já preenchidos no banco para o pontapé inicial do sistema. As regras de
negócio de exemplo já estão presentes assim como um usuário administrador padrão, com e-mail o ```admin@admin.com``` e
senha ```admin```.

Antes de se criar um recurso, é necessário criar tipos de recursos. Com o tipo criado, na tela de criação de recurso é
possível selecionar um tipo para o mesmo e completar sua criação.

Exite também a funcionalidade de lista de softwares, que pode ser útil para que professores e técnicos verifiquem quais
são os softwares instalados em laboratórios, facilitando a escolha de qual laboratório reservar, por exemplo.

Outra funcionalidade é o reporte de bugs, onde os usuários de todos os tipos podem detalhar algum problema que
encontrarem no sistema para que os administradores possam corrigí-los.

## Versões de Teste

Para a comodidade dos interessados em testar o sistema, existem diferentes tipos de artefatos que implementam o sistema. Nas subseções seguintes são apresentados mais detalhes sobre cada um deles.

### VM com Sistema Operacional com Interface Gráfica

Essa *Appliance* contém o sistema operacional Linux na distribuição Debian 9. Ela já está totalmente configurada e já possui todos os pré-requisitos para o funcionamento do sistema. O usuário padrão para o login no Debian é ```sire``` e a senha também ```sire```. O usuário ```root``` possui a senha ```root```. Esses usuários são de acesso do sistema operacional e não do sistema deste projeto, os usuários para acesso do SiRe estão descritos adiante.

Para acessar o sistema basta abrir o navegador e acessar o endereço [localhost/sire/index.php](http://localhost/sire/index.php). O usuário já adicionado para o login é ```admin@admin.com``` com senha ```admin```.

~~A imagem em formato OVA do sistema pode ser baixada através [desse link](https://drive.google.com/file/d/1MmTkiHrYgANk8Nyt6fynMMpjFMrRecJT/view?usp=sharing).~~

Link temporariamente indisponível por falta de hospedagem para o arquivo que tem aproximadamente 7GB.

### VM somente com o essencial, sem interface gráfica

O link para download é [este](https://drive.google.com/file/d/1OXE5AT-pJcuZGq18ADcZGtAdjQidr63q/view?usp=sharing) e, após fazer a importação da imagem no seu gerenciador, confira o IP atribuído a máquina criada e acesse o sistema usando o IP da máquina na rede com o sufixo `/sire/index.php`. Por exemplo, se o IP gerado for `192.168.2.2` você deverá acessar o endereço `http://192.168.2.2/sire/index.php`.

A imagem foi gerada a partir do Ubuntu Server 22.04 e caso seja necessário realizar o login no próprio Ubuntu o usuário é `sire` e a senha é `admin`.

**IMPORTANTE**: O sistema está com a flag de debug ativa, esta é uma imagem criada apenas para testes, nenhuma configuração foi adotada envolvendo segurança do host e da própria máquina virtual.

### :construction: Container (Docker)

Em desenvolvimento.

## Instalação

É valido lembrar que todos os pré-requisitos do [Laravel](https://laravel.com/docs/5.2) são também pré-requisitos
deste sistema.

Para a instalação é necessário ter previamente instalados o gerenciador de dependências
[Composer](https://getcomposer.org/), [Node.js](https://nodejs.org/) entre as versões 0.12 e 6.9.4 e também o
[Gulp.js](http://gulpjs.com/) instalado globalmente através do [Node.js](https://nodejs.org/). Com todas essas três
dependências instaladas, executam-se os seguintes comandos:

```bash
composer install
npm install
gulp --prod
php artisan migrate
php artisan db:seed
```

Enquanto o comando ```php artisan migrate``` cria as tabelas no banco de dados, o comando ```php artisan db:seed``` é o
comando que preenche as tabelas de usuário e de regras com alguns dados padrões que possibilitam o uso do sistema sem a
necessidade de inserir dados no banco por aplicações de terceiros, assim o administrador já pode utilizar o sistema
usando as credenciais padrão de e-mail e senha no login. Tais credenciais são:

* E-mail: admin@admin.com
* Senha: admin

Para usuários de sistemas UNIX, será necessário conceder permissão de leitura, gravação e execução da pasta em que se
encontra o sistema para o grupo *www-data* que pode ser dado pelo seguinte comando usando a permissão de administrador:

```bash
chown -R USUARIO:www-data PASTA
```

Basta usar o comando ```sudo``` ou ```su``` dependendo da distribuição *Linux* juntamente com este comando.

É necessário configurar as variáveis de ambiente do Laravel a partir do arquivo sem nome na raiz do projeto mas de
extensão ```ENV```. Existe um arquivo de exemplo [aqui](./.env.example) que pode ser editado e depois renomeado
apropriadamente apenas para ```.env```, onde nele devem-se encontrar todas as configurações do banco de dados.

## Changelog

Esse changelog está organizado na ordem de mais recente para o mais antigo, ou seja, a versão mais nova aparece como
primeira subseção e a versão mais antiga como a última subseção.

Versões terminadas com o carácter ```g``` refere-se ao *branch* ```generico```, para uso geral. O changelog das versões
específicas para a [UFOP](http://ufop.br/) estão mantidas com o objetivo de se manter dados históricos sobre a evolução
do sistema.

### Versão 1.0g

* Remoção do Login por LDAPI usando dados da UFOP por login tradicional baseado em tabela de usuários para aplicação
geral;
* Adição de testes par CRUD de usuário;
* Remoção de modelos de usuários e reservas legados;
* Uso de SASS para processamento de CSS;

### Versão 2.3.1

* Adição de testes de unidade;
* Adição de funcionalidade de softwares instalados em recursos de informática;
* Adição de funcionalidade de adição, remoção e edição de tipos de recursos;
* Adição de migrations;
* Refatoração de views, modularizando várias delas;
* Refatoração no nomes de rotas;
* Correção de bugs;

### Versão 2.3

* Refatoração de modelos e controllers;
* Adição de validação de formulários no back-end;
* Otimização da estrutura do banco de dados;
* Atualização da biblioteca [Chart.js](https://github.com/chartjs/Chart.js) para geração de gráficos;
* Adicionada obrigatoriedade do uso de HTTPS;
* Atualização da LDAPI para comunicação em HTTPS com certificados auto-assinados;
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

* Possibilidade de mudança de senha do usuário;
* Horários agora estão definidos e não são mais uma referência genérica de ordem;
* Página de visualização do quadro de alocação agora possui um botão de voltar;
* Os quadros de turnos agora podem ser expandidos e minimizados clicando também
sobre o nome do turno.

## Erros conhecidos

* ~~Uso do sistema em navegadores Safari para iOS em modo privativo pode
ocasionar problemas no momento de alocação;~~
* Tabela de usuários não é mostrada apropriadamente em navegadores Safari;
* Erros de disponibilidade do banco de dados não estão devidamente tratados;
* Horários podem se sobrepor entre turnos (*overlapping*).

## TODO

* Criar testes automatizados mais detalhados;
* Criar testes para o modelo de Reserva;
* Tratar para que caso altere o horário de início de cada turno para que o último horário do turno não sobreponha o início do próximo turno (*overlapping*).
* ~~Refatoração no nomes de rotas fora do padrão do Laravel~~;
* ~~Tratar erro de mesclagem de arquivos CSS do Bootstrap e Font Awesome~~;
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
