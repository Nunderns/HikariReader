import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

// Initialize Pusher with your credentials
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
    },
});

// Listen for new notifications
Echo.private(`App.Models.User.${window.Laravel.user.id}`)
    .notification((notification) => {
        // Dispatch a custom event that the notification dropdown can listen to
        const event = new CustomEvent('new-notification', { detail: notification });
        window.dispatchEvent(event);
        
        // Update the notification count in the navbar
        updateNotificationCount(1);
        
        // Play a sound for new notifications
        playNotificationSound();
    });

// Function to update the notification count in the navbar
function updateNotificationCount(change = 0) {
    const countElement = document.querySelector('.notification-count');
    if (countElement) {
        const currentCount = parseInt(countElement.textContent) || 0;
        const newCount = Math.max(0, currentCount + change);
        countElement.textContent = newCount;
        countElement.style.display = newCount > 0 ? 'block' : 'none';
    }
}

// Function to play a notification sound
function playNotificationSound() {
    // Try to use the Web Audio API sound first
    if (window.NotificationSound && typeof window.NotificationSound.play === 'function') {
        window.NotificationSound.play();
    } else {
        // Fallback to HTML5 Audio if Web Audio API is not available
        try {
            const audio = new Audio('/sounds/notification.mp3');
            audio.play().catch(e => console.log('Audio play failed:', e));
        } catch (e) {
            console.log('Error playing notification sound:', e);
        }
    }
}

// Mark a notification as read
window.markNotificationAsRead = function(notificationId) {
    fetch(`/notifications/${notificationId}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ _method: 'PATCH' })
    }).then(response => {
        if (response.ok) {
            // Update the UI to mark the notification as read
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.classList.remove('bg-blue-50');
                const unreadBadge = notificationElement.querySelector('.unread-badge');
                if (unreadBadge) {
                    unreadBadge.remove();
                }
                updateNotificationCount(-1);
            }
        }
    });
};

// Mark all notifications as read
window.markAllNotificationsAsRead = function() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ _method: 'PATCH' })
    }).then(response => {
        if (response.ok) {
            // Update the UI to mark all notifications as read
            document.querySelectorAll('.unread-badge').forEach(badge => badge.remove());
            document.querySelectorAll('.bg-blue-50').forEach(el => el.classList.remove('bg-blue-50'));
            const countElement = document.querySelector('.notification-count');
            if (countElement) {
                countElement.style.display = 'none';
                countElement.textContent = '0';
            }
        }
    });
};

// Initialize notification dropdown behavior
document.addEventListener('DOMContentLoaded', function() {
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const notificationToggle = document.querySelector('.notification-toggle');
    
    if (notificationToggle && notificationDropdown) {
        // Toggle dropdown
        notificationToggle.addEventListener('click', function(e) {
            e.preventDefault();
            notificationDropdown.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationToggle.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });
        
        // Handle new notifications
        window.addEventListener('new-notification', function(e) {
            const notification = e.detail;
            const notificationsList = document.querySelector('.notifications-list');
            
            if (notificationsList) {
                // Create new notification element
                const notificationElement = document.createElement('a');
                notificationElement.href = notification.data.url || '#';
                notificationElement.className = 'block px-4 py-3 hover:bg-gray-50 border-b border-gray-100 bg-blue-50';
                notificationElement.setAttribute('data-notification-id', notification.id);
                notificationElement.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="p-2 rounded-full ${getNotificationIcon(notification).bg} ${getNotificationIcon(notification).text}">
                                <i class="${getNotificationIcon(notification).icon}"></i>
                            </div>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <div class="flex justify-between">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    ${notification.data.title || 'Nova notificação'}
                                </p>
                                <span class="text-xs text-gray-400 ml-2 whitespace-nowrap">
                                    Agora mesmo
                                </span>
                            </div>
                            <p class="text-sm text-gray-500">
                                ${notification.data.message || 'Novo evento no sistema'}
                            </p>
                            ${notification.data.data && notification.data.data.title ? 
                                `<div class="mt-1 text-xs text-gray-600 bg-gray-50 p-2 rounded">
                                    ${notification.data.data.title}
                                </div>` : ''
                            }
                        </div>
                        <div class="ml-2">
                            <span class="h-2 w-2 rounded-full bg-blue-500 block unread-badge"></span>
                        </div>
                    </div>
                `;
                
                // Add to the top of the list
                if (notificationsList.firstChild) {
                    notificationsList.insertBefore(notificationElement, notificationsList.firstChild);
                } else {
                    notificationsList.appendChild(notificationElement);
                }
                
                // Show notification count
                updateNotificationCount(1);
            }
        });
    }
});

// Helper function to get notification icon based on type
function getNotificationIcon(notification) {
    const type = notification.type.toLowerCase();
    
    if (type.includes('manganotification')) {
        if (notification.data.type && notification.data.type.includes('created')) {
            return {
                icon: 'fas fa-plus-circle',
                bg: 'bg-green-100',
                text: 'text-green-600'
            };
        } else {
            return {
                icon: 'fas fa-edit',
                bg: 'bg-blue-100',
                text: 'text-blue-600'
            };
        }
    }
    
    // Default icon
    return {
        icon: 'fas fa-bell',
        bg: 'bg-gray-100',
        text: 'text-gray-600'
    };
}
