import InputError from '@/Components/InputError';
import AuthFooter from '@/Components/AuthFooter';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Head title="Lupa Kata Laluan" />

            <div className="mb-10">
                <Link
                    href={route('login')}
                    className="inline-flex items-center gap-1.5 text-xs font-black text-blue-600 hover:text-blue-500 transition-colors mb-6 uppercase tracking-widest"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={3}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Kembali
                </Link>
                
                <h2 className="text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                    Reset Kata Laluan
                </h2>
                <p className="mt-3 text-slate-500 dark:text-slate-400 font-medium">
                    Masukkan email anda untuk menerima pautan penetapan semula.
                </p>
            </div>

            {status && (
                <div className="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-500/10 dark:border-emerald-500/20 text-sm font-bold text-emerald-600 dark:text-emerald-400 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-6">
                <div className="space-y-2">
                    <label htmlFor="email" className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">
                        Alamat Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        autoFocus
                        autoComplete="email"
                        onChange={(e) => setData('email', e.target.value)}
                        placeholder="admin@sekolah.edu.my"
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    />
                    <InputError message={errors.email} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl text-sm font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50"
                >
                    {processing ? "Menghantar..." : "Hantar Pautan Reset"}
                </button>
            </form>

            <AuthFooter />
        </GuestLayout>
    );
}
