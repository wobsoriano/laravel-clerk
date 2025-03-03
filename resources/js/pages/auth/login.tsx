import { Head, useForm } from '@inertiajs/react';
import AuthLayout from '@/layouts/auth-layout';
import { SignIn } from '@clerk/clerk-react';


export default function Page() {
    return (
        <AuthLayout title="Log in to your account" description="Enter your email and password below to log in">
            <Head title="Sign Up" />
            <SignIn routing="hash" />
        </AuthLayout>
    );
}
