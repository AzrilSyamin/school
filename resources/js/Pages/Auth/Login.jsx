import { useState } from 'react';
import InputError from '@/Components/InputError';
import { Head, Link, useForm } from '@inertiajs/react';
import GuestLayout from '@/Layouts/GuestLayout';

export default function Login({ status, canResetPassword }) {
    const [showPassword, setShowPassword] = useState(false);

    const { data, setData, post, processing, errors, reset } = useForm({
        login: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log In" />

            <div className="mb-10">
                <h2 className="text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                    Log Masuk
                </h2>
                <p className="mt-3 text-slate-500 dark:text-slate-400 font-medium">
                    Selamat kembali! Sila masukkan kredensial anda.
                </p>
            </div>

            {status && (
                <div className="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-500/10 dark:border-emerald-500/20 text-sm font-bold text-emerald-600 dark:text-emerald-400">
                    {status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-6">
                {/* Login Field */}
                <div className="space-y-2">
                    <label htmlFor="login" className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">
                        Email / Username
                    </label>
                    <input
                        id="login"
                        type="text"
                        name="login"
                        value={data.login}
                        autoComplete="username"
                        autoFocus
                        onChange={(e) => setData('login', e.target.value)}
                        placeholder="Masukkan email atau username"
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    />
                    <InputError message={errors.login} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                {/* Password Field */}
                <div className="space-y-2">
                    <div className="flex items-center justify-between px-0.5">
                        <label htmlFor="password" className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                            Kata Laluan
                        </label>
                    </div>
                    <div className="relative group">
                        <input
                            id="password"
                            type={showPassword ? 'text' : 'password'}
                            name="password"
                            value={data.password}
                            autoComplete="current-password"
                            onChange={(e) => setData('password', e.target.value)}
                            placeholder="••••••••"
                            className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 pl-4 pr-12 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                        />
                        <button
                            type="button"
                            onClick={() => setShowPassword(!showPassword)}
                            className="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 dark:text-slate-500 hover:text-blue-600 transition-colors"
                        >
                            {showPassword ? (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            ) : (
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            )}
                        </button>
                    </div>
                    <InputError message={errors.password} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                {/* Actions */}
                <div className="flex items-center justify-between">
                    <label className="flex items-center gap-3 cursor-pointer group">
                        <input
                            type="checkbox"
                            checked={data.remember}
                            onChange={(e) => setData('remember', e.target.checked)}
                            className="w-5 h-5 rounded-md border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-blue-600 focus:ring-blue-500/20"
                        />
                        <span className="text-sm text-slate-500 dark:text-slate-400 font-bold">Ingat saya</span>
                    </label>

                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="text-sm font-black text-blue-600 hover:text-blue-500 transition-colors uppercase tracking-wider"
                        >
                            Lupa Kata Laluan?
                        </Link>
                    )}
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl text-sm font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50"
                >
                    {processing ? "Sila Tunggu..." : "Log Masuk Sekarang"}
                </button>
            </form>

            <div className="mt-12 pt-8 border-t border-slate-100 dark:border-slate-900 text-center">
                <p className="text-sm text-slate-500 dark:text-slate-400 font-medium">
                    Belum mempunyai akaun?{' '}
                    <Link
                        href={route('register')}
                        className="text-blue-600 dark:text-blue-500 font-black hover:underline transition-all"
                    >
                        Daftar Di Sini
                    </Link>
                </p>
            </div>
        </GuestLayout>
    );
}
