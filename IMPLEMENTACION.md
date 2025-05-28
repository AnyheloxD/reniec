# Implementación del Plugin RENIEC IDaaS Authentication

## Objetivo
Este plugin permite a los administradores de WordPress configurar la autenticación con RENIEC IDaaS (Perú) mediante un formulario en WP-Admin y generar un botón de inicio de sesión mediante un shortcode `[reniec_auth_button]`. Al hacer clic, el usuario es redirigido a una URL de autorización con parámetros firmados.

## Librerías Usadas
- **reniec/idaas**: SDK oficial de RENIEC para PHP, versión ^2.0, especificado en `composer.json` para instalación vía Composer.
- **WordPress Core**: Utiliza funciones nativas como `add_options_page`, `register_setting`, y `add_shortcode` para la integración.

## Estructura
- **index.php**: Archivo principal que carga dependencias, define constantes, y registra estilos y shortcodes.

- **inc/api-helper.php**: Clase `Reniec_Api_Helper` que gestiona la configuración (client_id, client_secret, redirect_uri) desde las opciones de WordPress.
- **inc/auth-reniec.php**: Clase `Reniec_Auth` que usa el SDK para generar la URL de autorización con un `state` dinámico.
- **templates/shortcode-view.php**: Plantilla para el botón de autenticación.
- **assets/style.css**: Estilos básicos para el botón.
- **composer.json**: Define la dependencia `reniec/idaas` y configura el autoload para las clases del plugin.

## Decisiones Tomadas
1. **Dependencia del SDK**: La dependencia `reniec/idaas` se incluye en `composer.json` con la versión `^2.0`. El usuario debe ejecutar `composer install` en la raíz del plugin para instalarla.
2. **Autoload**: Se usa PSR-4 en `composer.json` para cargar las clases del directorio `inc/`
3. **State Dinámico**: Se genera un `state` aleatorio con `bin2hex(random_bytes(16))` para seguridad, almacenado en la sesión .
4. **Errores**: Se manejan excepciones del SDK con `try/catch`, registrando errores en el log de WordPress para depuración.


## Uso
1. Instalar dependencias: En la raíz del plugin, ejecutar `composer install` para descargar `reniec/idaas`.
2. Activar el plugin en WordPress.
3. Configurar `client_id`, `client_secret`, y `redirect_uri` en Ajustes > RENIEC Auth.
4. Usar el shortcode `[reniec_auth_button]` en una página o post.
5. Al hacer clic, el usuario será redirigido a una URL como ejemplo: `https://midominio.com/?response-reniec=1&state=xyz&session_state=xyz&code=xyz`