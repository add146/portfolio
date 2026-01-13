// TypeScript types for Portfolio API

export interface Env {
    DB: D1Database;
    UPLOADS: R2Bucket;
    JWT_SECRET: string;
}

export interface AdminUser {
    id: number;
    username: string;
    password: string;
}

export interface Profile {
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

export interface Article {
    id: number;
    title: string;
    content: string;
    image_url: string | null;
    created_at: string;
}

export interface Education {
    id: number;
    school_name: string | null;
    degree: string | null;
    year_range: string | null;
}

export interface Experience {
    id: number;
    role: string | null;
    company: string | null;
    year_range: string | null;
    description: string | null;
}

export interface Project {
    id: number;
    title: string;
    description: string | null;
    image_url: string | null;
    link_url: string | null;
    created_at: string;
    details: string | null;
    display_order: number;
}

export interface Skill {
    id: number;
    skill_name: string | null;
    icon_url: string | null;
}

export interface JWTPayload {
    sub: string;
    username: string;
    exp: number;
    iat: number;
}
