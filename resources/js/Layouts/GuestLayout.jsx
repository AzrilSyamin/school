import { useState, useEffect } from 'react';
import { usePage } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    const { settings, appName } = usePage().props;
    const [theme, setTheme] = useState(() => {
        if (typeof window !== 'undefined') {
            return localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        }
        return 'light';
    });

    useEffect(() => {
        document.documentElement.className = theme;
        localStorage.setItem('theme', theme);
    }, [theme]);

    const toggleTheme = () => {
        setTheme(prev => prev === 'dark' ? 'light' : 'dark');
    };

    const siteTitle = settings?.site_title || appName || import.meta.env.VITE_APP_NAME || 'App';
    const siteLogo = settings?.site_logo
        ? (settings.site_logo.startsWith('settings/') ? `/storage/${settings.site_logo}` : `/${settings.site_logo}`)
        : null;

    return (
        <div className="min-h-screen flex flex-col lg:flex-row selection:bg-emerald-500/30 selection:text-emerald-100 font-sans antialiased bg-white dark:bg-slate-950 transition-colors duration-300">
            {/* Left Panel - Branding (Standard Modern Style) */}
            <div className="hidden lg:flex lg:w-[40%] xl:w-[35%] relative overflow-hidden bg-slate-900 dark:bg-slate-900 flex-col p-12 text-white border-r border-slate-200 dark:border-slate-800">
                {/* Subtle Grid Pattern */}
                <div
                    className="absolute inset-0 opacity-[0.05]"
                    style={{
                        backgroundImage: `radial-gradient(circle at 2px 2px, white 1px, transparent 0)`,
                        backgroundSize: '24px 24px',
                    }}
                />

                <div className="relative z-10 h-full flex flex-col">
                    {/* Logo */}
                    <div className="flex items-center gap-3 mb-16">
                        {siteLogo ? (
                            <img src={siteLogo} alt={siteTitle} className="h-10 w-auto" />
                        ) : (
                            <div className="w-10 h-10 rounded-xl bg-[#228260] dark:bg-[#32BA83] flex items-center justify-center shadow-lg shadow-emerald-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                </svg>
                            </div>
                        )}
                        <span className="font-black text-xl tracking-tight uppercase">{siteTitle}</span>
                    </div>

                    <div className="mt-auto">
                        <h1 className="text-4xl font-black mb-6 leading-[1.1] tracking-tight">
                            {siteTitle} <br />
                            <span className="text-[#32BA83]">Masa Hadapan.</span>
                        </h1>
                        <p className="text-slate-400 text-lg font-medium leading-relaxed max-w-sm mb-12">
                            Platform integrasi untuk urusan akademik, kehadiran dan pentadbiran sekolah secara digital.
                        </p>

                        <div className="space-y-6">
                            {[
                                "Akses Pantas & Efisien",
                                "Rekod Kehadiran Automatik",
                                "Sekuriti Data Terjamin"
                            ].map((text) => (
                                <div key={text} className="flex items-center gap-3">
                                    <div className="w-5 h-5 rounded-full bg-emerald-500/20 flex items-center justify-center border border-emerald-500/30">
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-3 w-3 text-[#32BA83]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={3}>
                                            <path strokeLinecap="round" strokeLinejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    </div>
                                    <span className="text-slate-300 font-bold text-sm uppercase tracking-wider">{text}</span>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="mt-auto pt-12 text-slate-500 text-xs font-bold uppercase tracking-widest">
                        &copy; {new Date().getFullYear()} {siteTitle.toUpperCase()}
                    </div>
                </div>
            </div>

            {/* Right Panel - Content */}
            <div className="flex-1 flex flex-col justify-center items-center p-8 sm:p-12 lg:p-20 relative overflow-y-auto">
                {/* Theme Toggle (Absolute) */}
                <div className="absolute top-6 right-6 lg:top-10 lg:right-10">
                    <button
                        onClick={toggleTheme}
                        className="p-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-200 shadow-sm"
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
                </div>

                <div className="w-full max-w-[440px]">
                    {/* Mobile Logo */}
                    <div className="lg:hidden flex items-center gap-3 mb-12 justify-center">
                        {siteLogo ? (
                            <img src={siteLogo} alt={siteTitle} className="h-10 w-auto" />
                        ) : (
                            <div className="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                </svg>
                            </div>
                        )}
                        <span className="font-black text-2xl tracking-tight uppercase text-slate-900 dark:text-white">{siteTitle}</span>
                    </div>

                    <div className="relative">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
}
