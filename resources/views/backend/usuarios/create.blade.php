<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('usuarios.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Roles</label>
                    <select name="rol_id" id="" class="form-control myselector">
                        @foreach($roles as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group">
                <label>Localidades</label>
                    <select name="localidad_id" id="" class="form-control myselector">
                        @foreach($localidades as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre Completo" required>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Correo" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
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

