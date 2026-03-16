<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 580px;
            margin: 30px auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #1a3c6b;
            color: white;
            padding: 25px 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 13px;
            opacity: 0.85;
        }

        .body {
            padding: 28px 30px;
            color: #333;
        }

        .body h2 {
            font-size: 18px;
            color: #1a3c6b;
            margin-top: 0;
        }

        .info-box {
            background: #f0f5ff;
            border-left: 4px solid #1a3c6b;
            padding: 15px 18px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info-box strong {
            color: #1a3c6b;
        }

        .steps {
            margin: 20px 0;
        }

        .step {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }

        .step-num {
            background: #1a3c6b;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            min-width: 24px;
            text-align: center;
            line-height: 24px;
            font-size: 13px;
            font-weight: bold;
            margin-right: 12px;
        }

        .step p {
            margin: 0;
            font-size: 14px;
            line-height: 22px;
            color: #444;
        }

        .telegram-box {
            background: #e3f2fd;
            border-radius: 6px;
            padding: 15px 18px;
            text-align: center;
            margin: 20px 0;
        }

        .telegram-box p {
            margin: 0;
            font-size: 14px;
        }

        .telegram-box a {
            color: #0277bd;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            background: #f4f6f9;
            text-align: center;
            padding: 15px;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🏥 Sistema SICMEC</h1>
            <p>Solicitud de Medicamentos y Ayudas</p>
        </div>
        <div class="body">
            <h2>¡Hola, {{ $factura->cliente->nombre }}!</h2>
            <p>Tu solicitud fue recibida correctamente. Adjunto a este correo encontrarás tu <strong>planilla
                    oficial</strong> en formato PDF.</p>

            <div class="info-box">
                <p>📋 <strong>N° de Solicitud:</strong> #{{ $factura->id }}</p>
                <p>📅 <strong>Fecha:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</p>
                @if($factura->medico_tratante)
                    <p>👨‍⚕️ <strong>Médico:</strong> {{ $factura->medico_tratante }}</p>
                @endif
                @if($factura->patologia)
                    <p>🏥 <strong>Patología:</strong> {{ $factura->patologia }}</p>
                @endif
                <p>📊 <strong>Estatus actual:</strong>
                    <span style="background: {{ $factura->estatus == 'Aprobada' || $factura->estatus == 'Finalizado' ? '#d4edda' : ($factura->estatus == 'Procesando' ? '#fff3cd' : '#e2e3e5') }}; 
                                 color: {{ $factura->estatus == 'Aprobada' || $factura->estatus == 'Finalizado' ? '#155724' : ($factura->estatus == 'Procesando' ? '#856404' : '#383d41') }}; 
                                 padding: 4px 10px; border-radius: 4px; font-weight: bold;">
                        {{ strtoupper($factura->estatus) }}
                    </span>
                </p>
                <p>💊 <strong>Total de ítems:</strong> {{ $factura->total_medicamentos }}</p>
            </div>

            <div class="steps">
                <p><strong>Próximos pasos:</strong></p>
                <div class="step">
                    <div class="step-num">1</div>
                    <p>Descarga y guarda tu planilla PDF adjunta (impresa o en el celular).</p>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <p>Consulta el estado de tu solicitud en tiempo real a través del Bot de Telegram.</p>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <p>Cuando sea aprobada, recibirás un SMS y podrás retirar en la oficina con tu planilla.</p>
                </div>
            </div>

            <div class="telegram-box">
                <p>🤖 Consulta el estado de tu solicitud en:</p>
                <a href="https://t.me/sicmec_ayuda_bot">@sicmec_ayuda_bot</a>
            </div>
        </div>
        <div class="footer">
            <p>Este correo fue generado automáticamente por el Sistema SICMEC. No responder a este mensaje.</p>
        </div>
    </div>
</body>

</html>