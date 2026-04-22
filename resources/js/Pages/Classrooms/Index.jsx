import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';
import SearchInput from '@/Components/SearchInput';
import { DataTable, EmptyTableRow, HeaderCell, HeaderRow, Pagination, TableBody, TableCell, TableHead, TableRow } from '@/Components/Table';

export default function Index({ classrooms, filters }) {
    const { flash } = usePage().props;
    const [deletingId, setDeletingId] = useState(null);
    const showActions = classrooms.data.some((classroom) => classroom.can?.update || classroom.can?.delete);
    const columnCount = showActions ? 5 : 4;

    const handleDelete = (id) => {
        if (confirm('Adakah anda pasti ingin memadam kelas ini?')) {
            setDeletingId(id);
            router.delete(route('classrooms.destroy', id), {
                onFinish: () => setDeletingId(null),
            });
        }
    };

    return (
        <AuthenticatedLayout title="Senarai Kelas">
            <Head title="Pengurusan Kelas" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pengurusan Kelas</h1>
                        <p className="mt-2 text-slate-500 dark:text-slate-400 font-medium">Urus senarai kelas dan pensyarah yang bertanggungjawab.</p>
                    </div>
                    {usePage().props.can?.create && (
                        <Link
                            href={route('classrooms.create')}
                            className="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-sm font-bold text-white transition-all shadow-lg shadow-blue-600/20 active:scale-95"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Kelas
                        </Link>
                    )}
                </div>

                {flash.success && (
                    <div className="flex items-start gap-3 rounded-2xl bg-green-500/10 border border-green-500/20 px-4 py-4 animate-in slide-in-from-top-2 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p className="text-sm text-green-600 dark:text-green-400 font-bold">{flash.success}</p>
                    </div>
                )}

                <div className="flex justify-end">
                    <div className="w-full md:w-80">
                        <SearchInput routeName="classrooms.index" initialValue={filters.search} />
                    </div>
                </div>

                <DataTable minWidth="min-w-[1000px]" footer={<Pagination meta={classrooms} />}>
                    <TableHead>
                        <HeaderRow>
                            <HeaderCell>Nama Kelas</HeaderCell>
                            <HeaderCell>Kursus</HeaderCell>
                            <HeaderCell>Ketua Kelas</HeaderCell>
                            <HeaderCell>Pensyarah</HeaderCell>
                            {showActions && <HeaderCell align="right">Tindakan</HeaderCell>}
                        </HeaderRow>
                    </TableHead>
                    <TableBody>
                                {classrooms.data.length > 0 ? (
                                    classrooms.data.map((classroom) => (
                                        <TableRow key={classroom.id}>
                                            <TableCell className="font-bold text-slate-900 dark:text-white">{classroom.name}</TableCell>
                                            <TableCell>
                                                <span className="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                                                    {classroom.course?.name || '-'}
                                                </span>
                                            </TableCell>
                                            <TableCell>
                                                {classroom.classrep ? (
                                                    <div className="flex items-center gap-3">
                                                        <div className="w-8 h-8 rounded-lg bg-violet-600 flex items-center justify-center text-[10px] font-black text-white shrink-0 shadow-md">
                                                            {classroom.classrep.first_name[0].toUpperCase()}
                                                        </div>
                                                        <span className="text-slate-700 dark:text-slate-300 font-bold">{classroom.classrep.first_name} {classroom.classrep.last_name}</span>
                                                    </div>
                                                ) : (
                                                    <span className="text-slate-400 italic text-xs font-medium">Belum dilantik</span>
                                                )}
                                            </TableCell>
                                            <TableCell>
                                                <div className="flex flex-wrap gap-2">
                                                    {classroom.teachers && classroom.teachers.length > 0 ? (
                                                        classroom.teachers.map((lecturer) => (
                                                            <div key={lecturer.id} className="inline-flex items-center gap-2 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                                <div className="w-5 h-5 rounded-md bg-blue-600 flex items-center justify-center text-[8px] font-black text-white shrink-0 overflow-hidden">
                                                                    {lecturer.picture ? (
                                                                        <img src={lecturer.picture.startsWith('images/') ? `/${lecturer.picture}` : `/storage/${lecturer.picture}`} alt="" className="w-full h-full object-cover" />
                                                                    ) : (
                                                                        lecturer.first_name[0].toUpperCase()
                                                                    )}
                                                                </div>
                                                                {lecturer.first_name}
                                                            </div>
                                                        ))
                                                    ) : (
                                                        <span className="text-slate-400 italic text-xs font-medium">Belum ditetapkan</span>
                                                    )}
                                                </div>
                                            </TableCell>
                                            {showActions && (
                                            <TableCell align="right">
                                                <div className="flex items-center justify-end gap-2">
                                                    {classroom.can?.update && (
                                                        <Link
                                                            href={route('classrooms.edit', classroom.id)}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all active:scale-90"
                                                            title="Kemaskini"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                            </svg>
                                                        </Link>
                                                    )}
                                                    {classroom.can?.delete && (
                                                        <button
                                                            onClick={() => handleDelete(classroom.id)}
                                                            disabled={deletingId === classroom.id}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-90 disabled:opacity-50"
                                                            title="Padam"
                                                        >
                                                            {deletingId === classroom.id ? (
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
                                        title="Tiada Rekod Kelas"
                                        description="Belum ada kelas didaftarkan dalam sistem."
                                        icon={<svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                                        </svg>}
                                    />
                                )}
                    </TableBody>
                </DataTable>
            </div>
        </AuthenticatedLayout>
    );
}
