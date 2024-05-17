importScripts("https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js")
importScripts("https://www.gstatic.com/firebasejs/8.6.2/firebase-messaging.js")

var firebaseConfig = {
    apiKey: "AIzaSyBbVNaJIVDu-yQILxSj-Au0TPX82JfOPhk",
    authDomain: "tajcoin-ce54e.firebaseapp.com",
    projectId: "tajcoin-ce54e",
    storageBucket: "tajcoin-ce54e.appspot.com",
    messagingSenderId: "341780590977",
    appId: "1:341780590977:web:dbcfd8f8af526bc13af880",
    measurementId: "G-8H5ZSTR8X3"
};
firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
    // Customize notification here
    const notificationTitle = 'Background Message Title';
    const notificationOptions = {
        body: 'Background Message body.',
        icon: '/firebase-logo.png'
    };

    return self.registration.showNotification(notificationTitle,
        notificationOptions);
});
