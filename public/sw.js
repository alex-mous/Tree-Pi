const CACHE_N = "treepi-cache-1";
const cacheableUrls = ["/", "/style.css", "/index.js", "/favicon.ico"];

self.addEventListener("install", (ev) => {
	console.log("Installing TreePi SW...");
	ev.waitUntil(caches.open(CACHE_N).then((cache) => {
		console.log("Cached opened");
		return cache.addAll(cacheableUrls);
	}));
});

self.addEventListener("fetch", (ev) => {
	ev.respondWith(caches.match(ev.request).then((resp) => {
		if (resp) { //Response cached - return it
			return resp;
		}
		return fetch(ev.request).then((resp) => { //Return the resposne and store it in the cache if possible
			if (resp && resp.status == 200 && resp.type == "basic" && ev.request.method == "GET") { //Cacheable if recieved correctly and not POST (to API)
				let clonedResp = resp.clone();
				caches.open(CACHE_N).then((cache) => cache.put(ev.request, clonedResp)); //Store the response in the cache
				console.log("Add cached URL: ", ev.request.url);
			}
			return resp;
		});
	}));
});
