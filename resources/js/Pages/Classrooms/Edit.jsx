import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import { useState, useEffect } from 'react';

const inputClass = "w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 dark:bg-slate-800/60 py-2.5 px-4 text-sm text-slate-900 dark:text-white placeholder-slate-500 outline-none transition-all duration-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20";
const labelClass = "block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5";

export default function Edit({ classroom, lecturers, courses, subjects, subjectAssignments, eligibleStudents, currentClassrepEmail }) {
    const [showEmailModal, setShowEmailModal] = useState(false);
    const [tempEmail, setTempEmail] = useState('');
    const [selectedStudent, setSelectedStudent] = useState(null);

    const { data, setData, put, processing, errors } = useForm({
        name: classroom.name,
        course_id: classroom.course_id || '',
        subject_assignments: subjectAssignments || {},
        classrep_email: currentClassrepEmail || '',
        classrep_id: classroom.classrep?.student_id_link || '', // We'll need to ensure we have this or just find by email
    });

    // Let's refine the initial classrep_id based on currentClassrepEmail
    useEffect(() => {
        if (currentClassrepEmail) {
            const currentStudent = eligibleStudents.find(s => s.email === currentClassrepEmail);
            if (currentStudent) {
                setData('classrep_id', currentStudent.id);
            }
        }
    }, [currentClassrepEmail, eligibleStudents]);

    const handleClassrepChange = (id) => {
        const student = eligibleStudents.find(s => s.id == id);
        
        if (!id) {
            setData({
                ...data,
                classrep_email: '',
                classrep_id: '',
            });
            return;
        }

        if (student && !student.email) {
            // Student exists but has no email, show modal
            setSelectedStudent(student);
            setShowEmailModal(true);
            // We set the ID first so the dropdown "sticks"
            setData('classrep_id', id);
        } else if (student) {
            // Student has email, use it directly
            setData({
                ...data,
                classrep_email: student.email,
                classrep_id: student.id,
            });
        }
    };

    const confirmEmail = () => {
        if (tempEmail && selectedStudent) {
            setData({
                ...data,
                classrep_email: tempEmail,
                classrep_id: selectedStudent.id,
            });
            setShowEmailModal(false);
            setTempEmail('');
        }
    };

    const handleAssignmentChange = (subjectId, lecturerId) => {
        setData('subject_assignments', {
            ...data.subject_assignments,
            [subjectId]: lecturerId
        });
    };

    const submit = (e) => {
        e.preventDefault();
        put(route('classrooms.update', classroom.id));
    };

    return (
        <AuthenticatedLayout title="Kemaskini Kelas">
            <Head title="Kemaskini Kelas" />

            <div className="max-w-4xl space-y-6">
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
                        <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Kemaskini Rekod Kelas</h1>
                        <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Edit maklumat kelas dan tetapkan pensyarah mengikut mata pelajaran.</p>
                    </div>
                </div>

                <div className="rounded-2xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-xl">
                    <form onSubmit={submit} className="divide-y divide-slate-200 dark:divide-slate-800">
                        <div className="p-6 space-y-6">
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label htmlFor="name" className={labelClass}>Nama Kelas</label>
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

                                <div>
                                    <label htmlFor="classrep_id" className={labelClass}>Ketua Kelas (Classrep)</label>
                                    <select
                                        id="classrep_id"
                                        value={data.classrep_id}
                                        onChange={(e) => handleClassrepChange(e.target.value)}
                                        className={inputClass}
                                    >
                                        <option value="">-- Belum Dilantik --</option>
                                        {eligibleStudents && eligibleStudents.map((student) => (
                                            <option key={student.id} value={student.id}>
                                                {student.name} {student.email ? `(${student.email})` : '(Perlu Emel)'}
                                            </option>
                                        ))}
                                    </select>
                                    <p className="mt-1.5 text-[10px] text-slate-500 italic">Sistem akan melantik pelajar ini secara automatik jika mereka mempunyai akaun sistem.</p>
                                    <InputError message={errors.classrep_email} className="mt-1.5 text-xs text-red-400" />
                                </div>
                            </div>
                        </div>

                        {/* Modal Input Emel */}
                        {showEmailModal && (
                            <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                                <div className="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-200 dark:border-slate-800 rounded-2xl w-full max-w-md shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                                    <div className="p-6 border-b border-slate-200 dark:border-slate-200 dark:border-slate-800">
                                        <h3 className="text-xl font-bold text-slate-900 dark:text-white">Masukkan Emel Pelajar</h3>
                                        <p className="text-sm text-slate-500 dark:text-slate-400 mt-1">Sila masukkan emel untuk <b>{selectedStudent?.name}</b> bagi melengkapkan pelantikan Ketua Kelas.</p>
                                    </div>
                                    <div className="p-6">
                                        <label className={labelClass}>Emel Pelajar</label>
                                        <input
                                            type="email"
                                            value={tempEmail}
                                            onChange={(e) => setTempEmail(e.target.value)}
                                            onKeyDown={(e) => {
                                                if (e.key === 'Enter') {
                                                    e.preventDefault();
                                                    confirmEmail();
                                                }
                                            }}
                                            placeholder="contoh: pelajar@email.com"
                                            className={inputClass}
                                            autoFocus
                                        />
                                        <p className="mt-2 text-[11px] text-slate-500 italic">Akaun User akan dicipta secara automatik menggunakan emel ini.</p>
                                    </div>
                                    <div className="p-6 bg-white dark:bg-white/50 dark:bg-slate-900/50 flex justify-end gap-3">
                                        <button
                                            type="button"
                                            onClick={() => {
                                                setShowEmailModal(false);
                                                setTempEmail('');
                                                setData('classrep_email', currentClassrepEmail || '');
                                            }}
                                            className="px-4 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white transition-colors"
                                        >
                                            Batal
                                        </button>
                                        <button
                                            type="button"
                                            onClick={confirmEmail}
                                            disabled={!tempEmail || !tempEmail.includes('@')}
                                            className="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-sm font-semibold text-white transition-colors shadow-lg shadow-blue-500/20 disabled:opacity-50"
                                        >
                                            Sahkan & Lantik
                                        </button>
                                    </div>
                                </div>
                            </div>
                        )}

                        <div className="p-6">
                            <div className="mb-4">
                                <h3 className="text-lg font-semibold text-slate-900 dark:text-white">Tugasan Mata Pelajaran</h3>
                                <p className="text-sm text-slate-500">Pilih pensyarah bagi setiap mata pelajaran dalam kelas ini.</p>
                            </div>

                            <div className="rounded-xl border border-slate-200 dark:border-slate-200 dark:border-slate-800 overflow-hidden bg-slate-50 dark:bg-slate-950/50">
                                <table className="w-full text-sm text-left">
                                    <thead className="bg-slate-50 dark:bg-slate-800/50">
                                        <tr>
                                            <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs">Mata Pelajaran</th>
                                            <th className="px-6 py-4 font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-xs">Pensyarah</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-slate-200 dark:divide-slate-800">
                                        {subjects.length > 0 ? (
                                            subjects.map((subject) => (
                                                <tr key={subject.id}>
                                                    <td className="px-6 py-4">
                                                        <div className="font-medium text-slate-900 dark:text-white">{subject.name}</div>
                                                        <div className="text-xs text-slate-500 font-bold uppercase tracking-tight">{subject.code || 'CODE'}</div>
                                                    </td>
                                                    <td className="px-6 py-4">
                                                        <select
                                                            value={data.subject_assignments[subject.id] || ''}
                                                            onChange={(e) => handleAssignmentChange(subject.id, e.target.value)}
                                                            className="w-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-900 dark:text-white outline-none focus:border-blue-500 transition-colors"
                                                        >
                                                            <option value="">-- Tiada Pensyarah --</option>
                                                            {lecturers.map((lecturer) => (
                                                                <option key={lecturer.id} value={lecturer.id}>
                                                                    {lecturer.first_name} {lecturer.last_name}
                                                                </option>
                                                            ))}
                                                        </select>
                                                    </td>
                                                </tr>
                                            ))
                                        ) : (
                                            <tr>
                                                <td colSpan="2" className="px-6 py-8 text-center text-slate-500 italic">
                                                    Tiada mata pelajaran dijumpai untuk kursus ini.
                                                </td>
                                            </tr>
                                        )}
                                    </tbody>
                                </table>
                            </div>
                            <InputError message={errors.subject_assignments} className="mt-2 text-xs text-red-400" />
                        </div>

                        <div className="p-6 bg-white dark:bg-white/50 dark:bg-slate-900/50 flex items-center justify-end gap-3">
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
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
