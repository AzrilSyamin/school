import { Head, Link } from '@inertiajs/react';

const features = [
    {
        title: 'Sistem Kehadiran',
        desc: 'Rekod kehadiran harian oleh Ketua Kelas atau Guru. Pengurus kursus mempunyai kawalan penuh terhadap semua rekod.',
        color: 'from-[#228260] to-[#32BA83]',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25h3.502a2.251 2.251 0 0 1 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.091 1.976 1.054 1.976 2.189V20.25a2.25 2.25 0 0 1-2.25 2.25h-10.5a2.25 2.25 0 0 1-2.25-2.25V6.108c0-1.135.845-2.098 1.976-2.189.373-.03.748-.057 1.123-.08M15.75 18H9m6.75-4.5H9m6.75-4.5H9" />
            </svg>
        ),
    },
    {
        title: 'Pengurus Kursus',
        desc: 'Lantik pensyarah sebagai pengurus kursus untuk mengawal selia kelas, subjek, dan pelajar di bawah jagaannya.',
        color: 'from-emerald-500 to-teal-600',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.436 60.436 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.905 59.905 0 0 1 12 3.493a59.902 59.902 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
            </svg>
        ),
    },
    {
        title: 'Rekod Pelajar',
        desc: 'Sistem pendaftaran pelajar yang lengkap dengan Student ID unik dan penempatan kelas secara automatik.',
        color: 'from-violet-500 to-purple-600',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.25c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
            </svg>
        ),
    },
    {
        title: 'Kawalan Akses (RBAC)',
        desc: 'Sistem 5-peringkat: Admin, Moderator, Pensyarah (Manager/Teacher), Pelajar & Ketua Kelas.',
        color: 'from-amber-500 to-orange-600',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
            </svg>
        ),
    },
    {
        title: 'Carian Pintar',
        desc: 'Cari maklumat pensyarah, pelajar, atau subjek menggunakan nama penuh dengan respons yang pantas.',
        color: 'from-[#228260] to-[#32BA83]',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        ),
    },
    {
        title: 'Sumber Terbuka',
        desc: 'Projek open-source berlesen MIT. Dibina dengan Laravel 12 & React 18 untuk institusi pendidikan Malaysia.',
        color: 'from-rose-500 to-pink-600',
        icon: (
            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                <path strokeLinecap="round" strokeLinejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
            </svg>
        ),
    },
];

const roles = [
    { name: 'Admin', desc: 'Akses penuh kepada semua fungsi sistem.', bg: 'bg-red-500/10 border-red-500/20 text-red-400' },
    { name: 'Moderator', desc: 'Uruskan pengguna, pensyarah & pelajar.', bg: 'bg-orange-500/10 border-orange-500/20 text-orange-400' },
    { name: 'Pensyarah', desc: 'Pengurus kursus & pengajar subjek.', bg: 'bg-emerald-500/10 border-emerald-500/20 text-[#32BA83]' },
    { name: 'Pelajar', desc: 'Akses terhad, lihat dashboard sahaja.', bg: 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' },
    { name: 'Ketua Kelas', desc: 'Merekod kehadiran untuk bilik darjah.', bg: 'bg-violet-500/10 border-violet-500/20 text-violet-400' },
];

export default function Home({ auth, laravelVersion, phpVersion }) {
    return (
        <div className="min-h-screen bg-[#0a0f1e] text-slate-200 font-sans">
            <Head title="EduFlow — Sistem Pengurusan Sekolah" />

            {/* Ambient background */}
            <div className="fixed inset-0 pointer-events-none overflow-hidden">
                <div className="absolute top-0 left-1/4 w-96 h-96 bg-emerald-600/10 rounded-full blur-[100px]" />
                <div className="absolute bottom-1/3 right-1/4 w-96 h-96 bg-teal-600/8 rounded-full blur-[100px]" />
                <div className="absolute top-1/2 left-0 w-64 h-64 bg-emerald-500/6 rounded-full blur-[80px]" />
            </div>

            {/* Navbar */}
            <nav className="relative z-50 border-b border-white/5 bg-[#0a0f1e]/80 backdrop-blur-xl sticky top-0">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-[#228260] to-[#32BA83] flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-slate-900 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <div>
                            <span className="text-base font-bold text-slate-900 dark:text-white">EduFlow</span>
                            <span className="hidden sm:inline text-xs text-slate-500 ml-2">Sistem Pengurusan Sekolah</span>
                        </div>
                    </div>
                    <div className="flex items-center gap-3">
                        {auth.user ? (
                            <Link href={route('dashboard')} className="px-4 py-2 rounded-xl bg-[#228260] hover:bg-[#1b6b4f] dark:bg-[#32BA83] dark:hover:bg-[#43c892] text-sm font-semibold text-white dark:text-slate-950 transition-colors shadow-lg shadow-emerald-500/20">
                                Pergi ke Dashboard →
                            </Link>
                        ) : (
                            <>
                                <Link href={route('login')} className="px-4 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white transition-colors">
                                    Log Masuk
                                </Link>
                                <Link href={route('register')} className="px-4 py-2 rounded-xl bg-[#228260] hover:bg-[#1b6b4f] dark:bg-[#32BA83] dark:hover:bg-[#43c892] text-sm font-semibold text-white dark:text-slate-950 transition-colors shadow-lg shadow-emerald-500/20">
                                    Daftar Akaun
                                </Link>
                            </>
                        )}
                    </div>
                </div>
            </nav>

            {/* Hero */}
            <section className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-20 text-center">
                <div className="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[#32BA83] text-xs font-semibold tracking-wider uppercase mb-8">
                    <span className="w-1.5 h-1.5 rounded-full bg-[#32BA83] animate-pulse" />
                    Open Source · MIT License
                </div>

                <h1 className="text-4xl sm:text-6xl lg:text-7xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-[1.08] mb-6">
                    Sistem Pengurusan<br />
                    <span className="bg-clip-text text-transparent bg-gradient-to-r from-[#228260] to-[#32BA83]">
                        Sekolah Moden
                    </span>
                </h1>

                <p className="text-lg sm:text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed mb-10">
                    Platform pengurusan pendidikan yang lengkap — dari rekod pelajar dan guru, pengurusan kelas, sehingga kawalan akses berbilang peranan. Sesuai untuk sekolah rendah dan menengah.
                </p>

                <div className="flex flex-wrap items-center justify-center gap-4">
                    <Link href={route('register')} className="px-7 py-3.5 rounded-2xl bg-[#228260] hover:bg-[#1b6b4f] dark:bg-[#32BA83] dark:hover:bg-[#43c892] text-base font-bold text-white dark:text-slate-950 transition-all shadow-xl shadow-emerald-500/20 flex items-center gap-2 group">
                        Mulakan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </Link>
                    <a href="https://github.com/AzrilSyamin/school" target="_blank" rel="noreferrer" className="px-7 py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 hover:border-slate-500 text-base font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:text-white transition-all flex items-center gap-2">
                        <svg className="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fillRule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clipRule="evenodd" />
                        </svg>
                        GitHub
                    </a>
                </div>

                {/* Stats row */}
                <div className="mt-16 grid grid-cols-3 sm:grid-cols-3 gap-4 max-w-md mx-auto">
                    {[
                        { val: '5', label: 'Peranan Pengguna' },
                        { val: '47', label: 'Unit Tests' },
                        { val: 'MIT', label: 'Lesen' },
                    ].map((s, i) => (
                        <div key={i} className="py-4 rounded-2xl bg-white/3 border border-white/8 text-center">
                            <div className="text-2xl font-extrabold text-slate-900 dark:text-white">{s.val}</div>
                            <div className="text-xs text-slate-500 mt-0.5">{s.label}</div>
                        </div>
                    ))}
                </div>
            </section>

            {/* Role pills */}
            <section className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <p className="text-center text-xs text-slate-500 font-semibold tracking-widest uppercase mb-5">5 Peringkat Kawalan Akses</p>
                <div className="flex flex-wrap justify-center gap-3">
                    {roles.map((r) => (
                        <div key={r.name} className={`flex items-center gap-2.5 px-4 py-2.5 rounded-xl border text-sm font-semibold ${r.bg}`}>
                            <span>{r.name}</span>
                            <span className="text-xs font-normal opacity-70 hidden sm:inline">— {r.desc}</span>
                        </div>
                    ))}
                </div>
            </section>

            {/* Features grid */}
            <section id="features" className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div className="text-center mb-14">
                    <p className="text-[#32BA83] text-xs font-bold tracking-widest uppercase mb-3">Fungsi Utama</p>
                    <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white">Semua yang anda perlukan, dalam satu platform.</h2>
                </div>
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    {features.map((f, i) => (
                        <div key={i} className="group p-6 rounded-2xl bg-white/3 border border-white/8 hover:border-white/15 hover:bg-white/5 transition-all duration-300">
                            <div className={`w-11 h-11 rounded-xl bg-gradient-to-br ${f.color} flex items-center justify-center text-slate-900 dark:text-white mb-4 shadow-lg`}>
                                {f.icon}
                            </div>
                            <h3 className="text-base font-bold text-slate-900 dark:text-white mb-2">{f.title}</h3>
                            <p className="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{f.desc}</p>
                        </div>
                    ))}
                </div>
            </section>

            {/* Tech stack strip */}
            <section className="relative z-10 border-y border-white/5 bg-white/2 py-8">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 flex flex-wrap items-center justify-center gap-x-10 gap-y-3">
                    <span className="text-xs text-slate-400 dark:text-slate-600 font-semibold uppercase tracking-widest">Dibina dengan</span>
                    {['Laravel 12', 'React 18', 'Inertia.js', 'Tailwind CSS v4', 'PHP 8.2', 'Vite 7'].map((t) => (
                        <span key={t} className="text-sm font-semibold text-slate-500 dark:text-slate-400">{t}</span>
                    ))}
                </div>
            </section>

            {/* CTA */}
            <section className="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
                <h2 className="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4">Sedia untuk bermula?</h2>
                <p className="text-slate-500 dark:text-slate-400 mb-8 text-lg">Daftar akaun secara percuma. Akaun anda akan diaktifkan selepas disahkan oleh Admin.</p>
                <Link href={route('register')} className="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-[#228260] hover:bg-[#1b6b4f] dark:bg-[#32BA83] dark:hover:bg-[#43c892] text-lg font-bold text-white dark:text-slate-950 transition-all shadow-xl shadow-emerald-500/20 group">
                    Daftar Sekarang — Percuma
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </Link>
            </section>

            {/* Footer */}
            <footer className="relative z-10 border-t border-white/5 py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div className="flex items-center gap-2">
                        <div className="w-6 h-6 rounded-lg bg-gradient-to-br from-[#228260] to-[#32BA83] flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-3.5 w-3.5 text-slate-900 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <span className="text-sm font-semibold text-slate-500 dark:text-slate-400">EduFlow</span>
                        <span className="text-xs text-slate-400 dark:text-slate-600">© 2026 · MIT License</span>
                    </div>
                    <p className="text-xs text-slate-400 dark:text-slate-600">
                        Laravel v{laravelVersion} · PHP v{phpVersion}
                    </p>
                </div>
            </footer>
        </div>
    );
}
