@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Registrar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form-add">
          @csrf
          <div class="form-group">
            <label for="nombre_producto">Nombre del producto</label>
            <input type="text" class="form-control" name="nombre_producto" required>
          </div>
          <div class="form-group">
            <label for="existencia">Existencia</label>
            <input type="number" min="0.00" class="form-control" name="existencia" >
          </div>

          <div class="form-group">
            <label for="presentacion">Tipo</label>
            <div class="custom-control custom-radio">
              <input class="custom-control-input radioTipo" type="radio" id="tipoMed1" name="tipo" value="medicamento" >
              <label for="tipoMed1" class="custom-control-label">Medicamento</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input radioTipo" type="radio" id="tipoMed2" name="tipo" value="insumo">
              <label for="tipoMed2" class="custom-control-label">Insumo</label>
            </div>
            <div class="custom-control custom-radio">
              <input class="custom-control-input radioTipo" type="radio" id="tipoMed3" name="tipo" value="ayudasTecnicas">
              <label for="tipoMed3" class="custom-control-label">Ayuda Tecnica</label>
            </div>
          </div>

          <div class="form-group">
            <label for="presentacion">Presentación</label>
            <select class="form-control" name="presentacion" >
             
           
            </select>
          </div>
          
          <div class="form-group">
            <label for="unidad">Unidad de medida</label>
            <div class="row">
              <div class="col-md-6">
                <input type="text" name="peso" id="peso" class="form-control" >    
              </div>
              <div class="col-md-6">
                <select class="form-control" name="unidad" id="unidad" >
                  <option>Miligramos (mg)</option>
                  <option>Gramos (g)</option>
                </select>
              </div>
            </div>
            
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
	<a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add" style="color: white !important;"><i class="fa fa-plus"></i> Nuevo producto</a>
	<div class="my-4"></div>
	<div class="card">
    <div class="card-header">
      <h3 class="card-title">Productos registrados</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <form id="form-product-filter">
        @csrf
        <div class="form-group">
          <label for="tipo">Filtrar por:</label>
          <select name="tipo" id="filtrar" class="form-control" required>
            <option value>--- SELECCIONE UNA OPCIÓN ---</option>
            <option value="medicamento">Medicamentos</option>
            <option value="insumo">Insumos médicos</option>
            <option value="ayudasTecnicas">Ayudas Técnicas</option>
            <option value="todos">Todos</option>
          </select>
        </div>
      </form>
      <table id="tabla-productos" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Código</th>
          <th>Nombre del Producto</th>
          <th>Existencia</th>
          <th>Presentación</th>
          <th>Unidad</th>
          <th class="text-right">Acciones</th>
        </tr>
        </thead>
        <tbody>
        
        </tbody>
        <tfoot>
        <tr>
          <th>Código</th>
          <th>Nombre del Producto</th>
          <th>Existencia</th>
          <th>Presentación</th>
          <th>Unidad</th>
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
  $('#form-add-edit').trigger('reset');
  $('#form-add-edit').attr('id', 'form-add');
  $('#btn-submit').attr('class', 'btn btn-success btn-lg').html('<i class="fa fa-check"></i> Registrar');
  $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Registrar medicamento');
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

    fetch('api/productos/store', {
      method: 'POST',
      body: form
    }).then(res => res.json()
     ).then(function(data){
      if(data){
        $('#form-add').trigger("reset");
        Swal.fire(
          '¡Perfecto!',
          'Registro realizado con éxito',
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

    fetch('api/producto/'+id, {
      method: 'GET',
    }).then(res => res.json()
     ).then(function(data){
      if(data){
        $('#add').modal('show');
        $('input[name=nombre_producto]').val(data.data.nombre_producto);
        $('input[name=codigo]').val(data.data.codigo);
        $('input[name=existencia]').val(data.data.existencia);
        $('input[name=peso]').val(data.data.peso);
        $('#form-add').attr('id', 'form-add-edit');
        $('#btn-submit').attr('class', 'btn btn-primary btn-lg').html('<i class="fa fa-check"></i> Modificar registro');
        $('#staticBackdropLabel').html('<i class="fa fa-edit"></i> Modificar registro');
        if(data.data.tipo == "medicamento"){
          $("#tipoMed1").prop("checked", true);
        }else{
          $("#tipoMed2").prop("checked", true);
        }
      }

     }).catch(function(err){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'err'
          })
        console.log(err)
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

    fetch('api/producto/update/'+id, {
      method: 'POST',
      'X-CSRF-TOKEN': "{{csrf_token()}}",
      body: form
    }).then(res => res.json()
     ).then(function(data){
      if(data){
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

//Filtrar inventario
$('#filtrar').change(function(e){
    e.preventDefault();
    let timerInterval,
        tipo = $(this).val();
    Swal.fire({
      title: 'Procesando...',
      html: 'La ventana se cerrará en <b></b> milisegundos.',
      timer: 500,
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

    fetch('api/productos/filtrar/'+tipo).then(res => res.json()
     ).then(function(data){
      if(data){
        console.log(data)
        let template = "",
            presentacion = "",
            unidad = "";
        data.data.forEach(e => {
                        
            if(e.presentacion != 0){
                if(e.tipo == "ayudasTecnicas"){
                    presentacion = (e.tipo_ayudas != null) ? e.tipo_ayudas.descripcion : "";
                  }
                  
                  if(e.tipo == "medicamento"){
                    presentacion = (e.tipo_medicamentos != null) ? e.tipo_medicamentos.descripcion : "";
                  }
                  
                  if(e.tipo == "insumo"){
                    presentacion = (e.tipo_insumo != null ) ? e.tipo_insumo.descripcion : "";
                  }
            }else{
              presentacion = `<span class="text-muted"><b><i>Sin asignar</i></b></span>`
            }

            if(e.peso != null && e.unidad != null){
              unidad = e.peso + " " + e.unidad;
            }

            if(e.peso == null){
              unidad = e.unidad;
            }

            if(e.peso == null && e.unidad == null){
              unidad = "<span class='text-muted'><b><i>Sin asignar</i></b></span>"
            }
           
            template += `
                <tr>
                  <td>${e.id}</td>
                  <td>${e.nombre_producto.toUpperCase()}</td>
                  <td>${(e.existencia <= 0) ? 0 : e.existencia}</td>
                  <td>${presentacion.toUpperCase()}</td>
                  <td>${unidad.toUpperCase()}</td>
                  <td>
                    <a href="#" class="btn btn-info edit" data-id="${e.id}" title="Editar registro"><i class="fa fa-edit"></i></a>
                    <a href="#" class="btn btn-dark delete" data-id="${e.id}" title="Eliminar registro"><i class="fa fa-trash"></i></a>
                  </td>
                </tr>
            `;
        });
        $('#tabla-productos').DataTable().destroy();
        $('#tabla-productos tbody').html(template); 
        $('#tabla-productos').DataTable({
            "responsive": true, 
            "lengthChange": false, 
            "autoWidth": false,
            "language": {
            "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            },
        });

      }

     }).catch(function(err){
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'err'
          })
        console.log(err)
     })
  })
  
// unidad peso
$(document).on('click', '.radioTipo',function(e){
  var radioTipo = $(this).prop("id");
  if(radioTipo == "tipoMed1"){
    $("#unidad").prop("disabled", false)
    $("#peso").prop("disabled", false)
  }else if(radioTipo == "tipoMed2"){
    $("#unidad").prop("disabled", true)
    $("#peso").prop("disabled", true)
  }
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

      fetch('api/producto/destroy/'+id, {
        method: 'GET',
      }).then(res => res.text()
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
  return await fetch('api/productos')
               .then(response => response.json())
               .then(res => {
                  let template = "",
                      template_productos = "",
                      template_tipo_select = "",
                      unidad = "",
                      presentacion = "",
                      i = 1;

                      res.data.productos.forEach(e => {
                      
                        if(e.presentacion != 0){
                          if(e.tipo == "ayudasTecnicas"){
                              presentacion = (e.tipo_ayudas != null) ? e.tipo_ayudas.descripcion : "";
                            }
                            
                            if(e.tipo == "medicamento"){
                              presentacion = (e.tipo_medicamentos != null) ? e.tipo_medicamentos.descripcion : "";
                            }
                            
                            if(e.tipo == "insumo"){
                              presentacion = (e.tipo_insumo != null ) ? e.tipo_insumo.descripcion : "";
                            }
                        }else{
                          presentacion = `<span class="text-muted"><b><i>Sin asignar</i></b></span>`
                        }

                        

                        template_productos += `
                          <tr>
                          <td>${e.id}</td>
                          <td>${e.nombre_producto.toUpperCase()}</td>
                          <td>${(e.existencia <= 0) ? 0 : e.existencia}</td>
                          <td>
                              ${presentacion.toUpperCase()}
                          </td>
                          <td class="unidad">${unidad.toUpperCase()}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit" data-id="${e.id}">
                              <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete" data-id="${e.id}">
                              <i class="fas fa-trash"></i>
                            </button>
                          </td>
                        </tr>`;


                        })
                        template_tipo_select = `<optgroup label="Medicamento">`
                        res.data.tipo_medicamentos.forEach(e => {
                        template_tipo_select += `<option value="${e.id}">${e.descripcion}</option>`;
                        });
                        template_tipo_select += `</optgroup>`

                        template_tipo_select += `<optgroup label="Insumos">`
                        res.data.tipo_insumos.forEach(e => {
                        template_tipo_select += `<option value="${e.id}">${e.descripcion}</option>`;
                        });
                        template_tipo_select += `</optgroup>`


                        template_tipo_select += `<optgroup label="Ayudas">`
                        res.data.tipo_ayuda.forEach(e => {
                        template_tipo_select += `<option value="${e.id}">${e.descripcion}</option>`;
                        });
                        template_tipo_select += `</optgroup>`







              

                        $('#tabla-productos').DataTable().destroy();
                        $('#tabla-productos tbody').html(template_productos);
                        $('#tabla-productos').DataTable({
                        "responsive": true, 
                        "ordering": false,
                        "language": {
                        "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                        }
                        });

                        $("[name=presentacion]").html(template_tipo_select);
            })

}
</script>
@endsection