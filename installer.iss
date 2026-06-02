; ============================================================
; POS Inventario - Script de Inno Setup
; Crea un instalador .exe que incluye XAMPP portable + el sistema
; y configura Apache/MySQL para arrancar automaticamente con Windows
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
Name: "startmenuicon"; Description: "Crear acceso directo en el menu inicio"; GroupDescription: "Accesos directos:";
Name: "autostartservices"; Description: "Iniciar Apache y MySQL automaticamente al encender la PC (recomendado)"; GroupDescription: "Servicios:";

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
Name: "{group}\Desinstalar {#MyAppName}"; Filename: "{uninstallexe}"

[Run]
; Registrar Apache como servicio de Windows (inicio automatico)
Filename: "{app}\xampp\apache\bin\httpd.exe"; Parameters: "-k install -n ""ApachePOS"""; Flags: runhidden; Tasks: autostartservices; Check: ServiceNotInstalled('ApachePOS')
Filename: "sc"; Parameters: "config ApachePOS start= auto"; Flags: runhidden; Tasks: autostartservices
Filename: "net"; Parameters: "start ApachePOS"; Flags: runhidden; Tasks: autostartservices

; Registrar MySQL como servicio de Windows (inicio automatico)
Filename: "{app}\xampp\mysql\bin\mysqld.exe"; Parameters: "--install MySQLPOS --defaults-file=""{app}\xampp\mysql\bin\my.ini"""; Flags: runhidden; Tasks: autostartservices; Check: ServiceNotInstalled('MySQLPOS')
Filename: "sc"; Parameters: "config MySQLPOS start= auto"; Flags: runhidden; Tasks: autostartservices
Filename: "net"; Parameters: "start MySQLPOS"; Flags: runhidden; Tasks: autostartservices

; Abrir el instalador del sistema en el navegador (ultimo paso)
Filename: "http://localhost/pos/install.php"; Description: "Abrir el instalador del sistema en el navegador"; Flags: nowait postinstall skipifsilent

[UninstallDelete]
Type: filesandordirs; Name: "{app}\xampp\htdocs\pos"

[UninstallRun]
; Detener y desregistrar los servicios al desinstalar
Filename: "net"; Parameters: "stop ApachePOS"; Flags: runhidden
Filename: "{app}\xampp\apache\bin\httpd.exe"; Parameters: "-k uninstall -n ""ApachePOS"""; Flags: runhidden
Filename: "net"; Parameters: "stop MySQLPOS"; Flags: runhidden
Filename: "{app}\xampp\mysql\bin\mysqld.exe"; Parameters: "--remove MySQLPOS"; Flags: runhidden

[Code]
function XamppNotInstalled: Boolean;
begin
  Result := not DirExists(ExpandConstant('{app}\xampp'));
end;

function ServiceNotInstalled(ServiceName: string): Boolean;
var
  ResultCode: Integer;
begin
  // Devuelve True si el servicio NO esta instalado
  Result := not Exec('sc', 'query "' + ServiceName + '"', '', SW_HIDE, ewWaitUntilTerminated, ResultCode)
            or (ResultCode <> 0);
end;

function InitializeSetup: Boolean;
begin
  MsgBox('Este instalador va a configurar POS Inventario en esta PC.' + #13#10 + #13#10 +
         'Incluye XAMPP (Apache + MySQL) si no esta instalado.' + #13#10 +
         'Si activas la opcion recomendada, los servicios arrancaran solos al encender la PC.' + #13#10 +
         'Se creara un acceso directo en el escritorio.',
         mbInformation, MB_OK);
  Result := True;
end;

procedure CurStepChanged(CurStep: TSetupStep);
begin
  // Hook para pasos personalizados (dejado vacio para futuras extensiones)
end;
