export default async function likeImage(route, context) {
    try {
        const response = await axios.post(route, {
            headers: { 'X-CSRF-TOKEN': context.csrfToken }
        });
        context.likes_count = response.data.likes;
        context.liked = response.data.liked;
    } catch (error) {
        window.location.href = '/login';
        // console.error('Error liking image:', error);
    }
}
