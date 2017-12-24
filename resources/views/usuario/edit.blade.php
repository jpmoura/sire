@extends('layout.base')

@section('title')
    Editar usuário {!! $usuario->nome !!}
@endsection

@section('page_icon')
    <i class="fa fa-pencil-square-o"></i>
@endsection

@section('description')
    Altere os capos para editar as informações sobre o usuário.
@endsection

@push('extra-js')
    <script>
        function submitDeleteForm() {
            var destroyForm = document.getElementById("destroy");
            destroyForm.submit();
        }
    </script>
@endpush

@section('content')
    <div class='row'>
        <div class='col-md-8 col-md-offset-2'>
            <div class="box box-primary-ufop">
                <div class="box-body">
                    <form class="form" action="{{ route('usuario.update', $usuario) }}" accept-charset="UTF-8" method="post">
                        <p class="text-info text-center">Para alterar a senha preencha os campos correspondentes. Caso contrário, deixe os campos em branco.</p>
                        {{ method_field('PATCH') }}

                        @include('usuario.form')

                        <br />

                        <div class="text-center">
                            <button type="button" class="btn btn-warning" onClick="history.back()">Cancelar <i class='fa fa-times'></i></button>
                            {{-- Um administrador não pode se excluir enquanto logado no sistema --}}
                            @if($usuario->status != 0 && $usuario->id != auth()->id())
                                <button type="button" class="btn btn-danger" style="color: white" onclick="submitDeleteForm()">Excluir <i class="fa fa-trash"></i></button>
                            @endif
                            <button type="submit" class="btn btn-success">Confirmar <i class='fa fa-check'></i></button>
                        </div>
                    </form>

                    {{-- Um administrador não pode se excluir enquanto logado no sistema --}}
                    @if($usuario->status != 0 && $usuario->id != auth()->id())
                        <div class="text-center">
                            <form id="destroy" action="{{ route('usuario.destroy', $usuario) }}" method="post" class="form-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection
