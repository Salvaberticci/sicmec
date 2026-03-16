# SICMEC - Sistema de Control de Medicamentos y Entregas a la Comunidad 🏥

Bienvenido al repositorio oficial del proyecto **SICMEC**. Este sistema ha sido diseñado para optimizar la gestión, entrega y seguimiento de medicamentos y ayudas técnicas a los ciudadanos.

## 📖 Guía del Sistema
Este repositorio sirve como guía técnica y funcional para entender el funcionamiento del proyecto.

Para una visión profunda de la arquitectura y herramientas, consulta nuestra:
👉 **[Documentación Técnica Completa](DOCUMENTACION_SISTEMA_SICMEC.md)**

---

## 🚀 Características Principales
*   **Gestión de Inventario**: Control total de medicamentos, insumos y ayudas técnicas.
*   **Seguimiento de Beneficiarios**: Registro detallado de entregas y estatus de solicitudes.
*   **Notificaciones Omnicanal**:
    *   📧 Correos electrónicos automáticos con planilla PDF adjunta.
    *   📱 Alertas vía SMS integradas con Twilio.
*   **ChatBot de Telegram**: Autogestión ciudadana para consultar estatus de trámites vía @sicmec_ayuda_bot.
*   **Reportes Inteligentes**: Generación de informes profesionales en PDF y tableros estadísticos dinámicos.

---

## 🛠️ Tecnologías Utilizadas
*   **Backend**: Laravel 8.x (PHP 7.4/8.0)
*   **Frontend**: AdminLTE 3, Bootstrap 5, Chart.js, Vue.js.
*   **Integraciones**: Twilio SDK, Telegram Bot API, DomPDF.

---

## ⚙️ Instalación Rápida
1. Clona el repositorio: `git clone https://github.com/Salvaberticci/sicmec.git`
2. Instala dependencias: `composer install` y `npm install`
3. Configura tu `.env` (usa `.env.example` como base).
4. Ejecuta las migraciones: `php artisan migrate`
5. ¡Listo! Ejecuta `php artisan serve`.

---
*Proyecto desarrollado con el objetivo de mejorar la eficiencia en la salud pública y la comunicación con el ciudadano. - 2026*
