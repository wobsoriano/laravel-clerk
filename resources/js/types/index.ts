import { LucideIcon } from 'lucide-react';

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavGroup {
    title: string;
    items: NavItem[];
}

export interface NavItem {
    title: string;
    url: string;
    icon?: LucideIcon | null;
    isActive?: boolean;
}

export interface SharedData {
    name: string;
    quote: { message: string; author: string };
    user: User;
    [key: string]: unknown;
}

export interface User {
    id: string;
    firstName: string;
    lastName: string;
    username: string;
    profileImageUrl: string;
    emailAddresses: Array<{
      emailAddress: string;
      verification: {
        status: string;
      }
    }>;
    lastSignInAt: number;
    lastActiveAt: number;
}
