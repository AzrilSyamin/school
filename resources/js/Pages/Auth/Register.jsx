import InputError from '@/Components/InputError';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import { useEffect } from 'react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        first_name: '',
        last_name: '',
        username: '',
        phone_number: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('register'));
    };

    return (
        <GuestLayout>
            <Head title="Pendaftaran Akaun" />

            <div className="mb-10">
                <h2 className="text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">Daftar Akaun</h2>
                <p className="text-slate-500 dark:text-slate-400 text-sm font-medium mt-3">Sertai komuniti pendidikan kami hari ini.</p>
            </div>

            <form onSubmit={submit} className="space-y-5">
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div className="space-y-2">
                        <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">Nama Pertama</label>
                        <input
                            type="text"
                            value={data.first_name}
                            onChange={(e) => setData('first_name', e.target.value)}
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required
                            autoFocus
                        />
                        <InputError message={errors.first_name} className="mt-1 font-bold text-xs text-red-500" />
                    </div>
                    <div className="space-y-2">
                        <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">Nama Akhir</label>
                        <input
                            type="text"
                            value={data.last_name}
                            onChange={(e) => setData('last_name', e.target.value)}
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        />
                        <InputError message={errors.last_name} className="mt-1 font-bold text-xs text-red-500" />
                    </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div className="space-y-2">
                        <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">Username</label>
                        <input
                            type="text"
                            value={data.username}
                            onChange={(e) => setData('username', e.target.value)}
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required
                        />
                        <InputError message={errors.username} className="mt-1 font-bold text-xs text-red-500" />
                    </div>
                    <div className="space-y-2">
                        <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">No. Telefon</label>
                        <input
                            type="text"
                            value={data.phone_number}
                            onChange={(e) => setData('phone_number', e.target.value)}
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            placeholder="0123456789"
                        />
                        <InputError message={errors.phone_number} className="mt-1 font-bold text-xs text-red-500" />
                    </div>
                </div>

                <div className="space-y-2">
                    <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">Email Rasmi</label>
                    <input
                        type="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        required
                    />
                    <InputError message={errors.email} className="mt-1 font-bold text-xs text-red-500" />
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div className="space-y-2">
                        <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">Kata Laluan</label>
                        <input
                            type="password"
                            value={data.password}
                            onChange={(e) => setData('password', e.target.value)}
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required
                        />
                        <InputError message={errors.password} className="mt-1 font-bold text-xs text-red-500" />
                    </div>
                    <div className="space-y-2">
                        <label className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">Sahkan</label>
                        <input
                            type="password"
                            value={data.password_confirmation}
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                            required
                        />
                        <InputError message={errors.password_confirmation} className="mt-1 font-bold text-xs text-red-500" />
                    </div>
                </div>

                <div className="pt-4">
                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl text-sm font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50"
                    >
                        {processing ? "Sila Tunggu..." : "Cipta Akaun Baharu"}
                    </button>
                </div>
            </form>

            <div className="mt-12 pt-8 border-t border-slate-100 dark:border-slate-900 text-center">
                <p className="text-sm text-slate-500 dark:text-slate-400 font-medium">
                    Sudah mempunyai akaun?{' '}
                    <Link
                        href={route('login')}
                        className="text-blue-600 dark:text-blue-500 font-black hover:underline transition-all"
                    >
                        Log Masuk Di Sini
                    </Link>
                </p>
            </div>
        </GuestLayout>
    );
}
