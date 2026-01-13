# Portfolio Cloudflare

Portfolio website running on Cloudflare Pages with D1 database and R2 storage.

## Tech Stack

- **Frontend**: Static HTML + Tailwind CSS + Vanilla JavaScript
- **Backend**: Cloudflare Workers (Hono router)
- **Database**: Cloudflare D1 (SQLite)
- **Storage**: Cloudflare R2

## Development

### Prerequisites

1. Node.js 18+
2. Wrangler CLI (`npm install -g wrangler`)
3. Cloudflare account

### Setup

1. Install dependencies:
```bash
npm install
```

2. Login to Cloudflare:
```bash
wrangler login
```

3. Create D1 database:
```bash
wrangler d1 create portfolio-db
```

4. Update `wrangler.toml` with the database ID from step 3.

5. Create R2 bucket:
```bash
wrangler r2 bucket create portfolio-uploads
```

6. Apply database schema:
```bash
wrangler d1 execute portfolio-db --local --file=./src/db/schema.sql
wrangler d1 execute portfolio-db --local --file=./src/db/seed.sql
```

7. Run locally:
```bash
npm run dev
```

8. Open http://localhost:8788

### Default Login

- Username: `admin`
- Password: `admin`

> ⚠️ Change the password immediately after first login!

## Deployment

1. Set the JWT secret:
```bash
wrangler secret put JWT_SECRET
```

2. Apply schema to production:
```bash
wrangler d1 execute portfolio-db --file=./src/db/schema.sql
wrangler d1 execute portfolio-db --file=./src/db/seed.sql
```

3. Deploy:
```bash
npm run deploy
```

## Project Structure

```
portfolio/
├── public/                    # Static frontend files
│   ├── index.html            # Main portfolio page
│   ├── article.html          # Article detail page
│   ├── project-details.html  # Project detail page
│   └── admin/                # Admin dashboard
│       ├── index.html        # Dashboard
│       └── login.html        # Login page
├── functions/                 # Cloudflare Pages Functions (API)
│   └── api/
│       └── [[route]].ts      # API router
├── src/                       # Shared source code
│   ├── db/
│   │   ├── schema.sql        # D1 schema
│   │   └── seed.sql          # Initial data
│   └── types.ts              # TypeScript types
├── wrangler.toml             # Cloudflare config
├── package.json
└── tsconfig.json
```

## API Endpoints

### Public (no auth required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/public/profile` | Get profile data |
| GET | `/api/public/skills` | Get all skills |
| GET | `/api/public/education` | Get education list |
| GET | `/api/public/experience` | Get experience list |
| GET | `/api/public/projects` | Get projects |
| GET | `/api/public/projects/:id` | Get single project |
| GET | `/api/public/articles` | Get recent articles |
| GET | `/api/public/articles/:id` | Get single article |

### Auth

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/auth/login` | Login, returns JWT |

### Admin (requires JWT)

| Method | Endpoint | Description |
|--------|----------|-------------|
| PUT | `/api/admin/profile` | Update profile |
| PUT | `/api/admin/account` | Change password |
| GET/POST/PUT/DELETE | `/api/admin/experience/:id?` | CRUD experience |
| GET/POST/PUT/DELETE | `/api/admin/education/:id?` | CRUD education |
| GET/POST/PUT/DELETE | `/api/admin/skills/:id?` | CRUD skills |
| GET/POST/PUT/DELETE | `/api/admin/projects/:id?` | CRUD projects |
| GET/POST/PUT/DELETE | `/api/admin/articles/:id?` | CRUD articles |
| POST | `/api/admin/upload` | Upload file to R2 |

## Migrating Images to R2

To migrate existing images from the `uploads/` folder:

1. Upload files to R2 bucket manually or use wrangler:
```bash
# For each file
wrangler r2 object put portfolio-uploads/filename.png --file=./uploads/filename.png
```

2. Update image URLs in the seed.sql or directly in the database to point to R2:
```
https://portfolio-uploads.YOUR_ACCOUNT.r2.dev/filename.png
```

Or configure a custom domain for R2 in the Cloudflare dashboard.
