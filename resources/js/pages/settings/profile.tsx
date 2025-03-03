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

const ProfilePage = () => {
  const { user } = usePage<SharedData>().props;
  
  const formatDate = (timestamp: number) => {
    return new Date(timestamp).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit'
    });
  };

  return (
    <div>
      <h1>Profile Information</h1>
      <ul>
        <li>Name: {user.firstName} {user.lastName}</li>
        <li>Username: @{user.username}</li>
        <li>
          Emails:
          <ul>
            {user.emailAddresses.map((email, index) => (
              <li key={index}>
                {email.emailAddress} ({email.verification.status})
              </li>
            ))}
          </ul>
        </li>
        <li>Last Sign In: {formatDate(user.lastSignInAt)}</li>
        <li>Last Active: {formatDate(user.lastActiveAt)}</li>
      </ul>
    </div>
  );
};

export default function Profile() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile settings" />

            <SettingsLayout>
                <div className="space-y-6">
                    <ClerkUserProfile>
                        <UserProfile.Page label="Custom Page" labelIcon={<DotIcon />} url="custom-page">
                            <ProfilePage />
                        </UserProfile.Page>
                    </ClerkUserProfile>
                </div>

            </SettingsLayout>
        </AppLayout>
    );
}
