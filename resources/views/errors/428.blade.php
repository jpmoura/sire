@extends('layout.base')

@section('title')
 Erro 428
@endsection

@section('page_icon')
    <i class="fa fa-times"></i>
@endsection

@section('description')
    Ocorreu um erro do tipo 428
@endsection

@section('content')
  <div class="row">
    <div class="error-page">
      <h2 class="headline text-yellow">428</h2>
      <br />
      <div class="error-content">
        <h3><i class="fa fa-warning text-yellow"></i> Precondição falhou!</h3>

        <p>
          Você está tentando executar uma ação em que é necessária uma precondição específica e que não foi
          enviada na requisição. Provavelmente seu navegador tentou restaurar a página para um estado inválido.
        </p>

        <p>
          Para evitar esse erro, <span class="text-bold">sempre</span> realize o logout.
        </p>
      </div>
    </div>
  </div>
@endsection
