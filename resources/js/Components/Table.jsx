import { Link } from '@inertiajs/react';

const alignClass = {
    left: 'text-left',
    center: 'text-center',
    right: 'text-right',
};

function cx(...classes) {
    return classes.filter(Boolean).join(' ');
}

export function DataTable({ children, footer = null, minWidth = 'min-w-[900px]', className = '' }) {
    return (
        <div className={cx('rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 overflow-hidden shadow-sm', className)}>
            <div className="overflow-x-auto custom-scrollbar">
                <table className={cx('w-full text-sm text-left', minWidth)}>
                    {children}
                </table>
            </div>
            {footer}
        </div>
    );
}

export function TableHead({ children }) {
    return (
        <thead className="bg-slate-900 dark:bg-slate-800/70">
            {children}
        </thead>
    );
}

export function HeaderRow({ children }) {
    return <tr>{children}</tr>;
}

export function HeaderCell({ children, align = 'left', className = '' }) {
    return (
        <th className={cx('px-5 sm:px-8 py-5 font-black text-white dark:text-slate-200 uppercase tracking-widest text-[11px]', alignClass[align], className)}>
            {children}
        </th>
    );
}

export function TableBody({ children }) {
    return (
        <tbody className="divide-y divide-slate-200 dark:divide-slate-800">
            {children}
        </tbody>
    );
}

export function TableRow({ children, className = '' }) {
    return (
        <tr className={cx('odd:bg-white even:bg-slate-100 hover:bg-emerald-50/80 dark:odd:bg-slate-950 dark:even:bg-slate-800/80 dark:hover:bg-slate-700/70 transition-colors group', className)}>
            {children}
        </tr>
    );
}

export function TableCell({ children, align = 'left', className = '' }) {
    return (
        <td className={cx('px-5 sm:px-8 py-5', alignClass[align], className)}>
            {children}
        </td>
    );
}

export function EmptyTableRow({ colSpan, title, description, icon }) {
    return (
        <tr>
            <td colSpan={colSpan} className="px-8 py-20 text-center">
                <div className="flex flex-col items-center justify-center">
                    <div className="w-16 h-16 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-4 shadow-inner">
                        {icon}
                    </div>
                    <p className="text-slate-500 dark:text-slate-400 font-bold">{title}</p>
                    {description && (
                        <p className="text-slate-400 dark:text-slate-600 text-xs mt-1">{description}</p>
                    )}
                </div>
            </td>
        </tr>
    );
}

export function Pagination({ meta }) {
    if (!meta?.links || meta.data?.length === 0) {
        return null;
    }

    return (
        <div className="px-8 py-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span className="text-sm text-slate-500 font-medium order-2 sm:order-1 text-center sm:text-left">
                Memaparkan <span className="font-bold text-slate-900 dark:text-white">{meta.from}</span> - <span className="font-bold text-slate-900 dark:text-white">{meta.to}</span> daripada <span className="font-bold text-slate-900 dark:text-white">{meta.total}</span> rekod
            </span>
            <div className="flex flex-wrap justify-center gap-1.5 order-1 sm:order-2">
                {meta.links.map((link, i) => (
                    <Link
                        key={i}
                        href={link.url || '#'}
                        className={cx(
                            'px-4 py-2 text-xs font-bold rounded-xl border transition-all active:scale-90',
                            link.active
                                ? 'bg-[#228260] dark:bg-[#32BA83] border-[#228260] dark:border-[#32BA83] text-white dark:text-slate-950 shadow-lg shadow-emerald-600/20'
                                : 'border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:border-[#228260] hover:text-[#228260] dark:hover:border-[#32BA83] dark:hover:text-[#32BA83]',
                            !link.url ? 'opacity-30 pointer-events-none' : ''
                        )}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                    />
                ))}
            </div>
        </div>
    );
}
