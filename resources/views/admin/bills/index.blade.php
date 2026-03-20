@extends('layouts.app')

@section('styles')
  {{--
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
@endsection

@section('content')


  <!-- Modal -->
  <div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-plus"></i> Nueva solicitud de medicamentos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="form-bill">
            @csrf
            <div class="row ">

              <div class="col-md-8 border-right">
                <div class="alert alert-info">
                  <p><i class="fas fa-info-circle"></i> Los campos con <b>(*)</b> son obligatorios.</p>
                </div>
                <div class="row justify-content-center align-items-center">
                  <div class="col-md-9">
                    <div class="row ml-2">
                      <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" name="nombre" required id="nombre"
                          onkeypress="return validator.soloLetras(event)" placeholder="Nombre y apellido (*)">
                      </div>

                      <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" name="cedula" id="cedula"
                          onkeypress="return validator.soloNumeros(event)" placeholder="Cédula">
                      </div>


                      <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" name="telefono" id="telefono"
                          onkeypress="return validator.soloNumeros(event)" placeholder="Teléfono">
                      </div>

                    </div>

                    <div class="row ml-2 mt-3">

                      <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Dirección">
                      </div>

                      <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" name="nro_expediente" id="nro_expediente"
                          onkeypress="return validator.soloNumeros(event)" placeholder="Número Expediente">
                      </div>

                      <div class="col-md-4 col-sm-4">
                        <input type="text" class="form-control" name="ubch_centro_electoral" id="ubch_centro_electoral"
                          onkeypress="return validator.soloLetras(event)" placeholder="Centro Electoral">
                      </div>
                    </div>

                    <div class="row ml-2 mt-3">
                      <div class="col-md-8 col-sm-8">
                        <input type="email" class="form-control" name="correo" id="correo"
                          placeholder="📧 Correo electrónico (se enviará la planilla PDF)">
                      </div>
                      <div class="col-md-4 col-sm-4">
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Opcional. Si se ingresa, el sistema
                          enviará automáticamente la planilla de solicitud al correo indicado.</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 d-md-inline-block align-self-center ">
                    <button type="button" id="add-product" class="btn btn-primary" data-toggle="modal"
                      data-target="#products" disabled style="height: 90px; margin-right: 10px;">
                      <i class="fas fa-prescription-bottle-alt"></i>
                      Añadir medicamento
                    </button>
                  </div>
                </div>
                <hr>
                <table class="table bordered table-striped">
                  <thead class="thead-dark">
                    <tr class="text-center">
                      <th>Nombre del producto</th>
                      <th>Cantidad</th>
                      <th>Presentación</th>
                      <th>Tipo</th>
                      <th>Unidad</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody id="products-body">

                  </tbody>
                  {{-- <tfoot>
                    <tr>
                      <th colspan="3"></th>
                      <th class="h3 text-center"><b>Total Venta</b>:</th>
                      <th class="h3" id=""></th>
                    </tr>
                  </tfoot> --}}
                </table>


              </div>
              <div class="col-md-4">
                <div class="w-100 bg-dark p-4">
                  <div class="row">
                    <div class="col-md-5">
                      <h4><b>Total Medicamentos</b>:</h4>
                    </div>
                    <div class="col-md-6 text-right">
                      <h4 id="total-medicamentos"></h4>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="form-group">
                  <label for="observacion">Código de VenAPP</label>
                  <input type="text" name="observacion" id="observacion" class="form-control">
                </div>

                <div class="form-group">
                  <label for="atendido_por">Atendido por</label>
                  <input type="text" name="atendido_por" id="atendido_por" class="form-control">
                </div>


                <select class="form-control mb-3 mt-3" name="estatus" id="estatus" required>
                  <option value>Selecciona el estatus</option>
                  <option value="En espera">En espera</option>
                  <option value="Procesando">Procesado</option>
                  <option value="Finalizado">Finalizado</option>
                </select>


                <hr>
                <div class="form-group">
                  <button class="btn btn-success btn-lg w-100 mr-2 ml-1" id="btn-submit"><i
                      class="fa fa-check-circle"></i> Finalizar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> --}}

        </div>
      </div>
    </div>
  </div>
  {{-- Products --}}
  <div class="modal" tabindex="-1" role="dialog" id="products">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Inventario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <h4>Añadir producto manual</h4>
            <hr>
            <form id="form-handle-product">
              <div class="row justify-content-start align-items-center">
                <div class="form-group" style="width: 33.3% !important;">
                  <label for="nombre_producto">Nombre del producto</label>
                  <input type="text" name="nombre_producto_handle" class="form-control">
                </div>
                <div class="form-group ml-2" style="width: 30% !important;">
                  <label for="cantidad">Cantidad</label>
                  <input type="text" name="cantidad_handle" class="form-control"
                    onkeypress="return validator.soloNumeros(event)">
                </div>
                <div class="form-group ml-2" style="width: 33.3% !important;">
                  <label for="presentacion_handle">Presentación</label>
                  <select class="form-control" name="presentacion_handle">


                  </select>
                </div>
                <div class="form-group ml-2" style="width: 33% !important;">
                  <label for="tipo_handle">Tipo:</label>
                  <select name="tipo_handle" class="form-control" required>
                    <option value="medicamento">Medicamentos</option>
                    <option value="insumo">Insumos médicos</option>
                    <option value="ayudasTecnicas">Ayudas Técnicas</option>
                  </select>
                </div>
                <div class="form-group w-25 ml-2" style="width: 33% !important;">
                  <label for="unidad">Unidad</label>
                  <input type="text" name="unidad_handle" class="form-control" placeholder="500 Miligramos">
                </div>
                <button class="btn btn-info btn-sm mt-3 ml-2"><i class="fas fa-plus"></i> Agregar producto</button>
              </div>
            </form>
          </div>

          <div class="container-fluid">
            <h4>Inventario registrado</h4>
            <hr>
            <div class="table-responsive">
              <table class="table table-bordered table-striped dataTable w-100" id="tabla-productos">
                <thead>
                  <th>#</th>
                  <th>Descripción</th>
                  <th>Cantidad</th>
                  <th>Existencia</th>
                  <th>Presentación</th>
                  <th>Unidad</th>
                  <th></th>
                </thead>
                <tbody id="tbody-productos">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> --}}
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="view" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detalles de la factura</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col ml-8">
                <p><span class="font-weight-bold">Beneficiario:</span> <br> <span id="nombre-d"></span></p>
              </div>
              <div class="col">
                <p><span class="font-weight-bold">Telefono:</span> <br> <span id="telefono-d"></span></p>
              </div>
              <div class="col">
                <p><span class="font-weight-bold">Direccion:</span> <br> <span id="direccion-d"></span></p>
              </div>

              <div class="col m-8">
                <p class="m-8"><span class="font-weight-bold">Número de expediente:</span> <br> <span
                    id="nro_expediente-d"></span></p>
              </div>
              <div class="col">
                <p><span class="font-weight-bold">Centro electoral:</span> <br> <span id="ubch_centro_electoral-d"></span>
                </p>
              </div>
              <div class="col">
                <p><span class="font-weight-bold">Código VenAPP:</span> <br> <span id="observacion-d"></span></p>
              </div>
              <div class="col">
                <p><span class="font-weight-bold">📧 Correo:</span> <br> <span id="correo-d"></span></p>
              </div>
            </div>
          </div>


          <table class="table table-bordered table-striped">
            <thead class="thead-dark text-center mt-5">
              <tr class="text-center">
                <th>Nombre del producto</th>
                <th>Cantidad</th>
                <th>Presentación</th>
                <th>Tipo</th>
                <th>Unidad</th>
              </tr>
            </thead>
            <tbody id="products-body-d">

            </tbody>
          </table>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <section class="container-fluid p-4 bg-white">
    <a href="#" class="btn btn-primary btn-lg" id="btn-add" data-toggle="modal" data-target="#add"
      style="color: white !important;"><i class="fa fa-plus"></i> Nueva solicitud</a>
    <div class="my-4"></div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Solicitudes Registradas</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body">

        <table id="tabla-solicitudes" class="table table-bordered table-striped text-center">
          <thead>
            <tr>
              <th>#</th>
              <th>Nombre y apellido</th>
              <th>Cedula</th>
              <th>Teléfono</th>
              <th>Direccion</th>
              <th>Estatus</th>
              <th>Fecha</th>
              <th>UD</th>
              <th>VenAPP</th>
              <th>Atendido Por</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
          <tfoot>
            <tr>
              <th>#</th>
              <th>Nombre y apellido</th>
              <th>Cedula</th>
              <th>Teléfono</th>
              <th>Direccion</th>
              <th>Estatus</th>
              <th>Fecha</th>
              <th>UD</th>
              <th>VenAPP</th>
              <th>Atendido Por</th>
              <th class="text-center">Acciones</th>
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
    var products = [];

    index();

    $('#btn-add').click(function () {
      $('#form-bill-edit').attr('id', 'form-bill');
      $('#form-bill').trigger('reset');
      $('#btn-submit').attr('class', 'btn btn-success btn-lg').html('<i class="fa fa-check"></i> Registrar');
      $('#staticBackdropLabel').html('<i class="fa fa-plus"></i> Registrar salida');
      products = [];
      index_cart();
    });

    $('#nombre').change(function () {
      let val = $(this).val();
      if (val != "") {
        $('#add-product').removeAttr("disabled");
      } else {
        $('#add-product').attr("disabled", "disabled");
      }
    })

    // $(document).on('keyup', '.cantidad', function(){
    //     let cantidad = $(this).val(),  
    //         existencia = $(this).parent().parent().children('td.existencia').text(),
    //         precio = $(this).parent().parent().children('td.precio').text(),
    //         total = parseFloat(cantidad).toFixed(2) * parseFloat(precio).toFixed(2);

    //         if(cantidad > existencia){
    //           $(this).val(existencia).triggerHandler('change');
    //           total = parseFloat(existencia).toFixed(2) * parseFloat(precio).toFixed(2);
    //         }

    //         if(cantidad == "" || cantidad == 0){
    //           $(this).parent().parent().children('td.total').html(0);  
    //         }else{

    //           $(this).parent().parent().children('td.total').html(total.toFixed(2));
    //         }
    // })

    $(document).on('submit', '#form-handle-product', function (e) {
      e.preventDefault();
      products.push({
        id: "P" + products.length,
        descripcion: $('[name=nombre_producto_handle]').val(),
        cantidad: $('[name=cantidad_handle]').val(),
        tipo: $('[name=tipo_handle]').val(),
        presentacion: $('[name=presentacion_handle]').val(),
        presentacionText: $('[name=presentacion_handle] option:selected').text(),
        unidad: $('[name=unidad_handle]').val(),
      });
      console.log(products)
      index_cart();
    })





    $(document).on('click', '.btn-plus', function () {
      let repeat = 0,
        i = 0,
        id = $(this).parent().parent().children('td.id').text(),
        descripcion = $(this).parent().parent().children('td.nombre_producto').text(),
        existencia = $(this).parent().parent().children('td.existencia').text(),
        cantidad = $(this).parent().parent().children('td.r-cantidad').children('input.cantidad').val(),
        presentacion = $(this).parent().parent().children('td.tipo').text(),
        unidad = $(this).parent().parent().children('td.unidad').text(),
        verSuma = 0;
      if (cantidad > 0 || cantidad != "") {
        products.forEach(e => {
          if (e.id == id) {
            products[i].cantidad = parseFloat(products[i].cantidad) + parseFloat(cantidad);
            products[i].total = parseFloat(products[i].cantidad) * (parseFloat(products[i].precio));
            repeat = 1;
            return true;
          }
          i += 1;
        });

        if (!repeat) {
          let product = {
            id: id,
            descripcion: descripcion,
            cantidad: cantidad,
            existencia: existencia,
            tipo: presentacion,
            unidad: unidad,
          }

          products.push(product);
          check_cart();
        }
        $(this).parent().parent().children('td.r-cantidad').children('input.cantidad').val(0)
        index_cart();
        repeat = 0;
        $.notify({
          icon: "fas fa-check-circle",
          message: "Medicamento añadido correctamente"

        }, {
          type: "success",
          timer: 200
        });
      } else {
        alert("La cantidad del producto no puede ser 0");
      }
    })

    //delete
    $(document).on('click', '.delete-product', function () {
      delete_product($(this).attr('data-id'));
      index_cart();
      check_cart();
    })

    function index_cart() {
      let template = "",
        total_medicamentos = 0;

      if (products.length > 0) {
        products.forEach(e => {
          template += `
                  <tr class="text-center">
                    <td>${e.descripcion}</td>
                    <td>${e.cantidad}</td>
                    <td>${e.presentacionText}</td>
                    <td>${e.tipo}</td>
                    <td>${e.unidad}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-product" data-id="${e.id}" title="Eliminar producto"><i class="fa fa-trash"></i></button>  
                    </td>
                  </tr>
                `;
          total_medicamentos = parseFloat(total_medicamentos) + parseFloat(e.cantidad);
        });
        $('#products-body').html(template);
        $('#total-medicamentos').html(total_medicamentos.toFixed());
      } else {
        $('#products-body').html("");
        $('#total-medicamentos').html(0);

      }
    }





    function delete_product(id) {
      let i = 0;
      products.forEach(e => {
        if (e.id == id) {
          products.splice(i, 1);
        }
        i += 1;
      });
    }

    function check_cart() {
      if (products.length > 0) {
        $('#metodo_pago').removeAttr('disabled').triggerHandler('change');
        $('#referencia').removeAttr('disabled').triggerHandler('change');
      } else {
        $('#metodo_pago').attr('disabled', 'disabled').triggerHandler('change');
        $('#referencia').attr('disabled', 'disabled').triggerHandler('change');
        $('#btn-submit').attr('disabled');
      }
    }

    $(document).on('change', '#metodo_pago', function () {
      $('#btn-submit').removeAttr('disabled');
    })


    $(document).on('submit', '#form-bill', function (e) {
      e.preventDefault();
      let form = new FormData(this);
      form.append('products', JSON.stringify(products));
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

      fetch('api/facturas/store', {
        method: 'POST',
        body: form
      }).then(res => res.json()
      ).then(function (data) {
        if (data) {
          $('#form-bill').trigger("reset");
          Swal.fire(
            '¡Perfecto!',
            'Registro realizado con éxito',
            'success'
          )
          index();
        }

      }).catch(function (err) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'err'
        })
        // console.log(err)
      })
    })



    // $('#cedula').keyup(function(e){
    //   e.preventDefault();
    //   let timerInterval;
    //   id = $(this).val();
    //   fetch('api/cliente/cedula/'+id, {
    //     method: 'GET',
    //   }).then(res => res.json()
    //    ).then(function(data){
    //     if(data){
    //       $('#add').modal('show');
    //       $('input[name=nombre]').val(data.nombre).triggerHandler('change');
    //       $('input[name=cedula]').val(data.cedula);
    //       $('input[name=telefono]').val(data.telefono);
    //       $('input[name=direccion]').val(data.direccion);
    //       $('input[name=nro_expediente]').val(data.nro_expediente);
    //       $('input[name=ubch_centro_electoral]').val(data.ubch_centro_electoral);

    //     }      

    //    }).catch(function(err){
    //       Swal.fire({
    //           icon: 'error',
    //           title: 'Oops...',
    //           text: 'err'
    //         })
    //       // console.log(err)
    //    })
    // })



    //borrar

    $(document).on('click', '.delete', function (e) {
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

          fetch('api/facturas/destroy/' + id, {
            method: 'GET',
          }).then(res => res.text()
          ).then(function (data) {
            if (data) {

              Swal.fire(
                '¡Perfecto!',
                'Registro eliminado con éxito',
                'success'
              )
              index();
            }

          }).catch(function (err) {
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

    $(document).on('click', '.edit', function (e) {
      e.preventDefault();
      let timerInterval;
      id = $(this).attr('data-id');
      products = [];
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

      fetch('api/facturas/' + id, {
        method: 'GET',
      }).then(response => response.json()
      ).then(function (res) {
        console.log(res)
        let presentacion = "",
          unidades = "";
        $('#add').modal('show');
        $('input[name=cedula]').val(res.data.cliente.cedula);
        $('input[name=nombre]').val(res.data.cliente.nombre);
        $('input[name=direccion]').val(res.data.cliente.direccion);
        $('input[name=telefono]').val(res.data.cliente.telefono);
        $('input[name=nro_expediente]').val(res.data.cliente.nro_expediente);
        $('input[name=ubch_centro_electoral]').val(res.data.cliente.ubch_centro_electoral);
        $('input[name=correo]').val(res.data.cliente.correo);
        $('input[name=observacion]').val(res.data.observacion);
        $('input[name=atendido_por]').val(res.data.atendido_por);
        $('select[name=estatus]').prepend(`<option selected>${res.data.estatus}</option>`);

        res.data.facturas_renglones.forEach(e => {
          if (e.producto.presentacion != 0) {
            if (e.producto.tipo == "ayudasTecnicas") {
              presentacion = e.producto.tipo_ayudas.descripcion
            }

            if (e.producto.tipo == "medicamento") {
              presentacion = e.producto.tipo_medicamentos.descripcion
            }

            if (e.producto.tipo == "insumo") {
              presentacion = e.producto.tipo_insumo.descripcion
            }

          } else {
            presentacion = "<span class='text-muted'><b><i>Sin asignar</i></b></span>"
          }


          unidades = (e.peso != null || e.unidad != null) ? e.peso + " " + e.unidad : "<span><b><i>No aplica</i></b></span>";
          products.push({
            id: e.producto_id,
            descripcion: e.producto.nombre_producto,
            cantidad: e.cantidad,
            presentacion: e.producto.presentacion,
            presentacionText: presentacion,
            tipo: e.producto.tipo,
            unidad: unidades,
          });
        })
        index_cart();

        $('#nombre').trigger('change');
        $('#form-bill').attr('id', 'form-bill-edit');
        $('#btn-submit').attr('class', 'btn btn-primary btn-lg w-100 p-2').html('<i class="fa fa-check"></i> Modificar registro');
        $('#staticBackdropLabel').html('<i class="fa fa-edit"></i> Modificar registro');


      }).catch(function (err) {
        Swal.fire({
          icon: 'error',
          text: 'err'
        })
        console.log(err)
      })
    })
    // Editar Cliente
    $(document).on('submit', '#form-bill-edit', function (e) {
      e.preventDefault();
      console.log(id)
      let form = new FormData(this);
      form.append('products', JSON.stringify(products));
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

      fetch('api/facturas/update/' + id, {
        method: 'POST',
        'X-CSRF-TOKEN': "{{csrf_token()}}",
        body: form
      }).then(res => res.text()
      ).then(function (data) {
        console.log(data)
        if (data) {
          $('#form-client-edit').trigger("reset");
          Swal.fire(
            '¡Perfecto!',
            'Registro modificado con éxito',
            'success'
          )
          index();
        }

      }).catch(function (err) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'err'
        })
        // console.log(err)
      })
    })

    $('.show').click(function (e) {
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

      fetch('api/facturas/' + id, {
        method: 'GET',
      }).then(response => response.json()
      ).then(function (res) {
        $('#add').modal('show');
        $('show[name=cedula]').val(res.data.cliente.cedula);
        $('show[name=nombre]').val(res.data.cliente.nombre);
        $('show[name=direccion]').val(res.data.cliente.direccion);
        $('show[name=telefono]').val(res.data.cliente.telefono);
        $('show[name=nro_expediente]').val(res.data.cliente.nro_expediente);
        $('show[name=ubch_centro_electoral]').val(res.data.cliente.ubch_centro_electoral);
        $('show[name=observacion]').val(res.data.observacion);
        $('select[name=estatus]').val(res.data.estatus);

        res.data.facturas_renglones.forEach(e => {
          products.push({
            id: e.producto_id,
            descripcion: e.producto.nombre_producto,
            cantidad: e.cantidad,
            presentacion: e.producto.presentacion,
            tipo: e.producto.tipo,
            unidad: e.producto.unidad,
          });
        })
        index_cart();
        $('#nombre').trigger('change');
        $('#form-bill').attr('id', 'form-bill-edit');
        $('#btn-submit').attr('class', 'btn btn-primary btn-lg w-100 p-2').html('<i class="fa fa-check"></i> Modificar registro');
        $('#staticBackdropLabel').html('<i class="fa fa-edit"></i> Modificar registro');


      }).catch(function (err) {
        Swal.fire({
          icon: 'error',
          text: 'err'
        })
        console.log(err)
      })
    })
    // mostrar
    $(document).on('click', '.btn-examinar', function () {
      let id = $(this).attr('data-id'),
        template = "";
      fetch('api/facturas/' + id)
        .then(response => response.json()
        ).then(res => {
          console.log(res)
          let presentacion = "",
            unidades = "";
          // $('#id').html();
          $('#nombre-d').html(res.data.cliente.nombre)
          $('#telefono-d').html(res.data.cliente.telefono)
          $('#direccion-d').html(res.data.cliente.direccion)
          $('#nro_expediente-d').html(res.data.cliente.nro_expediente)
          $('#ubch_centro_electoral-d').html(res.data.cliente.ubch_centro_electoral)
          $('#observacion-d').html(res.data.observacion)
          $('#correo-d').html(res.data.cliente.correo)
          $('#total_medicamentos-d').html(res.data.total_medicamentos)

          res.data.facturas_renglones.forEach(e => {
            if (e.presentacion != 0) {
              if (e.tipo == "ayudasTecnicas") {
                presentacion = (e.tipo_ayudas != null) ? e.tipo_ayudas.descripcion : "";
              }

              if (e.tipo == "medicamento") {
                presentacion = (e.tipo_medicamentos != null) ? e.tipo_medicamentos.descripcion : "";
              }

              if (e.tipo == "insumo") {
                presentacion = (e.tipo_insumo != null) ? e.tipo_insumo.descripcion : "";
              }

            } else {
              presentacion = "<span class='text-muted'><b><i>Sin asignar</i></b></span>"
            }


            unidades = (e.peso != null || e.unidad != null) ? e.peso + " " + e.unidad : "<span><b><i>No aplica</i></b></span>";
            template += `
            <tr class="text-center">
              <td>${e.producto.nombre_producto}</td>
              <td>${e.cantidad}</td>
              <td>${presentacion}</td>
              <td>${e.producto.tipo}</td>
              <td>${unidades}</td>
            </tr>
            `
          })

          $('#products-body-d').html(template)


        }).catch(err => {
          console.log(err)
        })

      $("#view").modal('show');
    })

    async function index() {
      return await fetch('api/facturas')
        .then(response => response.json())
        .then(res => {
          console.log("Hola")
          let template = "",
            template_productos = "",
            template_tipo_select = "",
            unidad = "",
            presentacion = "",
            i = 1;



          res.data.solicitudes.forEach(e => {
            const fechaISO = e.created_at;
            const fecha = new Date(fechaISO);

            // Formatear la fecha a dd/mm/yyyy
            const dia = fecha.getDate().toString().padStart(2, '0');
            const mes = (fecha.getMonth() + 1).toString().padStart(2, '0'); // Enero es 0
            const anio = fecha.getFullYear();

            const fechaFormateada = `${dia}/${mes}/${anio}`;
            template += `
                        <tr>
                          <td>${i}</td>
                          <td>${e.cliente.nombre}</td>
                          <td>${(e.cliente.cedula != null) ? e.cliente.cedula : "S/N"}</td>
                          <td>${(e.cliente.telefono != null) ? e.cliente.telefono : "S/N"}</td>
                          <td>${(e.cliente.direccion != null && e.cliente.direccion != "") ? e.cliente.direccion : "S/D"}</td>
                          <td>${e.estatus}</td>
                          <td>${fechaFormateada}</td>
                          <td>${e.total_medicamentos}</td>
                          <td>${(e.cliente.observacion != null && e.cliente.observacion != "") ? e.cliente.observacion : "S/N"}</td>
                          <td>${e.atendido_por}</td>

                          <td class="d-flex justify-content-center">
                            <a href="#" data-id="${e.id}"  class="btn btn-secondary btn-sm btn-examinar m-1" title="Examinar registro"><i class="fa fa-search"></i></a>
                            <a href="#" data-id="${e.id}" class="btn btn-info btn-sm edit m-1" title="Editar registro"><i class="fa fa-edit"></i></a>
                            <a href="#" data-id="${e.id}" class="btn btn-dark btn-sm delete m-1" title="Eliminar registro"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>`;

            i++;
          })

          res.data.productos.forEach(e => {

            if (e.presentacion != 0) {
              if (e.tipo == "ayudasTecnicas") {
                presentacion = (e.tipo_ayudas != null) ? e.tipo_ayudas.descripcion : "";
              }

              if (e.tipo == "medicamento") {
                presentacion = (e.tipo_medicamentos != null) ? e.tipo_medicamentos.descripcion : "";
              }

              if (e.tipo == "insumo") {
                presentacion = (e.tipo_insumo != null) ? e.tipo_insumo.descripcion : "";
              }
            } else {
              presentacion = `<span class="text-muted"><b><i>Sin asignar</i></b></span>`
            }

            if (e.peso != null && e.unidad != null) {
              unidad = e.peso + " " + e.unidad;
            }

            if (e.peso == null) {
              unidad = e.unidad;
            }

            if (e.peso == null && e.unidad == null) {
              unidad = "<span class='text-muted'><b><i>Sin asignar</i></b></span>"
            }

            template_productos += `
                          <tr>
                          <td class="id">${e.id}</td>
                          <td class="nombre_producto">${e.nombre_producto}</td>
                          <td class="r-cantidad"><input type="text" min="1" value="1" class="form-control cantidad" onkeypress="return validator.soloNumeros(event)"></td>
                          <td class="existencia">${(e.existencia <= 0) ? 0 : e.existencia}</td>
                          <td class="tipo">
                              ${presentacion}
                          </td>
                          <td class="unidad">${unidad}</td>
                          <td>
                            <button type="button" class="btn btn-primary btn-sm btn-plus w-100">
                              <i class="fa fa-plus"></i>
                            </button>
                          </td>
                        </tr>`;


          })
          console.log(res)
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







          $('#tabla-solicitudes').DataTable().destroy();
          $('#tabla-solicitudes > tbody').html(template);
          $('#tabla-solicitudes').DataTable({
            "responsive": true,
            "ordering": false,
            "language": {
              "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            }
          });


          $('#tabla-productos').DataTable().destroy();
          $('#tbody-productos').html(template_productos);
          $('#tabla-productos').DataTable({
            "responsive": true,
            "ordering": false,
            "language": {
              "url": '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
            }
          });

          $("[name=presentacion_handle]").html(template_tipo_select);
        })
    }

  </script>
@endsection