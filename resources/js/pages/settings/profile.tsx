import { SharedData, type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { UserProfile as ClerkUserProfile, UserProfile } from "@clerk/clerk-react"

import AppLayout from '@/layouts/app-layout';
import SettingsLayout from '@/layouts/settings/layout';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile settings',
        href: '/settings/profile',
    },
];

const DotIcon = () => {
    return (
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
        <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z" />
      </svg>
    )
}


const CustomPage = () => {
    const { user } = usePage<{ user: { id: string; email: string } }>().props;

    return (
      <div>
        <h1>Custom page</h1>
        <p>{ JSON.stringify(user) }</p>
      </div>
    )
  }
  

export default function Profile() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <ClerkUserProfile>
                        <UserProfile.Page label="Custom Page" labelIcon={<DotIcon />} url="custom-page">
                            <CustomPage />
                        </UserProfile.Page>
                    </ClerkUserProfile>
                </div>

            </SettingsLayout>
        </AppLayout>
    );
}
