# Project Setup and Running Guide

## Cleanup Completed ✅

The following files have been removed:
- ❌ `firebase.json` - Firebase hosting config (no longer needed)
- ❌ `firestore.rules` - Firestore security rules (replaced with PostgreSQL)
- ❌ `firestore.indexes.json` - Firestore indexes (replaced with PostgreSQL)
- ❌ `functions/` - Firebase Cloud Functions (replaced with NestJS backend)
- ❌ `.firebase/` - Firebase local directory
- ❌ `.firebaserc` - Firebase config file
- ❌ `metadata.json` - Unused metadata
- ❌ `PROJECT_SETUP.md` - Old setup docs
- ❌ `SETUP_INSTRUCTIONS.md` - Old setup docs
- ✏️ `services/firebase.ts` - Converted to deprecation note (references updated)

## Environment Configuration

### Frontend .env File
Location: `d:\haier-dop-portal\.env`

```env
# API Configuration
VITE_API_URL=http://localhost:3000

# EmailJS Configuration
VITE_EMAILJS_SERVICE_ID=service_zey2vlq
VITE_EMAILJS_TEMPLATE_APPROVED=template_073zy28
VITE_EMAILJS_PUBLIC_KEY=N2D4sZdTC5wXP1sjr
```

### Backend .env File
Location: `d:\haier-dop-portal\backend\.env`

**You need to create this file! Template provided below:**

```env
# Server Configuration
PORT=3000
NODE_ENV=development

# PostgreSQL Database Configuration
DB_HOST=localhost
DB_PORT=5432
DB_USERNAME=haier_user
DB_PASSWORD=your_postgres_password_here
DB_NAME=haier_dop

# JWT Configuration
JWT_SECRET=your_jwt_secret_key_change_in_production
JWT_EXPIRATION=24h
```

## Prerequisites to Install

### 1. Node.js and npm
- **Download from:** [https://nodejs.org/](https://nodejs.org/)
- **Install:** LTS version (v18 or v20 recommended)
- **Verify:** Open PowerShell and run:
  ```powershell
  node --version
  npm --version
  ```

### 2. PostgreSQL Database
- **Download from:** [https://www.postgresql.org/download/](https://www.postgresql.org/download/)
- **Install:** Choose latest stable version
- **Note the password:** You'll need this for the .env file
- **After installation, verify it's running:**
  ```powershell
  psql --version
  ```

## Step-by-Step Setup

### Step 1: Create PostgreSQL Database

Open **pgAdmin** (comes with PostgreSQL) or use **psql** command line:

```sql
-- Connect as postgres user, then run:
CREATE USER haier_user WITH PASSWORD 'your_secure_password';
CREATE DATABASE haier_dop OWNER haier_user;
GRANT ALL PRIVILEGES ON DATABASE haier_dop TO haier_user;
```

**Or use pgAdmin GUI:**
1. Open pgAdmin
2. Right-click "Databases" → "Create" → "Database"
3. Name: `haier_dop`
4. Owner: Create new user `haier_user` with password

### Step 2: Configure Environment Variables

**Frontend:**
1. Update `d:\haier-dop-portal\.env` with your EmailJS credentials

**Backend:**
1. Create file: `d:\haier-dop-portal\backend\.env`
2. Copy from `backend\.env.example`
3. Update with your PostgreSQL password:
   ```env
   DB_PASSWORD=your_postgres_password_here
   ```

### Step 3: Install Dependencies

Open PowerShell/Command Prompt in the project root:

```powershell
# Frontend dependencies
npm install

# Backend dependencies
cd backend
npm install
cd ..
```

This may take 5-10 minutes. Wait for completion.

### Step 4: Initialize Database with Seed Data

```powershell
cd backend
npm run seed:admin
cd ..
```

This creates the first admin user in the database.

## Running the Project

You'll need **TWO terminal windows** open simultaneously.

### Terminal 1: Start Backend Server

```powershell
cd d:\haier-dop-portal\backend
npm run start:dev
```

You should see:
```
[Nest] 12345  - 01/15/2026, 10:30:00 AM     LOG [NestFactory] Starting Nest application...
[Nest] 12345  - 01/15/2026, 10:30:01 AM     LOG [InstanceLoader] TypeOrmModule dependencies initialized
[Nest] 12345  - 01/15/2026, 10:30:02 AM     LOG [RoutesResolver] AppController {/}:
...
[Nest] 12345  - 01/15/2026, 10:30:03 AM     LOG [NestApplication] Nest application successfully started
```

**Backend is running at:** `http://localhost:3000`

### Terminal 2: Start Frontend Development Server

```powershell
cd d:\haier-dop-portal
npm run dev
```

You should see:
```
  VITE v6.2.0  running at:

  ➜  Local:   http://localhost:5173/
  ➜  press h to show help
```

**Frontend is running at:** `http://localhost:5173/`

## Accessing the Application

### User Side
- **URL:** `http://localhost:5173/` (or `http://localhost:5173/user`)
- **Features:**
  - Sign Up with SAP ID and Email
  - Login
  - Submit DOP Requests
  - View My Requests
  - Track Status (Pending/Approved/Rejected)
  - Logout

### Admin Side
- **URL:** `http://localhost:5173/admin`
- **Features:**
  - Admin Login
  - View All DOP Requests
  - Approve/Reject Requests
  - Add Comments
  - Logout

## Default Admin Account

After running `npm run seed:admin`, use these credentials:

```
Email: admin@haier.com
Password: Admin@123 (or as set in seed-admin.ts)
```

⚠️ **IMPORTANT:** Change this password in production!

## Testing the Workflow

1. **Open two browser tabs:**
   - Tab 1: `http://localhost:5173/` (User)
   - Tab 2: `http://localhost:5173/admin` (Admin)

2. **User Side:**
   - Sign up with a new account
   - Login
   - Submit a DOP request with files
   - View request status

3. **Admin Side:**
   - Login with admin credentials
   - See the submitted request
   - Click Approve/Reject
   - See email notification (EmailJS)

4. **User Side (again):**
   - Check "My Requests" tab
   - Verify status changed to Approved/Rejected

## Project Structure

```
haier-dop-portal/
├── Frontend (React + TypeScript + Vite)
│   ├── App.tsx
│   ├── components/
│   │   ├── Login.tsx
│   │   ├── SignUp.tsx
│   │   ├── RequestForm.tsx
│   │   ├── MyRequests.tsx
│   │   ├── AdminDashboard.tsx
│   │   └── Layout.tsx
│   ├── services/
│   │   ├── api.ts (API endpoints)
│   │   ├── dopService.ts (DOP logic)
│   │   └── emailService.ts (EmailJS)
│   ├── contexts/
│   │   └── AuthContext.tsx (Authentication state)
│   └── index.tsx
│
├── Backend (NestJS + PostgreSQL)
│   ├── src/
│   │   ├── auth/
│   │   │   ├── auth.service.ts
│   │   │   ├── auth.controller.ts
│   │   │   ├── jwt.strategy.ts
│   │   │   └── jwt-auth.guard.ts
│   │   ├── users/
│   │   │   ├── users.service.ts
│   │   │   ├── users.controller.ts
│   │   │   └── user.entity.ts
│   │   ├── admins/
│   │   │   ├── admins.service.ts
│   │   │   ├── admins.controller.ts
│   │   │   └── admin.entity.ts
│   │   ├── dop-requests/
│   │   │   ├── dop-requests.service.ts
│   │   │   ├── dop-requests.controller.ts
│   │   │   ├── dop-request.entity.ts
│   │   │   └── dop-requests.module.ts
│   │   ├── database/
│   │   │   └── database.module.ts (PostgreSQL config)
│   │   ├── app.module.ts
│   │   └── main.ts
│   ├── uploads/ (Generated when files uploaded)
│   ├── .env (You create this)
│   └── package.json
│
├── .env (Frontend config)
├── .env.example (Frontend template)
├── README.md (Project overview)
├── SETUP_GUIDE.md (This file)
└── package.json (Frontend)
```

## Available Commands

### Frontend
```bash
npm run dev       # Start development server (Vite)
npm run build     # Build for production
npm run preview   # Preview production build locally
```

### Backend
```bash
npm run start:dev      # Start with auto-reload (watch mode)
npm run start:prod     # Start production server
npm run build          # Build TypeScript to JavaScript
npm run lint           # Run ESLint
npm run test           # Run unit tests
npm run test:e2e       # Run end-to-end tests
npm run seed:admin     # Create initial admin user
```

## Troubleshooting

### "npm: command not found"
- ✅ **Solution:** Install Node.js from [https://nodejs.org/](https://nodejs.org/)

### "Database connection refused"
- ✅ **Solution:** Ensure PostgreSQL is running
  ```powershell
  # On Windows, check Services or:
  psql -U postgres
  ```

### "Port 3000 already in use"
- ✅ **Solution:** Change PORT in `backend/.env` or kill the process
  ```powershell
  # Find process using port 3000
  Get-NetTCPConnection -LocalPort 3000
  
  # Kill it (replace PID)
  Stop-Process -Id <PID> -Force
  ```

### "CORS error from frontend"
- ✅ **Solution:** Backend CORS is already configured. Ensure:
  - Backend is running on `http://localhost:3000`
  - Frontend `.env` has `VITE_API_URL=http://localhost:3000`

### "Email notifications not working"
- ✅ **Solution:** 
  - Check EmailJS credentials in `.env`
  - Create email templates in EmailJS dashboard
  - Use template IDs from dashboard in `.env`

### "Files not uploading"
- ✅ **Solution:**
  - Create `backend/uploads` folder
  - Check file size limits
  - Verify Multer configuration in `dop-requests.module.ts`

## Email Setup (EmailJS)

1. **Create EmailJS Account:**
   - Visit [https://www.emailjs.com/](https://www.emailjs.com/)
   - Sign up for free account

2. **Create Email Service:**
   - Add your email provider (Gmail, Outlook, etc.)
   - Get your Service ID

3. **Create Email Templates:**
   - **Approved Template:**
     - Subject: "Your DOP Request Approved"
     - Body: Use variables like `{{to_name}}`, `{{work_order}}`, etc.
   - **Rejected Template:**
     - Subject: "Your DOP Request Rejected"
     - Body: Similar variables

4. **Get Your Credentials:**
   - Service ID
   - Template ID (for each template)
   - Public Key

5. **Update .env:**
   ```env
   VITE_EMAILJS_SERVICE_ID=your_service_id
   VITE_EMAILJS_TEMPLATE_APPROVED=your_template_id
   VITE_EMAILJS_PUBLIC_KEY=your_public_key
   ```

## Production Deployment

### Build Frontend
```bash
npm run build
# Creates optimized files in dist/
```

### Build Backend
```bash
cd backend
npm run build
# Creates optimized files in dist/
```

### Deploy Frontend
- Use your existing Firebase hosting
- Or deploy to Vercel, Netlify, etc.

### Deploy Backend
- Use services like:
  - **Heroku** (free tier available)
  - **Railway** 
  - **Render**
  - **AWS**
  - **Your own server**

## Project was Migrated From Firebase!

This project originally used Firebase:
- ❌ Firebase Authentication → ✅ NestJS JWT
- ❌ Firestore Database → ✅ PostgreSQL + TypeORM
- ❌ Firebase Storage → ✅ Local file storage with Multer
- ❌ Cloud Functions → ✅ NestJS Controllers/Services

All data and functionality is now self-hosted using PostgreSQL and NestJS!

## Support & Questions

- Check README.md for project overview
- Review code comments in components
- Check backend src/ folder structure
- All API endpoints documented in README.md

---

**Last Updated:** January 15, 2026
**Status:** ✅ Ready to Run (after Node.js and PostgreSQL installation)
