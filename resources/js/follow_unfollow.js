export default async function followUser(userId, selectedImage) {
    try {
        const route = selectedImage.user.is_followed
            ? `/unfollow/${userId}`
            : `/follow/${userId}`;

        const response = await axios.post(route, null, {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
        });

        // Update follow status
        selectedImage.user.is_followed = !selectedImage.user.is_followed;
    } catch (error) {
        window.location.href = '/login';
        // console.error('Error following/unfollowing user:', error);
    }
}
