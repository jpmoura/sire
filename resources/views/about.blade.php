@extends('layout.base')

@section('title')
    Sobre
@endsection

@section('page_icon')
    <i class="fa fa-question"></i>
@endsection

@section('description')
    Aqui estão algumas informações sobre o sistema.
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <img src="{{asset('public/img/stackholders.png')}}" alt="Stackholders do Sistema" class="center-block img-responsive"/>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <p class="text-justify">
                O Sistema de Reserva de Salas e Equipamentos é o sistema da <a target="_blank" href="http://ufop.br">Universidade Federal de Ouro Preto</a> do
                <a taget="_blank" href="http://www.icea.ufop.br/site/"><em>campus</em> João Monlevade</a> usado por professores e corpo administrativo para realizar a alocação dos recursos
                existentes de acordo com as datas e horários disponíveis.
                <br />
                O novo sistema foi refeito pelo bolsista <a target="_black" href="https://github.com/jpmoura">João Pedro Santos de Moura</a>  devido a necessidade de se atualizar tanto a interface com o usuário quanto as ferramentas
                que davam suporte ao funcionamento do sistema. Um dos objetivos do sistema era atualizar as ferramentas sem comprometer a estrutura já existente do
                banco de dados, que contém todo o histórico de alocação
                <br>
                Essa é uma versão de uso geral, onde a versão original foi adaptada para que pudesse ser utilizada por qualquer instituição do ramo educacional que deseja possuir um sistem simples para reserva
                de seus recursos, sejam eles de qualquer tipo.
                <br>
                As versões terminadas com o caracter <span class="text-bold">G</span> se refere a versões de uso geral. As modificações das versão específicas para a <a target="_blank" href="http://ufop.br">UFOP</a>
                são mantidas com o objetivo de registrar historicamente a evolução do sistema.
                <section id="modificacoes">
                    <h3 class="text-center">Mudanças na Versão 1.0g</h3>
                    <ul>
                        <li>Remoção do Login por LDAPI usando dados da UFOP por login tradicional baseado em tabela de usuários para aplicação geral;</li>
                        <li>Adição de testes par CRUD de usuário;</li>
                        <li>Remoção de modelos de usuários e reservas legados;</li>
                        <li>Uso de SASS para processamento de CSS.</li>
                    </ul>

                    <h3 class="text-center">Mudanças na Versão 2.3</h3>
                    <ul>
                        <li>Refatoração de modelos e controllers;</li>
                        <li>Adição de validação de formulários no back-end;</li>
                        <li>Otimização da estrutura do banco de dados;</li>
                        <li>Atualização da biblioteca <a href="https://github.com/chartjs/Chart.js" target="_blank">Chart.js</a> para geração de gráficos;</li>
                        <li>Adicionada obrigatoriedade do uso de HTTPS;</li>
                        <li>Atualização da LDAPI para comunicação em HTTPS com certificados auto-assindados;</li>
                        <li>Correção de bugs.</li>
                    </ul>
                    <h3 class="text-center">Mudanças na Versão 2.2</h3>
                    <ul>
                        <li>Refatoração massiva de toda a estrutura do back-end;</li>
                        <li>Mudança no sistema de autenticação, usando a autenticação nativa do framework aliada com a API de autenticação <a href="https://github.com/jpmoura/ldapi" target="_blank">LDAPI</a>.
                            Agora também é possível o usuários optar por ser lembrado e assim o login é renovado automaticamente;
                        </li>
                        <li>Adicionado compactação, mesclagem e otimização dos arquivos CSS e JavaScript;</li>
                        <li>Melhoria no sistema de Log, agora registrando informações mais estruturadas e sendo feito através de eventos;</li>
                        <li>Alteração em todo sistema de rotas, usando grupos e middlewares;</li>
                        <li>Migração para o uso de modelos ao invés de execução de queries, atingindo assim o padrão MVC;</li>
                        <li>Mudança na organização dos arquivos das Views para um padrão semelhante de outros frameworks.</li>
                    </ul>

                    <h3 class="text-center">Mudanças na Versão 2.1.1</h3>
                    <ul>
                        <li>Adicionada restrição de alocações para usuários ordinários. Agora somente administradores podem alocar mais de um recurso no mesmo horário e dia;</li>
                        <li>Alterada o local onde o sistema é servido;</li>
                        <li>Correção dos caminhos dos arquivos CSS e Javascript;</li>
                        <li>Correção de erro de usuário tentar executar qualquer ação com <em>token</em> de sessão expirado.</li>
                    </ul>

                    <h3 class="text-center">Mudanças na Versão 2.1</h3>
                    <ul>
                        <li>Adicionado método de login usando dados do <a target="_blank" href="http://www.minha.ufop.br/"><i class="fa fa-home"></i> Minha UFOP</a>;</li>
                        <li>Adicionado suporte para <em>login</em> via <a target="_blank" href="http://200.239.152.5/meuicea/public"><i class="fa fa-building-o"></i> Meu ICEA</a> automaticamente, usando a mesma sessão;</li>
                        <li>Criptografia dos arquivos de sessões e alterado o tempo de vida para 30 minutos (eram 120);</li>
                        <li>Adicionado mais um tipo de usuário: Usuário Especial. Necessário caso o novo usuário não pertença a nenhum grupo do campus;</li>
                        <li>Adicionado persistência local de dados do usuário após o primeiro login;</li>
                        <li>Adicionado possiblidade de qualquer usuário reportar um bug no sistema;</li>
                        <li>Correção de bugs;</li>
                        <li>Retirada de arquivos desnecessários para funcionamento do sistema;</li>
                        <li>Adicionada opção ao administradores para visualizar as reservas de um recurso em um determinado dia;</li>
                        <li>Adicionado uma pré-visualização dos dados no momento do cadastro para confirmação.</li>
                    </ul>

                    <h3 class="text-center">Mudanças na Versão 2.0.1</h3>
                    <ul>
                        <li>Possibilidade de mundaça de senha do usuário;</li>
                        <li>Horários agora estão definidos e não são mais uma referência genérica de ordem;</li>
                        <li>Página de visualização do quadro de alocação agora possui um botão de voltar;</li>
                        <li>Os quadros de turnos agora podem ser expandidos e minizados clicando também sobre o nome do turno.</li>
                    </ul>

                    <h3 class="text-center">Principais novidades na versão 2.0</h3>
                    <ul>
                        <li>Remodelamento da interface com o usuário, com o objetivo de facilitar o processo de alocação, tornando-o mais intuitivo;</li>
                        <li>Uso do conceito de reponsividade na interface, sendo que a mesma se adapta os dispositivo do usuário sem comprometer sua usabilidade;</li>
                        <li>Atualização do PHP para a versão 7.0, aumentando a velocidade de execução do sistema;</li>
                        <li>Uso do <em>framework</em> <a target="_blank" href="https://laravel.com/">Laravel</a>, um dos <em>frameworks</em> mais famosos no período em que o sistema foi desenvolvido</li>
                        <li>Uso da arquitetura MVC para desenvolvimento, com o objetivo de facilitar a manutenção e atualização;</li>
                        <li>Utilização do padrão mais recente do HTML de acordo com o <a target="_blank" href="https://www.w3.org/html/">W3C</a>.</li>
                    </ul>
                </section>
                <h3 class="text-center">A Fazer</h3>
                <ul>
                    <li>Criar testes automatizados mais detalhados;</li>
                    <li>Tratar para que caso altere o horário de início de cada turno para que o último horário do turno não sobreponha o início do próximo turno.</li>
                    <li>Criar testes para o modelo Reserva;</li>
                    <li><del>Refatoração no nomes de rotas fora do padrão do Laravel;</del></li>
                    <li><del>Tratar erro de mesclagem de arquivos CSS do Bootstrap e Font Awesome;</del></li>
                    <li><del>Alterar o motor de login para utilizar um login único com base no sistema <a target="_blank" href="http://www.minha.ufop.br/"><i class="fa fa-home"></i> Minha UFOP</a>;</del></li>
                    <li><del>Adicionar configurações do servidor LDAP em uma tabela do banco de dados para evitar expor os dados no código-fonte;</del></li>
                    <li><del>Adicionar uma tabela de horários com a finalidade de fixar os <em>slots</em> de cada horário;</del></li>
                    <li><del>Utilizar o <em>eloquent</em> para evitar uso de intensivo da classe DB;</del></li>
                    <li><del>Capturar exceções de erro de conexão com o banco de dados;</del></li>
                    <li><del>Otimizar carregamento de objetos javascript e CSS usando SASS ou LESS;</del></li>
                    <li><del>Otimizar as tabelas do banco de dados;</del></li>
                    <li><del>Criar atalho para reservas "favoritas" (Laboratório, dia da semana e horários);</del></li>
                </ul>
            </p>
        </div>
    </div>
@endsection
