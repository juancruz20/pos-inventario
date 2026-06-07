@echo off
:: ============================================
::  Instalador web - Sistema POS
:: ============================================
::  Este script abre el navegador con el instalador
::  web que crea la base de datos y deja el sistema
::  listo para usar.
:: ============================================

setlocal

set "XAMPP_DIR=C:\xampp"
set "URL=http://localhost/pos/install.php"

echo.
echo =============================================
echo   Instalador web - Sistema POS
echo =============================================
echo.

:: Verificar XAMPP
if not exist "%XAMPP_DIR%\xampp_start.exe" (
    echo [ERROR] No se encontro XAMPP en %XAMPP_DIR%
    echo.
    echo Por favor instala XAMPP primero desde:
    echo https://www.apachefriends.org/
    echo.
    pause
    exit /b 1
)

:: Preguntar si quiere iniciar Apache/MySQL
set /p "START=Iniciar Apache y MySQL ahora? (S/N): "
if /i "%START%"=="S" (
    echo.
    echo Iniciando XAMPP...
    start "" "%XAMPP_DIR%\xampp_start.exe"
    echo Esperando 5 segundos a que inicien los servicios...
    timeout /t 5 /nobreak >nul
)

:: Abrir navegador con el instalador web
echo.
echo Abriendo navegador en: %URL%
echo.
echo Sigue los pasos en pantalla para completar la instalacion.
echo.
start "" "%URL%"

endlocal
