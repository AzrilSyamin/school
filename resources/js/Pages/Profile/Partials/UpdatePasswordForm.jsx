import InputError from '@/Components/InputError';
import { Transition } from '@headlessui/react';
import { useForm } from '@inertiajs/react';
import { useRef } from 'react';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function UpdatePasswordForm() {
    const passwordInput = useRef();
    const currentPasswordInput = useRef();

    const { data, setData, errors, put, reset, processing, recentlySuccessful } = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword = (e) => {
        e.preventDefault();
        put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => reset(),
            onError: (errors) => {
                if (errors.password) { reset('password', 'password_confirmation'); passwordInput.current.focus(); }
                if (errors.current_password) { reset('current_password'); currentPasswordInput.current.focus(); }
            },
        });
    };

    return (
        <form onSubmit={updatePassword} className="space-y-5">
            <div>
                <label htmlFor="current_password" className={labelClass}>Kata Laluan Semasa</label>
                <input id="current_password" ref={currentPasswordInput} type="password" value={data.current_password} onChange={(e) => setData('current_password', e.target.value)} autoComplete="current-password" className={inputClass} placeholder="••••••••" />
                <InputError className="mt-1.5 text-xs text-red-400" message={errors.current_password} />
            </div>

            <div>
                <label htmlFor="password" className={labelClass}>Kata Laluan Baharu</label>
                <input id="password" ref={passwordInput} type="password" value={data.password} onChange={(e) => setData('password', e.target.value)} autoComplete="new-password" className={inputClass} placeholder="••••••••" />
                <InputError className="mt-1.5 text-xs text-red-400" message={errors.password} />
            </div>

            <div>
                <label htmlFor="password_confirmation" className={labelClass}>Sahkan Kata Laluan Baharu</label>
                <input id="password_confirmation" type="password" value={data.password_confirmation} onChange={(e) => setData('password_confirmation', e.target.value)} autoComplete="new-password" className={inputClass} placeholder="••••••••" />
                <InputError className="mt-1.5 text-xs text-red-400" message={errors.password_confirmation} />
            </div>

            <div className="flex items-center gap-4 pt-2">
                <button
                    type="submit"
                    disabled={processing}
                    className="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-sm font-bold text-white shadow-lg shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                >
                    {processing && (
                        <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                    )}
                    Kemaskini Kata Laluan
                </button>

                <Transition show={recentlySuccessful} enter="transition ease-in-out" enterFrom="opacity-0" leave="transition ease-in-out" leaveTo="opacity-0">
                    <div className="flex items-center gap-1.5 text-sm text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Tersimpan!
                    </div>
                </Transition>
            </div>
        </form>
    );
}
