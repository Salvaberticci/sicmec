@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Registrar cobro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-pay">
          @csrf
          <div class="form-group">
            <label for="factura_id">Factura</label>
            <select class="form-control" name="factura_id" required>
                <option value>--- SELECCIONE ---</option>
                @foreach($data['facturas-pendientes'] as $key)
                  <option value="{{$key->id}}" data-monto={{$key->total_factura}}>{{"Nro: ". $key->id . " - " . $key->cliente->cedula . " - " .$key->cliente->nombre . " - " . number_format($key->total_factura,2) }}</option>
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
          <div class="form-group row">
            <div class="col-md-4 d-none" id="div-monto-bs">
              <label for="montoBs">Divisas ($)</label>
              <input type="text" class="form-control" id="montoBs" name="montoBs" required disabled>
            </div>   
            <div class="col-md-4 d-none" id="div-tasa">
              <label for="tasa">Tasa</label>
              <input type="text" class="form-control" id="tasa" name="tasa" required disabled>
            </div> 
            <div class="col-md-4">
              <label for="monto">Monto</label>
              <input type="text" class="form-control" name="monto" required>
            </div>
          </div>
          <div class="form-group">
            <label for="referencia">Referencia</label>
            <input type="text" class="form-control" name="referencia">
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
	<a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add" style="color: white !important;"><i class="fa fa-plus"></i> Nuevo cobro</a>
	<div class="my-4"></div>
	<div class="card">
              <div class="card-header">
                <h3 class="card-title">Cobros registrados</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<div class="alert alert-info">
              		<p><i class="fa fa-info-circle"></i> A través de los botones PDF y EXCEL puedes exportar tu tabla de registros.</p>
              	</div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Cédula</th>
                    <th>Cliente</th>
                    <th>Metodo de pago</th>
                    <th>Monto</th>
                    <th>Referencia</th>
                    <th class="text-right">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data['pagos'] as $key)
                    <tr>
                      <td>{{$key->created_at}}</td>
                      <td>{{$key->factura->cliente->cedula}}
                      <td>{{$key->factura->cliente->nombre}}
                      </td>
                      <td>{{$key->metodos_pago->descripcion}}</td>
                      <td>{{$key->monto}}</td>
                      <td>{{$key->referencia}}</td>
                      <td class="text-right">
                        {{-- <a href="#" data-id="{{$key->id}}" class="btn btn-warning btn-sm edit" title="Editar registro"><i class="fa fa-edit"></i></a> --}}
                        <a href="#" data-id="{{$key->id}}" class="btn btn-danger btn-sm delete" title="Eliminar registro"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Fecha</th>
                    <th>Cédula</th>
                    <th>Cliente</th>
                    <th>Metodo de pago</th>
                    <th>Monto</th>
                    <th>Referencia</th>
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
  $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Registrar cobro');
});

$('select[name=metodo_pago_id]').change(function(){
  let val = $(this).val();
  if(val == 3){
    $('#bs-tag').attr('class', 'd-block')
  }else{
    $('#bs-tag').attr('class', 'd-none')
    $('#tasa').attr('disabled','disabled');
    $('#montoBs').attr('disabled','disabled');
    $('#div-tasa').attr('class', 'col-md-4 d-none');
    $('#div-monto-bs').attr('class', 'col-md-4 d-none');
  }
})

$('select[name=metodo_pago_id]').change(function(){
  let val = $(this).val();
  if(val == 3){
    $('#tasa').removeAttr('disabled');
    $('#montoBs').removeAttr('disabled');
    $('#div-tasa').attr('class', 'col-md-4');
    $('#div-monto-bs').attr('class', 'col-md-4');
  }else{
    $('#tasa').attr('disabled','disabled');
    $('#montoBs').attr('disabled','disabled');
    $('#div-tasa').attr('class', 'col-md-4 d-none');
    $('#div-monto-bs').attr('class', 'col-md-4 d-none');
  }
});

$('#tasa').change(function(){
  let monto = $('input[name=montoBs]').val(),
      tasa = $(this).val(),
      cal = parseFloat(monto) * parseFloat(tasa);

      $('input[name=monto]').val(cal.toFixed(2)).triggerHandler('change');
})

$('input[name=monto]').change(function(){
  let montoFac = $('select[name=factura_id] option:selected').attr('data-monto'),
      monto = $('input[name=monto]').val(),
      cal = 0;

      cal = parseFloat(montoFac) - parseFloat(monto);
      

      if(cal < 0){
        alert("El monto del pago excede el monto de la factura, por lo tanto el cliente quedará con un saldo positivo.");
      }
})

$(document).on('submit', '#form-pay', function(e){
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

    fetch('cobros/store', {
      method: 'POST',
      body: form
    }).then(res => res.text()
     ).then(function(data){
      if(data){
        $('#form-pay').trigger("reset");
        Swal.fire(
          '¡Perfecto!',
          'Registro realizado con éxito',
          'success'
        )

        setTimeout(function(){
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

    fetch('cobro/'+id, {
      method: 'GET',
    }).then(res => res.json()
     ).then(function(data){
      if(data){
        $('#add').modal('show');
        $('input[name=nombre]').val(data.nombre);
        $('input[name=cedula]').val(data.cedula);
        $('input[name=telefono]').val(data.telefono);
        $('textarea[name=direccion]').text(data.direccion);
        $('input[name=cargo]').val(data.cargo);
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
// Editar cobro
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

    fetch('cobro/update/'+id, {
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

      fetch('cobro/destroy/'+id, {
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