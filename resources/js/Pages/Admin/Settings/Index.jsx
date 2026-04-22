import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, usePage } from '@inertiajs/react';
import { useRef, useState } from 'react';
import InputError from '@/Components/InputError';
import { Transition } from '@headlessui/react';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function Index({ settings }) {
    const logoInput = useRef();
    const faviconInput = useRef();
    const [logoPreview, setLogoPreview] = useState(null);
    const [faviconPreview, setFaviconPreview] = useState(null);

    const { data, setData, post, processing, errors, recentlySuccessful } = useForm({
        site_title: settings.site_title || '',
        site_logo: null,
        site_favicon: null,
    });

    const handleLogoChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('site_logo', file);
            const reader = new FileReader();
            reader.onloadend = () => setLogoPreview(reader.result);
            reader.readAsDataURL(file);
        }
    };

    const handleFaviconChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('site_favicon', file);
            const reader = new FileReader();
            reader.onloadend = () => setFaviconPreview(reader.result);
            reader.readAsDataURL(file);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('settings.update'), {
            forceFormData: true,
            preserveScroll: true,
        });
    };

    return (
        <AuthenticatedLayout title="Tetapan Sistem">
            <Head title="Tetapan Sistem" />

            <div className="space-y-6 max-w-4xl">
                <div>
                    <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Tetapan Sistem</h1>
                    <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Uruskan identiti visual dan konfigurasi asas aplikasi anda.</p>
                </div>

                <form onSubmit={submit} className="space-y-6">
                    {/* Branding Card */}
                    <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-sm">
                        <div className="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
                            <h2 className="text-base font-semibold text-slate-900 dark:text-white">Identiti & Branding</h2>
                        </div>
                        
                        <div className="p-6 space-y-8">
                            {/* Site Title */}
                            <div>
                                <label htmlFor="site_title" className={labelClass}>Tajuk Aplikasi (Site Title)</label>
                                <input 
                                    id="site_title" 
                                    type="text" 
                                    value={data.site_title} 
                                    onChange={(e) => setData('site_title', e.target.value)} 
                                    className={inputClass} 
                                    placeholder="Contoh: MySchool Management System"
                                />
                                <InputError className="mt-1.5 text-xs text-red-400" message={errors.site_title} />
                            </div>

                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                {/* Logo Upload */}
                                <div>
                                    <label className={labelClass}>Logo Aplikasi</label>
                                    <div className="mt-2 flex flex-col items-center p-6 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-2xl hover:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-950/30">
                                        <div className="w-full h-32 flex items-center justify-center mb-4 overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-inner">
                                            {logoPreview ? (
                                                <img src={logoPreview} className="max-h-full object-contain" alt="Logo Preview" />
                                            ) : settings.site_logo ? (
                                                <img src={settings.site_logo.startsWith('settings/') ? `/storage/${settings.site_logo}` : `/${settings.site_logo}`} className="max-h-full object-contain" alt="Current Logo" />
                                            ) : (
                                                <span className="text-slate-400 text-xs">Tiada Logo</span>
                                            )}
                                        </div>
                                        <input type="file" ref={logoInput} onChange={handleLogoChange} className="hidden" accept="image/*" />
                                        <button 
                                            type="button" 
                                            onClick={() => logoInput.current.click()} 
                                            className="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm hover:bg-slate-50 transition-all"
                                        >
                                            Pilih Logo Baru
                                        </button>
                                        <p className="mt-2 text-[10px] text-slate-500">PNG atau JPG (Max 2MB). Cadangan saiz: 512x512.</p>
                                    </div>
                                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.site_logo} />
                                </div>

                                {/* Favicon Upload */}
                                <div>
                                    <label className={labelClass}>Favicon (Icon Tab)</label>
                                    <div className="mt-2 flex flex-col items-center p-6 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-2xl hover:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-950/30">
                                        <div className="w-16 h-16 flex items-center justify-center mb-4 overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-inner p-2">
                                            {faviconPreview ? (
                                                <img src={faviconPreview} className="max-h-full object-contain" alt="Favicon Preview" />
                                            ) : settings.site_favicon ? (
                                                <img src={settings.site_favicon.startsWith('settings/') ? `/storage/${settings.site_favicon}` : `/${settings.site_favicon}`} className="max-h-full object-contain" alt="Current Favicon" />
                                            ) : (
                                                <span className="text-slate-400 text-[10px]">No Favicon</span>
                                            )}
                                        </div>
                                        <input type="file" ref={faviconInput} onChange={handleFaviconChange} className="hidden" accept="image/*" />
                                        <button 
                                            type="button" 
                                            onClick={() => faviconInput.current.click()} 
                                            className="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 shadow-sm hover:bg-slate-50 transition-all"
                                        >
                                            Pilih Favicon Baru
                                        </button>
                                        <p className="mt-2 text-[10px] text-slate-500">ICO atau PNG (Max 1MB). Saiz ideal: 32x32.</p>
                                    </div>
                                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.site_favicon} />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="flex items-center gap-4">
                        <button
                            type="submit"
                            disabled={processing}
                            className="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-sm font-black text-white shadow-lg shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-[0.99] disabled:opacity-50 uppercase tracking-widest"
                        >
                            {processing ? (
                                <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                            ) : null}
                            Kemaskini Tetapan
                        </button>

                        <Transition show={recentlySuccessful} enter="transition ease-in-out" enterFrom="opacity-0" leave="transition ease-in-out" leaveTo="opacity-0">
                            <div className="flex items-center gap-1.5 text-sm text-green-500 font-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Tetapan Berjaya Disimpan!
                            </div>
                        </Transition>
                    </div>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
