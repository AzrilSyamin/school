import InputError from '@/Components/InputError';
import { useForm } from '@inertiajs/react';
import { useRef, useState } from 'react';

export default function DeleteUserForm() {
    const [confirming, setConfirming] = useState(false);
    const passwordInput = useRef();

    const { data, setData, delete: destroy, processing, reset, errors, clearErrors } = useForm({ password: '' });

    const deleteUser = (e) => {
        e.preventDefault();
        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => { setConfirming(false); clearErrors(); reset(); };

    return (
        <div className="space-y-4">
            <div>
                <p className="text-sm text-slate-500 dark:text-slate-400">
                    Setelah akaun anda dipadam, semua data dan sumber berkaitan akan dibuang secara kekal. Sila muat turun mana-mana data yang ingin anda simpan sebelum meneruskan.
                </p>
            </div>

            <button
                onClick={() => setConfirming(true)}
                className="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-red-500/30 bg-red-500/10 text-sm font-medium text-red-400 hover:bg-red-500/20 hover:border-red-500/50 transition-all"
            >
                <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                    <path strokeLinecap="round" strokeLinejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
                Padam Akaun
            </button>

            {/* Confirmation Modal */}
            {confirming && (
                <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-black/70 backdrop-blur-sm" onClick={closeModal} />
                    <div className="relative z-10 w-full max-w-md rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-2xl p-6">
                        <div className="flex items-center gap-3 mb-4">
                            <div className="w-10 h-10 rounded-xl bg-red-500/10 border border-red-500/20 flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 className="text-base font-semibold text-slate-900 dark:text-white">Padam Akaun?</h3>
                                <p className="text-xs text-slate-500">Tindakan ini tidak boleh diundur</p>
                            </div>
                        </div>

                        <p className="text-sm text-slate-500 dark:text-slate-400 mb-5">
                            Semua data akan dipadamkan secara kekal. Masukkan kata laluan anda untuk mengesahkan.
                        </p>

                        <form onSubmit={deleteUser} className="space-y-4">
                            <div>
                                <label htmlFor="delete_password" className="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kata Laluan</label>
                                <input
                                    id="delete_password"
                                    ref={passwordInput}
                                    type="password"
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    placeholder="••••••••"
                                    className="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none transition-all focus:border-red-500 focus:ring-4 focus:ring-red-500/10"
                                />
                                <InputError className="mt-1.5 text-xs text-red-400" message={errors.password} />
                            </div>

                            <div className="flex justify-end gap-3">
                                <button type="button" onClick={closeModal} className="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    Batal
                                </button>
                                <button type="submit" disabled={processing} className="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-red-600 text-sm font-bold text-white hover:bg-red-500 transition-all shadow-lg shadow-red-600/20 active:scale-95 disabled:opacity-50">
                                    {processing && (
                                        <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                        </svg>
                                    )}
                                    Ya, Padam Akaun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
}
