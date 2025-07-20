registerPushTask(structuredPushNotificationSupport);
//registerPushTask(simplePushNotificationSupport);

registerNotificationAction('*', async (event) => {
  const data = JSON.parse(event.notification.data);
  const action = event.action || 'default';
  await clients.openWindow(data[action]);
});
