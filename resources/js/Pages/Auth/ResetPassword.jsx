import InputError from '@/Components/InputError';
import AuthFooter from '@/Components/AuthFooter';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm } from '@inertiajs/react';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('password.store'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Reset Kata Laluan" />

            <div className="mb-10">
                <h2 className="text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                    Kata Laluan Baru
                </h2>
                <p className="mt-3 text-slate-500 dark:text-slate-400 font-medium">
                    Sila cipta kata laluan baru yang kukuh untuk akaun anda.
                </p>
            </div>

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
                        autoComplete="username"
                        onChange={(e) => setData('email', e.target.value)}
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    />
                    <InputError message={errors.email} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                <div className="space-y-2">
                    <label htmlFor="password" className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">
                        Kata Laluan Baru
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        autoComplete="new-password"
                        autoFocus
                        onChange={(e) => setData('password', e.target.value)}
                        placeholder="••••••••"
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    />
                    <InputError message={errors.password} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                <div className="space-y-2">
                    <label htmlFor="password_confirmation" className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">
                        Sahkan Kata Laluan
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        autoComplete="new-password"
                        onChange={(e) => setData('password_confirmation', e.target.value)}
                        placeholder="••••••••"
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    />
                    <InputError message={errors.password_confirmation} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl text-sm font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50"
                >
                    {processing ? "Sila Tunggu..." : "Kemaskini Kata Laluan"}
                </button>
            </form>

            <AuthFooter />
        </GuestLayout>
    );
}
