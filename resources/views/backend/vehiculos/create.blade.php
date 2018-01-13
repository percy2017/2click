<!-- Modal -->
<div class="modal fade" id="modal_vehiculo_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('vehiculos.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
                <i class="fa fa-user"></i>
                Nuevo Vehiculo
            </h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre del Vehiculo" required>
            </div>
            <div class="form-group">
                <label>Ruedas</label>
                <input type="text" class="form-control" name="ruedas" placeholder="Cantidad de ruedas" required>
            </div>
        </div>
        <div class="modal-footer">
          
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-reply"></i>Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

