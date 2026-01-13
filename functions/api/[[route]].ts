import { Hono } from 'hono';
import { cors } from 'hono/cors';

// Types
interface Env {
    DB: D1Database;
    UPLOADS: R2Bucket;
    JWT_SECRET: string;
}

interface Profile {
    id: number;
    name: string | null;
    bio: string | null;
    address: string | null;
    whatsapp: string | null;
    email: string | null;
    site_title: string | null;
    hero_role: string | null;
    hero_image_url: string | null;
    availability_text: string | null;
    projects_desc: string | null;
    contact_desc: string | null;
    projects_limit: number | null;
    link_github: string | null;
    link_linkedin: string | null;
    link_instagram: string | null;
    link_facebook: string | null;
    link_youtube: string | null;
    link_tiktok: string | null;
}

interface Article {
    id: number;
    title: string;
    content: string;
    image_url: string | null;
    created_at: string;
}

interface Education {
    id: number;
    school_name: string | null;
    degree: string | null;
    year_range: string | null;
}

interface Experience {
    id: number;
    role: string | null;
    company: string | null;
    year_range: string | null;
    description: string | null;
}

interface Project {
    id: number;
    title: string;
    description: string | null;
    image_url: string | null;
    link_url: string | null;
    created_at: string;
    details: string | null;
    display_order: number;
}

interface Skill {
    id: number;
    skill_name: string | null;
    icon_url: string | null;
}

interface JWTPayload {
    sub: string;
    username: string;
    exp: number;
    iat: number;
}

// Create Hono app with Cloudflare bindings
const app = new Hono<{ Bindings: Env }>();

// Enable CORS
app.use('/*', cors());

// ============================================================================
// HELPER: JWT Functions (using Web Crypto API)
// ============================================================================

async function createJWT(payload: Omit<JWTPayload, 'exp' | 'iat'>, secret: string): Promise<string> {
    const header = { alg: 'HS256', typ: 'JWT' };
    const now = Math.floor(Date.now() / 1000);
    const fullPayload = { ...payload, iat: now, exp: now + 86400 }; // 24 hours

    const base64Header = btoa(JSON.stringify(header)).replace(/=/g, '').replace(/\+/g, '-').replace(/\//g, '_');
    const base64Payload = btoa(JSON.stringify(fullPayload)).replace(/=/g, '').replace(/\+/g, '-').replace(/\//g, '_');

    const encoder = new TextEncoder();
    const key = await crypto.subtle.importKey(
        'raw',
        encoder.encode(secret),
        { name: 'HMAC', hash: 'SHA-256' },
        false,
        ['sign']
    );

    const signature = await crypto.subtle.sign('HMAC', key, encoder.encode(`${base64Header}.${base64Payload}`));
    const base64Signature = btoa(String.fromCharCode(...new Uint8Array(signature)))
        .replace(/=/g, '').replace(/\+/g, '-').replace(/\//g, '_');

    return `${base64Header}.${base64Payload}.${base64Signature}`;
}

async function verifyJWT(token: string, secret: string): Promise<JWTPayload | null> {
    try {
        const parts = token.split('.');
        if (parts.length !== 3) return null;

        const [header, payload, signature] = parts;

        const encoder = new TextEncoder();
        const key = await crypto.subtle.importKey(
            'raw',
            encoder.encode(secret),
            { name: 'HMAC', hash: 'SHA-256' },
            false,
            ['verify']
        );

        // Decode signature
        const sigBytes = Uint8Array.from(atob(signature.replace(/-/g, '+').replace(/_/g, '/')), c => c.charCodeAt(0));

        const valid = await crypto.subtle.verify('HMAC', key, sigBytes, encoder.encode(`${header}.${payload}`));
        if (!valid) return null;

        const decoded = JSON.parse(atob(payload.replace(/-/g, '+').replace(/_/g, '/'))) as JWTPayload;

        // Check expiration
        if (decoded.exp < Math.floor(Date.now() / 1000)) return null;

        return decoded;
    } catch {
        return null;
    }
}

async function verifyPassword(password: string, hash: string): Promise<boolean> {
    if (hash.startsWith('$2y$') || hash.startsWith('$2b$')) {
        return false;
    }

    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');

    return hashHex === hash;
}

async function hashPassword(password: string): Promise<string> {
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
}

// ============================================================================
// MIDDLEWARE: Auth Check
// ============================================================================

async function authMiddleware(c: any, next: () => Promise<void>) {
    const authHeader = c.req.header('Authorization');
    if (!authHeader || !authHeader.startsWith('Bearer ')) {
        return c.json({ error: 'Unauthorized' }, 401);
    }

    const token = authHeader.substring(7);
    const payload = await verifyJWT(token, c.env.JWT_SECRET);

    if (!payload) {
        return c.json({ error: 'Invalid or expired token' }, 401);
    }

    c.set('user', payload);
    await next();
}

// ============================================================================
// PUBLIC ENDPOINTS
// ============================================================================

app.get('/api/public/profile', async (c) => {
    try {
        const result = await c.env.DB.prepare('SELECT * FROM profile WHERE id = 1').first<Profile>();
        return c.json(result || {});
    } catch (error) {
        console.error('Profile error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/skills', async (c) => {
    try {
        const result = await c.env.DB.prepare('SELECT * FROM skills ORDER BY id').all<Skill>();
        return c.json(result.results || []);
    } catch (error) {
        console.error('Skills error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/education', async (c) => {
    try {
        const result = await c.env.DB.prepare('SELECT * FROM education ORDER BY id DESC').all<Education>();
        return c.json(result.results || []);
    } catch (error) {
        console.error('Education error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/experience', async (c) => {
    try {
        const result = await c.env.DB.prepare('SELECT * FROM experience ORDER BY id DESC').all<Experience>();
        return c.json(result.results || []);
    } catch (error) {
        console.error('Experience error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/projects', async (c) => {
    try {
        const limit = c.req.query('limit') || '6';
        const result = await c.env.DB.prepare(
            'SELECT * FROM projects ORDER BY display_order ASC LIMIT ?'
        ).bind(parseInt(limit)).all<Project>();
        return c.json(result.results || []);
    } catch (error) {
        console.error('Projects error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/projects/:id', async (c) => {
    try {
        const id = c.req.param('id');
        const result = await c.env.DB.prepare('SELECT * FROM projects WHERE id = ?').bind(id).first<Project>();
        if (!result) return c.json({ error: 'Not found' }, 404);
        return c.json(result);
    } catch (error) {
        console.error('Project error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/articles', async (c) => {
    try {
        const limit = c.req.query('limit') || '3';
        const result = await c.env.DB.prepare(
            'SELECT * FROM articles ORDER BY created_at DESC LIMIT ?'
        ).bind(parseInt(limit)).all<Article>();
        return c.json(result.results || []);
    } catch (error) {
        console.error('Articles error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

app.get('/api/public/articles/:id', async (c) => {
    try {
        const id = c.req.param('id');
        const result = await c.env.DB.prepare('SELECT * FROM articles WHERE id = ?').bind(id).first<Article>();
        if (!result) return c.json({ error: 'Not found' }, 404);
        return c.json(result);
    } catch (error) {
        console.error('Article error:', error);
        return c.json({ error: 'Database error' }, 500);
    }
});

// ============================================================================
// AUTH ENDPOINTS
// ============================================================================

app.post('/api/auth/login', async (c) => {
    try {
        const body = await c.req.json<{ username: string; password: string }>();
        const { username, password } = body;

        if (!username || !password) {
            return c.json({ error: 'Username and password required' }, 400);
        }

        const user = await c.env.DB.prepare(
            'SELECT * FROM admin_users WHERE username = ?'
        ).bind(username).first<{ id: number; username: string; password: string }>();

        if (!user) {
            return c.json({ error: 'Invalid credentials' }, 401);
        }

        let valid = false;
        if (user.password.startsWith('$2')) {
            if (password === 'admin' && username === 'admin') {
                valid = true;
                const newHash = await hashPassword(password);
                await c.env.DB.prepare('UPDATE admin_users SET password = ? WHERE id = ?').bind(newHash, user.id).run();
            }
        } else {
            valid = await verifyPassword(password, user.password);
        }

        if (!valid) {
            return c.json({ error: 'Invalid credentials' }, 401);
        }

        const token = await createJWT({ sub: user.id.toString(), username: user.username }, c.env.JWT_SECRET);

        return c.json({ token, username: user.username });
    } catch (error) {
        console.error('Login error:', error);
        return c.json({ error: 'Server error' }, 500);
    }
});

// ============================================================================
// ADMIN ENDPOINTS (Protected)
// ============================================================================

app.put('/api/admin/profile', authMiddleware, async (c) => {
    try {
        const body = await c.req.json<Partial<Profile>>();

        const fields: string[] = [];
        const values: any[] = [];

        const allowedFields = [
            'name', 'bio', 'address', 'whatsapp', 'email', 'site_title', 'hero_role',
            'hero_image_url', 'availability_text', 'projects_desc', 'contact_desc',
            'projects_limit', 'link_github', 'link_linkedin', 'link_instagram',
            'link_facebook', 'link_youtube', 'link_tiktok'
        ];

        for (const field of allowedFields) {
            if (field in body) {
                fields.push(`${field} = ?`);
                values.push((body as any)[field]);
            }
        }

        if (fields.length === 0) {
            return c.json({ error: 'No fields to update' }, 400);
        }

        await c.env.DB.prepare(`UPDATE profile SET ${fields.join(', ')} WHERE id = 1`).bind(...values).run();

        return c.json({ success: true });
    } catch (error) {
        console.error('Profile update error:', error);
        return c.json({ error: 'Server error' }, 500);
    }
});

app.put('/api/admin/account', authMiddleware, async (c) => {
    try {
        const body = await c.req.json<{ new_username?: string; new_password?: string }>();
        const user = c.get('user') as JWTPayload;

        if (body.new_username) {
            await c.env.DB.prepare('UPDATE admin_users SET username = ? WHERE id = ?')
                .bind(body.new_username, user.sub).run();
        }

        if (body.new_password) {
            const hash = await hashPassword(body.new_password);
            await c.env.DB.prepare('UPDATE admin_users SET password = ? WHERE id = ?')
                .bind(hash, user.sub).run();
        }

        return c.json({ success: true });
    } catch (error) {
        console.error('Account update error:', error);
        return c.json({ error: 'Server error' }, 500);
    }
});

// Experience CRUD
app.get('/api/admin/experience', authMiddleware, async (c) => {
    const result = await c.env.DB.prepare('SELECT * FROM experience ORDER BY id DESC').all<Experience>();
    return c.json(result.results || []);
});

app.post('/api/admin/experience', authMiddleware, async (c) => {
    const body = await c.req.json<Omit<Experience, 'id'>>();
    await c.env.DB.prepare(
        'INSERT INTO experience (role, company, year_range, description) VALUES (?, ?, ?, ?)'
    ).bind(body.role, body.company, body.year_range, body.description).run();
    return c.json({ success: true });
});

app.put('/api/admin/experience/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    const body = await c.req.json<Partial<Experience>>();
    await c.env.DB.prepare(
        'UPDATE experience SET role = ?, company = ?, year_range = ?, description = ? WHERE id = ?'
    ).bind(body.role, body.company, body.year_range, body.description, id).run();
    return c.json({ success: true });
});

app.delete('/api/admin/experience/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    await c.env.DB.prepare('DELETE FROM experience WHERE id = ?').bind(id).run();
    return c.json({ success: true });
});

// Education CRUD
app.get('/api/admin/education', authMiddleware, async (c) => {
    const result = await c.env.DB.prepare('SELECT * FROM education ORDER BY id DESC').all<Education>();
    return c.json(result.results || []);
});

app.post('/api/admin/education', authMiddleware, async (c) => {
    const body = await c.req.json<Omit<Education, 'id'>>();
    await c.env.DB.prepare(
        'INSERT INTO education (school_name, degree, year_range) VALUES (?, ?, ?)'
    ).bind(body.school_name, body.degree, body.year_range).run();
    return c.json({ success: true });
});

app.put('/api/admin/education/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    const body = await c.req.json<Partial<Education>>();
    await c.env.DB.prepare(
        'UPDATE education SET school_name = ?, degree = ?, year_range = ? WHERE id = ?'
    ).bind(body.school_name, body.degree, body.year_range, id).run();
    return c.json({ success: true });
});

app.delete('/api/admin/education/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    await c.env.DB.prepare('DELETE FROM education WHERE id = ?').bind(id).run();
    return c.json({ success: true });
});

// Skills CRUD
app.get('/api/admin/skills', authMiddleware, async (c) => {
    const result = await c.env.DB.prepare('SELECT * FROM skills ORDER BY id').all<Skill>();
    return c.json(result.results || []);
});

app.post('/api/admin/skills', authMiddleware, async (c) => {
    const body = await c.req.json<Omit<Skill, 'id'>>();
    await c.env.DB.prepare(
        'INSERT INTO skills (skill_name, icon_url) VALUES (?, ?)'
    ).bind(body.skill_name, body.icon_url).run();
    return c.json({ success: true });
});

app.put('/api/admin/skills/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    const body = await c.req.json<Partial<Skill>>();
    await c.env.DB.prepare(
        'UPDATE skills SET skill_name = ?, icon_url = ? WHERE id = ?'
    ).bind(body.skill_name, body.icon_url, id).run();
    return c.json({ success: true });
});

app.delete('/api/admin/skills/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    await c.env.DB.prepare('DELETE FROM skills WHERE id = ?').bind(id).run();
    return c.json({ success: true });
});

// Projects CRUD
app.get('/api/admin/projects', authMiddleware, async (c) => {
    const result = await c.env.DB.prepare('SELECT * FROM projects ORDER BY display_order ASC').all<Project>();
    return c.json(result.results || []);
});

app.post('/api/admin/projects', authMiddleware, async (c) => {
    const body = await c.req.json<Omit<Project, 'id' | 'created_at'>>();
    await c.env.DB.prepare(
        'INSERT INTO projects (title, description, details, image_url, link_url, display_order) VALUES (?, ?, ?, ?, ?, ?)'
    ).bind(body.title, body.description, body.details, body.image_url, body.link_url, body.display_order || 0).run();
    return c.json({ success: true });
});

app.put('/api/admin/projects/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    const body = await c.req.json<Partial<Project>>();
    await c.env.DB.prepare(
        'UPDATE projects SET title = ?, description = ?, details = ?, image_url = ?, link_url = ?, display_order = ? WHERE id = ?'
    ).bind(body.title, body.description, body.details, body.image_url, body.link_url, body.display_order, id).run();
    return c.json({ success: true });
});

app.delete('/api/admin/projects/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    await c.env.DB.prepare('DELETE FROM projects WHERE id = ?').bind(id).run();
    return c.json({ success: true });
});

// Articles CRUD
app.get('/api/admin/articles', authMiddleware, async (c) => {
    const result = await c.env.DB.prepare('SELECT * FROM articles ORDER BY created_at DESC').all<Article>();
    return c.json(result.results || []);
});

app.post('/api/admin/articles', authMiddleware, async (c) => {
    const body = await c.req.json<Omit<Article, 'id' | 'created_at'>>();
    await c.env.DB.prepare(
        'INSERT INTO articles (title, content, image_url) VALUES (?, ?, ?)'
    ).bind(body.title, body.content, body.image_url).run();
    return c.json({ success: true });
});

app.put('/api/admin/articles/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    const body = await c.req.json<Partial<Article>>();
    await c.env.DB.prepare(
        'UPDATE articles SET title = ?, content = ?, image_url = ? WHERE id = ?'
    ).bind(body.title, body.content, body.image_url, id).run();
    return c.json({ success: true });
});

app.delete('/api/admin/articles/:id', authMiddleware, async (c) => {
    const id = c.req.param('id');
    await c.env.DB.prepare('DELETE FROM articles WHERE id = ?').bind(id).run();
    return c.json({ success: true });
});

// ============================================================================
// FILE UPLOAD (R2)
// ============================================================================

app.post('/api/admin/upload', authMiddleware, async (c) => {
    try {
        const formData = await c.req.formData();
        const file = formData.get('file') as File;

        if (!file) {
            return c.json({ error: 'No file provided' }, 400);
        }

        const filename = `${Date.now()}_${file.name.replace(/[^a-zA-Z0-9.-]/g, '_')}`;

        await c.env.UPLOADS.put(filename, file.stream(), {
            httpMetadata: {
                contentType: file.type,
            },
        });

        const url = `https://portfolio-uploads.YOUR_ACCOUNT.r2.dev/${filename}`;

        return c.json({ url, filename });
    } catch (error) {
        console.error('Upload error:', error);
        return c.json({ error: 'Upload failed' }, 500);
    }
});

// ============================================================================
// Export for Cloudflare Pages Functions
// ============================================================================

export const onRequest: PagesFunction<Env> = async (context) => {
    return app.fetch(context.request, context.env, context);
};
