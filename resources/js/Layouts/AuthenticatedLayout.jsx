import { usePage, router } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import AuthenticatedSidebar from '@/Components/AuthenticatedSidebar';
import { navItems } from '@/Config/navigation';

export default function AuthenticatedLayout({ children, title }) {
    const { auth, settings, appName } = usePage().props;
    const user = auth.user;
    const userRole = user.role?.toLowerCase();
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [userMenuOpen, setUserMenuOpen] = useState(false);

    // Theme logic
    const [theme, setTheme] = useState(() => {
        if (typeof window !== 'undefined') {
            return localStorage.getItem('theme') || 'dark';
        }
        return 'dark';
    });

    // Apply theme to html element on mount and when theme changes
    useEffect(() => {
        document.documentElement.className = theme;
    }, [theme]);

    const toggleTheme = () => {
        const newTheme = theme === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
        localStorage.setItem('theme', newTheme);
    };

    const handleLogout = () => {
        router.post(route('logout'));
    };

    const isActive = (routeName) => {
        try {
            if (route().current(routeName)) {
                return true;
            }

            if (routeName.endsWith('.index')) {
                return route().current(`${routeName.replace('.index', '')}.*`);
            }

            return false;
        } catch {
            return false;
        }
    };

    const filteredNavItems = navItems.filter(item => item.roles.includes(userRole));

    const siteTitle = settings?.site_title || appName || import.meta.env.VITE_APP_NAME || 'App';
    const siteLogo = settings?.site_logo
        ? (settings.site_logo.startsWith('settings/') ? `/storage/${settings.site_logo}` : `/${settings.site_logo}`)
        : null;

    return (
        <div className={`${theme} min-h-screen bg-slate-100 dark:bg-slate-950 transition-colors duration-300`}>
            {/* Background Wrapper */}
            <div className="flex min-h-screen text-slate-900 dark:text-white">
                {/* Desktop Sidebar */}
                <div className="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:w-64 z-50">
                    <AuthenticatedSidebar
                        siteLogo={siteLogo}
                        siteTitle={siteTitle}
                        navItems={filteredNavItems}
                        isActive={isActive}
                        onNavigate={() => setSidebarOpen(false)}
                        user={user}
                        userRole={userRole}
                        userMenuOpen={userMenuOpen}
                        onUserMenuToggle={() => setUserMenuOpen(!userMenuOpen)}
                        onLogout={handleLogout}
                    />
                </div>

                {/* Mobile Sidebar Overlay */}
                {sidebarOpen && (
                    <div className="fixed inset-0 z-50 flex lg:hidden">
                        <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={() => setSidebarOpen(false)} />
                        <div className="relative z-10 animate-in slide-in-from-left duration-300">
                            <AuthenticatedSidebar
                                mobile
                                siteLogo={siteLogo}
                                siteTitle={siteTitle}
                                navItems={filteredNavItems}
                                isActive={isActive}
                                onNavigate={() => setSidebarOpen(false)}
                                user={user}
                                userRole={userRole}
                                userMenuOpen={userMenuOpen}
                                onUserMenuToggle={() => setUserMenuOpen(!userMenuOpen)}
                                onLogout={handleLogout}
                            />
                        </div>
                    </div>
                )}

                {/* Main content */}
                <div className="flex-1 lg:pl-64 flex flex-col min-h-screen w-full max-w-full overflow-x-hidden min-w-0">
                    {/* Top bar */}
                    <header className="sticky top-0 z-40 bg-white/80 dark:bg-slate-950/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 lg:px-8 h-16 flex items-center justify-between transition-colors duration-300">
                        <div className="flex items-center gap-3">
                            <button
                                onClick={() => setSidebarOpen(true)}
                                className="lg:hidden p-2 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                            {title && (
                                <h1 className="text-lg font-bold text-slate-800 dark:text-white tracking-tight">
                                    {title}
                                </h1>
                            )}
                        </div>

                        <div className="flex items-center gap-4">
                            {/* Theme Toggle Button */}
                            <button
                                onClick={toggleTheme}
                                className="p-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 hover:text-[#228260] dark:hover:text-[#32BA83] hover:border-[#228260]/30 dark:hover:border-[#32BA83]/40 transition-all duration-200 shadow-sm"
                                title={theme === 'dark' ? 'Tukar ke Mod Terang' : 'Tukar ke Mod Gelap'}
                            >
                                {theme === 'dark' ? (
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591 1.591M12 18.75a6.75 6.75 0 1 1 0-13.5 6.75 6.75 0 0 1 0 13.5Z" />
                                    </svg>
                                ) : (
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                    </svg>
                                )}
                            </button>

                            <div className="hidden sm:block text-xs text-slate-500 dark:text-slate-400 font-semibold uppercase tracking-wider">
                                {new Date().toLocaleDateString('ms-MY', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' })}
                            </div>
                        </div>
                    </header>

                    {/* Page Content */}
                    <main className="flex-1 p-4 lg:p-8">
                        <div className="w-full">
                            {children}
                        </div>
                    </main>
                </div>
            </div>
        </div>
    );
}
