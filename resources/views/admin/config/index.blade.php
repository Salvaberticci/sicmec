@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Configuración de Twilio y SMS</h3>
                </div>

                @if(session('success'))
                    <div class="alert alert-success m-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('config.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Estos datos se utilizan para enviar notificaciones
                            automáticas vía SMS cada vez que se crea o aprueba una solicitud.
                        </div>

                        <div class="form-group">
                            <label for="twilio_sid">Twilio Account SID</label>
                            <input type="text" class="form-control" id="twilio_sid" name="twilio_sid"
                                value="{{ $config->twilio_sid ?? '' }}" placeholder="Ingrese SID de cuenta">
                        </div>

                        <div class="form-group">
                            <label for="twilio_token">Twilio Auth Token</label>
                            <input type="password" class="form-control" id="twilio_token" name="twilio_token"
                                value="{{ $config->twilio_token ?? '' }}" placeholder="Ingrese Token de autenticación">
                        </div>

                        <div class="form-group">
                            <label for="twilio_from">Número de origen (Twilio)</label>
                            <input type="text" class="form-control" id="twilio_from" name="twilio_from"
                                value="{{ $config->twilio_from ?? '' }}" placeholder="Ej: +1234567890">
                        </div>

                        <div class="form-group">
                            <label for="twilio_to_default">Número de destino predeterminado (Trial)</label>
                            <input type="text" class="form-control" id="twilio_to_default" name="twilio_to_default"
                                value="{{ $config->twilio_to_default ?? '' }}" placeholder="Ej: +584121234567">
                            <small class="form-text text-muted">Debido a la versión gratuita de Twilio, todos los mensajes
                                se enviarán únicamente a este número verificado.</small>
                        </div>

                        <hr>
                        <h4 class="mt-4"><i class="fab fa-telegram"></i> Configuración de Telegram</h4>

                        <div class="form-group">
                            <label for="telegram_bot_token">Telegram Bot Token</label>
                            <input type="password" class="form-control" id="telegram_bot_token" name="telegram_bot_token"
                                value="{{ $config->telegram_bot_token ?? '' }}" placeholder="Ingrese Token de @BotFather">
                            <small class="form-text text-muted">Este token permite que el bot interactúe con los
                                beneficiarios para consultar estatus.</small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection