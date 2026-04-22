import { router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export default function SearchInput({ routeName, placeholder = "Cari...", initialValue = "" }) {
    const [search, setSearch] = useState(initialValue);

    useEffect(() => {
        const timeoutId = setTimeout(() => {
            if (search !== initialValue) {
                router.get(route(routeName), { search }, {
                    preserveState: true,
                    replace: true,
                });
            }
        }, 500);
        return () => clearTimeout(timeoutId);
    }, [search]);

    return (
        <div className="relative w-full">
            <div className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" className="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <input
                type="text"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                placeholder={placeholder}
                className="w-full rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 py-2.5 pl-11 pr-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none transition-all duration-300 focus:border-[#228260] dark:focus:border-[#32BA83] focus:ring-4 focus:ring-emerald-500/10"
            />
        </div>
    );
}
