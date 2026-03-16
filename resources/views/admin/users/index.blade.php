@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Registrar usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-user">
          @csrf
          <div class="form-group">
            <label for="name">Nombre de Usuario</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" name="password" required minlength="8" title="La longitud de la contraseña debe ser mayor a 8 caracteres.">
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
	<a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add" style="color: white !important;"><i class="fa fa-plus"></i> Nuevo usuario</a>
	<div class="my-4"></div>
	<div class="card">
              <div class="card-header">
                <h3 class="card-title">Usuarios registrados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<div class="alert alert-info">
              		<p><i class="fa fa-info-circle"></i> A través de los botones PDF y EXCEL puedes exportar tu tabla de registros.</p>
              	</div>
                <table id="tabla-usuarios" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Nombre</th>
                    <th>Correo electrónico</th>
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

index();

$('#btn-add').click(function(){
  $('#form-user-edit').trigger('reset');
  $('#form-user-edit').attr('id', 'form-user');
  $('#btn-submit').attr('class', 'btn btn-success btn-lg').html('<i class="fa fa-check"></i> Registrar');
  $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Registrar usuario');
});

$(document).on('submit', '#form-user', function(e){
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

    fetch('usuarios/store', {
      method: 'POST',
      body: form
    }).then(res => res.text()
     ).then(function(data){
      if(data){
        $('#form-user').trigger("reset");
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

  $(document).on('click', '.edit', function(e){
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

    fetch('api/usuario/'+id, {
      method: 'GET',
    }).then(res => res.json()
     ).then(function(data){
      if(data){
        $('#add').modal('show');
        $('input[name=name]').val(data.name);
        $('input[name=email]').val(data.email);
        $('input[name=password]').val(data.password);
        $('#form-user').attr('id', 'form-user-edit');
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
// Editar usuario
  $(document).on('submit', '#form-user-edit', function(e){
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

    fetch('api/usuario/update/'+id, {
      method: 'POST',
      'X-CSRF-TOKEN': "{{csrf_token()}}",
      body: form
    }).then(res => res.text()
     ).then(function(data){
      if(data){
        $('#form-user-edit').trigger("reset");
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

      fetch('api/usuario/destroy/'+id, {
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


async function index(){
  return fetch('api/usuarios')
   .then(res => res.json())
   .then(function(data){
      let template = "", 
          i = 1;

          data.data.forEach(element => {
            template += `
            <tr>
              <td>${element.name}
              </td>
              <td>${element.email}</td>
              <td class="text-right">
                <a href="#" data-id="${element.id}" class="btn btn-warning btn-sm edit" title="Editar registro"><i class="fa fa-edit"></i></a>
                <a href="#" data-id="${element.id}" class="btn btn-danger btn-sm delete" title="Eliminar registro"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            `
          });
          $('#tabla-usuarios').DataTable().destroy();
          $('#tabla-usuarios tbody').html(template);
          $('#tabla-usuarios').DataTable({
                        "responsive": true, 
                        "ordering": false,
                        "language": {
                        "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                        }
                        })
    })
}
</script>
@endsection