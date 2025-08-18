registerPushTask(structuredPushNotificationSupport);
//registerPushTask(simplePushNotificationSupport);

registerNotificationAction('*', async (event) => {
  const data = JSON.parse(event.notification.data);
  const action = event.action || 'default';
  await clients.openWindow(data[action]);
});

registerPeriodicSyncTask('ping', async () => {
  const cache = await openCache('ping-cache');
  const res = await fetch('/ping');
  await cache.put('/ping', res.clone());

  notifyPeriodicSyncClients('ping', { updated: true });
});
