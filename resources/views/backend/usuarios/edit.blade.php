<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('usuarios.update',0) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <input type="text" id="id" name="id" hidden>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">
                <i class="fa fa-edit"></i>Editar Usuario
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
                    <p id="rol_id"></p>
            </div>
            <div class="form-group">
                <label>Localidades</label>
                    <select name="localidad_id" class="form-control myselector">
                        @foreach($localidades as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                    </select>
                    <p id="localidad_id"></p>
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
                <label>Nueva contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                <p id="password_view"></p>
            </div>
            <div class="form-group">
                <label for="">Habilitado</label>
                <br>
                <!-- <input id="habilitado" type="checkbox" class="checkbox" data-toggle="toggle" data-on="SI" data-off="NO">  -->
                <input type="checkbox" id="habilitado" name="habilitado" data-toggle="toggle" data-on="SI" data-on="NO"> 
                <!-- <input type="checkbox" class="form-control" checked>  -->
                <!-- <in id="habilitado"></div> -->
            </div>
        </div>
        <div class="modal-footer">
          
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-reply"></i>Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

