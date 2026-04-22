import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage, router } from '@inertiajs/react';
import { useState } from 'react';
import SearchInput from '@/Components/SearchInput';
import Modal from '@/Components/Modal';
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

export default function Index({ lecturers, filters, courses, classrooms }) {
    const { flash } = usePage().props;
    const [deletingId, setDeletingId] = useState(null);
    const [selectedLecturer, setSelectedLecturer] = useState(null);
    const [courseId, setCourseId] = useState(filters.course_id || '');
    const [classroomId, setClassroomId] = useState(filters.classroom_id || '');

    const handleFilter = () => {
        router.get(route('lecturers.index'), {
            search: filters.search,
            course_id: courseId,
            classroom_id: classroomId
        }, { preserveState: true });
    };

    const handleDelete = (id) => {
        if (confirm('Adakah anda pasti ingin memadam rekod pensyarah ini?')) {
            setDeletingId(id);
            router.delete(route('lecturers.destroy', id), {
                onFinish: () => setDeletingId(null),
            });
        }
    };

    const getLecturerCourses = (lecturer) => {
        const managed = (lecturer.managed_courses || []).map(c => ({ name: c.name, type: 'Manager' }));
        const teaching = (lecturer.teaching_classrooms || []).map(tc => ({ name: tc.course?.name, type: 'Teaching' }));
        
        // Merge and unique by course name
        const all = [...managed, ...teaching];
        const unique = Array.from(new Set(all.map(a => a.name))).map(name => {
            return all.find(a => a.name === name);
        });
        
        return unique;
    };

    return (
        <AuthenticatedLayout title="Senarai Pensyarah">
            <Head title="Pengurusan Pensyarah" />

            <div className="space-y-6">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                    <div>
                        <h1 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">Pengurusan Pensyarah</h1>
                        <p className="mt-2 text-slate-500 dark:text-slate-400 font-medium">Daftar dan urus maklumat pensyarah kolej anda.</p>
                    </div>
                    <Link
                        href={route('lecturers.create')}
                        className="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-sm font-bold text-white transition-all shadow-lg shadow-blue-600/20 active:scale-95"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2.5}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Daftar Pensyarah
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

                <div className="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm">
                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 items-end">
                        <div className="space-y-2">
                            <label className="block text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-1">Carian</label>
                            <SearchInput routeName="lecturers.index" initialValue={filters.search} />
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

                <DataTable minWidth="min-w-[900px]" footer={<Pagination meta={lecturers} />}>
                    <TableHead>
                        <HeaderRow>
                            <HeaderCell>Nama Pensyarah</HeaderCell>
                            <HeaderCell>Username</HeaderCell>
                            <HeaderCell>Kursus Terlibat</HeaderCell>
                            <HeaderCell align="right">Tindakan</HeaderCell>
                        </HeaderRow>
                    </TableHead>
                    <TableBody>
                                {lecturers.data.length > 0 ? (
                                    lecturers.data.map((lecturer) => {
                                        const lecturerCourses = getLecturerCourses(lecturer);
                                        return (
                                    <TableRow key={lecturer.id}>
                                        <TableCell>
                                                    <div className="flex items-center gap-4">
                                                        <div className="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-700 dark:text-slate-300 font-bold shadow-inner group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 overflow-hidden">
                                                            {lecturer.picture ? (
                                                                <img src={lecturer.picture.startsWith('images/') ? `/${lecturer.picture}` : `/storage/${lecturer.picture}`} alt="" className="w-full h-full object-cover" />
                                                            ) : (
                                                                (lecturer.first_name || '?')[0].toUpperCase()
                                                            )}
                                                        </div>
                                                        <div>
                                                            <div className="font-bold text-slate-900 dark:text-white">{lecturer.first_name} {lecturer.last_name}</div>
                                                            <div className="text-[10px] text-slate-400 dark:text-slate-500 uppercase font-black tracking-widest">{lecturer.gender || 'N/A'}</div>
                                                        </div>
                                                    </div>
                                        </TableCell>
                                        <TableCell>
                                                    <span className="font-mono text-xs font-bold px-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                        @{lecturer.username}
                                                    </span>
                                        </TableCell>
                                        <TableCell>
                                                    <div className="flex flex-wrap gap-1.5">
                                                        {lecturerCourses.length > 0 ? lecturerCourses.map((c, i) => (
                                                            <span key={i} className={`px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider border ${
                                                                c.type === 'Manager' ? 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-500/20' : 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-500/20'
                                                            }`}>
                                                                {c.name}
                                                            </span>
                                                        )) : <span className="text-slate-400 italic text-xs font-medium">Tiada Kursus</span>}
                                                    </div>
                                        </TableCell>
                                        <TableCell align="right">
                                                    <div className="flex items-center justify-end gap-2">
                                                        <button
                                                            onClick={() => setSelectedLecturer(lecturer)}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-all active:scale-90"
                                                            title="Lihat Detail"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                            </svg>
                                                        </button>
                                                        <Link
                                                            href={route('lecturers.edit', lecturer.id)}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-all active:scale-90"
                                                            title="Kemaskini"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                                                <path strokeLinecap="round" strokeLinejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                            </svg>
                                                        </Link>
                                                        <button
                                                            onClick={() => handleDelete(lecturer.id)}
                                                            disabled={deletingId === lecturer.id}
                                                            className="p-2.5 rounded-xl text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-90 disabled:opacity-50"
                                                            title="Padam"
                                                        >
                                                            {deletingId === lecturer.id ? (
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
                                                    </div>
                                        </TableCell>
                                    </TableRow>
                                        );
                                    })
                                ) : (
                            <EmptyTableRow
                                colSpan={4}
                                title="Tiada Rekod Pensyarah"
                                description="Sila laraskan penapis atau carian anda."
                                icon={
                                                    <svg xmlns="http://www.w3.org/2000/svg" className="h-8 w-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={1.5}>
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a5.946 5.946 0 0 0-.942 3.197M12 10.5a3.375 3.375 0 1 0 0-6.75 3.375 3.375 0 0 0 0 6.75ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                }
                            />
                                )}
                    </TableBody>
                </DataTable>
            </div>

            {/* Detail Modal */}
            <Modal show={!!selectedLecturer} onClose={() => setSelectedLecturer(null)} maxWidth="2xl">
                {selectedLecturer && (
                    <div className="p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden relative">
                        <button 
                            onClick={() => setSelectedLecturer(null)}
                            className="absolute top-6 right-6 text-slate-500 hover:text-slate-900 dark:text-white transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div className="flex flex-col items-center sm:items-start sm:flex-row gap-8">
                            <div className="w-32 h-32 rounded-3xl bg-blue-600 flex items-center justify-center text-3xl font-bold text-white shadow-2xl overflow-hidden border-4 border-slate-200 dark:border-slate-200 dark:border-slate-800 shrink-0">
                                {selectedLecturer.picture ? (
                                    <img src={selectedLecturer.picture.startsWith('images/') ? `/${selectedLecturer.picture}` : `/storage/${selectedLecturer.picture}`} alt="" className="w-full h-full object-cover" />
                                ) : (
                                    (selectedLecturer.first_name || '?')[0].toUpperCase()
                                )}
                            </div>
                            
                            <div className="flex-1 text-center sm:text-left">
                                <h2 className="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{selectedLecturer.first_name} {selectedLecturer.last_name}</h2>
                                <p className="text-blue-400 font-medium mt-1">Pensyarah Akademik</p>
                                
                                <div className="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div className="space-y-1">
                                        <label className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Username</label>
                                        <p className="text-slate-200">@{selectedLecturer.username}</p>
                                    </div>
                                    <div className="space-y-1">
                                        <label className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Email Rasmi</label>
                                        <p className="text-slate-200">{selectedLecturer.email}</p>
                                    </div>
                                    <div className="space-y-1">
                                        <label className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">No. Telefon</label>
                                        <p className="text-slate-200">{selectedLecturer.phone_number || '-'}</p>
                                    </div>
                                    <div className="space-y-1">
                                        <label className="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Jantina / Umur</label>
                                        <p className="text-slate-200">{selectedLecturer.gender || '-'} ({selectedLecturer.age || '-'} Tahun)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="mt-10 pt-8 border-t border-slate-200 dark:border-slate-200 dark:border-slate-800">
                            <h3 className="text-lg font-bold text-slate-900 dark:text-white mb-4">Penglibatan Kursus & Kelas</h3>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                {getLecturerCourses(selectedLecturer).map((c, i) => (
                                    <div key={i} className="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50">
                                        <div className={`w-2 h-2 rounded-full ${c.type === 'Manager' ? 'bg-indigo-500' : 'bg-blue-500'}`} />
                                        <div>
                                            <div className="text-sm font-semibold text-slate-900 dark:text-white">{c.name}</div>
                                            <div className="text-[10px] text-slate-500 font-bold uppercase">{c.type === 'Manager' ? 'Ketua Kursus' : 'Pengajar'}</div>
                                        </div>
                                    </div>
                                ))}
                                {getLecturerCourses(selectedLecturer).length === 0 && (
                                    <div className="col-span-2 py-8 text-center bg-slate-800/30 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                                        <p className="text-sm text-slate-500">Tiada rekod kursus atau kelas ditemui.</p>
                                    </div>
                                )}
                            </div>
                        </div>

                        {selectedLecturer.address && (
                            <div className="mt-8 pt-8 border-t border-slate-200 dark:border-slate-200 dark:border-slate-800">
                                <label className="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Alamat Kediaman</label>
                                <p className="text-sm text-slate-700 dark:text-slate-300 leading-relaxed bg-slate-800/30 p-4 rounded-xl border border-slate-200 dark:border-slate-700/50">
                                    {selectedLecturer.address}
                                </p>
                            </div>
                        )}
                    </div>
                )}
            </Modal>
        </AuthenticatedLayout>
    );
}
