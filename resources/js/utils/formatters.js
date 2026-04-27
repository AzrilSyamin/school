export function formatStudentId(value) {
    return String(value ?? '').replace(/\s+/g, '').toUpperCase();
}

export function formatNric(value) {
    return String(value ?? '').replace(/[^0-9-]/g, '');
}

export function hasInvalidNricCharacters(value) {
    return /[^0-9-]/.test(String(value ?? ''));
}
