import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/react';
import { UserProfile as ClerkUserProfile } from "@clerk/clerk-react"

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

export default function Profile() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <ClerkUserProfile />
                </div>

            </SettingsLayout>
        </AppLayout>
    );
}
