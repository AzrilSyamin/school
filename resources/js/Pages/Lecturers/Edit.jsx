import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function Edit({ lecturer }) {
    const { data, setData, post, processing, errors } = useForm({
        _method: 'PUT',
        first_name: lecturer.first_name || '',
        last_name: lecturer.last_name || '',
        email: lecturer.email || '',
        username: lecturer.username || '',
        phone_number: lecturer.phone_number || '',
        age: lecturer.age || '',
        gender: lecturer.gender || '',
        address: lecturer.address || '',
        picture: null,
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();
        // Use POST with _method: 'PUT' for file upload in Inertia
        post(route('lecturers.update', lecturer.id));
    };

    return (
        <AuthenticatedLayout title="Kemaskini Pensyarah">
            <Head title="Kemaskini Pensyarah" />

            <div className="max-w-4xl space-y-6">
                <div className="flex items-center gap-4">
                    <Link
                        href={route('lecturers.index')}
                        className="p-2 rounded-xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:bg-slate-800 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </Link>
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Kemaskini Maklumat Pensyarah</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Kemaskini maklumat peribadi dan akaun pensyarah.</p>
                    </div>
                </div>

                <div className="rounded-2xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                    <form onSubmit={submit} className="space-y-8">
                        {/* Profile Section */}
                        <div className="space-y-6">
                            <h2 className="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                                <span className="w-1.5 h-1.5 rounded-full bg-blue-500" />
                                Maklumat Peribadi
                            </h2>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label htmlFor="first_name" className={labelClass}>Nama Pertama</label>
                                    <input
                                        id="first_name"
                                        type="text"
                                        value={data.first_name}
                                        onChange={(e) => setData('first_name', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.first_name} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="last_name" className={labelClass}>Nama Akhir</label>
                                    <input
                                        id="last_name"
                                        type="text"
                                        value={data.last_name}
                                        onChange={(e) => setData('last_name', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.last_name} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="age" className={labelClass}>Umur</label>
                                    <input
                                        id="age"
                                        type="number"
                                        min="22"
                                        value={data.age}
                                        onChange={(e) => setData('age', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.age} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="gender" className={labelClass}>Jantina</label>
                                    <select
                                        id="gender"
                                        value={data.gender}
                                        onChange={(e) => setData('gender', e.target.value)}
                                        className={`${inputClass} appearance-none`}
                                    >
                                        <option value="">-- Pilih Jantina --</option>
                                        <option value="Lelaki">Lelaki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <InputError message={errors.gender} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="phone_number" className={labelClass}>No. Telefon</label>
                                    <input
                                        id="phone_number"
                                        type="text"
                                        value={data.phone_number}
                                        onChange={(e) => setData('phone_number', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.phone_number} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="picture" className={labelClass}>Gambar Profil (Kosongkan jika tiada perubahan)</label>
                                    <input
                                        id="picture"
                                        type="file"
                                        onChange={(e) => setData('picture', e.target.files[0])}
                                        className="w-full text-sm text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer"
                                    />
                                    <InputError message={errors.picture} className="mt-1.5 text-xs text-red-400" />
                                </div>
                            </div>
                            <div>
                                <label htmlFor="address" className={labelClass}>Alamat</label>
                                <textarea
                                    id="address"
                                    value={data.address}
                                    onChange={(e) => setData('address', e.target.value)}
                                    className={`${inputClass} min-h-[100px] resize-y`}
                                />
                                <InputError message={errors.address} className="mt-1.5 text-xs text-red-400" />
                            </div>
                        </div>

                        {/* Account Section */}
                        <div className="space-y-6 pt-6 border-t border-slate-200 dark:border-slate-200 dark:border-slate-800">
                            <h2 className="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                                <span className="w-1.5 h-1.5 rounded-full bg-blue-500" />
                                Maklumat Akaun
                            </h2>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label htmlFor="email" className={labelClass}>Alamat Email</label>
                                    <input
                                        id="email"
                                        type="email"
                                        value={data.email}
                                        onChange={(e) => setData('email', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.email} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="username" className={labelClass}>Username</label>
                                    <input
                                        id="username"
                                        type="text"
                                        value={data.username}
                                        onChange={(e) => setData('username', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.username} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="password" className={labelClass}>Kata Laluan Baharu (Kosongkan jika tiada perubahan)</label>
                                    <input
                                        id="password"
                                        type="password"
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.password} className="mt-1.5 text-xs text-red-400" />
                                </div>
                                <div>
                                    <label htmlFor="password_confirmation" className={labelClass}>Sahkan Kata Laluan Baharu</label>
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        value={data.password_confirmation}
                                        onChange={(e) => setData('password_confirmation', e.target.value)}
                                        className={inputClass}
                                    />
                                    <InputError message={errors.password_confirmation} className="mt-1.5 text-xs text-red-400" />
                                </div>
                            </div>
                        </div>

                        <div className="pt-6 border-t border-slate-200 dark:border-slate-200 dark:border-slate-800 flex items-center justify-end gap-3">
                            <Link
                                href={route('lecturers.index')}
                                className="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:bg-slate-800 transition-colors"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-sm font-semibold text-white transition-colors shadow-lg shadow-blue-500/20 disabled:opacity-50"
                            >
                                {processing && (
                                    <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                    </svg>
                                )}
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
