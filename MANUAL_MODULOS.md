# Manual de Nuevos Módulos y Actualizaciones - SICMEC 🏥

Este documento detalla todas las nuevas implementaciones, módulos y mejoras realizadas en el sistema SICMEC para mejorar la comunicación con los beneficiarios y la generación de reportes.

---

## 📋 Resumen de Nuevas Funcionalidades

1. **Notificaciones Automáticas por Correo Electrónico (PDF adjunto)**
2. **Notificaciones Automáticas por SMS (Vía Twilio)**
3. **Módulo de Configuración Dinámica**
4. **Reportes PDF Profesionales y Unificados**
5. **ChatBot Interactivo de Telegram**

---

## 1. Notificaciones por Correo Electrónico 📧

El sistema ahora envía correos electrónicos de manera automática a los beneficiarios cada vez que hay una interacción importante con su solicitud de medicamentos o ayudas técnicas.

*   **Creación de Solicitud:** Al registrar una nueva factura/solicitud, el sistema genera automáticamente la planilla oficial en PDF con el estilo institucional y la envía como archivo adjunto al correo del beneficiario (si lo proporcionó).
*   **Actualización de Estatus:** Cada vez que el administrador actualiza el estatus de la solicitud (Ej. pasa a "Procesando", "Aprobada" o "Finalizada"), se envía un nuevo correo informando el progreso.
*   **Diseño:** Los correos tienen un diseño limpio, institucional (azul oscuro), indican el número de solicitud, fecha, total de ítems, y muestran el estatus resaltado con colores según su estado.
*   **Enlace al Bot:** Todos los correos incluyen ahora un enlace directo al Bot de Telegram para incentivar el autoseguimiento.

## 2. Notificaciones por SMS 📱

Se ha integrado la plataforma **Twilio** para enviar alertas de texto (SMS) directas al teléfono móvil del beneficiario.

*   **Alertas Dinámicas:** Al crear una solicitud, el usuario recibe un SMS confirmando la recepción y su estatus actual.
*   **Seguimiento:** Si la solicitud cambia de estatus, se dispara un SMS automático (Ej. *"Hola [Nombre], tu solicitud #123 ha cambiado a estatus PROCESANDO"*).
*   **Aprobaciones y Finalizaciones:** Mensajes personalizados cuando la ayuda está lista para ser retirada ("APROBADA") o cuando ha sido entregada ("FINALIZADA").
*   Todos los SMS incluyen el enlace directo al bot de Telegram: `https://t.me/sicmec_ayuda_bot`.

## 3. Módulo de Configuración Dinámica ⚙️

Para evitar tener que modificar código interno o archivos ocultos (`.env`) cuando cambian las credenciales de los servicios, se creó un panel de control general.

*   **Ubicación en el Menú:** Accesible mediante el ícono de engranaje (⚙️) en la barra superior del Dashboard del Administrador.
*   **¿Qué hace?:** Permite gestionar visualmente y en tiempo real:
    *   Credenciales de Twilio (SID, Token, Número Remitente).
    *   Token del Bot de Telegram (provisto por @BotFather).

## 4. Mejoras en Reportes PDF 📄

Se modernizó e integró por completo el sistema de reportes en PDF del sistema.

*   **Nueva Plantilla Profesional:** Se creó un diseño unificado (`pdf.layout.blade.php`), estético e institucional (encabezados azules, tablas limpias, márgenes adecuados) para todos los reportes.
*   **Módulos Actualizados:** "Beneficiarios", "Inventario" y "Solicitudes" ahora usan este nuevo formato, haciendo que la información sea mucho más legible.
*   **Navegación Amigable:** Los reportes ahora se abren en una **pestaña nueva** del navegador (modo `stream`) en lugar de forzar una descarga inmediata, permitiendo al administrador revisarlos antes de imprimir o guardar.
*   **Integración de Reporte Directo:** El botón en la página antigua (`reportes-directo.php`) fue actualizado para utilizar el nuevo motor Laravel ("Imprimir PDF Profesional") preservando los filtros de fecha.

## 5. ChatBot Interactivo de Telegram 🤖

El módulo más innovador. Un bot diseñado exclusivamente para que los ciudadanos consulten su información sin necesidad de acceder al sistema web ni requerir atención manual.

*   **Funcionalidad:** Los usuarios inician el bot (`@sicmec_ayuda_bot`) y envían únicamente su número de **Cédula**.
*   **Seguridad y Privacidad:** El bot está blindado. Solo busca en la base de datos de solicitudes. No expone reportes generales ni inventario de la farmacia.
*   **Interactividad mediante Botones:** Una vez que reconoce la cédula, el bot lista las últimas 5 solicitudes mostrando el estatus con iconos intuitivos (✅ ⏳ 💤). Cada solicitud tiene un botón interactivo `["🔍 Detalle Solicitud #ID"]`.
*   **Detalle Exacto:** Al pulsar un botón, el bot muestra los medicamentos o ayudas específicas asociadas a esa solicitud en particular y cualquier observación dejada por el operador.

---

## 🛠️ Detalle Técnico (Para Desarrolladores)

A continuación se explica cómo funciona cada módulo a nivel de código y arquitectura.

### 📧 Sistema de Notificaciones (Email & SMS)
*   **Trigger:** Todo se dispara desde `App\Http\Controllers\FacturasController`.
*   **Métodos involucrados:** `store()` (creación) y `update()` (cambio de estatus).
*   **Email:** Utiliza la clase mailable `App\Mail\SolicitudCreada`. La generación del PDF adjunto se realiza dentro del método `build()` usando el facade `PDF` (`dompdf`).
*   **SMS:** Utiliza el SDK de Twilio. El controlador instancia `Twilio\Rest\Client` usando las credenciales almacenadas en el modelo `Configuracion`.

### ⚙️ Módulo de Configuración
*   **Modelo:** `App\Models\Configuracion`.
*   **Controlador:** `App\Http\Controllers\ConfiguracionController`.
*   **Persistencia:** Los valores se guardan en la tabla `configuracions`. Al ser un modelo de registro único (`singleton` conceptual), el sistema siempre usa `Configuracion::first()`.

### 📄 Generación de PDFs
*   **Motor:** `barryvdh/laravel-dompdf`.
*   **Layout Base:** `resources/views/pdf/layout.blade.php` define los estilos CSS embebidos (necesarios para DomPDF) y la estructura del encabezado/pie de página.
*   **Vistas Específicas:** `beneficiarios.blade.php`, `inventario.blade.php`, `solicitudes_list.blade.php` y `planilla_solicitud.blade.php`.

### 🤖 ChatBot de Telegram
*   **Servicio:** `App\Services\TelegramService`. Centraliza las peticiones HTTP (`GET`/`POST`) hacia la API de Telegram. Soporta el envío de `inline_keyboard` (botones).
*   **Controlador de Webhook:** `App\Http\Controllers\TelegramController`.
    *   **Manejo de Mensajes:** Procesa el texto plano (cédula) y realiza búsquedas elásticas en `App\Models\Cliente` y `App\Models\Factura`.
    *   **Manejo de Callbacks:** El método `handleCallbackQuery()` procesa las acciones de los botones (ej. ver detalles de una solicitud específica).
*   **Rutas:**
    *   `POST /telegram/webhook`: Recibe los eventos de Telegram. (Exento de CSRF).
    *   `GET /telegram/set-webhook`: Registra la URL del servidor ante Telegram.

---

## 🛠️ ¿Cómo encender y probar el Bot de Telegram Localmente?

Dado que el sistema se encuentra en un servidor local (XAMPP / `localhost`), Telegram no tiene forma de comunicarse directamente con tu computadora al momento de programarlo. Necesitamos crear un **puente o túnel público**.

Sigue estos 3 pasos cada vez que quieras poner el bot en línea para hacer pruebas desde tu entorno local:

### Paso 1: Abrir el Túnel (Localtunnel)
1. Abre una consola de comandos (Terminal, CMD o PowerShell) en la carpeta de tu proyecto.
2. Ejecuta el siguiente comando para exponer tu puerto 80 (donde corre XAMPP):
   ```bash
   npx localtunnel --port 80
   ```
3. Verás una respuesta en verde como: `your url is: https://algo-aleatorio.loca.lt`. **Copia esa URL generada**. No cierres esa consola mientras pruebas el bot.

### Paso 2: Actualizar la Configuración (.env)
1. Abre tu archivo `.env` en la raíz del proyecto SICMEC.
2. Busca la línea `APP_URL=...`
3. Pegue la nueva URL agregando la ruta del sistema al final. Debería quedar similar a esto:
   ```env
   APP_URL=https://algo-aleatorio.loca.lt/sicmec/public
   ```
   *(Asegúrate de guardar el archivo).*

### Paso 3: Reactivar el Webhook
1. Abre tu navegador web e introduce esta dirección usando tu nueva URL de localtunnel:
   ```url
   https://algo-aleatorio.loca.lt/sicmec/public/telegram/set-webhook
   ```
   *(También puedes usar simplemente `http://localhost/sicmec/public/telegram/set-webhook` si cambiaste el .env)*.
2. La página te devolverá un mensaje indicando `"webhook_request_sent"`. Esto significa que le acabas de avisar a los servidores mundiales de Telegram: *"¡Oye! Mi bot ahora está escuchando en esta nueva dirección"*.

**¡Listo!** Toma tu celular, ve a Telegram, abre el chat de `@sicmec_ayuda_bot` y envíale un número de cédula válido. El comando viajará por Telegram, pasará por tu túnel, llegará a tu base de datos local y verás la respuesta en tiempo real.

> **Nota para Producción:** Cuando el sistema SICMEC se suba a un Hosting en internet de forma definitiva (Ej. `https://sicmec-oficial.com`), ya no necesitarás usar Localtunnel jamás. Solo actualizarás el `.env` con la URL final, correrás la ruta `/set-webhook` una sola vez, y el bot funcionará para siempre de manera automática las 24 horas del día.
