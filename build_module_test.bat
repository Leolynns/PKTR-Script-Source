@echo off
python -tt build_module.py
@del *.pyc
pause
REM copy main.lua "..\ded\Modules\Persistent Kingdoms\lua\main.lua" /Y
REM cd ..\ded
REM start mb_warband_dedicated.exe -r PK_server_cfg.txt -m Persistent Kingdoms
