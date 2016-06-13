@extends('admin.admin_base')

@section('content')
  <div class="row">
    <div class="error-page">
      <h2 class="headline text-red">403</h2>
      <br />
      <div class="error-content">
        <h3><i class="fa fa-warning text-red"></i> Permissão insuficiente</h3>

        <p>
          Você não tem as permissões necessárias para executar essa ação.
          Por gentileza, volte para a página <a href="{{url('/')}}">inicial</a> ou voltar para a página <a href="javascript:history.back()">anterior</a> em que você estava.
        </p>
    </div>
  </div>

@endsection
