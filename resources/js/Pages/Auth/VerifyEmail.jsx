import AuthFooter from '@/Components/AuthFooter';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const submit = (e) => {
        e.preventDefault();
        post(route('verification.send'));
    };

    return (
        <GuestLayout>
            <Head title="Pengesahan Email" />

            <div className="mb-10">
                <h2 className="text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                    Sahkan Email
                </h2>
                <p className="mt-3 text-slate-500 dark:text-slate-400 font-medium">
                    Terima kasih kerana mendaftar! Sila sahkan alamat email anda melalui pautan yang kami hantar.
                </p>
            </div>

            {status === 'verification-link-sent' && (
                <div className="mb-8 p-4 rounded-xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-500/10 dark:border-emerald-500/20 text-sm font-bold text-emerald-600 dark:text-emerald-400">
                    Pautan pengesahan baru telah dihantar ke alamat email anda.
                </div>
            )}

            <form onSubmit={submit} className="space-y-6">
                <button
                    type="submit"
                    disabled={processing}
                    className="w-full py-4 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 rounded-xl text-sm font-black text-white uppercase tracking-[0.2em] shadow-lg shadow-blue-500/20 transition-all disabled:opacity-50"
                >
                    {processing ? "Menghantar..." : "Hantar Semula Email Pengesahan"}
                </button>

                <div className="flex justify-center">
                    <Link
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="text-xs font-black text-slate-400 hover:text-red-500 transition-colors uppercase tracking-[0.2em]"
                    >
                        Log Keluar
                    </Link>
                </div>
            </form>

            <AuthFooter />
        </GuestLayout>
    );
}
