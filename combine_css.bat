@echo off
set "output=PAGTREM\style\combined.css"
if exist "%output%" del "%output%"
for %%f in (PAGTREM\style\*.css) do (
    if not "%%~nf"=="combined" (
        echo /* %%~nf.css */ >> "%output%"
        type "%%f" >> "%output%"
        echo. >> "%output%"
    )
)
