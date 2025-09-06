const CACHE_NAME = 'laravel-pwa-cache-v2';

// Function to generate a dynamic offline response
const getOfflineResponse = () => {
    const offlineHtml = `
        <!DOCTYPE html>
        <html lang="vi">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ngoại tuyến</title>
            <style>
                body { 
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
                    text-align: center; 
                    padding: 50px; 
                    background-color: #f5f5f5; 
                    color: #333; 
                }
                h1 { 
                    font-size: 24px; 
                    color: #555;
                }
                p {
                    font-size: 16px;
                }
            </style>
        </head>
        <body>
            <h1>Bạn đang ngoại tuyến</h1>
            <p>Nội dung này không có sẵn khi ngoại tuyến. Vui lòng kiểm tra kết nối mạng của bạn.</p>
        </body>
        </html>
    `;
    return new Response(offlineHtml, {
        headers: { 'Content-Type': 'text/html' }
    });
};

// Install: Pre-cache essential, non-versioned assets.
self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('Opened cache for PWA');
      // Cache the root and manifest.
      return cache.addAll([
        '/',
        '/manifest.json'
      ]);
    })
  );
  self.skipWaiting();
});

// Activate: Clean up old caches.
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            console.log('Deleting old cache:', cacheName);
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
  self.clients.claim();
});

// Fetch: Apply caching strategies.
self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') {
    return;
  }

  // Strategy for navigation requests (HTML pages)
  if (event.request.mode === 'navigate') {
    event.respondWith(
      (async () => {
        try {
          // Try the network first
          const networkResponse = await fetch(event.request);
          return networkResponse;
        } catch (error) {
          // If network fails, try the cache
          console.log('Fetch failed; trying cache.', error);
          const cache = await caches.open(CACHE_NAME);
          const cachedResponse = await cache.match(event.request);
          // If it's in the cache, serve it. Otherwise, serve the generated offline response.
          return cachedResponse || getOfflineResponse();
        }
      })()
    );
    return;
  } 
  
  // Strategy: Stale-While-Revalidate for other assets (CSS, JS, images)
  event.respondWith(
    caches.open(CACHE_NAME).then(async (cache) => {
      const cachedResponse = await cache.match(event.request);
      const fetchPromise = fetch(event.request).then((networkResponse) => {
        cache.put(event.request, networkResponse.clone());
        return networkResponse;
      });

      // Return cached version if available, otherwise wait for the network.
      return cachedResponse || fetchPromise;
    })
  );
});
