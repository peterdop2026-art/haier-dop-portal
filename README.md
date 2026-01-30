# Haier DOP Portal

A full-stack web application for managing Date of Purchase (DOP) update requests for Haier products. Features include user authentication, request submission, admin dashboard for approvals, file uploads, and email notifications.

## Project Structure

```
├── Frontend (React + TypeScript + Vite)
│   ├── App.tsx - Main app component
│   ├── components/ - React components
│   ├── services/ - API services
│   ├── contexts/ - React Context providers
│   └── index.tsx - Entry point
│
├── Backend (NestJS + PostgreSQL)
│   ├── src/
│   │   ├── auth/ - Authentication & JWT
│   │   ├── users/ - User management
│   │   ├── admins/ - Admin management
│   │   ├── dop-requests/ - DOP request handling
│   │   ├── database/ - PostgreSQL configuration
│   │   └── main.ts - Server entry point
│   └── package.json
│
└── Configuration files
    ├── .env - Environment variables (frontend)
    ├── .env.example - Environment template
    └── backend/.env - Backend environment variables
```

## Features

✅ **User Authentication**
- Sign up with SAP ID and email
- Login with credentials
- JWT-based authentication
- Password reset functionality

✅ **DOP Request Management**
- Submit new DOP update requests
- Upload warranty cards and invoices
- Track request status (Pending, Approved, Rejected)
- View submission history

✅ **Admin Dashboard**
- Login with admin credentials
- View all pending requests
- Approve or reject requests
- Add comments or rejection reasons

✅ **Email Notifications**
- Automatic emails on request approval/rejection
- EmailJS integration for notifications
- Customizable email templates

✅ **File Uploads**
- Warranty card uploads
- Invoice document uploads
- Server-side storage with validation

✅ **Responsive Design**
- Mobile-friendly interface
- Tailwind CSS styling
- Lucide icons

## Prerequisites

- **Node.js** v16 or higher
- **PostgreSQL** v12 or higher
- **npm** or **yarn** package manager
- **EmailJS account** (for email notifications)

## Quick Start

### 1. Clone and Install Dependencies

```bash
# Frontend dependencies
npm install

# Backend dependencies
cd backend
npm install
cd ..
```

### 2. PostgreSQL Setup

**Download and Install PostgreSQL:**
1. Visit [https://www.postgresql.org/download/](https://www.postgresql.org/download/)
2. Install PostgreSQL for your OS
3. Remember the password you set during installation

**Create Database and User:**
```sql
-- Connect to PostgreSQL (use psql or pgAdmin)
CREATE USER haier_user WITH PASSWORD 'your_secure_password';
CREATE DATABASE haier_dop OWNER haier_user;
GRANT ALL PRIVILEGES ON DATABASE haier_dop TO haier_user;
```

### 3. Environment Setup

**Frontend (.env)**
```env
VITE_API_URL=http://localhost:3000
VITE_EMAILJS_SERVICE_ID=your_service_id
VITE_EMAILJS_TEMPLATE_APPROVED=your_template_id
VITE_EMAILJS_PUBLIC_KEY=your_public_key
```

**Backend (backend/.env)**
```env
PORT=3000
NODE_ENV=development
DB_HOST=localhost
DB_PORT=5432
DB_USERNAME=haier_user
DB_PASSWORD=your_secure_password
DB_NAME=haier_dop
JWT_SECRET=your_jwt_secret_key
JWT_EXPIRATION=24h
```

Copy from `.env.example` files and update with your values:
```bash
cp .env.example .env
cp backend/.env.example backend/.env
```

### 4. Initialize Database

Run the seed script to create the first admin user:
```bash
cd backend
npm run seed:admin
```

### 5. Start Development Servers

**Terminal 1 - Backend:**
```bash
cd backend
npm run start:dev
```

**Terminal 2 - Frontend:**
```bash
npm run dev
```

## Available Scripts

### Frontend
```bash
npm run dev       # Start development server
npm run build     # Build for production
npm run preview   # Preview production build
```

### Backend
```bash
npm run start:dev      # Start in watch mode
npm run start:prod     # Start production server
npm run build          # Build TypeScript
npm run lint           # Run ESLint
npm run test           # Run tests
npm run test:e2e       # Run E2E tests
npm run seed:admin     # Create admin user
```

## API Endpoints

### Authentication
- `POST /auth/login` - User login
- `POST /auth/admin/login` - Admin login
- `POST /users/signup` - User registration

### DOP Requests
- `GET /dop-requests` - Get all requests (admin only)
- `GET /dop-requests/my` - Get user's requests
- `POST /dop-requests` - Submit new request
- `PUT /dop-requests/:id/status` - Update request status (admin only)

### Users
- `GET /users/:id` - Get user profile
- `PUT /users/:id` - Update user profile

### Admins
- `GET /admins` - Get all admins (admin only)
- `POST /admins` - Create admin (admin only)

## Technologies Used

### Frontend
- **React 19** - UI framework
- **TypeScript** - Type safety
- **Vite** - Build tool and dev server
- **React Router** - Client-side routing
- **Axios** - HTTP client
- **Tailwind CSS** - Styling
- **Lucide React** - Icon library
- **EmailJS** - Client-side email service

### Backend
- **NestJS** - Node.js framework
- **TypeORM** - ORM for PostgreSQL
- **PostgreSQL** - Database
- **JWT** - Authentication tokens
- **Passport** - Authentication middleware
- **Multer** - File upload handling
- **Class Validator** - Data validation
- **bcryptjs** - Password hashing

## Project Status

✅ **Migrated from Firebase to PostgreSQL**
- ✅ Removed Firebase Cloud Functions
- ✅ Removed Firestore database references
- ✅ Removed Firebase Auth (using JWT instead)
- ✅ Implemented NestJS backend with PostgreSQL
- ✅ Updated frontend API calls to use backend endpoints
- ✅ Cleaned up extra/unnecessary files

## Deployed

- **Live Application**: [https://haier-dop-portal-by-ahsan.web.app/](https://haier-dop-portal-by-ahsan.web.app/)
- **Admin Dashboard**: [https://haier-dop-portal-by-ahsan.web.app/admin](https://haier-dop-portal-by-ahsan.web.app/admin)

## Troubleshooting

### Database Connection Error
- Verify PostgreSQL is running
- Check DB_HOST, DB_PORT, DB_USERNAME, DB_PASSWORD in backend/.env
- Ensure database `haier_dop` exists

### CORS Error
- Backend CORS is configured to allow frontend requests
- Verify VITE_API_URL matches backend URL

### Email Notifications Not Working
- Check EmailJS credentials in .env
- Verify email templates exist in EmailJS dashboard
- Check browser console for errors

### File Upload Failures
- Ensure `backend/uploads` directory exists
- Check file size limits in backend/.env
- Verify file format is supported

## License

UNLICENSED - Private Project

## Support

For issues and questions, contact the development team.
