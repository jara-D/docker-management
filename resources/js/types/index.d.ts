import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> =
    T & {
        name: string;
        auth: Auth;
        sidebarOpen: boolean;
        containers: Array<{
            id: number;
            container_id: string;
            name: string;
            status: string;
        }>;
        projects: Array<{
            id: number;
            name: string;
            state: string;
        }>;
        project: {
            id: number;
            name: string;
            state: string;
            containers: Array<{
                id: number;
                state: string;
                name: string;
            }>
        }
    };

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
