import { Link } from '@inertiajs/react';

export default function AuthenticatedSidebar({
    mobile = false,
    siteLogo,
    siteTitle,
    navItems,
    isActive,
    onNavigate,
    user,
    userRole,
    userMenuOpen,
    onUserMenuToggle,
    onLogout,
}) {
    return (
        <div className={`flex flex-col h-full bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 ${mobile ? 'w-72' : 'w-64'} transition-all duration-300`}>
            <div className="flex flex-col items-center gap-3 px-6 py-6 border-b border-slate-100 dark:border-slate-800 text-center">
                {siteLogo ? (
                    <img src={siteLogo} alt={siteTitle} className="h-16 max-w-[9rem] object-contain" />
                ) : (
                    <div className="w-16 h-16 rounded-3xl bg-gradient-to-br from-[#228260] to-[#32BA83] flex items-center justify-center shrink-0 shadow-lg shadow-emerald-600/25">
                        <svg xmlns="http://www.w3.org/2000/svg" className="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                )}
                <div className="min-w-0 w-full">
                    <p className="text-slate-900 dark:text-white font-extrabold text-base tracking-tight leading-tight truncate uppercase">{siteTitle}</p>
                </div>
            </div>

            <nav className="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto custom-scrollbar">
                <p className="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-3 mb-4">Utama</p>
                {navItems.map((item) => {
                    const active = isActive(item.routeName);

                    return (
                        <Link
                            key={item.href}
                            href={item.href}
                            onClick={onNavigate}
                            className={`flex items-center gap-3 px-4 py-3 border-b border-slate-200 dark:border-slate-700/80 text-sm font-semibold transition-all duration-200 group ${
                                active
                                    ? 'rounded-2xl bg-[#228260] dark:bg-[#32BA83] text-white dark:text-slate-950 shadow-lg shadow-emerald-600/20 border-b-[#1b6a4e] dark:border-b-[#32BA83]'
                                    : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white'
                            }`}
                        >
                            <span className={`transition-colors ${active ? 'text-white' : 'text-slate-400 dark:text-slate-500 group-hover:text-slate-900 dark:group-hover:text-slate-300'}`}>
                                {item.icon}
                            </span>
                            {item.label}
                        </Link>
                    );
                })}
            </nav>

            <div className="p-4 border-t border-slate-100 dark:border-slate-800">
                <div className="relative">
                    <button
                        onClick={onUserMenuToggle}
                        className="w-full flex items-center gap-3 p-3 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-200 group border border-transparent hover:border-slate-100 dark:hover:border-slate-800"
                    >
                        <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center text-slate-700 dark:text-white text-xs font-bold shrink-0 overflow-hidden shadow-inner border border-slate-200 dark:border-slate-700">
                            {user.picture ? (
                                <img
                                    src={user.picture === 'default.jpg' || user.picture.startsWith('images/')
                                        ? `/${user.picture === 'default.jpg' ? 'images/default.jpg' : user.picture}`
                                        : `/storage/${user.picture}`}
                                    alt=""
                                    className="w-full h-full object-cover"
                                />
                            ) : (
                                (user.first_name || user.email || '?')[0].toUpperCase()
                            )}
                        </div>
                        <div className="flex-1 text-left min-w-0">
                            <p className="text-sm font-bold text-slate-900 dark:text-white truncate">
                                {user.first_name ? `${user.first_name} ${user.last_name ?? ''}`.trim() : user.email}
                            </p>
                            <p className="text-[10px] text-slate-500 dark:text-slate-500 truncate font-bold uppercase tracking-wider">{userRole}</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" className={`h-4 w-4 text-slate-400 transition-transform duration-300 ${userMenuOpen ? 'rotate-180' : ''}`} fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                    {userMenuOpen && (
                        <div className="absolute bottom-full left-0 right-0 mb-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-300 z-50">
                            <div className="p-2 border-b border-slate-100 dark:border-slate-700">
                                <Link href={route('profile.edit')} className="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-slate-700/50 hover:text-[#228260] dark:hover:text-[#32BA83] rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    Profil Saya
                                </Link>
                            </div>
                            <div className="p-2">
                                <button onClick={onLogout} className="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Log Keluar
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
