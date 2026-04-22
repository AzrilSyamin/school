import { usePage } from '@inertiajs/react';

export default function AuthFooter() {
    const { settings, appName } = usePage().props;
    const siteTitle = settings?.site_title || appName || import.meta.env.VITE_APP_NAME || 'App';

    return (
        <div className="mt-12 pt-8 border-t border-slate-100 dark:border-slate-900 text-center">
            <p className="text-[10px] text-slate-400 dark:text-slate-600 font-black uppercase tracking-[0.3em]">
                &copy; {new Date().getFullYear()} {siteTitle} &bull; V2.0
            </p>
        </div>
    );
}
