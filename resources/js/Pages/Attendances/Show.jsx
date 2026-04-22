import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Show({ attendances, session, can }) {
    const { flash } = usePage().props;

    return (
        <AuthenticatedLayout title="Detail Kehadiran">
            <Head title="Detail Kehadiran" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div className="flex items-center gap-4">
                        <Link
                            href={route('attendances.index')}
                            className="p-2 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white transition-colors border border-slate-200 dark:border-slate-700"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
                            </svg>
                        </Link>
                        <div>
                            <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Detail Kehadiran</h1>
                            <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Senarai kehadiran pelajar bagi sesi ini.</p>
                        </div>
                    </div>
                    
                    <div className="flex items-center gap-3">
                        {can.update && (
                            <Link
                                href={route('attendances.edit', {
                                    subject_id: session.subject?.id,
                                    classroom_id: session.classroom?.id,
                                    date: session.date
                                })}
                                className="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-sm font-semibold text-white transition-colors shadow-lg shadow-blue-500/20"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Kemaskini Kehadiran
                            </Link>
                        )}
                        <button className="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-700 text-sm font-semibold text-slate-900 dark:text-white transition-colors border border-slate-200 dark:border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            PDF
                        </button>
                        <button className="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-700 text-sm font-semibold text-slate-900 dark:text-white transition-colors border border-slate-200 dark:border-slate-700">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            CSV
                        </button>
                    </div>
                </div>

                {/* Session Header */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-5 rounded-2xl shadow-sm">
                        <p className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Mata Pelajaran</p>
                        <p className="text-slate-900 dark:text-white font-semibold">{session.subject?.name}</p>
                        <p className="text-blue-400 text-xs font-bold">{session.subject?.code}</p>
                    </div>
                    <div className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-5 rounded-2xl shadow-sm">
                        <p className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Kelas</p>
                        <p className="text-slate-900 dark:text-white font-semibold">{session.classroom?.name}</p>
                    </div>
                    <div className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-5 rounded-2xl shadow-sm">
                        <p className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tarikh</p>
                        <p className="text-slate-900 dark:text-white font-semibold">
                            {new Date(session.date).toLocaleDateString('ms-MY', { day: '2-digit', month: 'long', year: 'numeric' })}
                        </p>
                    </div>
                    <div className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 p-5 rounded-2xl shadow-sm">
                        <p className="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Direkod Oleh</p>
                        <p className="text-slate-900 dark:text-white font-semibold">{session.recorder?.first_name} {session.recorder?.last_name}</p>
                    </div>
                </div>

                {/* Attendance List */}
                <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-sm">
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm text-left">
                            <thead className="bg-slate-50 dark:bg-slate-800/50">
                                <tr>
                                    <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs">Pelajar</th>
                                    <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs text-center">Status</th>
                                    <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs">Nota / Remarks</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-200 dark:divide-slate-800">
                                {attendances.map((attendance) => (
                                    <tr key={attendance.id} className="hover:bg-slate-50 dark:hover:bg-slate-800/50 dark:hover:bg-slate-800/30 transition-colors">
                                        <td className="px-6 py-4">
                                            <div className="font-medium text-slate-900 dark:text-white">{attendance.student?.name}</div>
                                            <div className="text-[10px] text-slate-500 uppercase font-bold tracking-tight">{attendance.student?.student_id || 'ID Pelajar'}</div>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <span className={`inline-flex px-3 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider ${
                                                attendance.status === 'Hadir' ? 'bg-green-500/10 text-green-400 border border-green-500/20' :
                                                attendance.status === 'Ponteng' ? 'bg-red-500/10 text-red-400 border border-red-500/20' :
                                                'bg-amber-500/10 text-amber-400 border border-amber-500/20'
                                            }`}>
                                                {attendance.status}
                                            </span>
                                        </td>
                                        <td className="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                                            {attendance.remarks || <span className="text-slate-400 dark:text-slate-600 italic">Tiada nota</span>}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
