// Notification sound using Web Audio API
class NotificationSound {
    constructor() {
        this.audioContext = null;
        this.initialized = false;
        this.init();
    }

    init() {
        try {
            // Create audio context
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            this.audioContext = new AudioContext();
            this.initialized = true;
        } catch (e) {
            console.error('Web Audio API is not supported in this browser', e);
            this.initialized = false;
        }
    }

    play() {
        if (!this.initialized) {
            console.warn('Audio not initialized');
            return false;
        }

        try {
            // Create oscillator and gain node
            const oscillator = this.audioContext.createOscillator();
            const gainNode = this.audioContext.createGain();
            
            // Configure oscillator
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(880, this.audioContext.currentTime); // A5 note
            oscillator.frequency.exponentialRampToValueAtTime(440, this.audioContext.currentTime + 0.1); // A4 note
            
            // Configure gain (volume)
            gainNode.gain.setValueAtTime(0.5, this.audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, this.audioContext.currentTime + 0.3);
            
            // Connect nodes
            oscillator.connect(gainNode);
            gainNode.connect(this.audioContext.destination);
            
            // Start and stop
            oscillator.start();
            oscillator.stop(this.audioContext.currentTime + 0.3);
            
            return true;
        } catch (e) {
            console.error('Error playing notification sound:', e);
            return false;
        }
    }
}

// Create a singleton instance
const notificationSound = new NotificationSound();

// Export for different module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = notificationSound;
} else {
    window.NotificationSound = notificationSound;
}
