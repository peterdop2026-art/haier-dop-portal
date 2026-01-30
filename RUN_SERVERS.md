# 🚀 Project Ready to Run!

## ✅ Completed Setup

- [x] Node.js & npm installed
- [x] Frontend dependencies installed
- [x] Backend dependencies installed
- [x] PostgreSQL database created (`haier_dop`)
- [x] Backend .env configured with correct password
- [x] Admin user seeded in database
- [x] All files cleaned and organized

## 🎯 Next: Start the Development Servers

You need **TWO separate terminal windows** for both servers to run simultaneously.

---

## Terminal 1: Start Backend Server

Open a new PowerShell and run:

```powershell
cd d:\haier-dop-portal\backend
powershell -ExecutionPolicy Bypass -Command "npm run start:dev"
```

**Expected output:**
```
[Nest] 12345  - 01/17/2026, 10:30:00 AM     LOG [NestFactory] Starting Nest application...
[Nest] 12345  - 01/17/2026, 10:30:01 AM     LOG [InstanceLoader] TypeOrmModule dependencies initialized
[Nest] 12345  - 01/17/2026, 10:30:02 AM     LOG [RoutesResolver] AppController {/}:
[Nest] 12345  - 01/17/2026, 10:30:03 AM     LOG [NestApplication] Nest application successfully started
```

✅ **Backend will be running at:** `http://localhost:3000`

---

## Terminal 2: Start Frontend Server

Open another new PowerShell and run:

```powershell
cd d:\haier-dop-portal
powershell -ExecutionPolicy Bypass -Command "npm run dev"
```

**Expected output:**
```
  VITE v6.2.0  running at:

  ➜  Local:   http://localhost:5173/
  ➜  press h to show help
```

✅ **Frontend will be running at:** `http://localhost:5173`

---

## 🌐 Access the Application

Once both servers are running, open your browser:

### User Application
- **URL:** http://localhost:5173/
- **Features:**
  - Sign up new account
  - Login with credentials
  - Submit DOP requests
  - View request history
  - Track request status

### Admin Dashboard
- **URL:** http://localhost:5173/admin
- **Features:**
  - Admin login
  - View all requests
  - Approve/Reject requests
  - See request details

---

## 🔐 Default Admin Login

```
Email: admin@haier.com
Password: Admin@123
```

⚠️ **Change this password after first login in production!**

---

## 📝 Test Workflow

1. **Open user app** (http://localhost:5173/)
2. **Sign up** with a new account (e.g., SAP ID: TEST001)
3. **Login** with your credentials
4. **Submit a DOP request** with files
5. **Open admin dashboard** (http://localhost:5173/admin)
6. **Login** as admin
7. **View the request** and click Approve/Reject
8. **Check user's "My Requests"** tab - status should be updated

---

## 🐛 Troubleshooting

### "Port 3000 already in use"
```powershell
# Kill the process using port 3000
Get-NetTCPConnection -LocalPort 3000 | ForEach-Object {
  Stop-Process -Id $_.OwningProcess -Force
}
```

### "Database connection error"
- Verify PostgreSQL is running
- Check `backend/.env` has correct password
- Ensure database `haier_dop` exists

### "CORS error in frontend"
- Backend is already configured for CORS
- Ensure backend is running on `http://localhost:3000`

### "npm: command not found" in PowerShell
Use the bypass method:
```powershell
powershell -ExecutionPolicy Bypass -Command "npm run dev"
```

---

## 📊 Project Structure Reminder

```
d:\haier-dop-portal\
├── Frontend (React + TypeScript)
│   ├── components/ (UI components)
│   ├── services/ (API calls)
│   ├── contexts/ (Auth state)
│   └── App.tsx
│
├── backend/ (NestJS API)
│   ├── src/
│   │   ├── auth/ (Authentication)
│   │   ├── users/ (User management)
│   │   ├── admins/ (Admin management)
│   │   ├── dop-requests/ (Core logic)
│   │   └── database/ (PostgreSQL)
│   └── main.ts
│
└── Configuration
    ├── .env (Frontend config)
    └── backend/.env (Backend config)
```

---

## 📚 Documentation Files

- **README.md** - Project overview
- **SETUP_GUIDE.md** - Detailed setup instructions
- **QUICK_START.md** - Quick checklist

---

## ⚡ Quick Commands Reference

### Frontend
```bash
npm run dev       # Start development server
npm run build     # Build for production
npm run preview   # Preview production build
```

### Backend
```bash
npm run start:dev      # Start with auto-reload
npm run start:prod     # Start production server
npm run build          # Build TypeScript
npm run seed:admin     # Create admin user
```

---

## ✨ You're All Set!

**Everything is ready.** Just start both servers in separate terminals and enjoy your DOP portal!

If you need help, check the documentation files or review the code comments.

**Happy coding!** 🎉
