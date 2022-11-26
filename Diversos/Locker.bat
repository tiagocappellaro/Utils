cls
@ECHO OFF
title Folder Privadas
if EXIST "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}" goto UNLOCK
if NOT EXIST Privadas goto MDLOCKER
:CONFIRM
echo Tem certeza de que deseja bloquear a pasta (S/N)
set/p "cho=>"
if %cho%==Y goto LOCK
if %cho%==y goto LOCK
if %cho%==S goto LOCK
if %cho%==s goto LOCK
if %cho%==n goto END
if %cho%==N goto END
echo Invalid choice.
goto CONFIRM
:LOCK
ren Privadas "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}"
attrib +h +s "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}"
echo Folder locked
goto End
:UNLOCK
echo Digite a senha para desbloquear pasta
set/p "pass=>"
if NOT %pass%== 123 goto FAIL
attrib -h -s "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}"
ren "Control Panel.{21EC2020-3AEA-1069-A2DD-08002B30309D}" Privadas
echo Folder Unlocked successfully
goto End
:FAIL
echo Senha Invalida
goto end
:MDLOCKER
md Privadas
echo Privadas foi criada com sucesso
goto End
:End