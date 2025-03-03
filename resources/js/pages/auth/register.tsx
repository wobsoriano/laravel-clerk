import { Head } from '@inertiajs/react';
import AuthLayout from '@/layouts/auth-layout';
import { SignUp } from '@clerk/clerk-react';

export default function Page() {
    return (
        <AuthLayout title="Create an account" description="Enter your details below to create your account">
            <Head title="Register" />
            <SignUp routing="hash" />
        </AuthLayout>
    );
}
