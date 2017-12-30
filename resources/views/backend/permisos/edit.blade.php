<!-- Modal -->
<div class="modal fade" id="edit_permisos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('permisos.update',0) }}">
        {{ method_field('PUT') }}
        {{ csrf_field() }}


        <input type="text" id="edit_id" name="edit_id" hidden>
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Editar Permiso</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Nombre Completo</label>
              <input type="text" class="form-control" id="edit_nombre" name="nombre" placeholder="Nombre" required>
          </div>
          <div class="form-group">
              <label>Ruta</label>
              <input type="text" class="form-control" id="edit_ruta" name="ruta" placeholder="Ruta" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Editar</button>
        </div>
      </form>
    </div>
  </div>
</div>