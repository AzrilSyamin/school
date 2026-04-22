import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import { formatStudentId } from '@/utils/formatters';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function Edit({ student, classrooms }) {
    const { data, setData, put, processing, errors } = useForm({
        name: student.name,
        student_id: student.student_id || '',
        email: student.email || '',
        age: student.age ?? '',
        gender: student.gender ?? '',
        classroom_id: student.classroom_id ?? '',
    });

    const submit = (e) => {
        e.preventDefault();
        put(route('students.update', student.id));
    };

    return (
        <AuthenticatedLayout title="Kemaskini Pelajar">
            <Head title="Kemaskini Pelajar" />

            <div className="max-w-2xl space-y-6">
                <div className="flex items-center gap-4">
                    <Link
                        href={route('students.index')}
                        className="p-2 rounded-xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:bg-slate-800 transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </Link>
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Kemaskini Rekod Pelajar</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Edit maklumat pelajar yang sedia ada.</p>
                    </div>
                </div>

                <div className="rounded-2xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6">
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label htmlFor="name" className={labelClass}>Nama Penuh</label>
                                <input
                                    id="name"
                                    type="text"
                                    value={data.name}
                                    onChange={(e) => setData('name', e.target.value)}
                                    className={inputClass}
                                />
                                <InputError message={errors.name} className="mt-1.5 text-xs text-red-400" />
                            </div>

                            <div>
                                <label htmlFor="student_id" className={labelClass}>Student ID</label>
                                <input
                                    id="student_id"
                                    type="text"
                                    value={data.student_id}
                                    onChange={(e) => setData('student_id', formatStudentId(e.target.value))}
                                    className={inputClass}
                                    autoCapitalize="characters"
                                />
                                <InputError message={errors.student_id} className="mt-1.5 text-xs text-red-400" />
                            </div>
                        </div>

                        <div>
                            <label htmlFor="email" className={labelClass}>Emel (Pilihan)</label>
                            <input
                                id="email"
                                type="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                className={inputClass}
                            />
                            <InputError message={errors.email} className="mt-1.5 text-xs text-red-400" />
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label htmlFor="age" className={labelClass}>Umur</label>
                                <input
                                    id="age"
                                    type="number"
                                    min="1"
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
                        </div>

                        <div>
                            <label htmlFor="classroom_id" className={labelClass}>Kelas</label>
                            <select
                                id="classroom_id"
                                value={data.classroom_id}
                                onChange={(e) => setData('classroom_id', e.target.value)}
                                className={`${inputClass} appearance-none`}
                            >
                                <option value="">-- Tiada Kelas (Belum Ditetapkan) --</option>
                                {classrooms.map((c) => (
                                    <option key={c.id} value={c.id}>{c.name}</option>
                                ))}
                            </select>
                            <InputError message={errors.classroom_id} className="mt-1.5 text-xs text-red-400" />
                        </div>

                        <div className="pt-4 border-t border-slate-200 dark:border-slate-200 dark:border-slate-800 flex items-center justify-end gap-3">
                            <Link
                                href={route('students.index')}
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
