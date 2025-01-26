export async function publishImage(route, csrfToken) {
    try {
        await axios.post(route, {}, {
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        alert('Image Published');
    } catch (error) {
        console.error('Error publishing image:', error);
        alert('Failed to publish image');
    }
}

export async function unpublishImage(route, csrfToken) {
    try {
        await axios.post(route, {}, {
            headers: { 'X-CSRF-TOKEN': csrfToken }
        });
        alert('Image Unpublished');
    } catch (error) {
        console.error('Error unpublishing image:', error);
        alert('Failed to unpublish image');
    }
}
