import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

const statCards = [
    {
        key: 'total_users',
        label: 'Jumlah Pengguna',
        href: '/users',
        color: 'from-indigo-500 to-blue-600',
        glow: 'shadow-indigo-500/20',
        bg: 'bg-indigo-500/10 border-indigo-500/20',
        iconColor: 'text-indigo-500 dark:text-indigo-400',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
        ),
    },
    {
        key: 'lecturers',
        label: 'Jumlah Pensyarah',
        href: '/lecturers',
        color: 'from-blue-500 to-cyan-600',
        glow: 'shadow-blue-500/20',
        bg: 'bg-blue-500/10 border-blue-500/20',
        iconColor: 'text-blue-400',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
            </svg>
        ),
    },
    {
        key: 'students',
        label: 'Jumlah Pelajar',
        href: '/students',
        color: 'from-emerald-500 to-teal-600',
        glow: 'shadow-emerald-500/20',
        bg: 'bg-emerald-500/10 border-emerald-500/20',
        iconColor: 'text-emerald-400',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        ),
    },
    {
        key: 'courses',
        label: 'Jumlah Kursus',
        href: '/courses',
        color: 'from-fuchsia-500 to-purple-600',
        glow: 'shadow-fuchsia-500/20',
        bg: 'bg-fuchsia-500/10 border-fuchsia-500/20',
        iconColor: 'text-fuchsia-400',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        ),
    },
];

export default function Dashboard({ stats, recentStudents }) {
    const { auth } = usePage().props;
    const userRole = auth.user.role;
    const canSeeStudents = !['student'].includes(userRole);

    return (
        <AuthenticatedLayout title="Dashboard">
            <Head title="Dashboard" />

            <div className="space-y-10 animate-in fade-in duration-700">
                {/* Page Header */}
                <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                            Hi, {auth.user.first_name || 'Pengguna'}! 👋
                        </h1>
                        <p className="mt-2 text-slate-500 dark:text-slate-400 font-medium">
                            Selamat kembali, <span className="text-blue-500 dark:text-blue-400 font-bold">@{auth.user.username}</span>. Berikut adalah ringkasan sistem kolej anda.
                        </p>
                    </div>
                </div>

                {/* Stat Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-wrap lg:justify-start gap-6">
                    {statCards.map((card) => (
                        <Link
                            key={card.key}
                            href={card.href}
                            className={`group relative overflow-hidden rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 transition-all duration-300 hover:scale-[1.03] hover:shadow-2xl hover:shadow-blue-500/10 dark:hover:shadow-blue-900/20 shadow-sm w-full lg:min-w-[270px] lg:max-w-[300px] flex-1`}
                        >
                            {/* Persistent Subtle Background Gradient - Much more visible */}
                            <div className={`absolute inset-0 bg-gradient-to-br ${card.color} opacity-[0.15] dark:opacity-[0.25]`} />
                            
                            {/* Hover Inner Gradient - Bold */}
                            <div className={`absolute inset-0 bg-gradient-to-br ${card.color} opacity-0 group-hover:opacity-[0.4] transition-opacity duration-500`} />
                            
                            <div className="flex items-start justify-between relative z-10">
                                <div>
                                    <p className="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-[0.2em]">{card.label}</p>
                                    <p className="mt-3 text-4xl font-black text-slate-900 dark:text-white tracking-tight">{stats?.[card.key] ?? 0}</p>
                                </div>
                                <div className={`p-4 rounded-2xl bg-white/90 dark:bg-slate-800/90 backdrop-blur-md ${card.iconColor} shadow-md group-hover:bg-white group-hover:text-blue-600 transition-all duration-500`}>
                                    {card.icon}
                                </div>
                            </div>
                            <div className="mt-6 flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-900 dark:text-white opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 relative z-10">
                                <span>Lihat Butiran</span>
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={3}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                            {/* Decorative background element */}
                            <div className={`absolute -bottom-10 -right-10 w-32 h-32 rounded-full bg-gradient-to-br ${card.color} opacity-[0.3] group-hover:opacity-[0.6] transition-opacity blur-3xl`} />
                        </Link>
                    ))}
                </div>

                {/* Recent Students Table */}
                {canSeeStudents && (
                    <div className="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-sm">
                        <div className="flex flex-col sm:flex-row sm:items-center justify-between px-5 sm:px-8 py-6 sm:py-7 border-b border-slate-100 dark:border-slate-800 gap-4 bg-white/50 dark:bg-slate-900/50 backdrop-blur-xl">
                            <div>
                                <h2 className="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pelajar Terbaru</h2>
                                <p className="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 font-medium">Rekod pendaftaran pelajar yang paling terkini.</p>
                            </div>
                            <Link
                                href="/students"
                                className="inline-flex items-center justify-center gap-2 px-5 py-2.5 sm:px-6 sm:py-3 rounded-2xl bg-slate-900 dark:bg-blue-600 hover:bg-slate-800 dark:hover:bg-blue-700 text-[10px] sm:text-xs font-black uppercase tracking-widest text-white transition-all shadow-lg shadow-slate-900/10 dark:shadow-blue-600/20 active:scale-95"
                            >
                                Lihat Semua
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </Link>
                        </div>

                        <div className="overflow-x-auto custom-scrollbar">
                            {recentStudents && recentStudents.length > 0 ? (
                                <table className="w-full text-sm text-left min-w-[800px]">
                                    <thead>
                                        <tr className="bg-slate-50/50 dark:bg-slate-800/30">
                                            <th className="px-5 sm:px-8 py-5 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Nama Pelajar</th>
                                            <th className="px-5 sm:px-8 py-5 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Umur</th>
                                            <th className="px-5 sm:px-8 py-5 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] text-center">Jantina</th>
                                            <th className="px-5 sm:px-8 py-5 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Kelas & Kursus</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
                                        {recentStudents.map((student) => (
                                            <tr key={student.id} className="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors group">
                                                <td className="px-5 sm:px-8 py-5 whitespace-nowrap">
                                                    <div className="flex items-center gap-4">
                                                        <div className="w-10 h-10 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-black shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                                            {student.name ? student.name[0].toUpperCase() : '?'}
                                                        </div>
                                                        <span className="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{student.name}</span>
                                                    </div>
                                                </td>
                                                <td className="px-5 sm:px-8 py-5 text-slate-500 dark:text-slate-400 font-bold">{student.age ?? '—'}</td>
                                                <td className="px-5 sm:px-8 py-5 text-center">
                                                    {student.gender ? (
                                                        <span className={`inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border ${student.gender === 'Lelaki' ? 'bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20' : 'bg-pink-50 text-pink-700 border-pink-100 dark:bg-pink-500/10 dark:text-pink-400 dark:border-pink-500/20'}`}>
                                                            {student.gender}
                                                        </span>
                                                    ) : <span className="text-slate-300 dark:text-slate-600 font-bold tracking-widest">—</span>}
                                                </td>
                                                <td className="px-5 sm:px-8 py-5">
                                                    <div className="flex flex-col gap-1">
                                                        <span className="font-black text-slate-800 dark:text-slate-200 tracking-tight">{student.classroom?.name || '—'}</span>
                                                        <span className="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-[0.1em]">{student.classroom?.course?.name || '—'}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            ) : (
                                <div className="flex flex-col items-center justify-center py-24 text-center">
                                    <div className="w-20 h-20 rounded-[2.5rem] bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-6 shadow-inner rotate-3 group-hover:rotate-0 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-10 w-10 text-slate-200 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <h3 className="text-slate-900 dark:text-white font-black text-xl tracking-tight">Tiada Pelajar</h3>
                                    <p className="text-slate-500 dark:text-slate-400 text-sm mt-2 max-w-xs mx-auto font-medium leading-relaxed">Sila tambah pelajar baru untuk mula memantau prestasi kolej anda secara digital.</p>
                                </div>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
