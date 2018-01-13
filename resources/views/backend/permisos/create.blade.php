<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('permisos.store') }}">
        {{ csrf_field() }}
        <input type="text" value="{{$rol->id}}" name="rol_id" hidden>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo Permiso</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Nombre</label>
              <input type="text" list="browsers" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
              <datalist id="browsers">
                @foreach($permisos_all as $item)
                  <option value="{{ $item->nombre }}">
                @endforeach
              </datalist>
          </div>
          <div class="form-group">
              <label>Ruta</label>
              <input type="text" list="browsers2" class="form-control" id="ruta" name="ruta" placeholder="Ruta" required>
              <datalist id="browsers2">
                @foreach($permisos_all as $item)
                  <option value="{{ $item->ruta }}">
                @endforeach
              </datalist>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>