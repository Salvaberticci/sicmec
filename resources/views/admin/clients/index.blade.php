@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Registrar Beneficiario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-client">
          @csrf
          <div class="form-group">
            <label for="cedula">Cédula</label>
            <input type="text" class="form-control" name="cedula">
          </div>

          <div class="form-group">
            <label for="nombre">Nombre del beneficiario (*)</label>
            <input type="text" class="form-control" name="nombre" required>
          </div>

          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" name="telefono">
          </div>

          <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" name="direccion">
          </div>

          <div class="form-group">
            <label for="nro_expediente">Número de expediente</label>
            <input type="text" class="form-control" name="nro_expediente">
          </div>

          <div class="form-group">
            <label for="ubch_centro_electoral">Centro Electoral</label>
            <input type="text" class="form-control" name="ubch_centro_electoral">
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

<section class="container-fluid p-4 bg-white">
  <div class="row">
    <div class="col-md-6">
      <a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add" style="color: white !important;"><i class="fa fa-plus"></i> Nuevo beneficiario</a>   
    </div>
  </div>
	 
  
	<div class="my-4"></div>
	<div class="card">
              <div class="card-header">
                <h3 class="card-title">Beneficiarios registrados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabla-beneficiarios" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Número de expediente</th>
                    <th>Dirección</th>
                    <th>Centro electoral</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Cédula</th>
                      <th>Nombre</th>
                      <th>Teléfono</th>
                      <th>Número de expediente</th>
                      <th>Dirección</th>
                      <th>Centro electoral</th>
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
  $('#form-add-edit').attr('id', 'form-add');
  $('#btn-submit').attr('class', 'btn btn-success btn-lg').html('<i class="fa fa-check"></i> Registrar');
  $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Registrar beneficiario');
});

$(document).on('submit', '#form-client', function(e){
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

    fetch('api/clientes/store', {
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

    fetch('api/cliente/'+id, {
      method: 'GET',
    }).then(res => res.json()
     ).then(function(data){
      if(data){
  
        $('#add').modal('show');
        $('input[name=cedula]').val(data.cedula);
        $('input[name=nombre]').val(data.nombre);
        $('input[name=direccion]').val(data.direccion);
        $('input[name=telefono]').val(data.telefono);
        $('input[name=nro_expediente]').val(data.nro_expediente);
        $('input[name=ubch_centro_electoral]').val(data.ubch_centro_electoral);
        $('input[name=atendido_por]').val(data.atendido_por);
        $('#form-client').attr('id', 'form-client-edit');
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
// Editar Cliente
  $(document).on('submit', '#form-client-edit', function(e){
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

    fetch('api/cliente/update/'+id, {
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
        index();
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

      fetch('api/cliente/destroy/'+id, {
        method: 'GET',
      }).then(res => res.json()
      ).then(function(data){
        if(data){
          
          Swal.fire(
            '¡Perfecto!',
            'Registro eliminado con éxito',
            'success'
          )
          index();
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
  return fetch('api/clientes')
   .then(res => res.json())
   .then(function(data){
      let template = "", 
          i = 1;

          data.data.forEach(element => {
            template += `
            <tr>
              <td>${element.cedula}</td>
              <td>${element.nombre.toUpperCase()}</td>
              <td>${element.telefono}</td>
              <td>${element.nro_expediente}</td>
              <td>${(element.direccion !=  null && element.direccion !=  "") ? element.direccion.toUpperCase() : "Sin asignar"}</td>
              <td>${(element.ubch_centro_electoral !=  null && element.ubch_centro_electoral != "") ? element.ubch_centro_electoral.toUpperCase() : "<span class='text-muted'><b><i>SIN ASIGNAR</i></b></span>"}</td>
              <td>
                <button class="btn btn-primary btn-sm edit" data-id="${element.id}"><i class="fa fa-edit"></i></button>
                <button class="btn btn-danger btn-sm delete" data-id="${element.id}"><i class="fa fa-trash"></i></button>
              </td>
            </tr>
            `
          });
          $('#tabla-beneficiarios').DataTable().destroy();
          $('#tabla-beneficiarios tbody').html(template);
          $('#tabla-beneficiarios').DataTable({
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