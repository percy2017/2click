<!-- Modal -->
<div class="modal fade" id="modal_cupon_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('cupones.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo Cupon</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Codigo</label>
              <input type="text" class="form-control" name="codigo" required>
          </div>
          <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="form-group">
              <label>descripcion</label>
              <textarea name="descripcion" class="form-control" rows="3" required></textarea>
          </div>
          <div class="form-group">
              <label>Descuento en %</label>
              <input type="number" class="form-control" name="descuento" required>
          </div>
          <div class="form-group">
            <label for="">Habilitado</label>
            <br>
            <input type="checkbox" name="habilitado" data-toggle="toggle" data-off="NO">
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