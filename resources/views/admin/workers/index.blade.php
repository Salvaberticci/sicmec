@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Registrar trabajador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-worker">
          @csrf
          <div class="form-group">
            <label for="cedula">Cédula</label>
            <input type="text" class="form-control" name="cedula" required>
          </div>
          <div class="form-group">
            <label for="nombre">Nombre del trabajador</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" name="telefono" required>
          </div>
          <div class="form-group">
            <label for="direccion">Dirección</label>
            <textarea class="form-control" name="direccion" required></textarea>
          </div>
          <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" class="form-control" name="cargo" required>
          </div>
          <div class="form-group">
            <label for="turno">Turno</label>
            <select name="turno" id="turno" class="form-control" required>
              <option value>--- SELECCIONE ---</option>
              @foreach($data['turnos'] as $key) 
              <option value="{{$key->id}}">{{$key->descripcion}}</option>
              @endforeach
            </select>
          </div>
          <hr>
          <div class="w-100 text-right">
            <button type="submit" id="btn-submit" class="btn btn-success btn-lg"><i class="fa fa-check"></i> Registrar</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div>
  </div>
</div>

<section class="container p-4 bg-white">
	<a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add" style="color: white !important;"><i class="fa fa-plus"></i> Nuevo trabajador</a>
	<div class="my-4"></div>
	<div class="card">
              <div class="card-header">
                <h3 class="card-title">Trabajadores registrados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<div class="alert alert-info">
              		<p><i class="fa fa-info-circle"></i> A través de los botones PDF y EXCEL puedes exportar tu tabla de registros.</p>
              	</div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data['trabajadores'] as $key)
                    <tr>
                      <td>{{$key->cedula}}</td>
                      <td>{{$key->nombre}}
                      </td>
                      <td>{{$key->telefono}}</td>
                      <td>{{$key->cargo}}</td>
                      <td class="text-right">
                        <a href="#" data-id="{{$key->id}}" class="btn btn-warning btn-sm edit" title="Editar registro"><i class="fa fa-edit"></i></a>
                        <a href="#" data-id="{{$key->id}}" class="btn btn-danger btn-sm delete" title="Eliminar registro"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Cargo</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
</section>
@endsection

@section('scripts')
<script>
var id = "";
$('#btn-add').click(function(){
  $('#form-add-edit').attr('id', 'form-add');
  $('#btn-submit').attr('class', 'btn btn-success btn-lg').html('<i class="fa fa-check"></i> Registrar');
  $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Registrar trabajador');
});

$(document).on('submit', '#form-worker', function(e){
    e.preventDefault();
    let form = new FormData(this);
    let timerInterval;
    Swal.fire({
      title: 'Procesando...',
      html:'La ventana se cerrará en <b></b> milisegundos.',
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      /* Read more about handling dismissals below */
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
      }
    })

    fetch('trabajadores/store', {
      method: 'POST',
      body: form
    }).then(res => res.text()
     ).then(function(data){
      if(data){
        $('#form-client').trigger("reset");
        Swal.fire(
          '¡Perfecto!',
          'Registro realizado con éxito',
          'success'
        )
        setTimeout(() => {
          location.reload();
        }, 1500);
      }

     }).catch(function(err){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'err'
          })
        // console.log(err)
     })
  })

  $('.edit').click(function(e){
    e.preventDefault();
    let timerInterval;
    id = $(this).attr('data-id');
    Swal.fire({
      title: 'Procesando...',
      html: 'La ventana se cerrará en <b></b> milisegundos.',
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      /* Read more about handling dismissals below */
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
      }
    })

    fetch('trabajador/'+id, {
      method: 'GET',
    }).then(res => res.json()
     ).then(function(data){
      let turno = "";
      if(data){
        if(data.turno == 1){
          turno = "DIURNO";
        }

        if(data.turno == 2){
          turno = "MATUTINO";
        }

        if(data.turno == 3){
          turno = "NOCTURNO";
        }

        $('#add').modal('show');
        $('input[name=nombre]').val(data.nombre);
        $('input[name=cedula]').val(data.cedula);
        $('input[name=telefono]').val(data.telefono);
        $('textarea[name=direccion]').text(data.direccion);
        $('input[name=cargo]').val(data.cargo);
        $('select[name=turno]').append(`<option selected value="${data.turno}">${turno}</option>`);
        $('#form-worker').attr('id', 'form-worker-edit');
        $('#btn-submit').attr('class', 'btn btn-primary btn-lg').html('<i class="fa fa-check"></i> Modificar registro');
        $('#staticBackdropLabel').html('<i class="fa fa-edit"></i> Modificar registro');
      }

     }).catch(function(err){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'err'
          })
        // console.log(err)
     })
  })
// Editar trabajador
  $(document).on('submit', '#form-worker-edit', function(e){
    e.preventDefault();
    let form = new FormData(this);
        form.append('_method', 'PUT');
    let timerInterval;
    Swal.fire({
      title: 'Procesando...',
      html: 'La ventana se cerrará en <b></b> milisegundos.',
      timer: 1000,
      timerProgressBar: true,
      didOpen: () => {
        Swal.showLoading()
        const b = Swal.getHtmlContainer().querySelector('b')
        timerInterval = setInterval(() => {
          b.textContent = Swal.getTimerLeft()
        }, 100)
      },
      willClose: () => {
        clearInterval(timerInterval)
      }
    }).then((result) => {
      /* Read more about handling dismissals below */
      if (result.dismiss === Swal.DismissReason.timer) {
        console.log('I was closed by the timer')
      }
    })

    fetch('trabajador/update/'+id, {
      method: 'POST',
      'X-CSRF-TOKEN': "{{csrf_token()}}",
      body: form
    }).then(res => res.text()
     ).then(function(data){
      if(data){
        $('#form-client-edit').trigger("reset");
        Swal.fire(
          '¡Perfecto!',
          'Registro modificado con éxito',
          'success'
        )
        setTimeout(() => {
          location.reload();
        }, 1500);
      }

     }).catch(function(err){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'err'
          })
        // console.log(err)
     })
  })


$(document).on('click', '.delete',function(e){
  e.preventDefault();
  let id = $(this).attr('data-id')
  Swal.fire({
    title: '¿Estás seguro(a) de eliminar este registro?',
    text: "Ten en cuenta que la información que será eliminada es irrecuperable.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Cancelar',
    confirmButtonText: 'Si, eliminar'
  }).then((result) => {
    if (result.isConfirmed) {
      let timerInterval;
      Swal.fire({
        title: 'Procesando...',
        html: 'La ventana se cerrará en <b></b> milisegundos.',
        timer: 1000,
        timerProgressBar: true,
        didOpen: () => {
          Swal.showLoading()
          const b = Swal.getHtmlContainer().querySelector('b')
          timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
          }, 100)
        },
        willClose: () => {
          clearInterval(timerInterval)
        }
      }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
          console.log('I was closed by the timer')
        }
      })

      fetch('trabajador/destroy/'+id, {
        method: 'GET',
      }).then(res => res.text()
      ).then(function(data){
        if(data){
          
          Swal.fire(
            '¡Perfecto!',
            'Registro eliminado con éxito',
            'success'
          )
          setTimeout(() => {
            location.reload();
          }, 1500);
        }

      }).catch(function(err){
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'err'
            })
          // console.log(err)
      })
      
    }
  })
}) 
</script>
@endsection