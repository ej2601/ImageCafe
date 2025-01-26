import './bootstrap';

import Alpine from 'alpinejs';

import './image_generation.js';
import './image_grid_manager.js';

// Alpine Components
import imageViewer from './imageViewer.js';


// Utility Functions
import copyToClipboard from './copyToClipboard.js';
import followUser from './follow_unfollow.js';
import likeImage from './like.js';
import { publishImage, unpublishImage } from './publish.js';


window.Alpine = Alpine;


Alpine.data('imageViewer', imageViewer);


// axios.get('/api/user-id')
// .then(response => {
//     Alpine.store('global', {
//         currentUserId: response.data.id,
//     });
    
// })
// .catch(error => {
//     console.error('Error fetching user ID:', error);
// });

Alpine.start();

// Attach utilities to window for global access if needed
window.copyToClipboard = copyToClipboard;
window.likeImage = likeImage;
window.publishImage = publishImage;
window.unpublishImage = unpublishImage;

window.followUser = followUser;



