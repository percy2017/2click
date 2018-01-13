<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('usuarios.store') }}">
        {{ csrf_field() }}
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
                <i class="fa fa-user"></i>Nuevo Usuario
            </h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Roles</label>
                    <select name="rol_id" class="form-control myselector">
                        @foreach($roles as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group">
                <label>Localidades</label>
                    <select name="localidad_id" class="form-control myselector">
                        @foreach($localidades as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
            </div>
            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" class="form-control" name="name" placeholder="Nombre Completo" required>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="email" class="form-control" name="email" placeholder="Correo" required>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
            </div>
            <div class="form-group">
                <label for="">Habilitado</label>
                <br>
                <input type="checkbox" class="checkbox" checked data-toggle="toggle" data-on="SI" data-off="NO"> 
                <!-- <input type="checkbox" class="form-control" checked>  -->
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

