@echo off
REM ============================================================
REM Script para restaurar un backup del proyecto POS
REM ============================================================
REM Uso: doble click en restaurar.bat
REM ============================================================

setlocal enabledelayedexpansion

set BACKUP_DIR=C:\xampp\htdocs\Copias_de_proyectos\backups
set DST_DIR=C:\xampp\htdocs\pos

echo.
echo ============================================================
echo   POS Inventario - Restaurar Backup
echo ============================================================
echo.
echo Backups disponibles:
echo.

set CONTADOR=0
for %%f in ("%BACKUP_DIR%\pos_*.zip") do (
    set /a CONTADOR+=1
    echo   [!CONTADOR!]  %%~nxf
    set "FILE_!CONTADOR!=%%f"
)

if %CONTADOR% equ 0 (
    echo   No se encontraron backups en %BACKUP_DIR%
    pause
    exit /b
)

echo.
set /p OPCION="Numero de backup a restaurar (0 para cancelar): "

if "%OPCION%"=="0" exit /b

call set ZIP_PATH=%%FILE_%OPCION%%%
if "%ZIP_PATH%"=="" (
    echo Opcion invalida.
    pause
    exit /b
)

echo.
echo ATENCION: esto va a sobrescribir todos los archivos en:
echo   %DST_DIR%
echo.
set /p CONFIRMAR="Continuar? (S/N): "
if /i not "%CONFIRMAR%"=="S" exit /b

echo.
echo [1/3] Deteniendo Apache y MySQL...
net stop ApachePOS 2>nul
net stop MySQLPOS 2>nul
net stop "Apache2.4" 2>nul
net stop mysql 2>nul

echo.
echo [2/3] Extrayendo backup a %DST_DIR%...
powershell -NoProfile -Command "Add-Type -AssemblyName System.IO.Compression.FileSystem; $src = '%ZIP_PATH%'; $dst = '%DST_DIR%'; if (Test-Path $dst) { Get-ChildItem -LiteralPath $dst -Force | Where-Object { $_.Name -ne '.git' } | Remove-Item -Recurse -Force }; [System.IO.Compression.ZipFile]::ExtractToDirectory($src, $dst); Write-Host 'Extraccion OK'"

echo.
echo [3/3] Restaurando base de datos...
for %%s in ("%BACKUP_DIR%\pos_db_*.sql") do (
    set "ULTIMO_SQL=%%s"
)
if defined ULTIMO_SQL (
    "C:\xampp\mysql\bin\mysql.exe" -u root < "!ULTIMO_SQL!" 2>nul
    if !errorlevel! neq 0 (
        echo    ADVERTENCIA: no se pudo restaurar la BD. Verificar manualmente.
    ) else (
        echo    BD restaurada desde !ULTIMO_SQL!
    )
) else (
    echo    No se encontro dump SQL para restaurar.
)

echo.
echo ============================================================
echo   Restauracion completada
echo   Iniciando servicios...
net start ApachePOS 2>nul
net start MySQLPOS 2>nul
echo ============================================================
echo.
pause
