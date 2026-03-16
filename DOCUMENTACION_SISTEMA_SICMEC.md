# Documentación Técnica Extensa y Detallada del Sistema SICMEC 🏥

## Índice
1. [Introducción y Propósito](#1-introducción-y-propósito)
2. [Arquitectura del Sistema](#2-arquitectura-del-sistema)
3. [Tecnologías del Backend (Lado del Servidor)](#3-tecnologías-del-backend-lado-del-servidor)
4. [Tecnologías del Frontend (Lado del Cliente)](#4-tecnologías-del-frontend-lado-del-cliente)
5. [Estructura y Modelado de la Base de Datos](#5-estructura-y-modelado-de-la-base-de-datos)
6. [Descripción Detallada de los Módulos](#6-descripción-detallada-de-los-módulos)
7. [Integraciones de Terceros (APIs)](#7-integraciones-de-terceros-apis)
8. [Seguridad y Protección de Datos](#8-seguridad-y-protección-de-datos)
9. [Flujos de Trabajo y Lógica de Negocio](#9-flujos-de-trabajo-y-lógica-de-negocio)
10. [Guía Completa y Exhaustiva de Despliegue (Producción)](#10-guía-completa-y-exhaustiva-de-despliegue-producción)

---

## 1. Introducción y Propósito

El **Sistema de Control de Medicamentos y Entregas a la Comunidad (SICMEC)** es una plataforma web integral diseñada para digitalizar, organizar y agilizar el proceso de asistencia social en materia de salud. Su objetivo principal es gestionar el inventario de una farmacia comunitaria o institucional, llevar un registro detallado de los beneficiarios (pacientes/ciudadanos) y procesar las solicitudes (entregas) de medicamentos, insumos médicos y ayudas técnicas.

El sistema fue concebido no solo como un panel administrativo estático, sino como una herramienta de comunicación proactiva. Por ello, incorpora notificaciones automatizadas multicanal (correo electrónico y mensajes de texto SMS) e interacciones mediante un bot oficial de Telegram, permitiendo al ciudadano mantenerse informado sobre el estatus de su trámite sin necesidad de acudir presencialmente a una oficina.

---

## 2. Arquitectura del Sistema

SICMEC está construido bajo el patrón de diseño arquitectónico **MVC (Modelo-Vista-Controlador)**, impulsado por el framework Laravel.

*   **Modelo (Model):** Representa las estructuras de datos (Tablas de base de datos) y la lógica de negocio subyacente. Los modelos interactúan a través de *Eloquent ORM*, lo que permite realizar consultas a la base de datos utilizando sintaxis orientada a objetos en lugar de escribir SQL puro.
*   **Vista (View):** Es la capa de presentación. En SICMEC, las vistas son generadas dinámicamente en el servidor utilizando el motor de plantillas *Blade*. Estas vistas combinan HTML, CSS, JavaScript y directivas especiales de Blade para mostrar los datos al usuario final de manera estilizada y estructurada.
*   **Controlador (Controller):** Actúa como el intermediario (el "cerebro" de la operación). Recibe las peticiones HTTP (GET, POST, PUT, DELETE) desde el navegador del usuario a través de las Rutas (`routes/web.php` o `routes/api.php`), procesa la información (validando datos, pidiendo información a los Modelos) y finalmente devuelve una respuesta (una Vista renderizada, un archivo PDF, o un JSON).

Además del clásico MVC, el sistema implementa **Arquitectura Orientada a Servicios (Service classes)** para extraer la lógica compleja que no pertenece directamente a un Controlador. Ejemplos de esto son `TwilioService` y `TelegramService`, que encapsulan todas las complejas llamadas a APIs externas, manteniendo los controladores de la aplicación limpios y enfocados puramente en el flujo HTTP.

---

## 3. Tecnologías del Backend (Lado del Servidor)

El backend de SICMEC es el núcleo funcional y lógico del proyecto. Esta arquitectura robusta está garantizada por el uso de tecnologías modernas, estables y altamente soportadas por la comunidad.

1.  **PHP 7.4 / 8.0+**: El lenguaje de programación de propósito general del lado del servidor. Se eligió PHP por su inmensa penetración en el mercado web, su rapidez de ejecución y su perfecta simbiosis con servidores estándar (Apache/Nginx).
2.  **Laravel Framework (Versión 8.x)**: Laravel es el framework PHP más popular. Proporciona:
    *   **Enrutamiento Expresivo:** Definición de URIs limpias y legibles.
    *   **Eloquent ORM:** Mapeo objeto-relacional que hace que interactuar con la base de datos sea seguro (previniendo inyección SQL nativamente) e intuitivo.
    *   **Migraciones y Seeders:** Control de versiones para la base de datos. Ningún desarrollador tiene que pasarse archivos `.sql`; las migraciones construyen las tablas con comandos de consola.
    *   **Motor de Plantillas Blade:** Herencia de vistas, inclusión de componentes y escape automático de variables (protegiendo contra ataques XSS).
    *   **Sistema de Middleware:** Filtros que analizan las peticiones antes de que lleguen a la aplicación (ej. verificando que el usuario esté autenticado antes de dejarlo ver los reportes).
3.  **Composer**: El gestor de dependencias de PHP. Administra todas las librerías de terceros (paquetes o vendor) que Laravel requiere para funcionar. Automáticamente gestiona las versiones y las actualizaciones de librerías como Twilio SDK, DomPDF, etc.
4.  **Artisan CLI**: La interfaz de línea de comandos incluida en Laravel. Permite hacer desde tareas rutinarias (borrar caché, crear controladores) hasta ejecutar scripts periódicos.

---

## 4. Tecnologías del Frontend (Lado del Cliente)

La interfaz gráfica del usuario (GUI) ha sido desarrollada priorizando la facilidad de uso, la responsividad (adaptación a pantallas de teléfonos, tablets y monitores) y la retroalimentación visual clara.

1.  **HTML5 y CSS3**: Los bloques fundamentales de construcción web. Se utilizan para la semántica estructural y los estilos en cascada no cubiertos por los frameworks.
2.  **Bootstrap 5.1**: El framework CSS más famoso. En SICMEC se utiliza intensivamente el sistema de grillas (grids) de Bootstrap para organizar el contenido (tarjetas, formularios, tablas) y que este "fluya" y se redimensione automáticamente dependiendo del tamaño de la pantalla del usuario.
3.  **AdminLTE 3**: Una plantilla de panel de control (Dashboard) de código abierto construida sobre Bootstrap. Provee la estructura visual principal del lado del administrador: barra lateral retráctil, menú superior de navegación, paneles de información (widgets), tablas de datos estilizadas, etc. Esto da a la aplicación un aspecto pulido, corporativo y altamente profesional con muy poco esfuerzo de diseño a medida.
4.  **FontAwesome 5 / 6**: Librería de iconografía vectorial. Facilita la comprensión visual del sistema integrando iconos intuitivos en botones, menús, estados (checkmarks, warnings, relojes de arena).
5.  **JavaScript (Vainilla) & jQuery**: jQuery es una librería de JavaScript clásica, adoptada principalmente porque la plantilla AdminLTE 3 depende de ella en gran medida para sus animaciones y componentes dinámicos (colapsar menús, modales).
6.  **Vue.js 2.6 (En componentes específicos)**: Vue.js está presente en el ecosistema del framework como tecnología reactiva. Laravel Mix compila los componentes de Vue permitiendo interfaces asíncronas modernas allí donde jQuery ya no resulta tan limpio o mantenible, logrando así componentes reactivos que actualizan la vista sin recargar la página.
7.  **Chart.js**: Una librería flexible de gráficos basada en JavaScript. Es la responsable de "dar vida" al panel principal (*Dashboard*). Renderiza visualizaciones como gráficos de barras (para entregas por mes), gráficos de dona/pastel (para la distribución por estados de las solicitudes), o gráficos de progreso, convirtiendo la data de la base de datos en formatos fáciles de digerir de un solo vistazo.
8.  **SweetAlert2 / Toastr**: Utilizados para brindar *feedback* o alertas interactivas al usuario, reemplazando la fea y tosca alerta nativa del navegador (`alert()`). Informan al operador cuando "Una solicitud se ha creado con éxito" o le advierten con modales pop-up de confirmación antes de eliminar permanentemente un registro.

---

## 5. Estructura y Modelado de la Base de Datos

El sistema usa **MySQL** (o MariaDB) como motor de base de datos relacional (RDBMS). Toda la información generada en SICMEC se centraliza aquí, asegurando integridad referencial. El ORM *Eloquent* mapea estas tablas directamente a clases PHP orientadas a objetos.

### 5.1. Tablas Nucleares (Core Tables)

1.  **Tabla `users` (Usuarios/Administradores)**
    *   Maneja las cuentas que tienen acceso al panel web del sistema.
    *   Almacena: Nombre, email, contraseña encriptada (Bycrypt Hash), y un token de "recordar sesión".
2.  **Tabla `clientes` (Beneficiarios/Pacientes)**
    *   Representa al núcleo ciudadano del sistema. Cada persona que requiere asistencia.
    *   Campos Importantes: `cedula` (DNI, usado para identificar unívocamente y para la interacción con Telegram), `nombre`, `telefono` (con código de área internacional para envíos de SMS vía Twilio), `correo` (para envío de PDFs y notificaciones), `direccion`, y opcionalmente `nro_expediente`.
3.  **Tabla `productos` (Catálogo/Farmacia)**
    *   Soporta el inventario físico del recinto. No se limita solo a medicinas.
    *   Campos: `codigo` (SKU / código interno), `nombre_producto`, `tipo` (Enum: 'medicamento', 'insumo', 'ayudasTecnicas'), `existencia` (número entero que determina el stock disponible), `unidad`, `peso`.
4.  **Tabla `facturas` (Solicitudes/Trámites)**
    *   El centro logístico del sistema. A pesar del término técnico ("factura"), representa una **solicitud o entrega oficial de asistencia social** a costo cero o subsidiado.
    *   Campos: `cliente_id` (Relación Foránea), `total_medicamentos` (Resumen de cuántas cosas se entregaron), `estatus` (Estado actual del flujo de trabajo: 'Procesando', 'Aprobada', 'Finalizada', 'Rechazada').
5.  **Tabla `facturas_renglones` (Items de Solicitud)**
    *   Tabla pivote que conecta una "Factura/Solicitud" con los "Productos", resolviendo así la relación de muchos a muchos (Una solicitud tiene muchos productos, un producto puede estar en muchas solicitudes).
    *   Campos: `factura_id`, `producto_id`, `cantidad`, `precio` (si aplica), `total`.
6.  **Tabla `configuracions` (Ajustes Sistémicos)**
    *   Una tabla clave para mantener dinámico el sistema. Permite cambiar credenciales de APIS externas sin modificar variables de entorno permanentemente ni acceder por FTP/SSH.
    *   Campos: `twilio_sid`, `twilio_token`, `twilio_from`, `telegram_bot_token`. El sistema por lo general solicita solo el primer registro (`Configuracion::first()`).

### 5.2. Relaciones Eloquent
El framework permite que los objetos naveguen por estas tablas de forma fluida:
*   Un `$cliente->facturas` devuelve todas las solicitudes introducidas por ese ciudadano.
*   Una `$factura->cliente` devuelve el perfil del beneficiario.
*   Una `$factura->facturas_renglones` carga todo el carrito de items relacionados a esa solicitud.

---

## 6. Descripción Detallada de los Módulos

### Módulo 1: Autenticación y Autorización
Basado en Laravel UI (`laravel/ui`), protege las rutas del sistema. Solo usuarios registrados y autenticados con credenciales verificadas pueden acceder al panel. Dispone de middleware `auth` para bloquear completamente accesos directos por URL.

### Módulo 2: Gestión de Beneficiarios (Pacientes)
Un submódulo completo de *CRUD (Create, Read, Update, Delete)*. Permite registrar a nuevos ciudadanos. Incluye buscadores y paginación para manejar grandes volúmenes de registros rápidamente sin saturar el navegador con la carga completa de datos.

### Módulo 3: Gestión de Inventario (Farmacia)
Funciona como un WMS (Warehouse Management System) básico. Los administradores dan de alta medicamentos o ayudas (sillas de ruedas, bastones). La existencia de estos productos dicta qué se le puede asociar a un beneficiario en una solicitud posterior. El módulo de inventario está tipificado estandarizando "medicamentos", "insumos" y "ayudas técnicas" en filtros separados.

### Módulo 4: Sistema de Operatoria - Solicitudes/Entregas
Es el corazón operativo del software.
1. Se selecciona un beneficiario.
2. Se "agregan al carrito" productos bajando así, mediante transacciones lógicas, el stock actual de dichos artículos en tiempo real.
3. Se genera un "ID de solicitud".
Este módulo gestiona el "Ciclo de Vida" del trámite mediante estados finitos (`estatus`). Todo trámite empieza usualmente en etapa inicial evaluativa.

### Módulo 5: Motor de Tipografía y Reportes en PDF
El sistema abandona los clásicos y aburridos reportes web imprimibles a favor de reportes estrictamente renderizados del lado del servidor usando la librería especializada **DomPDF** (`barryvdh/laravel-dompdf`).
Al pulsar botones de impresión, el sistema:
1. Compila una vista Blade limpia (`pdf.layout` y variantes).
2. Convierte todo el DOM (HTML/CSS en línea) dentro del servidor a un archivo binario PDF puro.
3. Lo "transmite" (stream) al navegador del usuario, mostrándolo en modo previsualización, con un diseño que incluye cabeceras oficiales, pie de página paginado e isologotipos formales y fijos de alta calidad.

### Módulo 6: Configuración Dinámica (Settings Panel)
Una ruta protegida (`/configuracion`) provee un formulario que edita los registros únicos en la base de datos de configuraciones, permitiendo que las pasarelas SMS y Bot cambien sus "llaves maestras" bajo demanda, con efecto inmediato en toda la aplicación.

---

## 7. Integraciones de Terceros (APIs)

SICMEC trasciende su propio servidor al hablar de forma bidireccional con dos de las APIS más poderosas a nivel mundial.

### 7.1. API de Twilio (Servicios de Telefonía SMS)
**Objetivo:** Permitir comunicaciones inmediatas mediante el canal GSM ubicuo, sin importar si el beneficiario no tiene internet en ese momento.
**Arquitectura:** Usando el Driver de Twilio (`twilio/sdk`), SICMEC inicializa el cliente utilizando Credenciales Dinámicas (`Account SID`, `Auth Token`, `From Number`).
**Flujo:**
1. Al momento crítico de ejecutar un Guardado (`store()` o `update()` en `FacturasController`), se instancia un Service Object especializado (`TwilioService`).
2. El mensaje se redacta incluyendo variables ("Hola Juan, tu solicitud #522...").
3. Se envía el 'payload' a la API REST de Twilio de manera asincrónica, generando una solicitud de despacho de mensaje de texto.

### 7.2. API del Bot de Telegram (Auto-Consulta Ciudadana)
**Objetivo:** Descentralizar las consultas de la recepción física usando Inteligencia/Automatización de bajo costo.
**Arquitectura:** SICMEC funciona no solo como servidor web de pantallas, sino también como **Servidor Webhook HTTP**. Cuando una persona le "escribe" un mensaje al Bot en Telegram Internacional, los servidores de Telegram interceptan ese mensaje y lo mandan como paquete POST en milisegundos a SICMEC a la ruta determinada `/telegram/webhook`.
**Flujo y Parseo:**
1. Telegram dispara el POST. Laravel lo recibe de manera blindada exceptuado de verificación CSRF.
2. `TelegramController` lee el JSON del mensaje de texto. Evalúa si es formato numérico (cédula).
3. Si lo es, hace un *query* a la base de datos.
4. Redacta una hermosa cadena en bloque usando Emojis y formato Markdown interno de Telegram y la envía usando un GET/POST de retorno empleando `GuzzleHttp` y el Facade de Http de Laravel.
5. El servidor envía *"Inline Keyboards"* (Botones anexos a la burbuja de chat), que en caso de pulsarse, envían eventos *Callback Query*, decodificados instantáneamente ofreciendo menues al ciudadano en la app Telegram (por ejemplo "Presiona aquí para detallar esta solicitud especial").

---

## 8. Seguridad y Protección de Datos

En arquitecturas web que manejan datos que asocian identificaciones nacionales con afecciones médicas/entregas, la seguridad es prioritaria.
1. **Defensas Anti-Inyección (XSS / SQLi):** El ORM Eloquent usa PDO vinculando parámetros (Parameter Binding) nativamente blindando todas las transacciones SQL. Los motores Blade usan `{{}}` la directiva equivalente a `htmlspecialchars()`, anulando cualquier intento de inyección de JavaScript (Stored XSS) en los nombres de pacientes.
2. **Sistema de Tokens CSRF:** Todas las peticiones POST, PUT o DELETE desde el navegador viajan firmadas herméticamente con un token dinámico `@csrf`. Cualquier petición sin esta firma recibe un bloqueo inmediato `HTTP 419 Page Expired`. (Nota: La ruta de Webhook de Telegram está obligatoriamente exonerada de esta defensa en `VerifyCsrfToken` por su naturaleza externa "Machine-to-Machine").
3. **Manejo Sensible de Credenciales:** Todas las configuraciones sensibles reales y permanentes del servidor o conexiones SMTP viven exclusivamente en el archivo `.env`, el cual ignora explícitamente el sistema de versionado Git, evitando el temido robo masivo de credenciales en GitHub.

---

## 9. Flujos de Trabajo y Lógica de Negocio

El sistema operativo obedece la siguiente cascada lógica o *Workflow*:

1. **Alta del Beneficiario:** Introducción primaria en base de datos de los datos socioeconómicos de contacto.
2. **Generación del Peticitorio (Gestor Triage):** Un operador toma nota de los requerimientos y los agrupa en un objeto llamado internamente "Factura" (Ticket o Solicitud).
3. **Trigger Operacional (Eventos Post-Acción):** Una vez la DB ejecuta el *commit*, el *Controller* dispara la Cadena Reactiva:
   * **Notificación de Correo (SMTP):** Envía correo transaccional utilizando las credenciales `MAIL_MAILER` del `.env`, re-compilando el componente Blade PDF internamente, incrustándolo en streaming y enviándolo vía red utilizando Google SMTP u otra pasarela de Mail as a Service.
   * **Notificación SMS:** Twilio se enciende y despacha.
4. **Ciclo Iterativo de Estatus:** Los operadores progresan la solicitud avanzando estadíos ('Aprobando', 'Distribuyendo', 'Cerrando'). Cada *Update* HTTP genera nuevas micro-alertas SMS/Email reportando el estado nuevo al usuario final, manteniendo total transparencia y disminuyendo ansiedad social (llamadas o aglomeraciones constantes en oficinas).

---

## 10. Guía Completa y Exhaustiva de Despliegue (Producción)

Desplegar Laravel de manera correcta en un entorno de producción (servidor real, VPS o hosting dedicado) garantiza rendimiento y seguridad máxima.

### 10.1. Requisitos Preliminares del Servidor
*   Un servidor tipo Linux (Ubuntu 20.04/22.04 LTS altamente recomendado).
*   **Servidor Web:** Apache (con módulo `mod_rewrite` activo) o Nginx (con el pasarela configurada hacia php-fpm).
*   **PHP:** Versión 7.4, 8.0, 8.1 o superior, con todas sus extensiones (BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML, cURL).
*   **Base de Datos:** MySQL (>5.7) o MariaDB (>10.3).
*   **Gestores:** Composer (Para instalar componentes PHP), Node.js y NPM (Opcionales en servidor puro si ya compilaste los assets, pero útiles).
*   **Certificado SSL:** Absolutamente MANDATORIO. Todo el panel debe correr sobre `HTTPS`. Sin `HTTPS`, Telegram nunca aceptará el *Webhook*.

### 10.2. Preparación Inicial del Repositorio
**Paso A: Subida del Código**
Usa Git para clonar el repositorio o transfiere los archivos mediante SFTP (FileZilla).
```bash
# Navegar al directorio raíz del servidor estipulado (ej: /var/www/sicmec)
git clone https://github.com/tu-usuario/sicmec.git .
```

**Paso B: Instalación del Árbol de Dependencias**
```bash
# Descargar todas las librerías del backend (excluyendo herramientas de dev test)
composer install --optimize-autoloader --no-dev
```

**Paso C: Compilación de Archivos Visuales (JS/CSS)**
*(Si los assets ya están precompilados y subidos, puedes saltar esto)*
```bash
npm install
npm run prod
```

### 10.3. Configuración del Entorno (Directamente crítico)
Debes clonar la plantilla `.env.example` para generar tu verdadero archivo físico `.env`:
```bash
cp .env.example .env
```
Posteriormente, edita exhaustivamente dicho documento (`nano .env`):
*   `APP_ENV=production` (Crítico para que Laravel esconda trazas de errores y apague su modo Debug).
*   `APP_DEBUG=false` (Para evitar exponer rutas relativas del sistema operativo o detalles ante una excepción imprevista PHP).
*   `APP_URL=https://nuestro-dominio-sicmec.com`
*   Variables `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` hacia tus credenciales maestras de servidor MySQL de producción real.
*   Credenciales SMTP (`MAIL_HOST`, `MAIL_PORT`...)
*   Si vas a quemar variables de Twilio directo, configúralas acá (aunque preferiblemente hazlo luego desde el Panel GUI Web del propio SICMEC).

Genera la clave de encriptación de sesión (Obligatorio, creará un String base64 en `APP_KEY`):
```bash
php artisan key:generate
```

### 10.4. Ejecución de la Migración y Simientes de Datos Finales
Estructurar las tablas y sus relaciones indexadas directamente en el SQL del host:
```bash
# El comando instalará todas las tablas e inyectará los datos semilla iniciales obligatorios. Te pedirá confirmación de entorno de "producción" respondiendo "yes".
php artisan migrate --seed --force
```

### 10.5. Configuraciones del Servidor Web (Permisos y Entradas)
**Permisos Lógicos (Caso Linux)**
Laravel necesita guardar variables temporales en su memoria local (`storage` y `bootstrap/cache`). Obligatoriamente debes ceder permisos de propietario de estas ubicaciones al motor web (Ej: *www-data* en Apache):
```bash
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

**Bloque de Configuración Web Server Document Root - IMPORTANTÍSIMO**
El servidor (`Apache` VHost o Server Block de `Nginx`) no debe apuntar a la raíz del repositorio (`/var/www/sicmec`). Si lo hace, expondrás tu archivo `.env` al público de internet, y perderás tus contraseñas y base datos masivamente.

*El "Document Root" de Apache/Nginx DEBE apuntar estrictamente, y única y exclusivamente, al directorio de nombre `/public` interno de Laravel:*
```apache
<VirtualHost *:80>
    ServerName nuestro-dominio-sicmec.com
    # DIRIGIR HACIA CARPETA PUBLIC
    DocumentRoot /var/www/sicmec/public

    <Directory /var/www/sicmec/public>
        AllowOverride All
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>
</VirtualHost>
```

### 10.6. Optimización Post-Despliegue Laravel
Una vez que en Producción el sistema corre adecuadamente sin contratiempos, usa Artisan para aplanar los archivos masivos de arrays y optimizar la carga a velocidad de disco ultra-rápida (en sistemas pesados, esto reduce hasta un 40% el tiempo de espera por Load en cada clic):
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
*(Cualquier edición manual posterior sobre tu fichero `.env` u otro archivo requerirá obligatoriamente ejecutar `php artisan optimize:clear` o no verás reflejado el trabajo).*

### 10.7. Enlace Definitivo del Bot de Telegram en Producción
Abre un explorador web estándar, y entra como super Administrador con cuenta autorizada, luego simplemente visita por URL pre-fabricada la ruta webhook para forzar los engranajes del motor de Telegram Services:
Visitar: `https://nuestro-dominio-sicmec.com/telegram/set-webhook` (A estas alturas ya debe incluir HTTPS definitivo).

*Notarás un OK del JSON "webhook is set". En ese momento, habrás completado el despliegue a una escala sumamente profesional de tu aplicación e integración de AI Cloud.*

---
*Fin de la Guía Arquitectónica Técnica Profunda de SICMEC - Actualizado: Marzo de 2026*
