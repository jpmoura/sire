@extends('admin.admin_base')

@section('content')
  <div class="row">
    <div class="error-page">
      <h2 class="headline text-yellow">413</h2>
      <br />
      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Sua Sessão expirou!</h3>

        <p>
          Você está tentando executar uma ação com sua sessão expirada. Efetue
          o logout e então refaça o login para renovar a sessão e poder realizar a ação.
        </p>

        <p>
          Para evitar esse erro, <span class="text-bold">sempre</span> realize o logout.
        </p>
      </div>
    </div>
  </div>
@endsection
