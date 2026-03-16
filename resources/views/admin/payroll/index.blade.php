@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Pago a trabajador</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-add">
          @csrf
          <div class="form-group">
            <label for="trabajador_id">Trabajador</label>
            <select class="form-control" name="trabajador_id" required>
                <option value>--- SELECCIONE ---</option>
                @foreach($data['trabajadores'] as $key)
                  <option value="{{$key->id}}">{{$key->cedula . " - " .$key->nombre}}</option>
                @endforeach 
            </select>
          </div>
          <div class="form-group">
            <label for="metodo_pago_id">Método de pago</label>
            <select class="form-control" name="metodo_pago_id" required>
              <option value>--- SELECCIONE ---</option>
              @foreach($data['metodos-pago'] as $key)
                @if($key->id != 6)
                <option value="{{$key->id}}">{{$key->descripcion}}</option>
                @endif
              @endforeach 
          </select>
          </div>
          <div class="form-group">
            <label for="monto">Monto</label>
            <input type="text" class="form-control" name="monto" required onkeypress="return validator.soloNumeros(event)">
          </div>
          <div class="form-group">
            <label for="observacion">Observación</label>
            <input type="text" class="form-control" name="observacion">
          </div>
          <hr>
          <div class="w-100 text-right">
            <button type="submit" id="btn-submit" class="btn btn-success btn-lg"><i class="fa fa-check"></i> Pagar</button>
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
	<a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add" style="color: white !important;"><i class="fa fa-plus"></i> Nuevo pago</a>
	<div class="my-4"></div>
	<div class="card">
              <div class="card-header">
                <h3 class="card-title">Nominas registradas</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<div class="alert alert-info">
              		<p><i class="fa fa-info-circle"></i> A través de los botones PDF y EXCEL puedes exportar tu tabla de registros.</p>
              	</div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Fecha de pago</th>
                    <th>Cédula</th>
                    <th>Trabajador</th>
                    <th>Monto</th>
                    <th>Método de pago</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data['nominas'] as $key)
                    <tr>
                      <td>{{$key->created_at->diffForHumans()}}</td>
                      <td>{{number_format($key->trabajadore->cedula)}}</td>
                      <td>{{$key->trabajadore->nombre}}</td>
                      <td>{{number_format($key->monto,2)}}</td>
                      <td>{{$key->metodos_pago->descripcion}}</td>
                      <td class="text-right">
                        <a href="#" data-id="{{$key->id}}" class="btn btn-info btn-sm" title="Imprimir comprobante"><i class="fa fa-print"></i></a>
                        <a href="#" data-id="{{$key->id}}" class="btn btn-danger btn-sm delete" title="Eliminar registro"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Fecha de pago</th>
                    <th>Cédula</th>
                    <th>Trabajador</th>
                    <th>Monto</th>
                    <th>Método de pago</th>
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
  $('#btn-submit').attr('class', 'btn btn-success btn-lg').html('<i class="fa fa-check"></i> Pagar');
  $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Pago a trabajador');
});

$(document).on('submit', '#form-add', function(e){
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

    fetch('nominas/store', {
      method: 'POST',
      body: form
    }).then(res => res.text()
     ).then(function(data){
      console.log(data)
      if(data){
        $('#form-add').trigger("reset");
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

    fetch('nomina/'+id, {
      method: 'GET',
    }).then(res => res.json()
     ).then(function(data){
      if(data){
        $('#add').modal('show');
        $('select[name=turno]').append(`<option selected value="${data.turno}">${turno}</option>`);
        $('select[name=turno]').append(`<option selected value="${data.turno}">${turno}</option>`);
        $('input[name=monto]').val(data.monto);
        $('input[name=observacion]').val(data.observacion);
        $('#form-add').attr('id', 'form-add-edit');
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
  $(document).on('submit', '#form-add-edit', function(e){
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

    fetch('nomina/update/'+id, {
      method: 'POST',
      'X-CSRF-TOKEN': "{{csrf_token()}}",
      body: form
    }).then(res => res.text()
     ).then(function(data){
      if(data){
        $('#form-add-edit').trigger("reset");
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

      fetch('nomina/destroy/'+id, {
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