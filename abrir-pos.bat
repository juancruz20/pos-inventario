@echo off
:: ============================================
::  Abrir Sistema POS
:: ============================================
::  Inicia XAMPP si no esta corriendo y abre el
::  sistema POS en el navegador.
:: ============================================

setlocal

set "XAMPP_DIR=C:\xampp"
set "URL=http://localhost/pos/inicio"

echo.
echo =============================================
echo   Sistema POS
echo =============================================
echo.

:: Verificar XAMPP
if not exist "%XAMPP_DIR%\xampp_start.exe" (
    echo [ERROR] No se encontro XAMPP en %XAMPP_DIR%
    pause
    exit /b 1
)

:: Iniciar servicios si no estan corriendo
tasklist /FI "IMAGENAME eq httpd.exe" 2>NUL | find /I /N "httpd.exe">NUL
if "%ERRORLEVEL%" NEQ "0" (
    echo Iniciando Apache y MySQL...
    start "" "%XAMPP_DIR%\xampp_start.exe"
    timeout /t 5 /nobreak >nul
) else (
    echo Apache ya esta corriendo.
)

echo.
echo Abriendo: %URL%
echo.
start "" "%URL%"

endlocal
