# SiRe - Sistema de Reserva de Salas e Equipamentos

<p class="text-center">
  ![Pré-visualização SiRe](./overview.gif "Pré-visualização SiRe")
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
desenvolvimento. Uma restrissão do desenvolvimento foi a necessidade de usar o
banco de dados original da primeira versão, o que limitou alguns pontos no
desenvolvimento da interface com o usuário.

## Funcionamento
O sistema é baseado na funcionalidade CRUD de banco de dados para a inserção,
leitura, atualização e remoção de informações de usuários, salas/equipamentos e
alocações feitas. Não foi usado modelos de dados tendo em vista as alterações
que estão programadas, onde a tabela de usuários será refeita para a utilização
da autenticação única via LDAP a partir do sistema [MinhaUFOP](http://www.minha.ufop.br/)

Para autenticação, também não foi utilizado o *middleware* de autenticação nativo
do Laravel também devido as mudanças que virão, sendo assim, toda autenticação
foi feita "manualmente", através de consultas SQL e utilização de variáveis
de sessão através provedor de serviço [Session](https://laravel.com/docs/5.2/session), nativo do [Laravel](https://laravel.com/).

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

A estrutura do banco de dados usada pelo sistema pode ser criada a partir do
script SQL encontrado [aqui](./DUMP_bdreserva.sql). Além disso é necessário configurar as variáveis
de ambiente do Laravel a partir do arquivo na raiz do projeto sem nome mas de
extensão ENV. Existe um arquivo de exemplo [aqui](./.env.example) que pode ser editado e depois
renomeado apropriadamente apenas para .env onde nele deve-se encontrar o
endereço, senha, usuário e nome da base do banco de dados.

## TODO

* Otimização da estrutura do banco de dados;
* Autenticação LDAP via [MinhaUFOP](http://www.minha.ufop.br/);
* Validade de credenciais, para uso de professores substitutos e visitantes;
