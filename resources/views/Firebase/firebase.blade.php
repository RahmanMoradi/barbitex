@include('Firebase.permission')
<audio id="myAudio">
    <source src="{{asset('notification/beep.ogg')}}" type="audio/ogg">
    <source src="{{asset('notification/beep.mp3')}}" type="audio/mpeg">
</audio>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.2/firebase-messaging.js"></script>

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: `{{env('FIREBASE_APIKEY')}}`,
        authDomain: `{{env('FIREBASE_AUTH_DOMAIN')}}`,
        databaseURL: `{{env('FIREBASE_DATABASE_URL')}}`,
        projectId: `{{env('FIREBASE_PROJECT_ID')}}`,
        storageBucket: `{{env('FIREBASE_STORAGE_BUCKET')}}`,
        messagingSenderId: `{{env('FIREBASE_MESSAGING_SENDER_ID')}}`,
        appId: `{{env('FIREBASE_APP_ID')}}`,
    };
    let userToken = `{{Auth::guard('admin')->check() ? Auth::guard('admin')->user()->api_token : Auth::user()->api_token}}`
    {{--if (!userToken) {--}}
    {{--    userToken = `{{Auth::guard('admin')->user()->api_token}}`--}}
    {{--}--}}
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                url: `/fcm/save-device-token?api_token=${userToken}`,
                type: 'POST',
                data: {
                    fcm_token: token,
                },
                dataType: 'JSON',
                success: function (response) {
                    console.log(response)
                },
                error: function (err) {
                    console.log(" Can't do because: " + err);
                },
            });
        })
        .catch(function (err) {
            // dNone('')
            console.log("Unable to get permission to notify.", err);
            messaging.getToken()
            // messaging.refreshToken()
        });

    function playSound() {
        document.getElementById('myAudio').play();
    }

    messaging.onMessage(function (payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
            click_action: payload.notification.click_action
        };
        new Notification(noteTitle, noteOptions);
        playSound()
    });
</script>
