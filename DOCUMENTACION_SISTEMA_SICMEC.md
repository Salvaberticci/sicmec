# Documentación Técnica del Sistema SICMEC 🏥

Este documento proporciona una visión integral de la arquitectura, herramientas, librerías y estructura del proyecto **SICMEC** (Sistema de Control de Medicamentos y Entregas a la Comunidad).

---

## 🚀 Tecnologías Principales (Core Stack)

### Backend
*   **Framework:** [Laravel 8.75](https://laravel.com/docs/8.x)
*   **Lenguaje:** PHP ^7.3 | ^8.0
*   **Base de Datos:** MySQL (Gestionado usualmente vía XAMPP en desarrollo)
*   **Gestor de Dependencias:** Composer

### Frontend
*   **Framework CSS:** Bootstrap 5.1.3
*   **Plantilla Base:** AdminLTE 3 (Provee la interfaz de panel administrativo con FontAwesome 5)
*   **Librería de Gráficos:** Chart.js (Para los tableros estadísticos dinámicos)
*   **JavaScript:** 
    *   jQuery (Para manipulación del DOM y peticiones AJAX)
    *   Vue.js 2.6 (Usado en componentes específicos de la interfaz)
    *   Axios (Para comunicación con la API)

---

## 📦 Librerías y Dependencias Clave

### Integraciones y Servicios
*   **Twilio SDK (`twilio/sdk`):** Utilizado para el envío masivo de notificaciones SMS a los beneficiarios.
*   **Telegram Bot API:** Integrado mediante un servicio personalizado (`TelegramService`) para el autoseguimiento de solicitudes.
*   **Laravel DomPDF (`barryvdh/laravel-dompdf`):** Motor de generación de reportes profesionales en formato PDF.
*   **GuzzleHTTP:** Cliente HTTP para realizar peticiones a las APIs de Telegram y Twilio.

### Utilidades de Laravel
*   **Laravel UI:** Para el andamiaje de autenticación y vistas Blade.
*   **Laravel Sanctum:** Para la protección de rutas de API.
*   **Laravel Spanish (`laraveles/spanish`):** Paquete de idioma para español en validaciones y mensajes del sistema.

---

## 📂 Estructura del Proyecto

El proyecto sigue el patrón de diseño **MVC** (Modelo-Vista-Controlador) estándar de Laravel, con capas adicionales de servicios:

```text
sicmec/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Lógica principal de las peticiones (Facturas, Clientes, Configuración)
│   │   └── Middleware/        # Filtros de seguridad (Autenticación, CSRF)
│   ├── Models/                # Clases Eloquent (Factura, Producto, Cliente, Configuracion)
│   ├── Services/              # Lógica de negocio externa (TelegramService, TwilioService)
│   └── Mail/                  # Clases para el envío de correos electrónicos
├── config/                    # Archivos de configuración del sistema (mail, sms, app)
├── database/
│   ├── migrations/            # Estructura de la base de datos controlada por versiones
│   └── seeders/               # Datos iniciales y de prueba
├── public/                    # Archivos públicos, assets (CSS/JS) y scripts legados
├── resources/
│   ├── views/                 # Plantillas Blade (Dashboard, PDF, Emails)
│   └── lang/                  # Archivos de traducción
├── routes/
│   ├── web.php                # Rutas del panel administrativo y vistas web
│   └── api.php                # Rutas para el Webhook de Telegram y servicios móviles
└── .env                       # Variables de entorno y credenciales sensibles (NO subir a Git)
```

---

## 🛠️ Módulos Principales del Sistema

### 1. Sistema de Notificaciones Omnicanal
Cada vez que una solicitud cambia de estado, el sistema dispara automáticamente:
*   **Email:** Con la planilla de solicitud en PDF adjunta de forma automática.
*   **SMS:** Un mensaje de texto breve informando al beneficiario sobre su trámite.

### 2. ChatBot Interactivo (Telegram)
Permite a los ciudadanos consultar el estatus de sus ayudas enviando su número de cédula al bot `@sicmec_ayuda_bot`. El bot interactúa mediante botones dinámicos para mostrar detalles específicos de cada medicamento.

### 3. Panel de Configuración Dinámica
Permite al administrador cambiar las claves de API (Twilio, Telegram) directamente desde la interfaz web, sin necesidad de editar archivos técnicos del servidor.

### 4. Generación de Reportes PDF
Reportes unificados y profesionales para:
*   Inventario de farmacia e insumos.
*   Listado de beneficiarios atendidos.
*   Historial de solicitudes filtrado por fechas.

---

## ⚙️ Requisitos para el Desarrollo Local
1. **XAMPP** con PHP 7.4+ y MySQL.
2. **Composer** instalado globalmente.
3. **Localtunnel** (`npx localtunnel --port 80`) para probar el Bot de Telegram localmente.
4. **Credenciales:** Configurar el archivo `.env` con los datos de Twilio y Telegram Bot Token.

---
*Documentación generada para el equipo de desarrollo de SICMEC - 2026*
