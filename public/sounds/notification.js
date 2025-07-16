// This script generates a simple notification sound using the Web Audio API
function playNotificationSound() {
    try {
        // Create audio context
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        const audioContext = new AudioContext();
        
        // Create oscillator
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        // Configure oscillator
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(880, audioContext.currentTime); // A5 note
        oscillator.frequency.exponentialRampToValueAtTime(440, audioContext.currentTime + 0.1); // A4 note
        
        // Configure gain (volume)
        gainNode.gain.setValueAtTime(0.5, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
        
        // Connect nodes
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        // Start and stop
        oscillator.start();
        oscillator.stop(audioContext.currentTime + 0.5);
        
        return true;
    } catch (e) {
        console.error('Error playing notification sound:', e);
        return false;
    }
}

// Export for ES modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { playNotificationSound };
}
