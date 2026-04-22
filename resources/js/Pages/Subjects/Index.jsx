import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';
import SearchInput from '@/Components/SearchInput';
import { DataTable, EmptyTableRow, HeaderCell, HeaderRow, Pagination, TableBody, TableCell, TableHead, TableRow } from '@/Components/Table';

export default function Index({ subjects, filters }) {
    const { flash } = usePage().props;
    const [deletingId, setDeletingId] = useState(null);
    const showActions = subjects.data.some((subject) => subject.can?.update || subject.can?.delete);
    const columnCount = showActions ? 3 : 2;

    const handleDelete = (id) => {
        if (confirm('Adakah anda pasti ingin memadam mata pelajaran ini?')) {
            setDeletingId(id);
            router.delete(route('subjects.destroy', id), {
                onFinish: () => setDeletingId(null),
            });
        }
    };

    return (
        <AuthenticatedLayout title="Senarai Mata Pelajaran">
            <Head title="Pengurusan Mata Pelajaran" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pengurusan Mata Pelajaran</h1>
                        <p className="mt-2 text-slate-500 dark:text-slate-400 font-medium">Urus senarai mata pelajaran mengikut kursus kolej.</p>
                    </div>
                    {usePage().props.can?.create && (
                        <Link
                            href={route('subjects.create')}
                            className="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-sm font-bold text-white transition-all shadow-lg shadow-blue-600/20 active:scale-95"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Mata Pelajaran
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
                        <SearchInput routeName="subjects.index" initialValue={filters.search} />
                    </div>
                </div>

                <DataTable minWidth="min-w-[800px]" footer={<Pagination meta={subjects} />}>
                    <TableHead>
                        <HeaderRow>
                            <HeaderCell>Mata Pelajaran</HeaderCell>
                            <HeaderCell>Kursus</HeaderCell>
                            {showActions && <HeaderCell align="right">Tindakan</HeaderCell>}
                        </HeaderRow>
                    </TableHead>
                    <TableBody>
                                {subjects.data.length > 0 ? (
                                    subjects.data.map((subject) => (
                                        <TableRow key={subject.id}>
                                            <TableCell className="font-bold text-slate-900 dark:text-white group-hover:text-[#228260] dark:group-hover:text-[#32BA83] transition-colors">
                                                {subject.name}
                                            </TableCell>
                                            <TableCell>
                                                {subject.course ? (
                                                    <span className="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20">
                                                        {subject.course.name}
                                                    </span>
                                                ) : (
                                                    <span className="text-slate-400 italic text-xs font-medium">Tiada Kursus</span>
                                                )}
                                            </TableCell>
                                            {showActions && (
                                            <TableCell align="right">
                                                <div className="flex items-center justify-end gap-2">
                                                    {subject.can?.update && (
                                                        <Link
                                                            href={route('subjects.edit', subject.id)}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all active:scale-90"
                                                            title="Kemaskini"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                            </svg>
                                                        </Link>
                                                    )}
                                                    {subject.can?.delete && (
                                                        <button
                                                            onClick={() => handleDelete(subject.id)}
                                                            disabled={deletingId === subject.id}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-90 disabled:opacity-50"
                                                            title="Padam"
                                                        >
                                                            {deletingId === subject.id ? (
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
                                        title="Tiada Rekod Mata Pelajaran"
                                        description="Sila laraskan penapis atau carian anda."
                                        icon={<svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                        </svg>}
                                    />
                                )}
                    </TableBody>
                </DataTable>
            </div>
        </AuthenticatedLayout>
    );
}
