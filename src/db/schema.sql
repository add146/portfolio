-- D1 Schema for Portfolio
-- SQLite compatible

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL
);

-- Profile table (single row, id=1)
CREATE TABLE IF NOT EXISTS profile (
  id INTEGER PRIMARY KEY,
  name TEXT,
  bio TEXT,
  address TEXT,
  whatsapp TEXT,
  email TEXT,
  site_title TEXT DEFAULT 'MY.PORTFOLIO',
  hero_role TEXT DEFAULT 'Creative Dev.',
  hero_image_url TEXT,
  availability_text TEXT DEFAULT 'AVAILABLE FOR WORK',
  projects_desc TEXT,
  contact_desc TEXT,
  projects_limit INTEGER DEFAULT 6,
  link_github TEXT,
  link_linkedin TEXT,
  link_instagram TEXT,
  link_facebook TEXT,
  link_youtube TEXT,
  link_tiktok TEXT
);

-- Articles/Blog table
CREATE TABLE IF NOT EXISTS articles (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  content TEXT NOT NULL,
  image_url TEXT,
  created_at TEXT DEFAULT (datetime('now'))
);

-- Education table
CREATE TABLE IF NOT EXISTS education (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  school_name TEXT,
  degree TEXT,
  year_range TEXT
);

-- Experience table
CREATE TABLE IF NOT EXISTS experience (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  role TEXT,
  company TEXT,
  year_range TEXT,
  description TEXT
);

-- Projects table
CREATE TABLE IF NOT EXISTS projects (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  title TEXT NOT NULL,
  description TEXT,
  image_url TEXT,
  link_url TEXT,
  created_at TEXT DEFAULT (datetime('now')),
  details TEXT,
  display_order INTEGER DEFAULT 0
);

-- Skills table
CREATE TABLE IF NOT EXISTS skills (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  skill_name TEXT,
  icon_url TEXT
);
