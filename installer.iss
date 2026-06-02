; ============================================================
; POS Inventario - Script de Inno Setup
; Crea un instalador .exe que incluye XAMPP portable + el sistema
; ============================================================
; Compilacion: descargar Inno Setup de https://jrsoftware.org/isdl.php
;   y abrir este archivo con Inno Setup Compiler -> Build -> Compile
; ============================================================

#define MyAppName "POS Inventario"
#define MyAppVersion "2.0"
#define MyAppPublisher "POS Inventario"
#define MyAppURL "https://github.com/juancruz20/pos-inventario"
#define MyAppExeName "pos_installer.exe"

[Setup]
AppId={{A1B2C3D4-E5F6-7890-ABCD-EF1234567890}
AppName={#MyAppName}
AppVersion={#MyAppVersion}
AppPublisher={#MyAppPublisher}
AppPublisherURL={#MyAppURL}
DefaultDirName={autopf}\{#MyAppName}
DefaultGroupName={#MyAppName}
DisableProgramGroupPage=yes
OutputDir=installer_output
OutputBaseFilename={#MyAppExeName}
Compression=lzma2
SolidCompression=yes
WizardStyle=modern
PrivilegesRequired=admin
UninstallDisplayIcon={app}\xampp\apache\bin\httpd.exe
ArchitecturesInstallIn64BitMode=x64compatible

[Languages]
Name: "spanish"; MessagesFile: "compiler:Languages\Spanish.isl"

[Tasks]
Name: "desktopicon"; Description: "Crear acceso directo en el escritorio"; GroupDescription: "Accesos directos:";
Name: "startmenuicon"; Description: "Crear acceso directo en el menú inicio"; GroupDescription: "Accesos directos:";

[Files]
; Copiar XAMPP portable
Source: "C:\xampp\*"; DestDir: "{app}\xampp"; Flags: ignoreversion recursesubdirs createallsubdirs; Check: XamppNotInstalled
; Copiar el sistema POS
Source: "C:\xampp\htdocs\pos\*"; DestDir: "{app}\xampp\htdocs\pos"; Flags: ignoreversion recursesubdirs createallsubdirs

[Icons]
Name: "{commondesktop}\{#MyAppName}"; Filename: "http://localhost/pos"; Tasks: desktopicon
Name: "{group}\{#MyAppName}"; Filename: "http://localhost/pos"; Tasks: startmenuicon
Name: "{group}\Panel de Control XAMPP"; Filename: "{app}\xampp\xampp-control.exe"
Name: "{group}\Instalar Base de Datos"; Filename: "http://localhost/pos/install.php"

[Run]
; Abrir el panel de control de XAMPP al finalizar
Filename: "{app}\xampp\xampp-control.exe"; Description: "Abrir panel de control XAMPP"; Flags: nowait postinstall skipifsilent
; Abrir el instalador del sistema en el navegador
Filename: "http://localhost/pos/install.php"; Description: "Instalar base de datos"; Flags: nowait postinstall skipifsilent

[UninstallRun]
; Detener servicios XAMPP al desinstalar
Filename: "{app}\xampp\xampp_stop.exe"; Flags: runhidden

[Code]
function XamppNotInstalled: Boolean;
begin
  Result := not DirExists(ExpandConstant('{app}\xampp'));
end;

function InitializeSetup: Boolean;
begin
  // Mensaje de bienvenida
  MsgBox('Este instalador va a configurar POS Inventario en esta PC.' + #13#10 + #13#10 +
         'Incluye XAMPP (Apache + MySQL) si no esta instalado.' + #13#10 +
         'Se creara un acceso directo en el escritorio.', mbInformation, MB_OK);
  Result := True;
end;

procedure CurStepChanged(CurStep: TSetupStep);
begin
  if CurStep = ssPostInstall then
  begin
    // Configurar puerto de MySQL si es necesario
    // Aqui se podria editar httpd.conf o my.ini
  end;
end;
