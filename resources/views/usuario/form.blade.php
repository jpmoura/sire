{{ csrf_field() }}

<div class="form-group {{ $errors->has('nome') ? ' has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-user"></i></span>
        <input class="form-control" name="nome" maxlength="255" type="text" placeholder="Nome do usuário"
               value="@if($errors->has('nome')) {{ old('nome') }}@elseif(Route::is('usuario.edit')){{ $usuario->nome }}@endif" required>
    </div>
    @if($errors->has('nome'))
        <p class="help-block">{!! $errors->first('nome') !!}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
    <div class="input-group ">
        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        <input class="form-control" name="email" maxlength="255" type="email" placeholder="E-mail do usuário (Será usado para o login)"
               value="@if($errors->has('email')) {{ old('email') }}@elseif(Route::is('usuario.edit')){{ $usuario->email }}@endif" required>
    </div>
    @if($errors->has('email'))
        <p class="help-block">{!! $errors->first('email') !!}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        <input class="form-control" name="password" maxlength="255" type="password" placeholder="Senha" @if(Route::is('usuario.create')) required @endif>
    </div>
    @if($errors->has('password'))
        <p class="help-block">{!! $errors->first('password') !!}</p>
    @endif
</div>

<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        <input class="form-control" name="password_confirmation" maxlength="255" type="password" placeholder="Confirme a senha" @if(Route::is('usuario.create')) required @endif>
    </div>
</div>

<div class="form-group {{ $errors->has('nivel') ? ' has-error' : '' }}">
    <div class="input-group">
        <span class="input-group-addon "><i class="fa fa-sitemap"></i></span>
        <select class="form-control" name="nivel" required title="Nível de privilégio">
            <option value="">Selecione o nível de privilégio</option>
            <option value="1" @if(old('nivel') == 1 || (isset($usuario) && $usuario->nivel == 1)) selected @endif>Administrador</option>
            <option value="2" @if(old('nivel') == 2 || (isset($usuario) && $usuario->nivel == 2)) selected @endif>Professor / Técnico administrativo</option>
            <option value="3" @if(old('nivel') == 3 || (isset($usuario) && $usuario->nivel == 3)) selected @endif>Usuário Especial</option>
        </select>
    </div>
    @if($errors->has('nivel'))
        <p class="help-block">{!! $errors->first('nivel') !!}</p>
    @endif
</div>

@if(Route::is('usuario.edit'))
    <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
        <div class="input-group">
            <span class="input-group-addon "><i class="fa fa-power-off"></i></span>
            <select class="form-control" name="status" required title="Status">
                <option value="">Selecione o status do usuário</option>
                <option value="0" @if(old('status') == 0 || (isset($usuario) && $usuario->status == 0)) selected @endif>Inativo</option>
                <option value="1" @if(old('status') == 1 || (isset($usuario) && $usuario->status == 1)) selected @endif>Ativo</option>
            </select>
        </div>
        @if($errors->has('status'))
            <p class="help-block">{!! $errors->first('status') !!}</p>
        @endif
    </div>
@endif