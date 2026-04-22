import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm, usePage, router } from '@inertiajs/react';
import { useState, useEffect } from 'react';

export default function Create({ classrooms = [], selectedClassroom = null, students = [], subjects = [], date, existingAttendances = null, isEditing = false }) {
    const { auth } = usePage().props;
    const { data, setData, post, processing, errors } = useForm({
        classroom_id: selectedClassroom?.id || '',
        subject_id: isEditing && existingAttendances?.length > 0 ? existingAttendances[0].subject_id : '',
        date: date,
        attendances: students.map(student => {
            const existing = existingAttendances?.find(a => a.student_id === student.id);
            return {
                student_id: student.id,
                status: existing ? existing.status : 'Hadir',
                remarks: existing ? (existing.remarks || '') : ''
            };
        })
    });

    // Initialize attendances when students change (only for new records)
    useEffect(() => {
        if (students && students.length > 0 && !isEditing) {
            setData('attendances', students.map(student => ({
                student_id: student.id,
                status: 'Hadir',
                remarks: ''
            })));
        }
    }, [students, isEditing]);

    const handleClassroomChange = (id) => {
        setData('classroom_id', id);
        router.get(route('attendances.create'), { classroom_id: id }, { 
            preserveState: true,
            preserveScroll: true,
            onSuccess: (page) => {
                // The students and subjects will be updated via props
            }
        });
    };

    const handleStatusChange = (studentId, status) => {
        const newAttendances = data.attendances.map(item => 
            item.student_id === studentId ? { ...item, status } : item
        );
        setData('attendances', newAttendances);
    };

    const handleRemarksChange = (studentId, remarks) => {
        const newAttendances = data.attendances.map(item => 
            item.student_id === studentId ? { ...item, remarks } : item
        );
        setData('attendances', newAttendances);
    };

    const submit = (e) => {
        e.preventDefault();
        post(route('attendances.store'));
    };

    const isAdminOrLecturer = ['admin', 'moderator', 'lecturer'].includes(auth.user.role);

    return (
        <AuthenticatedLayout title="Ambil Kehadiran">
            <Head title="Ambil Kehadiran" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">{isEditing ? 'Kemaskini Kehadiran' : 'Ambil Kehadiran'}</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">
                            Sila pilih kelas dan mata pelajaran untuk mula merekod.
                        </p>
                    </div>
                    <Link
                        href={route('attendances.index')}
                        className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:border-[#228260] hover:text-[#228260] dark:hover:border-[#32BA83] dark:hover:text-[#32BA83] transition-colors"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Kembali
                    </Link>
                </div>

                {/* Selectors */}
                <div className="rounded-2xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xl">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {isAdminOrLecturer && (
                            <div>
                                <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Pilih Kelas</label>
                                <select
                                    value={data.classroom_id}
                                    onChange={(e) => handleClassroomChange(e.target.value)}
                                    className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                >
                                    <option value="">-- Pilih Kelas --</option>
                                    {classrooms.map(c => (
                                        <option key={c.id} value={c.id}>{c.name}</option>
                                    ))}
                                </select>
                                {errors.classroom_id && <p className="mt-1 text-xs text-red-500">{errors.classroom_id}</p>}
                            </div>
                        )}

                        <div>
                            <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                            <select
                                value={data.subject_id}
                                onChange={(e) => setData('subject_id', e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                disabled={!data.classroom_id}
                            >
                                <option value="">-- Pilih Subjek --</option>
                                {subjects.map(s => (
                                    <option key={s.id} value={s.id}>{s.name} ({s.code})</option>
                                ))}
                            </select>
                            {errors.subject_id && <p className="mt-1 text-xs text-red-500">{errors.subject_id}</p>}
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tarikh</label>
                            <input
                                type="date"
                                value={data.date}
                                onChange={(e) => setData('date', e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            />
                            {errors.date && <p className="mt-1 text-xs text-red-500">{errors.date}</p>}
                        </div>
                    </div>
                </div>

                {selectedClassroom ? (
                    <div className="space-y-4">
                        {!data.subject_id && (
                            <div className="flex items-center gap-3 p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                </svg>
                                <span>Sila pilih <b>Mata Pelajaran</b> sebelum menghantar kehadiran.</span>
                            </div>
                        )}
                        
                        <div className="rounded-2xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-2xl">
                            <form onSubmit={submit}>
                            <div className="overflow-x-auto">
                                <table className="w-full text-sm text-left">
                                    <thead className="bg-slate-50 dark:bg-slate-800/50">
                                        <tr>
                                            <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs w-1/3">Nama Pelajar</th>
                                            <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs text-center">Status Kehadiran</th>
                                            <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs">Nota / Alasan</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-200 dark:divide-slate-800">
                                        {students.map((student, index) => (
                                            <tr key={student.id} className="hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:hover:bg-slate-800/30 transition-colors">
                                                <td className="px-6 py-4">
                                                    <div className="flex items-center gap-3">
                                                        <div className="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-bold text-slate-500">
                                                            {index + 1}
                                                        </div>
                                                        <div>
                                                            <span className="font-medium text-slate-900 dark:text-white">{student.name}</span>
                                                            <div className="text-[10px] text-slate-400 dark:text-slate-600 font-bold">{student.student_id}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4">
                                                    <div className="flex items-center justify-center gap-1.5">
                                                        {['Hadir', 'Sakit', 'Kecemasan', 'Ponteng'].map((status) => (
                                                            <button
                                                                key={status}
                                                                type="button"
                                                                onClick={() => handleStatusChange(student.id, status)}
                                                                className={`px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase transition-all border ${
                                                                    data.attendances.find(a => a.student_id === student.id)?.status === status
                                                                        ? status === 'Hadir' ? 'bg-green-500/10 text-green-400 border-green-500/50 shadow-lg shadow-green-500/10' :
                                                                          status === 'Ponteng' ? 'bg-red-500/10 text-red-400 border-red-500/50 shadow-lg shadow-red-500/10' :
                                                                          'bg-amber-500/10 text-amber-400 border-amber-500/50 shadow-lg shadow-amber-500/10'
                                                                        : 'bg-slate-50 dark:bg-slate-800/50 text-slate-500 border-slate-200 dark:border-slate-700/50 hover:bg-slate-700/50'
                                                                }`}
                                                            >
                                                                {status}
                                                            </button>
                                                        ))}
                                                    </div>
                                                </td>
                                                <td className="px-6 py-4">
                                                    <input
                                                        type="text"
                                                        value={data.attendances.find(a => a.student_id === student.id)?.remarks || ''}
                                                        onChange={(e) => handleRemarksChange(student.id, e.target.value)}
                                                        placeholder="Masukkan nota jika perlu..."
                                                        className="w-full bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700/50 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 outline-none focus:border-blue-500/50 transition-colors"
                                                    />
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>

                            <div className="px-6 py-6 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 flex flex-col sm:flex-row items-center justify-between gap-4">
                                <p className="text-xs text-slate-500 italic text-center sm:text-left">
                                    Merekod sebagai: <span className="text-blue-400 font-bold uppercase tracking-tight">{auth.user.first_name} {auth.user.last_name}</span>
                                </p>
                                <button
                                    type="submit"
                                    disabled={processing || data.attendances.length === 0 || !data.subject_id}
                                    className="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-sm font-bold text-white transition-all shadow-xl shadow-blue-500/20 disabled:opacity-50 active:scale-95"
                                >
                                    {processing && (
                                        <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                        </svg>
                                    )}
                                    Simpan & Hantar Kehadiran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                ) : (
                    <div className="flex flex-col items-center justify-center py-24 px-4 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/30 text-center">
                        <div className="w-20 h-20 rounded-3xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-10 w-10 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 className="text-xl font-bold text-slate-900 dark:text-white">Sedia untuk merekod?</h3>
                        <p className="text-slate-500 text-sm mt-2 max-w-sm mx-auto">Sila pilih kelas dan mata pelajaran di atas untuk memaparkan senarai pelajar.</p>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
