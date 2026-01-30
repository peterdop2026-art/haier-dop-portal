@echo off
REM Start Haier DOP Portal Development Servers

echo.
echo ====================================
echo  Haier DOP Portal - Server Startup
echo ====================================
echo.

REM Check if Node.js is installed
node --version >nul 2>&1
if errorlevel 1 (
    echo ERROR: Node.js is not installed!
    echo Download from: https://nodejs.org/
    pause
    exit /b 1
)

echo Checking environment...
echo.

REM Display current status
echo Node.js version:
node --version
echo.

echo.
echo To start the servers, open 2 PowerShell terminals:
echo.
echo TERMINAL 1 - Backend Server:
echo   cd d:\haier-dop-portal\backend
echo   powershell -ExecutionPolicy Bypass -Command "npm run start:dev"
echo.
echo TERMINAL 2 - Frontend Server:
echo   cd d:\haier-dop-portal
echo   powershell -ExecutionPolicy Bypass -Command "npm run dev"
echo.
echo Then open your browser:
echo   User App: http://localhost:5173/
echo   Admin: http://localhost:5173/admin
echo.
echo ====================================
echo   See RUN_SERVERS.md for details
echo ====================================
echo.
pause
