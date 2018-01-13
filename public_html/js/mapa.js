
function initMap() 
{ 
  var marker;
  var lat_x;
  var lng_y;
  if (navigator.geolocation) 
  {
    console.log('Esperando la posicion del GPS');
    // document.getElementById("espera_text").innerHTML = 'Esperando la posicion del GPS';
    var geo_options = {enableHighAccuracy:true, maximumAge:30000, timeout:27000};
    navigator.geolocation.getCurrentPosition(mapear,showError,geo_options);
    
  } 
  else 
  {
      // alert('tu navegador no es compatible con la geo-localizacion..! ')
      $.alert({
          title: 'Informacion..!',
          content: 'tu navegador no es compatible con la geo-localizacion..!',
          icon: 'fa fa-rocket',
          animation: 'scale',
          closeAnimation: 'scale',
          buttons: {
              okay: {
                  text: 'OK',
                  btnClass: 'btn-blue'
              }
          }
      });
  }    
}
function mapear_con_error()
{
    lat_x = -14.825832;
    lng_y = -64.900025;
    console.log('posicion obtenida.!');
    document.getElementById("latitud").value = lat_x;
    document.getElementById("longitud").value = lng_y;
    //parametros del mapa
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: {lat:  lat_x, lng:  lng_y}
    });

    //parametros del market(globo)
    marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: {lat: lat_x, lng: lng_y}
    });
    // marker.addListener('click', toggleBounce);
    marker.addListener( 'dragend', function (event)
    {
      document.getElementById('latitud').value = this.getPosition().lat();
      document.getElementById('longitud').value = this.getPosition().lng();

    });
    document.getElementById("cargando_map").style.display = 'none';
    document.getElementById("cargado_map").style.display = 'block';
}
function mapear(position) 
{
  position.enableHighAccuracy = true;
  lat_x = position.coords.latitude;
  lng_y = position.coords.longitude;
  console.log('posicion obtenida.!');
  // document.getElementById("espera_text").style.display = 'none';
  // document.getElementById("map").style.display  = 'flex';
  
  // alert(document.getElementById("latitud"));

    document.getElementById("latitud").value = lat_x;
    document.getElementById("longitud").value = lng_y;
    //parametros del mapa
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: {lat:  lat_x, lng:  lng_y}
    });

    //parametros del market(globo)
    marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: {lat: position.coords.latitude, lng: position.coords.longitude}
    });
    // marker.addListener('click', toggleBounce);
    marker.addListener( 'dragend', function (event)
    {
      document.getElementById('latitud').value = this.getPosition().lat();
      document.getElementById('longitud').value = this.getPosition().lng();

    });
    document.getElementById("cargando_map").style.display = 'none';
    document.getElementById("cargado_map").style.display = 'block';
    
}

function showError(error) 
{
    switch(error.code) {
        case error.PERMISSION_DENIED:
            // alert("User denied the request for Geolocation.");
            // alert("EL usuario a denegado su ubicacion. permita a la aplicacion que obtenga su ubicacion e intente niuevamente ");
            // $.alert({
            //     title: 'Error',
            //     content: 'EL usuario a denegado su ubicacion.<br>permita a la aplicacion que obtenga su ubicacion e intente nuevamente ',
            //     icon: 'fa fa-close',
            //     animation: 'scale',
            //     closeAnimation: 'scale',
            //     type: 'red',
            //     buttons: {
            //         okay: {
            //             text: 'OK',
            //             btnClass: 'btn-red'
            //         }
            //     }
            // });
            mapear_con_error();
            break;
        case error.POSITION_UNAVAILABLE:
             // alert("Su ubicacion no esta disponible. intentelo mas tarde");
            //  $.alert({
            //     title: 'Error',
            //     content: '<p class="text-center"> Su ubicacion no esta disponible.<br>intentelo mas tarde..!<br>o habilite su GPS </p>',
            //     icon: 'fa fa-close',
            //     animation: 'scale',
            //     closeAnimation: 'scale',
            //     type: 'red',
            //     buttons: {
            //         okay: {
            //             text: 'OK',
            //             btnClass: 'btn-red'
            //         }
            //     }
            // });
             mapear_con_error();
            break;
        case error.TIMEOUT:
             // alert("Se agoto el tiempo de estara para obtener su ubicacion.<br> intentelo nuevamente.");
            // $.alert({
            //     title: 'Error',
            //     content: 'Se agoto el tiempo de estara para obtener su ubicacion.<br> intentelo nuevamente..!',
            //     icon: 'fa fa-rocket',
            //     animation: 'scale',
            //     closeAnimation: 'scale',
            //     type: 'red',
            //     buttons: {
            //         okay: {
            //             text: 'OK',
            //             btnClass: 'btn-red'
            //         }
            //     }
            // });
            mapear_con_error();
            break;
        case error.UNKNOWN_ERROR:
            //  $.alert({
            //     title: 'Error',
            //     content: 'Error desconocido..!',
            //     icon: 'fa fa-rocket',
            //     animation: 'scale',
            //     type: 'red',
            //     closeAnimation: 'scale',
            //     type: 'red',
            //     buttons: {
            //         okay: {
            //             text: 'OK',
            //             btnClass: 'btn-red'
            //         }
            //     }
            // });
             mapear_con_error();
            break;
    }
}


function buscarMapa()
{
  
  var geocoder = new google.maps.Geocoder();
  var address = document.getElementById("buscar_mapa").value;
  var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
    });
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === 'OK') 
    {
      document.getElementById('latitud').value = results[0].geometry.location.lat();
      document.getElementById('longitud').value = results[0].geometry.location.lng();
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: results[0].geometry.location
      });

    marker.addListener( 'dragend', function (event)
    {
      document.getElementById('latitud').value = this.getPosition().lat();
      document.getElementById('longitud').value = this.getPosition().lng();

    });

    } else 
    {
      // alert('Geocode was not successful for the following reason: ' + status);
      $.alert({
                title: 'Informacion..!',
                content: 'Intente con otra locacion !',
                icon: 'fa fa-rocket',
                animation: 'scale',
                type: 'red',
                closeAnimation: 'scale',
                buttons: {
                    okay: {
                        text: 'OK',
                        btnClass: 'btn-blue'
                    }
                }
            });
    }
  });

}
function mapear_edit(lat_x, lng_y) 
{
    document.getElementById("latitud").value = lat_x;
    document.getElementById("longitud").value = lng_y;
    //parametros del mapa
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: {lat:  lat_x, lng:  lng_y}
    });

    //parametros del market(globo)
    marker = new google.maps.Marker({
      map: map,
      draggable: true,
      animation: google.maps.Animation.DROP,
      position: {lat: lat_x, lng: lng_y}
    });
    // marker.addListener('click', toggleBounce);
    marker.addListener( 'dragend', function (event)
    {
      document.getElementById('latitud').value = this.getPosition().lat();
      document.getElementById('longitud').value = this.getPosition().lng();

    });
    document.getElementById("cargando_map").style.display = 'none';
    document.getElementById("cargado_map").style.display = 'block';
    
}

function enrutar()
{
  alert('destino');
}