export function formatToLocaleDate(date) {
    if (!date) return "";
    return new Date(date).toLocaleDateString("de-DE");
}

export function formatDateForApi(dateString) {
    const date = new Date(dateString);
    return date.toISOString();
}

export function isBeforeToday(date, currentDate) {
    if (!date) return false;
    return new Date(date) < new Date(currentDate);
}

export function isToday(date, currentDate) {
    if (!date) return false;
    const today = new Date(currentDate);
    const inputDate = new Date(date);
    return (
        inputDate.getFullYear() === today.getFullYear() &&
        inputDate.getMonth() === today.getMonth() &&
        inputDate.getDate() === today.getDate()
    );
}
