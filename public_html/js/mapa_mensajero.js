// $(document).ready(function() {
// });


function initMap() 
{ 
  var marker;
  var lat_x;
  var lng_y;
  var mapa;
  
  if (navigator.geolocation) 
  {
    console.log('Esperando la posicion del GPS');
    // document.getElementById("espera_text").innerHTML = 'Esperando la posicion del GPS';
    var geo_options = {enableHighAccuracy:true, maximumAge:0, timeout:30000};
    navigator.geolocation.getCurrentPosition(mapear, showError, geo_options);


    //navigator.geolocation.watchPosition(tracking, showError, geo_options);
    
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
var destino_track='';
// var mierda='';
//------------------------------------------------------------------------
function tracking(position)
{
  if(destino_track != '')
  {
    console.log('SE actico el tracking..');
    lat_x = position.coords.latitude;
    lng_y = position.coords.longitude;

    var directionsDisplay = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: {lat:  lat_x, lng:  lng_y}
    }); 
    directionsDisplay.setMap(map);
    document.getElementById('right-panel').innerHTML = '';
    directionsDisplay.setPanel(document.getElementById('right-panel'));

    var origen = lat_x+', '+lng_y;

    directionsService.route({
      origin: origen,
      destination: destino_track,

      travelMode: google.maps.TravelMode['DRIVING']
    }, function(response, status) {
      if (status == 'OK') {
        directionsDisplay.setDirections(response);
      } else {
        window.alert('Direccion no encontrada. intente nuevamente. ' + status);
      }
    });
  }
  
}

//------------------------------------------------------------------------
function mapear_con_error()
{
    lat_x = -14.825832;
    lng_y = -64.900025;
    console.log('posicion obtenida.!');
    document.getElementById("latitud").value = lat_x;
    document.getElementById("longitud").value = lng_y;

    //parametros del mapa
    map = new google.maps.Map(document.getElementById('map'), {
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
      lat_x = this.getPosition().lat();
      lng_y = this.getPosition().lng();

    });
    document.getElementById("cargando_map").style.display = 'none';
    document.getElementById("cargado_map").style.display = 'block';
}

//-----------------------------------------------------------------------
function mapear(position) 
{
  // position.enableHighAccuracy = true;
  lat_x = position.coords.latitude;
  lng_y = position.coords.longitude;
  console.log('posicion obtenida.!');
  
  map = new google.maps.Map(document.getElementById('map'), {
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
    lat_x = this.getPosition().lat();
    lng_y = this.getPosition().lng();
  });
  document.getElementById("cargando_map").style.display = 'none';
  document.getElementById("cargado_map").style.display = 'block';
    
}

function showError(error) 
{
    switch(error.code) {
        case error.PERMISSION_DENIED:
            //alert("User denied the request for Geolocation.");
            //alert("EL usuario a denegado su ubicacion. permita a la aplicacion que obtenga su ubicacion e intente niuevamente ");
            $.alert({
                title: 'Error',
                content: 'EL usuario a denegado su ubicacion.<br>permita a la aplicacion que obtenga su ubicacion e intente nuevamente ',
                icon: 'fa fa-close',
                animation: 'scale',
                closeAnimation: 'scale',
                type: 'red',
                buttons: {
                    okay: {
                        text: 'OK',
                        btnClass: 'btn-red'
                    }
                }
            });
            //mapear_con_error();
            break;
        case error.POSITION_UNAVAILABLE:
             //alert("Su ubicacion no esta disponible. intentelo mas tarde");
            $.confirm({
              escapeKey: 'cancel',
              title: 'Ubicacion',
              content: 'Su ubicacion no esta disponible. intentelo mas tarde - '+error.POSITION_UNAVAILABLE+'<br>Establecer la Ubicacion por Defecto?',
              buttons: {
                  formSubmit: {
                      text: 'Ok',
                      btnClass: 'btn-blue',
                      action: function () 
                      { 
                        mapear_con_error();    
                      }
                  },
                  cancel: function () 
                  {
                      //close
                  },
              },
              onContentReady: function () {
              // bind to events
              var jc = this;
              this.$content.find('form').on('submit', function (e) {
                  // if the user submits the form by pressing enter in the field.
                  e.preventDefault();
                  jc.$$formSubmit.trigger('click'); // reference the button and click it
              });
          }
          });
             //mapear_con_error();
            break;
        case error.TIMEOUT:
             //alert("Se agoto el tiempo de estara para obtener su ubicacion.<br> intentelo nuevamente.");
            $.alert({
                title: 'Error',
                content: 'Se agoto el tiempo de estara para obtener su ubicacion.<br> intentelo nuevamente..!',
                icon: 'fa fa-rocket',
                animation: 'scale',
                closeAnimation: 'scale',
                type: 'red',
                buttons: {
                    okay: {
                        text: 'OK',
                        btnClass: 'btn-red'
                    }
                }
            });
            //mapear_con_error();
            break;
        case error.UNKNOWN_ERROR:
             $.alert({
                title: 'Error',
                content: 'Error desconocido..!',
                icon: 'fa fa-rocket',
                animation: 'scale',
                type: 'red',
                closeAnimation: 'scale',
                type: 'red',
                buttons: {
                    okay: {
                        text: 'OK',
                        btnClass: 'btn-red'
                    }
                }
            });
             //mapear_con_error();
            break;
    }
}


function buscarMapa()
{
  var geocoder = new google.maps.Geocoder();
  var address = document.getElementById("buscar_mapa").value;
  
  map = new google.maps.Map(document.getElementById('map'), {
      zoom: 15,
    });
  geocoder.geocode({'address': address}, function(results, status) {
    if (status === 'OK') 
    {
      document.getElementById('latitud').value = results[0].geometry.location.lat();
      document.getElementById('longitud').value = results[0].geometry.location.lng();
      lat_x = results[0].geometry.location.lat();
      lng_y = results[0].geometry.location.lng();
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: results[0].geometry.location
      });

    
    marker.addListener( 'dragend', function (event)
    {
      lat_x = this.getPosition().lat();
      lng_y = this.getPosition().lng();

    });


    } else 
    {
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

// $("#proveedor_p").click(function()
// {

//       alert(lat_x+' - '+lng_y);
// });
function enrutar(destino)
{
  // alert(destino);
  destino_track= destino;
  var directionsDisplay = new google.maps.DirectionsRenderer;
  var directionsService = new google.maps.DirectionsService;
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 16,
    center: {lat:  lat_x, lng:  lng_y}
  }); 
  directionsDisplay.setMap(map);
  document.getElementById('right-panel').innerHTML = '';
  directionsDisplay.setPanel(document.getElementById('right-panel'));

  var origen = lat_x+', '+lng_y;
  // var destino = document.getElementById('proveedor').value;

  directionsService.route({
    origin: origen,
    destination: destino,

    travelMode: google.maps.TravelMode['DRIVING']
  }, function(response, status) {
    if (status == 'OK') {
      directionsDisplay.setDirections(response);
    } else {
      window.alert('Direccion no encontrada. intente nuevamente. ' + status);
    }
  });
 
}
