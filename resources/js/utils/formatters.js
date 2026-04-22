export function formatStudentId(value) {
    return String(value ?? '').replace(/\s+/g, '').toUpperCase();
}
