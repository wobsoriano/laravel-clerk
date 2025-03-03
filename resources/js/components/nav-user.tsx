import { SidebarMenu, SidebarMenuItem, useSidebar } from '@/components/ui/sidebar';
import { useIsMobile } from '@/hooks/use-mobile';
import { type SharedData } from '@/types';
import { usePage } from '@inertiajs/react';
import { UserButton } from '@clerk/clerk-react';

export function NavUser() {
    const { auth } = usePage<SharedData>().props;
    const { state } = useSidebar();
    const isMobile = useIsMobile();

    return (
        <SidebarMenu>
            <SidebarMenuItem>
                <UserButton showName userProfileUrl={route('settings.profile')} appearance={{
                    elements: {
                        "userButtonBox": "flex flex-row-reverse!"
                    }
                }} />
            </SidebarMenuItem>
        </SidebarMenu>
    );
}
