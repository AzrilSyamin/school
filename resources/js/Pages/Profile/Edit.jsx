import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';

export default function Edit({ mustVerifyEmail, status }) {
    const { auth } = usePage().props;
    const user = auth.user;
    const initials = [user.first_name, user.last_name]
        .filter(Boolean)
        .map((n) => n[0])
        .join('')
        .toUpperCase() || user.email[0].toUpperCase();

    return (
        <AuthenticatedLayout title="Profil Saya">
            <Head title="Profil" />

            <div className="space-y-6 max-w-3xl">
                {/* Page Header */}
                <div>
                    <h1 className="text-2xl font-bold text-slate-900 dark:text-white">Profil Saya</h1>
                    <p className="mt-1 text-sm text-slate-500 dark:text-slate-400">Urus maklumat akaun dan tetapan keselamatan anda.</p>
                </div>

                {/* Profile Avatar Card */}
                <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 flex items-center gap-5 shadow-sm">
                    <div className="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-600 flex items-center justify-center text-white text-2xl font-bold shrink-0 overflow-hidden shadow-lg shadow-blue-500/20">
                        {user.picture ? (
                            <img 
                                src={user.picture === 'default.jpg' || user.picture.startsWith('images/') 
                                    ? `/${user.picture === 'default.jpg' ? 'images/default.jpg' : user.picture}` 
                                    : `/storage/${user.picture}`} 
                                alt="" 
                                className="w-full h-full object-cover" 
                            />
                        ) : (
                            initials
                        )}
                    </div>
                    <div>
                        <p className="text-lg font-semibold text-slate-900 dark:text-white">
                            {user.first_name
                                ? `${user.first_name} ${user.last_name ?? ''}`.trim()
                                : '—'}
                        </p>
                        <p className="text-sm text-slate-500 dark:text-slate-400">{user.email}</p>
                        {user.role && (
                            <span className="mt-1.5 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                {user.role}
                            </span>
                        )}
                    </div>
                </div>

                {/* Update Profile Info */}
                <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-sm">
                    <div className="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                        <h2 className="text-base font-semibold text-slate-900 dark:text-white">Maklumat Profil</h2>
                        <p className="text-xs text-slate-500 mt-0.5">Kemaskini nama dan alamat email akaun anda.</p>
                    </div>
                    <div className="p-6">
                        <UpdateProfileInformationForm mustVerifyEmail={mustVerifyEmail} status={status} />
                    </div>
                </div>

                {/* Update Password */}
                <div className="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-sm">
                    <div className="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                        <h2 className="text-base font-semibold text-slate-900 dark:text-white">Kemaskini Kata Laluan</h2>
                        <p className="text-xs text-slate-500 mt-0.5">Pastikan akaun anda menggunakan kata laluan yang kukuh.</p>
                    </div>
                    <div className="p-6">
                        <UpdatePasswordForm />
                    </div>
                </div>

                {/* Delete Account */}
                <div className="rounded-2xl border-2 border-red-500/30 dark:border-red-500/20 bg-white dark:bg-slate-900 overflow-hidden shadow-sm transition-all duration-300">
                    <div className="px-6 py-4 border-b border-red-500/20 bg-red-50/10 dark:bg-red-500/5">
                        <h2 className="text-base font-semibold text-red-600 dark:text-red-400">Zon Bahaya</h2>
                        <p className="text-xs text-red-500/60 dark:text-red-400/60 mt-0.5 font-medium">Tindakan ini tidak boleh diundur setelah dilakukan.</p>
                    </div>
                    <div className="p-6">
                        <DeleteUserForm />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
