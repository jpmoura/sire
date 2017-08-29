{{ csrf_field() }}

<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
    <input type="text" name="title" maxlength="100" class="form-control" placeholder="Título" required>
</div>

<div class="input-group">
    <span class="input-group-addon"><i class="fa fa-th-list"></i></span>
    <textarea name="description" maxlength="850" rows="6" style="resize: none" class="form-control" placeholder="Informe o máximo de detalhes que conseguir (Ex.: navegador, ação que estava realizando, se era navagação privada ou não, se era em um dispositivo móvel ou desktop, etc.)" required></textarea>
</div>