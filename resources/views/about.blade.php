@extends('admin.admin_base')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <img src="{{asset('/img/stackholders.png')}}" alt="Stackholders do Sistema" class="center-block img-responsive"/>
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
        <section id="modificacoes">
          <h3 class="text-center">Mudanças na Versão 2.1</h3>
          <ul>
            <li>Adicionado método de login usando dados do <a target="_blank" href="http://www.minha.ufop.br/"><i class="fa fa-home"></i> Minha UFOP</a>;</li>
            <li>Criptografia dos arquivos de sessões e alterado o tempo de vida para 30 minutos (eram 120);</li>
            <li>Adicionado mais um tipo de usuário: Usuário Especial. Necessário caso o novo usuário não pertença a nenhum grupo do campus;</li>
            <li>Adicionado persistência local de dados do usuário após o primeiro login;</li>
            <li>Adicionado possiblidade de qualquer usuário reportar um bug no sistema;</li>
            <li>Correção de bugs;</li>
            <li>Retirada de arquivos desnecessários para funcionamento do sistema;</li>
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
          <li><del>Alterar o motor de login para utilizar um login único com base no sistema <a target="_blank" href="http://www.minha.ufop.br/"><i class="fa fa-home"></i> Minha UFOP</a>;</del></li>
          <li>Adicionar configurações do servidor LDAP em uma tabela do banco de dados para evitar expor os dados no código-fonte;</li>
          <li>Otimizar as tabelas do banco de dados;</li>
          <li>Otimizar carregamento de objetos javascript e CSS usando SASS ou LESS;</li>
          <li>Adicionar uma tabela de horários com a finalidade de fixar os <em>slots</em> de cada horário;</li>
          <li>Criar atalho para reservas "favoritas" (Laboratório, dia da semana e horários);</li>
          <li>Tratar para que caso altere o horário de início de cada turno para que o último horário do turno não sobreponha o início do próximo turno.</li>
        </ul>
      </p>
    </div>
  </div>
@endsection
