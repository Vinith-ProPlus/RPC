// Initialize Firebase
$(document).ready(function(){
    const rootUrl=$('#txtRootUrl').val();
    var firebaseConfig=null;
    var fcmToken="";
    var UserID="";
    var messaging=null;
    // Register the service worker to handle background notifications
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/firebase-messaging-sw.js')
        .then((registration) => {
            console.log('Service Worker registered with scope:', registration.scope);
            messaging.useServiceWorker(registration);
        })
        .catch((error) => {
            console.error('Service Worker registration failed:', error);
        });
    }
    const firebaseInit=async()=>{
        let tmp=await getFirebaseConfig();
        firebaseConfig=tmp.firebaseConfig;
        UserID=tmp.UserID;
        fcmToken=tmp.fcmToken;
        if(UserID!=""){
            firebase.initializeApp(firebaseConfig);
            // Retrieve Firebase Messaging object.
            messaging = firebase.messaging();
            messaging.requestPermission().then(function () {
                if (fcmToken=="") {
                    getRegisterToken();
                }
            }).catch(function (err) {
                console.log('Unable to get permission to notify.', err);
            });
            messaging.onMessage(function (payload) {
                //console.log('Message received. ', payload);
                var title = payload.data.title;
            
                var options = {
                    body: payload.data.body,
                    icon: payload.data.icon,
                    image: payload.data.image,
                    data: {
                        time: new Date(Date.now()).toString(),
                        click_action: payload.data.click_action
                    }
                };
                var myNotification = new Notification(title, options);
            });
        }
    }
    const getFirebaseConfig=async()=>{
        return await new Promise((resolve,reject)=>{
            $.ajax({
                type:"post",
                url:rootUrl+"firebase/get/firebase-config",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:()=>{resolve(null)},
                success:async(response)=>{
                    resolve(response);
                }
            });
        });
    }
    const sendTokenToServer=async(fcmToken)=>{ console.log(fcmToken)
        if(UserID!=""){
            $.ajax({
                type:"post",
                url:rootUrl+"firebase/fcm-token/save",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                data:{fcmToken,UserID},
                dataType:"json",
                async:true,
            });
        }
    }
    const getRegisterToken=async()=>{
        if(messaging!=null){

            messaging.getToken().then(function (currentToken) {
                if (currentToken) {
                    fcmToken=currentToken;
                    sendTokenToServer(currentToken);
                    // updateUIForPushEnabled(currentToken);
                } else {
                    // Show permission request.
                    console.log('No Instance ID token available. Request permission to generate one.');
                    // Show permission UI.
                    // updateUIForPushPermissionRequired();
                    sendTokenToServer("");
                }
            }).catch(function (err) {
                console.log('An error occurred while retrieving token. ', err);
                //showToken('Error retrieving Instance ID token. ', err);
                sendTokenToServer("");
            });
        }
    } 
    firebaseInit();
});