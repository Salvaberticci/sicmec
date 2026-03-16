<p align="center">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
    <img src="https://img.shields.io/badge/Versi%C3%B3n-1.0%20(Estable)-informational" alt="Version">
    <img src="https://img.shields.io/badge/PHP-%5E7.3%20%7C%20%5E8.0-blue" alt="PHP Version">
    <img src="https://img.shields.io/badge/Laravel-8.x-red" alt="Laravel Version">
    <img src="https://img.shields.io/badge/MySQL-Soportado-success" alt="Database">
    <img src="https://img.shields.io/badge/Bots-Telegram_API-2CA5E0" alt="Telegram integration">
    <img src="https://img.shields.io/badge/SMS-Twilio-F22F46" alt="Twilio integration">
</p>

# 🏥 SICMEC - Sistema de Control de Medicamentos y Entregas a la Comunidad

Bienvenido al repositorio oficial y de documentación pública del proyecto **SICMEC**.

SICMEC es una solución informática integral en forma de **Aplicación Web (Web Application)**, arquitecturada bajo el robusto entorno de Laravel/PHP, diseñada exhaustivamente para sistematizar de forma altamente eficiente, pulcra y automatizada los procesos sociales modernos relativos a la captura de datos (pacientes/beneficiarios), la gestión de inventario de recursos limitados, y sobre todo, la trazabilidad perfecta del circuito de **solicitud y entrega de insumos biomédicos, medicinas y ayudas técnicas**.

---

## 📖 Documentación Profunda y Técnica

Si buscas comprender a cabalidad **CÓMO ESTÁ HECHO** el sistema, qué técnicas se han implementado hasta el más mínimo archivo de lógica, cuáles son los esquemas relacionales exactos y qué consideraciones de seguridad perimetral se han adaptado, por favor, detente de inmediato y consulta el manual oficial exclusivo, incluido en la raíz del proyecto para desarrolladores, DevOps e Ingenieros:

👉 **[Hacer Clic Aquí: LEER DOCUMENTACIÓN TÉCNICA DEL SISTEMA (SERVER, DB & DEPLOY) COMPLETA](DOCUMENTACION_SISTEMA_SICMEC.md)**

---

## 🌟 Características Detalladas e Innovaciones Aplicadas

SICMEC no es un simple programa (software de estantería o un clásico CRUD), va diez pasos adelante incorporando tecnologías altamente requeridas por el estándar 5.0 (automatizaciones sociales). Sus pilares son:

### 1. Panel de Administración y Farmacia Interna 📦
*   Interfaces completamente responsivas y ultra rápidas (UX minimalista, clara y concisa a través de **AdminLTE v3 y Bootstrap v5**).
*   Inventario segmentado e inteligente: Clasificación por unidades de peso, medicamentos sintéticos, insumos líquidos o sólidos, y ayudas ortopédicas/técnicas diversas.
*   Registros de beneficiarios robusto: Contemplando datos geográficos y telemetría de contacto celular/email vinculante.
*   Dashboards de visualización ejecutiva: Mediante la librería vectorial **Chart.js** adaptada nativamente a escala por contenedores asercionados, mostrando rendimientos históricos (Doughnuts, Lines, Bar charts).

### 2. Motor Exclusivo de Documentos en Tiempo Real (PDF Server-Side Processing) 📄
*   Descartada la antigua técnica de imprimir web sucias y rotas en HTML; cuenta con el paquete transcriptor *Barryvdh/DomPDF*.
*   Permite generar formatos matriciales ISO con encabezados, recuadros numéricos para cada trámite ejecutado, actas de entregas pulcramente maquetadas al vuelo en formatos `.pdf` que visualizan e indexan todo sin perder márgenes desde cualquier navegador moderno.

### 3. Comunicación Omnicanal Inteligente a Ciudadanos 📬
La joya técnica del diseño SICMEC. Cuando un trámite se aprueba o evoluciona, el sistema se convierte en el eslabón logístico invisible para comunicarse pasivamente sin gastar un minuto del tiempo humano:

*   **Mailer Integrado (SMTP Automation):** Conforma hilos HTML que adjuntan nativamente el PDF de factura y lo envían a buzones de correo masivos sin detención.
*   **Twilio Text Integration System:** El sistema genera conexiones seguras con Estados Unidos/Europa (REST API) que gatillan un SMS nativo a la terminal telefónica base del usuario (GSM), comunicando el ID real de la orden, logrando un alcance del 100% de la población (Incluso aquellos desprovistos de un plan temporal de datos o un SmartPhone).

### 4. Inteligencia Centralizada y Auto-Gestión Pública (Telegram Chatbot AI Plugin) 🤖
*   Integra un Bot 100% operacional en modalidad _Application Webhook_, usando tecnología End-to-End con el protocolo HTTPS API Oficial de Telegram Corp.
*   Funciona pasivamente (Idle): El beneficiario abre la App "Telegram" en la comodidad de su hogar/equipo, enviándole únicamente su credencial numérica o documento de identidad y en menos de `0.2` décimas de segundo nuestro servidor compilará consultas subyacentes MySQL y, a modo "conversación natural", dibujará una UI emergente en Telegram con teclados de reacción o menús tipo *"Ver detalles específicos del Tramite #XXXX"*. Eliminando colas completas presenciales para procesos de mero seguimiento/trámites estáticos.

### 5. Configuración Zero-Downtime y Dynamic Loading ⚡
*   Los credenciales de todo lo expuesto no requieren que programadores ingresen periódicamente a tocar complicadísimo código CPanel o reinicien repositorios en GitHub. Se introdujo una estructura en "Persistencia de Configuración Única" con un menú encriptado dentro del perfil administrativo Web de la página; un simple campo que acepta llaves hash o Keys en un formulario visual permitiendo actualizar números telefónicos maestros o contraseñas API sin tiempo colapsado.

---

## 🛠 Entorno de Componentes Técnicos y Tech Stack

**Arquitectura Base:**
*   BackEnd Engine: Language `PHP` - Versiones Superiores: `^7.4+`, `^8.0+`, `^8.1+`. (Paradigma OOP).
*   Framework Lógico Base: `Laravel` - Edición Histórica: `8.75`. Motor: ORM *Eloquent*.
*   Motor SQL Engine Data Persistence: Integración estricta relacional, nativamente construido para `MySQL Server` o `MariaDB Data Clusters`.
*   Dependency Map: Compresión generativa vía motor empaquetado `Composer JSON System`.

**Interface (Front-End) - User Client Processing:**
*   CSS Framework Core Matrix: `Framework Bootstrap-V5.x` apoyado visualmente bajo la estética unificada de `AdminLTE Panel`.
*   Scripting & Dynamics Events Async: Componentes mixtos híbridos Reactivos con Engine en `Vue.JS 2.x` coexistiendo con rutinas de manipulación vectorial vía `jQuery / Javascript Vainilla ES6`.
*   Asynchronism/Requests API Data Fetch: Sistema `Axios HTTP JS Component`, librerías vectoriales de análisis visual `Chart JS Analytics`.

---

## 🚦 Primeros Pasos & Requisitos de Entorno (Instalación Local para Desarrollo Temprano y Testing)

El sistema ha sido probado a fondo para integrarse perfectamente a suites locales como XAMPP, WAMP o entornos Docker (Laravel Sail / Homestead).

1.  Abre la terminal en tu directorio predeterminado, y procede al copiado atómico de Github completo y su ramificación activa de manera segura y forzada hacia protocolo HTTPS/SSH:
    ```bash
    git clone https://github.com/Salvaberticci/sicmec.git
    cd sicmec
    ```

2.  Copia o Regenera de Cero el archivo crítico de variables globales oculto, mediante la matriz base:
    ```bash
    cp .env.example .env
    ```

3.  Resuelve e instala las millones de líneas de dependencias backend omitidas de GIT, conectando con repositorios Packagist mundiales centrales (Este procedimiento puede tomar varios minutos según red Ethernet o WiFi):
    ```bash
    composer install
    ```

4.  Abre tu archivo local `.env` recién creado en tu bloc de notas táctico, o tu propio IDE y enlázalo rellenando (host, db, password) correspondientes a la instalación de MySQL Local de tu torre para que la App Laravel "encuentre" la BD vacía y la conecte mediante los TCP locales `3306`:
    ```env
    DB_DATABASE=sicmec
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  Corre los puentes de despliegue lógico para la encriptación asimétrica obligada base64 del Backend Laravel Framework:
    ```bash
    php artisan key:generate
    ```

6.  Con la ruta DB validada, exige a la consola que reconstruya tablas foráneas y siembre la "Seed" o Data de test, recreando tu programa entero preñado con Data lista para usar:
    ```bash
    php artisan migrate --seed
    ```

7.  Genera enrutamiento de dependencias y scripts NPM asíncronos para reconstruir (Buid tools) node_modules visuales (Si te es requerido en entorno de test/modificaciones React o VUE localmente no compilados):
    ```bash
    npm install
    npm run dev
    ```

8.  ¡Felicidades, todo el motor de alto flujo SICMEC se encuentra ahora levantado tras tu Firewall! Puedes correr el emulador interno con servidor Web local:
    ```bash
    php artisan serve
    ```

*Visita de forma estricta localhost, el puerto `8000` predefinido para testear desde escritorio.* (Ejemplo de Login Genérico Inicial: Ingresar al endpoint `http://127.0.0.1:8000`).

*(NOTA ESPECIAL SOBRE TELEGRAM EN LOCAL: En entorno "localhost", una app en Rusia u otro continente no encontrará esa palabra. Exige túneles con URL temporal. Requiere el uso de extensiones tunelizadoras complejas del tipo `localtunnel` vía NODE.JS o mediante las interfaces binarias multiplataformas cerradas corporativas tipo `ngrok`). - Remítete la Documentación Adjunta Interna de Despliegue en el punto anterior.*

---

## 🌎 Despliegues Completos hacia Escenarios Finales o Clústers en Producción / Servidores Formales

Si tu plan final ineludible se basa sobre subir esta bestia, a espacios virtualizados tipo VPS DigitalOcean, Linode AWS Server EC2 Instances Amazon (Instancias Cloud Base Elastic) O CPaneles nativos compartidos, se impone aplicar una configuración específica extra con énfasis riguroso de Seguridad HTTP. Para desplegar y hacer de manera totalmente invulnerable esto debes acudir imperativamente a leer:

👉 **El apartado número 10 absoluto ("Guía Completa y Exhaustiva de Despliegue Producción") encontrado adentro del archivo técnico centralizado: `DOCUMENTACION_SISTEMA_SICMEC.md`.** 👈
Ahí detallaré Apache Config, Storage permissions, SymLinks, y HTTPS NGINX reverse proxys obligatorios.

---

### ©️ Licencia de Código y Filosofía Institucional Aplicada
*Repositorio oficial perteneciente al autor y al staff maestro global arquitectónico del Desarrollo SICMEC 2026. Distribución analítica y consultiva para Ingenieros, Auditores Técnicos, Operadores Integrales y Gerencias Administrativas Oficiales del ente central.*
