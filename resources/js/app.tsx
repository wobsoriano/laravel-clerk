import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { route as routeFn } from 'ziggy-js';
import { initializeTheme } from './hooks/use-appearance';
import { ClerkProvider } from '@clerk/clerk-react';
import { dark } from '@clerk/themes';

declare global {
    const route: typeof routeFn;
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx')),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(
            <ClerkProvider
                publishableKey={import.meta.env.VITE_CLERK_PUBLISHABLE_KEY}
                afterSignOutUrl="/sign-in"
                signInFallbackRedirectUrl="/"
                signUpFallbackRedirectUrl="/"
                signInUrl="/sign-in"
                signUpUrl="/sign-up"
                appearance={{ baseTheme: dark }}
                // @ts-expect-error Add type
                initialState={props.initialPage.props.initialState}
            >
                <App {...props} />
            </ClerkProvider>
        );
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on load...
initializeTheme();
