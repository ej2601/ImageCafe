window.ImageGrid = window.ImageGrid || {};

ImageGrid.imageManager = function (){
    return {
        images: imageData || [],
        next_page_url: nextPageUrl || null,
        loading: false,
        selectedImages: [],
        sortOrder: sortOrder || 'latest',
        
        
        // Infinite Scroll
        init() {
            
            // console.log('hello');
            const grid = this.$refs.imageGrid;
            grid.addEventListener('scroll', () => {
                if ((grid.scrollTop + grid.clientHeight) >= (grid.scrollHeight - 300)) {
                    this.loadMoreImages();
                    this.loading = true;
                }
            });
        },
        
        loadMoreImages() {
                   
            if (this.next_page_url && !this.loading) {
                this.loading = true;
                axios.get(this.next_page_url, {
                    params: {
                        sortOrder: this.sortOrder,
                        search: document.querySelector('input[name="search"]').value
                    }
                })
                .then(response => {
                    this.images = [...this.images, ...response.data.images];
                    this.next_page_url = response.data.next_page_url;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error loading more images:', error);
                    this.loading = false;
                });
            }
        },

        deleteSelected() {
            if (confirm('Are you sure you want to delete these images?')) {
                axios.post(bulkDeleteRoute, {
                    selected_images: this.selectedImages
                }).then(response => {
                    window.location.reload();
                }).catch(error => {
                    console.error('Error deleting images:', error);
                });
            }
        },

        viewImage(imageId) {
            window.location.href = '/image/' + imageId;
        }
    }
}
