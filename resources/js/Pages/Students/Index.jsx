import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';
import SearchInput from '@/Components/SearchInput';
import {
    DataTable,
    EmptyTableRow,
    HeaderCell,
    HeaderRow,
    Pagination,
    TableBody,
    TableCell,
    TableHead,
    TableRow,
} from '@/Components/Table';

export default function Index({ students, filters, classrooms, courses }) {
    const { auth, flash } = usePage().props;
    const [deletingId, setDeletingId] = useState(null);
    const [classroomId, setClassroomId] = useState(filters.classroom_id || '');
    const [courseId, setCourseId] = useState(filters.course_id || '');
    const showActions = students.data.some((student) => student.can?.update || student.can?.delete);
    const columnCount = showActions ? 5 : 4;

    const handleFilter = () => {
        router.get(route('students.index'), {
            search: filters.search,
            classroom_id: classroomId,
            course_id: courseId
        }, { preserveState: true });
    };

    const handleDelete = (id) => {
        if (confirm('Adakah anda pasti ingin memadam rekod pelajar ini?')) {
            setDeletingId(id);
            router.delete(route('students.destroy', id), {
                onFinish: () => setDeletingId(null),
            });
        }
    };

    const canCreate = usePage().props.can?.create;

    return (
        <AuthenticatedLayout title="Senarai Pelajar">
            <Head title="Pengurusan Pelajar" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Pengurusan Pelajar</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Lihat dan urus semua rekod pelajar berdaftar.</p>
                    </div>
                    {canCreate && (
                        <Link
                            href={route('students.create')}
                            className="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-sm font-semibold text-white transition-colors shadow-lg shadow-blue-500/20"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Pelajar
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
                <div className="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 sm:p-6 shadow-sm">
                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 items-end">
                        <div className="space-y-2">
                            <label className="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1">Carian</label>
                            <SearchInput routeName="students.index" initialValue={filters.search} />
                        </div>
                        <div className="space-y-2">
                            <label className="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1">Kursus</label>
                            <select
                                value={courseId}
                                onChange={(e) => setCourseId(e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            >
                                <option value="">Semua Kursus</option>
                                {courses.map(c => (
                                    <option key={c.id} value={c.id}>{c.name}</option>
                                ))}
                            </select>
                        </div>
                        <div className="space-y-2">
                            <label className="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1">Kelas</label>
                            <select
                                value={classroomId}
                                onChange={(e) => setClassroomId(e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            >
                                <option value="">Semua Kelas</option>
                                {classrooms.map(c => (
                                    <option key={c.id} value={c.id}>{c.name} ({c.course?.code})</option>
                                ))}
                            </select>
                        </div>
                        <button
                            onClick={handleFilter}
                            className="w-full sm:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-sm font-bold transition-all shadow-lg shadow-blue-600/20 active:scale-95 flex items-center justify-center gap-2"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                            </svg>
                            Tapis
                        </button>
                    </div>
                </div>

                <DataTable minWidth="min-w-[900px]" footer={<Pagination meta={students} />}>
                    <TableHead>
                        <HeaderRow>
                            <HeaderCell>Nama Pelajar</HeaderCell>
                            <HeaderCell>Student ID</HeaderCell>
                            <HeaderCell>Maklumat</HeaderCell>
                            <HeaderCell>Kelas & Kursus</HeaderCell>
                                    {showActions && (
                                <HeaderCell align="right">Tindakan</HeaderCell>
                                    )}
                        </HeaderRow>
                    </TableHead>
                    <TableBody>
                                {students.data.length > 0 ? (
                                    students.data.map((student) => (
                                <TableRow key={student.id}>
                                    <TableCell>
                                                <div className="flex items-center gap-4">
                                                    <div className="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-bold shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                                        {student.name ? student.name[0].toUpperCase() : '?'}
                                                    </div>
                                                    <span className="font-bold text-slate-900 dark:text-white">{student.name}</span>
                                                </div>
                                    </TableCell>
                                    <TableCell>
                                                <span className="font-mono text-xs font-bold px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                    {student.student_id}
                                                </span>
                                    </TableCell>
                                    <TableCell>
                                                <div className="flex flex-col gap-1.5">
                                                    <span className="text-slate-700 dark:text-slate-300 font-bold">{student.age || '-'} Tahun</span>
                                                    <span className={`inline-flex w-fit px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider ${
                                                        student.gender === 'Lelaki' ? 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400' : 'bg-pink-100 text-pink-700 dark:bg-pink-500/10 dark:text-pink-400'
                                                    }`}>
                                                        {student.gender || '-'}
                                                    </span>
                                                </div>
                                    </TableCell>
                                    <TableCell>
                                                {student.classroom ? (
                                                    <div className="flex flex-col gap-1">
                                                        <span className="text-slate-800 dark:text-slate-200 font-bold">{student.classroom.name}</span>
                                                        <span className="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-tight">{student.classroom.course?.name}</span>
                                                    </div>
                                                ) : (
                                                    <span className="text-slate-400 italic text-xs font-medium">Tiada Kelas</span>
                                                )}
                                    </TableCell>
                                            {showActions && (
                                        <TableCell align="right">
                                                 <div className="flex items-center justify-end gap-2">
                                                             {student.can?.update && (
                                                                 <Link
                                                                     href={route('students.edit', student.id)}
                                                                     className="p-2.5 rounded-xl text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all active:scale-90"
                                                                     title="Kemaskini"
                                                                 >
                                                                     <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                         <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                                     </svg>
                                                                 </Link>
                                                             )}
                                                             {student.can?.delete && (
                                                                 <button
                                                                     onClick={() => handleDelete(student.id)}
                                                                     disabled={deletingId === student.id}
                                                                     className="p-2.5 rounded-xl text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-90 disabled:opacity-50"
                                                                     title="Padam"
                                                                 >
                                                                     {deletingId === student.id ? (
                                                                         <svg className="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                             <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                                                             <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                                                         </svg>
                                                                     ) : (
                                                                         <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                             <path strokeLinecap="round" strokeLinejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                         </svg>
                                                                     )}
                                                                 </button>
                                                             )}
                                                 </div>
                                        </TableCell>
                                            )}
                                </TableRow>
                                    ))
                                ) : (
                            <EmptyTableRow
                                colSpan={columnCount}
                                title="Tiada Rekod Pelajar"
                                description="Sila laraskan penapis atau carian anda."
                                icon={
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                    </svg>
                                }
                            />
                                )}
                    </TableBody>
                </DataTable>
            </div>
        </AuthenticatedLayout>
    );
}
