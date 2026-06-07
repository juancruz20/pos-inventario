; ============================================
; Script Inno Setup - Sistema POS
; ============================================
; Empaqueta el proyecto POS para distribuirlo a otra PC.
;
; Requisitos en la PC destino:
;   - XAMPP instalado en C:\xampp\ (Apache + MySQL)
;
; Lo que hace este instalador:
;   1. Copia todos los archivos del proyecto a C:\xampp\htdocs\pos\
;   2. Crea acceso directo en el escritorio
;   3. (Opcional) Crea acceso directo en el menú inicio
;
; Para compilar: instalar Inno Setup (https://jrsoftware.org/isinfo.php)
;   y abrir este archivo con Inno Setup Compiler, o ejecutar ISCC.exe.
; ============================================

#define MyAppName "Sistema POS"
#define MyAppVersion "1.0.0"
#define MyAppPublisher "Inventario POS"
#define MyAppURL "https://github.com/juancruz20/pos-inventario"
#define MyAppExeName "POS.url"

[Setup]
AppId={{B5F8E4A1-9C2D-4D3E-B6F1-7A8C9E0D2B3F}
AppName={#MyAppName}
AppVersion={#MyAppVersion}
AppPublisher={#MyAppPublisher}
AppPublisherURL={#MyAppURL}
AppSupportURL={#MyAppURL}
DefaultDirName=C:\xampp\htdocs\pos
DefaultGroupName={#MyAppName}
DisableProgramGroupPage=yes
DisableWelcomePage=no
OutputDir=output
OutputBaseFilename=pos_installer
Compression=lzma
SolidCompression=yes
WizardStyle=modern
PrivilegesRequired=admin
UninstallDisplayIcon={app}\dist\img\plantilla\icono.png
ArchitecturesInstallIn64BitMode=x64compatible

[Languages]
Name: "spanish"; MessagesFile: "compiler:Languages\Spanish.isl"

[Tasks]
Name: "desktopicon"; Description: "Crear acceso directo en el escritorio"; GroupDescription: "Accesos directos:"

[Files]
; Copia TODO el contenido del proyecto (carpeta pos actual) al destino
; Excluye archivos innecesarios de git, pruebas y builds anteriores
Source: "*"; DestDir: "{app}"; Flags: ignoreversion recursesubdirs createallsubdirs; Excludes: ".git\*,*.git,*.gitignore,*.gitkeep,output\*,*.ps1,*.tmp,*.log"
; NOTA: "ignoreversion" es importante para que reinstale sobre versiones nuevas

[Icons]
; Acceso directo que abre el instalador web (que crea la BD y la deja lista)
Name: "{commondesktop}\{#MyAppName}"; Filename: "{app}\abrir-pos.bat"; Tasks: desktopicon
Name: "{group}\Abrir Sistema POS"; Filename: "{app}\abrir-pos.bat"
Name: "{group}\Instalar Base de Datos"; Filename: "{app}\instalar-pos.bat"
Name: "{group}\Desinstalar"; Filename: "{uninstallexe}"

[Run]
; Opcional: lanzar el instalador web al terminar
Filename: "{app}\instalar-pos.bat"; Description: "Ejecutar instalador web ahora"; Flags: nowait postinstall skipifsilent

[UninstallDelete]
; Limpia archivos de cache al desinstalar
Type: filesandordirs; Name: "{app}\vistas\img\productos\*"
Type: filesandordirs; Name: "{app}\vistas\img\usuarios\*"
Type: filesandordirs; Name: "{app}\vistas\img\comprobantes\*"

[Code]
// Verifica que XAMPP este instalado antes de continuar
function InitializeSetup(): Boolean;
var
  XamppPath: String;
begin
  Result := True;
  XamppPath := 'C:\xampp\';

  if not DirExists(XamppPath) then
  begin
    if MsgBox('No se detecto XAMPP en ' + XamppPath + '.' + #13#10 +
              'Este sistema requiere XAMPP con Apache y MySQL.' + #13#10 +
              'Descarga gratis desde: https://www.apachefriends.org/' + #13#10#13#10 +
              'Deseas continuar de todos modos?',
              mbConfirmation, MB_YESNO) = IDNO then
    begin
      Result := False;
    end;
  end;
end;
