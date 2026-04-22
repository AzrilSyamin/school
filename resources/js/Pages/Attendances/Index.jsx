import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useEffect, useMemo, useState } from 'react';
import { DataTable, HeaderCell, HeaderRow, TableBody, TableCell, TableHead, TableRow } from '@/Components/Table';

export default function Index({ sessions, classrooms = [], subjects = [], courses = [], filters }) {
    const { flash, auth } = usePage().props;
    const canFilterByCourse = ['admin', 'moderator'].includes(auth.user?.role);
    const [date, setDate] = useState(filters.date || '');
    const [courseId, setCourseId] = useState(filters.course_id || '');
    const [classroomId, setClassroomId] = useState(filters.classroom_id || '');
    const [subjectId, setSubjectId] = useState(filters.subject_id || '');

    const filteredClassrooms = useMemo(() => {
        if (!canFilterByCourse || !courseId) {
            return classrooms;
        }

        return classrooms.filter((classroom) => String(classroom.course_id) === String(courseId));
    }, [canFilterByCourse, classrooms, courseId]);

    const filteredSubjects = useMemo(() => {
        if (!canFilterByCourse || !courseId) {
            return subjects;
        }

        return subjects.filter((subject) => String(subject.course_id) === String(courseId));
    }, [canFilterByCourse, courseId, subjects]);

    useEffect(() => {
        if (!courseId) {
            return;
        }

        if (classroomId && !filteredClassrooms.some((classroom) => String(classroom.id) === String(classroomId))) {
            setClassroomId('');
        }

        if (subjectId && !filteredSubjects.some((subject) => String(subject.id) === String(subjectId))) {
            setSubjectId('');
        }
    }, [classroomId, courseId, filteredClassrooms, filteredSubjects, subjectId]);

    const handleFilter = () => {
        router.get(route('attendances.index'), {
            date: date,
            course_id: canFilterByCourse ? courseId : undefined,
            classroom_id: classroomId,
            subject_id: subjectId
        }, { preserveState: true });
    };

    return (
        <AuthenticatedLayout title="Rekod Kehadiran">
            <Head title="Pengurusan Kehadiran" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Rekod Kehadiran</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Senarai sesi kehadiran pelajar mengikut mata pelajaran dan kelas.</p>
                    </div>
                    {usePage().props.can?.create && (
                        <Link
                            href={route('attendances.create')}
                            className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-sm font-semibold text-white transition-colors shadow-lg shadow-blue-500/20"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Ambil Kehadiran
                        </Link>
                    )}
                </div>

                {flash.success && (
                    <div className="flex items-start gap-3 rounded-xl bg-green-500/10 border border-green-500/20 px-4 py-3">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-green-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p className="text-sm text-green-400">{flash.success}</p>
                    </div>
                )}

                {/* Filters */}
                <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-sm">
                    <div className={`grid grid-cols-1 md:grid-cols-2 ${canFilterByCourse ? 'xl:grid-cols-5' : 'xl:grid-cols-4'} gap-4 items-end`}>
                        <div>
                            <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Tarikh</label>
                            <input
                                type="date"
                                value={date}
                                onChange={(e) => setDate(e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            />
                        </div>
                        {canFilterByCourse && (
                            <div>
                                <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kursus</label>
                                <select
                                    value={courseId}
                                    onChange={(e) => setCourseId(e.target.value)}
                                    className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                                >
                                    <option value="">Semua Kursus</option>
                                    {courses.map((course) => (
                                        <option key={course.id} value={course.id}>{course.name}</option>
                                    ))}
                                </select>
                            </div>
                        )}
                        <div>
                            <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kelas</label>
                            <select
                                value={classroomId}
                                onChange={(e) => setClassroomId(e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            >
                                <option value="">Semua Kelas</option>
                                {filteredClassrooms.map((classroom) => (
                                    <option key={classroom.id} value={classroom.id}>{classroom.name}</option>
                                ))}
                            </select>
                        </div>
                        <div>
                            <label className="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                            <select
                                value={subjectId}
                                onChange={(e) => setSubjectId(e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            >
                                <option value="">Semua Subjek</option>
                                {filteredSubjects.map((subject) => (
                                    <option key={subject.id} value={subject.id}>{subject.name}</option>
                                ))}
                            </select>
                        </div>
                        <button
                            onClick={handleFilter}
                            className="w-full px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-sm font-semibold transition-all shadow-lg shadow-blue-500/20"
                        >
                            Tapis
                        </button>
                    </div>
                </div>

                {sessions.data && sessions.data.length > 0 ? (
                    <DataTable minWidth="min-w-[1000px]">
                        <TableHead>
                            <HeaderRow>
                                <HeaderCell>Mata Pelajaran</HeaderCell>
                                <HeaderCell align="center">Kelas</HeaderCell>
                                <HeaderCell align="center">Tarikh</HeaderCell>
                                <HeaderCell>Direkod Oleh</HeaderCell>
                                <HeaderCell align="right">Tindakan</HeaderCell>
                            </HeaderRow>
                        </TableHead>
                        <TableBody>
                                    {sessions.data.map((session, index) => (
                                        <TableRow key={index}>
                                            <TableCell>
                                                <div className="font-semibold text-slate-900 dark:text-white">{session.subject?.name}</div>
                                                <div className="text-[10px] text-slate-500 font-bold uppercase tracking-tight">{session.subject?.code}</div>
                                            </TableCell>
                                            <TableCell align="center">
                                                <span className="px-3 py-1 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs font-bold border border-indigo-500/20">
                                                    {session.classroom?.name}
                                                </span>
                                            </TableCell>
                                            <TableCell align="center" className="text-slate-700 dark:text-slate-300 font-medium whitespace-nowrap">
                                                {new Date(session.date).toLocaleDateString('ms-MY', { day: '2-digit', month: 'short', year: 'numeric' })}
                                            </TableCell>
                                            <TableCell>
                                                 <div className="flex flex-col">
                                                     <span className="text-slate-900 dark:text-white text-xs font-semibold">
                                                         {session.recorder?.first_name} {session.recorder?.last_name}
                                                     </span>
                                                     <span className="text-[10px] text-slate-500 uppercase tracking-tighter">
                                                         {session.recorder?.role?.name}
                                                     </span>
                                                 </div>
                                             </TableCell>
                                             <TableCell align="right">
                                                 <div className="flex items-center justify-end gap-2">
                                                     {session.can?.update && (
                                                         <Link
                                                             href={route('attendances.edit', { 
                                                                 subject_id: session.subject_id, 
                                                                 classroom_id: session.classroom_id, 
                                                                 date: session.date 
                                                             })}
                                                             className="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:text-blue-400 hover:bg-blue-500/10 transition-colors"
                                                             title="Kemaskini"
                                                         >
                                                             <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                                                 <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                             </svg>
                                                         </Link>
                                                     )}
                                                     <Link
                                                         href={route('attendances.show', { 
                                                             subject_id: session.subject_id, 
                                                             classroom_id: session.classroom_id, 
                                                             date: session.date 
                                                         })}
                                                         className="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 transition-colors"
                                                         title="Lihat Detail"
                                                     >
                                                         <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                                             <path strokeLinecap="round" strokeLinejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                             <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                         </svg>
                                                     </Link>
                                                     
                                                     {/* Export buttons */}
                                                     <div className="flex gap-1 ml-2 pl-2 border-l border-slate-200 dark:border-slate-200 dark:border-slate-800">
                                                        <button 
                                                            className="p-1.5 rounded-md text-slate-500 hover:text-red-400 hover:bg-red-500/10 transition-colors"
                                                            title="Download PDF"
                                                            onClick={() => alert('Fungsi muat turun PDF akan datang')}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                            </svg>
                                                        </button>
                                                        <button 
                                                            className="p-1.5 rounded-md text-slate-500 hover:text-green-400 hover:bg-green-500/10 transition-colors"
                                                            title="Download CSV/Excel"
                                                            onClick={() => alert('Fungsi muat turun CSV akan datang')}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125V3.375m1.125 16.25h17.25m-17.25 0a1.125 1.125 0 0 0 1.125 1.125m16.125-1.125v-11.25a3.375 3.375 0 0 0-3.375-3.375H8.25m12 12.375H3.75" />
                                                            </svg>
                                                        </button>
                                                     </div>
                                                </div>
                                            </TableCell>
                                        </TableRow>
                                    ))}
                        </TableBody>
                    </DataTable>
                ) : (
                    <div className="flex flex-col items-center justify-center py-20 px-4 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-center">
                        <div className="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-slate-400 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={1.5} d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h3 className="text-lg font-semibold text-slate-900 dark:text-white">Tiada Sesi Kehadiran</h3>
                        <p className="text-slate-500 text-sm mt-1 max-w-xs mx-auto">Sila pilih tarikh, kelas atau mata pelajaran lain untuk melihat rekod.</p>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
