importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

var config = {
    apiKey: "AIzaSyDvCMr74-j8znI5_FIoyRpDmgQmeuL1vgA",
    authDomain: "rpc-builders.firebaseapp.com",
    projectId: "rpc-builders",
    storageBucket: "rpc-builders.firebasestorage.app",
    messagingSenderId: "967501161709",
    appId: "1:967501161709:web:ff1bfdfa596c31f499d8e4"
  };
  firebase.initializeApp(config);
  
  // Retrieve Firebase Messaging object.
const messaging = firebase.messaging();


messaging.setBackgroundMessageHandler(function(payload) {
    
 var  title =payload.data.title;
  
 var options ={
        body: payload.data.body,
        icon: payload.data.icon,
        image: payload.data.image,
     data:{
            time: new Date(Date.now()).toString(),
            click_action: payload.data.click_action
        }
      
  };
 return self.registration.showNotification(title, options);

  
});


self.addEventListener('notificationclick', function(event) {

   var action_click=event.notification.data.click_action;
  event.notification.close();

  event.waitUntil(
    clients.openWindow(action_click)
  );
});
