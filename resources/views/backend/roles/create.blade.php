<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('roles.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">
            <i class="fa fa-pencil"></i> Nuevo Rol
          </h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Nombre Completo</label>
              <input type="text" class="form-control" name="nombre" placeholder="Nombre de Rol" required>
          </div>
          <div class="form-group">
            <label for="">Descripcion</label>
            <textarea name="descripcion" id="" class="form-control" rows="3" placeholder="Descripcion del rol"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-reply"></i>Cerrar
          </button>
          
        </div>
      </form>
    </div>
  </div>
</div>