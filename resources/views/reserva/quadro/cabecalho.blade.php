<div class="box-header with-border">
    <h3 class="text-center">
        <a href="#" class="text-black" data-widget="collapse">
            @if($turno == 'm')
                <i class="fa fa-sun-o"></i> Turno Matutino
            @elseif($turno == 'v')
                <i class="fa fa-cloud"></i> Turno Vespertino
            @else
                <i class="fa fa-moon-o"></i> Turno Noturno
            @endif
        </a>
    </h3>
    <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
    </div>
</div>