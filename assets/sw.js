// *** Service Worker *** //
/*
    This is the service worker file. It will be populated with the rules you define in the
    configuration file.
    You can define here custom rules depending on your application needs.
 */

registerPushTask(structuredPushNotificationSupport);
//registerPushTask(simplePushNotificationSupport);

registerNotificationAction('*', async (event) => {
  const data = JSON.parse(event.notification.data);
  const action = event.action || 'default';
  await clients.openWindow(data[action]);
});
