document.addEventListener('alpine:init', () => {
    Alpine.data('imageGenerator', () => ({
        isGenerating: false,
        seconds: 0,
        interval: null,
        generatedImageUrl: '',
        showTimer: false,
        imageId: null,

        async generateImage() {
            const prompt = this.$refs.prompt.value;

            if (prompt.trim() === '') {
                alert("Please enter a prompt before generating the image.");
                return;
            }

            this.generatedImageUrl = '';
            this.isGenerating = true;
            this.showTimer = true;
            this.seconds = 0;
            this.startTimer();



            try {
                const formData = new FormData(this.$refs.imageForm);
                console.log(formData)
                const response = await axios.post(imageGenerateRoute, formData, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    }
                });
                console.log(response)
                if (response.status === 200) {
                    this.generatedImageUrl = response.data.image_path;
                    this.imageId = response.data.image_id;
                } else {
                    alert('Failed to generate image.');
                }
            } catch (error) {
                console.error('Error generating image:', error);
                alert('Something went wrong.');
            } finally {
                this.stopTimer();
                // this.isGenerating = false;
            }
        },

        startTimer() {
            this.interval = setInterval(() => {
                this.seconds++;
            }, 1000);
        },

        stopTimer() {
            clearInterval(this.interval);
            this.showTimer = false;
        },

        async  deleteImage(url) {
            if (confirm('Are you sure you want to delete this image?')) {
                
                await axios.delete(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest', // Ensures Laravel treats it as AJAX
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF protection
                    }
                })
                .then(response => {
                    // alert(response.data.status || 'Image deleted successfully!');
                    this.generatedImageUrl = '';
                    this.isGenerating = false;
                    // Optionally, remove the deleted image from the DOM or refresh the list
                    // window.location.reload(); // Refresh to reflect changes
                })
                .catch(error => {
                    console.error('Error deleting image:', error);
                    alert('Failed to delete the image. Please try again.');
                });
            }
        }
        
    }));
});