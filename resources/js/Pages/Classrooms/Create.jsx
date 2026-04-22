import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function Create({ courses }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        course_id: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('classrooms.store'));
    };

    return (
        <AuthenticatedLayout title="Tambah Kelas">
            <Head title="Tambah Kelas" />

            <div className="max-w-2xl space-y-6">
                <div className="flex items-center gap-4">
                    <Link
                        href={route('classrooms.index')}
                        className="p-2 rounded-xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:bg-slate-800 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </Link>
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Tambah Kelas Baharu</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Daftar kelas dan pilih kursus.</p>
                    </div>
                </div>

                <div className="rounded-2xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xl">
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label htmlFor="name" className={labelClass}>Nama Kelas</label>
                                <input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className={inputClass}
                                    placeholder="Contoh: Class A"
                                />
                                <InputError message={errors.name} className="mt-1.5 text-xs text-red-400" />
                            </div>

                            <div>
                                <label htmlFor="course_id" className={labelClass}>Kursus</label>
                                <select
                                    id="course_id"
                                    value={data.course_id}
                                    onChange={(e) => setData('course_id', e.target.value)}
                                    className={inputClass}
                                >
                                    <option value="">Pilih Kursus</option>
                                    {courses.map((course) => (
                                        <option key={course.id} value={course.id}>{course.name}</option>
                                    ))}
                                </select>
                                <InputError message={errors.course_id} className="mt-1.5 text-xs text-red-400" />
                            </div>
                        </div>

                        <div className="pt-4 border-t border-slate-200 dark:border-slate-200 dark:border-slate-800 flex items-center justify-end gap-3">
                            <Link
                                href={route('classrooms.index')}
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
                                Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
