import InputError from '@/Components/InputError';
import AuthFooter from '@/Components/AuthFooter';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm } from '@inertiajs/react';

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors, reset } = useForm({
        password: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('password.confirm'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Sahkan Kata Laluan" />

            <div className="mb-10">
                <h2 className="text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                    Kawasan Selamat
                </h2>
                <p className="mt-3 text-slate-500 dark:text-slate-400 font-medium">
                    Sila sahkan kata laluan anda sebelum meneruskan ke bahagian ini.
                </p>
            </div>

            <form onSubmit={submit} className="space-y-6">
                <div className="space-y-2">
                    <label htmlFor="password" className="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] px-0.5">
                        Kata Laluan
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        autoFocus
                        onChange={(e) => setData('password', e.target.value)}
                        placeholder="••••••••"
                        className="w-full rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none transition-all focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10"
                    />
                    <InputError message={errors.password} className="mt-1 text-xs text-red-500 font-bold" />
                </div>

                <button
                    type="submit"
                    disabled={processing}
                    className="w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl text-sm font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50"
                >
                    {processing ? "Menyemak..." : "Sahkan Kata Laluan"}
                </button>
            </form>

            <AuthFooter />
        </GuestLayout>
    );
}
