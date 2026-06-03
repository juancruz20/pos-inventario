; POS Inventario - Instalador completo con XAMPP portable
; Compila con Inno Setup 6.x

#define MyAppName "POS Inventario"
#define MyAppVersion "1.0.0"
#define MyAppPublisher "juancruz20"
#define MyAppURL "https://github.com/juancruz20/pos-inventario"
#define MyAppExeName "xampp_start.exe"
#define SourceXampp "C:\Users\ManuF\AppData\Local\Temp\opencode\pos_installer_build\xampp_portable\xampp"
#define SourceProject "C:\Users\ManuF\AppData\Local\Temp\opencode\pos_installer_build\project\pos"

[Setup]
AppId={{A1B2C3D4-E5F6-4A5B-8C9D-0E1F2A3B4C5D}
AppName={#MyAppName}
AppVersion={#MyAppVersion}
AppPublisher={#MyAppPublisher}
AppPublisherURL={#MyAppURL}
DefaultDirName={autopf}\{#MyAppName}
DefaultGroupName={#MyAppName}
DisableProgramGroupPage=yes
PrivilegesRequired=admin
PrivilegesRequiredOverridesAllowed=dialog
OutputDir=C:\xampp\htdocs\pos\dist
OutputBaseFilename=pos_installer_full_setup
SetupIconFile=
Compression=lzma2/normal
SolidCompression=yes
InternalCompressLevel=ultra
DiskSpanning=no
UninstallDisplayIcon={app}\xampp\xampp-control.exe
UninstallDisplayName={#MyAppName}
VersionInfoVersion={#MyAppVersion}
VersionInfoCompany={#MyAppPublisher}
WizardSizePercent=120
WindowVisible=no

[Languages]
Name: "spanish"; MessagesFile: "compiler:Languages\Spanish.isl"

[Tasks]
Name: "autostart"; Description: "Iniciar Apache y MySQL automaticamente al arrancar Windows"; GroupDescription: "Servicios:"; Flags: checkedonce
Name: "desktopicon"; Description: "Crear acceso directo en el escritorio"; GroupDescription: "Accesos directos:"; Flags: checkedonce

[Files]
Source: "{#SourceXampp}\*"; DestDir: "{app}\xampp"; Flags: ignoreversion recursesubdirs createallsubdirs
Source: "{#SourceProject}\*"; DestDir: "{app}\xampp\htdocs\pos"; Flags: ignoreversion recursesubdirs createallsubdirs

[Dirs]
Name: "{app}\xampp\tmp"

[Icons]
Name: "{group}\{#MyAppName}"; Filename: "{app}\xampp\xampp-control.exe"
Name: "{group}\Abrir POS en el navegador"; Filename: "http://localhost/pos"
Name: "{group}\Ver archivos del proyecto"; Filename: "{app}\xampp\htdocs\pos"
Name: "{commondesktop}\{#MyAppName}"; Filename: "{app}\xampp\xampp-control.exe"; Tasks: desktopicon

[Run]
Filename: "{app}\xampp\php\php.exe"; Parameters: "install.php --auto"; WorkingDir: "{app}\xampp\htdocs\pos"; Flags: runhidden waituntilterminated; Tasks: autostart
Filename: "http://localhost/pos"; Description: "Abrir el sistema en el navegador"; Flags: postinstall shellexec skipifsilent

[UninstallRun]
Filename: "{cmd}"; Parameters: "/c taskkill /F /IM mysqld.exe & taskkill /F /IM httpd.exe & exit 0"; Flags: runhidden
Filename: "{app}\xampp\uninstall.exe"; Flags: runhidden; RunOnceId: "UninstallXampp"

[UninstallDelete]
Type: filesandordirs; Name: "{app}\xampp\mysql\data\*"
Type: filesandordirs; Name: "{app}\xampp\php\tmp"
Type: filesandordirs; Name: "{app}\xampp\tmp"

[Messages]
BeveledLabel={#MyAppName} v{#MyAppVersion} - Sistema de Punto de Venta
SetupWindowTitle=Instalador de {#MyAppName}

[Code]
function NeedsAddPath(Param: string): boolean;
var
  OrigPath: string;
begin
  if not RegQueryStringValue(HKEY_LOCAL_MACHINE, 'SYSTEM\CurrentControlSet\Control\Session Manager\Environment', 'Path', OrigPath) then
    Result := True
  else
    Result := Pos(';' + LowerCase(Param) + ';', ';' + LowerCase(OrigPath) + ';') = 0;
end;

procedure AddToPath(Path: string);
var
  Paths: string;
begin
  if NeedsAddPath(Path) then
  begin
    if RegQueryStringValue(HKEY_LOCAL_MACHINE, 'SYSTEM\CurrentControlSet\Control\Session Manager\Environment', 'Path', Paths) then
    begin
      Paths := Paths + ';' + Path;
      RegWriteStringValue(HKEY_LOCAL_MACHINE, 'SYSTEM\CurrentControlSet\Control\Session Manager\Environment', 'Path', Paths);
    end;
  end;
end;

function InitializeSetup(): Boolean;
begin
  Result := True;
end;

procedure CurStepChanged(CurStep: TSetupStep);
begin
  if CurStep = ssPostInstall then
  begin
    AddToPath(ExpandConstant('{app}\xampp\php'));
    AddToPath(ExpandConstant('{app}\xampp\mysql\bin'));
  end;
end;
