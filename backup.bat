@echo off
REM ============================================================
REM Script para hacer backup del proyecto POS y su base de datos
REM ============================================================
REM Uso: doble click en backup.bat
REM Los backups se guardan en C:\xampp\htdocs\Copias_de_proyectos\backups\
REM ============================================================

setlocal enabledelayedexpansion

set FECHA=%date:~-4%-%date:~3,2%-%date:~0,2%_%time:~0,2%-%time:~3,2%
set FECHA=%FECHA: =0%
set BACKUP_DIR=C:\xampp\htdocs\Copias_de_proyectos\backups
set SRC_DIR=C:\xampp\htdocs\pos
set ZIP_PATH=%BACKUP_DIR%\pos_%FECHA%.zip
set SQL_PATH=%BACKUP_DIR%\pos_db_%FECHA%.sql

echo.
echo ============================================================
echo   POS Inventario - Backup
echo   %date% %time%
echo ============================================================
echo.

if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

echo [1/3] Verificando MySQL...
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo    MySQL no parece estar corriendo. Intentando continuar...
)

echo.
echo [2/3] Exportando base de datos a %SQL_PATH%...
"C:\xampp\mysql\bin\mysqldump.exe" -u root --default-character-set=utf8 --skip-comments --databases pos > "%SQL_PATH%" 2>nul
if %errorlevel% neq 0 (
    echo    ADVERTENCIA: no se pudo exportar la BD. Continuando solo con archivos.
    del "%SQL_PATH%" 2>nul
) else (
    echo    BD exportada correctamente.
)

echo.
echo [3/3] Comprimiendo proyecto a %ZIP_PATH%...
powershell -NoProfile -Command "Add-Type -AssemblyName System.IO.Compression.FileSystem; $src = '%SRC_DIR%'; $dst = '%ZIP_PATH%'; if (Test-Path $dst) { Remove-Item $dst -Force }; $temp = Join-Path $env:TEMP ('pos_backup_' + [guid]::NewGuid().ToString('N')); New-Item -ItemType Directory -Path $temp -Force | Out-Null; Get-ChildItem -LiteralPath $src -Force | Where-Object { $_.Name -ne '.git' } | ForEach-Object { Copy-Item -LiteralPath $_.FullName -Destination (Join-Path $temp $_.Name) -Recurse -Force }; [System.IO.Compression.ZipFile]::CreateFromDirectory($temp, $dst, [System.IO.Compression.CompressionLevel]::Optimal, $false); Remove-Item $temp -Recurse -Force; Write-Host ('Tamano: ' + [math]::Round((Get-Item $dst).Length / 1MB, 2) + ' MB')"

echo.
echo ============================================================
echo   Backup completado
echo   Archivos:
if exist "%ZIP_PATH%"   echo     %ZIP_PATH%
if exist "%SQL_PATH%"   echo     %SQL_PATH%
echo ============================================================
echo.
pause
