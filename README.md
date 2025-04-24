# Akihabara Dreams

**Akihabara Dreams** es una tienda en línea dedicada a la venta de figuras de colección, mangas, y productos de merchandising relacionados con el anime y la cultura pop japonesa. Este proyecto está desarrollado con tecnologías como PHP, HTML, CSS y JavaScript, e incluye funcionalidades modernas como generación de recibos en PDF y notificaciones por correo electrónico.

## 🚀 Características principales

- 🛒 Catálogo de productos organizado por categorías.
- 📦 Gestión de pedidos por parte de los usuarios.
- 🧾 Descarga de recibos de compra en formato PDF (implementado con **TCPDF**).
- 📧 Envío automático de correos electrónicos al confirmar un pedido (utilizando **PHPMailer**).
- 💬 Chat en vivo con soporte técnico (en proceso de implementación).
- 👤 Panel de usuarios para ver historial de pedidos.
- 🖥️ Panel administrativo (pendiente de desarrollo).

---

## 🧱 Estructura del proyecto

```bash
/Akihabara-dreams
│
├── app/
│   ├── controllers/         # Lógica de controladores
│   ├── includes/            # Archivos compartidos
│   ├── lang/                # Archivos para la traducción de la página
│   ├── models/              # Modelos de datos
│   ├── repositories/        # Acceso y gestión de datos
│   ├── translations/        # Archivos con los datos de la BDD traducidos
│   ├── routes.php           # Archivo para la rutas de confirmación de pedido y descarga de pdf
│   └── views/               # Vistas HTML/PHP
│
├── config/
│   ├── database.php         # Configuración de conexión a base de datos
│   └── loader.php           # Autocarga de archivos
│
├── logs/
│   └── emails/              # Registros de correos enviados
│
├── public/
│   ├── receipts/            # Recibos PDF generados
│   ├── error404.html
│   ├── index.php            # Página principal
│   ├── index-micuenta.php   # Perfil de usuario
│   ├── index-pedidos.php    # Gestión de pedidos
│   ├── index-productos.php  # Catálogo de productos
│   └── index-usuarios.php   # Administración de usuarios
│
├── resources/
│   ├── commons/             # Recursos compartidos
│   ├── css/                 # Hojas de estilo
│   ├── images/              # Imágenes organizadas por secciones
│   └── js/                  # Scripts JS
│
├── vendor/                  # Librerías externas (Composer)
│   ├── composer/
│   ├── phpmailer/
│   ├── tecnickcom/          # TCPDF
│   └── autoload.php
│
├── .htaccess
├── composer.json
├── composer.lock
└── database.sql             # Script de base de datos

---

## 🧪 Desarrollo del chat (plan futuro)

Se planea implementar un sistema de **chat en vivo** que permita a los usuarios contactar con el soporte técnico en tiempo real. Las tecnologías consideradas incluyen:

- **Frontend**: JavaScript (AJAX/WebSockets), interfaz integrada en la página de usuario.
- **Backend**: PHP con Ratchet o servicios de terceros como Pusher o Firebase.
- **Base de datos**: almacenamiento de historial de mensajes para consultas futuras.
- **Notificaciones**: alertas en tiempo real al administrador cuando un cliente inicia un chat.

---

## 📫 Contacto

¿Tienes ideas, dudas o sugerencias?  
Puedes abrir un *issue* en este repositorio o escribirme directamente:

- GitHub: [https://github.com/Shaie1MP](https://github.com/Shaie1MP)
- Email: montesdeocapuga.shaiel@gmail.com

---

## 👨‍💻 Autor

Desarrollado con por [Shaiel]  

---
