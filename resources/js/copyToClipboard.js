export default async function copyToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
        alert('Copied to clipboard');
    } catch (error) {
        console.error('Failed to copy text:', error);
        alert('Failed to copy');
    }
}
