<script>
(function() {
    console.log('🔔 Push Subscribe: Script loaded');
    
    if ('serviceWorker' in navigator && 'PushManager' in window) {
        console.log('✅ Push Subscribe: Browser supports Push API');
        navigator.serviceWorker.register('<?= BASE_URL ?>/sw.js')
            .then(registration => {
                console.log('✅ Push Subscribe: Service Worker registered', registration);
                
                if (Notification.permission === 'default') {
                    console.log('⏳ Push Subscribe: Requesting permission...');
                    Notification.requestPermission().then(permission => {
                        console.log('📋 Push Subscribe: Permission result:', permission);
                        if (permission === 'granted') {
                            subscribeUser(registration);
                        } else {
                            console.error('❌ Push Subscribe: Permission denied');
                        }
                    });
                } else if (Notification.permission === 'granted') {
                    console.log('✅ Push Subscribe: Permission already granted');
                    subscribeUser(registration);
                } else {
                    console.error('❌ Push Subscribe: Permission:', Notification.permission);
                }
            })
            .catch(err => console.error('❌ Push Subscribe: SW registration failed:', err));
    } else {
        console.error('❌ Push Subscribe: Browser does not support Push API');
    }

    function subscribeUser(registration) {
        console.log('⏳ Push Subscribe: Creating subscription...');
        const publicKey = 'BEl62iUYgUivxIkv69yViEuiBIa-Ib9-SkvMeAtA3LFgDzkrxZJjSgSnfckjBJuBkr3qBUYIHBQFLXYp5Nksh8U';
        
        registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array(publicKey)
        })
        .then(subscription => {
            console.log('✅ Push Subscribe: Subscription created', subscription);
            console.log('⏳ Push Subscribe: Saving to backend...');
            
            fetch('<?= BASE_URL ?>/api/push/subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(subscription)
            })
            .then(res => {
                console.log('📡 Push Subscribe: Backend response status:', res.status);
                return res.json();
            })
            .then(data => {
                console.log('✅ Push Subscribe: Backend response:', data);
                if (data.success) {
                    console.log('🎉 Push Subscribe: Successfully saved to database!');
                } else {
                    console.error('❌ Push Subscribe: Failed to save:', data);
                }
            })
            .catch(err => console.error('❌ Push Subscribe: Failed to save subscription:', err));
        })
        .catch(err => console.error('❌ Push Subscribe: Failed to subscribe to push:', err));
    }
    
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
})();
</script>
