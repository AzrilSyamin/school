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

export default function Index({ users, filters, roles, courses, classrooms }) {
    const { flash } = usePage().props;
    const [deletingId, setDeletingId] = useState(null);
    const [roleId, setRoleId] = useState(filters.role_id || '');
    const [courseId, setCourseId] = useState(filters.course_id || '');
    const [classroomId, setClassroomId] = useState(filters.classroom_id || '');
    const showActions = users.data.some((user) => user.can?.update || user.can?.delete);
    const columnCount = showActions ? 5 : 4;

    const handleFilter = () => {
        router.get(route('users.index'), {
            search: filters.search,
            role_id: roleId,
            course_id: courseId,
            classroom_id: classroomId
        }, { preserveState: true });
    };

    const handleDelete = (id) => {
        if (confirm('Adakah anda pasti ingin memadam pengguna ini?')) {
            setDeletingId(id);
            router.delete(route('users.destroy', id), {
                onFinish: () => setDeletingId(null),
            });
        }
    };

    return (
        <AuthenticatedLayout title="Pengurusan Pengguna">
            <Head title="Pengurusan Pengguna" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pengurusan Pengguna</h1>
                        <p className="mt-2 text-slate-500 dark:text-slate-400 font-medium">Urus akaun sistem, peranan, dan kebenaran akses.</p>
                    </div>
                    <Link
                        href={route('users.create')}
                        className="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-sm font-bold text-white transition-all shadow-lg shadow-blue-600/20 active:scale-95"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Pengguna
                    </Link>
                </div>

                {flash.success && (
                    <div className="flex items-start gap-3 rounded-2xl bg-green-500/10 border border-green-500/20 px-4 py-4 animate-in slide-in-from-top-2 duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-green-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <p className="text-sm text-green-600 dark:text-green-400 font-bold">{flash.success}</p>
                    </div>
                )}

                {/* Filters */}
                <div className="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6 items-end">
                        <div className="space-y-2">
                            <label className="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1">Carian</label>
                            <SearchInput routeName="users.index" initialValue={filters.search} />
                        </div>
                        <div className="space-y-2">
                            <label className="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1">Peranan</label>
                            <select
                                value={roleId}
                                onChange={(e) => setRoleId(e.target.value)}
                                className="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-2.5 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all"
                            >
                                <option value="">Semua Peranan</option>
                                {roles.map(r => (
                                    <option key={r.id} value={r.id}>{r.name}</option>
                                ))}
                            </select>
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
                                    <option key={c.id} value={c.id}>{c.name}</option>
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

                <DataTable minWidth="min-w-[1000px]" footer={<Pagination meta={users} />}>
                    <TableHead>
                        <HeaderRow>
                            <HeaderCell>Nama Penuh</HeaderCell>
                            <HeaderCell>Username / Email</HeaderCell>
                            <HeaderCell>Peranan</HeaderCell>
                            <HeaderCell>Status</HeaderCell>
                            {showActions && (
                                <HeaderCell align="right">Tindakan</HeaderCell>
                            )}
                        </HeaderRow>
                    </TableHead>
                    <TableBody>
                                {users.data.length > 0 ? (
                                    users.data.map((user) => (
                                <TableRow key={user.id}>
                                    <TableCell>
                                                <div className="flex items-center gap-4">
                                                    <div className="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-bold shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 overflow-hidden">
                                                        {user.picture ? (
                                                            <img src={user.picture.startsWith('images/') ? `/${user.picture}` : `/storage/${user.picture}`} alt="" className="w-full h-full object-cover" />
                                                        ) : (
                                                            (user.first_name || '?')[0].toUpperCase()
                                                        )}
                                                    </div>
                                                    <span className="font-bold text-slate-900 dark:text-white">{user.first_name} {user.last_name}</span>
                                                </div>
                                    </TableCell>
                                    <TableCell>
                                                <div className="flex flex-col">
                                                    <span className="text-slate-900 dark:text-white text-xs font-bold tracking-tight">@{user.username}</span>
                                                    <span className="text-slate-500 text-[11px] font-medium">{user.email}</span>
                                                </div>
                                    </TableCell>
                                    <TableCell>
                                                <span className="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                    {user.role?.name || '-'}
                                                </span>
                                    </TableCell>
                                    <TableCell>
                                                <span className={`inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest ${
                                                    user.is_active ? 'text-green-600 bg-green-50 dark:text-green-400 dark:bg-green-500/10' : 'text-red-600 bg-red-50 dark:text-red-400 dark:bg-red-500/10'
                                                }`}>
                                                    <span className={`w-1.5 h-1.5 rounded-full ${user.is_active ? 'bg-green-500 animate-pulse' : 'bg-red-500'}`} />
                                                    {user.is_active ? 'Aktif' : 'Tidak Aktif'}
                                                </span>
                                    </TableCell>
                                    {showActions && (
                                    <TableCell align="right">
                                                <div className="flex items-center justify-end gap-2">
                                                    {user.can?.update && (
                                                    <Link
                                                        href={route('users.edit', user.id)}
                                                        className="p-2.5 rounded-xl text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all active:scale-90"
                                                        title="Kemaskini"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                            <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                        </svg>
                                                    </Link>
                                                    )}
                                                    {user.can?.delete && (
                                                    <button
                                                        onClick={() => handleDelete(user.id)}
                                                        disabled={deletingId === user.id}
                                                        className="p-2.5 rounded-xl text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-90 disabled:opacity-50"
                                                        title="Padam"
                                                    >
                                                        {deletingId === user.id ? (
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
                                title="Tiada Rekod Pengguna"
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
