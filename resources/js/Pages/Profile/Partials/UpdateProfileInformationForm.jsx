import InputError from '@/Components/InputError';
import { Transition } from '@headlessui/react';
import { Link, useForm, usePage } from '@inertiajs/react';
import { useRef, useState } from 'react';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function UpdateProfileInformation({ mustVerifyEmail, status }) {
    const user = usePage().props.auth.user;
    const fileInput = useRef();
    const [preview, setPreview] = useState(null);

    const { data, setData, post, errors, processing, recentlySuccessful } = useForm({
        _method: 'PATCH',
        first_name: user.first_name ?? '',
        last_name: user.last_name ?? '',
        email: user.email,
        username: user.username ?? '',
        phone_number: user.phone_number ?? '',
        age: user.age ?? '',
        gender: user.gender ?? '',
        address: user.address ?? '',
        picture: null,
    });

    const handleFileChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('picture', file);
            const reader = new FileReader();
            reader.onloadend = () => setPreview(reader.result);
            reader.readAsDataURL(file);
        }
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('profile.update'), {
            preserveScroll: true,
            forceFormData: true,
        });
    };

    return (
        <form onSubmit={submit} className="space-y-6">
            {/* Profile Picture Section */}
            <div className="flex flex-col sm:flex-row items-center gap-6 pb-2">
                <div className="relative group">
                    <div className="w-24 h-24 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 overflow-hidden border-2 border-slate-200 dark:border-slate-700 group-hover:border-blue-500 transition-all shadow-inner">
                        {preview ? (
                            <img src={preview} className="w-full h-full object-cover" alt="Preview" />
                        ) : user.picture ? (
                            <img 
                                src={user.picture === 'default.jpg' || user.picture.startsWith('images/') 
                                    ? `/${user.picture === 'default.jpg' ? 'images/default.jpg' : user.picture}` 
                                    : `/storage/${user.picture}`} 
                                className="w-full h-full object-cover" 
                                alt="Profile" 
                            />
                        ) : (
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-10 w-10 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        )}
                        <div className="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" onClick={() => fileInput.current.click()}>
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                            </svg>
                        </div>
                    </div>
                    <input type="file" ref={fileInput} className="hidden" onChange={handleFileChange} accept="image/*" />
                </div>
                <div className="flex-1 text-center sm:text-left">
                    <h3 className="text-sm font-bold text-slate-900 dark:text-white">Gambar Profil</h3>
                    <p className="text-xs text-slate-500 mt-1 mb-3">Klik pada gambar untuk menukar avatar anda. (JPG, PNG, max 2MB)</p>
                    <button type="button" onClick={() => fileInput.current.click()} className="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-widest hover:underline">
                        Pilih Gambar Baru
                    </button>
                    <InputError className="mt-1 text-xs text-red-400" message={errors.picture} />
                </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label htmlFor="first_name" className={labelClass}>Nama Pertama</label>
                    <input id="first_name" type="text" value={data.first_name} onChange={(e) => setData('first_name', e.target.value)} autoComplete="given-name" className={inputClass} />
                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.first_name} />
                </div>
                <div>
                    <label htmlFor="last_name" className={labelClass}>Nama Akhir</label>
                    <input id="last_name" type="text" value={data.last_name} onChange={(e) => setData('last_name', e.target.value)} autoComplete="family-name" className={inputClass} />
                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.last_name} />
                </div>
            </div>

            <div>
                <label htmlFor="email" className={labelClass}>Alamat Email</label>
                <input id="email" type="email" value={data.email} onChange={(e) => setData('email', e.target.value)} autoComplete="email" className={inputClass} />
                <InputError className="mt-1.5 text-xs text-red-400" message={errors.email} />
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label htmlFor="username" className={labelClass}>Username</label>
                    <input id="username" type="text" value={data.username} onChange={(e) => setData('username', e.target.value)} autoComplete="username" className={inputClass} />
                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.username} />
                </div>
                <div>
                    <label htmlFor="phone_number" className={labelClass}>No. Telefon</label>
                    <input id="phone_number" type="text" value={data.phone_number} onChange={(e) => setData('phone_number', e.target.value)} autoComplete="tel" className={inputClass} placeholder="0123456789" />
                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.phone_number} />
                </div>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label htmlFor="age" className={labelClass}>Umur</label>
                    <input id="age" type="number" value={data.age} onChange={(e) => setData('age', e.target.value)} className={inputClass} placeholder="Contoh: 25" />
                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.age} />
                </div>
                <div>
                    <label htmlFor="gender" className={labelClass}>Jantina</label>
                    <select id="gender" value={data.gender} onChange={(e) => setData('gender', e.target.value)} className={inputClass}>
                        <option value="">Pilih Jantina</option>
                        <option value="Lelaki">Lelaki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                    <InputError className="mt-1.5 text-xs text-red-400" message={errors.gender} />
                </div>
            </div>

            <div>
                <label htmlFor="address" className={labelClass}>Alamat</label>
                <textarea id="address" value={data.address} onChange={(e) => setData('address', e.target.value)} className={`${inputClass} min-h-[100px] py-3`} placeholder="Alamat lengkap anda..." />
                <InputError className="mt-1.5 text-xs text-red-400" message={errors.address} />
            </div>

            {mustVerifyEmail && user.email_verified_at === null && (
                <div className="flex items-start gap-3 rounded-xl bg-amber-500/10 border border-amber-500/20 px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 text-amber-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
                    <p className="text-sm text-amber-400">
                        Email anda belum disahkan.{' '}
                        <Link href={route('verification.send')} method="post" as="button" className="underline hover:text-amber-300 transition-colors">
                            Hantar semula pautan pengesahan.
                        </Link>
                        {status === 'verification-link-sent' && (
                            <span className="block mt-1 text-green-400">Pautan pengesahan telah dihantar!</span>
                        )}
                    </p>
                </div>
            )}

            <div className="flex items-center gap-4 pt-2">
                <button
                    type="submit"
                    disabled={processing}
                    className="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-sm font-black text-white shadow-lg shadow-blue-500/20 transition-all hover:scale-[1.02] active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 uppercase tracking-widest"
                >
                    {processing ? (
                        <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                    ) : null}
                    Simpan Perubahan
                </button>

                <Transition show={recentlySuccessful} enter="transition ease-in-out" enterFrom="opacity-0" leave="transition ease-in-out" leaveTo="opacity-0">
                    <div className="flex items-center gap-1.5 text-sm text-green-500 font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Tersimpan!
                    </div>
                </Transition>
            </div>
        </form>
    );
}
