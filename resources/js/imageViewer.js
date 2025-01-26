export default () => ({
    likes_count: null, // Initialize likes dynamically
    liked: null, // Initialize liked dynamically

    init(likes, liked) {
        this.likes_count = likes;
        this.liked = liked;
    },

    handleScroll(event) {
        const element = event.target;
        const scrollTop = element.scrollTop;
        const elementHeight = element.offsetHeight;
        const detailsSection = this.$refs.detailsSection;

        if (scrollTop > elementHeight / 2) {
            detailsSection.classList.remove('opacity-0');
            detailsSection.classList.add('opacity-100');
        } else {
            detailsSection.classList.remove('opacity-100');
            detailsSection.classList.add('opacity-0');
        }
    },
});
