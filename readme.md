# SiRe - Sistema de Reserva de Salas e Equipamentos

![](https://github.com/jpmoura/sire-icea-ufop/blob/master/.overview.gif)

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
desenvolvimento. Uma restrissão do desenvolvimento foi a necessidade de usar o
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
Para instalação é necessário ter o gerenciado de dependências composer instalado,
e a partir dele usar o comando de instalação:

```bash
composer install
composer update
```

Para usuários de sistemas UNIX, será necessário conceder permissão de leitura,
gravação e execução da pasta em que se encontra o sistema para o grupo
*www-data* que pode ser dado pelo seguinte comando usando a permissão de
administrador:

```bash
chown -R www-data:USUARIO PASTA
```

Basta usar o comando *sudo* ou *su* dependendo da distribuição *Linux*
juntamente com este comando.

A estrutura do banco de dados usada pelo sistema pode ser criada a partir do
script SQL encontrado [aqui](./DUMP_bdreserva.sql). Além disso é necessário configurar as variáveis
de ambiente do Laravel a partir do arquivo na raiz do projeto sem nome mas de
extensão ENV. Existe um arquivo de exemplo [aqui](./.env.example) que pode ser editado e depois
renomeado apropriadamente apenas para .env onde nele deve-se encontrar o
endereço, senha, usuário e nome da base do banco de dados.

## Changelog

### Versão 2.1

* Adicionado método de *login* usando dados do [Minha UFOP](http://www.minha.ufop.br/);
* Adicionado suporte para *login* via [Meu ICEA](http://200.239.152.5/meuicea/public) automaticamente, usando a mesma sessão;
* Criptografia dos arquivos de sessões e alterado o tempo de vida para 30 minutos (eram 120);
* Adicionado mais um tipo de usuário: Usuário Especial. Necessário caso o novo usuário não pertença a nenhum grupo do campus;
* Adicionado persistência local de dados do usuário após o primeiro *login*;
* Correção de bugs;
* Adicionada opção para reportar de bugs para usuários comuns e visualizar os reportes para administradores;
* Retirada de arquivos desnecessários;
* Adicionado uma pré-visualização dos dados no momento do cadastro para confirmação.

### Versão 2.0.1

* Possibilidade de mundaça de senha do usuário;
* Horários agora estão definidos e não são mais uma referência genérica de ordem;
* Página de visualização do quadro de alocação agora possui um botão de voltar;
* Os quadros de turnos agora podem ser expandidos e minizados clicando também sobre o nome do turno.

## Erros conhecidos

* ~~Uso do sistema em navegadores Safari para iOS em modo privativo pode ocasionar problemas no momento de alocação;~~
* Tabela de usuários não é mostrada apropriadamente em navegadores Safari;
* Em Safari para plataforma Windows, o redimensionamento da imagem do usuário
não acontece de maneira correta;
* Erros de disponibilidade do banco de dados não estão devidamente tratados;
* Horários podem se sobrepor entre turnos.

## TODO

* ~~Autenticação LDAP via [Minha UFOP](http://www.minha.ufop.br/);~~
* ~~Adicionar configurações do servidor LDAP em uma tabela do banco de dados para evitar expor os dados no código-fonte;~~
* Utilizar a ferramenta *eloquent* do [Laravel](http://laravel.com) para reforçar o padrão MVC;
* Otimização da estrutura do banco de dados;
* Adicionar uma tabela de horários com a finalidade de fixar os <em>slots</em> de cada horário;
* Tratar para que caso altere o horário de início de cada turno para que o último horário do turno não sobreponha o início do próximo turno;
* Criar atalho para reservas "favoritas" (Laboratório, dia da semana e horários);
* Otimização do carregamento dos elementos CSS e Javascript usando Gulp juntamente com SASS ou LESS.
